<?php 
$sect= $_SESSION["area"]; 
$pic=$_SESSION["nama"];
$akses=$_SESSION["akses"];
$user=$_SESSION["user"];
$pch_sec=explode("-",$sect);
$perinow=date("Ym");
?>
<script type="text/javascript">
	function dwndtl_pr(url,title,w,h){
		var sect="<?php echo $sect; ?>";
		var term=document.form1.term.value;
		var rg_tgl=document.form1.rg_tgl.value;
		if(url=="D"){
			ur="Exp_xls/exp_rkpPR.php?s="+sect+"&t="+term+"&p=''&d="+rg_tgl+"&j="+'rpt';
		}else{
			ur="Exp_xls/exp_rkpPR.php?s="+sect+"&t="+term+"&p="+periode+"&d="+rg_tgl+"&j="+'rkp';
		}
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(ur, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};
</script>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>DOWNLOAD REPORT VOUCEHR PAYING</h2>
		</div>
		<div class="row clearfix">
			<div class="card">
				<div class="header">
					<h2>REPORT VP <?php echo $sect; ?><small>Download Report VP</small></h2>
				</div>
				<div class="body">
					<div class="row clearfix">
						<div class="col-md-12">	
							<form role="form"  name="form1" id="form1" method="post" action="">
								<div class="row clearfix">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Term</label>
											<div class="group-line">
												<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="term" id="term">
													<option selected="selected" value="">-Pilih Term-</option>
													<?php 
													$tb_term=odbc_exec($koneksi_lp,"select distinct term from bps_PR order by term desc");
													$row=0;
													while($bar_term=odbc_fetch_array($tb_term)){
														$row++;
														$opt_trm=odbc_result($tb_term,"term");
														echo '<option value="'.$opt_trm.'">TERM '.$opt_trm.'</option>';
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-3">	
										<div class="form-group">
											<label>Periode Budget</label>
											<div class="form-line">
												<input type="number" class="periodemn form-control" id="peri" name="peri" value="" placeholder="Periode Plan">
											</div>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="form-group">
											<label>Pilih Range Tanggal</label>
											<div class="form-line">
												<input type="text"  class="rg_tgl form-control" id="rg_tgl" name="rg_tgl" placeholder="Detail Pencarian" >
											</div>
										</div>
									</div>
									<div class="col-sm-2">
										<button type="submit" id="cr_vp" name="cr_vp" class="btn bg-green waves-effect"><i class="material-icons">search</i></button>
									</div>
								</div>
								<div class="row clearfix">
									<?php 
									if($sect=='FA-FIN'){
										?>
										<div class="col-sm-3">	
											<div class="form-group">
												<label>Section</label>
												<div class="group-line">
													<select class="selectpicker"  style="width: 100%;"  name="sec" id="sec">
														<option selected="selected" value="">-Pilih Sect-</option>
														<?php 
														$tb_sect=odbc_exec($koneksi_lp,"select distinct sect from bps_pr order by sect asc");
														while($bar_sect=odbc_fetch_array($tb_sect)){
															$tsect=odbc_result($tb_sect,"sect");
															echo'<option value="'.$tsect.'">'.$tsect.'</option>';
														}
														?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-sm-3">	
											<div class="form-group">
												<label>Purchasing</label>
												<div class="group-line">
													<select class="selectpicker"  style="width: 100%;"  name="lp" id="lp">
														<option selected="selected" value="">-Pilih Purchasing-</option>
														<?php 
														$tb_lp=odbc_exec($koneksi_lp,"select distinct lp from bps_tmpPR order by lp asc");
														while($bar_lp=odbc_fetch_array($tb_lp)){
															$tlp=odbc_result($tb_lp,"lp");
															echo'<option value="'.$tlp.'">'.$tlp.'</option>';
														}
														?>
													</select>
												</div>
											</div>
										</div>
										<?php 
									}
									?>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div> 

		<div class="row clearfix">
			<div class="card">
				<form action="" id="frm1" name="frm1" method="post"  enctype="multipart/form-data">
					<div class="header">
						<h2>Record Voucher Paying ( VP )</h2>
					</div>
					<div class="row clearfix">
						<div class="body">
							<div class="table-responsive">
								<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
									<thead>
										<tr>
											<th>No.</th>
											<th>Section</th>
											<th>PR Date</th>
											<th>PR No</th>
											<th>Part No.</th>
											<th>Phase</th>											
											<th>Description</th>
											<th>Account</th>
											<th>Fiscal</th>
											<th>Supp Code</th>
											<th>Supp Name</th>
											<th>Qty Order</th>
											<th>UoM</th>											
											<th>Price Order</th>
											<th>Amount Order</th>
											<th>PO No.</th>
											<th>PO Date</th>
											<th>Inv No</th>
											<th>Inv Date</th>
											<th>No Faktur pajak</th>
											<th>CV Code</th>
											<th>Carline</th>
											<th>Periode Budget</th>
											<th>Tanggal Datang</th>
											<th>Qty RCV</th>
											<th>Price RCV</th>
											<th>Amount RCV</th>
											<th>Description Upload</th>
											<th>Purchasing</th>
											<th>Curr</th>
											<th>VP No</th>
											<th>PPH</th>
											<th>PPN</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if(isset($_POST['cr_vp']))
										{
											if($sect=='FA-FIN')
											{
												$lp=$_POST['lp'];
												$sec=$_POST['sec'];
												
												$cr_lp="";
												if($lp!=""){$cr_lp=" and a.lp='$lp' ";}
												if($sec==""){
													$cr_sect="";
												}else{
													$cr_sect=" and e.sect='$sec'";
												}
											}
											else{
												$cr_sect=" and e.sect='$sect'"; 
												$cr_lp="";
											}

											$peri=$_POST['peri'];
											if($peri==""){
												$cr_peri="";
											}else{
												$cr_peri=" and b.periode='$peri'";
											}

											$term=$_POST['term'];
											if($term==""){
												$cr_term="";
											}else{
												$cr_term=" and b.term='$term'";
											}

											$rg_tg=$_POST['rg_tgl'];
											$rg_tgl=explode("-",$rg_tg);
											$rg_tgl0=date("Y-m-d",strtotime($rg_tgl[0]));
											$rg_tgl1=date("Y-m-d",strtotime($rg_tgl[1]));
											if($rg_tgl0==$rg_tgl1){
												$cr_tgl="";
											}else{
												$cr_tgl=" and a.rcv_inv_date between '$rg_tgl0' and '$rg_tgl1'";
											}

											$lht_dt="select distinct b.term,a.sect_to, b.pr_date, a.pr_no, b.phase, a.part_no,a.part_nm, a.part_dtl, a.part_desc,
											a.account,a.kode_supp, d.supp_name,a.qty,a.uom,a.curr,a.price, a.qty*a.price as amount,a.po_no,
											convert(nvarchar,ISNULL(c.tgl_updt,b.pr_date),23) as po_date, a.inv_no, a.inv_tgl, a.faktur_pajak,b.cccode,
											f.CARLINE, b.periode, a.qty_dtg,isnull(a.rcv_inv_date,a.inv_tgl) as tgl_dtg,a.qty_dtg, a.lp,a.no_ctrl,
											vp_no,a.pph,a.ppn,a.fiscal from bps_kedatangan a 
											left join bps_tmpPR b on a.pr_no=b.pr_no and a.no_ctrl=b.no_ctrl
											left join bps_podtl c on a.pr_no=c.pr_no and a.no_ctrl=c.no_ctrl and a.po_no=c.po_no and a.qty=c.qty
											left join lp_supp d on a.kode_supp=d.supp_code 
											left join bps_vp e on a.inv_no=e.inv_no and a.po_no=e.po_no
											left join LP_CV f on b.cccode=f.CV_CODE and b.term=f.TERM
											where a.no_ctrl is not null $cr_tgl $cr_sect $cr_peri $cr_term $cr_lp 
											group by b.term,a.sect_to, b.pr_date, a.pr_no, b.phase, a.part_no,a.part_nm, a.part_dtl, a.part_desc,
											a.account,a.kode_supp, d.supp_name,a.qty,a.uom,a.curr,a.price, a.qty*a.price,a.po_no, a.inv_no, a.inv_tgl, a.faktur_pajak,b.cccode,
											f.CARLINE, b.periode, a.qty_dtg,a.qty_dtg, a.lp,a.no_ctrl,a.pph,a.ppn,c.tgl_updt,a.rcv_inv_date,vp_no,a.fiscal
											order by sect_to asc";
											 // and a.qty=b.qty_act
											//echo $lht_dt;
											$tb_vp=odbc_exec($koneksi_lp,$lht_dt);
											$i=0;
											while($bar_vp=odbc_fetch_array($tb_vp))
											{
												$i++;
												$desc=$bar_vp["part_nm"]." ".$bar_vp["part_dtl"]." ".$bar_vp["part_desc"];
												$qty=$bar_vp["qty"];
												$qty_dtg=$bar_vp["qty_dtg"] ;
												?>	
												<tr>
													<td><?= $i ; ?></td>
													<td><?= $bar_vp["sect_to"] ; ?></td>
													<td><?= date("Y-m-d",strtotime($bar_vp["pr_date"]))   ; ?></td>
													<td><?= $bar_vp["pr_no"] ; ?></td>
													<td><?= $bar_vp["part_no"] ; ?></td>
													<td><?= $bar_vp["phase"] ; ?></td>													
													<td><?= $desc ; ?></td>
													<td><?= $bar_vp["account"] ; ?></td>
													<td><?= $bar_vp["fiscal"] ; ?></td>
													<td><?= $bar_vp["kode_supp"] ; ?></td>
													<td><?= $bar_vp["supp_name"] ; ?></td>
													<td><?= $bar_vp["qty"] ; ?></td>
													<td><?= $bar_vp["uom"] ; ?></td>													
													<td><?= $bar_vp["price"] ; ?></td>
													<td><?= $bar_vp["amount"] ; ?></td>
													<td><?= $bar_vp["po_no"] ; ?></td>
													<td><?= $bar_vp["po_date"] ; ?></td>
													<td><?= $bar_vp["inv_no"] ; ?></td>
													<td><?= $bar_vp["inv_tgl"] ; ?></td>
													<td><?= $bar_vp["faktur_pajak"] ; ?></td>
													<td><?= $bar_vp["cccode"] ; ?></td>
													<td><?= $bar_vp["CARLINE"] ; ?></td>
													<td><?= $bar_vp["periode"] ; ?></td>
													<td><?= $bar_vp["tgl_dtg"] ; ?></td>
													<td><?= $bar_vp["qty_dtg"] ; ?></td>
													<td><?= $bar_vp["price"] ; ?></td>
													<td><?= $qty_dtg*$bar_vp["price"] ; ?></td>
													<td><?= number_format($qty_dtg)." ".$bar_vp["uom"]." ".$desc ; ?></td>
													<td><?= $bar_vp["lp"] ; ?></td>
													<td><?= $bar_vp["curr"] ; ?></td>
													<td><?= $bar_vp["vp_no"] ; ?></td>
													<td><?= $bar_vp["pph"] ; ?></td>
													<td><?= $bar_vp["ppn"] ; ?></td>
												</tr>	
												<?php
											}
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

<script>
	$(function() {
		$('.rg_tgl').daterangepicker({
			opens: 'left'
		}, function(start, end, label) {
			console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		});
	});

	$(document).ready(function()
	{
		$('.periodemn').bootstrapMaterialDatePicker({
			format: 'YYYYMM', Date : new Date(),
			clearButton: true,
			weekStart: 0,
			time: false
		});	
		$('.date_req').bootstrapMaterialDatePicker({
			format: 'YYYY-MM-DD',
			clearButton: true,
			weekStart: 0,
			time: false
		});	
	});
</script>