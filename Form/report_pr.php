<?php 
$lok=$_SESSION['lok'];
// $sect= $_SESSION["area"];
$pic=$_SESSION["nama"];
$akses=$_SESSION["akses"];
$user=$_SESSION["user"];
$pch_sec=explode("-",$sect);
$perinow=date("Ym");
?>

<script type="text/javascript">
	function dwndtl_pr(url,title,w,h){
		// var sect="<?php echo $sect; ?>";
		var sect=document.form1.sec.value;
		var term=document.form1.term.value;
		var lok="<?php echo $lok; ?>";
		var rg_tgl=document.form1.rg_tgl.value;
		var ur="Exp_xls/exp_dtl_PR1.php?s="+sect;
		if(url=="D"){
			ur="Exp_xls/exp_rkpPR.php?s="+sect+"&t="+term+"&p=''&d="+rg_tgl+"&j="+'rpt'+"&l="+lok;
		}else{
			ur="Exp_xls/exp_rkpPR.php?s="+sect+"&t="+term+"&p="+periode+"&d="+rg_tgl+"&j="+'rkp'+"&l="+lok;
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
			<h2>DOWNLOAD REPORT PR</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12">
				<div class="card">
					<div class="header">
						<h2>REPORT PR <?php echo $sect; ?><small>Download Report PR</small></h2>
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
													$tb_term=odbc_exec($koneksi_lp,"select distinct term from bps_PR order by term desc");
													$row=0;
													while($bar_term=odbc_fetch_array($tb_term)){
														$row++;
														$opt_trm=odbc_result($tb_term,"term");
														// $opt_term='<option value="'.$opt_trm.'">TERM '.$opt_trm.'</option>';
														echo '<option value="'.$opt_trm.'">TERM '.$opt_trm.'</option>';
													}
													?>
												</select>
											</div>
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label>Pilih Tanggal PR</label>
											<div class="form-line">
												<input type="text"  class="form-control" id="rg_tgl" name="rg_tgl" placeholder="Detail Pencarian" >
											</div>
										</div>
									</div>

									<?php 
									$akses=$_SESSION["akses"];
									$adm=strpos($akses,'_FA');
										if($adm1=='admin')
										{
											?> 
											<div class="col-sm-3">	
												<div class="form-group">
													<label>Section</label>
													<div class="group-line">
														<select class="selectpicker"  style="width: 100%;"  name="sec" id="sec">
															<option selected="selected" value="">-Pilih Sect-</option>
															<option value="all">ALL Sect</option>
															<?php 
															$tb_sect=odbc_exec($koneksi_lp,"select distinct sect from bps_pr order by sect asc");
															while($bar_sect=odbc_fetch_array($tb_sect))
															{
																$tsect=odbc_result($tb_sect,"sect");
																echo'<option value="'.$tsect.'">'.$tsect.'</option>';
															}
															?>
														</select>
													</div>
												</div>
											</div>
											<?php 
										} else {
											?>
											<input type="hidden" name="sec" value="<?= $sect ; ?>">
											<?php 
										}
										?> 

									<div class="col-sm-3">
										<button type="button" onclick="dwndtl_pr('D','Report PR','800','500'); return false;">Download
										</button>
										<!--script>alert('$tgl_d');</script-->
									</div>

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> 
	</div>
</section>

<script>
	function pilih(row){
		var kd_pel1=row.cells[1].innerHTML;

		document.frmdel.podel.value=kd_pel1;
	};

	$(function() {
		$('input[name="rg_tgl"]').daterangepicker({
			opens: 'left'
		}, function(start, end, label) {
			console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		});
	});

</script>