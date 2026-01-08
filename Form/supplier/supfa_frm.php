
<?php 
$sect= $_SESSION["area"];
$pic=$_SESSION["nama"];
error_reporting(0);

?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>SUPPLIER ORACLE FINANCE</h2>
		</div>

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2 class=" pull-left">Supplier FA
						</h2><br>
						<span>Cari Supplier FA</span>
						<button type="submit" name="kirim_ap" id="kirim_ap" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float  pull-right" onclick="show_modimport();"><i class="material-icons">control_point</i></button>

					</div>
					<div class="row clearfix">
						<div class="body">
							<form action="" id="frm_crsupp" method="post"  enctype="multipart/form-data">
									<div class="col-sm-3">	
										<div class="form-group">
											<label>Optional Filter</label>
											<select class="selectpicker form-control" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
												<option selected="selected" value="">---Pilih Kolom---</option>
												<option value="supp_code">Kode Supplier</option>
												<option value="supp_site_id">Id Supp_Site</option>
												<option value="supplier_id">Id Supplier</option>
												<option value="supplier_no">No Supplier</option>
												<option value="supplier_name">Nama Supplier</option>
												<option value="supplier_site_code">Supplier Site</option>
												<option value="accts_pay_code_combination_id">Account Pay</option>
												<option value="prepay_code_combination_id">Pre pay Code</option>
												<option value="org_id">ID Affiliate</option>
												<option value="acc_code">Code Account</option>
												<option value="kategori">Kategori</option>


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
            include "form/supplier/supfa_mod.php"; 
            include "form/supplier/suppfa_js.php"; 
		?> 

