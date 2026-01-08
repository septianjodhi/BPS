<script type="text/javascript">
	function open_child(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};

	function cr_nik(url,title,w,h){
		var area=document.form1.area.value;
		if(area=="")
		{
			alert("DEPARTMENT Belum dipilih");
		}
		else{
			var left = (screen.width/2)-(w/2);
			var top = (screen.height/2)-(h/2);
			w = window.open(url+'&a='+area, title, 'toolbar=no, location=no, directories=no, \n\
				status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
				width='+w+',height='+h+',top='+top+',left='+left);		
		}
	};
</script>
<?php 
include("koneksi.php");
$pic=$_SESSION['nama'];
$sect=$_SESSION['area'];
$pc_sect=explode("-", $sect);
$dept=$pc_sect[0];
include "excel_reader2.php";
?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>MASTER USER</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Manual Input Master User BPS</small></h2>
					</div>
					<div class="body">
						<form role="form"  name="form1" id="form1" method="post" action="">
							<div class="row clearfix">
								<div class="col-12">
									<div class="col-md-3">
										<div class="form-group">
											<label>NIK</label>
											<div class="input-group">
												<div class="form-line">
													<input type="text" class="form-control" id="nik" name="nik" placeholder="NIK" required>
												</div>
												<span class="input-group-addon">
													<button type="button" class="btn bg-purple waves-effect"  onclick="cr_nik('template.php?plh=select/plh_nikhr.php','800','300'); return false;"><i class="material-icons">search</i> </button>
												</span>
											</div>
										</div>

										<div class="form-group">
											<label>DEPT-SECT</label>
											<div class="form-line">
												<select class="selectpicker" style="width: 100%;"  name="area" id="area"  required>
													<option selected="selected" value="">---Pilih Area---</option>
													<?php												
												// if ($sect=='FA-FIN' or $sect=='PGA-IT')
												// {
												// 	$wh_sect=" where sect is not null ";
												// }else
												// {
												// 	$wh_sect=" where sect like '$dept%' ";
												// }
													$sql_sami = mysql_query("SELECT dept_code,sect_code FROM tbl_sect 
														order by dept_code") or die(mysql_error());
													while ($tr_sami = mysql_fetch_array ($sql_sami)) {
														$dept_code=$tr_sami['dept_code'];
														$sect_code=$tr_sami['sect_code'];
														$area1=$dept_code."-".$sect_code;
														echo '<option value="'.$area1.'">'.$area1.'</option>';
													}
													?>
												</select>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label>NAMA</label>
											<div class="form-line">
												<input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
											</div>
										</div>
										<div class="form-group">
											<label>LOKASI</label>			
											<div class="input-group">
												<select class="selectpicker" style="width: 100%;"  name="lokasi" id="lokasi"  required>
													<option selected="selected" value="">---Pilih Area---</option>
													<option value="TF">SAMI-TF</option>
													<option value="JF">SAMI-JF</option>
												</select>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label>USER</label>
											<div class="form-line">
												<input type="text" class="form-control" id="user" name="user" placeholder="User" required>
											</div>
										</div>
										<!-- <div class="form-group">
											<label>PASSWORD</label>
											<div class="form-line">
												<input type="password" class="form-control" id="passw" name="passw" placeholder="PASSWORD" required>
											</div>
										</div> -->
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>EMAIL</label>
											<div class="form-line">
												<input type="text" class="form-control" id="email" name="email" placeholder="EMAIL" required>
											</div>
										</div>									
									</div>
								</div>
								<div class="col-md-12">
									<div class="col-md-1">
										<div class="form-group">
											<label>ADM FA</label>
											<div class="switch"><label><input type="checkbox" name="job[]" value="ADM_FA"><span class="lever switch-col-blue"></span></label></div>
										</div>
									</div>
									<div class="col-md-1">
										<div class="form-group">
											<label>Approve</label>
											<div class="switch"><label><input type="checkbox" name="job[]" value="APR_PR"><span class="lever switch-col-blue"></span></label></div>
										</div>
									</div>
									<div class="col-md-1">
										<div class="form-group">
											<label>LP</label>
											<div class="switch"><label><input type="checkbox" name="job[]" value="LP"><span class="lever switch-col-blue"></span></label></div>
										</div>
									</div>
									<div class="col-md-1">
										<div class="form-group">
											<label>TAX</label>
											<div class="switch"><label><input type="checkbox" name="job[]" value="TAX"><span class="lever switch-col-blue"></span></label></div>
										</div>
									</div>
								</div>

							</div>
							<button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>
							<button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>HAPUS</button>
						</form>
					</div>
				</div>	                   
				<!-- </div> -->
				<?php
				if(isset($_POST['smpn']) or isset($_POST['del'])){	
					$nik=$_POST['nik'];
					$email=$_POST['email'];
					$nama=$_POST['nama'];
					$user=$_POST['user'];
					$passw='Budget';
					// $passw=$_POST['passw'];
					$job=$_POST['job'];
					$lst_job="";
					for ($i=0; $i < count($job) ; $i++){
						$lst_job=$lst_job.",".$job[$i];
					}
					$lokasi=$_POST['lokasi'];
					$area=$_POST['area'];
					$akses='USER_SECT'.$lst_job;

					$cek_data=mysql_query("select count(lokasi) as jml,lokasi from tbl_user where app_nm='BPS' and lokasi='$lokasi' and nik='$nik' and area='$area' and user='$user' limit 1");
					while($baris=mysql_fetch_array($cek_data)){
						$jml_data=$baris['jml'];
						$rec_lok=$baris['lokasi'];
					}

					if($jml_data==1){
						$update =mysql_query("update tbl_user set email='$email',area='$area',akses='$akses' where app_nm='BPS' and lokasi='$rec_lok' and nik='$nik' and area='$area' and user='$user'");
						// echo "update tbl_user set email='$email',area='$area',akses='$akses' where app_nm='BPS' and lokasi='$rec_lok' and nik='$nik' and area='$area' and user='$user'";
					}else{
					// $tb_del=mysql_query("delete from tbl_user where app_nm='BPS' and lokasi='$lokasi' and nik='$nik' and area='$area' and user='$user' ");
						$qry_insert="insert into tbl_user(nik,nama,user,pass,akses,status,area,lokasi,email,
						app_nm,tgl_updt,pic_updt) values('$nik','$nama','$user','$passw','$akses','User','$area','$lokasi','$email','BPS',now(),'$pic')";

					// echo $qry_insert;
						$tb_add=mysql_query($qry_insert);
					}
					// $sq_crpart="select * from tbl_user where app_nm='BPS' and lokasi='$lokasi' and 
					// nik='$nik' and user='$user' order by area asc";
				}
				?>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Upload User</small></h2>
					</div>
					<div class="body">
						<form role="form" enctype="multipart/form-data" name="form2" id="form2" method="post" action="">
							<div class="form-group">
								<label>Open File</label>
								<div class="form-line">
									<input type="file" class="form-control" id="file" name="file" placeholder="Cari File" required>
								</div>
							</div>
							<button type="submit" id="upld" name="upld" class="btn bg-orange waves-effect">
								<i class="material-icons">saves</i>UPLOAD
							</button>
						</form>
					</div>
				</div>	                   
			</div>

		</div>
		<?php
		if(isset($_POST['upld']) )
		{
			require_once "excel_reader2.php";
	//	echo "<script>alert('upload data');</script>"; 
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
				$dataok=0;$datan=0;			
				$pic=$_SESSION['nama'];
				for ($i=6; $i<=$fixedbaris; $i++)
				{
					$kol1=$data->val($i,1); //No
					$kol2=$data->val($i,2); //NIK
					$kol3=$data->val($i,3); //Nama
					$kol4=$data->val($i,4); //User ID
					$kol5=$data->val($i,5); //Password
					$kol6=$data->val($i,6); //Akses
					$kol7=$data->val($i,7); //Dept
					$kol8=$data->val($i,8); //Sect
					$kol9=$data->val($i,9); //Lokasi
					$kol10=$data->val($i,10); //E-mail

					$area=$kol7."-".$kol8;
					$pch_lok=explode("-", $kol9) ;

					if($kol2!=""){
						$tb_del=mysql_query("delete from tbl_user where app_nm='BPS' and lokasi='$kol9' 
							and nik='$kol2' and area='$area' and user='$kol4' ");
						$qry_insert="insert into tbl_user(nik,nama,user,pass,akses,status,area,lokasi,email,						app_nm,tgl_updt,pic_updt) values('$kol2','$kol3','$kol4','$kol5','$kol6','User','$area','$pch_lok[1]','$kol10','BPS',now(),'$pic')";
					// echo $qry_insert;
						$hasil=mysql_query($qry_insert);
						// echo "<br>lht ".$i.$sql_updt;
						if(!$hasil){
							echo "<br>Error ".$i.$sql_updt;
							$datan++;
							print(odbc_error());
						}else{$dataok++;}
					}
				}
				unlink($_FILES['file']['name']);	
				$sq_crpart="select * from bps_part where tgl_updt=getdate()";
				echo "<script>alert('Selesai $dataok data OK, $datan Data Gagal');'</script>";
			}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_part.php'</script>"; }
		}
		?>
		<div class="row clearfix">
			<div class="card">
				<div class="row clearfix">				
					<div class="header">
						<h2>Record<small>Data Menu</small></h2>
					</div>
					<div class="body">
						<form action="" id="frmcari" method="post"  enctype="multipart/form-data">
							<div class="col-sm-3">	
								<div class="form-group">
									<!--label>Kolom</label-->
									<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
										<option selected="selected" value="">---Pilih Kolom---</option>
										<option value="nik">NIK</option>
										<option value="nama">Nama</option>
										<option value="user">User App</option>										
									</select>
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
										<th>Lokasi</th>
										<th>Email</th>
										<th>Area</th>
										<th>Nik</th>
										<th>Nama</th>
										<th>User App</th>
										<th>Akses</th>
									</tr>
								</thead>

								<tbody>
									<?php
									if(isset($_POST['cr_b']) ){	
										$cmd_cari=$_POST['cmd_cari'];
										$txt_cari=str_replace(" ","",$_POST['txt_cari']);
										if($txt_cari==""){$whr=""; 
									}else{
										$whr=" and replace($cmd_cari,' ','') like '%$txt_cari%'";
									}
									$sq_acc="select * from tbl_user where app_nm='BPS' $whr order by app_nm";
												//echo $sq_acc;
								}
								if(isset($_POST['cr_b']) or isset($_POST['smpn']) ){
									$tb_acc=mysql_query($sq_acc);
												//$row=0;
									while($baris1=mysql_fetch_array($tb_acc)){
												// $row++;
										?>	
										<tr onclick="javascript:pilih(this);">
											<td><?php echo $baris1["lokasi"]; ?></td>
											<td><?php echo $baris1["email"]; ?></td>
											<td><?php echo $baris1["area"]; ?></td>
											<td><?php echo $baris1["nik"]; ?></td>
											<td><?php echo $baris1["nama"]; ?></td>
											<td><?php echo $baris1["user"]; ?></td>
											<td><?php echo $baris1["akses"]; ?></td>
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
		</div>
	</div>
</div>
</section>
<script>
	function pilih(row)
	{
		var kd_pel0=row.cells[0].innerHTML;
		var kd_pel1=row.cells[1].innerHTML;
		var kd_pel2=row.cells[2].innerHTML;
		var kd_pel3=row.cells[3].innerHTML;
		var kd_pel4=row.cells[4].innerHTML;
		var kd_pel5=row.cells[5].innerHTML;
		var kd_pel6=row.cells[6].innerHTML;
		document.form1.email.value=kd_pel1;
		document.form1.nik.value=kd_pel3;
		document.form1.nama.value=kd_pel4;
		document.form1.user.value=kd_pel5;
	}
</script>