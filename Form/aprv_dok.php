<script>
	function open_childX(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};	
</script>

<?php
$sect= $_SESSION["area"]; 
$pic=$_SESSION["nama"];
$akses=$_SESSION["akses"];
$user=$_SESSION["user"];
$pch_sec=explode("-",$sect);
$whr="and sect='-'";
$perinow=date("Ym");
$lok=$_SESSION['lokasi'];
// $adm=strpos($akses,'ADM_FA');
$admin_FA=strpos($akses,'_FA');
$kd_akses=explode(",",$akses);
if(in_array('ADM_FA',$kd_akses)){
	$adm1="admin";
}else{
	$adm1="user";
}
?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>APPROVE <?php echo strtoupper($sect); ?></h2>
		</div>
		<div class="row clearfix">
			<div class="card">				
				<div class="header">
					<h2>Record Document Approve<small>Lihat data ApproveA <?php // echo $_GET['prv'] ; ?></small></h2>
				</div>
				<form role="form"  name="frm" id="frm" method="post" action="" enctype="multipart/form-data">

					<?php if($_GET['prv']=='verified' and $adm1== 'admin' ){?>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Range Tanggal</label>
								<div class="form-line">
									<input type="text"  class="form-control" id="rg_tgl" name="rg_tgl" placeholder="Detail Pencarian" required>
								</div>		
							</div>
						</div>

						<div class="col-sm-4">
							<div class="form-group">
								<label>Section</label>
								<div class="form-line">
									<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="sectu" id="sectu" >
										<option selected="selected" value="">--Pilih Section--</option>
										<?php
										$cr_sect="select DISTINCT sect from bps_approve where sect not like '%ALL%' and no_aprv<=3 order by sect asc";
										$tb_sect=odbc_exec($koneksi_lp,$cr_sect);
										while(odbc_fetch_array($tb_sect)){ 
											$plh_sect=odbc_result($tb_sect,"sect");
											echo '<option value="'.$plh_sect.'">'.$plh_sect.'</option>';
										}?>	
									</select>
								</div>		
							</div>
						</div>
					<?php }?>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Status</label>
							<div class="input-group">
								<div class="form-line">
									<select class="selectpicker" style="width: 100%;"  name="cr_status" id="cr_status">
										<option value="">--Pilih Status--</option>
										<option value='CHECKED'>SUDAH CHECK</option>
										<option value='BLMCHECKED'>BELUM CHECK</option>
									</select>
								</div>
								<span class="input-group-addon">
									<button type="submit" name="cr_dt" id="cr_dt" class="btn bg-purple waves-effect"><i class="material-icons">search</i> </button>
								</span>
							</div>
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-sm-12">
							<div class="body">
								<div class="table-responsive">
									<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
										<thead>
											<tr>
												<th>No</th>
												<th>Jenis Doc.</th>
												<th>No Doc.</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
									</form>
									<tbody>
										<?php
										if(isset($_POST['cr_dt'])){
											$status=$_POST['cr_status'];
											
											if($_GET['prv']=='verified' and $adm1== 'admin' ){
												$sectu=$_POST['sectu'] ;
												if($sectu==''){
													$crsect="";
												}else{
													$crsect=" and no_doc like '%$sectu%'";
												}

												$rg_tg=$_POST['rg_tgl'];
												$rg_tgl=explode("-",$rg_tg);
												$rg_tgl0=date("Y-m-d",strtotime($rg_tgl[0]));
												$rg_tgl1=date("Y-m-d",strtotime($rg_tgl[1]));
												$whrtgl=" and tgl_prepaire BETWEEN '".$rg_tgl0." 00:00:00.000' AND '".$rg_tgl1." 23:59:59.999'";
												$crapp="";
											}else{
												$sectu=$sect;
												$crsect=" and no_doc like '%$sectu%'";
												$whrtgl=" and  tgl_prepaire>=dateadd(day,-5,getdate())";
												$crapp=" and pic_plan='".$_SESSION['nama']."'";
											}

											if($status=='CHECKED' ){
												if($_GET['prv']=='verified' and $adm1== 'admin'){
													$whrfil=" and status='FINISH' and sect='$sectu' ";
												}else{
													$whrfil=" and status='Close' and sect='$sect' ";
												}
											}else if ($status='BLMCHECKED'){
												if( $adm1!== 'admin' and $_GET['prv']=='verified'){
													$whrfil=" and status='Close' and sect='$sectu' ";
													//$whrtgl=" and tgl_prepaire BETWEEN '".$rg_tgl0." 00:00:00.000' AND '".$rg_tgl1." 23:59:59.999'";
													$whrtgl="";
												}else{
													$whrfil=" and status is null ";
													$whrtgl="";
												}
											}else{
												$whrfil=" and status is null and no_aprv <=3 ";
											}

											if(isset($_GET['prv'])){
												switch ($_GET['prv']){
													case 'section':
													$whr=" sect='$sect'";
													$whrtgl ="";
													$sq_acc="SELECT * from bps_approve where jns_doc in ('ADD','PR','kontrak') and $whr $whrfil $whrtgl order by no_doc asc";
													break;

													case 'mgr':

													$whr="status is null and pic_plan='$pic' and no_doc in (select no_doc from bps_approve where status='close' and no_aprv<(select min(no_aprv) from bps_approve where pic_plan='$pic')) and no_aprv<7";
													$whrtgl ="";
													$sq_acc="SELECT * from bps_approve where jns_doc in ('ADD','PR','kontrak') and $whr $whrfil $whrtgl   order by no_doc asc";
													break;

													case 'verified':

													if( $adm1!== 'admin' ){
														$section="$sectu";
													}else{
														$section="$sect";
													}
													$whr=" and no_doc in (select no_doc from bps_approve where sect='$sectu'
													and (status='close' or status='FINISH'))";

													$sq_acc="SELECT DISTINCT jns_doc,status,no_doc,max(no_aprv) as no_aprv,
													max(tgl_prepaire) as tgl_prepaire
													from bps_approve where jns_doc in ('ADD','PR','kontrak') $whrtgl $crsect $whrfil $whr
													group by jns_doc,status,no_doc
													order by jns_doc,no_doc asc";
													break;

													default :
													$whr="status is null and sect='SAMI-ALL' and pic_plan='$pic'";
													$sq_acc="SELECT * from bps_approve where jns_doc in ('ADD','PR','kontrak') and $whr $whrfil $whrtgl order by no_doc asc";
													break;
												}
											}

											$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
											echo $sq_acc;
											$row=0;
											while($baris1=odbc_fetch_array($tb_acc)){ 
												$row++;
												$jns_doc=odbc_result($tb_acc,"jns_doc");
												$stts=odbc_result($tb_acc,"status");
												$no_doc=odbc_result($tb_acc,"no_doc");
												$no_aprv=odbc_result($tb_acc,"no_aprv");
												?>	
												<tr  onclick="javascript:pilih(this);" >
													<td><?php echo $row; ?></td>
													<td><?php echo $jns_doc; ?></td>
													<td><?php echo $no_doc; ?></td>
													<td><?php echo $stts; ?></td>
													<td>
														
														<?php
														switch ($jns_doc) {
															case 'PR':
																$phpaprv="form/pr/aprv_PR.php";
																break;
																case 'ADD':
																$phpaprv="form/pr/aprv_ADD.php";
																break;
															
															default:
																$phpaprv="select/aprv_".$jns_doc.".php";
																break;
														}
														/*if($jns_doc=="PR"){
															$phpaprv="form/pr/aprv_PR.php";
														}else{
															$phpaprv="select/aprv_".$jns_doc.".php";
														}*/
														?>
														<button type="button" class="btn bg-green waves-effect" onclick="open_child('<?php echo $phpaprv;?>?nomor=<?php echo $row;?>&nodoc=<?php echo $no_doc;?>&lok=<?php echo $lok ;?>&jnsdok=<?php echo $jns_doc;?>&stts=<?php echo $status;?>&prv=<?= $_GET['prv'];?>','Lihat Detail <?php echo $no_doc;?>','800','500'); return false;"><i class="material-icons">visibility</i>
														</button>
														<?php 
//}
														?>
													</td>
												</tr>
												<?php 
											}
										}
										?>	
									</tbody>
									<tfoot>
										<tr>	
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>	
				</div>
			</div>	
		</div>
	</div>           
</div>
</section>

<script>
	$(function() {
		$('input[name="rg_tgl"]').daterangepicker({
			opens: 'left'
		}, function(start, end, label) {
			console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		});
	});

	$(document).ready(function()
	{

		$('.periodemn').bootstrapMaterialDatePicker({
			format: 'YYYYMM', minDate : new Date(),
			clearButton: true,
			weekStart: 0,
			time: false
		});	
		$('.periodeflex').bootstrapMaterialDatePicker({
			format: 'YYYYMM',
			clearButton: true,
			weekStart: 0,
			time: false
		});	
	});
</script>

