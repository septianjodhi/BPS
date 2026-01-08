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
?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Purchase Requisition Budget Invest</h2>
		</div>

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>Record<small>Cari Budget untuk Pembbuatan PR Invest</small></h2>
					</div>
					<div class="row clearfix">
						<div class="body">
							<form action="" id="frmcariinvest" method="post"  enctype="multipart/form-data">
								<div class="col-sm-3">	
										<div class="form-group">
											<label>CIP NO</label>
											<div class="input-group">
												<select class="selectpicker" style="width: 100%;"  name="dt_phs" id="dt_phs" onchange="listperi()" required>
													<option selected="selected" value="">--Phase--</option>
													<?php
													$tb_phs=odbc_exec($koneksi_lp,"select distinct no_ctrl,cip_no,bud_group from bps_budget_invest where sect='$sect' and periode>=convert(nvarchar(6),getdate(),112)
														union
														select distinct no_ctrl,cip_no,bud_group from bps_budget_invest_add where sect='$sect' and periode>=convert(nvarchar(6),getdate(),112) 
														and doc_no is not null and kode_chg in (4,5) order by cip_no asc ");
													// $row=0;
													while($tb_phs_code=odbc_fetch_array($tb_phs))
													{
														// $row++;
														$no_ctrl_g=odbc_result($tb_phs,"no_ctrl");
														$phs_code=odbc_result($tb_phs,"cip_no");
														$bud_group=odbc_result($tb_phs,"bud_group");
														echo '<option value="'.$phs_code.'|'.$no_ctrl_g.'|'.$bud_group.'">CIP '.round($phs_code).' - '.$bud_group.'</option>';
													}
													?>												
												</select>
											</div>
										</div>
									</div>


									<div class="col-sm-2">	
										<div class="form-group">
											<label>Delivery Order</label>
											<select class="form-control" style="width: 100%;"  name="peri" id="peri" onchange="listcurr()" required>
											</select>
										</div>
									</div>
									
									<div class="col-sm-2">
										<div class="form-group">
											<label>Currency</label>
											<select class=" form-control" style="width: 100%;"  name="curr" id="curr" required>
											</select>
										</div>
									</div>

									<div class="col-sm-3">	
										<div class="form-group">
											<label>Optional Filter</label>
											<select class="selectpicker form-control" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
												<option selected="selected" value="">---Pilih Kolom---</option>
												<option value="part_no">PART NO</option>
												<option value="part_nm">PART NAME</option>
												<option value="part_dtl">PART DETAIL</option>
												<option value="uom">UOM</option>
												<option value="lp">PURCHASING</option>
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

		<div id="loding"></div>		
		<div id="buatpr"></div>
		<div id="tbldata"></div>
			<h2>DATA INVOICE</h2>
		</div>		
		</div>
		</section>
<div class="modal fade" id="mdplhpr" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="defaultModalLabel">List Budget Dipilih</h4>
			</div>
			<div class="modal-body">
			<form action="" id="frm_svpr" method="post"  enctype="multipart/form-data">	
				<div class="body">
					<div class="row clearfix">
						<div class="col-sm-3">
							<div class="form-group">
								<label>PR No</label>
									<div class="form-line">
									<input type="text" name="prno" id="prno"  class="form-control" disabled required>
									</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label>Kode Dept</label>
									<div class="form-line">
									<input type="text" name="kddep" id="kddep"  class="form-control" disabled required>
									</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label>PR Date</label>
								<div class="form-line">
									<input type="text" name="pr_date" id="pr_date" value="<?php echo date("Y-m-d",strtotime("now"));?>" class="form-control date_req"  required>
								</div>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="form-group">
							<label>Required Date</label>
								<div class="form-line">
									<input type="text" name="req_date" id="req_date" value="" class="form-control date_req" required placeholder="Tanggal Kedatangan" >
								</div>
							</div>
						</div>
				</div>
				<div class="row clearfix" >
					<div class="col-sm-12">
						<div class="form-group">
							<label>Remark PR</label>
							<div class="form-line">
								<input type="text" name="rmk_pr" id="rmk_pr" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="row clearfix" >
					<table id="terpilih" class="table table-striped table-bordered " cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>CIP No.</th>
							<th>Part No</th>
							<th>Desc</th>
							<th>Uom</th>
							<th>Curr</th>
							<th>Price Plan</th>
							<th>Price Quotation</th>
							<th>Purchasing</th>
							<th>Qty Order</th>
							<th>Reason</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
				</div>
				</div>
				<div class="modal-footer">
					<div class="col-sm-2">
						<div class="form-group">
							<label>Waktu Create PR</label>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<div class="form-line">
								<input type="text" name="timecreate" id="timecreate" class="form-control" disabled required>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<button type="submit"  id="smpn_pr" name="smpn_pr" class="btn bg-green waves-effect"><i class="material-icons">saves</i>Save</button>
							<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
						</div>
					</div>
					
					
				</div>
				<!-- onclick="save_pr();" -->
			</form>
			</div>
		</div>
	</div>
</div>
		<?php 
            include "form/pr/invest/pr_invest_js.php"; 
		?> 

