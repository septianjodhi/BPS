 <div class="card">
 <div class="container-fluid">
 <?php

 $sql1="select * from bps_proses";
 
 ?>
	
<form id="form1" name="form1" method="post">
<div class="block-header"><h2>CARI KODE PROSES</h2>  </div>
<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
    <thead>
<tr>
<th>KODE</th>
<th>KATEGORY</th>
<th>KETERANGAN</th>
<th>PENAWARAN</th>
<th>PR</th>
<th>PO</th>
<th>INVOICE</th>
<th>VP</th>
<th>PETTY CASH</th>

			
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
<td><?php echo odbc_result($tb_area,"kd_pros");?></td>
<td><?php echo odbc_result($tb_area,"kategori");?></td>
<td><?php echo odbc_result($tb_area,"Keterangan");?></td>
<td><?php echo odbc_result($tb_area,"penawaran");?></td>
<td><?php echo odbc_result($tb_area,"PR");?></td>
<td><?php echo odbc_result($tb_area,"PO");?></td>
<td><?php echo odbc_result($tb_area,"Invoice");?></td>
<td><?php echo odbc_result($tb_area,"vp");?></td>
<td><?php echo odbc_result($tb_area,"cash");?></td>
	
        </tr>
		<?php } ?>      
    </tbody>
</table>
</form>
</div></div>

<script>
    function pilih(row){
var kd_pel0=row.cells[0].innerHTML;
window.opener.parent.document.getElementById("id_proses").value =kd_pel0;
        window.close();
    }
</script>