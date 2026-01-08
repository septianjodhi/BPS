<script>
	function open_childX(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};	
</script>

<?php
$pic=$_SESSION['nama'];
$area=$_SESSION['area'];
$akses_user=$_SESSION['akses'];
$cek_adm=strpos($akses_user,"ADM_FA");
$cek_lp=strpos($akses_user,"LP");
$pc_area=explode("-", $area);
$sect=$pc_area[1];
?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>MASTER PART</h2>
	</div>
		<div class="row clearfix">
			<div class="col-lg-9">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Manual Input Master Part</small></h2>
					</div>
					<div class="body">
						<form role="form"  name="form1" id="form1" method="post" action="">
							<div class="row clearfix">

								<div class="col-md-4">				
									<div class="form-group">
										<label>Part No</label>
										<div class="form-line">
											<input type="text" class="form-control" id="part_no" name="part_no" placeholder="Part No" required>
										</div>
									</div>	
									<div class="form-group">
										<label>Nama Part</label>
										<div class="form-line">
											<input type="text" class="form-control" id="part_nm" name="part_nm" placeholder="Nama Part" required>
										</div>
									</div>
									<div class="form-group">
										<label>Currency</label>
										<div class="input-group">
											<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="curr" id="curr"  required>
												<option selected="selected" value="">Currency</option>
												<?php
												$qcurr="select distinct kurs_code from lp_kurs";
												$tb_curr=odbc_exec($koneksi_lp,$qcurr);
												while($bar_curr=odbc_fetch_array($tb_curr)){
													$dt_curr=odbc_result($tb_curr,"kurs_code");
													echo '<option value="'.$dt_curr.'">'.$dt_curr.'</option>';
												}				
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label>Kategori Pajak</label>			
										<div class="input-group">
											<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="kat_tax" id="kat_tax"  required>
												<option value="">---Pilih Kategori---</option>
												<option value="fix_ppn">Fix PPN</option>
												<option value="fix_non-ppn">Fix Non PPN</option>
												<option value="flexible">Flexible</option>
											</select>
										</div>
									</div>              				
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Detail Part</label>
										<div class="form-line">
											<input type="text" class="form-control" id="part_dtl" name="part_dtl" placeholder="Detail Part" required>
										</div>
									</div>
									<div class="form-group">
										<label>UOM</label>
										<div class="form-line">
											<input type="text" class="form-control" id="part_uom" name="part_uom" placeholder="UOM" required>
										</div>
									</div>
									<div class="form-group">
										<label>Jenis Kategori</label>			
										<div class="input-group">
											<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="part_kat" id="part_kat"  required>
												<option selected="selected" value="">---Pilih Kategori---</option>
												<option value="BARANG">BARANG</option>
												<option value="JASA">JASA</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label>Process Code</label>
										<div class="input-group">
											<div class="form-line">
												<input type="text" class="form-control" id="id_proses" name="id_proses" placeholder="Kode Proses" required>
											</div>
											<span class="input-group-addon">
												<button type="button" class="btn bg-purple waves-effect"  onclick="open_child('template.php?plh=select/plh_pros.php','Data Conveyor','800','500'); return false;">
													<i class="material-icons">search</i>
												</button>
											</span>
										</div>
									</div>
								</div>

								<div class="col-md-4">			
									<div class="form-group">
										<label>Purchasing</label>
										<div class="form-line">
											<input type="text" class="form-control" id="part_grp" name="part_grp" placeholder="GA/MTP/LD" required>
										</div>
									</div>
									<div class="form-group">
										<label>Price1</label>
										<div class="form-line">
											<input type="number" min="0" step=".01" class="form-control" id="price1" name="price1" placeholder="JUL-DEC" required>
										</div>
									</div>				
									<div class="form-group">
										<label>Price2</label>
										<div class="form-line">
											<input type="number" min="0" step=".01" class="form-control" id="price2" name="price2" placeholder="JAN-JUN" required>
										</div>
									</div>		
								</div>
							</div>
							<div class="row clearfix">		 
								<button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button><button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>
							</div>
						</form>
					</div>
				</div>	                   
			</div>
			<?php
			// if($cek_lp!=0 or $cek_adm!=0 ){
			if(isset($_POST['smpn']) or isset($_POST['del'])){
				$part_no=$_POST['part_no'];	
				$part_nm=$_POST['part_nm'];
				$part_grp=$_POST['part_grp'];
				$part_kat=$_POST['part_kat'];
				$part_dtl=$_POST['part_dtl'];
				$part_uom=$_POST['part_uom'];
				$kat_tax=$_POST['kat_tax'];
				$price1=$_POST['price1'];
				$price2=$_POST['price2'];
				$curr=$_POST['curr'];
				$id_proses=$_POST['id_proses'];
				$vprc1="";$vprc2="";$tprc1="";$tprc2="";
				for ($n=1; $n<=6; $n++){
					$njul=$n+6;
					$tprc1=$tprc1."price".$n.",";
					$tprc2=$tprc2."price".$njul.",";
					$vprc1=$vprc1."'".$price1."',";
					$vprc2=$vprc2."'".$price2."',";
				}

				$qry_del="delete from bps_part where part_no='$part_no'";
				$qry_add="insert into bps_part(part_no,part_nm,part_grp,part_kat,part_dtl,uom,curr,".$tprc1.$tprc2."pic_updt, tgl_updt, lp, kat_tax,kd_proses,status_part) values('$part_no','$part_nm','$part_grp','$part_kat','$part_dtl','$part_uom','$curr',".$vprc1.$vprc2."'$pic',getdate(),'$part_grp','$kat_tax','$id_proses',0)";
          		// echo $qry_add;
				$tb_del=odbc_exec($koneksi_lp,$qry_del);
				$tb_add=odbc_exec($koneksi_lp,$qry_add);
			}
				// if(isset($_POST['smpn']) ){	

					// $sq_crpart="select * from bps_part where part_no='$part_no'";
				// }
			// }
			?>	 
			<div class="col-lg-3">
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
					<?php
					// if($cek_lp!=0 or $cek_adm!=0 ){
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
$kolA=$data->val($i,1);//NO
$kolB=$data->val($i,2);//PURCHASING
$kolC=$data->val($i,3);//KATEGORI
$kolD=$data->val($i,4);//PART NAME
$kolE=$data->val($i,5);//PART NO
$kolF=$data->val($i,6);//PART DETAIL
$kolG=$data->val($i,7);//UOM
$kolH=$data->val($i,8);//CURRENCY
$kolI=$data->val($i,9);//PRICE1
$kolJ=$data->val($i,10);//PRICE2

$kolI=str_replace(",","",$kolI);
$kolJ=str_replace(",","",$kolJ);
$kolU=$data->val($i,21);//PRICE2
$kolV=$data->val($i,22);//Kategori Tax
$kolW=$data->val($i,23);//Kategori Tax
$kolX=$data->val($i,24);//fungsi
$kolY=$data->val($i,25);//acc foh
$kolZ=$data->val($i,26);//acc opex
$kolAA=$data->val($i,27);//acc desc

$vprc="";$tprc="";
if($kolE!=""){	
	for ($n=1; $n<=12; $n++){
		$vprc=$vprc."'".$data->val($i,$n+8)."',";
		$tprc=$tprc."price".$n.",";
	}
	// delete part yang sama
	$sql_del="delete from bps_part where part_no='$kolE'";
	$hilang=odbc_exec($koneksi_lp,$sql_del);

	$sql_updt="insert into bps_part(part_grp,part_kat,part_nm,part_no,part_dtl,uom,curr,
	".$tprc."pic_updt,tgl_updt,lp,kat_tax,kd_proses,kd_lt,status_part,FUNGSI,acc_no_foh,acc_no_opex,acc_desc) values
	('$kolB','$kolC','$kolD','$kolE','$kolF','$kolG','$kolH',".$vprc."'$pic',getdate(),'$sect','$kolU','$kolV','$kolW',0,'$kolX','$kolY','$kolZ','$kolAA')";
	$hasil = odbc_exec($koneksi_lp, $sql_updt);
	if(!$hasil){
		echo "<br>Error ".$i.$sql_updt;
		$datan++;
		print(odbc_error());
	}else{
		$dataok++;
		// echo $sql_del."<br>";
		// echo "<br>lht ".$i.$sql_updt;	
	}
}
}
unlink($_FILES['file']['name']);	
echo "<script>alert('Selesai $dataok data OK, $datan Data Gagal');'</script>";
// $sq_crpart="select * from bps_part where tgl_updt=getdate()";

}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_part.php'</script>"; }
}
// }
?>	 	                   
</div>


<div class="col-lg-3">
				<div class="card">
					<div class="header">
						<h2>Upload<small>Add Account in Master Part</small></h2>
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
							<form role="form" enctype="multipart/form-data" name="form21" id="form21" method="post" action="">
								<div class="form-group">
									<label>Open File</label>
									<div class="form-line">
										<input type="file" class="form-control" id="file" name="file" placeholder="Cari File" required>
									</div>
								</div>
								<button type="submit" id="upld6" name="upld6" class="btn bg-orange waves-effect">
									<i class="material-icons">saves</i>UPLOAD
								</button>
							</form>
						</div>
					</div>
					<?php
					// if($cek_lp!=0 or $cek_adm!=0 ){
					if(isset($_POST['upld6']) ){
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
			for ($i=2; $i<=$fixedbaris; $i++){		
$kolA=$data->val($i,1);//NO
$kolB=$data->val($i,2);//PART NO
$kolC=$data->val($i,3);//PART DETAIL
$kolD=$data->val($i,4);//FUNGSI TUJUAN
$kolE=$data->val($i,5);//ACCOUNT FOH
$kolF=$data->val($i,6);//ACCOUNT OPEX
$kolG=$data->val($i,7);//DESC


$vprc="";$tprc="";
if($kolB!=""){	
	
	

	$sql_updt="UPDATE BPS_PART set acc_no_foh='$kolE',acc_no_opex='$kolF',acc_desc='$kolG',FUNGSI='$kolD' where part_no='$kolB'";
	$hasil = odbc_exec($koneksi_lp, $sql_updt);
	if(!$hasil){
		echo "<br>Error ".$i.$sql_updt;
		$datan++;
		print(odbc_error());
	}else{
		$dataok++;
		// echo $sql_del."<br>";
		// echo "<br>lht ".$i.$sql_updt;	
	}
}
}
unlink($_FILES['file']['name']);	
echo "<script>alert('Selesai $dataok data OK, $datan Data Gagal');'</script>";


}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_part.php'</script>"; }
}
// }
?>	 	                   
</div>


</div>

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
								<option value="lp">Purchasing</option>
								<option value="part_kat">Kategori</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6">	
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
								<!-- <th>No</th> -->
								<th>Approve</th>
								<th>Purchasing</th>
								<th>Kategori</th>
								<th>Nama Part</th>
								<th>Part No</th>
								<th>Detail Part</th>
								<th>Uom</th>
								<th>Kode Proses</th>
								<th>Currency</th>
								<th>Kategori Tax</th>	
								<th>Pic Update</th>
								
								<?php 
								$day=date('Y');
								for ($i=1; $i <=12 ; $i++) {
									if($i<=6){
										$month=$i+6;
									}else{
										$month=$i-6;
									}
									$m=substr("0".$month,-2);
									$tgl=$day."-".$m."-01";
									echo "<th>".date("M",strtotime($tgl))."</th>";
								}
								?>
								<th>Fungsi</th>
								<th>Account FOH</th>
								<th>Account OPEX</th>	
								<th>Acc Description</th>
							</tr>
						</thead>

						<tbody>
							<?php
							if(isset($_POST['cr_b']) ){	
								$cmd_cari=$_POST['cmd_cari'];
								$txt_cari=str_replace(" ","",$_POST['txt_cari']);

								if($txt_cari==""){
									$whr="";
								}else{
									$whr="and replace($cmd_cari,' ','') like '%$txt_cari%'";
								}

								$sq_crpart="select * from bps_part where part_no is not null $whr";
								// }
								// if(isset($_POST['smpn']) or isset($_POST['cr_b'])){	
								// if(isset($_POST['cr_b'])){	
								$tb_acc=odbc_exec($koneksi_lp,$sq_crpart);
								$row=0;
								while($baris1=odbc_fetch_array($tb_acc)){ 
									$row++;
									$status_part=$baris1['status_part'];
									$part_no=odbc_result($tb_acc,"part_no");
									$lp=odbc_result($tb_acc,"lp");
									if ($status_part==0) {
									?>	
									<tr onclick="javascript:pilih(this);">
									<?php } ?>
										<!-- <td><?php echo $row; ?></td> -->
										<td><?php if ($status_part=='' || $status_part==0) {
											echo 'Belum Verifikasi';
											?>
										<!-- 	<button type="button" class="btn bg-green waves-effect" onclick="open_childX('select/aprv_pn.php?pn=<?php echo $part_no;?>&lp=<?php echo $lp;?>&lok=<?php echo $lok ;?>','Lihat Detail <?php echo $part_no;?>','800','500'); return false;"><i class="material-icons">visibility</i>
											</button> -->
											<?php 
										}else {
											echo 'Sudah Verifikasi';
										}
										?>

									</td>
									<td><?php echo odbc_result($tb_acc,"lp"); ?></td>
									<td><?php echo odbc_result($tb_acc,"part_kat"); ?></td>
									<td><?php echo odbc_result($tb_acc,"part_nm"); ?></td>
									<td><?php echo odbc_result($tb_acc,"part_no"); ?></td>
									<td><?php echo odbc_result($tb_acc,"part_dtl"); ?></td>
									<td><?php echo odbc_result($tb_acc,"uom"); ?></td>
									<td><?php echo odbc_result($tb_acc,"kd_proses"); ?></td>
									<td><?php echo odbc_result($tb_acc,"curr"); ?></td>
									<td><?php echo odbc_result($tb_acc,"kat_tax"); ?></td>
									<td><?php echo odbc_result($tb_acc,"pic_updt"); ?></td>
									
									
									<?php 
									for ($i=1; $i <=12 ; $i++) {
										$price="price".$i;
										?>
										<td>
											<?php echo number_format(odbc_result($tb_acc,"$price"),2,".",""); ?></td>
											<?php
										}
										?>
											<?php /*
											<?php 
											for ($i=1; $i <=12 ; $i++) {
												if($i<=6){
													$price="price".($i+6);
												}else{
													$price="price".($i-6);
												}
												?>
												<td>
													<?php echo number_format(odbc_result($tb_acc,"$price"),2,".",""); ?></td>
													<?php 
												} 
												?>
												*/ ?>
												<td><?php echo odbc_result($tb_acc,"fungsi"); ?></td>
									<td><?php echo odbc_result($tb_acc,"acc_no_foh"); ?></td>
									<td><?php echo odbc_result($tb_acc,"acc_no_opex"); ?></td>
									<td><?php echo odbc_result($tb_acc,"acc_desc"); ?></td>
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
		document.form1.part_grp.value=kd_pel1;
		document.form1.part_kat.value=kd_pel2;
		document.form1.part_nm.value=kd_pel3;
		document.form1.part_no.value=kd_pel4;
		document.form1.part_dtl.value=kd_pel5;
		document.form1.part_uom.value=kd_pel6;
		document.form1.id_proses.value=kd_pel7;
		document.form1.curr.value=kd_pel8;
	}
</script>