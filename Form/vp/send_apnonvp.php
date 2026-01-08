<?php 
include "../../koneksi.php";
date_default_timezone_set("Asia/Bangkok");
$alamatplug="../../Assets/";
require_once "../../excel_reader2.php";

$pic=$_POST['nm_pic'] ;
$lokasi=$_POST['lks_bps'] ;
if($lokasi=="JF"){
    $kd13="134";
    $ftpu=$ftpujf;$ftpp=$ftppjf;
    $nmfile="SAMIJ_AP_".date("Ymdhis").".csv";
}else{
    $kd13="131";
    $ftpu=$ftputf;$ftpp=$ftpptf;
    $nmfile="SAMIT_AP_".date("Ymdhis").".csv";
}
$alamatfile = '../../exp_csvtxt/'.$nmfile;

?>
<div class="header">
    <h2 class=" pull-left">Data AP</h2>
</div>
<div class="body">
<div style="overflow-x: auto;">
 <table id="tablesendap" class="table table-bordered table-striped">
   <thead>
  
<tr>  
   <th>No</th>
   <th>Supplier name</th>
   <th>Supplier Site</th>
   <th>Tgl invoice</th>
   <th>Invoice</th>
   <th>Categori</th>
   <th>BL/VP No</th>
   <th>Charge Account</th>
   <th>Amount</th>
   <th>Aff ID</th>
   <th>Type Transaksi</th>
   <th>Tgl GL/VP</th>
   <th>Currency</th>
   <th>Exchange </th>
   <th>Tgl Rate</th>
   <th>Data Error</th>
</tr> 
   </thead>
   <tbody>

<?php
        $file_name = $_FILES['file_ap']['name']; //nama file (tanpa path)
        $tmp_name  = $_FILES['file_ap']['tmp_name']; //nama local temp file di server
        $file_size = $_FILES['file_ap']['size']; //ukuran file (dalam bytes)
        $file_type = $_FILES['file_ap']['type']; //tipe filenya (langsung detect MIMEnya)
        $fp1 = fopen($tmp_name, 'r'); // open file (read-only, binary)
        $fp = fopen($tmp_name, 'r');        
        $pecah=explode(".",$file_name);
        $ekstensi=$pecah[1];
        $extensionList=array("xls","XLS");
        if(in_array($ekstensi,$extensionList)){     
            $target = basename($_FILES['file_ap']['name']) ;
            move_uploaded_file($_FILES['file_ap']['tmp_name'], $target);           
            $data = new Spreadsheet_Excel_Reader($_FILES['file_ap']['name'],false);  
            $baris = $data->rowcount($sheet_index=0);
            $fixedbaris = $baris;$jmrow=0;
        $fX = fopen($alamatfile, 'w');
        $bar=0;
        $info="";
            for ($i=4; $i<=$fixedbaris; $i++){      
$kolA=$data->val($i,1);//No
$kolB=$data->val($i,2);//VP No
$kolC=$data->val($i,3);//Kode Supp
$kolD=$data->val($i,4);//Part Name
$kolE=$data->val($i,5);//Type Row
$kolF=$data->val($i,6);//SUPPLIER NAME
$kolG=$data->val($i,7);//SUPPLIER SITE
$kolH=$data->val($i,8);//INVOICE DATE
$kolI=$data->val($i,9);//INVOICE NUM (AP)
$kolJ=$data->val($i,10);//REFF. NO
$kolK=$data->val($i,11);//BL/AWB
$kolL=$data->val($i,12);//CHARGE ACCOUNT
$kolM=$data->val($i,13);//AMOUNT
$kolN=$data->val($i,14);//ORG ID
$kolO=$data->val($i,15);//TRANSACTION TYPE
$kolP=$data->val($i,16);//GL DATE
$kolQ=$data->val($i,17);//CURRENCY
$kolR=$data->val($i,18);//EXCHANGE TYPE
$kolS=$data->val($i,19);//EXCHANGE RATE DATE

$pchvp=explode("-", $kolB);
$periode=$pchvp[2];
$vp=$kolB;
$tglvp=date("Y-m-d",strtotime($kolS));
$invno=$kolI;
$tglinv=date("Y-m-d",strtotime($kolH));
$supp_bps=$kolC;
$supp_orc=$kolF;
$supsite=$kolG;
$partnm=$kolD;
$chgtype=$kolO;
$chg_acc=$kolL;
$rate_typ=$kolR;
$curr=$kolQ;
$refno=$kolJ;

$amn=str_replace(",","",$kolM);
$idaff=$kolN;
$pchacc=explode(".",$kolL);
switch ($pchacc[3]) {
    case '1181101':
        $kodebar="1";
        $typ_row="pajak";
        break;
    case '111290':
        $kodebar="1";
        $typ_row="pajak";
        break;
    
    default:
        $kodebar="0";
        $typ_row="bayar";
        break;
}


if($kolB!="" ){
    $sqlins="insert into bps_ap(periode,vp_no,tgl_vp,inv_no,tgl_inv,kode_supp,supplier_name,supplier_site_code,part_nm,kategori,charge_account,exchange_type,curr,distribution_ammount,org_id,remark,pic_update,tgl_update,row_stt,row_ap,transfer_status) values";
            //,transfer_pic,transfer_date,file_send
    $valap0="('$periode','$vp','$tglvp','$invno','$tglinv','$supp_bps','$supp_orc','$supsite','$partnm','$chgtype','$chg_acc','$rate_typ','$curr','$amn','$idaff','$refno','$pic',getdate(),'$typ_row','$kodebar','create')";
   

    //$sqldeldata="delete from bps_supplier_fa where  supp_code='$kolK' and supp_site_id='$kolJ'";
    $sql_updt=$sqlins.$valap0;
    $hasil = odbc_exec($koneksi_lp, $sql_updt);

//echo "<br>lht ".$i.$sql_updt;
    if(!$hasil){
        /*echo "<br>Error ".$i.$sql_updt;
        print(odbc_error());*/
        $info="Gagal";
        $sttbar="Data Tidak sesuai Format";
    }else{ $jmrow++; 
        $sttbar="Data OK";
    }
        $dtl0='"'.$supp_orc.'","'.$supsite.'","'.$tglinv.'","'.$invno.'","'.$refno.'","'.$vp.'","'.$chg_acc.'","'.$amn.'","'.$idaff.'","'.$chgtype.'","'.$tglvp.'","'.$curr.'","'.$rate_typ.'","'.$tglvp.'","'.$tglvp.'"';
        fwrite($fX,$dtl0);
        fwrite($fX, "\r\n");
?>
            <tr>
               <td><?= $i;?></td>
               <td><?= $supp_orc ?></td>
               <td><?= $supsite;?></td>
               <td><?= $tglinv; ?></td>
               <td><?= $invno; ?></td>
               <td><?= $partnm; ?></td>
               <td><?= $vp; ?></td>
               <td><?= $chg_acc; ?></td>
               <td><?= $amn; ?></td>
               <td><?= $idaff; ?></td>
               <td><?= $chgtype; ?></td>
               <td><?= $tglvp; ?></td>
               <td><?= $curr; ?></td>
               <td><?= $rate_typ; ?></td>
               <td><?= $tglvp; ?></td>
               <td><?= $sttbar; ?></td>
            </tr> 
<?php 
}
}
unlink($_FILES['file_ap']['name']);   
fclose($fX);
 $whrupdt=" where  file_send is null";
/*Upload ke FTP*/
     if($info=="Gagal"){
            unlink($alamatfile);
        //    $tb_insertap=odbc_exec($koneksi_lp,$sql_delap);
            echo "<script>alert('Gagal ,Terdapat mising data');</script>"; 
        }else{
echo "<h3>Nama File yang di Upload $nmfile</h3>";
            $ftp_server = $ftp_orafin;
            $ftp_conn = ftp_connect($ftp_server) or die("Tidak dapat terhubung ke FTP $ftp_server");
            $login = ftp_login($ftp_conn,$ftpu,$ftpp);
            ftp_pasv($ftp_conn, true);
        $dest = 'INT_ORAFIN/NEW/AP/'.$nmfile;
            if (ftp_put($ftp_conn, $dest, $alamatfile, FTP_ASCII))
              {  
        $tb_updtstt = odbc_exec($koneksi_lp,"update bps_ap set transfer_date=getdate(),transfer_pic='$pic',file_send='$dest',transfer_status='CLOSE' $whrupdt");    
        echo "<script>alert('INVOICE SUDAH SELESAI DI TRANSFER SILAHKAN TUNGGU SCHEDULE EKSEKUSI DARI PASI ATAU DI PROSES MELALUI ORACLE FINANCE');</script>";
          //echo "<script>alert('Successfully uploaded $file ');</script>"; 
          }
            else { echo "<script>alert('Gagal upload ke FTP $dest');</script>";  
            echo "<script>alert('$ftp_orafin  $ftpu  $ftpp');</script>";    
            }
            ftp_close($ftp_conn);   
        }



echo "<script>alert('$jmrow DATA SELESAI DI UPLOAD ');</script>";
}else{ echo "<script>alert('Format file harus XLS');</script>"; 
}

?>
</tbody>

</table>
</div>
</div>
<?php include $alamatplug."assets/function_obj.php"; ?>
<script>    export_datatable('tablesendap'); </script>