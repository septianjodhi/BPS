 <div class="card">
 <div class="container-fluid">
 <?php
$wh=$_GET["w"];
$c_to1=$_GET["c1"];
$c_to2=$_GET["c2"];
$c_to3=$_GET["c3"];
$c_to4=$_GET["c4"];
$c_to5=$_GET["c5"];
// $sql1="select * from bps_part where part_nm like '%$wh%'";
$sql1="SELECT * from bps_part where status_part=1 and part_nm like '%$wh%'";
 
 ?>
	
<form id="form1" name="form1" method="post">
<div class="block-header"><h2>CARI PART</h2>  </div>
<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
    <thead>
<tr>
<th>Part Name</th>
<th>Part No</th>
<th>Detail part</th>
<th>Kategory Part</th>
<th>UOM</th>			
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
<td><?php echo odbc_result($tb_area,"part_nm");?></td>
<td><?php echo odbc_result($tb_area,"part_no");?></td>
<td><?php echo odbc_result($tb_area,"part_dtl");?></td>
<td><?php echo odbc_result($tb_area,"part_kat");?></td>
<td><?php echo odbc_result($tb_area,"uom");?></td>
	
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
var kd_pel2=row.cells[2].innerHTML;
var kd_pel3=row.cells[3].innerHTML;
var kd_pel4=row.cells[4].innerHTML;
var c_to1="<?php echo $c_to1; ?>";
var c_to2="<?php echo $c_to2; ?>";
var c_to3="<?php echo $c_to3; ?>";
var c_to4="<?php echo $c_to4; ?>";
var c_to5="<?php echo $c_to5; ?>";
if(c_to1!=""){
window.opener.parent.document.getElementById(c_to1).value =kd_pel0;
}
if(c_to2!=""){
window.opener.parent.document.getElementById(c_to2).value =kd_pel1;
}
if(c_to3!=""){
window.opener.parent.document.getElementById(c_to3).value =kd_pel2;
}
if(c_to4!=""){
window.opener.parent.document.getElementById(c_to4).value =kd_pel3;
}
if(c_to5!=""){
window.opener.parent.document.getElementById(c_to5).value =kd_pel4;
}
window.close();
		
    }
</script>