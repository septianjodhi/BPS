<style>
	.my-custom-scrollbar {
		position: relative;
		height: 400px;
		overflow: auto;
	}
	.table-wrapper-scroll-y {
		display: block;
	}
</style>

<style type="text/css">
	body {
		height: 1000px;
	}
	thead {
		background-color: white;
	}
</style>

<script type="text/javascript">
	function open_child(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
		
	};
</script>
<?php
$pic=$_SESSION['nama'];
$area=$_SESSION['area'];
$akses_user=$_SESSION['akses'];
$cek_adm=strpos($akses_user,"ADM_FA");
$cek_lp=strpos($akses_user,"LP");
$pc_area=explode("-", $area);
$sect=$pc_area[1];

$cek_apr=strpos($akses,'APP_PR');
$kd_akses=explode(",",$akses);
if($cek_apr>0){
	$apprv="admin";
}else{
	$apprv="user";
}

if(isset($_POST['smpn']) ){

	$bln=date("Ym");

	foreach ($_POST['plh'] as $_boxValue2)
	{
		$np2=explode("|",$_boxValue2);	

		$update_part=odbc_exec($koneksi_lp,"UPDATE bps_part SET status_part='1',tgl_ubah=GETDATE() 
			where part_no='$np2[0]' and lp='$sect' ");
	}

	echo "<script>alert('DATA BERHASIL DIPERBARUI');</script>";
}

?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>APPROVE MASTER PART</h2>
		</div>

		<div class="row clearfix">
			<div class="card">
				<div class="row clearfix">				
					<div class="header">
						<h2>Record<small>Cari Part No <?= $sect; ?></small></h2>
					</div>
					<div class="body">
						<form action="" id="frmcari" method="post"  enctype="multipart/form-data">

							<div class="col-sm-3">	
								<div class="form-group">
									<!--label>Kolom</label-->
									<select class="selectpicker" style="width: 100%;"  name="status" id="status" >
										<option selected="selected" value="">---Pilih Status---</option>
										<option value="1">Sudah Approve</option>
										<option value="0">Belum Approve</option>
									</select>
								</div>
							</div>

							<div class="col-sm-3">	
								<div class="form-group">
									<!--label>Kolom</label-->
									<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
										<option selected="selected" value="">---Pilih Kolom---</option>
										<option value="part_no">Part</option>
										<option value="part_nm">Nama Part</option>
										<option value="part_dtl">Detail Part</option>
										<option value="uom">Uom</option>
										<option value="curr">Currency</option>
										<option value="lp">Purchasing</option>
										<option value="part_kat">Kategori</option>
									</select>
								</div>
							</div>

							<div class="col-sm-4">	
								<div class="form-group">
									<div class="form-line">
										<input type="text"  class="form-control" data-role="tagsinput" id="txt_cari" name="txt_cari" placeholder="Detail Pencarian">
									</div> 
								</div>
							</div>

							<div class="col-sm-2">
								<button type="submit" name="cr_b" id="cr_b" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">search</i> </button>
								<button type="reset" name="reset" id="reset" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">clear</i> </button>
							</div>
						</form>
					</div>	
				</div>	   
				<div class="row clearfix">
					<form action="" id="form" name="form" method="post" enctype="multipart/form-data">
						<div class="body">
							<!-- <div class="table-responsive"> -->
								<div class="table-wrapper-scroll-y my-custom-scrollbar">
									<table id="dtVerticalScroll_vvvv" class="table table-striped table-bordered " cellspacing="0" width="100%">	
										<!-- <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2"> -->
											<thead>
												<tr>	
													<th>No</th>
													<th>
														<div class="switch" >
															<label>
																<input type="checkbox" onchange="checkAll(this)" name="chk[]" >
																<span class="lever"></span>
															</label>
														</div>
													</th>							
													<th>Status Part</th>
													<th>Purchasing</th>
													<th>Kategori</th>
													<th>Nama Part</th>
													<th>Part No</th>
													<th>Detail Part</th>
													<th>Uom</th>
													<th>Kode Proses</th>
													<th>Currency</th>
													<th>Kategori Tax</th>	
													<th>Pic Update</th>
													<?php 
													$day=date('Y');
													for ($i=1; $i <=12 ; $i++) {
														if($i<=6){
															$month=$i+6;
														}else{
															$month=$i-6;
														}
														$m=substr("0".$month,-2);
														$tgl=$day."-".$m."-01";
														echo "<th>".date("M",strtotime($tgl))."</th>";
													}
													?>
												</tr>
											</thead>

											<tbody>
												<?php
												if(isset($_POST['cr_b']) ){	
													$status=$_POST['status'];
													if($status==""){
														$status_part="   (status_part in ('0','1') or status_part is null)";
													}else if($status==0 || $status==""){
														$status_part="  (status_part is null or status_part='0') ";
													}else {
														$status_part="  status_part='$status' ";
													}
													$cmd_cari=$_POST['cmd_cari'];
													$txt_cari=str_replace(" ","",$_POST['txt_cari']);
													if($txt_cari==""){
														$whr=""; 
													}else{
														$whr="and replace($cmd_cari,' ','') like '%$txt_cari%'";
													}
													$sq_crpart="select * from bps_part where  $status_part $whr";
													// $sq_crpart="select * from bps_part where lp='$sect' $status_part $whr";
												// echo $sq_crpart;
													$tb_acc=odbc_exec($koneksi_lp,$sq_crpart);
													$row=0;
													while($baris1=odbc_fetch_array($tb_acc)){
														$row++;
														$lp=$baris1["lp"];
														?>	
														<tr onclick="javascript:pilih(this);">
															<td><?= $row; ?></td>
															<td>
																<div class="switch" ><label><input type="checkbox" name="plh[]" id="plh" value="<?php echo $baris1["part_no"]; ?>" onclick="dipilih(this.form);"><span class="lever"></span></label></div>
															</td>
															<td>
																<?php if($baris1["status_part"]==0){
																	echo "Belum Approve";
																}else{
																	echo "Sudah Approve";
																} 
																?>
															</td>
															<td><?= $baris1["lp"]; ?></td>
															<td><?= $baris1["part_kat"]; ?></td>
															<td><?= $baris1["part_nm"]; ?></td>
															<td><?= $baris1["part_no"]; ?></td>
															<td><?= $baris1["part_dtl"]; ?></td>
															<td><?= $baris1["uom"]; ?></td>
															<td><?= $baris1["kd_proses"]; ?></td>
															<td><?= $baris1["curr"]; ?></td>
															<td><?= $baris1["kat_tax"]; ?></td>
															<td><?= $baris1["pic_updt"]; ?></td>
															<?php 
															for ($i=1; $i <=12 ; $i++) {
																$price="price".$i;
																?>
																<td>
																	<?= number_format($baris1["$price"],2,".",""); ?></td>
																	<?php
																}
																?>
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
										<div class="body">
											<div class="form-group">
												<button type="submit" name="smpn" id="smpn" class="btn bg-green waves-effect"><i class="material-icons">save</i>Appprove</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>

			<script>
				function pilih(row){
					var kd_pel0=row.cells[0].innerHTML;
					var kd_pel1=row.cells[1].innerHTML;
					var kd_pel2=row.cells[2].innerHTML;
					var kd_pel3=row.cells[3].innerHTML;
					var kd_pel4=row.cells[4].innerHTML;
					var kd_pel5=row.cells[5].innerHTML;
					var kd_pel6=row.cells[6].innerHTML;
					var kd_pel7=row.cells[7].innerHTML;
					var kd_pel8=row.cells[8].innerHTML;
					var kd_pel9=row.cells[9].innerHTML;
					document.form1.part_grp.value=kd_pel1;
					document.form1.part_kat.value=kd_pel2;
					document.form1.part_nm.value=kd_pel3;
					document.form1.part_no.value=kd_pel4;
					document.form1.part_dtl.value=kd_pel5;
					document.form1.part_uom.value=kd_pel6;
					document.form1.id_proses.value=kd_pel7;
					document.form1.curr.value=kd_pel8;
				}
			</script>

			<script type="text/javascript">
				function checkAll(ele) {
					var checkboxes = document.getElementsByTagName('input');
					if (ele.checked) {
						for (var i = 0; i < checkboxes.length; i++) {
							if (checkboxes[i].type == 'checkbox' ) {
								checkboxes[i].checked = true;
							}
						}
					} else {
						for (var i = 0; i < checkboxes.length; i++) {
							if (checkboxes[i].type == 'checkbox') {
								checkboxes[i].checked = false;
							}
						}
					}
				}

				function moveScroll(){
					var scroll = $(window).scrollTop();
					var anchor_top = $("#maintable").offset().top;
					var anchor_bottom = $("#bottom_anchor").offset().top;
					if (scroll>anchor_top && scroll<anchor_bottom) {
						clone_table = $("#clone");
						if(clone_table.length == 0){
							clone_table = $("#maintable").clone();
							clone_table.attr('id', 'clone');
							clone_table.css({position:'fixed',
								'pointer-events': 'none',
								top:0});
							clone_table.width($("#maintable").width());
							$("#table-container").append(clone_table);
							$("#clone").css({visibility:'hidden'});
							$("#clone thead").css({visibility:'visible'});
						}
					} else {
						$("#clone").remove();
					}
				}
				$(window).scroll(moveScroll);
			</script>