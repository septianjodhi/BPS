
 <?php
 $nmobj=$_GET['o'];
 $nmcar=$_GET['c'];
 $kol=$_GET['k'];
 $no_ctrl=$_GET['n'];
	 $sql1="select * from lp_cv order by cost_center_code";

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
<th>No</th>
<th>CC CODE</th>
<th>MAKER CODE</th>
<th>CARLINE</th>
<th>CV</th>
<th>CV DESCRIPTION</th>
				
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
			<td><?php echo $row; ?></td>
			<td><?php echo odbc_result($tb_area,"COST_CENTER_CODE");?></td>
            <td><?php echo odbc_result($tb_area,"CARMAKER");?></td>	
            <td><?php echo odbc_result($tb_area,"CARLINE");?></td>	
            <td><?php echo odbc_result($tb_area,"CV_CODE");?></td>
            <td><?php echo odbc_result($tb_area,"CV_DESC");?></td>		
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
var kd_pel4=row.cells[4].innerHTML;
//window.opener.parent.document.getElementById("").value = kd_pel0;
//window.opener.parent.document.getElementById("p_no").value = kd_pel1;
//window.opener.parent.document.getElementById("p_dtl").value = kd_pel2;
window.opener.parent.document.getElementById("no_ctrl").value = kd_pel4;
        window.close();
   }
</script>