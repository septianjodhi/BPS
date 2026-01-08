<?php 

date_default_timezone_set("Asia/Bangkok");
include "../../koneksi.php";
$alamatplug="../../Assets/";
$term = $_POST['ap_term'] ;
$periode = $_POST['ap_peri'] ;
$colom = $_POST['cmd_cari'] ;
$isi = $_POST['txt_cari'] ;

if($isi==""){
    $whr="";
}else{
    $whr=" and replace($colom,' ','') like '%$isi%'";
}
?>
<div class="header">
    <h2 class=" pull-left">Data AP</h2>
</div>
<div class="row clearfix">
<div class="body">
<div style="overflow-x: auto;">
 <table id="tablecariap" class="table table-bordered table-striped">
   <thead>
  
<tr>  
   <th>Periode</th>
   <th>VP No</th>
   <th>Tgl VP</th>
   <th>Invoice No</th>
   <th>Tgl Inv</th>
   <th>Kode Supp</th>
   <th>Nama Supplier</th>
   <th>Supplier Site</th>
   <th>Nama Part</th>
   <th>Categori</th>
   <th>Charge Account</th>
   <th>Type Transaksi</th>
   <th>Curruncy</th>
   <th>Amount</th>
   <th>Aff ID</th>
   <th>Keterangan</th>
   <th>Create by</th>
   <th>waktu create </th>
   <th>Send by</th>
   <th>waktu Send </th>
   <th>File Send </th>
</tr> 
   </thead>
   <tbody>

<?php
$sql_stk0="select * from bps_AP where periode='$periode' $whr";
    $tb_stk0=odbc_exec($koneksi_lp,$sql_stk0);
//echo $sql_stk0;
    $bar=0;
    $info="";
    $sttbar="";
        while($bar_ap1=odbc_fetch_array($tb_stk0))
        {  
            $bar++;
                    ?>
            <tr>
                <td><?= odbc_result($tb_stk0,"periode"); ?></td>
                <td><?= odbc_result($tb_stk0,"vp_no"); ?></td>
                <td><?= odbc_result($tb_stk0,"tgl_vp"); ?></td>
                <td><?= odbc_result($tb_stk0,"inv_no"); ?></td>
                <td><?= odbc_result($tb_stk0,"tgl_inv"); ?></td>
                <td><?= odbc_result($tb_stk0,"kode_supp"); ?></td>
                <td><?= odbc_result($tb_stk0,"supplier_name"); ?></td>
                <td><?= odbc_result($tb_stk0,"supplier_site_code"); ?></td>
                <td><?= odbc_result($tb_stk0,"part_nm"); ?></td>
                <td><?= odbc_result($tb_stk0,"kategori"); ?></td>
                <td><?= odbc_result($tb_stk0,"charge_account"); ?></td>
                <td><?= odbc_result($tb_stk0,"exchange_type"); ?></td>
                <td><?= odbc_result($tb_stk0,"curr"); ?></td>
                <td><?= odbc_result($tb_stk0,"distribution_ammount"); ?></td>
                <td><?= odbc_result($tb_stk0,"org_id"); ?></td>
                <td><?= odbc_result($tb_stk0,"remark"); ?></td>
                <td><?= odbc_result($tb_stk0,"pic_update"); ?></td>
                <td><?= odbc_result($tb_stk0,"tgl_update"); ?></td>
                <td><?= odbc_result($tb_stk0,"transfer_pic"); ?></td>
                <td><?= odbc_result($tb_stk0,"transfer_date"); ?></td>
                <td><?= odbc_result($tb_stk0,"file_send"); ?></td>

            </tr> 
               <?php 
        }
?>
</tbody>

</table>
</div>
</div>
</div>

<div class="row clearfix">
    <div class="body">
        <div style="overflow-x: auto;">
             <table id="tablevp" class="table table-bordered table-striped">
               <thead>                
                    <tr>  
                       <th>No</th>
                       <th>VP No</th>
                       <th>Nama File</th>
                       <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql_stk1="select distinct vp_no,file_send from bps_AP where periode='$periode' $whr";
                        $tb_stk1=odbc_exec($koneksi_lp,$sql_stk1);
                        $bar1=0;
                        while($bar_ap1=odbc_fetch_array($tb_stk1))
                            {
                                $bar1++;
                                $lsvp=odbc_result($tb_stk1,"vp_no"); 
                                $lsnmfile=odbc_result($tb_stk1,"file_send"); 
                                $isitombol="'".$lsvp."'";
                                $tombol='<button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float waves-light" onclick="hapus_ap('.$isitombol.');"><i class="material-icons">delete_forever</i></button>';
                    ?>
                    <tr>
                        <td><?=$bar1;?></td>
                        <td><?=$lsvp;?></td>
                        <td><?=$lsnmfile;?></td>
                        <td><?=$tombol;?></td>
                    </tr>
                <?php } ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<?php include $alamatplug."assets/function_obj.php"; ?>
<script>    export_datatable('tablecariap'); </script>
<script>    export_datatable('tablevp'); </script>