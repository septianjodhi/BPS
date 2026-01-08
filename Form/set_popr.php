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
error_reporting(0);
session_start();
$sect=$_SESSION["area"]; 
$pic=$_SESSION["nama"];
$pch_sect=explode("-",$sect);
$dept=$pch_sect[0];
$sec=$pch_sect[1];
$tahun_ini=date("Y");
$tahun_lalu=$tahun_ini-1;
$periode_skrg=date("Ym");
$periode_lampau=$tahun_ini."01";

$cr_term=odbc_exec($koneksi_lp,"SELECT TOP 1 term from bps_setTerm where CONVERT (Date, GETDATE())  between start_term AND finish_term");
// echo "SELECT TOP 1 term from bps_setTerm where getdate() between start_term AND finish_term";
$term_order=odbc_result($cr_term,'term');
$term_lalu=$term_order-1;
$term_next=$term_order+1;
// $tb_part=odbc_exec($koneksi,$res);

if(isset($_POST['delpo']) ){	
	$podel=$_POST["podel"];
	$tb_del1=odbc_exec($koneksi_lp,"DELETE from bps_podtl where pr_no='$prno'");
}

if(isset($_POST['smpn'])){
	$bln=date("ymds");
	$plh=$_POST['plh'];

	/*$qry_nopo="select max(RIGHT(po_no,3)) as jj from bps_podtl where lp='$pch_sect[1]' and convert(nvarchar(6),tgl_updt,112)='$bln'";
	$tb_nopo=odbc_exec($koneksi_lp,$qry_nopo);
	while($bar_nopo=odbc_fetch_array($tb_nopo)){
		$nopo=odbc_result($tb_nopo,"jj");
	}*/

	foreach ($plh as $_boxValue2){
		$np2=explode("|",$_boxValue2);
//$nopo=$nopo+1;	
//$nopo3=substr('000'.$nopo,-3);
		$po_no=$sec."-".$bln."-000";
// (case when a.part_desc is null then '' else a.part_desc end) as 

	/*	$qryinpodtl="INSERT into bps_podtl ( no_quo, kode_supp, pr_no, part_no, part_nm, part_dtl,
			part_desc,po_no,pic_updt,tgl_updt,qty,price,lp,term,periode,curr,uom,account,cccode,no_ctrl)
		select distinct a.no_quo,a.kode_supp,'$np2[0]',a.part_no,a.part_nm,a.part_dtl,(case when a.part_desc is null then '' else a.part_desc end) as part_desc,'$np2[0]' as po_no, '$pic' as pic_updt,getdate() 
		as tgl_updt,sum(b.qty) as qty,b.price,a.lp,a.term,a.periode,a.curr,a.uom,a.account,a.cccode,a.no_ctrl 
		FROM bps_tmpPR a left join bps_PR b on a.periode=b.periode and a.no_ctrl=b.no_ctrl and a.pr_no=b.pr_no and a.price_tot=b.price and a.qty_act=b.Qty
		left join bps_approve c on b.sect=c.sect and b.PR_NO=c.no_doc
		where a.pr_no='$np2[0]' and a.penawaran='YES' and a.no_ctrl not in ( select no_ctrl from bps_podtl where pr_no=a.pr_no and qty=a.qty_act and part_no=a.part_no) and c.status='FINISH' and a.lp='$sec' 
		group by a.no_quo,a.kode_supp,a.pr_no,a.part_no, a.part_nm,a.part_dtl,a.part_desc,b.price,a.lp,a.term,a.periode,a.curr,a.uom,a.account,a.cccode,a.no_ctrl";
	*/
	$qry_hdrpr="SELECT sect,periode,no_ctrl,pr_no,price,sum(qty)[qty] FROM bps_PR where pr_no='$np2[0]' group by periode,no_ctrl,pr_no,price,sect";
	$qryinpodtl="INSERT into bps_podtl ( no_quo, kode_supp, pr_no, part_no, part_nm, part_dtl,
		part_desc,po_no,pic_updt,tgl_updt,qty,price,lp,term,periode,curr,uom,account,cccode,no_ctrl)
		select distinct a.no_quo,a.kode_supp,'$np2[0]',a.part_no,a.part_nm,a.part_dtl,(case when a.part_desc is null then '' else a.part_desc end) as part_desc,'$np2[0]' as po_no, '$pic' as pic_updt,getdate() 
		as tgl_updt,b.qty,b.price,a.lp,a.term,a.periode,a.curr,a.uom,a.account,a.cccode,a.no_ctrl 
		FROM bps_tmpPR a left join ($qry_hdrpr) b on a.periode=b.periode and a.no_ctrl=b.no_ctrl and a.pr_no=b.pr_no and a.price_tot=b.price and a.qty_act=b.Qty
		left join bps_approve c on b.sect=c.sect and b.PR_NO=c.no_doc
		where a.pr_no='$np2[0]' and a.penawaran='YES' and a.no_ctrl not in ( select no_ctrl from bps_podtl where pr_no=a.pr_no and qty=a.qty_act and part_no=a.part_no) and c.status='FINISH' and a.lp='$sec'"; 
		$tb_crdtpo=odbc_exec($koneksi_lp,$qryinpodtl);
		 // echo $qryinpodtl;
	}
 echo $qryinpodtl."xxxxxxxxxx";
// echo $sq_pr."xxxxxxxxxx";
}
?>

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Purchase Order</h2>
		</div>

		<div class="row clearfix">
			<div class="card">
				<form action="" id="frm_rmk" name="frm_rmk" method="post"  enctype="multipart/form-data">
					<div class="row clearfix">
						<div class="header">
							<h2>Record Purchase Requisition (PR) </h2>
						</div>

						<div class="row clearfix">
							<div class="body">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Pilih Tanggal PR</label>
										<div class="form-line">
											<input type="text"  class="form-control" id="rg_tgl" name="rg_tgl" placeholder="Detail Pencarian" required>
										</div>
									</div></div></div><button type="submit" name="cr_tgl" id="cr_tgl" class="btn bg-purple waves-effect"><i class="material-icons">search</i></button>
								</div>
							</div>

							<div class="row clearfix">
								<div class="body">
									<div class="table-wrapper-scroll-y my-custom-scrollbar	">
										<table id="example" class="table table-bordered table-striped table-hover dataTable tabel2">
											<thead>
												<tr>	
													<th>PILIH PR</th>
													<th>PR NO</th>
													<th>PR DATE</th>
													<!-- <th>QTY</th>
														<th>AMOUNT</th> -->
														<th>SECT</th>
														<th>REMARK</th>
														<th>PURCHASING</th>
													</tr>
												</thead>
												<tbody>
													<?php

													if (isset($_GET['q'])) {
														$qry_outstanding	= base64_decode($_GET['q']);
														$sq_pr=$qry_outstanding;
													} else if (isset($_POST['cr_tgl'])) {
														// $sq_pr="SELECT a.pr_no,b.sect,a.pr_date,b.remark,a.lp,sum(b.qty) as qty,
														// sum(b.qty*b.price) as amn 
														// FROM bps_tmpPR a left join bps_PR b on a.periode=b.periode and a.no_ctrl=b.no_ctrl and a.price_tot=b.price and a.qty_act=b.Qty
														// left join bps_approve c on b.sect=c.sect and b.PR_NO=c.no_doc
														// where a.penawaran='YES' and a.no_ctrl not in ( select no_ctrl from bps_podtl where pr_no=a.pr_no and qty>=a.qty_act and part_no=a.part_no) and c.status='FINISH'
														// and a.lp='$sec' $cr_date group by a.pr_no,b.sect,a.pr_date,b.remark,a.lp order by b.sect asc,a.pr_no desc";

														$rg_tg=$_POST['rg_tgl'];
														$rg_tgl=explode("-",$rg_tg);
														$rg_tgl0=date("Y-m-d",strtotime($rg_tgl[0]));
														$rg_tgl1=date("Y-m-d",strtotime($rg_tgl[1]));
														$whr=" AND b.pr_date BETWEEN '".$rg_tgl0."' AND '".$rg_tgl1."'";
														$whr2=" AND b.pr_date=convert(varchar, getdate(), 23)";
														if($rg_tg==''){$cr_date=$whr2;}else{$cr_date=$whr;}

														// $sq_pr="SELECT distinct a.pr_no,b.sect,a.pr_date,b.remark,a.lp FROM bps_tmpPR a left join bps_PR b on a.periode=b.periode and a.no_ctrl=b.no_ctrl and a.price_tot=b.price and a.qty_act=b.Qty
														// left join bps_approve c on b.sect=c.sect and b.PR_NO=c.no_doc
														// where a.penawaran='YES' and a.no_ctrl not in ( select no_ctrl from bps_podtl where pr_no=a.pr_no and qty>=a.qty_act and part_no=a.part_no) and c.status='FINISH' and a.lp='$sec' AND a.term in ($term_order) $cr_date order by b.sect asc,a.pr_no desc";

														$sq_pr="SELECT distinct a.periode,b.sect,a.pr_no,a.pr_date,lp,b.remark from bps_tmpPR a left join bps_pr b on a.pr_no=b.pr_no left join bps_approve c on b.sect=c.sect and b.PR_NO=c.no_doc where penawaran='YES' and not exists (select * from bps_podtl where pr_no=a.pr_no and no_ctrl=a.no_ctrl ) and a.term in ($term_order,$term_lalu,$term_next) and lp='$sec' and c.status='FINISH' and a.periode>='$periode_lampau' $cr_date order by a.periode,a.pr_date ASC" ;
														
														
													}else{
														$sq_pr="";
													}
													 //echo $sq_pr."xxxxxxxxxx";
													$tb_pr=odbc_exec($koneksi_lp,$sq_pr);
													$i=0;
													while($bar_pr=odbc_fetch_array($tb_pr)){ 
														$prno=odbc_result($tb_pr,"pr_no");
														$remark=odbc_result($tb_pr,"remark");
														$i++;
														?>	
														<tr>
															<td>
																<div class="switch" ><label><input type="checkbox" name="plh[]" id="plh" value="<?php echo $prno; ?>" >
																	<span class="lever"></span></label>
																</div>
															</td>
															<td width="15%"><?php echo $prno; ?></td>
															<td width="10%"><?php echo date("Y-m-d",strtotime(odbc_result($tb_pr,"pr_date"))); ?></td>
															<!-- <td><?php echo round(odbc_result($tb_pr,"qty"),2); ?></td>
																<td><?php echo number_format(odbc_result($tb_pr,"amn"),2,".",","); ?></td> -->
																<td width="10%"><?php echo odbc_result($tb_pr,"sect"); ?></td>
																<td><?php echo $remark; ?></td>
																<td><?php echo odbc_result($tb_pr,"lp");  ?></td>
															</tr>	
															<?php 
														}
														?>
														<tr class="odd gradeX">
															<td align="center" valign="middle" nowrap="nowrap"><input type="checkbox" value="-|0|0|0|0|0|0" ></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
														</tr>
													</tbody>
												</table>
											</div>
											<?php 
											if(isset($_POST['cr_tgl']) ){
												?>
												<div class="body">	
													<button type="submit" id="smpn" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>Save</button>	
												</div>
												<?php 
											} 
											?>
										</div>
									</div>
								</form> 
							</div>
						</div>

						<div class="row clearfix">
							<div class="card">
								<form action="" id="frm1" name="frm1" method="post"  enctype="multipart/form-data">
									<div class="header">
										<h2>Record Purchase Requisition (PR) Siap dibuat PO</h2>
									</div>
									<div class="row clearfix">
										<div class="body">
											<div class="table-responsive">
												<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
													<thead>
														<tr>
															<th>NO</th>
															<th>PR NO</th>
															<th>PR DATE</th>
															<th>QTY</th>
															<th>AMOUNT</th>
															<th>SECT</th>
															<th>REMARK</th>
															<th>PO NO</th>
															<th>ACTION</th>
														</tr>
													</thead>
													<tbody>

														<?php 
														$lht_dt="SELECT distinct a.pr_no,remark,pr_date,sect,sum(a.qty) as qty,sum(a.qty*a.price) as price,po_no from bps_podtl a left join bps_pr b
														on a.pr_no=b.pr_no where po_no not like 'PO%' and lp='$sec' group by a.pr_no,remark,pr_date,sect,po_no order by a.pr_no";
														$tb_pr=odbc_exec($koneksi_lp,$lht_dt);
																// echo $lht_dt;
														$i=0;
														while($bar_pr=odbc_fetch_array($tb_pr)){ 
															$prno=odbc_result($tb_pr,"pr_no");
															$remark=odbc_result($tb_pr,"remark");
															$i++;
															?>	
															<tr  onclick="javascript:pilih(this);" >
																<td><?php echo $i; ?></td>
																<td><?php echo $prno; ?></td>
																<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_pr,"pr_date"))); ?></td>
																<td><?php echo odbc_result($tb_pr,"qty"); ?></td>
																<td><?php echo number_format(odbc_result($tb_pr,"price"),2,".",","); ?></td>
																<td><?php echo odbc_result($tb_pr,"sect"); ?></td>
																<td><?php echo $remark; ?></td>
																<td><?php echo odbc_result($tb_pr,"po_no"); ?></td>
																<td>
																	<a href="#" onClick="deletepo()" ><i  class="material-icons">delete</i></a>
																</td>
															</tr>	
															<?php 
														}
														?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</form> 
							</div>
						</div>
					</div>
				</section>


				<div class="modal fade" id="mddel" tabindex="1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">HAPUS PO</h4></div>
							<form action="" id="frmdel" name="frmdel" method="post"  enctype="multipart/form-data">
								<div class="modal-body">
									APAKAH ANDA YAKIN INGIN MENGHAPUS PR INI ? <input type="text" readonly class="form-control" data-role="tagsinput" id="podel" name="podel" placeholder="PR NO" required>
									<div class="modal-footer">
										<button type="submit" id="delpo" name="delpo" class="btn btn-link waves-effect">HAPUS</button>
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
									</div>
								</form></div></div>
							</div></div>
							<?php
							if(isset($_POST['delpo']) ){	
								$podel=$_POST["podel"];
								$tb_del1=odbc_exec($koneksi_lp,"delete from bps_podtl where pr_no='$podel'");
								
							}
							?>

							<script>
								function pilih(row){
									var kd_pel1=row.cells[1].innerHTML;
//alert(kd_pel1)
document.frmdel.podel.value=kd_pel1;
};
function deletepo(){
	$('#mddel').modal('show');
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