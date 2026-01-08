 <div class="card">
   <div class="container-fluid">
       <?php
       $c_to=$_GET["c"];
       if(isset($_GET["penawaran"])){
        $kecuali="where exists(SELECT * from bps_kontrak_supp where  tgl_berakhir>=getdate() and kode_supp=lp_supp.SUPP_CODE)";
       }else{
        $kecuali="";
       }
       $sql1="select * from lp_supp $kecuali";

       ?>

       <form id="form1" name="form1" method="post">
        <div class="block-header"><h2>CARI SUPPLIER</h2>  </div>
        <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
            <thead>
                <tr>
                    <th>Code Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Alamat</th>
                    <th>Kota</th>
                    <th>Nama CP</th>
                    <th>Telp</th>
                </tr>
            </thead>
            <tbody>
                <!--        data ini bisa di loop dari database-->
                <?php
                $tb_area=odbc_exec($koneksi_lp,$sql1);
                $row=0;
                while($baris1=odbc_fetch_array($tb_area)){ $row++;
                    ?>
                    <tr onclick="javascript:pilih(this);">
                        <td><?php echo odbc_result($tb_area,"SUPP_CODE");?></td>
                        <td><?php echo odbc_result($tb_area,"SUPP_NAME");?></td>
                        <td><?php echo odbc_result($tb_area,"ALAMAT");?></td>
                        <td><?php echo odbc_result($tb_area,"KOTA");?></td>
                        <td><?php echo odbc_result($tb_area,"CP_NAME");?></td>
                        <td><?php echo odbc_result($tb_area,"TELP");?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
</div></div>

<script>
    function pilih(row){
        var kd_pel0=row.cells[0].innerHTML;
        var kd_pel1=row.cells[1].innerHTML;
        window.opener.parent.document.getElementById("<?php echo $c_to; ?>").value =kd_pel0;
        window.opener.parent.document.getElementById("supp").value =kd_pel1;
        window.close();
    }
</script>