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
$tgl_lewat = date('Y-m-d', strtotime('-60 days'));

if(isset($_POST['delvp']) ){	
	$vpdel=$_POST["vpdel"];
	$tb_del1=odbc_exec($koneksi_lp,"delete from bps_vp where vp_no='$vpdel'");
	$tb_del1=odbc_exec($koneksi_lp,"delete from bps_approve where no_doc='$vpdel'");

	echo "<script>alert('Data Telah Dihapus');</script>";
}

if(isset($_POST['smpn']) ){
	$bln=date("ym");
	$plh=$_POST['plh'];
	$reason=$_POST['reason'];
	$discount=$_POST['discount'];
	$amt_adj=$_POST['amt_adj'];
	$tgl_exp=date("Y-m-d",strtotime($_POST['tgl_exp']));
	$pt=$_POST['pt'];
	
	if($amt_adj<=2 && $amt_adj>=-4){
		
	$novp=0;
	$qry_novp="select max(RIGHT(vp_no,3)) as jj from bps_vp where (lp='$sec' or sect='$sect') and convert(nvarchar(4),tgl_updt,12)='$bln'";
	//periode='$per_tmp'";
	$tb_novp=odbc_exec($koneksi_lp,$qry_novp);	while($bar_novp=odbc_fetch_array($tb_novp)){
		$novp=odbc_result($tb_novp,"jj");
	}
	$novp=$novp+1;	
	$novp2=substr('000'.$novp,-3);
	$vp_no="JF-VP-".$sec."-".$bln."-".$novp2;
	
	
	foreach ($plh as $_boxValue2){
		$np2=explode("|",$_boxValue2);

//$crppn=odbc_exec($koneksi_lp,"select isnull(ppn,0) as ppn from LP_SUPP where SUPP_CODE='$np2[1]'");
//$ppn=odbc_result($crppn,"ppn");

		$vp="insert into bps_vp (inv_no,po_no,lp,kode_supp,qty_tot,tot_bayar,curr,no_bc,tgl_bc,jns_bc,vp_no,pic_updt,tgl_updt,reason,pph,ppn,
		paid_thru,sect,rcv_inv_date,amt_adj,discount)
		select distinct inv_no,po_no,lp,kode_supp,sum(qty_dtg) as qty_tot,sum(qty_dtg*price) as tot_bayar,curr,no_bc,tgl_bc,jns_bc,'$vp_no' as vp_no,'$pic' as pic_updt,getdate() as tgl_updt,'$reason' as reason,pph,ppn,'$pt' as paid_thru,'$sect' as sect,max(rcv_inv_date) as rcv_inv_date,'$amt_adj'[amt_adj],'$discount'[discount]
		from bps_kedatangan where inv_no='$np2[0]' and (sect_to='$sect' or lp='$sec')
		group by inv_no,po_no,lp,kode_supp,curr,pph,no_bc,tgl_bc,jns_bc,ppn";
		
		$tb_vp=odbc_exec($koneksi_lp,$vp);
	}
	$sql_amount="select distinct vp_no,sum(dbo.lp_konprc(term,'IDR',curr,tot_bayar)) as idr from bps_vp where vp_no='$vp_no' group by vp_no";
	$tb_amount=odbc_exec($koneksi_lp,$sql_amount);
	$qty_add="";$prc_add="";
	while($bar_moun=odbc_fetch_array($tb_amount)){
		$amoun_IDR=odbc_result($tb_amount,"idr");
	}
	$pchsec=explode("-",$sect);
	$dept=$pchsec[0];
	$qry_delaprv="delete from bps_approve where jns_doc in('VP') and no_doc='$vp_no'";
	$tb_delaprv=odbc_exec($koneksi_lp,$qry_delaprv);

	$cr_aprv=odbc_exec($koneksi_lp, "select count(*) as jm from bps_setApprove where 
		jns_dok ='VP' and status_akun='AKTIF' and (sect='$sect' or sect='$dept-ALL' or (sect='SAMI-ALL' AND (max_amount='0' or
		(min_amount<=0 and max_amount>0))))");
	$jm_aprv=odbc_result($cr_aprv, "jm");

	if($jm_aprv==4)
	{
		$qry_adaprv=odbc_exec($koneksi_lp,"insert into bps_approve(pic_plan, no_doc,tgl_prepaire,jns_doc,
			sect,initial,approve,no_aprv)
			values ('$pic','$vp_no',getdate(),'VP','$sect','$pic','PREPARED',1)");
	}

	$qry_adaprv="insert into bps_approve(pic_plan,email_plan,no_doc,tgl_prepaire,jns_doc,
	sect,initial,approve,no_aprv)
	SELECT nama as pic_plan,email as email_plan,'$vp_no' as no_doc,getdate() as tgl_prepaire,
	'VP' as jns_doc,sect,initial,approve,no_aprv  FROM bps_setApprove where jns_dok ='VP'
	and status_akun='AKTIF' and 
	(sect='$sect' or sect='$dept-ALL' or (sect='SAMI-ALL' AND (max_amount='0' or 
	(min_amount<=0 and max_amount=0))))";

	

	$tb_inaprv=odbc_exec($koneksi_lp,$qry_adaprv);
	echo "<script>alert('Data Telah Disimpan');</script>";
	
	}else{
		echo "<script>alert('Gagal');</script>";
	}
	
	//echo $vp;
}?>

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Input Voucher Paying <?= $tgl_lewat; ?></h2>
		</div>

		<div class="row clearfix">
			<div class="card">
				<div class="row clearfix">
					<div class="header">
						<h2>Record Data Pembelian </h2>
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

							<div class="col-sm-6">	
								<div class="form-group">
									<label>Supplier</label>
									<select class="selectpicker" data-live-search="true" name="ksupp" id="ksupp" required>
										<option selected="selected" value="">--Supplier--</option>
										<?php
										$tb_supp=odbc_exec($koneksi_lp,"SELECT distinct SUPP_NAME,kode_supp from bps_kedatangan a inner join LP_SUPP b on a.kode_supp=b.SUPP_CODE and (sect_to='$sect' or lp='$sec')");
	//echo $tb_supp;
										while($tb_supp_code=odbc_fetch_array($tb_supp)){ 
											$supp=odbc_result($tb_supp,"SUPP_NAME");
											$kode_supp=odbc_result($tb_supp,"kode_supp");
											echo '<option value="'.$kode_supp.'">'.$supp.'</option>';}
											?>
										</select>
									</div></div>
									<button type="submit" name="cr_tgl" id="cr_tgl" class="btn bg-purple waves-effect"><i class="material-icons">search</i></button>
								</form>
							</div></div></div>


							<?php if(isset($_POST['cr_tgl'])){
								$ksupp=$_POST['ksupp'];
								if($ksupp==''){$crsp="";}else{$crsp=" kode_supp='$ksupp'";}
								$rg_tg=$_POST['rg_tgl'];
								$rg_tgl=explode("-",$rg_tg);
								$rg_tgl0=date("Y-m-d",strtotime($rg_tgl[0]))." ".'00:00:00';
								$rg_tgl1=date("Y-m-d",strtotime($rg_tgl[1]))." ".'23:59:59';
								$whr=" AND tgl_updt BETWEEN '$rg_tgl0' AND '$rg_tgl1' ";

								$qrycrdt="SELECT count(*) as jmc from bps_kedatangan a where $crsp $whr and (sect_to='$sect' or lp='$sec') ";
								 //echo $qrycrdt;
								$tb_crdt=odbc_exec($koneksi_lp,$qrycrdt);
								$jm=0;
								while($barcrdt=odbc_fetch_array($tb_crdt)){
									$jm=odbc_result($tb_crdt,"jmc");
								}
								if($jm==0){
									echo "<script>alert('TIDAK ADA DATA YANG DI CARI');</script>";
									// echo $qrycrdt;
								}else{

									?>
									<div class="container-fluid">
										<div class="row clearfix">
											<form action="" id="frmcari" name="frmcari" method="post"  enctype="multipart/form-data">
												<div class="card">
													<div class="header">
														<h2>Data Pembelian Supllier <?php //echo $supp; ?></h2>
													</div>

													<div class="row clearfix">
														<div class="body">

															<div class="row">

																<div class="col-sm-3">	
																	<div class="form-group">
																		<label>Paid Thru</label>
																		<div class="form-line">
																			<select class="selectpicker" style="width: 100%;"  name="pt" id="pt">
																				<option selected="selected" value="">---Pilih Jenis Pembayaran---</option>
																				<option value="transfer">TRANSFER</option>
																				<option value="cash">CASH</option>
																			</select>
																		</div>
																	</div>
																</div>	
																
																<div class="col-sm-3">	
																	<div class="form-group">
																		<label>Payment For</label>
																		<div class="form-line">
																			<input type="textarea" name="reason" id="reason" value="" class="form-control" placeholder="Reason" required>
																		</div>
																	</div>
																</div>

																<div class="col-sm-3">	
																	<div class="form-group">
																		<label>Discount (curr) </label>
																		<div class="form-line">
																			<input type="number" min=0 name="discount" id="discount" value="" class="form-control" placeholder="Discount" value="0">
																		</div>
																	</div>
																</div>
																
																<div class="col-sm-3">	
																	<div class="form-group">
																		<label>Amount Adjusment</label>
																		<div class="form-line">
																			<input type="number" min=-4 max=2 name="amt_adj" id="amt_adj" class="form-control" value="0">
																		</div>
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
																		<tr>	
																			<th><div class="switch" >
																				<label>
																					<input type="checkbox" onchange="checkAll(this)" name="plh[]" >
																					<span class="lever"></span>
																				</label>
																			</div></th>
																			<th>DOC NO</th>
																			<th>DOC DATE</th>
																			<th>QTY</th>
																			<th>AMOUNT</th>
																			<th>VENDOR</th>
																			<th>PURCHASING</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																		$sq_pr="
																		SELECT distinct inv_no as no_doc,inv_tgl as doc_date,kode_supp,sum(qty_dtg) as qty,(case when curr='IDR' then sum(floor((qty_dtg*price))+(floor((qty_dtg*price)*isnull(ppn,0)/100))-(floor((qty_dtg*price)*isnull(pph,0)/100))) else sum((qty_dtg*price)+((qty_dtg*price)*isnull(ppn,0)/100)-((qty_dtg*price)*isnull(pph,0)/100)) end) as amn,lp from bps_kedatangan a
																		where $crsp $whr and (sect_to='$sect' or lp='$sec') and inv_no not in (select inv_no from bps_vp where inv_no=a.inv_no and lp=a.lp)
																		group by inv_no,kode_supp,lp,inv_tgl,CURR";
																		//echo $sq_pr;
																		$tb_po=odbc_exec($koneksi_lp,$sq_pr);
																		$i=0;
																		while($bar_po=odbc_fetch_array($tb_po)){ 
																			$no_doc=odbc_result($tb_po,"no_doc");
																			$ksupp=odbc_result($tb_po,"kode_supp");
																			$i++;
																			?>
																			<tr>
																				<td>
																					<div class="switch" ><label><input type="checkbox" name="plh[]" id="plh" value="<?php echo $no_doc."|".$ksupp; ?>" >
																						<span class="lever"></span></label>
																					</div>
																				</td>
																				<td><?php echo $no_doc; ?></td>
																				<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_po,"doc_date"))); ?></td>
																				<td><?php echo odbc_result($tb_po,"qty"); ?></td>
																				<td><?php echo number_format(odbc_result($tb_po,"amn"),2,".",","); ?></td>
																				<td><?php echo $ksupp; ?></td>
																				<td><?php echo odbc_result($tb_po,"lp");  ?></td>
																			</tr>	
																			<?php 
																		}
																	}
																	?>
																	<tr class="odd gradeX">
																		<td align="center" valign="middle" nowrap="nowrap"><input type="checkbox" value="-" ></td>
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
														<?php }}?>
													</div>
												</div>


												<div class="container-fluid">
													<div class="row clearfix">
														<div class="card">
															<form action="" id="frm1" name="frm1" method="post"  enctype="multipart/form-data">
																<div class="header">
																	<h2>Record Voucher Paying</h2>
																</div>
																<div class="row clearfix">
																	<div class="body">
																		<div class="table-responsive">
																			<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
																				<thead>
																					<tr>
																						<th>NO</th>
																						<th>VP NO</th>
																						<th>VP DATE</th>
																						<th>PO NO</th>
																						<th>TOTAL BAYAR</th>
																						<th>VENDOR</th>
																						<th>PURCHASING</th>
																						<th>ACTION</th>
																					</tr >
																				</thead>
																				<tbody>

																					<?php
																					$lht_dt="SELECT vp_no,kode_supp,sum(qty_tot) as qty_tot,curr,SUM(tot_bayar+(tot_bayar*ppn/100)-(tot_bayar*pph/100)) as tot_bayar,sect,
																					min(tgl_updt) as tgl_updt
																					from bps_vp where sect='$sect' and tgl_updt between '$tgl_lewat' and getdate()
																					group by vp_no,kode_supp,curr,sect
																					order by vp_no desc";
																					$tb_pr=odbc_exec($koneksi_lp,$lht_dt);
																					// echo $lht_dt;
																					$i=0;
																					while($bar_pr=odbc_fetch_array($tb_pr)){ 
																						$vp_no=odbc_result($tb_pr,"vp_no");
																						$bayar=odbc_result($tb_pr,"tot_bayar");
																						$i++;
																						?>
																						<tr onclick="javascript:pilih(this);" >
																							<td><?php echo $i; ?></td>
																							<td><?php echo $vp_no; ?></td>
																							<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_pr,"tgl_updt"))); ?></td>
																							<?php 
																							$dt_po=odbc_exec($koneksi_lp,"SELECT po_no from bps_vp where vp_no='$vp_no' " );
																							$gab_po="";
																							while($tbl_po=odbc_fetch_array($dt_po)){ 
																								$po_no=$tbl_po['po_no'];
																								$gab_po=$gab_po.",".$po_no;
																							}
																							?>
																							<td><?= substr($gab_po, 1,strlen($gab_po)); ?></td>
																							<td><?php echo number_format($bayar); ?></td>
																							<td><?php echo odbc_result($tb_pr,"kode_supp"); ?></td>
																							<td><?php echo odbc_result($tb_pr,"sect");  ?></td>
																							<td>
																								<a href="##">
																									<i onclick="open_child('Exp_pdf/print_vp1.php?nomor=<?php echo $i;?>&no_doc=<?php echo $vp_no;?>&sect=<?php echo $sect;?>','Print vp <?php echo $vp_no;?>','800','500'); return false;" class="material-icons">print</i>
																								</a>
																								<a href="#" onClick="deletevp()" ><i class="material-icons">delete</i></a>
																								<!-- <a href="#" data-id='<?= $vp_no; ?>' data-toggle='modal' href='#' data-target='#mddel' title='Hapus Data'>
																									<i class="material-icons">delete</i>
																								</a> -->
																								<!-- <a class='btn btn-danger btn-sm' data-id='<?= $id; ?>' 
																									href='index.php?page=form/trn/del_license.php&n=<?=  $baris1["nik"]; ?>' data-target='#edit' title='Ubah Data' >
																									<i class="fa fa-trash">  Hapus Lisence</i>
																								</a> -->
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
													<div class="modal-header">
														<h4 class="modal-title" id="defaultModalLabel">HAPUS DOKUMEN</h4>
													</div>
													<form action="" id="frmdel" name="frmdel" method="post"  enctype="multipart/form-data">
														<div class="modal-body">
															APAKAH ANDA YAKIN INGIN MENGHAPUS DOKUMEN INI? 
															<input type="text" readonly class="form-control" data-role="tagsinput" id='bookId' name="vpdel" placeholder="VP NO" required>
															<div class="modal-footer">
																<button type="submit" id="delvp" name="delvp" class="btn btn-link waves-effect">HAPUS</button>
																<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
															</div>
														</div>
													</form>
												</div>
											</div>
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
				var kd_pel1=row.cells[1].innerHTML;
				document.frmdel.vpdel.value=kd_pel1;
			};

			function deletevp(){
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
		</script>
