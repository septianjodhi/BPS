<?php
$pr_no=$_GET['pr_no'];
$sect=$_GET['sec'];
$periode=$_GET['periode'];

session_start();
include "../koneksi.php";
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=PR_NO_".$pr_no.".xls");
$query="SELECT a.periode,a.no_ctrl,a.part_no,a.part_nm,a.part_dtl,a.part_desc,b.qty as qty_pr,b.price as price_pr,a.uom,a.curr FROM bps_tmpPR a 
left join bps_pr b on a.pr_no=b.pr_no and a.no_ctrl=b.no_ctrl where a.pr_no='$pr_no' ";
?>
<table>
	<tr>
		<th colspan="4" align="left">PT. Semarang Autocomp Manufacturing Indonesia</th>
	</tr>
	<tr>
		<th colspan="2" align="left">PR NO : <?= $pr_no ; ?></th>
	</tr>
	<tr>
		<th colspan="2" align="left">Dept/Sect</th>
		<td>: <?php echo $sect; ?></td>
	</tr>
	<tr>
		<th></th>
		<td></td>
	</tr>
	<tr><td colspan="2" align="left"><?php echo date("Y-m-d H:i:s") ?></td></tr>
</table>
<br>
<table border="1">
	<tr>
		<th>No</th>
		<th>Periode</th>
		<th>No Control</th>
		<th>Part No</th>
		<th>Part Name</th>
		<th>Part Detail</th>
		<th>Part Desc</th>
		<th>UoM</th>
		<th>Curr</th>
		<th>Qty PR</th>
		<th>Harga</th>
		<th>Kode Supplier</th>
		<th>Qty Cappacity</th>
		<th>Priority</th>
	</tr>
	<?php 
	$data = odbc_exec($koneksi_lp,$query);
	$no = 1;
	while($d = odbc_fetch_array($data)){
		?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $d['periode']; ?></td>
			<td><?php echo $d['no_ctrl']; ?></td>
			<td><?php echo $d['part_no']; ?></td>
			<td><?php echo $d['part_nm']; ?></td>
			<td><?php echo $d['part_dtl']; ?></td>
			<td><?php echo $d['part_desc']; ?></td>
			<td><?php echo $d['uom']; ?></td>
			<td><?php echo $d['curr']; ?></td>
			<td><?php echo $d['qty_pr']; ?></td>
			<td><?php echo $d['price_pr']; ?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?php 
	}
	?>
</table>
