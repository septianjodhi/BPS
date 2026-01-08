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
$tbl_po="bps_podtl";

if(isset($_POST['delpo']) ){	
	$podel=$_POST["podel"];
	$tb_del1=odbc_exec($koneksi_lp,"delete from $tbl_po where pr_no='$prno' and po_no='$podel' ");
	// $tb_del1=odbc_exec($koneksi_lp,"delete from bps_approve where jns_doc='PO' and no_doc='$podel'");
}
?>

<?php
if(isset($_POST['smpn_po'])){
	$pph=$_POST['pph'];
	$ppn=$_POST['ppn'];	
	$blnds=date("ymds");
	$bln=date("ym");
	$blnth=date("Ym");
	$eta=$_POST['eta_po'];
	$periode=$_POST['periode'];
	$plh=$_POST['plh'];

	$insert_po="INSERT INTO $tbl_po ( no_quo,kode_supp,pr_no,part_no,part_nm,part_dtl,part_desc,po_no,eta,pic_updt,tgl_updt,qty,price,lp,term,periode,curr,uom,account,cccode,no_ctrl,status_po,ppn,pph)";
// ============================================
	
	$supcap="SELECT distinct supp_code from bps_suppcapacity where periode='$periode' and lp='$sec'";
	$qry_supp=odbc_exec($koneksi_lp,$supcap);
	$i=0;
	while($baris_supp=odbc_fetch_array($qry_supp)){
		$i++;
		$supp_code=$baris_supp["supp_code"];

		$qry_nopo="SELECT isnull(max(RIGHT(po_no,3)),0) as jj from $tbl_po where lp='$sec' and kode_supp='$supp_code' and convert(nvarchar(6),tgl_updt,112)='$blnth'";
		
		$tb_nopo=odbc_exec($koneksi_lp,$qry_nopo);
		$nopo=odbc_result($tb_nopo,"jj");

		$nopo=$nopo+1;	
		$nopo3=substr('000'.$nopo,-3);
		$po_no="PO-".$sec."-".$supp_code.$bln."-".$nopo3;
		// echo $po_no."<br>";

		foreach ($plh as $_boxValue2){
			$np2=explode("|",$_boxValue2);			
		}

		$data_pr="SELECT no_ctrl,part_no,qty_act from bps_tmpPR where pr_no='$np2[0]' and lp='$sec' ";
		$qry_pr=odbc_exec($koneksi_lp,$data_pr);
		// echo $data_pr."<br>";

		while($baris_part=odbc_fetch_array($qry_pr)){
			$part_no=$baris_part["part_no"];
			$qty_act=$baris_part["qty_act"];

			$cr_percap="SELECT count(*) as jml from bps_suppcapacity where part_no='$part_no' and lp='$sec' and periode='$periode' ";

			$qry_jmlsupp=odbc_exec($koneksi_lp,$cr_percap);
			// echo $cr_percap."<br>";
			$jml_sup=odbc_result($qry_jmlsupp, "jml");
			$sisa_qty=$qty_act%$jml_sup;
			$qty_order=($qty_act-$sisa_qty)/$jml_sup;

			// echo $i." - ".$part_no." qty=".$sisa_qty."<br>";
			$cr_prioritas=odbc_exec($koneksi_lp,"SELECT prioritas from bps_suppcapacity where part_no='$part_no' and lp='$sec' and periode='$periode' and supp_code='$supp_code' ");
			$prioritas=odbc_result($cr_prioritas, "jml");

			if($i<=$sisa_qty and $sisa_qty>0 ){
				$qty_po=$qty_order+1;
			}else{
				$qty_po=$qty_order;
			}

			$query_pr2="SELECT distinct no_quo,'$supp_code' as kode_supp,pr_no,a.part_no,a.part_nm,a.part_dtl,
			part_desc,'$po_no' as po_no,'$eta' as eta, '$pic' as pic_updt,
			getdate() as tgl_updt,$qty_po as qty,
			price_tot as price,a.lp,a.term, a.periode,curr,uom, account,cccode,no_ctrl,'OPEN' as status_po,
			$ppn as ppn,$pph as pph
			from bps_tmpPR a
			inner join bps_suppcapacity b on a.part_no=b.part_no and a.lp=b.lp and a.periode=b.periode
			where a.pr_no='$np2[0]' and supp_code='$supp_code' and a.lp='$sec' and a.part_no='$part_no'
			and penawaran='YES' and a.periode='$periode'
			group by no_quo,pr_no,a.part_no,a.part_nm,a.part_dtl,a.part_desc,qty_act,price_tot,a.lp,a.term,a.periode,curr,uom,account,cccode,no_ctrl,prioritas,kapasitas,a.kode_supp";

			$tb_insert=odbc_exec($koneksi_lp,$insert_po." ".$query_pr2);

			$qry_delaprv="delete from bps_approve where jns_doc='PO' and no_doc='$po_no'";
			$tb_delaprv=odbc_exec($koneksi_lp,$qry_delaprv);
			$qry_adaprv="insert into bps_approve(pic_plan,email_plan,no_doc,tgl_prepaire,jns_doc,sect,initial,approve,no_aprv) SELECT nama as pic_plan,email as email_plan,'$po_no' as no_doc,getdate() as tgl_prepaire,'PO',sect,initial,approve,no_aprv  FROM bps_setApprove where jns_dok='PO' and status_akun='aktif'  and (sect='$sect' or sect='$dept-ALL' or sect='SAMI-ALL')";
			$tb_delaprv=odbc_exec($koneksi_lp,$qry_adaprv);
			// echo $query_pr2."<br>";
			// echo $insert_po." ".$query_pr2."<br>";
		}

		// $i++;
	}

	// ============================================
	// echo "<script>alert('$pph');</script>";
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
										<label>Pilih Periode PR</label>
										<div class="form-line">
											<!-- <input type="text"  class="form-control" id="rg_tgl" name="rg_tgl" placeholder="Detail Pencarian" required> -->
											<!-- <input type="number" class="periode form-control" id="periodemn" name="periodemn" value="<?php echo date("Ym"); ?>" placeholder="Periode" required> -->
											<select class="selectpicker" name="periode" id="periode" required>
												<option selected="selected" value="">-Pilih Periode-</option>
												<?php 
												$tb_term=odbc_exec($koneksi_lp,"SELECT distinct periode from bps_tmpPR where lp='$sec' and penawaran='YES' and periode>=convert(nvarchar(6), getdate(), 112) order by periode desc");
												$row=0;
												while($bar_term=odbc_fetch_array($tb_term)){
													$row++;
													$opt_trm=odbc_result($tb_term,"periode");
														// $opt_term='<option value="'.$opt_trm.'">TERM '.$opt_trm.'</option>';
													echo '<option value="'.$opt_trm.'">'.$opt_trm.'</option>';
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-2">
									<button type="submit" name="cr_s" id="cr_s" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">search</i></button>
									<button type="reset" name="reset" id="reset" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">clear</i> </button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<?php
		if(isset($_POST['cr_s'])){
			$period=$_POST['periode'];
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
										<label>Periode</label>
										<div class="form-line">
											<input type="text" readonly name="periode" id="periode" value="<?php echo $period; ?>" class="form-control"  required>
										</div>
									</div>
								</div>
								<div class="col-sm-2">	
									<div class="form-group">
										<label>PO Date</label>
										<div class="form-line">
											<input type="date" name="po_date" id="po_date" value="<?php echo date("Y-m-d");?>" class="form-control date-min"  required>
										</div>
									</div>
								</div>
								<div class="col-sm-2">	
									<div class="form-group">
										<label>ETA SAMI</label>
										<div class="form-line">
											<input type="date" name="eta_po" id="eta_po" class="form-control date-min" value="<?php echo date("Y-m-d");?>" required>
										</div>
									</div>
								</div>
								<div class="col-sm-2">	
									<div class="form-group">
										<label>PPN</label>
										<div class="form-line">
											<select class="selectpicker" style="width: 100%;"  name="ppn" id="ppn" >
												<option selected="selected" value="0">---Pilih Nominal---</option>
												<option value="0">0%</option>
												<option value="10">10%</option>
											</select>
										</div>
									</div>
								</div> 
								<div class="col-sm-2">	
									<div class="form-group">
										<label>PPH</label>
										<div class="form-line">
											<select class="selectpicker" style="width: 100%;"  name="pph" id="pph" >
												<option selected="selected" value="0">---Pilih Nominal---</option>
												<option value="0">0%</option>
												<option value="2">2%</option>
												<option value="3">3%</option>
												<option value="4">4%</option>
												<option value="5">5%</option>
											</select>
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
													<th width="10%">PILIH PR</th>
													<th>PR NO</th>
													<th>PR DATE</th>
													<th>AMOUNT</th>
													<th>SECT</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$rg_tg=$_POST['rg_tgl'];
												$rg_tgl=explode("-",$rg_tg);
												$rg_tgl0=date("Y-m-d",strtotime($rg_tgl[0]));
												$rg_tgl1=date("Y-m-d",strtotime($rg_tgl[1]));
												$whr=" AND b.pr_date BETWEEN '".$rg_tgl0."' AND '".$rg_tgl1."'";
												$whr2=" AND b.pr_date=convert(varchar, getdate(), 23)";
												if($rg_tg==''){$cr_date=$whr2;}else{$cr_date=$whr;}

												$sq_pr="SELECT a.periode,b.sect,b.pr_date,a.pr_no,sum(b.Qty*b.price) as amn,
												isnull((select sum(qty*price) from $tbl_po where pr_no=a.pr_no and eta is not null),0) as amn_po from bps_tmpPR a left join bps_pr b on a.pr_no=b.PR_NO and a.no_ctrl=b.no_ctrl
												where a.periode='$period' and 
												part_no in (select part_no from bps_suppcapacity where periode='$period' and lp='$sec')
												group by a.periode,b.sect,a.pr_no,b.pr_date
												having sum(b.Qty*b.price)>isnull((select sum(qty*price) from $tbl_po where pr_no=a.pr_no and eta is not null),0)";
													// echo $sq_pr;
												$tb_pr=odbc_exec($koneksi_lp,$sq_pr);
												$i=0;
												while($bar_pr=odbc_fetch_array($tb_pr)){ 
													$prno=odbc_result($tb_pr,"pr_no");
													$remark=odbc_result($tb_pr,"remark");
													$i++;
													?>	
													<tr>
														<td>
															<div class="switch" ><label><input type="checkbox" name="plh[]" id="plh" value="<?php echo $prno.'|'.$periode; ?>" >
																<span class="lever"></span></label>
															</div>
														</td>
														<td width="15%"><?php echo $prno; ?></td>
														<td width="10%"><?php echo date("Y-m-d",strtotime(odbc_result($tb_pr,"pr_date"))); ?></td>
														<td><?php echo number_format(odbc_result($tb_pr,"amn"),2,".",","); ?></td>
														<td width="10%"><?php echo odbc_result($tb_pr,"sect"); ?></td>
													</tr>	
													<?php 
												}
												?>
												<tr class="odd gradeX">
													<td align="center" valign="middle" nowrap="nowrap"><input type="checkbox" value="-|0|0|0|0|0|0" ></td>
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
					<h2>Print Purchase Order (PO)</h2>
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
										$period_old=date("Ym")-1;
										$sq_po="SELECT distinct a.po_no,min(a.tgl_updt) as tgl,a.kode_supp,b.SUPP_NAME,a.lp from bps_podtl a
										left join lp_supp b on a.kode_supp=b.supp_code inner join bps_suppcapacity c on a.kode_supp=c.supp_code and c.periode=a.periode  where a.lp='$sec' and po_no like 'PO%' and (a.periode>=convert(nvarchar(6),getdate(),112) or a.periode='$period_old') group by a.po_no,a.kode_supp,b.SUPP_NAME,a.lp order by min(a.tgl_updt) desc";
										$tb_po=odbc_exec($koneksi_lp,$sq_po);
										$i=0;
										while($bar_po=odbc_fetch_array($tb_po)){ $i++;
											$pono=odbc_result($tb_po,"po_no");
											$supp_code=odbc_result($tb_po,"kode_supp");
											$lp=odbc_result($tb_po,"lp");
											?>	
											<tr onclick="javascript:pilih(this);" >
												<td><?php echo $i; ?></td>
												<td><?php echo $pono; ?></td>
												<td><?php echo date("d-M-Y",strtotime(odbc_result($tb_po,"tgl"))); ?></td>
												<td><?php echo $supp_code; ?></td>
												<td><?php echo odbc_result($tb_po,"SUPP_NAME"); ?></td>
												<td><?= $lp; ?></td>
												<td>
													<a href="##" class="btn bg-orange waves-effect"><i onclick="open_child('Exp_pdf/print_po.php?nomor=<?php echo $i;?>&po_no=<?php echo $pono;?>','Print PO <?php echo $pono;?>','800','500'); return false;" class="material-icons">print</i></a>
													<a href="#" onClick="deletepo()" class="btn bg-red waves-effect"><i  class="material-icons">delete</i></a>
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

<div class="modal fade" id="mddel" tabindex="1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">HAPUS PO</h4></div>
			<form action="" id="frmdel" name="frmdel" method="post"  enctype="multipart/form-data">
				<div class="modal-body">
					APAKAH ANDA YAKIN INGIN MENGHAPUS PO <input type="text" readonly class="form-control" data-role="tagsinput" id="podel" name="podel" placeholder="PO NO" required>
					<div class="modal-footer">
						<button type="submit" id="delpo" name="delpo" class="btn btn-link waves-effect">HAPUS</button>
						<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


			<?php /*
			if(isset($_POST['cr_p'])){
				$period=$_POST['periode'];
				?>
				<div class="row clearfix">
					<div class="card">
						<form action="" id="form1" name="form1" method="post"  enctype="multipart/form-data">			
							<div class="row clearfix">
								<input type="hidden" name="periode" id="periode" value="<?= $periode ;?>">
								<div class="body">
									<div class="col-sm-3">	
										<div class="form-group">
											<label>PO Date</label>
											<div class="form-line">
												<input type="date" name="po_date" id="po_date" value="<?php echo date("Y-m-d");?>" class="form-control date-min"  required>
											</div>
										</div>
									</div>
									<div class="col-sm-3">	
										<div class="form-group">
											<label>ETA SAMI</label>
											<div class="form-line">
												<input type="date" name="eta_po" id="eta_po" class="form-control date-min"  value="<?php echo date("Y-m-d");?>" required>
											</div>
										</div>
									</div>
									<div class="col-sm-3">	
										<div class="form-group">
											<label>PPN</label>
											<div class="form-line">
												<select class="selectpicker" style="width: 100%;"  name="ppn" id="ppn" >
													<option selected="selected" value="0">0%</option>
													<option value="10">10%</option>
												</select>
											</div>
										</div>
									</div> 
									<div class="col-sm-3">	
										<div class="form-group">
											<label>PPH</label>
											<div class="form-line">
												<select class="selectpicker" style="width: 100%;"  name="pph" id="pph" >
													<option selected="selected" value="0">0%</option>
													<option value="2">2%</option>
													<option value="3">3%</option>
													<option value="4">4%</option>
													<option value="5">5%</option>
												</select>
											</div>
										</div>
									</div> 
								</div>
							</div>

							<div class="table-wrapper-scroll-y my-custom-scrollbar	">
								<table id="example" class="table table-bordered table-striped table-hover dataTable tabel2">
									<thead>
										<tr>	
											<th width="10%">PILIH PR</th>
											<th>PR NO</th>
											<th>PR DATE</th>
											<th>AMOUNT</th>
											<th>SECT</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$rg_tg=$_POST['rg_tgl'];
										$rg_tgl=explode("-",$rg_tg);
										$rg_tgl0=date("Y-m-d",strtotime($rg_tgl[0]));
										$rg_tgl1=date("Y-m-d",strtotime($rg_tgl[1]));
										$whr=" AND b.pr_date BETWEEN '".$rg_tgl0."' AND '".$rg_tgl1."'";
										$whr2=" AND b.pr_date=convert(varchar, getdate(), 23)";
										if($rg_tg==''){$cr_date=$whr2;}else{$cr_date=$whr;}

											// $sq_pr="SELECT a.periode,b.sect,b.pr_date,a.pr_no,sum(b.Qty*b.price) as amn,
											// isnull((select sum(qty*price) from $tbl_po where pr_no=a.pr_no and eta is not null),0) as amn_po
											// from bps_tmpPR a left join bps_pr b on a.pr_no=b.PR_NO and a.no_ctrl=b.no_ctrl
											// where a.periode='$period' and 
											// part_no in (select part_no from bps_suppcapacity where periode='$period' and lp='$sec')
											// group by a.periode,b.sect,a.pr_no,b.pr_date
											// having sum(b.Qty*b.price)>isnull((select sum(qty*price) from $tbl_po where pr_no=a.pr_no and eta is not null),0)";

										$sq_pr="SELECT a.periode,b.sect,b.pr_date,a.pr_no,sum(b.Qty*b.price) as amn,
										isnull((select sum(qty*price) from $tbl_po where pr_no=a.pr_no and eta is not null),0) as amn_po
										from bps_tmpPR a left join bps_pr b on a.pr_no=b.PR_NO and a.no_ctrl=b.no_ctrl
										where a.periode='$period' and 
										part_no in (select part_no from bps_suppcapacity where periode='$period' and lp='$sec')
										group by a.periode,b.sect,a.pr_no,b.pr_date
										having sum(b.Qty*b.price)>isnull((select sum(qty*price) from $tbl_po where pr_no=a.pr_no and eta is not null),0)";

										echo $sq_pr;
										$tb_pr=odbc_exec($koneksi_lp,$sq_pr);
										$i=0;
										while($bar_pr=odbc_fetch_array($tb_pr)){ 
											$prno=odbc_result($tb_pr,"pr_no");
											$remark=odbc_result($tb_pr,"remark");
											$i++;
											?>	
											<tr>
												<td>
													<div class="switch" ><label><input type="checkbox" name="plh[]" id="plh" value="<?php echo $prno.'|'.$periode; ?>" >
														<span class="lever"></span></label>
													</div>
												</td>
												<td width="15%"><?php echo $prno; ?></td>
												<td width="10%"><?php echo date("Y-m-d",strtotime(odbc_result($tb_pr,"pr_date"))); ?></td>
												<td><?php echo number_format(odbc_result($tb_pr,"amn"),2,".",","); ?></td>
												<td width="10%"><?php echo odbc_result($tb_pr,"sect"); ?></td>
											</tr>	
											<?php 
										}
										?>
										<tr class="odd gradeX">
											<td align="center" valign="middle" nowrap="nowrap"><input type="checkbox" value="-|0|0|0|0|0|0" ></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="body">	
								<button type="submit" id="smpn" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>Save</button>	
							</div>
						</form>					
					</div>
				</div>
			<?php } ?>


*/ ?>
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
				</form>
			</div>
		</div>
	</div>
</div>


<script>
	function pilih(row){
		var kd_pel1=row.cells[1].innerHTML;

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

</script>
