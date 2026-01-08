
 <?php
 $term=$_GET['t'];
 $periode=$_GET['p'];
 $sect=$_GET['s'];
 $kat=$_GET['k'];
 //$sql1="select * from dbo.bps_budget where jns_budget='$kat' and periode='$periode' and term='$term' and sect like '$sect%' ";
 
$sql1="select jns_budget,no_ctrl,lp,id_proses,account,sub_acc,part_no,part_nm,part_dtl,part_desc,qty,uom,curr,price,phase,cccode,expaired,lt_vp,lt_datang,lt_po,lt_pr,lt_quo 
from dbo.bps_budget where jns_budget='$kat' and periode='$periode' and term='$term' and sect like '$sect%'
union
select jns_budget,no_ctrl,lp,id_proses,account,sub_acc,part_no,part_nm,part_dtl,part_desc,qty,uom,curr,price,phase,cccode,expaired,lt_vp,lt_datang,lt_po,lt_pr,lt_quo 
from dbo.bps_budget_add where jns_budget='$kat' and periode='$periode' and term='$term' and sect like '$sect%' and kode_chg in (4,5)
order by part_no";
//echo $sql1;
 ?>
<div class="container-fluid">
<div class="row clearfix">
<div class="card">
<div class="row clearfix">
<div class="body">
	
<!--form id="form1" name="form1" method="post"-->
<div class="block-header"><h2>CARI NO CONTROL</h2>  </div>
<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
    <thead>
<tr>
<th>JENIS BUDGET</th>
<th>CONTROL NO</th>
<th>PURCHASING</th>
<th>KODE PROSES</th>
<th>ACCOUNT</th>
<th>SUB ACC</th>
<th>PART NO</th>
<th>PART NAME</th>
<th>DETAIL PART</th>
<th>DESCRIPTION</th>
<th>QTY</th>
<th>UOM</th>
<th>CURR</th>
<th>PRICE</th>
<th>PHASE</th>
<th>CC CODE</th>
<th>EXPAIRED DATE</th>
<th>VP</th>
<th>KEDATANGAN</th>
<th>PO</th>
<th>PR</th>
<th>PENAWARAN</th>

			
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
<td><?php echo odbc_result($tb_area,"jns_budget");?></td>
<td><?php echo odbc_result($tb_area,"no_ctrl");?></td>
<td><?php echo odbc_result($tb_area,"lp");?></td>
<td><?php echo odbc_result($tb_area,"id_proses");?></td>
<td><?php echo odbc_result($tb_area,"account");?></td>
<td><?php echo odbc_result($tb_area,"sub_acc");?></td>
<td><?php echo odbc_result($tb_area,"part_no");?></td>
<td><?php echo odbc_result($tb_area,"part_nm");?></td>
<td><?php echo odbc_result($tb_area,"part_dtl");?></td>
<td><?php echo odbc_result($tb_area,"part_desc");?></td>
<td><?php echo odbc_result($tb_area,"qty");?></td>
<td><?php echo odbc_result($tb_area,"uom");?></td>
<td><?php echo odbc_result($tb_area,"curr");?></td>
<td><?php echo odbc_result($tb_area,"price");?></td>
<td><?php echo odbc_result($tb_area,"phase");?></td>
<td><?php echo odbc_result($tb_area,"cccode");?></td>
<td><?php echo odbc_result($tb_area,"expaired");?></td>
<td><?php echo odbc_result($tb_area,"lt_vp");?></td>
<td><?php echo odbc_result($tb_area,"lt_datang");?></td>
<td><?php echo odbc_result($tb_area,"lt_po");?></td>
<td><?php echo odbc_result($tb_area,"lt_pr");?></td>
<td><?php echo odbc_result($tb_area,"lt_Quo");?></td>
	
        </tr>
		<?php } ?>      
    </tbody>
</table>
<!--/form-->
</div>
</div></div></div></div>

<script>
    function pilih(row){
var kd_pel0=row.cells[0].innerHTML;
var kd_pel1=row.cells[1].innerHTML;
var kd_pel2=row.cells[2].innerHTML;
var kd_pel3=row.cells[3].innerHTML;
var kd_pel4=row.cells[4].innerHTML;
var kd_pel5=row.cells[5].innerHTML;
var kd_pel6=row.cells[6].innerHTML;
var kd_pel7=row.cells[7].innerHTML;
var kd_pel8=row.cells[8].innerHTML;
var kd_pel9=row.cells[9].innerHTML;
var kd_pel10=row.cells[10].innerHTML;
var kd_pel11=row.cells[11].innerHTML;
var kd_pel12=row.cells[12].innerHTML;
var kd_pel13=row.cells[13].innerHTML;
var kd_pel14=row.cells[14].innerHTML;
var kd_pel15=row.cells[15].innerHTML;
var kd_pel16=row.cells[16].innerHTML;
var kd_pel17=row.cells[17].innerHTML;
var kd_pel18=row.cells[18].innerHTML;
var kd_pel19=row.cells[19].innerHTML;
var kd_pel20=row.cells[20].innerHTML;
var kd_pel21=row.cells[21].innerHTML;
//window.opener.parent.document.getElementById("").value = kd_pel0;
window.opener.parent.document.getElementById("no_ctrl").value = kd_pel1;
//window.opener.parent.document.getElementById("lp").value = kd_pel2;
window.opener.parent.document.getElementById("id_proses").value = kd_pel3;
//window.opener.parent.document.getElementById("account").value = kd_pel4;
//window.opener.parent.document.getElementById("sub_acc").value = kd_pel5;
window.opener.parent.document.getElementById("part_no").value = kd_pel6;
window.opener.parent.document.getElementById("part_nm").value = kd_pel7;
window.opener.parent.document.getElementById("part_dtl").value = kd_pel8;
window.opener.parent.document.getElementById("part_desc").value = kd_pel9;
window.opener.parent.document.getElementById("qty").value = kd_pel10;
window.opener.parent.document.getElementById("uom").value = kd_pel11;
//window.opener.parent.document.getElementById("curr").value = kd_pel12;
window.opener.parent.document.getElementById("price").value = kd_pel13;
//window.opener.parent.document.getElementById("phase").value = kd_pel14;
window.opener.parent.document.getElementById("cccode").value = kd_pel15;
//window.opener.parent.document.getElementById("").value = kd_pel16;
window.opener.parent.document.getElementById("lt_vp").value = kd_pel17;
window.opener.parent.document.getElementById("lt_datang").value = kd_pel18;
window.opener.parent.document.getElementById("lt_po").value = kd_pel19;
window.opener.parent.document.getElementById("lt_pr").value = kd_pel20;
window.opener.parent.document.getElementById("lt_Quo").value = kd_pel21;
        window.close();
   }
</script>