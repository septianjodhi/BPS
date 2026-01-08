<script type="text/javascript">
	function open_child(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};	
</script>
<?php 
$pic_updt=$_SESSION['nama'];
$area=$_SESSION['area'];
$akses_user=$_SESSION['akses'];
$cek_adm=strpos($akses_user,"ADM_FA");
$cek_lp=strpos($akses_user,"LP");
$pc_area=explode("-", $area);
$sect=$pc_area[1];
// $pic_updt=$_SESSION['nama'];
?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Kategori Lead Time</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-9">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Manual Kategori Lead Time</small></h2>
					</div>
					<div class="body">
						<form role="form"  name="form1" id="form1" method="post" action="">
							<div class="row clearfix">
								<div class="col-md-3">
									<div class="form-group">
										<label>Kode Lead Time</label>
										<div class="form-line">
											<input type="text" class="form-control" id="kode_lt" name="kode_lt" placeholder="Kode Proses" required>
										</div>
									</div>
								</div>

								<div class="col-md-9">
									<div class="form-group">
										<label>Keterangan </label>
										<div class="form-line">
											<input type="text" class="form-control" id="ket_pros" name="ket_pros" placeholder="Keterangan" required>
										</div>
										
									</div>
								</div>
							</div>

							<!-- <div class="form-group">
								<label>Periode</label>
								<div class="form-line">
									<select class="selectpicker" style="width: 100%;"  name="peri" id="peri">
										<option selected="selected" value="">--Pilih Periode--</option>
										<?php
										$tb_peri=odbc_exec($koneksi_lp,"select distinct periode from bps_setperiode where periode>=convert(nvarchar(6),getdate(),112) order by periode asc");
										while($baris1=odbc_fetch_array($tb_peri)){ 
											$peri=odbc_result($tb_peri,"periode");
											echo '<option value="'.$peri.'">'.$peri.'</option>';
										}
										?>
									</select>
								</div>
							</div> -->


							<div class="row clearfix">
								<div class="col-md-2">
									<div class="form-group">
										<label>Penawaran</label>
										<div class="form-line">
											<input type="number" min="0" value="7" class="form-control" id="quo" name="quo" placeholder="Kode Proses" required>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>PR</label>
										<div class="form-line">
											<input type="number" min="0" value="7" class="form-control" id="pr" name="pr" placeholder="Kode Proses" required>
										</div>
									</div>
								</div>
								<div class="col-md-2">	
									<div class="form-group">
										<label>PO</label>
										<div class="form-line">
											<input type="number" min="0" value="7" class="form-control" id="po" name="po" placeholder="Kode Proses" required>
										</div>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Kedatangan</label>
										<div class="form-line">
											<input type="number" min="0" value="7" class="form-control" id="inv" name="inv" placeholder="Kode Proses" required>
										</div>
									</div>  

								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>VP</label>
										<div class="form-line">
											<input type="number" min="0" value="7" class="form-control" id="vp" name="vp" placeholder="Kode Proses" required>
										</div>
									</div>
								</div>

								

									<?php /*
									<div class="form-group">
										<label>LP</label>
										<div class="form-line">
											<select class="selectpicker" style="width: 100%;"  name="lp" id="lp" placeholder="Choose Purchasing" required>
												<option selected="selected" value="">-Choose Purchasing-</option>
												<?php
												$qlp="select * from bps_lp order by kd_lp";
												$tb_lp=odbc_exec($koneksi_lp,$qlp);
												while($bar_qlp=odbc_fetch_array($tb_lp)){
													$dt_lp=odbc_result($tb_lp,"kd_lp");
													echo '<option value="'.$dt_lp.'">'.$dt_lp.'</option>';
												}				
												?>
											</select>
										</div>
									</div>
									*/ ?>
								</div>
							<!-- </div> -->
							<div class="row clearfix"> 
								<button type="submit" id="smpn" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>
								<button type="submit" id="del" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>
							</div>  
						</form>
					</div>
				</div>	                   
			</div>
			<?php
		if($cek_lp!=0 or $adm1!='admin' ){
				if(isset($_POST['smpn']) or isset($_POST['del'])){	
					
					$kode_lt=$_POST['kode_lt'];
					// $periode=$_POST['peri'];
					$periode='';
					$ket_pros=$_POST['ket_pros'];

					$quo=$_POST['quo'];
					$pr=$_POST['pr'];
					$po=$_POST['po'];
					$inv=$_POST['inv'];
					$vp=$_POST['vp'];
					// $lp=$_POST['lp'];

					$qry_del="delete from bps_leadtime where kode_lt='$kode_lt'";
					$qry_add="insert into bps_leadtime (kode_lt,periode,lt_quo,lt_pr,lt_po,lt_dtg,lt_vp,ket,pic_updt,tgl_updt,lp) values('$kode_lt','$periode','$quo','$pr','$po','$inv','$vp','$ket_pros','$pic_updt',getdate(),'$sect')";
				//	$tb_del=odbc_exec($koneksi_lp,$qry_del);
echo $qry_add;
					if(isset($_POST['smpn']) )
					{	
						$tb_add=odbc_exec($koneksi_lp,$qry_add);
						echo $qry_add;
				echo "<script>alert('Sukses Menambah Data!'); window.location = '?page=form/inpt_leadtime.php'</script>";
					}
				}
				if(isset($_POST['del']) )
				{	
					$qry_del="delete from bps_leadtime where kode_lt='$kode_lt'";
					$tb_del=odbc_exec($koneksi_lp,$qry_del);
				}
		}
			?>

			<div class="col-lg-3">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Upload Master Lead Time Budget</small></h2>
						<ul class="header-dropdown m-r--5">
							<li class="dropdown">
								<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
									<i class="material-icons">more_vert</i>
								</a>
								<ul class="dropdown-menu pull-right">
									<li><a href="template/LEADTIME.xls">Download Form</a></li>
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
				<?php
				if($cek_lp!=0 or $adm1!='admin' ){
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
			for ($i=6; $i<=$fixedbaris; $i++){

$kol1=$data->val($i,1);	//No
$kol2=$data->val($i,2);	//Kode Lead Time
//$kol3=$data->val($i,3);	//Periode
$kol4=$data->val($i,4);	//Quotation
$kol5=$data->val($i,5);	//PR
$kol6=$data->val($i,6);	//PO
$kol7=$data->val($i,7);	//Kedatangan
$kol8=$data->val($i,8);	//VP
$kol9=$data->val($i,9);	//Keterangan
$tgl_updt=date("Y-m-d H:i:s");

$sql_del="delete from bps_leadtime where kode_lt='$kol2'";
$hilang=odbc_exec($koneksi_lp,$sql_del);	
$sql_updt="insert into bps_leadtime (kode_lt, lt_quo, lt_pr, lt_po, lt_dtg, lt_vp, ket, pic_updt,tgl_updt,lp) values('$kol2','$kol4','$kol5','$kol6','$kol7','$kol8','$kol9','$pic_updt',getdate(),'$sect')";

$hasil = odbc_exec($koneksi_lp, $sql_updt);
// echo "<br>lht ".$i.$sql_updt;
if(!$hasil){
	echo "<br>Error ".$i.$sql_updt;
	$datan++;
	print(odbc_error());
}else{$dataok++;}

unlink($_FILES['file']['name']);	
echo "<script>alert('Selesai $dataok data OK, $datan Data Gagal');'</script>";
$sq_crpart="select * from bps_leadtime where tgl_updt>='$tgl_updt'";
}
}
else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_part.php'</script>"; }
}
}
?>	 	                   
</div>
</div>

<div class="row clearfix">
	<div class="col-lg-12">
		<div class="card">

<!--div class="row clearfix">				
<div class="header">
<h2>Record<small>Cari Proses</small></h2>
</div>
<div class="body">
<form action="" id="frmcari" method="post"  enctype="multipart/form-data">
	
<div class="col-sm-3">	
<div class="form-group">
<label>Kolom</label>
<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
<option selected="selected" value="">---Pilih Kolom---</option>
<option value="kd_pros">KODE PROSES</option>
<option value="kategori">KATEGORI</option>
<option value="penawaran">PENAWARAN</option>
<option value="PR">PR</option>
<option value="PO">PO</option>
<option value="Invoice">INVOICE</option>
<option value="vp">VP</option>
<option value="cash">P.CASH</option>
<option value="Keterangan">KETERANGAN</option>
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
</div-->

<div class="row clearfix">
	<div class="body">
		<div class="table-responsive">
			<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
				<thead>
					<tr>	
						<th>KODE</th>
						<!-- <th>PERIODE</th> -->
						<th>LEAD TIME QUO</th>
						<th>LEAD TIME PR</th>
						<th>LEAD TIME PO</th>
						<th>LEAD TIME DATANG</th>
						<th>LEAD TIME VP</th>
						<th>KETERANGAN</th>
					</tr>
				</thead>
				<tbody>
					<?php
/*if(isset($_POST['cr_b']) ){	
//$cmd_cari=$_POST['cmd_cari'];
//$txt_cari=str_replace(" ","",$_POST['txt_cari']);
if($cmd_cari==""){$whr="kd_pros is not null"; }else{
$whr="$cmd_cari='YES'";}
$sq_acc="select * from bps_proses where $whr";
*/
$sq_acc="select * from bps_leadtime where lp='$sect' ";
$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
$row=0;
while($baris1=odbc_fetch_array($tb_acc)){ $row++;
	?>	
	<tr onclick="javascript:pilih(this);">
		<td><?php echo odbc_result($tb_acc,"kode_lt"); ?></td>
		<!-- <td><?php echo odbc_result($tb_acc,"periode"); ?></td> -->
		<td><?php echo odbc_result($tb_acc,"lt_quo"); ?></td>
		<td><?php echo odbc_result($tb_acc,"lt_pr"); ?></td>
		<td><?php echo odbc_result($tb_acc,"lt_po"); ?></td>
		<td><?php echo odbc_result($tb_acc,"lt_dtg"); ?></td>
		<td><?php echo odbc_result($tb_acc,"lt_vp"); ?></td>
		<td><?php echo odbc_result($tb_acc,"ket"); ?></td>
	</tr>	
	<?php 
}
//}

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
		var kd_pel7=row.cells[7].innerHTML;
		document.form1.kode_lt.value=kd_pel0;
		document.form1.peri.value=kd_pel1;
		document.form1.quo.value=kd_pel2;
		document.form1.pr.value=kd_pel3;
		document.form1.po.value=kd_pel4;
		document.form1.inv.value=kd_pel5;
		document.form1.vp.value=kd_pel6;
		document.form1.ket_pros.value=kd_pel7;

		document.frmdel.prdel.value=kd_pel0;
	}

</script>