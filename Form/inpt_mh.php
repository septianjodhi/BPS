<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>MAN HOUR</h2>
		</div>
		<div class="row clearfix">
			<?php /*
			<div class="col-lg-9">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Manual Input Master Area</small></h2>
					</div>
					<div class="body">
						<form role="form"  name="form1" id="form1" method="post" action="">
							<div class="row clearfix">

								<div class="col-md-4">				
									<div class="form-group">
										<label>Car Maker</label>
										<div class="form-line">
											<input type="text" class="form-control" id="mkr" name="mkr" placeholder="Car Maker" required>
										</div>
									</div>							
									<div class="form-group">
										<label>Cost Center Code</label>
										<div class="form-line">
											<input type="text" class="form-control" id="cccode" name="cccode" placeholder="Cost Center Code" required>
										</div>
									</div>				
								</div>   
								<div class="col-md-4">
									<div class="form-group">
										<label>Code Carline</label>
										<div class="form-line">
											<input type="text" class="form-control" id="kd_car" name="kd_car" placeholder="Code Carline" required>
										</div></div>
										<div class="form-group">
											<label>Carline</label>
											<div class="form-line">
												<input type="text" class="form-control" id="nm_car" name="nm_car" placeholder="Carline" required>
											</div>
										</div>
									</div>        
									<div class="col-md-4">
										<div class="form-group">
											<label>Code Conveyor</label>
											<div class="form-line">
												<input type="text" class="form-control" id="kd_cv" name="kd_cv" placeholder="Code Conveyor" required>
											</div></div>
											<div class="form-group">
												<label>Conveyor</label>
												<div class="form-line">
													<input type="text" class="form-control" id="nm_cv" name="nm_cv" placeholder="Conveyor" required>
												</div>
											</div>
										</div>     

									</div>
									<div class="row clearfix">		 
										<button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
										<button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>

									</div>  
								</form>
							</div>
						</div>	                   
					</div>
					<?php
					if(isset($_POST['smpn']) or isset($_POST['del'])){	
						$mkr=$_POST['mkr'];	
						$cccode=$_POST['cccode'];
						$kd_cv=$_POST['kd_cv'];
						$nm_cv=$_POST['nm_cv'];
						$kd_car=$_POST['kd_car'];
						$nm_car=$_POST['nm_car'];

						$pic=$_SESSION['nama'];;
						$qry_del="delete from lp_cv where cv_code='$kd_cv'";
						$qry_add="insert into lp_cv(carmaker,cost_center_code,cv_code,cv_desc,carline_code,carline,pic_update,tgl_update) values('$mkr','$cccode','$kd_cv','$nm_cv','$kd_car','$nm_car','$pic',getdate())";
						$tb_del=odbc_exec($koneksi_lp,$qry_del);
					}
					if(isset($_POST['smpn']) ){	
						$tb_add=odbc_exec($koneksi_lp,$qry_add);
					}
					?>
					*/ ?>
					<!-- <div class="col-lg-12"> -->
						<div class="card">
							<div class="header">
								<h2>INPUT<small>Upload Master Set MH</small></h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="template/SET_MH.xls">Download Form</a></li>
										</ul>
									</li> 
								</ul>
								</div>
								<div class="body">
									<form role="form" enctype="multipart/form-data" name="form2" id="form2" method="post" action="">
										<div class="form-group">
											<label>Open File</label>
											<div class="form-line">
												<input type="file" class="form-control" id="file" name="file" placeholder="Cari File" required>
											</div>
										</div>
										<button type="submit" id="upld" name="upld" class="btn bg-orange waves-effect"><i class="material-icons">saves</i>UPLOAD
										</button>
									</form>
								</div>
							</div>	                   
							<!-- </div> -->
						</div>
						<?php
						if(isset($_POST['upld']) ){
							require_once "excel_reader2.php";
//nama file (tanpa path)
							$file_name = $_FILES['file']['name']; 
//nama local temp file di server
							$tmp_name  = $_FILES['file']['tmp_name']; 
//ukuran file (dalam bytes)
							$file_size = $_FILES['file']['size']; 
//tipe filenya (langsung detect MIMEnya)
							$file_type = $_FILES['file']['type']; 
// open file (read-only, binary)
							$fp1 = fopen($tmp_name, 'r'); 
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

								$pic=$_SESSION['nama'];
								for ($i=6; $i<=$fixedbaris; $i++){
//Periode
									$kolA=$data->val($i,1);
//Periode
									$kolB=$data->val($i,2);
//MH Term
									$kolC=$data->val($i,3);
//Plan
									$kolD=$data->val($i,4);
//Act
									$kolE=$data->val($i,5);

									if($kolB!="" and $kolC!="" ){	
										$sql_del="delete from bps_setMh where periode='$kolB' and term_mh='$kolC' ";
										$hilang=odbc_exec($koneksi_lp,$sql_del);	
										$sql_updt="insert into bps_setMh (periode,term_mh,plen,act,pic_updt,tgl_updt)
										values('$kolB',$kolC,$kolD,$kolE,'$pic',getdate())";
										$hasil = odbc_exec($koneksi_lp, $sql_updt);
//echo "<br>lht ".$i.$query1;
										if(!$hasil){
											echo "<br>Error ".$i.$sql_updt;
											print(odbc_error());
										}else{
											echo "<script>alert('Ada $fixedbaris data Berhasil di simpan');</script>";
										}
									}
								}
								unlink($_FILES['file']['name']);	

							}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_mh.php'</script>"; }

						}
						?>	 
						<div class="row clearfix">
							<div class="card">
								<div class="row clearfix">				
									<div class="header">
										<h2>Record<small>Cari Master Carline</small></h2>
									</div>
									<div class="body">
										<form action="" id="frmcari" method="post"  enctype="multipart/form-data">

											<div class="col-sm-3">	
												<div class="form-group">
													<!--label>Kolom</label-->
													<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
														<option selected="selected" value="">---Pilih Kolom---</option>
														<option value="periode">Periode</option>
														<option value="term_mh">Term MH</option>
													</select>
												</div>
											</div>
											<div class="col-sm-6">	
												<div class="form-group">
													<div class="form-line">
														<input type="text"  class="form-control" data-role="tagsinput" id="txt_cari" name="txt_cari" placeholder="Detail Pencarian">
													</div> 
												</div></div>

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

															<th>No</th>
															<th>Periode</th>
															<th>MH</th>
															<th>Plan</th>
															<th>Actual</th>
														</tr>
													</thead>

													<tbody>
														<?php
														if(isset($_POST['cr_b']) ){	
															$cmd_cari=$_POST['cmd_cari'];
															$txt_cari=str_replace(" ","",$_POST['txt_cari']);
															if($txt_cari==""){$whr="periode is not null"; }else{
																$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
																$sq_acc="select * from bps_setMh where $whr";
																$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
																$row=0;
																while($baris1=odbc_fetch_array($tb_acc)){ $row++;
																	?>	
																	<tr  onclick="javascript:pilih(this);">
																		<td><?php echo $row; ?></td>
																		<td><?php echo odbc_result($tb_acc,"periode"); ?></td>
																		<td><?php echo odbc_result($tb_acc,"term_mh"); ?></td>
																		<td><?php echo odbc_result($tb_acc,"plen"); ?></td>
																		<td><?php echo odbc_result($tb_acc,"act"); ?></td>
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
								var kd_pel2=row.cells[2].innerHTML;
								var kd_pel3=row.cells[3].innerHTML;
								var kd_pel4=row.cells[4].innerHTML;
								var kd_pel5=row.cells[5].innerHTML;
								var kd_pel6=row.cells[6].innerHTML;
								document.form1.mkr.value=kd_pel1;
								document.form1.cccode.value=kd_pel2;
								document.form1.kd_car.value=kd_pel3;
								document.form1.nm_car.value=kd_pel4;
								document.form1.kd_cv.value=kd_pel5;
								document.form1.nm_cv.value=kd_pel6;
							}
						</script>