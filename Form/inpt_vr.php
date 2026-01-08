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
			<h2>Input Voucher Receiving</h2>
		</div>

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
									<label>Received From</label>
									<div class="form-line">
										<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="ksupp" id="ksupp" >
											<option selected="selected" value="">--Received From--</option>
											<?php
											$tb_supp=odbc_exec($koneksi_lp,"select distinct SUPP_NAME,supp_code from lp_supp ");
											while($tb_supp_code=odbc_fetch_array($tb_supp)){ 
												$supp=odbc_result($tb_supp,"SUPP_NAME");
												$kode_supp=odbc_result($tb_supp,"supp_code");
												echo '<option value="'.$kode_supp.'">'.$supp.'</option>';
											}
											?>
										</select>
									</div>
								</div>
							</div>
							
						<div class="col-sm-3">	
							<div class="form-group">
								<label>Invoice No</label>
								<div class="form-line">
									<input type="text" name="inv_no" id="inv_no" value="" class="form-control" placeholder="Nomor Invoice" required>
								</div>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group">
								<label>Receiving date</label>
								<div class="form-line">
									<input type="text" class="form-control datetime" id="tgl" name="tgl" placeholder="Tanggal Invoice" required>
								</div>
							</div>
						</div>
						
						<div class="col-sm-3">
								<div class="form-group">
									<label>Received Thru</label>
									<div class="form-line">
										<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="rthru" id="rthru" >
											<option selected="selected" value="TRANSFER">TRANSFER</option>
											<option value="CASH">CASH</option>
										</select>
									</div>
								</div>
							</div>

					
					</div>
				</div>
				
					<div class="row clearfix">
						<div class="body">
							<div class="col-sm-3">
							<div class="form-group">
								<label>Amount</label>
								<div class="form-line">
									<input type="text" class="form-control" id="amount" name="amount" placeholder="Amount" required>
								</div>
							</div>
							</div>
							
							<div class="col-sm-3">
								<div class="form-group">
									<label>Received From</label>
									<div class="form-line">
										<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="kurs" id="kurs" >
											<option selected="selected" value="IDR">IDR</option>
											<option value="USD">USD</option>
											<option  value="EUR">EURO</option>
											<option value="JPY">YEN</option>
											<option value="THB">THB</option>
										</select>
									</div>
								</div>
							</div>
							
							<div class="col-sm-6">
							<div class="form-group">
								<label>Description</label>
								<div class="form-line">
									 <textarea rows="4" class="form-control"  id="descrip" name="descrip"  placeholder="Description" required></textarea>
								</div>
							</div>
							</div>
						
						</div>
					</div>
					
					<div class="row clearfix">
						
					</div>
					
				<div class="row clearfix">
					<div class="body">
						
				
						<div class="body">	
							<button type="submit" id="smpn" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>Save</button>	
						</div>
				
				</div>
			</div>
			</div>
	</form>
			<?php
			if(isset($_POST['smpn']) ){
				$sect=$_SESSION["area"];
				$pic=$_SESSION["nama"];
				$bln2=date("m");
				$bln=date("Ym");
				$year=date("Y");
				$ksupp=$_POST['ksupp'];
				$inv_no=$_POST['inv_no'];
				
				$amount=$_POST['amount'];
				$descrip=$_POST['descrip'];
				$ksupp=$_POST['ksupp'];
				$kurs=$_POST['kurs'];
				$rthru=$_POST['rthru'];
				
				$tgl_inv=date("Y-m-d",strtotime($_POST['tgl']));
				
				$novp=0;
				$qry_novp="select max(RIGHT(vp_no,3)) as jj from bps_vr where sect='$sect' and MONTH(tgl_updt)='$bln2' AND YEAR(tgl_updt)='$year'";
			
				$tb_novp=odbc_exec($koneksi_lp,$qry_novp);	while($bar_novp=odbc_fetch_array($tb_novp)){
					$novp=odbc_result($tb_novp,"jj");
				}
				
				$novp=$novp+1;	
				$novp2=substr('000'.$novp,-3);
				$vp_no="VR-".$sec."-".$bln."-".$novp2;
	
				$vp="insert into bps_vr (inv_no,po_no,lp,kode_supp,qty_tot,tot_bayar,curr,vp_no,pic_updt,tgl_updt,reason,
				paid_thru,sect,rcv_inv_date,pph) values ('$inv_no','$inv_no','$sect','$ksupp','1','$amount','$kurs','$vp_no','$pic',getdate(),'$descrip','$rthru','$sect','$tgl_inv','0')";
//echo $vp;
				$tb_vp=odbc_exec($koneksi_lp,$vp);
				
				echo "<script>alert('DATA BERHASIL DISIMPAN DENGAN VP NO $vp_no');</script>";
			}
			?>
		
</div>

<div class="container-fluid">
	<div class="row clearfix">
		<div class="card">
			<form action="" id="frm1" name="frm1" method="post"  enctype="multipart/form-data">
																<div class="header">
																	<h2>Record Voucher Receiving</h2>
																</div>
																<div class="row clearfix">
																	<div class="body">
																		<div class="table-responsive">
																			<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
																				<thead>
																					<tr>
																						<th>NO</th>
																						<th>VR NO</th>
																						<th>INV NO</th>
																						<th>VR DATE</th>
																						<th>DESCRIPTION</th>
																						<th>TOTAL BAYAR</th>
																						<th>VENDOR</th>
																						<th>PURCHASING</th>
																						<th>ACTION</th>
																					</tr >
																				</thead>
																				<tbody>

																					<?php
																					$lht_dt="SELECT vp_no,kode_supp,qty_tot,curr,tot_bayar,sect,inv_no,reason, tgl_updt from bps_vr where sect='$sect' order by vp_no desc";
																					$tb_pr=odbc_exec($koneksi_lp,$lht_dt);
																					//echo $lht_dt;
																					$i=0;
																					while($bar_pr=odbc_fetch_array($tb_pr)){ 
																						$vp_no=odbc_result($tb_pr,"vp_no");
																						$bayar=odbc_result($tb_pr,"tot_bayar");
																						$i++;
																						?>
																						<tr onclick="javascript:pilih(this);" >
																							<td><?php echo $i; ?></td>
																							<td><?php echo odbc_result($tb_pr,"tgl_updt"); ?></td>
																							<td><?php echo $vp_no; ?></td>
																							<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_pr,"tgl_updt"))); ?></td>
																							<td><?php echo odbc_result($tb_pr,"REASON"); ?></td>
																							<td><?php echo number_format($bayar); ?></td>
																							<td><?php echo odbc_result($tb_pr,"kode_supp"); ?></td>
																							<td><?php echo odbc_result($tb_pr,"sect");  ?></td>
																							<td>
																								<a href="##">
																									<i onclick="open_child('Exp_pdf/print_vr1.php?nomor=<?php echo $i;?>&no_doc=<?php echo $vp_no;?>&sect=<?php echo $sect;?>','Print vr <?php echo $vp_no;?>','800','500'); return false;" class="material-icons">print</i>
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
			<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">HAPUS VOUCHER RECEIVING</h4></div>
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