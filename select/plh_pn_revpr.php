<?php
$nm=$_GET['nm'];
$sql1="select * from bps_part where status_part=1 and part_nm='$nm'";
// $sql1="select * from bps_part where part_nm='$nm'";

?>
<link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.js"></script>
<script src="../plugins/jquery-datatable/jquery.dataTables.js"></script>


<div class="card">
   <div class="container-fluid">

    <!--form id="form1" name="form1" method="post"-->
    <div class="block-header"><h2>MASTER PART</h2>  </div>
    <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
        <thead>
            <tr>
                <th>PART NAME</th>
                <th>PART NO</th>
                <th>PART DETAIL</th>
                <th>KATEGORY</th>
                <th>UOM</th>
                <th>CURRENCY</th>


            </tr>
        </thead>
        <tbody>
            <!--data ini bisa di loop dari database-->
            <?php
            include "../koneksi.php";
            $tb_area=odbc_exec($koneksi_lp,$sql1);
            $row=0;
            while($baris1=odbc_fetch_array($tb_area)){ $row++;
                ?>
                <tr onclick="javascript:pilih(this);">
                    <td><?php echo odbc_result($tb_area,"part_nm");?></td>
                    <td><?php echo odbc_result($tb_area,"part_no");?></td>
                    <td><?php echo odbc_result($tb_area,"part_dtl");?></td>
                    <td><?php echo odbc_result($tb_area,"part_kat");?></td>
                    <td><?php echo odbc_result($tb_area,"uom");?></td>
                    <td><?php echo odbc_result($tb_area,"curr");?></td>

                </tr>
            <?php } ?>      
        </tbody>
    </table>
    <!--/form-->
</div></div>

<script>
    function pilih(row){
        var kd_pel0=row.cells[0].innerHTML;
        var kd_pel1=row.cells[1].innerHTML;
        var kd_pel2=row.cells[2].innerHTML;
        var kd_pel3=row.cells[3].innerHTML;
//window.opener.parent.document.getElementById("").value = kd_pel0;
window.opener.parent.document.getElementById("p_no").value = kd_pel1;
window.opener.parent.document.getElementById("p_dtl").value = kd_pel2;
window.close();
}
</script>