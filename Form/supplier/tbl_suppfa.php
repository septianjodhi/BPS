<?php 

date_default_timezone_set("Asia/Bangkok");
include "../../koneksi.php";
$alamatplug="../../Assets/";
$colom = $_POST['cmd_cari'] ;
$isi = $_POST['txt_cari'] ;

if($isi==""){
    $whr="";
}else{
    $whr=" where replace($colom,' ','') like '%$isi%'";
}
?>
<div class="header">
    <h2 class=" pull-left">Data Supplier</h2>
</div>
<div class="row clearfix">
<div class="body">
<div style="overflow-x: auto;">
 <table id="tablecarisuppfa" class="table table-bordered table-striped">
   <thead>
  
<tr>  
<th>Id Supplier</th>
<th>No Supplier</th>
<th>Nama Supplier</th>
<th>Supplier Site</th>
<th>Account Pay</th>
<th>Pre pay Code</th>
<th>ID Affiliate</th>
<th>Code Account</th>
<th>Kategori</th>
<th>Id Supp_Site</th>
<th>Kode Supplier</th>
<th></th>
</tr> 
   </thead>
   <tbody>

<?php
$sql_stk0="select * from bps_supplier_fa  $whr";
    $tb_stk0=odbc_exec($koneksi_lp,$sql_stk0);
//echo $tb_stk0;
    $bar=0;
    $info="";
    $sttbar="";
        while($bar_ap1=odbc_fetch_array($tb_stk0))
        {  
            $bar++;
            $kode_supp=odbc_result($tb_stk0,"supp_code"); 
            $id_suppsite=odbc_result($tb_stk0,"supp_site_id"); 
            $isitombol="'".$kode_supp."','".$id_suppsite."'";
            $tombol='<button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float waves-light" onclick="hapus_suppfa('.$isitombol.');"><i class="material-icons">delete_forever</i></button>';
                    ?>
            <tr>
                <td><?= odbc_result($tb_stk0,"supplier_id"); ?></td>
                <td><?= odbc_result($tb_stk0,"supplier_no"); ?></td>
                <td><?= odbc_result($tb_stk0,"supplier_name"); ?></td>
                <td><?= odbc_result($tb_stk0,"supplier_site_code"); ?></td>
                <td><?= odbc_result($tb_stk0,"accts_pay_code_combination_id"); ?></td>
                <td><?= odbc_result($tb_stk0,"prepay_code_combination_id"); ?></td>
                <td><?= odbc_result($tb_stk0,"org_id"); ?></td>
                <td><?= odbc_result($tb_stk0,"acc_code"); ?></td>
                <td><?= odbc_result($tb_stk0,"kategori"); ?></td>
                <td><?= odbc_result($tb_stk0,"supp_site_id"); ?></td>
                <td><?= odbc_result($tb_stk0,"supp_code"); ?></td>
                <td><?=$tombol;?></td>

            </tr> 
               <?php 
        }
?>
</tbody>

</table>
</div>
</div>
</div>


<?php include $alamatplug."assets/function_obj.php"; ?>
<script>    export_datatable('tablecarisuppfa'); </script>