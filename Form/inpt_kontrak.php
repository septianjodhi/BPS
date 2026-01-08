<script>
	function cr_supp(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
		document.form1.no_quo.value="";
	};
</script>

<?php 
$area= $_SESSION["area"];
$pic_updt=$_SESSION['nama'];
$pch_sect=explode("-",$area);
$sect=$pch_sect[1];
?>

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Dokumen Supplier<small>Input Data Dokumen Supplier</small></h2>
		</div>
		<div class="row clearfix">
			<div class="card">
				<div class="header">
					<ul class="nav nav-tabs tab-nav-right" role="tablist">
						<li role="presentation" class="active"><a href="#manual" data-toggle="tab">Manual Input</a></li>
						<li role="presentation"><a href="#by_upload" data-toggle="tab">Upload</a></li>
					</ul>	
				</div>
				<div class="tab-content">
					<!-- Tab Panel Manual -->
					<div role="tabpanel" class="tab-pane fade in active" id="manual">
						<div class="header"><h2>INPUT DOKUMEN SUPPLIER</h2>
						</div>
						<div class="body">
							<form role="form"  name="form1" id="form1" method="post" action="" enctype="multipart/form-data">
								<div class="body">
									<div class="row clearfix">
										<div class="col-md-12">
											<div class="col-md-3">
												<div class="form-group">
													<label>Kode Supplier</label>
													<div class="input-group">
														<div class="form-line">
															<input type="text" readonly class="form-control" id="kode_supp" name="kode_supp" placeholder="Kode Supplier" required>
														</div>
														<span class="input-group-addon">
															<button type="button" class="btn bg-red waves-effect" onclick="cr_supp('template.php?plh=select/plh_supp.php&c=kode_supp','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
														</span>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Nama Supplier</label>
													<div class="form-line">
														<input type="text" name="supp" class="form-control" id="supp" placeholder="Nama Supplier" readonly>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Kategori Dokumen</label>
													<div class="form-line">
														<select class="selectpicker" name="jns_kontrak" id="jns_kontrak">
															<option selected="selected" value="">---Pilih Kategori Dokumen---</option>
															<option value="umum">Umum</option>
															<option value="project">Project</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Masa Berlaku</label>
													<div class="input-group">
														<div class="form-line">
															<!-- <input type="text"  class="form-control" id="rg_tgl" name="rg_tgl" placeholder="Masa Kontrak"> -->
															<input type="text"  class="form-control datetime" id="tgl" name="tgl" placeholder="Masa Kontrak">
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-12">											
											<div class="col-md-3">
												<div class="form-group">
													<label>No Dokumen</label>
													<div class="form-line">
														<input type="text" name="no_dok" class="form-control" id="no_dok" placeholder="No Dokumen">
													</div>	
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Jenis Dokumen</label>
													<div class="form-line">
														<!-- <input type="text" name="jns_dok" class="form-control" id="jns_dok" placeholder="Jenis Dokumen"> -->
														<select class="selectpicker" name="jns_dok" id="jns_dok">
															<option selected="selected" value="">---Pilih Jenis Dokumen---</option>
															<option value="KONTRAK">KONTRAK</option>
															<option value="PENAWARAN">PENAWARAN</option>
															<option value="REGISTER">REGISTER</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Amount</label>
													<div class="form-line">
														<input type="number" name="amount" class="form-control" id="amount" placeholder="Amount">
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Lokasi Penyimpanan</label>
													<div class="form-line">
														<input type="text" name="lok_simpan" class="form-control" id="lok_simpan" placeholder="Lokasi Penyimpanan">
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="col-md-3">
												<div class="form-group">
													<label>Dok.Referensi</label>
													<div class="form-line">
														<input type="file" class="form-control" id="dok_ref" name="dok_ref" placeholder="Dok.Referensi" >
													</div>
												</div>
											</div>
											<div class="col-md-9">
												<div class="form-group">
													<label>Keterangan</label>
													<div class="form-line">
														<input type="text" name="ket" class="form-control" id="ket" placeholder="Keterangan">
													</div>
												</div>
											</div>											
										</div>
									</div>

									<div class="row clearfix">
										<button type="submit" id="smpn" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
										<button type="reset" id="reset" name="reset" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Clear</button>
									</div>  
								</div>
							</form>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane fade" id="by_upload">        
						<div class="header">
							<h2>INPUT<small>Upload Data Quotation</small></h2>
							<ul class="header-dropdown m-r--5">
								<li class="dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="material-icons">more_vert</i>
									</a>
									<ul class="dropdown-menu pull-right">
										<li><a href="template/KONTRAK_SUPPLIER.xls">download</a></li>
									</ul>
								</li>
							</ul>
						</div>
						<form role="form" enctype="multipart/form-data" name="form2" id="form2" method="post" action="">
							<div class="body">
								<div class="col-lg-12">		
									<div class="col-md-6">	
										<div class="form-group">
											<label>Open File</label>
											<div class="form-line">
												<input type="file" class="form-control" id="file" name="file" placeholder="Cari File" required>
											</div>
										</div>
									</div>		
									<div class="col-md-3">	
										<button type="button" class="btn btn-outline-secondary" onclick="open_child('http://10.62.125.18:8080/share.cgi?ssid=6f91cac3be3d419e90e1b34441264fe8','upload','800','500'); return false;">DOK.REFF</button>
									</div>
								</div>
								<div class="row clearfix">	
									<button type="submit" id="upld" name="upld" class="btn bg-orange waves-effect">
										<i class="material-icons">saves</i>Send</button>
									</div>
								</div>
							</form>	
						</div>
					</div>							
				</div>
			</div>
		</div>
	</section>


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
		// kode verifikasi
		// open file (read-only, binary)
		$fp1 = fopen($tmp_name, 'r'); 
		$fp = fopen($tmp_name, 'r');		
		$pecah=explode(".",$file_name);
		$ekstensi=$pecah[1];
		$extensionList=array("xls","XLS");
		if(in_array($ekstensi,$extensionList)){		
			$target = basename($_FILES['file']['name']) ;
			// ganti nama file 	
			move_uploaded_file($_FILES['file']['tmp_name'], $target); 
			$data = new Spreadsheet_Excel_Reader($_FILES['file']['name'],false);  
			$baris = $data->rowcount($sheet_index=0);
			$fixedbaris = $baris;	 
			//$sect_u=$data->val(5,2)."-".$data->val(5,4);
			$periode=DATE("Ym");
			$pic=$_SESSION['nama'];
			$jmrow=0;
			//echo $sql_del;
			for ($i=5; $i<=$fixedbaris; $i++){
				$kol2=$data->val($i,2);
				$kol4=$data->val($i,4);
				$kol5=$data->val($i,5);
				$kol6=$data->val($i,6);
				$kol7=$data->val($i,7);
				$kol8=$data->val($i,8);
				$kol9=$data->val($i,9);
				$kol10=$data->val($i,10);
				$kol11=$data->val($i,11);

				$no_dok=$kol6;

				if($kol2!=""){
					$ling="http://10.62.125.18:8080/share.cgi?ssid=6f91cac3be3d419e90e1b34441264fe8/".$kol10;

				$delsuppkon="delete from bps_kontrak_supp where lp='$sect' and kode_supp='$kol2' and no_dok='$kol6'";
				
					$qry_inst="INSERT into bps_kontrak_supp (lp,kode_supp,jns_kontrak,tgl_mulai,tgl_berakhir,no_dok,jns_dok,amount,lok_simpan,dok_ref,ket,pic_updt,tgl_updt,status_ver ) values('$sect','$kol2','$kol4',getdate(),'$kol5','$kol6','$kol7','$kol8','$kol9','$ling','$kol11','$pic',getdate(),0)";
					
				$tb_del=odbc_exec($koneksi_lp,$delsuppkon);
					$hasil = odbc_exec($koneksi_lp,$qry_inst);
					
					$del_apr="DELETE from bps_approve where jns_doc='KONTRAK' and no_doc='$no_dok' and sect='$area' ";
					$eks_delapr=odbc_exec($koneksi_lp,$del_apr);

					$ins_apr="INSERT into bps_approve(pic_plan,email_plan,no_doc,tgl_prepaire,jns_doc,sect,initial,approve,no_aprv)
					SELECT top 1 nama as pic_plan,email as email_plan,'$no_dok' as no_doc,getdate() as tgl_prepaire,
					'KONTRAK' as jns_doc,sect,initial,approve,no_aprv FROM bps_setApprove where jns_dok='PO' and status_akun='aktif' and sect='$area' and no_aprv in (2,3) order by no_aprv asc";
					$eks_insapr=odbc_exec($koneksi_lp,$ins_apr);
					// echo "<br>lht ".$i.$qry_inst;
					if(!$hasil){
						echo "<br>Error ".$i.$qry_inst;
						print(odbc_error());
					}else{ 
						$jmrow++; 
					}
				}	
			}		
			unlink($_FILES['file']['name']);	
			echo "<script>alert('$jmrow DATA SELESAI DI UPLOAD ');</script>";
		}else{ 
				// echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_Quo.php'</script>"; 
			echo "<script>alert('Format file harus XLS');</script>"; 
		}

	}


	if(isset($_POST['smpn']) or isset($_POST['del']))
	{
		$kode_supp=$_POST['kode_supp'];
		$supp=$_POST['supp'];
		$jns_kontrak=$_POST['jns_kontrak'];
			// $rg_tgl=$_POST['rg_tgl'];
		$rg_tgl=$_POST['tgl'];
		$no_dok=$_POST['no_dok'];
		$jns_dok=$_POST['jns_dok'];
		$amount=$_POST['amount'];
		$lok_simpan=$_POST['lok_simpan'];
		$dok_ref=$_FILES['dok_ref']['name'];
		$ket=$_POST['ket'];

			// $rg_tg=explode("-",$rg_tgl);
			// $rg_tgl0=date("Y-m-d",strtotime($rg_tg[0]));
			// $rg_tgl1=date("Y-m-d",strtotime($rg_tg[1]));
		$rg_tgl0=date("Y-m-d");
		$rg_tgl1=date("Y-m-d",$rg_tgl);
		$rg_tgl1=$rg_tgl;
		if(isset($_POST['smpn']) ){
			if($dok_ref=="" ){
				echo "<script>alert('TIDAK ADA DOKUMEN REFERENSI , DOKUMEN REFERENSI HARUS TERISI');</script>";
			}else{

				$nmdok="";
				$uploadDir = "./dok_quo/";
				if(isset($dok_ref)){
					if(is_uploaded_file($_FILES['dok_ref']['tmp_name'])){
						$uploadFile = $_FILES['dok_ref'];
						$extractFile = pathinfo($uploadFile['name']);
				//untuk mengetahui ukuran file
						$size = $_FILES['dok_ref']['size']; 
						if(($size !=0)&&($size>2084070)){
							exit('Ukuran gambar terlalu besar?');		
						}	
					} 
					$sameName = 0; 
	// Menyimpan banyaknya file dengan nama yang sama dengan file yg diupload
					$handle = opendir($uploadDir);
					while(false !== ($file = readdir($handle))){ 
						if(strpos($file,$extractFile['filename']) !== false)
			// Tambah data file yang sama
							$sameName++; 
					}
					$newName = empty($sameName) ? $uploadFile['name'] : $extractFile['filename'].'('.$sameName.').'.$extractFile['extension']; 
					if(move_uploaded_file($uploadFile['tmp_name'],$uploadDir.$newName)){
						$nmdok=$newName;
					}
				}
				$delsuppkon="delete from bps_kontrak_supp where lp='$sect' and kode_supp='$kode_sup' and no_dok='$no_dok'";
				$insert="INSERT INTO bps_kontrak_supp (lp,kode_supp,jns_kontrak,tgl_mulai,tgl_berakhir,no_dok,jns_dok,amount,lok_simpan,dok_ref,ket,pic_updt,tgl_updt,status_ver ) values  ";
				$qry_inst=$insert."( '$sect','$kode_supp','$jns_kontrak','$rg_tgl0','$rg_tgl1','$no_dok','$jns_dok','$amount','$lok_simpan','$dok_ref','$ket','$pic_updt',GETDATE(),0)";
						// echo $qry_inst;
				$tb_del=odbc_exec($koneksi_lp,$delsuppkon);
				$tb_add=odbc_exec($koneksi_lp,$qry_inst);

				$update=odbc_exec($koneksi_lp,"UPDATE lp_supp set no_kontrak='$no_dok',tgl_kontrak='$rg_tgl1' where SUPP_CODE='$kode_supp' ");
						// ECHO "update lp_supp set no_kontrak='$no_dok',tgl_kontrak='$rg_tgl1' where SUPP_CODE='$kode_supp' ";

				$del_apr="DELETE from bps_approve where jns_doc='KONTRAK' and no_doc='$no_dok' and sect='$area' ";
				$eks_delapr=odbc_exec($koneksi_lp,$del_apr);

				$ins_apr="INSERT into bps_approve(pic_plan,email_plan,no_doc,tgl_prepaire,jns_doc,sect,initial,approve,no_aprv)
				SELECT top 1 nama as pic_plan,email as email_plan,'$no_dok' as no_doc,getdate() as tgl_prepaire,
				'KONTRAK' as jns_doc,sect,initial,approve,no_aprv FROM bps_setApprove where jns_dok='PO' and status_akun='aktif' and sect='$area' and no_aprv in (2,3) order by no_aprv asc";
				$eks_insapr=odbc_exec($koneksi_lp,$ins_apr);
						// echo $ins_apr;
				echo "<script>alert('DATA SUDAH DI UPDATE');</script>";
			}
		}
	}
	?>
	<!-- DATA PENCARIAN START -->

	<section class="content">
		<div class="container-fluid">
			<div class="row clearfix">
				<div class="card">
					<div class="header">
						<h2>Cari Data Kontrak Supplier
							<small>Data Penawaran berikut adalah Data Budget yang Schedul penawaran dan sesuai waktu yang telah di set sebelumnya</small></h2>
						</div>
						<form role="form"  name="form2" id="form2" method="post" action="" enctype="multipart/form-data">
							<div class="col-sm-3">
								<div class="form-group">
									<label>Range Tanggal</label>
									<div class="form-line">
										<input type="text"  class="form-control" id="rg_tgl" name="rg_tgl" placeholder="Detail Pencarian" required>
									</div>
								</div>
							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<label>Purchasing</label>
									<div class="form-line">
										<select class="selectpicker" style="width: 100%;"  name="lp" id="lp">
											<option selected="selected" value="">--Purchasing--</option>
											<?php
											$tb_lp=odbc_exec($koneksi_lp,"select distinct lp from bps_budget ");//where sect='$sect'
											while($tb_lp_code=odbc_fetch_array($tb_lp)){ 
												$lp_code=odbc_result($tb_lp,"lp");
												echo '<option value="'.$lp_code.'">'.$lp_code.'</option>';
											}?>	
										</select>
									</div>		
								</div>
							</div>


							<div class="col-sm-3">	
								<div class="form-group">

									<label>Filter Kolom</label>
									<div>
										<select class="selectpicker" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
											<option selected="selected" value="">---Pilih Kolom---</option>
											<option value="kode_supp">Kode Supplier</option>
											<option value="a.part_nm">PART NAME</option>
											<option value="a.part_dtl">DETAIL PART</option>
											<option value="a.part_desc">KETERANGAN PART</option>
										</select>
									</div>
								</div>
							</div>

							<div class="col-sm-3">	
								<div class="form-group">
									<label>Detail Filter</label>
									<div class="input-group">
										<div class="form-line">
											<input type="text"  class="form-control" data-role="tagsinput" id="txt_cari" name="txt_cari" placeholder="Detail Pencarian">
										</div> 
										<span class="input-group-addon">
											<button type="submit" name="cari" id="cari" class="btn bg-purple waves-effect"><i class="material-icons">search</i> </button>
										</span>	
									</div>
								</div>
							</div>

							<div class="row clearfix">
								<div class="col-sm-12">
									<div class="body">
										<div class="table-responsive">
											<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
												<thead>
													<tr>	
														<th>Purchasing</th>
														<th>Kode Suppleir</th>
														<th>Nama Suppleir</th>
														<th>Jenis Kontrak</th>
														<th>Tanggal Mulai</th>
														<th>Tanggal Berakhir</th>
														<th>No Dokumen</th>
														<th>Jenis Dokumen</th>
														<th>Amount</th>
														<th>Lokasi Peyimpanan</th>
														<th>Dokumen Reff</th>
														<th>Keterangan</th>
														<th>PIC Update</th>
														<th>Tanggal Update</th>
														<th>Status Verifikasi</th>
														<th>Tanggal Verifikasi</th>
														<th>PIC Verifikasi</th>
													</tr>
												</thead>
												<tbody>
													<?php 
													if(isset($_POST['cari'])){
														$pchsect=explode("-",$sect);
														$cmd_cari=$_POST['cmd_cari'];
														$txt_cari=str_replace(" ","",$_POST['txt_cari']);
														if($txt_cari==""){
															$whrfil=""; 
														}else{
															$whrfil=" and replace($cmd_cari,' ','') like '%$txt_cari%'";
														}

														$lp=$_POST['lp'];
														
														if($lp==""){
															$crlp="";
														}else{
															$crlp=" and lp='$lp'";
														}

														$rg_tg=$_POST['rg_tgl'];
														$rg_tgl=explode("-",$rg_tg);
														$rg_tgl0=date("Y-m-d",strtotime($rg_tgl[0]));
														$rg_tgl1=date("Y-m-d",strtotime($rg_tgl[1]));
															// $whr=" AND (bps_budget.expaired BETWEEN '".$rg_tgl0."' AND '".$rg_tgl1."')";
															// $whr2=" AND (bps_budget_add.expaired BETWEEN '".$rg_tgl0."' AND '".$rg_tgl1."')";

														$sq_acc="SELECT ks.*,s.SUPP_NAME from bps_kontrak_supp ks left join LP_SUPP s on ks.kode_supp=s.SUPP_CODE";
//echo $sq_acc;
														$tb_acc=odbc_exec($koneksi_lp,$sq_acc);

														$row=0;
														while($baris1=odbc_fetch_array($tb_acc)){
															$row++;
															$tgend=strtotime($baris1['tgl_berakhir']);
															if($tgend<strtotime(date("Y-m-d"))){
																$sttdok="Tidak Aktif";
															}else{
																$sttdok=$baris1['no_dok'];//"Aktif";
															}
															
															?>
															<tr  onclick="javascript:pilih(this);">
																<td> <?= $baris1['lp']; ?> </td>
																<td> <?= $baris1['kode_supp']; ?> </td>
																<td> <?= $baris1['SUPP_NAME']; ?> </td>
																<td> <?= $baris1['jns_kontrak']; ?> </td>
																<td> <?= $baris1['tgl_mulai']; ?> </td>
																<td> <?= $baris1['tgl_berakhir']; ?> </td>
																<td> <?= $sttdok; ?> </td>
																<td> <?= $baris1['jns_dok']; ?> </td>
																<td> <?= $baris1['amount']; ?> </td>
																<td> <?= $baris1['lok_simpan']; ?> </td>
																<td> <?= $baris1['dok_ref']; ?> </td>
																<td> <?= $baris1['ket']; ?> </td>
																<td> <?= $baris1['pic_updt']; ?> </td>
																<td> <?= $baris1['tgl_updt']; ?> </td>
																<td> <?= $baris1['status_ver']; ?> </td>
																<td> <?= $baris1['tgl_ver']; ?> </td>
																<td> <?= $baris1['pic_ver']; ?> </td>
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
						</form>
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
				var kd_pel8=row.cells[8].innerHTML;
				if(kd_pel8=='OPEN'){
					document.form1.part_no.value=kd_pel0;
					document.form1.part_nm.value=kd_pel1;
					document.form1.part_dtl.value=kd_pel2;
					document.form1.part_desc.value=kd_pel3;
					document.form1.co_quo.value=kd_pel4;
					document.form1.est_po.value=kd_pel5;
					document.form1.lp.value=kd_pel6;
				}
			};

			$(function() {
				$('input[name="rg_tgl"]').daterangepicker({
					opens: 'left'
				}, function(start, end, label) {
					console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
				});
			});
		</script>