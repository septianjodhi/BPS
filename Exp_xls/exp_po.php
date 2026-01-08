<?php
// $po_no='PO-LD-MDP2203-001';
$po_no=$_GET['po_no'];
$lp=$_GET['lp'];

session_start();
include "../koneksi.php";
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=PO_NO_".$po_no.".xls");
$query="SELECT pr_no,po_no,no_ctrl,part_nm,part_no,part_dtl,part_desc,qty,isnull((select sum(qty_dtg) from bps_kedatangan where po_no=a.po_no and no_ctrl=a.no_ctrl),0) as qty_dtg from bps_podtl a where po_no='$po_no' and qty<>isnull((select sum(qty_dtg) from bps_kedatangan where po_no=a.po_no and no_ctrl=a.no_ctrl),0) order by part_no asc";
?>
<table>
	<tr>
		<th colspan="4" align="left">PT. Semarang Autocomp Manufacturing Indonesia</th>
	</tr>
	<tr>
		<th colspan="2" align="left">PO NO : <?= $po_no ; ?></th>
	</tr>
	<tr>
		<th colspan="2" align="left">Purchasing</th>
		<td>: <?php echo $lp; ?></td>
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
		<th>PR No</th>
		<th>PO No</th>
		<th>No Control</th>
		<th>Part Name</th>
		<th>Part No</th>		
		<th>Part Detail</th>
		<th>Part Desc</th>
		<th>Qty PO</th>
		<th>Qty Rcv</th>
		<th>Qty Datang</th>
		<th>Inv No</th>
		<th>Inv Date</th>
		<th>Inv Rcv Date</th>
		<th>Jenis BC</th>
		<th>No BC</th>
		<th>Tanggal BC</th>
		<th>Faktur Pajak</th>
		<th>PPh</th>
		<th>PPn</th>
	</tr>
	<?php 
	$data = odbc_exec($koneksi_lp,$query);
	$no = 1;
	while($d = odbc_fetch_array($data)){
		?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $d['pr_no']; ?></td>
			<td><?php echo $d['po_no']; ?></td>
			<td><?php echo $d['no_ctrl']; ?></td>
			<td><?php echo $d['part_nm']; ?></td>
			<td><?php echo $d['part_no']; ?></td>			
			<td><?php echo $d['part_dtl']; ?></td>
			<td><?php echo $d['part_desc']; ?></td>
			<td><?php echo $d['qty']; ?></td>
			<td><?php echo $d['qty_dtg']; ?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?php 
	}
	?>
</table>
