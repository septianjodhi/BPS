<!-- <section class="content">
 <div class="container-fluid">
	<div class="block-header">
		<h1 align="center">UNDER MAINTENANCE 404<br>
			<small><em>for Urgent, please contact IT on ext 215</em></small></h1>

	</div>
</div>
</section> -->
<?php /**/?>
<script>
	function open_child(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
		
	};
</script>
<?php 
$lok= $_SESSION['lok'];
$sect= $_SESSION["area"]; 
$pic=$_SESSION["nama"];

$akses=$_SESSION["akses"];
$adm=strpos($akses,'_FA');
$kd_akses=explode(",",$akses);
if(in_array('ADM_FA',$kd_akses)){
	$adm1="admin";
}else{
	$adm1="user";
}

if(isset($_POST['delpr']) ){	
	$prdel=$_POST["prdel"];
	$tb_del1=odbc_exec($koneksi_lp,"delete from bps_pr where pr_no='$prdel'");
	$tb_del2=odbc_exec($koneksi_lp,"delete from bps_tmppr where pr_no='$prdel'");
	$tb_del1=odbc_exec($koneksi_lp,"delete from bps_approve where jns_doc in('PR','ADD') and no_doc='$prdel'");
}
?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>REVISI PR <?php echo strtoupper($sect); ?></h2>
		</div>
		<div class="row clearfix">
			<div class="card">
				<div class="row clearfix">				
					<div class="header">
						<h2>Record PR ber Status masih OPEN<small>Lihat data PR</small></h2>
					</div>
					<div class="body">
						<form action="" id="frm_rmk" name="frm_rmk" method="post"  enctype="multipart/form-data">
							<div class="row clearfix">
								<div class="body">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Pilih Tanggal PR</label>
											<div class="form-line">
												<input type="text"  class="form-control" id="rg_tgl" name="rg_tgl" placeholder="Detail Pencarian" required>
											</div>
										</div>
									</div>
								</div>
								<button type="submit" name="lihat_tgl" id="lihat_tgl" class="btn bg-purple waves-effect"><i class="material-icons">search</i></button>
							</div>

							<div class="table-responsive">
								<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
									<thead>
										<tr> 
											<th>PERIODE</th>	
											<th>PR NO</th>
											<th>PR DATE</th>
											<th width="10%">JUM ITEM</th>
											<th width="10%">TOT QTY</th>
											<th width="10%">AMOUNT IDR</th>
											<th width="10%">AMOUNT USD</th>
											<th width="30%"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										if(isset($_POST['lihat_tgl'])){
											$perinow=date("Ym");
											$rg_tg=$_POST['rg_tgl'];
											$rg_tgl=explode("-",$rg_tg);
											$rg_tgl0=date("Y-m-d",strtotime($rg_tgl[0]));
											$rg_tgl1=date("Y-m-d",strtotime($rg_tgl[1]));
											$whr=" AND a.pr_date BETWEEN '".$rg_tgl0."' AND '".$rg_tgl1."'";
											$whr2=" AND a.pr_date=convert(varchar, getdate(), 23)";
											if($rg_tg==''){$cr_date=$whr2;}else{$cr_date=$whr;}

											$sq_acc="
											SELECT distinct PERIODE,PR_NO,PR_DATE,COUNT(no_ctrl) as jm_item,sum(qty) as tot_qty,sum(dbo.lp_konprc(term,'IDR',curr,qty*price)) as idr,
											sum(dbo.lp_konprc(term,'USD',curr,qty*price)) as dolar,b.status from bps_pr a left join bps_approve b on PR_NO=no_doc and a.sect=b.sect
											where a.sect='$sect' $cr_date
											group by PERIODE,PR_NO,PR_DATE,b.status 
											order by pr_no ,pr_date desc";
//and periode>=convert(nvarchar(6),getdate(),112)
											// echo $sq_acc;
											$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
											$row=0;
											while($baris1=odbc_fetch_array($tb_acc)){ $row++;
												$prno=odbc_result($tb_acc,"pr_no");
												$status=odbc_result($tb_acc,"status");
												$jmitem=odbc_result($tb_acc,"jm_item");
												$tot_qty=number_format(odbc_result($tb_acc,"tot_qty"), '2', '.', '.');
												$idr= number_format(odbc_result($tb_acc,"idr"),0,".",",");
												$dolar=number_format(odbc_result($tb_acc,"dolar"),2,".",",");
												$periode_pr=odbc_result($tb_acc,"periode");
												if (strpos($prno,"INVEST")==0){
													$select="Exp_pdf/print_pr.php?nomor=";
												}else{
													$select="Exp_pdf/print_pr_invest.php?nomor=";
												}
												?>	
												<tr onclick="javascript:pilih(this);" >
													<td><?php echo odbc_result($tb_acc,"periode"); ?></td>
													<td><?php echo $prno; ?></td>
													<td><?php echo odbc_result($tb_acc,"pr_date"); ?></td>
													<td><input width="10%" type="number" readonly name="jmitem[]" id="jmitem" value="<?php echo $jmitem;?>" class="form-control"></td>
													<td><input width="10%" type="text" readonly name="tot_qty[]" id="tot_qty" value="<?php echo $tot_qty;?>" class="form-control"></td>
													<td><input width="10%" type="text" readonly name="idr[]" id="idr" value="<?php echo $idr;?>" class="form-control"></td>
													<td><input width="10%" type="text" readonly name="dolar[]" id="dolar" value="<?php echo $dolar;?>" class="form-control"></td>
													<td  width="30%">
														<a href="##"><i onclick="open_child('<?php echo $select.$row;?>&nopr=<?php echo $prno;?>','Print PR <?php echo $prno;?>','800','500'); return false;" class="material-icons">print</i></a>
														<?php if ($status!='FINISH' || $adm1=='user'){?>
															<a href="##">
																<i onclick="open_child('select/rev_pr.php?pic=<?php echo $pic;?>&sec=<?php echo $sect;?>&sesi=<?php echo $lok;?>&nopr=<?php echo $prno;?>','Edit PR <?php echo $prno;?>','800','500'); return false;" class="material-icons">edit
																</i>
															</a>
															<a href="#" onClick="deletepr()" ><i  class="material-icons">delete</i></a><?php }?>
															<a href="Exp_xls/exp_PR.php?pr_no=<?php echo $prno; ?>&sec=<?php echo $sect;?>&periode=<?php echo $periode_pr; ?>" _target="blank"><i  class="material-icons">file_download</i></a>
															<a href="index.php?page=form/inpt_posupcap2.php&pr_no=<?= $prno; ?>" type="button" class="btn bg-yellow waves-effect" ><i class="material-icons">swap_horiz</i> Buat PO</a>
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
							</form> 
						</div>	
					</div>	
				</div>
			</div>           
		</div>
	</div>
</section>


<div class="modal fade" id="mddel" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">HAPUS PR</h4></div>
			<form action="" id="frmdel" name="frmdel" method="post"  enctype="multipart/form-data">
				<div class="modal-body">
					APAKAH ANDA YAKIN INGIN MENGHAPUS PR <input type="text" readonly class="form-control" data-role="tagsinput" id="prdel" name="prdel" placeholder="PR NO" required> ?
				</div>
				<div class="modal-footer">
					<button type="submit" id="delpr" name="delpr" class="btn btn-link waves-effect">HAPUS</button>
					<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script>
	function pilih(row){
//alert(row.cells.item(1).innerHTML);
//var kd_pel0=row.cells[0].innerHTML;
var kd_pel1=row.cells[1].innerHTML;
document.frmdel.prdel.value=kd_pel1;
};

function deletepr(){
	$('#mddel').modal('show');
     // window.location.assign('urlkedua')
   };


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
