<?php
$_SESSION['lok']=$_GET['sesi'];	
$_SESSION['lokasi']=$_GET['sesi'];	
$nctrl=$_GET['ctrl'];
$list_nctrl=str_replace(",","','",$nctrl);	  
include "../koneksi.php";
?> 
 <table class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
	<thead>
<tr>	
<th>No</th>
<th>NO CONTROL</th>
<th>PART NAME</th>
<th>DETAIL PART</th>
<th>DESC PART</th>
<th>QTY</th>
<th>PRICE</th>
</tr>	
	</thead>
	<tbody>
<?php
$sqCC="select * from bps_budget_add where no_ctrl_add in('$list_nctrl')";
$tbsqCC=odbc_exec($koneksi_lp,$sqCC);
$row=0;
while($DCC=odbc_fetch_array($tbsqCC)){$row++;
	?>
        <tr>			
			<td><?php echo $row;?></td>		
			<td><?php echo odbc_result($tbsqCC,"no_ctrl_add");?></td>				
			<td><?php echo odbc_result($tbsqCC,"part_nm");?></td>		
			<td><?php echo odbc_result($tbsqCC,"part_dtl");?></td>			
			<td><?php echo odbc_result($tbsqCC,"part_desc");?></td>			
			<td><?php echo number_format(odbc_result($tbsqCC,"qty"),0,".",",");?></td>		
			<td><?php echo number_format(odbc_result($tbsqCC,"price"),2,".",",");?></td>			
        </tr>
		<?php } ?>  	
	</tbody>
	</table>