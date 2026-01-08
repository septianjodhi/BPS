<?php 
$sect= $_SESSION["area"]; 
$pic=$_SESSION["nama"];
$akses=$_SESSION["akses"];
$user=$_SESSION["user"];
$lok=$_SESSION['lok'];
$pch_sec=explode("-",$sect);
$perinow=date("Ym");
$jns=$_GET['jns'];
$adm=strpos($akses,'ADM_FA');
if(isset($jns)){
	switch ($jns){
		case 'rpt':
		$wh=" REPORT";break;
		case 'rkp':
		$wh=" REKAP";break;
		default :
		$wh=" REPORT";break;
	}
}
?>

<script type="text/javascript">
	function dwndtl_pr(url,title,w,h){
		var sect=document.form1.sec.value;
		var lok="<?php echo $lok; ?>";
		var term=document.form1.term.value;
		var periode=document.form1.periode.value;
		
		var ur="Exp_xls/exp_dtl_PR.php?s="+sect;

		if(url=="S"){
			ur="Exp_xls/exp_rkpPR.php?s="+sect+"&t="+term+"&p="+periode+"&l="+lok+"&d=''&j="+'rkp';
		}else{
			ur="Exp_xls/exp_rkpPR.php?s="+sect+"&t="+term+"&p="+periode+"&l="+lok+"&d=''&j="+'rkp';
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
			<h2>DOWNLOAD <?php echo $wh?> PR</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12">
				<div class="card">
					<div class="header">
						<h2><?php echo $wh?> PR <?php echo $sect; ?>
						<small>Download <?php echo $wh?> PR</small></h2>

					</div>
					<div class="body">
						<div class="row clearfix">
							<div class="col-md-12">	
								<form role="form"  name="form1" id="form1" method="post" action="">

									<div class="col-sm-3">	
										<div class="form-group">
											<label>Term</label>
											<div class="group-line">
												<select class="selectpicker"  style="width: 100%;"  name="term" id="term" required>
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
										<button type="button" onclick="dwndtl_pr('S','Report PR','800','500'); return false;">Download</button>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label>Periode</label>
											<div class="group-line">
												<select class="selectpicker"  style="width: 100%;"  name="periode" id="periode">
													<option selected="selected" value="">-Pilih Periode-</option>
													<?php
													if($adm1!='admin'){
														$sql_peri="select distinct periode from bps_pr where sect='$sect' order by periode asc";
													}
													else{
														$sql_peri="select distinct periode from bps_pr 
														order by periode asc";
													}

													$tb_peri=odbc_exec($koneksi_lp,$sql_peri);
													while($baris1=odbc_fetch_array($tb_peri))
													{ 
														$peri=odbc_result($tb_peri,"periode");
														echo '<option value="'.$peri.'">'.$peri.'</option>';
													}
													?>
												</select>
											</div>
										</div>
									</div>

									<?php 
									$akses=$_SESSION["akses"];
									$adm=strpos($akses,'_FA');
										if($adm1=='admin')
										{
											?> 
											<div class="col-sm-2">	
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
//alert(kd_pel1)
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