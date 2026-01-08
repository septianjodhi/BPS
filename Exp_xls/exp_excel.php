
<html>
<head>
	<title>Export Data Ke Excel Dengan PHP</title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>
 
	<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data Pegawai.xls");
	session_start();

	include "../koneksi.php";
	include "PHPExcel.php";

	date_default_timezone_set("Asia/Jakarta");
	$excelku = new PHPExcel();
	$sect=$_GET['s'];
	$term=$_GET['t'];
	$per=$_GET['p'];
	?>
 
 <table>
    <tr>
	<th colspan="3">EXPENSE BUDGET REPORT 予算統制報告</th>
	</tr>
	<tr>
	<th>PERIOD(月度)</th>
	<th> : <?php echo $per;?></th>
	</tr>
	<tr>
	<th>DEPT (部署名)</th>
	<th> : <?php echo $sect;?></th>
	</tr>
	<tr>
	</tr>
 </table>	

    <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
    <thead>
    <tr>	
	<th>Section</th>
	<th>Part No.</th>
	<th>Part Name</th>
	<th>Detail Part</th>
	<th>Acc No.</th>
	<th>Acc Desc</th>
	<th>Category</th>
	<th>Cost Center</th>
	<th>Carline</th>
	<th>Car Maker</th>
	<th>Uom</th>
	<th>Qty STP</th>
	<th>Price STP</th>
	<th>Amount STP</th>
	<th>Qty Actual</th>
	<th>Price Actual</th>
	<th>Amount Actual</th>
	<th>Qty Deff</th>
	<th>Price Deff</th>
	<th>Amount Deff</th>
	</tr>
    </thead>
    <tbody>
									
	<?php
	$qrpt_pr="select distinct  a.term,a.periode,a.sect,a.part_no,a.part_nm,a.part_dtl,a.account,c.ACC_DESC,a.phase,a.cccode,d.CARLINE,d.CARMAKER,a.qty as qty_plan,sum(b.Qty) as qty_act, a.uom,a.curr,dbo.lp_konprc(a.term,'USD',a.curr,a.price) as price_plan,dbo.lp_konprc(b.term,'USD',b.curr,b.price) as price_act from bps_budget a full join bps_pr b on a.periode=b.periode and a.sect=b.sect and a.no_ctrl=b.no_ctrl
	full join LP_ACC c on a.account=c.ACC_NO full join LP_CV d on a.cccode=d.COST_CENTER_CODE
	where a.sect='$sect' and a.periode='$per' and a.term='$term'
	group by a.term, a.periode, a.sect, a.part_no, a.part_nm, a.part_dtl, a.account, c.ACC_DESC, a.phase, a.cccode, d.CARLINE, d.CARMAKER, a.uom, a.curr, a.price,b.price,a.qty,b.curr,b.term order by a.part_no";
	//echo $qrpt_pr;
	$tb_crdt=odbc_exec($koneksi_lp,$qrpt_pr);
	$row=0;
	while($barcrdt=odbc_fetch_array($tb_crdt)){
		$row++;
		$qty_plan=odbc_result($tb_crdt,"qty_plan");
		$price_plan=odbc_result($tb_crdt,"price_plan");
		$amount_p=$qty_plan*$price_plan;
		
		$cr_status="select status from bps_approve a,bps_PR b where a.no_doc=b.PR_NO and a.sect='$sect' and periode='$per' and term='$term'";
		$tb_stts=odbc_exec($koneksi_lp,$cr_status);
		$status=odbc_result($tb_stts,"status");
		
		if($status!='FINISH'){
		$qty_act=0;
		$price_act=0;
		$amount_act=0;}
		else{
		$qty_act=odbc_result($tb_crdt,"qty_act");
		$price_act=odbc_result($tb_crdt,"price_act");
		$amount_act=$qty_act*$price_act;}
		?>
	<tr>	
	<th><?php echo odbc_result($tb_crdt,"sect"); ?></th>
	<th><?php echo odbc_result($tb_crdt,"part_no");?></th>
	<th><?php echo odbc_result($tb_crdt,"part_nm");?></th>
	<th><?php echo odbc_result($tb_crdt,"part_dtl");?></th>
	<th><?php echo odbc_result($tb_crdt,"account");?></th>
	<th><?php echo odbc_result($tb_crdt,"ACC_DESC");?></th>
	<th><?php echo odbc_result($tb_crdt,"phase");?></th>
	<th><?php echo odbc_result($tb_crdt,"cccode");?></th>
	<th><?php echo odbc_result($tb_crdt,"CARLINE");?></th>
	<th><?php echo odbc_result($tb_crdt,"CARMAKER");?></th>
	<th><?php echo odbc_result($tb_crdt,"uom");?></th>
	<th><?php echo number_format($qty_plan,2,".",".");?></th>
	<th><?php echo number_format($price_plan,2,".",".");?></th>
	<th><?php echo number_format($amount_p,2,".",".");?></th>
	<th><?php echo number_format($qty_act,2,".",".");?></th>
	<th><?php echo number_format($price_act,2,".",".");?></th>
	<th><?php echo number_format($amount_act,2,".",".");?></th>
	<th><?php echo number_format($qty_act-$qty_plan,2,".",".");?></th>
	<th><?php echo number_format($price_act-$price_plan,2,".",".");?></th>
	<th><?php echo number_format($amount_act-$amount_p,2,".",".");?></th>
	</tr>
	<?php 
}

?>
	</tbody>
	</table>

</body>
</html>