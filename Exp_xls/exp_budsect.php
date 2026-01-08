<?php
session_start();
$noctrl=$_GET['c'];
$jmlctrl=substr_count($noctrl, ",")-1;
$pch_ctrl=explode(",", $noctrl);
$sect= $_SESSION["area"];

include "../koneksi.php";
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Plan_Budget_".$sect.".xls");
?>
<table>
	<tr>
		<th colspan="4" align="left">PT. Semarang Autocomp Manufacturing Indonesia</th>
	</tr>
	<tr>
		<th colspan="2" align="left">Plan Budget</th>
	</tr>
	<tr>
		<th colspan="2" align="left">Dept/Sect</th>
		<td><?php echo $sect; ?></td>
	</tr>
	<tr>
	</tr>
	<tr><td colspan="2" align="left"><?php echo date("Y-m-d H:i:s") ?></td></tr>
</table>
<br>
<table border="1">
	<tr>
		<th>No</th>
		<th class="bg-grey">Term</th>
		<th>Type</th>
		<th>Control No</th>
		<th>Purchasing</th>
		<th>Process Code</th>
		<th>Part No</th>
		<th>Part Name</th>
		<th>Part Detail</th>
		<th>Part Deskripsi</th>
		<th>Periode</th>
		<th>Qty</th>
		<th>Uom</th>
		<th>Currency</th>
		<th>Price</th>
		<th>Phase</th>
		<th>Cost Center</th>
		<th>Lt Quotation</th>
		<th>Lt Pr</th>
		<th>Lt Po</th>
		<th>Lt Arrival</th>
		<th>Lt Vp</th>

	</tr>
	<?php 
	$lctrl_no="";
	for ($i=0; $i <= $jmlctrl; $i++) { 
		$ctrl_no="'".$pch_ctrl[$i]."'";
		$lctrl_no=$lctrl_no.",".$ctrl_no;
	}
	$lctrl_no_ok=substr($lctrl_no,1,strlen($lctrl_no));
	$sq_acc="select * from bps_budget where no_ctrl in ($lctrl_no_ok) order by no_ctrl asc";
	// echo $sq_acc;
	$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
	$no=0;$section="";
	// echo $sq_acc;
	while($baris1=odbc_fetch_array($tb_acc)){
		$no++;
		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $baris1['term']; ?></td>
			<td><?php echo $baris1['jns_budget']; ?></td>
			<td><?php echo $baris1['no_ctrl']; ?></td>
			<td><?php echo $baris1['lp']; ?></td>
			<td><?php echo $baris1['id_proses']; ?></td>
			<td><?php echo $baris1['part_no']; ?></td>
			<td><?php echo $baris1['part_nm']; ?></td>
			<td><?php echo $baris1['part_dtl']; ?></td>
			<td><?php echo $baris1['part_desc']; ?></td>
			<td><?php echo $baris1['periode']; ?></td>
			<td><?php echo $baris1['qty']; ?></td>
			<td><?php echo $baris1['uom']; ?></td>
			<td><?php echo $baris1['curr']; ?></td>
			<td><?php echo $baris1['price']; ?></td>
			<td><?php echo $baris1['phase']; ?></td>
			<td><?php echo $baris1['cccode']; ?></td>
			<td><?php echo $baris1['lt_Quo']; ?></td>
			<td><?php echo $baris1['lt_pr']; ?></td>
			<td><?php echo $baris1['lt_po']; ?></td>
			<td><?php echo $baris1['lt_datang']; ?></td>
			<td><?php echo $baris1['lt_vp']; ?></td>
		</tr>
		<?php 
	}
	?>
</table>
