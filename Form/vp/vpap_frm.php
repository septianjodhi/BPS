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


<?php 
$sect= $_SESSION["area"];
$pic=$_SESSION["nama"];
error_reporting(0);
/*Cari term*/
$sqlcrterm="select top 1 * from bps_setTerm  where start_term<=getdate() and finish_term>=getdate()";
$termnow='0';
$tb_trm=odbc_exec($koneksi_lp,$sqlcrterm);
while($bar_trm=odbc_fetch_array($tb_trm))
{
$termnow=odbc_result($tb_trm,"term");
}
?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>ACCOUNT PAY <?= $termnow;?></h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2 class=" pull-left">Record
						</h2><br>
						<span>Cari AP</span>
						<button type="button" name="kirim_ap" id="kirim_ap" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float  pull-right" onclick="$('#mdplhvp').modal('show');">AP</button>

					</div>
					<div class="row clearfix">
						<div class="body">
							<form action="" id="frm_crap" method="post"  enctype="multipart/form-data">
								<div class="col-sm-3">	
										<div class="form-group">
											<label>Term</label>
											<div class="input-group">
												<select  class="form-control" style="width: 100%;"  name="ap_term" id="ap_term" onchange="list_peri();" required>
													<option selected="selected" value="">--Term--</option>
													<?php
													$tb_phs=odbc_exec($koneksi_lp,"select distinct term from bps_setTerm ");
													// $row=0;
													while($tb_phs_code=odbc_fetch_array($tb_phs))
													{
														$trmplh=odbc_result($tb_phs,"term");
														echo '<option value="'.$trmplh.'">Term '.$trmplh.'</option>';
													}
													?>												
												</select>
											</div>
										</div>
									</div>


									<div class="col-sm-2">	
										<div class="form-group">
											<label>Periode</label>
											<select class="form-control" style="width: 100%;"  name="ap_peri" id="ap_peri" required>
												<option value=''>Pilih Periode</option>
											</select>
										</div>
									</div>
									

									<div class="col-sm-3">	
										<div class="form-group">
											<label>Optional Filter</label>
											<select class="selectpicker form-control" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
												<option selected="selected" value="">---Pilih Kolom---</option>
												<option value="vp_no">VP</option>
												<option value="inv_no">Invoice</option>
												<option value="supp_code">Kode Supp</option>
												<option value="file_send">Nama File</option>
											</select>
										</div>
									</div>

									<div class="col-sm-2">	
										<div class="form-group">
											<label>Detail Filter</label>
											<div class="form-line">
												<input type="text" class="form-control" data-role="tagsinput" id="txt_cari" name="txt_cari" placeholder="Detail Pencarian">
											</div> 
										</div>
									</div>

									<div class="col-sm-2">
										<button type="submit" name="cr_b" id="cr_b" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">search</i> </button>
										<button type="reset" name="reset" id="reset" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">clear</i> </button>
									</div>
								</form>
							</div>	
						</div>
					</div>
				</div>
			</div>

		<div id="loding" class="row clearfix"></div>	
		<div id="tbllist" class="row clearfix"></div>
		<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		            <div class="card">
						<div id="tbldata"></div>	
					</div>
				</div>		
			</div>
		</div>
		</section>

		<?php 
            include "form/vp/ap_mod.php"; 
            include "form/vp/ap_js.php"; 
		?> 

