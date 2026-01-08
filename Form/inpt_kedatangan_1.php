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

if(isset($_POST['delinv']) )
{	
	$invdel=$_POST["invdel"];	
	$pc_inv=explode("|", $invdel);
	$tb_del1=odbc_exec($koneksi_lp,"delete from bps_kedatangan where inv_no='$pc_inv[0]' and po_no='$pc_inv[1]' ");
}
$crlp=odbc_exec($koneksi_lp,"select distinct lp from bps_tmppr");
?>

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Input Kedatangan 1</h2>
		</div>

		<div class="row clearfix">
			<div class="card">
				<div class="row clearfix">
					<div class="header">
						<h2>Record Requirement</h2>
					</div>
					<div class="body">
						<form action="" id="frm_rmk" name="frm_rmk" method="post"  enctype="multipart/form-data">
							<div class="col-sm-3">
								<div class="form-group">
									<label>Pilih Tanggal</label>
									<div class="form-line">
										<input type="text"  class="form-control" id="rg_tgl" name="rg_tgl" placeholder="Detail Pencarian" required>
									</div>
								</div>
							</div>

							<div class="col-sm-3"> 
								<div class="form-group">
									<label>Jenis Dokumen</label>
									<div class="form-line">
										<select class="selectpicker" name="jns_doc" id="jns_doc" required>
											<option selected="selected" value="">---Pilih Jenis Dok---</option>
											<option value="po">PO</option>
											<option value="pr">PR</option>
										</select>
									</div>
								</div>
							</div>
							<button type="submit" name="cr_tgl" id="cr_tgl" class="btn bg-purple waves-effect"><i class="material-icons">search</i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php 
		if(isset($_POST['cr_tgl']))
		{
			$supp=$_POST['supp'];
			$jns_doc=$_POST['jns_doc'];
			if($supp==''){$crsp="";}else{$crsp=" and kode_supp='$supp'";}
			if($jns_doc==''){$crlp="";}else if($jns_doc=='pr'){$crlp=" and sect='$sect' or lp='$sec' and jns_doc='PR'";}
			else {$crlp=" and lp='$sec'";}

			$rg_tg=$_POST['rg_tgl'];
			$rg_tgl=explode("-",$rg_tg);
			$rg_tgl0=date("Y-m-d",strtotime($rg_tgl[0]))." ".'00:00:00';
			$rg_tgl1=date("Y-m-d",strtotime($rg_tgl[1]))." ".'23:59:59';
			$whr_tgl=" and tgl_updt BETWEEN '$rg_tgl0' AND '$rg_tgl1' ";
			?>
			<div class="container-fluid">
				<div class="row clearfix">
					<form action="" id="frmcari" name="frmcari" method="post"  enctype="multipart/form-data">
						<div class="card">
							<div class="header">
								<h2>Pilih Data Requirement </h2>
							</div>

							<div class="row clearfix">
								<div class="body">

									<div class="col-sm-3">	
										<div class="form-group">
											<label>Jenis BC</label>
											<div class="form-line">
												<select class="selectpicker"  style="width: 100%;"  name="jnbc" id="jnbc">
													<option selected="selected" value="">---Pilih Jenis BC---</option>
													<option value="BC23">BC23</option>
													<option value="BC27M">BC27M</option>
													<option value="BC40">BC40</option>
												</select>
											</div>
										</div>
									</div>

									<div class="col-sm-3">	
										<div class="form-group">
											<label>Nomor BC</label>
											<div class="form-line">
												<input type="text" name="nobc" id="nobc" value="" class="form-control" placeholder="Nomor BC">
											</div>
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label>Tanggal BC</label>
											<div class="form-line">
												<input type="text" class="form-control datetime" id="tglbc" name="tglbc"  placeholder="Tanggal BC">
											</div>
										</div>
									</div>

								</div>
							</div>

							<div class="row clearfix">
								<div class="body">
									<div class="col-sm-3">	
										<div class="form-group">
											<label>Invoice No</label>
											<div class="form-line">
												<input type="text" name="inv_no" id="inv_no" value="" class="form-control" placeholder="Nomor Invoice" required>
											</div>
										</div>
										<?php
										if($jns_doc=='pr'){
											?>
											<div class="form-group">
												<label>Supplier</label>
												<div class="form-line">
													<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="ksupp" id="ksupp" >
														<option selected="selected" value="">--Supplier--</option>
														<?php
														$tb_supp=odbc_exec($koneksi_lp,"select distinct SUPP_NAME,supp_code from lp_supp ");
														while($tb_supp_code=odbc_fetch_array($tb_supp)){ 
															$supp=odbc_result($tb_supp,"SUPP_NAME");
															$kode_supp=odbc_result($tb_supp,"supp_code");
															echo '<option value="'.$kode_supp.'">'.$supp.'</option>';}
															?>
														</select>
													</div>
												</div>
											<?php } ?>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label>Invoice date</label>
												<div class="form-line">
													<input type="text" class="form-control datetime" id="tgl" name="tgl" placeholder="Tanggal Invoice" required>
												</div>
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label>Invoice Rcv date</label>
												<div class="form-line">
													<input type="text" class="form-control datetime" id="tgl_rcv" name="tgl_rcv" placeholder="Tanggal rcv Invoice" required>
												</div>
											</div>
										</div>

										<div class="col-sm-1">	
											<div class="form-group">
												<label>PPH</label>
												<div class="form-line">
													<select name="pph" id="pph" >
														<option selected="selected" value="">---Pilih pph---</option>
														<option value="0.5">0.5</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="10">10</option>
														<option value="20">20</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>


								<div class="row clearfix">
									<div class="body">
										<div class="table-wrapper-scroll-y my-custom-scrollbar	">
											<table id="example" class="table table-bordered table-striped table-hover dataTable tabel2">
												<thead>
													<tr >	
														<td align="center">Pilih Doc</td>
														<td align="center">Doc No</td>
														<td align="center">Doc Date</td>
														<td align="center">Vendor</td>
														<td align="center">Purchasing</td>
													</tr>
												</thead>
												<tbody>
													<?php

													$sq_pr="
													SELECT jns_doc,po_no as no_doc,min(tgl_updt) as tgl_doc,kode_supp,count(part_no) as jml_part,sum(qty) as qty_order,lp FROM mstr_kdtgn
													where jns_doc='$jns_doc' $whr_tgl $crlp 
													group by jns_doc,po_no,kode_supp,lp";
													$tb_po=odbc_exec($koneksi_lp,$sq_pr);
													$i=0;
													while($bar_po=odbc_fetch_array($tb_po)){ 
														$no_doc=odbc_result($tb_po,"no_doc");
														$lp=odbc_result($tb_po,"lp");
														$kd_supp=odbc_result($tb_po,"kode_supp");
														if($kd_supp==''){$supp=$ksupp;}else{$supp=$kd_supp;}
														$i++;
														?>	
														<tr>
															<td>
																<div class="switch"><label>
																	<input type="checkbox" name="plh[]" id="plh" value="<?php echo $no_doc."|".$lp; ?>" >
																	<span class="lever"></span></label>
																</div>
															</td>
															<td><?php echo $no_doc;?></td>
															<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_po,"tgl_doc"))); ?></td>
															<td><?php echo odbc_result($tb_po,"kode_supp"); ?></td>
															<td><?php echo $lp;  ?></td>
														</tr>	
														<?php 
													}}
													?>
													<tr class="odd gradeX">
														<td align="center" valign="middle" nowrap="nowrap"><input type="checkbox" value="-" ></td>
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
										<?php }?>
									</div>
								</div>
								<?php
								if(isset($_POST['smpn']) ){
									$bln=date("Ym");
									$plh=$_POST['plh'];
									$inv_no=$_POST['inv_no'];
									$q_pln=$_POST['q_pln'];
									$pph=$_POST['pph'];
									$ksupp=$_POST['ksupp'];
									if($pph==''){$pjk=0;}else{$pjk=$pph;}
									$count=count($plh);
									$tgl_inv=date("Y-m-d",strtotime($_POST['tgl']));
									$tgl_rcv=date("Y-m-d",strtotime($_POST['tgl_rcv']));

									$jnbc=$_POST['jnbc'];
									$nobc=$_POST['nobc'];
									$tgl_bc=$_POST['tglbc'];
									$qpln="";
									foreach ($plh as $_boxValue2){
										$np2=explode("|",$_boxValue2);
										$qryinpodtl="insert into bps_kedatangan (part_no, part_nm, part_dtl, part_desc,qty,pr_no,po_no,no_quo,kode_supp,sect_to,inv_no,inv_tgl, qty_dtg,pic_updt,tgl_updt,lp,price,curr,pph,account,cccode,ppn,uom,rcv_inv_date,no_bc,tgl_bc,jns_bc,no_ctrl)
										select part_no, part_nm, part_dtl, part_desc,qty_order as qty,pr_no,po_no,no_quo,(case when kode_supp='' then '$ksupp' else kode_supp end ) as kode_supp,
										sect as sect_to, '$inv_no' as inv_no,'$tgl_inv' as inv_tgl,(qty_order-qty_dtg) as qty_dtg,'$pic' as pic_updt,getdate() as tgl_updt,lp,price,curr,'$pjk' as pph,account,cccode,ppn,uom,'$tgl_rcv' as rcv_inv_date,'$nobc' as no_bc,'$tgl_bc' as tgl_bc,'$jnbc' as jns_bc,no_ctrl 
										from stok_dtg a where po_no='$np2[0]' and (qty_order-qty_dtg)>0";

										$tb_crdtpo=odbc_exec($koneksi_lp,$qryinpodtl);
									}
									$tb_updtbud=odbc_exec($koneksi_lp,"update bps_podtl set status_po='CLOSE' where po_no='$np2[0]' and no_ctrl='$noctrl'");

									echo "<script>alert('DATA BERHASIL DISIMPAN DENGAN INV NO $inv_no $qryinpodtl');</script>";
								}
								?>
							</div>
						</form>
					</div>
				</div>

				<div class="container-fluid">
					<div class="row clearfix">
						<div class="card">
							<form action="" id="frm1" name="frm1" method="post"  enctype="multipart/form-data">
								<div class="header">
									<h2>Record Incoming</h2>
								</div>
								<div class="row clearfix">
									<div class="body">
										<div class="table-responsive">
											<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
												<thead>
													<tr>
														<th>NO</th>
														<th>INV NO</th>
														<th>PO NO</th>
														<th>TANGGAL</th>
														<th>VENDOR</th>
														<th>PURCHASING</th>
														<th>TANGGAL PENERIMAAN</th>
														<th>ACTION</th>
													</tr>
												</thead>
												<tbody>
													<?php

													$lht_dt="select distinct inv_no,po_no,inv_tgl,kode_supp,lp,min(tgl_updt) as tgl_updt from bps_kedatangan where pic_updt='$pic' or lp='$sec' 
													group by inv_no,po_no,inv_tgl,kode_supp,lp
													order by tgl_updt desc ";
													$tb_pr=odbc_exec($koneksi_lp,$lht_dt);
													$i=0;
													while($bar_pr=odbc_fetch_array($tb_pr)){ 
														$po_no=odbc_result($tb_pr,"po_no");
														$inv_no=odbc_result($tb_pr,"inv_no");
														$lp=odbc_result($tb_pr,"lp");
														$i++;
														?>	
														<tr onclick="javascript:pilih(this);" >
															<td><?php echo $i; ?></td>
															<td><?php echo $inv_no; ?></td>
															<td><?php echo $po_no; ?></td>
															<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_pr,"inv_tgl"))); ?></td>
															<td><?php echo odbc_result($tb_pr,"kode_supp"); ?></td>
															<td><?php echo $lp;  ?></td>
															<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_pr,"tgl_updt"))); ?></td>
															<td>
																<a href="##"><i onclick="open_child('select/rev_dtg.php?inv=<?php echo $inv_no;?>&lp=<?php echo $lp;?>&nopo=<?php echo $po_no;?>&pic=<?php echo $pic;?>','Edit INV <?php echo $inv_no;?>','800','500'); return false;" class="material-icons">edit</i></a>
																<a href="#" onClick="deleteinv()" class="material-icons">delete</i></a>
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
			</div>
		</section>

		<div class="modal fade" id="mddel" tabindex="1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">HAPUS KEDATANGAN</h4></div>
					<form action="" id="frmdel" name="frmdel" method="post"  enctype="multipart/form-data">
						<div class="modal-body">
							APAKAH ANDA YAKIN INGIN MENGHAPUS PO INI DARI DAFTAR PENERIMAAN? <input type="text" readonly class="form-control" data-role="tagsinput" id="invdel" name="invdel" placeholder="INV NO" required>
							<div class="modal-footer">
								<button type="submit" id="delinv" name="delinv" class="btn btn-link waves-effect">HAPUS</button>
								<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
							</div>
						</form>
					</div>
				</div>
			</div>


		<script>
			function pilih(row){
				var kd_pel1=row.cells[1].innerHTML;
				var kd_pel2=row.cells[2].innerHTML;

				document.frmdel.invdel.value=kd_pel1+"|"+kd_pel2;
			};
			function deleteinv(){
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