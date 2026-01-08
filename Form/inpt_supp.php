<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>SUPPLIER</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-9">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Manual Input supplier</small></h2>
					</div>
					<div class="body">
						<form role="form"  name="form1" id="form1" method="post" action="">
							<!-- <div class="row clearfix"> -->

								<div class="col-sm-12">
									<div class="col-sm-4">
										<div class="form-group">
											<label>Supplier Name</label>
											<div class="form-line">
												<input type="text" class="form-control" id="nm_supp" name="nm_supp" placeholder="Supplier name" required>
											</div>
										</div>
										<div class="form-group">
											<label>Supplier Code</label>
											<div class="form-line">
												<input type="text" class="form-control" id="cd_supp" name="cd_supp" placeholder="Supplier Code" required>
											</div>
										</div>
										
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label>Address</label>
											<div class="form-line">
												<input type="text" class="form-control" id="almt" name="almt" placeholder="Address" required>
											</div>
										</div>
										<div class="form-group">
											<label>City</label>
											<div class="form-line">
												<input type="text" class="form-control" id="ct_almt" name="ct_almt" placeholder="City" required>
											</div>
										</div>										
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label>Kode Area</label>
											<div class="group-line">
												<select class="selectpicker"style="width: 100%;"  name="kd_area" id="kd_area" required>
													<option value="">-Pilih Area-</option>
													<option value="lokal">Lokal</option>
													<option value='import'>Import</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label>Kategori</label>
											<div class="form-line">
												<select class="selectpicker"style="width: 100%;"  name="kat" id="kat" required>
													<option value="">-Pilih kategori-</option>
													<option value="non-pkp">Non PKP</option>
													<option value='pkp'>PKP</option>
												</select>
											</div>
										</div>										
									</div>									
								</div>

								<div class="col-sm-12">
									<div class="col-sm-3">										
										<div class="form-group">
											<label>No HP</label>
											<div class="form-line">
												<input type="text" class="form-control" id="" name="nohp" placeholder="nohp" required>
											</div>
										</div>
										<div class="form-group">
											<label>Telphone</label>
											<div class="form-line">
												<input type="text" class="form-control" id="telp" name="telp" placeholder="Telephone" required>
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>NPWP</label>
											<div class="form-line">
												<input type="text" class="form-control" id="npwp" name="npwp" placeholder="npwp">
											</div>
										</div>
										<div class="form-group">
											<label>Fax</label>
											<div class="form-line">
												<input type="text" class="form-control" id="fax" name="fax" placeholder="fax">
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Contact Person</label>
											<div class="form-line">
												<input type="text" class="form-control" id="" name="cp" placeholder="cp" required>
											</div>
										</div>
										<div class="form-group">
											<label>Postcode</label>
											<div class="form-line">
												<input type="text" class="form-control" id="" name="kd_pos" placeholder="Postcode">
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Email</label>
											<div class="form-line">
												<input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
											</div>
										</div>
										<div class="form-group">
											<label>PPN</label>
											<div class="form-line">
												<input type="number" min="0" max="10" class="form-control" id="ppn" name="ppn" placeholder="PPN" required>
											</div>
										</div>										
									</div>
								</div>
								<!-- </div> -->
								<div class="row clearfix">		 
									<button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
									<button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>

								</div>  
							</form>
						</div></div>	                   
					</div>
					<?php
					if(isset($_POST['smpn']) or isset($_POST['del'])){	
/*$mkr=$_POST['mkr'];	
$cccode=$_POST['cccode'];
$kd_cv=$_POST['kd_cv'];
$nm_cv=$_POST['nm_cv'];
$kd_car=$_POST['kd_car'];
$nm_car=$_POST['nm_car'];
$ppn=$_POST['ppn'];*/

$nm_supp=$_POST['nm_supp'];
$almt=$_POST['almt'];
$telp=$_POST['telp'];
$email=$_POST['email'];
$cd_supp=$_POST['cd_supp'];
$ct_almt=$_POST['ct_almt'];
$fax=$_POST['fax'];
$npwp=$_POST['npwp'];
$cp=$_POST['cp'];
$kd_pos=$_POST['kd_pos'];
$nohp=$_POST['nohp'];
$ppn=$_POST['ppn'];
$kat=$_POST['kat'];
$kd_area=$_POST['kd_area'];

//cd_supp,nm_supp,almt,ct_almt,kd_pos,telp
$pic=$_SESSION['nama'];;
$qry_del="delete from lp_supp where SUPP_NAME='$nm_supp'";
//$qry_add="insert into lp_cv(carmaker,cost_center_code,cv_code,cv_desc,carline_code,carline,ppn,pic_update,tgl_update) values('$mkr','$cccode','$kd_cv','$nm_cv','$kd_car','$nm_car','$ppn','$pic',getdate())";
$qry_add="insert into lp_supp(SUPP_CODE,SHORT_NAME,SUPP_NAME,ALAMAT,KOTA,KODE_POS,TELP,FAX,NPWP,CP_NAME,CP_HP,EMAIL,kat,PIC_UPDATE,TGL_UPDATE,ppn,kdarea) values('$cd_supp','$nm_supp','$nm_supp','$almt','$ct_almt','$kd_pos','$telp','$fax','$npwp','$cp','$nohp','$email','$kat','$pic',getdate(),$ppn,'$kd_area')";
$tb_del=odbc_exec($koneksi_lp,$qry_del);
}
if(isset($_POST['smpn']) ){	
	$tb_add=odbc_exec($koneksi_lp,$qry_add);
}
?>	 
<div class="col-lg-3">
	<div class="card">
		<div class="header">
			<h2>INPUT<small>Upload Supplier</small></h2>
			<ul class="header-dropdown m-r--5">
				<li class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<i class="material-icons">more_vert</i>
					</a>
					<ul class="dropdown-menu pull-right">
						<li><a href="javascript:void(0);">Action</a></li>
					</ul>
				</li> </ul>
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
if(isset($_POST['upld']) ){
	require_once "excel_reader2.php";
	//	echo "<script>alert('upload data');</script>"; 
		$file_name = $_FILES['file']['name']; //nama file (tanpa path)
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
			
			$pic=$_SESSION['nama'];
			for ($i=5; $i<=$fixedbaris; $i++){		
$kolA=$data->val($i,1);//No
$kolB=$data->val($i,2);//KODE SUPPLIER
$kolC=$data->val($i,3);//NAMA SUPPLIER
$kolD=$data->val($i,4);//ALAMAT
$kolE=$data->val($i,5);//KOTA
$kolF=$data->val($i,6);//KODE POS	
$kolG=$data->val($i,7);//TELPHONE
$kolH=$data->val($i,8);//FAX
$kolI=$data->val($i,9);//NPWP
$kolJ=$data->val($i,10);//CONTACT PERSON
$kolK=$data->val($i,11);//HP
$kolK=str_replace("'","",$kolK);
$kolL=$data->val($i,12);//EMAIL
$kolM=$data->val($i,13);//PPN
$kolN=$data->val($i,14);//PPN
$kolO=$data->val($i,15);//PPN
if($kolM==""){$ppn="0";}else{$ppn=$kolM;}

if($kolB!=""){	
	$sql_del="delete from lp_supp where SUPP_CODE='$kolB'";
	$hilang=odbc_exec($koneksi_lp,$sql_del);
	$kode_supplier=str_replace(' ', '', $kolB);
	$sql_updt="insert into lp_supp(SUPP_CODE,SHORT_NAME,SUPP_NAME,ALAMAT,KOTA,KODE_POS,TELP,FAX,NPWP,CP_NAME,CP_HP,EMAIL,ppn,PIC_UPDATE,TGL_UPDATE,kat,kdarea) values('$kode_supplier','$kolC','$kolC','$kolD','$kolE','$kolF','$kolG','$kolH','$kolI','$kolJ','$kolK','$kolL','$ppn','$pic',getdate(),'$kolN','$kolO')";
	//$kode_supplier=str_replace(' ', '', $kolC);
	//$sql_updt="insert into lp_supp(SUPP_CODE,SHORT_NAME,SUPP_NAME,ALAMAT,KOTA,KODE_POS,TELP,FAX,NPWP,CP_NAME,CP_HP,EMAIL,ppn,PIC_UPDATE,TGL_UPDATE,kat,kdarea) values('$kolB','$kode_supplier','$kode_supplier','$kolD','$kolE','$kolF','$kolG','$kolH','$kolI','$kolJ','$kolK','$kolL','$ppn','$pic',getdate(),'$kolN','$kolO')";
	$hasil = odbc_exec($koneksi_lp, strtoupper($sql_updt));
//echo "<br>lht ".$i.$query1;
	if(!$hasil){
		echo "<br>Error ".$i.$sql_updt;
		print(odbc_error());
	}else{}
}
}
unlink($_FILES['file']['name']);	

}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_supp.php'</script>"; }

}
?>	 
<div class="row clearfix">
	<div class="card">
		<div class="row clearfix">				
			<div class="header">
				<h2>Record<small>Cari Master Supplier</small></h2>
			</div>
			<div class="body">
				<form action="" id="frmcari" method="post"  enctype="multipart/form-data">

					<div class="col-sm-3">	
						<div class="form-group">
							<!--label>Kolom</label-->
							<select class="selectpicker" name="cmd_cari" id="cmd_cari" >
								<option selected="selected" value="">---Pilih Kolom---</option>
								<option value="SUPP_CODE">KODE SUPPLIER</option>
								<option value="SHORT_NAME">NAMA SUPPLIER</option>
								<option value="ALAMAT">ALAMAT</option>
								<option value="KOTA">KOTA</option>
								<option value="KODE_POS">KODE POS</option>
								<option value="TELP">TELPHONE</option>
								<option value="FAX">FAX</option>
								<option value="NPWP">NPWP</option>
								<option value="CP_NAME">CONTACT PERSON</option>
								<option value="CP_HP">HP</option>
								<option value="EMAIL">EMAIL</option>
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
									<th>KODE SUPPLIER</th>
									<th>NAMA SUPPLIER</th>
									<th>ALAMAT</th>
									<th>KOTA</th>
									<th>KODE POS</th>
									<th>TELPHONE</th>
									<th>FAX</th>
									<th>NPWP</th>
									<th>CONTACT PERSON</th>
									<th>HP</th>
									<th>EMAIL</th>
									<th>PPN(%)</th>

								</tr>
							</thead>

							<tbody>
								<?php
								if(isset($_POST['cr_b']) ){	
									$cmd_cari=$_POST['cmd_cari'];
									$txt_cari=str_replace(" ","",$_POST['txt_cari']);
									if($txt_cari==""){$whr="SUPP_CODE is not null"; }else{
										$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
										$sq_acc="select * from lp_supp where $whr";
										$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
										$row=0;
										while($baris1=odbc_fetch_array($tb_acc)){ $row++;
											?>	
											<tr  onclick="javascript:pilih(this);">
												<td><?php echo $row; ?></td>
												<td><?php echo odbc_result($tb_acc,'SUPP_CODE'); ?></td>
												<td><?php echo odbc_result($tb_acc,'SUPP_NAME'); ?></td>
												<td><?php echo odbc_result($tb_acc,'ALAMAT'); ?></td>
												<td><?php echo odbc_result($tb_acc,'KOTA'); ?></td>
												<td><?php echo odbc_result($tb_acc,'KODE_POS'); ?></td>
												<td><?php echo odbc_result($tb_acc,'TELP'); ?></td>
												<td><?php echo odbc_result($tb_acc,'FAX'); ?></td>
												<td><?php echo odbc_result($tb_acc,'NPWP'); ?></td>
												<td><?php echo odbc_result($tb_acc,'CP_NAME'); ?></td>
												<td><?php echo odbc_result($tb_acc,'CP_HP'); ?></td>
												<td><?php echo odbc_result($tb_acc,'EMAIL'); ?></td>
												<td><?php echo odbc_result($tb_acc,'PPN'); ?></td>

											</tr>	
											<?php 
										}}?>	
									</tbody>
									<tfoot>
										<tr>	
										</tr>
									</tfoot>
								</table>
							</div>
						</div></div>
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
				var kd_pel7=row.cells[7].innerHTML;
				var kd_pel8=row.cells[8].innerHTML;
				var kd_pel9=row.cells[9].innerHTML;
				var kd_pel10=row.cells[10].innerHTML;
				var kd_pel11=row.cells[11].innerHTML;
				var kd_pel12=row.cells[12].innerHTML;
				document.form1.cd_supp.value=kd_pel1;
				document.form1.nm_supp.value=kd_pel2;
				document.form1.almt.value=kd_pel3;
				document.form1.ct_almt.value=kd_pel4;
				document.form1.kd_pos.value=kd_pel5;
				document.form1.telp.value=kd_pel6;

			}
		</script>