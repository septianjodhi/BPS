<?php 
$pic_updt=$_SESSION['nama'];
$sect=$_SESSION["area"];
$user=$_SESSION["user"];
?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>BUDGET INVEST</h2>
		</div>

		<div class="row clearfix">
			<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Manual Input Budget Invest</small></h2>
					</div>
					<div class="body">
						<form name="form1" id="form1" method="post" action="">						
							<div class="row clearfix">
								<div class="col-md-12">
									<div class="col-md-3">
										<div class="form-group">
											<label>No Control</label>
											<div class="form-line">
												<input type="text" class="form-control" name="no_ctrl" id="no_ctrl" required readonly>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Term</label>
											<div class="form-line">
												<input type="text" class="form-control" name="term" id="term" required>
											</div>
											<?php /*
											<div class="input-group">
												<select class="selectpicker" style="width: 100%;"  data-live-search="true" name="term" id="term"  required>
													<option selected="selected" value="">---Pilih Term---</option>
													<?php
													$qterm="select distinct term from bps_setterm order by term desc";
													$tb_qterm=odbc_exec($koneksi_lp,$qterm);
													$opt_term="";
													while($bar_qterm=odbc_fetch_array($tb_qterm)){
														$term=odbc_result($tb_qterm,"term");
														$opt_term=$opt_term.'<option value="'.$term.'">'.$term.'</option>';
													}
													echo $opt_term;
													?>
												</select> 
												</div>
												*/?>											
											</div>
										</div>
										<!-- <div class="col-md-3">
											<div class="form-group">
												<label>Sub Term</label>
												<div class="input-group">
													<select class="selectpicker" style="width: 100%;"  name="subterm" id="subterm"  required>
														<option selected="selected" value="">---Pilih Sub Term---</option>
														<option>7-12</option>
														<option>1-6</option>
													</select>
												</div>
											</div>
										</div> -->
										<div class="col-md-3">				
											<div class="form-group">
												<label>Sect</label>
												<div class="form-line">
													<input type="text" class="form-control" name="sect" id="sect" required>
												</div>
											<?php /*
												<div class="input-group">
													<select  class="selectpicker" style="width: 100%;" data-live-search="true" name="sect" id="sect"  required>
														<option selected="selected" value="">---Pilih Sect---</option>
														<?php
														$qsect="select distinct sect from bps_budget_invest order by sect asc";
														$tb_qsect=odbc_exec($koneksi_lp,$qsect);
														$opt_sect="";
														while($bar_qsect=odbc_fetch_array($tb_qsect)){
															$sec=odbc_result($tb_qsect,"sect");
															$opt_sect=$opt_sect.'<option value="'.$sec.'">'.$sec.'</option>';
														}
														echo $opt_sect;
														?>
													</select>
												</div>
												*/?>
											</div>
										</div>
										<div class="col-md-3">				
											<div class="form-group">
												<label>CIP No.</label>
												<div class="form-line">
													<input type="number" class="form-control" min=0 step="1" name="cip" id="cip" required readonly>
												</div>
											</div>
										</div>									
									</div>
									<div class="col-md-12">
										<div class="col-md-5">
											<div class="form-group">
												<label>Equipment name</label>
												<div class="form-line">
													<input type="text" class="form-control" name="equipment" id="equipment" required>
												</div>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<label>Carline</label>
												<div class="input-group">
													<select  class="selectpicker" style="width: 100%;" data-live-search="true" name="carline" id="carline"  required>
														<option selected="selected" value="">---Pilih Sect---</option>
														<?php
														$qcar="select distinct CARLINE,CARLINE_CODE from LP_CV where CARLINE is not null order by CARLINE asc";
														$tb_qcar=odbc_exec($koneksi_lp,$qcar);
														$opt_car="";
														while($bar_qsect=odbc_fetch_array($tb_qcar)){
															$CARLINE_CODE=odbc_result($tb_qcar,"CARLINE_CODE");
															$CARLINE=odbc_result($tb_qcar,"CARLINE");
															$opt_car=$opt_car.'<option value="'.$CARLINE_CODE.'">'.strtoupper($CARLINE)."(".$CARLINE_CODE.")".'</option>';
														}
														echo $opt_car;
														?>
													</select>
												</div>
											</div>
										</div>
										
										<div class="col-md-2">
											<div class="form-group">
												<label>Qty</label>
												<div class="form-line">
													<input type="number" class="form-control" min=0 step="1" name="qty" id="qty" required readonly>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-md-4">
											<div class="form-group">
												<label>Price</label>
												<div class="form-line">
													<input type="number" class="form-control" min=0 step="1" name="price" id="price" required readonly>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Order Plan</label>
												<div class="form-line">
													<input type="number" readonly class="del_plan bg-grey form-control" id="order_plan" name="order_plan" value="<?php echo date("Ym"); ?>" placeholder="Delivery Plan" required>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Delivery Plan</label>
												<div class="form-line">
													<input type="number" readonly class="del_plan bg-grey form-control" id="del_plan" name="del_plan" value="<?php echo date("Ym"); ?>" placeholder="Delivery Plan" required>
												</div>
											</div>
										</div>
									</div>
								</div>
								<button type="submit" id="smpn" name="smpn" class="btn bg-orange waves-effect">
									<i class="material-icons">save</i>Simpan
								</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>UPLOAD<small>Upload Budget Invest</small></h2>
						</div>
						<div class="body">
							<form role="form" enctype="multipart/form-data" name="form2" id="form2" method="post" action="">
								<div class="row clearfix">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="form-group">
											<label>Open File</label>
											<div class="form-line">
												<input type="file" class="form-control" id="file" name="file" placeholder="Cari File" required>
											</div>
										</div>
										<button type="submit" id="upld" name="upld" class="btn bg-orange waves-effect">
											<i class="material-icons">file_upload</i>Upload Data
										</div>
										<?php
										if(isset($_POST['smpn'])){
											if($user=="APR"){
												$no_ctrl=$_POST['no_ctrl'];
												$term=$_POST['term'];
												$subterm=$_POST['subterm'];
												$sec=$_POST['sect'];
												$equipment=$_POST['equipment'];
												$carline=$_POST['carline'];
												$cip=$_POST['cip'];
												$qty=$_POST['qty'];
												$price=$_POST['price'];
												$order_plan=$_POST['order_plan'];
												$del_plan=$_POST['del_plan'];

												$updt="update bps_budget_invest
												set bud_group='$equipment',
												carline='$carline',
												qty='$qty',price='$price',
												order_plan='$order_plan',
												del_plan='$del_plan',
												pic_updt='$pic_updt',
												tgl_updt=getdate()
												where no_ctrl='$no_ctrl' ";
												$hasil = odbc_exec($koneksi_lp, $updt);
												echo "<script>alert('Data Berhasil di Diperbarui'); window.location = '?page=form/inpt_budinvest.php'</script>";
											}else{
												echo "<script>alert('Anda dilarang memperbarui data ini'); window.location = '?page=form/inpt_budinvest.php'</script>";
											}
										}
										if(isset($_POST['upld']) )
										{
											if($adm1!="admin")
											{
												echo "<script>alert('Anda dilarang memperbarui data ini'); window.location = '?page=form/inpt_budinvest.php'</script>";
											}else{
												require_once "excel_reader2.php";
									// echo "<script>alert('upload data');</script>"; 								
									$file_name = $_FILES['file']['name'];// nama file (tanpa path)								
									$tmp_name  = $_FILES['file']['tmp_name']; //nama local temp file di server								
									$file_size = $_FILES['file']['size']; //ukuran file (dalam bytes)								
									$file_type = $_FILES['file']['type']; //tipe filenya (langsung detect MIMEnya)		
									$fp1 = fopen($tmp_name, 'r'); // open file (read-only, binary)
									$fp = fopen($tmp_name, 'r');		
									$pecah=explode(".",$file_name);
									$ekstensi=$pecah[1];
									$extensionList=array("xls","XLS");
									if(in_array($ekstensi,$extensionList)){		
										$target = basename($_FILES['file']['name']) ;
										move_uploaded_file($_FILES['file']['tmp_name'], $target);			 
										$data = new Spreadsheet_Excel_Reader($_FILES['file']['name'],false);  
										$baris = $data->rowcount($sheet_index=0);
										$fixedbaris = $baris;
										for ($i=6; $i<=$fixedbaris; $i++){
											$kolA=$data->val($i,1);//no
											$kolB=$data->val($i,2);//Term
											$kolC=$data->val($i,3);//CIP No
											$kolD=$data->val($i,4);//Department
											$kolE=$data->val($i,5);//Sect
											$kolF=$data->val($i,6);//Equipment name
											$kolG=str_replace(",","",$data->val($i,7));//Qty											
											$kolH=str_replace(",","",$data->val($i,8));//Price											
											$kolI=$data->val($i,9);//Order Plan											
											$kolJ=$data->val($i,10);//Delivery Plan											
											$kolK=$data->val($i,11);//Carline
											$kolL=$data->val($i,12);//Sub Term

											$no_ctrl=$kolB."-".$kolE."-".substr($kolJ, -2)."-".substr("0000".$kolC, -4);
											$sec2=$kolD."-".$kolE;

											if($kolF!=""){
												/*$lht_dt=odbc_fetch_row(odbc_exec($koneksi_lp,"SELECT * FROM bps_budget_invest where no_ctrl='$no_ctrl' "));
												if($lht_dt==0)
												{
													$del = odbc_exec($koneksi_lp, "delete from bps_budget_invest where no_ctrl='$no_ctrl' ");
												}
												*/
												$del = odbc_exec($koneksi_lp, "delete from bps_budget_invest where term='$kolB' and cip_no='$kolC'");
												$sql_updt="INSERT into bps_budget_invest (term, no_ctrl, sect, sub_term, periode, cip_no, bud_group, qty, price, order_plan, del_plan, carline, pic_updt, tgl_updt, jns_budget, lt_quo, lt_pr, lt_po, lt_dtg, lt_vp ,expired ) 
												values ($kolB,'$no_ctrl','$sec2','$kolL','$kolJ',$kolC,'$kolF','$kolG' ,'$kolH','$kolI','$kolJ','$kolK','$pic_updt', getdate(),'NORMAL',14,0,0,5,0,LEFT($kolJ,4) +'-'+ RIGHT($kolJ,2) +'-28')";

												$hasil = odbc_exec($koneksi_lp, $sql_updt);
												echo "<br>lht ".$i.$sql_updt;
												if(!$hasil){
													echo "<br>Error ".$i.$sql_updt;
													print(odbc_error());
												}
											}
										}

										$baris_data=$fixedbaris-5;
										echo "<script>alert('Ada $baris_data baris. Data Berhasil di Upload');
										window.location = '?page=form/inpt_budinvest.php'</script>";
										unlink($_FILES['file']['name']);
									}
									else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_budinvest.php'</script>"; 
								}
							}
						}
						?>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>

<div class="row clearfix">
	<div class="col-lg-12 col-md-129 col-sm-12 col-xs-12">
		<div class="card">
			<div class="row clearfix">
				<div class="header">
					<h2>Record<small>Plan Budget</small></h2>
				</div>
				<div class="body">
					<form action="" id="frmcari" method="post"  enctype="multipart/form-data">
						<div class="col-md-2">	
							<div class="form-group">
								<div class="input-group">
									<select class="selectpicker" style="width: 50%;"  name="term_cr" id="term_cr"  required>
										<option selected="selected" value="">---Pilih Term---</option>
										<?php
										$qterm="select distinct term from bps_setterm order by term desc";
										$tb_qterm=odbc_exec($koneksi_lp,$qterm);
										$opt_term="";
										while($bar_qterm=odbc_fetch_array($tb_qterm)){
											$term=odbc_result($tb_qterm,"term");
											$opt_term=$opt_term.'<option value="'.$term.'">'.$term.'</option>';
										}
										echo $opt_term;
										?>
									</select>
								</div>
							</div>
						</div>
						<?php if($adm1=='admin'){ ?>
							<div class="col-md-2">	
								<div class="form-group">
									<div class="input-group">
										<select class="selectpicker" style="width: 100%;"  name="sect_cr" id="sect_cr" >
											<option selected="selected" value="">---Pilih Section---</option>
											<option value="all">Semua Section</option>
											<?php
											$qsect="select distinct sect from bps_budget_invest order by sect asc";
											$tb_qsect=odbc_exec($koneksi_lp,$qsect);
											$opt_sect="";
											while($bar_qsect=odbc_fetch_array($tb_qsect)){
												$sec=odbc_result($tb_qsect,"sect");
												$opt_sect=$opt_sect.'<option value="'.$sec.'">'.$sec.'</option>';
											}
											echo $opt_sect;
											?>
										</select>
									</div>
								</div>
							</div>
						<?php } ?>
						<div class="col-sm-2">	
							<div class="form-group">
								<div class="input-group">
									<select class="selectpicker" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
										<option selected="selected" value="">---Pilih Kolom---</option>
										<option value="periode">Periode</option>
										<option value="no_ctrl">No Control</option>	
										<option value="bud_group">Equipment Name</option>
										<option value="order_plan">Order Plan</option>
										<option value="del_plan">Delivery Plan</option>
									</select>
								</div>
							</div>
						</div>

						<div class="col-sm-4">	
							<div class="form-group">
								<div class="form-line">
									<input type="text"  class="form-control" data-role="tagsinput" id="txt_cari" name="txt_cari" placeholder="Detail Pencarian">
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
			<div class="row clearfix">
				<div class="body">
					<div class="table-responsive">
						<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
							<thead>
								<tr>
									<th>Section</th>									
									<th>Term</th>									
									<th>Periode</th>
									<th>No Ctrl</th>									
									<th>CIP No</th>
									<th>Eqipment Name</th>
									<th>Qty</th>
									<th>Price</th>
									<th>Amount</th>
									<th>Order Plan</th>
									<th>Delivery Plan</th>
									<th>Carline</th>
									<th>Tgl_Updt</th>
								</tr>
							</thead>

							<tbody>
								<?php
								if(isset($_POST['cr_b']) ){
									$term_cr=$_POST['term_cr'];

									if($user=="APR" || $user=="FAR"){										
										$sect_cr=$_POST['sect_cr'];
										if($sect_cr=="all"){
											$whr0="";
										}else{
											$whr0=" and sect='$sect_cr'";
										}
										$section=$sect_cr;
									}
									else{$whr0=" and sect='$sect' ";
									$section=$sect;
								}
								$cmd_cari=$_POST['cmd_cari'];
								$txt_cari=str_replace(" ","",$_POST['txt_cari']);

								if($txt_cari==""){
									$whr=""; 
								}else{
									$whr=" and replace($cmd_cari,' ','') like '%$txt_cari%'";
								}										
							}

							if(isset($_POST['smpn']) or isset($_POST['upld']) or isset($_POST['cr_b'])){
								$sq_acc="select term,sect,periode,no_ctrl,cip_no,bud_group,qty,price,order_plan, del_plan,carline,tgl_updt,(qty * price) as amount from bps_budget_invest where term='$term_cr' $whr0 $whr
								union select term,sect,periode,no_ctrl,cip_no,bud_group,qty,price,order_plan, del_plan,carline,tgl_updt,(qty * price) as amount from bps_budget_invest_add where term='$term_cr' $whr0 $whr ";
								$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
								$row=0;$section="";
								 echo $sq_acc;
								while($baris1=odbc_fetch_array($tb_acc)){
									$row++;
									$depsect=odbc_result($tb_acc,"sect");
									$price=odbc_result($tb_acc,"price");
									$qty=odbc_result($tb_acc,"qty");
									
									?>	
									<tr onclick="javascript:pilih(this);">
										<td><?php echo $depsect;?></td>
										<td><?php echo odbc_result($tb_acc,"term");?></td>
										<td><?php echo odbc_result($tb_acc,"periode");?></td>
										<td><?php echo odbc_result($tb_acc,"no_ctrl");?></td>												
										<td><?php echo odbc_result($tb_acc,"cip_no");?></td>
										<td><?php echo odbc_result($tb_acc,"bud_group");?></td>
										<td><?php echo $qty;?></td>
										<td><?php echo round($price,2);?></td>
										<td><?php echo $qty*$price;?></td>
										<td><?php echo odbc_result($tb_acc,"order_plan");?></td>
										<td><?php echo odbc_result($tb_acc,"del_plan");?></td>
										<td><?php echo odbc_result($tb_acc,"carline");?></td>
										<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_acc,"tgl_updt"))) ;?></td>
									</tr>	
									<?php 
								}
							}
							?>	
						</tbody>
						<tfoot>
							<tr>	
							</tr>
						</tfoot>
					</table>
					<?php if(isset($_POST['cr_b'])){ ?>
						<button type="button" class="btn bg-purple waves-effect" onclick="open_child('Exp_xls/exp_part_invest.php?t=<?php echo $term_cr;?>&s=<?php if($user=="APR"){ echo $sect_cr ; }else { echo $depsect ;} ?>','800','500'); return false;">
							<i class="material-icons">file_download</i>
							<span>Download</span>
						</button>	
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</section>

<script type="text/javascript">
	$(document).ready(function()
	{
		$('.del_plan').bootstrapMaterialDatePicker({
			format: 'YYYYMM', Date : new Date(),
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
<script>
	function pilih(row){
		var kd_pel0=row.cells[0].innerHTML;
		var kd_pel1=row.cells[1].innerHTML;
		var kd_pel2=row.cells[2].innerHTML;
		var kd_pel3=row.cells[3].innerHTML;
		var kd_pel4=row.cells[4].innerHTML;
		var kd_pel5=row.cells[5].innerHTML;
		var kd_pel6=row.cells[6].innerHTML;
		var kd_pel7=row.cells[7].innerHTML;
		var kd_pel8=row.cells[8].innerHTML;
		var kd_pel9=row.cells[9].innerHTML;
		var kd_pel10=row.cells[10].innerHTML;

		document.form1.sect.value=kd_pel0;
		document.form1.term.value=kd_pel1;
		document.form1.no_ctrl.value=kd_pel3;
		document.form1.cip.value=kd_pel4;
		document.form1.equipment.value=kd_pel5;
		document.form1.qty.value=kd_pel6;
		document.form1.price.value=kd_pel7;
		document.form1.order_plan.value=kd_pel8;
		document.form1.del_plan.value=kd_pel9;
		document.form1.carline.value=kd_pel10;
	}
</script>