<?php 
include "../../koneksi.php";
date_default_timezone_set("Asia/Bangkok");
$alamatplug="../../Assets/";
$vp = $_POST['vp_o'] ;
$periode = $_POST['pervp_o'] ;
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
$sql_delap="delete bps_ap where vp_no='$vp' and file_send is null";
$tb_insertap=odbc_exec($koneksi_lp,$sql_delap);

$sql_stk0="select distinct  d.kode_supp,d.inv_tgl,d.inv_no,d.part_nm,d.vp_no,'$kd13.'+d.kd_car+'.'+d.account+'.'+d.dept_code+'$kd13.0000.0000.0000'[chg_account]
,d.faktur_pajak[transaksi],d.tgl_vp,d.curr,'Corporate'[chg_type],d.tgl_vp[rate_date]
,s.SUPPLIER_NAME,s.SUPPLIER_SITE_CODE,s.ORG_ID,d.cccode
,sum(d.amount)[amount],sum(d.pajak)[pajak]
from bps_vporafin d left join (select * from BPS_SUPPLIER_FA where supp_site_id='2') s on d.kode_supp=s.supp_code
 where d.vp_no='$vp'
 group by
 d.inv_tgl,d.inv_no,d.part_nm,d.vp_no,d.kd_car,d.account,d.dept_code,d.faktur_pajak,d.tgl_vp,d.curr,s.SUPPLIER_NAME,s.SUPPLIER_SITE_CODE,s.ORG_ID, d.kode_supp,d.cccode";
    $tb_stk0=odbc_exec($koneksi_lp,$sql_stk0);
//echo $tb_stk0;
$fX = fopen($alamatfile, 'w');
    $bar=0;
    $info="";
        while($bar_vp=odbc_fetch_array($tb_stk0))
        {  
            $sttbar="";
            $bar++;
            $supp_orc=odbc_result($tb_stk0,"supplier_name"); 
            $supp_bps=odbc_result($tb_stk0,"kode_supp"); 
            $invno=odbc_result($tb_stk0,"inv_no"); 
            $cccode=odbc_result($tb_stk0,"cccode"); 
            $chgtype=odbc_result($tb_stk0,"transaksi").",".$invno.",VAT,".$invno.",".$vp; 
            if ($supp_orc =="") {
            $sttbar .="<li>Master Supplier FA ($supp_bps)</li>";
            $info="Gagal";
            }
            if ($cccode =="") {
            $sttbar .="<li>CC CODE $cccode belum tersedia</li>";
            $info="Gagal";
            }
            $supsite=odbc_result($tb_stk0,"supplier_site_code"); 
            $tglinv=date("Y-m-d",strtotime(odbc_result($tb_stk0,"inv_tgl")));
            $partnm=odbc_result($tb_stk0,"part_nm");
            $chg_acc=odbc_result($tb_stk0,"chg_account");
            $rate_typ=odbc_result($tb_stk0,"chg_type");
            $amn=number_format(odbc_result($tb_stk0,"amount"),2,".","");
            $pajak=number_format(odbc_result($tb_stk0,"pajak"),2,".","");
            $idaff=odbc_result($tb_stk0,"org_id");
            $tglvp=date("Y-m-d",strtotime(odbc_result($tb_stk0,"tgl_vp")));
            $curr=odbc_result($tb_stk0,"curr");

            $sqlins="insert into bps_ap(periode,vp_no,tgl_vp,inv_no,tgl_inv,kode_supp,supplier_name,supplier_site_code,part_nm,kategori,charge_account,exchange_type,curr,distribution_ammount,org_id,remark,pic_update,tgl_update,row_stt,row_ap,transfer_status) values";
            //,transfer_pic,transfer_date,file_send
            $valap0="('$periode','$vp','$tglvp','$invno','$tglinv','$supp_bps','$supp_orc','$supsite','$partnm','$chgtype','$chg_acc','$rate_typ','$curr','$amn','$idaff','$supp_orc','$pic',getdate(),'bayar','0','create')";
            $valap1="('$periode','$vp','$tglvp','$invno','$tglinv','$supp_bps','$supp_orc','$supsite','$partnm','$chgtype','$chg_acc','$rate_typ','$curr','$pajak','$idaff','$chgtype','$pic',getdate(),'pajak','1','create')";

            $dtl0='"'.$supp_orc.'","'.$supsite.'","'.$tglinv.'","'.$invno.'","'.$partnm.'","'.$vp.'","'.$chg_acc.'","'.$amn.'","'.$idaff.'","'.$supp_orc.'","'.$tglvp.'","'.$curr.'","'.$rate_typ.'","'.$tglvp.'","'.$tglvp.'"';
            
            ?>
            <tr>
               <td><?=$bar;?></td>
               <td><?= $supp_orc ?></td>
               <td><?= $supsite;?></td>
               <td><?= $tglinv; ?></td>
               <td><?= $invno; ?></td>
               <td><?= $partnm; ?></td>
               <td><?= $vp; ?></td>
               <td><?= $chg_acc; ?></td>
               <td><?= $amn; ?></td>
               <td><?= $idaff; ?></td>
               <td><?= $supp_orc; ?></td>
               <td><?= $tglvp; ?></td>
               <td><?= $curr; ?></td>
               <td><?= $rate_typ; ?></td>
               <td><?= $tglvp; ?></td>
               <td><ul><?= $sttbar; ?></ul></td>
            </tr> 
            <?php 

            ?>
            <tr>
                <td><?=$bar;?></td>
               <td><?= $supp_orc ?></td>
               <td><?= $supsite; ?></td>
               <td><?= $tglinv; ?></td>
               <td><?= $invno; ?></td>
               <td><?= $partnm; ?></td>
               <td><?= $vp; ?></td>
               <td><?= $chg_acc; ?></td>
               <td><?= $pajak; ?></td>
               <td><?= $idaff; ?></td>
               <td><?= $chgtype; ?></td>
               <td><?= $tglvp; ?></td>
               <td><?= $curr; ?></td>
               <td><?= $rate_typ; ?></td>
               <td><?= $tglvp; ?></td>
               <td><ul><?= $sttbar; ?></ul></td>
            </tr> 
               <?php 
               $dtl1='"'.$supp_orc.'","'.$supsite.'","'.$tglinv.'","'.$invno.'","'.$partnm.'","'.$vp.'","'.$chg_acc.'","'.$pajak.'","'.$idaff.'","'.$chgtype.'","'.$tglvp.'","'.$curr.'","'.$rate_typ.'","'.$tglvp.'","'.$tglvp.'"';
               fwrite($fX,$dtl0);
               fwrite($fX, "\r\n"); 
               fwrite($fX,$dtl1);
               fwrite($fX, "\r\n"); 
               $tb_insertap=odbc_exec($koneksi_lp,$sqlins.$valap0.",".$valap1);
        }
        //echo $sqlins.$valap0.",".$valap1;
        $whrupdt=" where vp_no='$vp' and file_send is null";
        fclose($fX);
        if($info=="Gagal"){
            unlink($alamatfile);
            $tb_insertap=odbc_exec($koneksi_lp,$sql_delap);
            echo "<script>alert('Gagal ,Terdapat mising data');</script>"; 
        }else{
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
        //echo $sqlins.$valap0.",".$valap1;
?>
</tbody>

</table>
</div>
</div>
<?php include $alamatplug."assets/function_obj.php"; ?>
<script>    export_datatable('tablesendap'); </script>