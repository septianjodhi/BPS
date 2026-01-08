<?php
$section=$_GET['s'];
if($section!='all'){$sect="and sect='$section' ";}else{$sect="";}
$term=$_GET['t'];
session_start();
include "../koneksi.php";
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Budget_invest_".$sect.".xls");
?>
<table>
	<tr>
		<th colspan="4" align="left">PT. Semarang Autocomp Manufacturing Indonesia</th>
	</tr>
	<tr>
		<th colspan="2" align="left">Budget Invest Part</th>
	</tr>
	<tr>
		<th colspan="2" align="left">Dept/Sect</th>
		<td><?php echo $section; ?></td>
	</tr>
	<tr>
	</tr>
	<tr><td colspan="2" align="left"><?php echo date("Y-m-d H:i:s") ?></td></tr>
</table>
<br>
<table border="1">
	<tr>
		<th>No</th>
		<th>Term</th>
		<th>CIP No</th>
		<th>No Control</th>
		<th>Order Plan</th>
		<th>Delivery Plan</th>
		<th>Budget Group</th>
		<th>Qty Ori</th>
		<th>Price Ori</th>
		<th>Part No</th>
		<th>Qty Order</th>
		<!-- <th>Curr Order</th>		
		<th>Uom Order</th>
		<th>Price Order</th>
		<th>Purchasing</th> -->
	</tr>
	<?php 
	$sq_acc="select term,cip_no,no_ctrl,order_plan,del_plan,bud_group,qty,price from bps_budget_invest where term='$term' $sect
	union
	select term,cip_no,no_ctrl,order_plan,del_plan,bud_group,qty,price from bps_budget_invest_add where term='$term' $sect";
	$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
	$no=0;$section="";
	// echo $sq_acc;
	while($baris1=odbc_fetch_array($tb_acc)){
		$no++;
		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $baris1['term']; ?></td>
			<td><?php echo $baris1['cip_no']; ?></td>
			<td><?php echo $baris1['no_ctrl']; ?></td>
			<td><?php echo $baris1['order_plan']; ?></td>
			<td><?php echo $baris1['del_plan']; ?></td>
			<td><?php echo $baris1['bud_group']; ?></td>
			<td><?php echo $baris1['qty']; ?></td>
			<td><?php echo $baris1['price']; ?></td>
			<td></td>
			<td></td>
		</tr>
		<?php 
	}
	?>
</table>
