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
	function open_child(url,title,w,h)
	{
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};
</script>
<?php
$sect=$_SESSION["area"];
$lokasi=$_SESSION["lokasi"];
$pic=$_SESSION["nama"];
$pch_sect=explode("-",$sect);
$dept=$pch_sect[0];
$sec=$pch_sect[1]; 

if(isset($_POST['smpn_po']) )
{
	$bln=date("ym");
	$blnth=date("Ym");
	$nopo=0;
	$plh=$_POST['plh'];
	$kd_spp=str_replace(' ', '',$_POST['suppl']);
	$eta=$_POST['eta_po'];
	$term_op=$_POST['term_op'];
	$qry_nopo="select max(RIGHT(po_no,3)) as jj from bps_podtl where lp='$pch_sect[1]' and kode_supp='$kd_spp' and convert(nvarchar(6),tgl_updt,112)='$blnth' and po_no<>pr_no";

	echo $qry_nopo;

	$tb_nopo=odbc_exec($koneksi_lp,$qry_nopo);
	while($bar_nopo=odbc_fetch_array($tb_nopo))
	{
		$nopo=number_format(odbc_result($tb_nopo,"jj"),0,"","");
	}
	
	$nopo=$nopo+1;
	$nopo3=substr('000'.$nopo,-3);

	$pph=$_POST['pph'];
	$ppn=$_POST['ppn'];

	foreach ($plh as $_boxValue2)
	{
		$np2=explode("|",$_boxValue2);
		if ($lokasi=='TF') {
			$po_no=str_replace(' ', '',"TF-PO-".$sec."-".trim($np2[1].$bln)."-".$nopo3);
		} else {
			$po_no=str_replace(' ', '',"JF-PO-".$sec."-".$np2[1].$bln."-".$nopo3);
		}

		// $updt_po="update bps_podtl set po_no='$po_no',tgl_updt=getdate(),eta='$eta',status_po='OPEN',ppn='$ppn',pph='$pph'
		// where po_no not like 'PO%' and kode_supp='$np2[1]' and part_no='$np2[0]' and pr_no='$np2[2]' and lp='$sec'";
		$updt_po="update bps_podtl set po_no='$po_no',tgl_updt=getdate(),eta='$eta',status_po='OPEN',ppn='$ppn',pph='$pph',term_of_payment='$term_op'
		where po_no not like '$lokasi-PO%' and kode_supp='$np2[1]' and no_ctrl='$np2[4]' ";

		$tbupdt_po=odbc_exec($koneksi_lp,$updt_po);
		 ECHO $updt_po;
	}
	$qry_delaprv="delete from bps_approve where jns_doc='PO' and no_doc='$po_no'";
	$tb_delaprv=odbc_exec($koneksi_lp,$qry_delaprv);
	$qry_adaprv="insert into bps_approve(pic_plan,email_plan,no_doc,tgl_prepaire,jns_doc,sect,initial,approve,no_aprv) SELECT nama as pic_plan,email as email_plan,'$po_no' as no_doc,getdate() as tgl_prepaire,'PO',sect,initial,approve,no_aprv  FROM bps_setApprove where status_akun='aktif' and jns_dok='PO' and (sect='$sect' or sect='$dept-ALL' or sect='SAMI-ALL')";
	$tb_delaprv=odbc_exec($koneksi_lp,$qry_adaprv);
	// echo $qry_adaprv;
}
?>

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Purchase Order</h2>
		</div>
		<div class="row clearfix">	
			<div class="card">
				<div class="row clearfix">		
					<div class="header">
						<h2>Record<small>Cari Supplier</small></h2>
					</div>
					<div class="body">
						<form action="" id="frmsupp" method="post"  enctype="multipart/form-data">

							<div class="col-sm-3">	
								<div class="form-group">
									<label>Supplier</label>
									<div class="form-line">
										<select class="selectpicker" style="width: 100%;"  name="ksupp" id="ksupp" required>
											<option selected="selected" value="">--Pilih Supplier--</option>
											<?php
											$tb_ksupp=odbc_exec($koneksi_lp,"select distinct kode_supp from bps_podtl where po_no not like '$lokasi-PO%' and lp='$sec'");
											while($baris1=odbc_fetch_array($tb_ksupp)){
												$ksupp=odbc_result($tb_ksupp,"kode_supp");
												echo '<option value="'.$ksupp.'">'.$ksupp.'</option>';
											}
											?>
										</select>
									</div> 
								</div>
							</div>

							<div class="col-sm-2">
								<button type="submit" name="cr_s" id="cr_s" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">search</i> </button>
								<button type="reset" name="reset" id="reset" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">clear</i> </button>
							</div>
						</form>
					</div>	
				</div>
			</div>
		</div>
		<?php
		if(isset($_POST['cr_s'])){
			$kdsuppi=$_POST['ksupp'];
			?>
			<div class="row clearfix">
				<div class="card">
					<form action="" id="frmcari" name="frmcari" method="post"  enctype="multipart/form-data">
						<div class="row clearfix">				
							<div class="header">
								<h2>Buat Purchase Order (PO)</h2>
							</div>

							<div class="body">
								<div class="col-sm-2">	
									<div class="form-group">
										<label>Supplier</label>
										<div class="form-line">
											<input type="text" readonly name="suppl" id="suppl" value="<?php echo $kdsuppi; ?>" class="form-control"  required>
										</div>
									</div>
								</div>

								<div class="col-sm-2">	
									<div class="form-group">
										<label>PO Date</label>
										<div class="form-line">
											<input type="text" name="po_date" id="po_date" value="<?php echo date("Y-m-d");?>" class="form-control date-min"  required>
										</div>
									</div>
								</div>

								<div class="col-sm-2">	
									<div class="form-group">
										<label>ETA SAMI</label>
										<div class="form-line">
											<input type="text" name="eta_po" id="eta_po" class="form-control date-min"  required>
										</div>
									</div>
								</div>

								<div class="col-sm-3">	
									<div class="form-group">
										<label>PPN</label>
										<div class="form-line">
											<select name="ppn" id="ppn" >
												<option selected="selected" value="0">---Pilih Nominal---</option>
												<option value="0">0%</option>
												<option value="10">10%</option>
												<option value="11">11%</option>
												<option value="12">12%</option>
											</select>
										</div>
									</div>
								</div> 

								<div class="col-sm-3">	
									<div class="form-group">
										<label>PPH</label>
										<div class="form-line">
											<!-- <select class="selectpicker" style="width: 100%;"  name="pph" id="pph" required> -->
												<select  name="pph" id="pph" >
													<option selected="selected" value="0">---Pilih Nominal---</option>
													<option value="0">0%</option>
													<option value="0.5">0.5%</option>
													<option value="1.75">1.75%</option>
													<option value="2">2%</option>
													<option value="2.5">2.5%</option>
													<option value="2.65">2.65%</option>
													<option value="3">3%</option>
													<option value="4">4%</option>
													<option value="5">5%</option>
													<option value="10">10%</option>
													<option value="15">15%</option>
													<option value="20">20%</option>
												</select>
											</div>
										</div>
									</div>
									
									
								<div class="col-sm-4">
									<div class="form-group">
										<label>Term Of Payment</label>
										<div class="form-line">
											<input type="text" name="term_op" id="term_op" class="form-control" value="1 Month After Invoice Received"  required>
										</div>
									</div>
								</div>
								
								</div>	
								
								
							</div>

							<div class="row clearfix">
								<div class="body">
									<div class="table-responsive">
										<div class="table-wrapper-scroll-y my-custom-scrollbar">
											<table id="dtVerticalScroll" class="table table-bordered table-striped dataTable tabel2 " cellspacing="0" width="100%">								
												<thead>	
													<tr>
														<th width="80">Pilih</th>
														<th>TERM</th>
														<th>PERIODE</th>
														<th>SUPP</th>
														<th>PR NO</th>
														<th>PART NO</th>
														<th>PART NAME</th>
														<th>PART DETAIL</th>
														<th>PART DESC</th>
														<th>QTY</th>
														<th>PRICE</th>
														<!-- <th>PO DATE (MIN)</th> -->
													</tr>
												</thead>
												<tbody>
													<?php
													$sq_acc="select * from bps_podtl where lp='$sec' and kode_supp='$kdsuppi' and po_no not like '$lokasi-PO-$sec%'";
													$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
													// ECHO $sq_acc;
													$row=0;
													while($baris1=odbc_fetch_array($tb_acc)){ 
														$row++;
														$supp=odbc_result($tb_acc,"kode_supp");
														$part_no=odbc_result($tb_acc,"part_no");
														$pr_no=odbc_result($tb_acc,"pr_no");
														$no_ctrl=odbc_result($tb_acc,"no_ctrl");
														// $min_po=date("Y-m-d",strtotime(odbc_result($tb_acc,"min_po")));
														$qty=number_format(odbc_result($tb_acc,"qty"),0,".",",");

														?>	
														<tr>				
															<td >
																<div class="switch" ><label><input type="checkbox" name="plh[]" id="plh" value="<?php echo $part_no.'|'.$supp.'|'.$pr_no.'|'.$qty.'|'.$no_ctrl; ?>" onclick="dipilih(this.form);"><span class="lever"></span></label>
																</div>
															</td>
															<td><?php echo odbc_result($tb_acc,"term"); ?></td>
															<td><?php echo odbc_result($tb_acc,"periode"); ?></td>
															<td><?php echo $supp; ?></td>
															<td><?php echo $pr_no; ?></td>
															<td><?php echo $part_no; ?></td>
															<td><?php echo odbc_result($tb_acc,"part_nm"); ?></td>
															<td><?php echo odbc_result($tb_acc,"part_dtl"); ?></td>
															<td><?php echo odbc_result($tb_acc,"part_desc"); ?></td>
															<td><?php echo $qty; ?></td>
															<td><?php echo odbc_result($tb_acc,"curr")." ".number_format(odbc_result($tb_acc,"price"),0,".",","); ?></td>
															<!-- <td><?php echo $min_po; ?></td> -->
														</tr>
														<?php 
													}
													?>
													<tr class="odd gradeX">
														<td align="center" valign="middle" nowrap="nowrap"><input type="checkbox"  name="plh[]" id="plh" value="-|0|0|0|0|0|0" ></td>
														<td align="center" valign="middle" nowrap="nowrap"></td>
														<td align="center" valign="middle" nowrap="nowrap"></td>
														<td align="center" valign="middle" nowrap="nowrap"></td>
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
									</div>
								</div>
							</div>  
							<?php if(isset($_POST['cr_s']) and $row>0){ ?>
								<div class="row clearfix">	
									<div class="body">		
										<button type="submit" id="smpn_po" name="smpn_po" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>	
									</div>     
								</div> 			
							<?php } ?>
						</form>       
					</div>
				</div>
			<?php } ?>

			<div class="row clearfix">
				<div class="card">
					<div class="header">
						<h2>Print Dokumen Additional Section <?php echo $sect; ?></h2>
					</div>
					<form action="" id="frm_rmk" name="frm_rmk" method="post"  enctype="multipart/form-data">
						<div class="row clearfix">
							<div class="body">
								<div class="table-responsive">
									<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
										<thead>
											<tr>	
												<th>NO</th>
												<th>PO NO</th>
												<th>TANGGAL</th>
												<th>SUPPLIER CODE</th>
												<th>SUPPLIER</th>
												<th>LP</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sq_po="select distinct a.po_no,min(a.tgl_updt) as tgl,a.kode_supp,b.SUPP_NAME,a.lp 
											from bps_podtl a
											LEFT join lp_supp b on a.kode_supp=b.supp_code where a.lp='$sec' and po_no like '$lokasi-PO%'
											and not exists (select * from bps_kedatangan where po_no=a.po_no)
											group by a.po_no,a.kode_supp,b.SUPP_NAME,a.lp order by min(a.tgl_updt) desc";
											// ECHO $sq_po;
											$tb_po=odbc_exec($koneksi_lp,$sq_po);
											$i=0;
											while($bar_po=odbc_fetch_array($tb_po)){ $i++;
												$pono=odbc_result($tb_po,"po_no");
												$supp_code=odbc_result($tb_po,"kode_supp");
												?>	
												<tr onclick="javascript:pilih(this);" >
													<td><?php echo $i; ?></td>
													<td><?php echo $pono; ?></td>
													<td><?php echo date("d-M-Y",strtotime(odbc_result($tb_po,"tgl"))); ?></td>
													<td><?php echo $supp_code; ?></td>
													<td><?php echo odbc_result($tb_po,"SUPP_NAME"); ?></td>
													<td><?php echo odbc_result($tb_po,"lp"); ?></td>
													<td>
														<button type="button" class="btn bg-orange waves-effect" onclick="open_child('form/po/print_po.php?nomor=<?php echo $i;?>&po_no=<?php echo $pono;?>','Print PO <?php echo $pono;?>','800','500'); return false;"><i class="material-icons">print</i></button>
														<a href="##"  class="btn bg-yellow waves-effect"><i onclick="open_child('select/rev_po.php?sesi=<?php echo $lokasi;?>&sec=<?php echo $sect;?>&nodoc=<?php echo $pono;?>','Edit PO <?php echo $pono;?>','800','500'); return false;" class="material-icons">edit</i></a>
														<a href="#" class="btn bg-red waves-effect" onClick="deleteadd()" ><i class="material-icons">delete</i></a>
														<a href="Exp_xls/exp_po.php?po_no=<?php echo $pono; ?>&lp=<?= $lp; ?>" _target="blank" class="btn bg-blue waves-effect">
														<i  class="material-icons">file_download</i>
													</a>
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
	<div class="modal fade" id="mddel" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel">HAPUS PO</h4>
				</div>
				<form action="" id="frmdel" name="frmdel" method="post"  enctype="multipart/form-data">
					<div class="modal-body">
						APAKAH ANDA YAKIN INGIN MENGHAPUS
						<input type="text" readonly class="form-control" data-role="tagsinput" id="podel" name="podel" placeholder="PO NO"  required>
						<div class="modal-footer">
							<button type="submit" id="delpo" name="delpo" class="btn btn-link waves-effect">HAPUS</button>
							<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php
	if(isset($_POST['delpo']) )
	{	
		$podel=$_POST["podel"];
		$blnb=date("ymdh");
		$revpono=$sec."-".$blnb."-000";
		$updt="update bps_podtl set po_no=REPLACE(po_no,'$podel',pr_no),eta=null,status_po=null where po_no='$podel'";
		$tb_del1=odbc_exec($koneksi_lp,$updt);
		// echo $updt;
		$tb_del1=odbc_exec($koneksi_lp,"delete from bps_approve where jns_doc='ADD' and no_doc='$podel'");
	}
	"<script>alert('DATA BERHASIL DI HAPUS');</script>"
	?>
	<script>
		function pilih(row){
			var kd_pel12=row.cells[1].innerHTML;

			document.frmdel.podel.value=kd_pel12;
		}

		function deleteadd(){
			$('#mddel').modal('show');
		};
	</script>
