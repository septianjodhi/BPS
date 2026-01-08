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
			var ur="Exp_xls/exp_dtl_PR1.php?s="+sect;
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
				<h2>DOWNLOAD REPORT ADDITIONAL</h2>
			</div>
			<div class="row clearfix">
				<div class="col-lg-12">
					<div class="card">
						<div class="header">
							<h2>REPORT ADDITIONAL <?php echo $sect; ?>
							<small>Download Additional</small>
						</h2>
					</div>
					<div class="body">
						<div class="row clearfix">
							<div class="col-md-12">	
								<form role="form"  name="form1" id="form1" method="post" action="">

									<div class="col-sm-3">	
										<div class="form-group">
											<label>Term</label>
											<div class="group-line">
												<select class="selectpicker" name="term" id="term" required>
													<option selected="selected" value="">-Pilih Term-</option>
													<?php 
													$tb_term=odbc_exec($koneksi_lp,"select distinct term from bps_setTerm order by term desc");
													$row=0;
													while($bar_term=odbc_fetch_array($tb_term)){
														$row++;
														$opt_trm=odbc_result($tb_term,"term");
															// $opt_term='<option value="'.$opt_trm.'">TERM '.$opt_trm.'</option>';
														echo '<option value="'.$opt_trm.'">TERM '.$opt_trm.'</option>';
													}													
													?>

													?>
												</select>
											</div>
										</div>
									</div>
									<?php if($adm!== FALSE){?>
										<div class="col-sm-3">	
											<div class="form-group">
												<label>Sect</label>
												<div class="group-line">
													<select class="selectpicker"  style="width: 100%;"  name="sec" id="sec">
														<option selected="selected" value="">-Pilih Sect-</option>
														<option value="all">-All Section-</option>
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
									<?php } ?>

									<div class="col-sm-3">
										<div class="form-group">
											<label>Periode</label>
											<div class="group-line">
												<div class="form-line">
													<input type="text" class="periodeflex form-control" id="periode" name="periode" placeholder="periode">
												</div>
											</div>
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label>Pilih Tanggal Additional</label>
											<div class="form-line">
												<input type="text"  class="form-control" id="rg_tgl" name="rg_tgl" value="" >
											</div>
										</div>
									</div>

									<div class="col-sm-2">
										<button type="submit" id="cr_dt" name="cr_dt" class="btn bg-green waves-effect"><i class="material-icons">search</i></button>
										<!-- <button type="button" onclick="dwndtl_pr('D','Report PR','800','500'); return false;">search</button> -->
										<!--script>alert('$tgl_d');</script-->
									</div>											
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row clearfix">
			<div class="col-lg-12">
				<div class="card">
					<div class="header">
						<h2>Data Additional Section <?php echo $sect; ?></h2>
					</div>
					<form action="" id="frm_rmk" name="frm_rmk" method="post"  enctype="multipart/form-data">
						<div class="row clearfix">
							<div class="body">
								<div class="table-responsive">
									<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
										<thead>
											<tr>	
												<th>Sect</th>
												<th>Periode</th>
												<th>Term</th>
												<th>No_Ctrl</th>
												<th>Part No</th>
												<th>Part Nm</th>
												<th>Part Dtl</th>
												<th>Qty</th>
												<th>Uom</th>
												<th>Price</th>
												<th>Ket Chg</th>
												<th>Account</th>
												<th>Purchasing</th>
												<th>Curr</th>
												<th>Phase</th>
												<th>Add No</th>
												<th>Add Date</th>
												<th>Remark Add</th>
												<th>Pr No</th>
												<th>Pr Date</th>
												<th>Price Usd</th>
												<th>Amount Usd</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if (isset($_POST['cr_dt'])) {
												 if($adm!== FALSE){
												 	$section=$_POST['sec'];
												 	if($section=='all'){
												 		$whr_sect="";
												 	}else{
												 		$whr_sect=" and a.sect='$section' ";
												 	}												 	
												 }else{
												 	$whr_sect=" and a.sect='$sect'";
												 }

												$term=$_POST['term'];
												$periode=$_POST['periode'];
												if($periode==""){$cr_per="";}else{$cr_per=" and a.periode='$periode'";}
												$rg_tg=$_POST['rg_tgl'];
												$rg_tgl=explode("-",$rg_tg);
												$rg_tgl0=date("Y-m-d",strtotime($rg_tgl[0]))." 00:00:00";
												$rg_tgl1=date("Y-m-d",strtotime($rg_tgl[1]))." 23:59:59";
												if($rg_tgl[0]=$rg_tgl[1]){$cr_tg="";}else{$cr_tg=" and a.tgl_updt between '$rg_tgl0' 
												and '$rg_tgl1' ";}

												$sq_docadd="select a.sect,a.periode,a.term,a.no_ctrl,a.part_no,
												a.part_nm,a.part_dtl,a.qty,a.uom,a.price,a.kode_chg,a.ket_chg,
												a.account,a.lp,a.curr,a.phase,a.cccode,a.doc_no,a.doc_date,a.remark,
												b.PR_NO,b.PR_DATE,dbo.lp_konprc(a.term,'USD',a.curr,a.price) as price_USD
												from bps_budget_add a left join bps_pr b on a.no_ctrl=b.no_ctrl 
												and a.periode=b.periode
												where doc_no is not null and a.term='$term'  
												$cr_per $cr_tg $whr_sect";
												// echo $sq_docadd ;
												$tb_docadd=odbc_exec($koneksi_lp,$sq_docadd);
												
												$i=0;
												while($baris=odbc_fetch_array($tb_docadd)){ $i++;
													$docno=odbc_result($tb_docadd,"doc_no");
													?>	
													<tr>
														<td><?= $baris["sect"]; ?>
														<td><?= $baris["periode"]; ?>
														<td><?= $baris["term"]; ?>
														<td><?= $baris["no_ctrl"]; ?>
														<td><?= $baris["part_no"]; ?>
														<td><?= $baris["part_nm"]; ?>
														<td><?= $baris["part_dtl"]; ?>
														<td><?= $baris["qty"]; ?>
														<td><?= $baris["uom"]; ?>
														<td><?= $baris["price"]; ?>
														<td><?= $baris["ket_chg"]; ?>
														<td><?= $baris["account"]; ?>
														<td><?= $baris["lp"]; ?>
														<td><?= $baris["curr"]; ?>
														<td><?= $baris["phase"]; ?>
														<td><?= $baris["doc_no"]; ?>
														<td><?= $baris["doc_date"]; ?>
														<td><?= $baris["remark"]; ?>
														<td><?= $baris["PR_NO"]; ?>
														<td><?= $baris["PR_DATE"]; ?>
														<td><?= $baris["price_USD"]; ?>
														<td><?= $baris["price_USD"] * $baris["qty"]; ?>
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
	</div>
	</section>


	<script type="text/javascript">
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