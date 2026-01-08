<?php 
include "../../koneksi.php";
date_default_timezone_set("Asia/Bangkok");
$alamatplug="../../Assets/";
$pic=$_POST['nm_pic'] ;
$lokasi=$_POST['lks_bps'] ;

require_once "../../excel_reader2.php";
	//	echo "<script>alert('upload data');</script>"; 
		$file_name = $_FILES['file_supp']['name']; //nama file (tanpa path)
		$tmp_name  = $_FILES['file_supp']['tmp_name']; //nama local temp file di server
		$file_size = $_FILES['file_supp']['size']; //ukuran file (dalam bytes)
		$file_type = $_FILES['file_supp']['type']; //tipe filenya (langsung detect MIMEnya)
		$fp1 = fopen($tmp_name, 'r'); // open file (read-only, binary)
		$fp = fopen($tmp_name, 'r');		
		$pecah=explode(".",$file_name);
		$ekstensi=$pecah[1];
		$extensionList=array("xls","XLS");
		if(in_array($ekstensi,$extensionList)){		
			$target = basename($_FILES['file_supp']['name']) ;
			move_uploaded_file($_FILES['file_supp']['tmp_name'], $target);			 
			$data = new Spreadsheet_Excel_Reader($_FILES['file_supp']['name'],false);  
			$baris = $data->rowcount($sheet_index=0);
			$fixedbaris = $baris;$jmrow=0;
			for ($i=6; $i<=$fixedbaris; $i++){		
$kolA=$data->val($i,1);//Id Supplier
$kolB=$data->val($i,2);//No Supplier
$kolC=$data->val($i,3);//Nama Supplier
$kolD=$data->val($i,4);//Supplier Site
$kolE=$data->val($i,5);//Account Pay
$kolF=$data->val($i,6);//Pre pay Code
$kolG=$data->val($i,7);//ID Affiliate
$kolH=$data->val($i,8);//Code Account
$kolI=$data->val($i,9);//
$kolJ=$data->val($i,10);//Id Supp_Site
$kolK=$data->val($i,11);//Kode Supplier


if($kolK!=""){
	$sql_updt="insert into bps_supplier_fa(supplier_id,supplier_no,supplier_name,supplier_site_code,accts_pay_code_combination_id,prepay_code_combination_id,org_id,acc_code,supp_site_id,supp_code,kategori,app_nm,pic_update,tgl_update)
	values('$kolA','$kolB','$kolC','$kolD','$kolE','$kolF','$kolG','$kolH','$kolJ','$kolK','AP','BPS','$pic',getdate())";
	$sqldeldata="delete from bps_supplier_fa where  supp_code='$kolK' and supp_site_id='$kolJ'";
	$hasil = odbc_exec($koneksi_lp, $sql_updt);

//echo "<br>lht ".$i.$sql_updt;
	if(!$hasil){
		echo "<br>Error ".$i.$sql_updt;
		print(odbc_error());
	}else{ $jmrow++; }
}
}
unlink($_FILES['file_supp']['name']);	
echo "<script>alert('$jmrow DATA SELESAI DI UPLOAD ');</script>";
}else{ echo "<script>alert('Format file harus XLS');</script>"; 
}


?>