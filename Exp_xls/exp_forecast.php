<?php
$sect=$_GET['s'];
$periode=$_GET['p'];
session_start();
include "../koneksi.php";
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Forecast_".$sect."_Periode_".$periode.".xls");
?>
<table>
	<tr>
		<th colspan="4" align="left">PT. Semarang Autocomp Manufacturing Indonesia</th>
	</tr>
	<tr>
		<th colspan="2" align="left">Forecast</th>
	</tr>
	<tr>
		<th colspan="2" align="left">Dept/Sect</th>
		<td>: <?php echo $sect; ?></td>
	</tr>
	<tr>
		<th colspan="2" align="left">Periode</th>
		<td>: <?php echo $periode; ?></td>
	</tr>
	<tr><td colspan="2" align="left"><?php echo date("Y-m-d H:i:s") ?></td></tr>
</table>
<br>
<table border="1">
	<tr>
		<th rowspan="2" valign="top">No</th>
		<th rowspan="2" valign="top">No Control</th>
		<th rowspan="2" valign="top">Part No</th>
		<th rowspan="2" valign="top">Part Name</th>
		<th rowspan="2" valign="top">Part Detail</th>
		<th rowspan="2" valign="top">Part Desc</th>
		<th rowspan="2" valign="top">UoM</th>
		<th rowspan="2" valign="top">Curr</th>
		<th colspan="2">STP</th>
		<th colspan="2">Forecast</th>
	</tr>
	<tr>
		<th>Qty</th>
		<th>Price</th>
		<th>Qty</th>
		<th>Price</th>
	</tr>
	<?php 
	$data = odbc_exec($koneksi_lp,"SELECT *,(select top 1 price FROM bps_Quotation where 
		lp_rekom='YES' and part_no=a.part_no order by tgl_updt desc) as price_quo 
		FROM bps_budget a where sect='$sect' and periode='$periode' and Not exists (select *
		FROM bps_tmpPR where no_ctrl=a.no_ctrl)");
	$no = 1;
	while($d = odbc_fetch_array($data)){
		$price_fcs=$d['price_fcs'];
		$price_quo=$d["price_quo"];
		$price_fcs=$d["price_fcs"];
		if($price_fcs==""){$price=$price_quo;}else if($price_quo==""){$price=$d["price"];}else{$price=$price_fcs;}
		?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $d['no_ctrl']; ?></td>
			<td><?php echo $d['part_no']; ?></td>
			<td width="400"><?php echo $d['part_nm']; ?></td>
			<td width="500"><?php echo $d['part_dtl']; ?></td>
			<td><?php echo $d['part_desc']; ?></td>
			<td width="50"><?php echo $d['uom']; ?></td>
			<td width="50"><?php echo $d['curr']; ?></td>
			<td width="90"><?php echo $d['qty']; ?></td>
			<td width="90"><?php echo $d['price']; ?></td>
			<td width="90"><?php if( $d['qty_fcs']!=0){echo $d['qty_fcs'] ;}else{echo 0; }  ; ?></td>
			<td width="90"><?php if($price==0){echo 0;}else{ echo $price;} ; ?></td>
		</tr>
		<?php 
	}
	?>
</table>
