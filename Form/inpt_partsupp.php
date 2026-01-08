<script type="text/javascript">
	function open_child(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
		
	};

	function cr_part(url,title,w,h){
		var part_kat=document.form1.part_kat.value;
		var pnd=document.form1.part_nm.value;
		var lp=document.form1.lp.value;
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url+'&part_kat='+part_kat+'&lp='+lp+'&pnd='+pnd+'&p', title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);		
	};

</script>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>MASTER PART SUPPLIER</h2>
		</div>
		<div class="row clearfix">
			<div class="col-md-9">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Manual Input Master Part</small></h2>
					</div>
					<div class="body">
						<form role="form"  name="form1" id="form1" method="post" action="" class="step_with_validation">
							<h3>STEP 1</h3>
							<fieldset>
								<div class="row clearfix">
									<div class="col-md-4">	
										<div class="form-group">
											<label>Supplier</label>
											<div class="form-line">
												<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="ksupp" id="ksupp" >
													<option selected="selected" value="">--Supplier--</option>
													<?php
													$tb_supp=odbc_exec($koneksi_lp,"select distinct SUPP_NAME,supp_code from lp_supp where SUPP_NAME is not null");
													while($tb_supp_code=odbc_fetch_array($tb_supp)){ 
														$supp=odbc_result($tb_supp,"SUPP_NAME");
														$kode_supp=odbc_result($tb_supp,"supp_code");
														echo '<option value="'.$kode_supp.'">'.$supp.'</option>';
													}
													?>
												</select>
											</div>
										</div>
									</div>

									<div class="col-md-4">			
										<div class="form-group">
											<label>Kategori</label>			
											<div class="input-group">
												<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="part_kat" id="part_kat"  required>
													<option selected="selected" value="">---Pilih Kategori---</option>
													<option value="BARANG">BARANG</option>
													<option value="JASA">JASA</option>
												</select>
											</div>
										</div>
									</div>	
									<div class="col-md-4">	
										<div class="form-group">
											<label>Purchasing</label>
											<div class="form-line">
												<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="lp" id="lp"  required>
													<option selected="selected" value="">---Pilih Purchasing---</option>
													<option value="GA">GA</option>
													<option value="MTP">MTP</option>
													<option value="LD">LD</option>
													<option value="EXIM">EXIM</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</fieldset>

							<h3>STEP 2</h3>
							<fieldset>
								<div class="row clearfix">
									<div class="col-md-4">				
										<div class="form-group">
											<label>Part No</label>
											<div class="input-group">
												<div class="form-line">
													<input type="text" readonly class="form-control bg-grey" id="part_no" name="part_no" placeholder="Part No" required>
												</div>
												<span class="input-group-addon">
													<button type="button" class="btn bg-purple waves-effect "  onclick="cr_part('template.php?plh=select/plh_partsec.php','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> 
													</button>
												</span>
											</div>
										</div>

										<div class="form-group">
											<label>Part No Supplier</label>
											<div class="form-line">
												<input type="text" class="form-control" id="part_nos" name="part_nos" placeholder="Part No Supplier" required>
											</div>
										</div>
									</div>
									<div class="col-md-4">	
										<div class="form-group">
											<label>Nama Part</label>
											<div class="form-line">
												<input type="text" class="form-control bg-grey" id="part_nm" name="part_nm" placeholder="Nama Part" required>
											</div>
										</div>

										<div class="form-group">
											<label>Nama Part Supplier</label>
											<div class="form-line">
												<input type="text" class="form-control" id="part_nms" name="part_nms" placeholder="Nama Part Supplier" required>
											</div>
										</div>
									</div>
									<div class="col-md-4">	
										<div class="form-group">
											<label>Detail Part</label>
											<div class="form-line">
												<input type="text" class="form-control bg-grey" id="part_dtl" name="part_dtl" placeholder="Detail Part" required>
											</div>
										</div>
										<div class="form-group">
											<label>UoM Part</label>
											<div class="form-line">
												<input type="text" class="form-control" id="uom" name="uom" placeholder="UoM Part" required>
											</div>
										</div>
									</div>

									<div class="footer">		 
										<button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>
									</div>
								</div>
							</fieldset>

						</form>
					</div>
				</div>	                   
			</div>
			<?php
			if(isset($_POST['smpn'])){	
				$part_no=$_POST['part_no'];	
				$part_nm=$_POST['part_nm'];
				$part_grp=$_POST['part_grp'];
				$part_kat=$_POST['part_kat'];
				$part_dtl=$_POST['part_dtl'];
				$uom=$_POST['uom'];
				$kdsupp=$_POST['ksupp'];
				$part_nos=$_POST['part_nos'];
				$part_nms=$_POST['part_nms'];
				$lp=$_POST['lp'];
				$pic=$_SESSION['nama'];

				$qry_del="delete from bps_part_supp where part_no_sm='$part_no' and kode_supp='$kdsupp'";
				$tb_del=odbc_exec($koneksi_lp,$qry_del);
				$qry_add="insert into bps_part_supp(part_no_sm,part_no_supp,kode_supp,kategori,part_nm_supp,lp,uom_supp,pic_updt,tgl_updt) values
				('$part_no','$part_nos','$kdsupp','$part_kat','$part_nms','$lp','$uom','$pic',getdate())";

				$tb_add=odbc_exec($koneksi_lp,$qry_add);
				$sq_crpart="select * from bps_part_supp where part_no_sm='$part_no' and kode_supp='$kdsupp'";
			}
			?>	 
			<div class="col-md-3">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Upload Master Part</small></h2>
						<ul class="header-dropdown m-r--5">
							<li class="dropdown">
								<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
									<i class="material-icons">more_vert</i>
								</a>
								<ul class="dropdown-menu pull-right">
									<li><a href="javascript:void(0);">Action</a></li>
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
			$dataok=0;$datan=0;			
			$pic=$_SESSION['nama'];
			for ($i=5; $i<=$fixedbaris; $i++){		
$kol1=$data->val($i,1);//NO
$kol2=$data->val($i,2);//PURCHASING
$kol3=$data->val($i,3);//KATEGORI
$kol4=$data->val($i,4);//PART NAME
$kol5=$data->val($i,5);//PART NO
$kol6=$data->val($i,6);//PART DETAIL
$kol7=$data->val($i,7);//UOM
$kol8=$data->val($i,8);//CURRENCY
// $kolI=$data->val($i,9);//PRICE1
// $kolJ=$data->val($i,10);//PRICE2
// $kolI=str_replace(",","",$kolI);
// $kolJ=str_replace(",","",$kolJ);

if($kol3!=""){	
	$sql_del="delete from bps_part_supp where part_no_supp='$kol3'";
	$hilang=odbc_exec($koneksi_lp,$sql_del);	
	$sql_updt="insert into bps_part_supp ( part_no_sm,part_no_supp,kode_supp,kategori,
	part_nm_supp,lp,uom_supp,pic_updt,tgl_updt) 
	values('$kol2','$kol3','$kol4','$kol5','$kol6','$kol7','$kol8','$pic',getdate())";
	$hasil = odbc_exec($koneksi_lp, $sql_updt);
//echo "<br>lht ".$i.$sql_updt;
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
				<h2>Record<small>Cari Part No</small></h2>
			</div>
			<div class="body">
				<form action="" id="frmcari" method="post"  enctype="multipart/form-data">

					<div class="col-sm-3">	
						<div class="form-group">
							<!--label>Kolom</label-->
							<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
								<option selected="selected" value="">---Pilih Kolom---</option>
								<option value="part_no">Part</option>
								<option value="part_nm">Nama Part</option>
								<option value="part_dtl">Detail Part</option>
								<option value="uom">Uom</option>
								<option value="curr">Currency</option>
								<option value="part_grp">Purchasing</option>
								<option value="part_kat">Kategori</option>
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
									<th>Purchasing</th>
									<th>Kategori</th>									
									<th>Part No</th>
									<th>Part No Supplier</th>
									<th>Nama Part</th>
									<th>Kode Supplier</th>
									<th>Uom</th>
									<th>Pic Update</th>
								</tr>
							</thead>

							<tbody>
								<?php
								if(isset($_POST['cr_b']) ){	
									$cmd_cari=$_POST['cmd_cari'];
									$txt_cari=str_replace(" ","",$_POST['txt_cari']);
									if($txt_cari==""){$whr=" part_no_sm is not null"; }else{
										$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
										$sq_crpart="select * from bps_part_supp where $whr";
									}
									if(isset($_POST['smpn']) or isset($_POST['cr_b'])){	
										$tb_acc=odbc_exec($koneksi_lp,$sq_crpart);
										$row=0;
										while($baris1=odbc_fetch_array($tb_acc)){ $row++;
											?>	
											<tr onclick="javascript:pilih(this);">
												<td><?php echo $row; ?></td>
												<td><?php echo odbc_result($tb_acc,"lp"); ?></td>
												<td><?php echo odbc_result($tb_acc,"kategori"); ?></td>	
												<td><?php echo odbc_result($tb_acc,"part_no_sm"); ?></td>
												<td><?php echo odbc_result($tb_acc,"part_nm_supp"); ?></td>
												<td><?php echo odbc_result($tb_acc,"part_nm_supp"); ?></td>
												<td><?php echo odbc_result($tb_acc,"kode_supp"); ?></td>
												<td><?php echo odbc_result($tb_acc,"uom_supp"); ?></td>
												<td><?php echo odbc_result($tb_acc,"pic_updt"); ?></td>
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
		var kd_pel7=row.cells[7].innerHTML;
		var kd_pel8=row.cells[8].innerHTML;
		var kd_pel9=row.cells[9].innerHTML;
		document.form1.lp.value=kd_pel1;
		document.form1.part_kat.value=kd_pel2;
		document.form1.lp.value=kd_pel3;
		document.form1.part_no.value=kd_pel4;
		document.form1.part_nos.value=kd_pel5;
		document.form1.part_nms.value=kd_pel6;
		document.form1.ksupp.value=kd_pel7;
		document.form1.uom.value=kd_pel8;
		document.form1.part_dtl.value=kd_pel9;

	}
</script>