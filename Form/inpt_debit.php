<script>
	function cr_supp(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
		document.form1.no_quo.value="";
	};
	function clear_noquo(){
		document.form1.no_quo.value="";
	};  
	function cr_ctrl(url,title,w,h){
		var pno=document.form1.part_no.value;
		var pnm=document.form1.part_nm.value;
		var pndt=document.form1.part_dtl.value;
		var pnde=document.form1.part_desc.value;
		var lp=document.form1.lp.value;
		if(pnm==""){alert('DATA BELUM LENGKAP');}else{   
			var left = (screen.width/2)-(w/2);
			var top = (screen.height/2)-(h/2);
			w = window.open(url+'&p1='+pnm+'&p2='+pndt+'&p3='+pnde+'&l='+lp, title, 'toolbar=no, location=no, directories=no, \n\
				status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
				width='+w+',height='+h+',top='+top+',left='+left);	

		}		
	};	
	function cr_noquo(url,title,w,h){
		var ks=document.form1.kode_supp.value;
		if(ks==""){alert('SUPPLIER BELUM DIPILIH');}else{   
			var left = (screen.width/2)-(w/2);
			var top = (screen.height/2)-(h/2);
			w = window.open(url+'&s='+ks, title, 'toolbar=no, location=no, directories=no, \n\
				status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
				width='+w+',height='+h+',top='+top+',left='+left);	
		}	

	};
</script>
<?php $sect= $_SESSION["area"]; ?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>TAGIHAN</h2>
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
					<div role="tabpanel" class="tab-pane fade in active" id="manual">
						<div class="header"><h2>INPUT TAGIHAN</h2></div>
						<div class="body">
							<form role="form"  name="form1" id="form1" method="post" action="" enctype="multipart/form-data">
								<div class="body">
									<div class="row clearfix">
										<div class="col-md-3">
											<div class="form-group">
												<label>Part No</label>
												<div class="form-line">
													<input type="text"  readonly class="bg-yellow form-control" id="part_no" name="part_no" placeholder="Part No" required>
												</div>
											</div>
										</div>                
										<div class="col-md-3">		
											<div class="form-group">
												<label>Nama Part</label>
												<div class="form-line">
													<input type="text" readonly class="bg-yellow form-control" id="part_nm" name="part_nm" placeholder="Nama Part" required>
												</div>
											</div>
										</div>                
										<div class="col-md-3">		
											<div class="form-group">
												<label>Detail Part</label>
												<div class="form-line">
													<input type="text"  readonly class="bg-yellow form-control" id="part_dtl" name="part_dtl" placeholder="Detail Part" required>
												</div>
											</div>
										</div>                
										<div class="col-md-3">			
											<div class="form-group">
												<label>Deskripsi</label>
												<div class="form-line">
													<input type="text" readonly class="bg-yellow form-control" id="part_desc" name="part_desc" placeholder="Deskripsi">
												</div>
											</div>
										</div>                
									</div>				
									<div class="row clearfix">
										<div class="col-md-2">
											<div class="form-group">
												<label>Purchasing</label>
												<div class="form-line">
													<input type="text" readonly class="bg-yellow form-control" id="lp" name="lp" placeholder="Purchasing" required>
												</div>
											</div>
										</div>                
										<div class="col-md-2">		
											<div class="form-group">
												<label>Cut Off Penawaran</label>
												<div class="form-line">
													<input type="text" readonly class="bg-yellow form-control" id="co_quo" name="co_quo" placeholder="Cut Off Penawaran" required>
												</div>
											</div>
										</div>                
										<div class="col-md-2">	
											<div class="form-group">
												<label>Estimasi PO</label>
												<div class="form-line">
													<input type="text" readonly class="bg-yellow form-control" id="est_po" name="est_po" placeholder="Estimasi PO" required>
												</div></div></div> 
												<div class="col-md-2">	
													<div class="form-group">
														<label>Berlaku (Hari)</label>
														<div class="form-line">
															<input type="number" min="1" class="form-control" id="day_aktf" name="day_aktf" placeholder="Masa Berlaku" required>

														</div>
													</div>
												</div>  
												<div class="col-md-2">	
													<div class="form-group">
														<label>Exp.Penawaran</label>
														<div class="form-line">
															<input type="text"  class="form-control date-min" id="exp_quo" name="exp_quo"  placeholder="Exp.Penawaran" required>				
														</div>
													</div>
												</div>
												<div class="col-md-2">	
													<div class="form-group">
														<label>Price</label>
														<div class="form-line">
															<input type="number" class="form-control" id="price" name="price" step="any" placeholder="Price" required>				
														</div>
													</div>
												</div>
											</div>
											<div class="row clearfix">
												<div class="col-md-2">	
													<div class="form-group">
														<label>Code Supplier</label>
														<div class="input-group">
															<div class="form-line">
																<input type="text" readonly class="form-control" id="kode_supp" name="kode_supp" placeholder="Kode Supplier" required>
															</div>
															<span class="input-group-addon">
																<button type="button" class="btn bg-red waves-effect"  onclick="cr_supp('template.php?plh=select/plh_supp.php&c=kode_supp','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
															</span>
														</div>
													</div>
												</div>
												<div class="col-md-3">	
													<div class="form-group">
														<label>No Penawaran</label>
														<div class="input-group">
															<div class="form-line">
																<input type="text" readonly class="form-control" id="no_quo" name="no_quo" placeholder="No Penawaran" required>
															</div>
															<span class="input-group-addon">
																<button type="button" class="btn bg-red waves-effect"  onclick="cr_noquo('template.php?plh=select/cek_noquo.php&o=no_quo&p=<?php echo date("Ym"); ?>','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
															</span>
														</div>
													</div>
												</div>
												<div class="col-md-3">	 
													<div class="form-group">
														<label>Dok.Referensi</label>
														<div class="form-line">
															<input type="file" class="form-control" id="dok_ref" name="dok_ref" placeholder="Dok.Referensi" >				
														</div></div></div>
														<div class="col-md-2">	 
															<div class="form-group">
																<label>Rekomendasi</label>
																<div class="form-line">
																	<div class="switch" ><label><input type="checkbox" name="rekom" id="rekom" value="YES" ><span class="lever"></span>
																	</label>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">	
													<div class="col-md-6">	 
														<div class="form-group">
															<label>Link.Referensi</label>
															<div class="form-line">
																<input type="text" class="form-control" id="link_ref" name="link_ref" placeholder="Link.Referensi">				
															</div>
														</div>
													</div>
													<div class="col-md-6">	
														<div class="form-group">
															<label>Keterangan</label>
															<div class="form-line">
																<input type="text" class="form-control" id="ket_quo" name="ket_quo" placeholder="Keterangan">
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">		 
													<button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
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
													<li><a href="javascript:void(0);">Action</a></li>
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
													</div></div>		
													<div class="col-md-3">	
														<button type="button" class="btn btn-outline-secondary" onclick="open_child('http://10.62.125.18:8080/share.cgi?ssid=0wSxpzb','upload','800','500'); return false;">DOK.REFF</button>
													</div></div>
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
			//$sect_u=$data->val(5,2)."-".$data->val(5,4);
			$periode=DATE("Ym");
			$pic=$_SESSION['nama'];
			$jmrow=0;
			//echo $sql_del;
			for ($i=7; $i<=$fixedbaris; $i++){		
//$kolA=$data->val($i,1);//no
$kolB=$data->val($i,2);//PART NO
$kolC=$data->val($i,3);//PART NAME
$kolD=$data->val($i,4);//PART DTL
$kolE=$data->val($i,5);//PART DESC
$kolF=str_replace(' ', '',$data->val($i,6));//KODE SUPP
$kolG=$data->val($i,7);//EXP. QUO
$kolH=$data->val($i,8);//PRICE
$kolI=$data->val($i,9);//LINK REFF
$kolJ=$data->val($i,10);//KETERANGAN
$kolK=$data->val($i,11);//REKOMEN
$experied=strtotime($kolG);

if($kolB!=""){
	$day_aktf=($experied-strtotime(date("Y-m-d h:i:s")))/1440;
	$sql1="select MAX(RIGHT(no_quo,4)) as c from bps_quotation where no_quo like '$kolF-$periode%'";
// echo $sql1;
	$jmdt=0;
	$tb_area=odbc_exec($koneksi_lp,$sql1);
	while($baris1=odbc_fetch_array($tb_area)){
		$jmdt=odbc_result($tb_area,"c");	  
	}
	$jmdt=$jmdt+1;
	$no_quo=$kolF."-".$periode."-".substr("0000".$jmdt,-4);
// $ling="http://10.62.125.18:8080/share.cgi?ssid=0sJ6wVR#0sJ6wVR/Quotation/".$kolI;
	$ling="http://10.62.125.18:8080/share.cgi?ssid=0wSxpzb#0wSxpzb/Quotation".$kolI;

//$hilang=odbc_exec($koneksi_lp,"Delete from bps_quotation".$sql_del);
	$qry_inst="insert into bps_quotation(part_no,part_nm,part_dtl,part_desc,kode_supp,no_quo,exp_quo,price,link_ref,day_aktf,ket_quo,stts_updt,lp_rekom,pic_updt,tgl_updt,sect,jns_dok) values('$kolB','$kolC','$kolD','$kolE','$kolF','$no_quo','$kolG','$kolH','$ling','$day_aktf','$kolJ','UnUse','$kolK','$pic',getdate(),'$sect','Tagihan')";

	$hasil = odbc_exec($koneksi_lp,$qry_inst);	
//echo "<br>lht ".$i.$qry_inst;
	if(!$hasil){
		echo "<br>Error ".$i.$qry_inst;
		print(odbc_error());
	}else{ $jmrow++; }
}	}		
unlink($_FILES['file']['name']);	
echo "<script>alert('$jmrow DATA SELESAI DI UPLOAD ');</script>";
$sq_acc="select * from bps_quotation where tgl_updt=getdate() and pic_updt='$pic'";

}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_Quo.php'</script>"; }

}


if(isset($_POST['smpn']) or isset($_POST['del'])){
	$pic_updt=$_SESSION['nama'];
	$part_no=$_POST['part_no'];	
	$part_nm=$_POST['part_nm'];	
	$part_dtl=$_POST['part_dtl'];	
	$part_desc=$_POST['part_desc'];	
	$kode_supp=$_POST['kode_supp'];
	$no_quo=$_POST['no_quo'];
	$exp_quo=$_POST['exp_quo'];
	$price=$_POST['price'];
	$dok_ref=$_FILES['dok_ref']['name'];
	$link_ref=$_POST['link_ref'];
	$ket_quo=$_POST['ket_quo'];
	$day_aktf=$_POST['day_aktf'];
	$pc_sect=explode("-",$sect);

	if(isset($_POST['rekom'])){$rekom="YES";
	$qry_ganti="update bps_quotation set lp_rekom='NO' where part_no='$part_no' and part_nm='$part_nm' and part_dtl='$part_dtl' and exp_quo>=getdate()";
	$tb_ganti=odbc_exec($koneksi_lp,$qry_ganti);
}else{$rekom="NO";}
$qry_del="delete from bps_quotation where no_quo='$no_quo'";

$tb_chg=odbc_exec($koneksi_lp,$qry_del);
if(isset($_POST['smpn']) ){	
	if($dok_ref=="" and $link_ref==""){
		echo "<script>alert('TIDAK ADA DOKUMEN REFERENSI , DOK REF ATAU LINK REF HARUS TERISI');</script>";
	}else{

		$nmdok="";
		$uploadDir = "./dok_quo/";
		if(isset($dok_ref)){	
			if(is_uploaded_file($_FILES['dok_ref']['tmp_name'])){
				$uploadFile = $_FILES['dok_ref'];
				$extractFile = pathinfo($uploadFile['name']);
		$size = $_FILES['dok_ref']['size']; //untuk mengetahui ukuran file
	/*	$tipe = $_FILES['dok_ref']['type'];// untuk mengetahui tipe file
		$exts =array('image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png');
		if(!in_array(($tipe),$exts)){
			echo 'Format file yang di izinkan hanya JPEG dan PNG';
			exit;		}
	*/
			if(($size !=0)&&($size>2084070)){exit('Ukuran gambar terlalu besar?');		}	
		} 
	$sameName = 0; // Menyimpan banyaknya file dengan nama yang sama dengan file yg diupload
	$handle = opendir($uploadDir);
	while(false !== ($file = readdir($handle))){ 
		if(strpos($file,$extractFile['filename']) !== false)
		$sameName++; // Tambah data file yang sama
}
$newName = empty($sameName) ? $uploadFile['name'] : $extractFile['filename'].'('.$sameName.').'.$extractFile['extension']; 
if(move_uploaded_file($uploadFile['tmp_name'],$uploadDir.$newName)){
	$nmdok=$newName;
}}
//echo "<script>alert('$dok_ref');</script>";
if($part_desc==""){$part_desc="NULL";}else{$part_desc="'$part_desc'";}
$qry_inst="insert into bps_quotation(part_no,part_nm,part_dtl,part_desc,kode_supp,no_quo,exp_quo,price,dok_ref,link_ref,day_aktf,ket_quo,stts_updt,lp_rekom,pic_updt,tgl_updt,sect,jns_dok) values('$part_no','$part_nm','$part_dtl',$part_desc,'$kode_supp','$no_quo','$exp_quo','$price','$nmdok','$link_ref','$day_aktf','$ket_quo','UnUse','$rekom','$pic_updt',getdate(),'$sect','Tagihan')";

//echo $qry_inst;
$tb_add=odbc_exec($koneksi_lp,$qry_inst);
echo "<script>alert('DATA SUDAH DI UPDATE');</script>";
//$sq_acc="select * from bps_budget where no_ctrl='$no_ctrl'";
}}}
?>	 
<div class="row clearfix">
	<div class="card">
		<div class="header">
			<h2>Cari Tagihan
				<small>Data Tagihan berikut adalah Data Budget Tanpa Penawaran dan sesuai waktu yang telah di set sebelumnya</small></h2>
			</div>
			<form role="form"  name="form2" id="form2" method="post" action="" enctype="multipart/form-data">
				<div class="col-sm-3">
					<div class="form-group">
						<label>Range Tanggal</label>
						<div class="form-line">
							<input type="text"  class="form-control" id="rg_tgl" name="rg_tgl" placeholder="Detail Pencarian" required>
						</div>		
					</div></div>
					<div class="col-sm-3">	
						<div class="form-group">
							<label>Filter Kolom</label>
							<div>
								<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
									<option selected="selected" value="">---Pilih Kolom---</option>
									<option value="part_no">PART NO</option>
									<option value="part_nm">PART NAME</option>
									<option value="part_dtl">DETAIL PART</option>
									<option value="part_desc">KETERANGAN PART</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-6">	
						<div class="form-group">
							<label>Detail Filter</label>
							<div class="input-group">
								<div class="form-line">
									<input type="text"  class="form-control" data-role="tagsinput" id="txt_cari" name="txt_cari" placeholder="Detail Pencarian">
								</div> 
								<span class="input-group-addon">
									<button type="submit" name="cr_tgl" id="cr_tgl" class="btn bg-purple waves-effect"><i class="material-icons">search</i> </button>
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
												<th>PART NO</th>
												<th>NAMA PART</th>
												<th>DETAIL PART</th>
												<th>KET. PART</th>
												<th>BATAS PENAWARAN</th>
												<th>ESTIMASI PO</th>
												<th>PURCHASING</th>
												<th>JUMLAH SUPP</th>
												<th>STATUS</th>
											</tr>
										</thead>
									</form>

									<tbody>
										<?php 
										if(isset($_POST['cr_tgl'])){
											$pchsect=explode("-",$sect);
											$cmd_cari=$_POST['cmd_cari'];
											$txt_cari=str_replace(" ","",$_POST['txt_cari']);
											if($txt_cari==""){$whrfil=""; }else{
												$whrfil=" and replace($cmd_cari,' ','') like '%$txt_cari%'";}
//$lp=$_POST['lp'];
//if($lp==""){$crlp=="";}else{$crlp=" and lp='$lp'";}
												$rg_tg=$_POST['rg_tgl'];
												$rg_tgl=explode("-",$rg_tg);
												$rg_tgl0=date("Y-m-d",strtotime($rg_tgl[0]));
												$rg_tgl1=date("Y-m-d",strtotime($rg_tgl[1]));
												$whr=" AND (bps_budget.expaired BETWEEN '".$rg_tgl0."' AND '".$rg_tgl1."')";

												$sq_acc="select distinct expaired,part_no,part_nm,part_dtl,part_desc,lp,min(lt_vp) as lt_vp,min(lt_datang)as lt_datang,min(lt_po) as lt_po,min(lt_pr) as lt_pr,min(lt_Quo) as lt_Quo,(select count(distinct kode_supp) as c_sup from bps_quotation where exp_quo>=getdate() and part_nm=bps_budget.part_nm and part_no=bps_budget.part_no and part_dtl=bps_budget.part_dtl) as jm_quo from bps_budget where dbo.cr_proseslp('quo',id_proses)='NO' and sect='$sect' $whr $whrfil group by part_no,part_nm,part_dtl,part_desc,lp,expaired
												UNION
												select distinct expaired,part_no,part_nm,part_dtl,part_desc,lp,min(lt_vp) as lt_vp,min(lt_datang)as lt_datang,min(lt_po) as lt_po,min(lt_pr) as lt_pr,min(lt_Quo) as lt_Quo,(select count(distinct kode_supp) as c_sup from bps_quotation where exp_quo>=getdate() and part_nm=bps_budget_add.part_nm and part_no=bps_budget_add.part_no and part_dtl=bps_budget_add.part_dtl) as jm_quo from bps_budget_add where dbo.cr_proseslp('quo',id_proses)='NO' and sect='$sect' AND (bps_budget_add.expaired BETWEEN '".$rg_tgl0."' AND '".$rg_tgl1."') $whrfil and kode_chg in (4,5) group by part_no,part_nm,part_dtl,part_desc,lp,expaired";
												// echo $sq_acc;
												$tb_acc=odbc_exec($koneksi_lp,$sq_acc);

												$row=0;
												while($baris1=odbc_fetch_array($tb_acc)){
													$row++;
													$expaired=odbc_result($tb_acc,"expaired");	
													$lt_vp=Odbc_result($tb_acc,"lt_vp");
													$lt_datang=odbc_result($tb_acc,"lt_datang");
													$lt_po=odbc_result($tb_acc,"lt_po");
													$lt_pr=odbc_result($tb_acc,"lt_pr");
													$lt_Quo=odbc_result($tb_acc,"lt_Quo");
													$lt_datang_cumm=$lt_datang+$lt_vp;
													$lt_po_cumm=$lt_po+$lt_datang_cumm;
													$lt_pr_cumm=$lt_pr+$lt_po_cumm;
													$lt_Quo_cumm=$lt_Quo+$lt_pr_cumm;
													$view_lt_po=date('Y-m-d', strtotime($expaired. " - $lt_po_cumm days"));
													$view_lt_Quo=date('Y-m-d', strtotime($expaired. " - $lt_Quo_cumm days"));
													$strtime_quo=strtotime($view_lt_Quo);
													$strtime_now=strtotime(date("Y-m-d"));
													if($strtime_quo>=$strtime_now){$sttquo="OPEN";}else{$sttquo="BERAKHIR";}
													?>

													<tr  onclick="javascript:pilih(this);">
														<td><?php echo odbc_result($tb_acc,"part_no"); ?></td>
														<td><?php echo odbc_result($tb_acc,"part_nm"); ?></td>
														<td><?php echo odbc_result($tb_acc,"part_dtl"); ?></td>
														<td><?php echo odbc_result($tb_acc,"part_desc"); ?></td>
														<td><?php echo $view_lt_Quo; ?></td>
														<td><?php echo $view_lt_po; ?></td>
														<td><?php echo odbc_result($tb_acc,"lp"); ?></td>
														<td><?php echo odbc_result($tb_acc,"jm_quo"); ?></td>
														<td><?php echo $sttquo; ?></td>
													</tr>

													<?php 
												}}
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



 //$(function() {
  //$('input[name="rg_tgl"]').daterangepicker({
    //timePicker: true,
    //startDate: moment().startOf('hour'),
    //endDate: moment().startOf('hour').add(32, 'hour'),
    //locale: {
      //format: 'M/DD/YYYY'
    //}
  //});
//});

$(document).ready(function()
{

	$('.periodemn').bootstrapMaterialDatePicker({
		format: 'YYYYMM', minDate : new Date(),
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