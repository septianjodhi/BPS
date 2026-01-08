<?php
error_reporting(0);
session_start();

include "../koneksi.php";
$periode=date("d-m-Y H:i:s");
$nomor=$_GET['nomor'];
$kd=$_GET['nodoc'];
$rmk=$_GET['rmk'];
$pic_updt=$_SESSION['nama'];
$sect= $_SESSION["area"];
/*
if(isset($rmk)){
$tb_pr=odbc_exec($koneksi_lp,"update bps_pr set remark='$rmk' where pr_no='$kd' and request is null");
}
*/		
//-----------------------Kode program untuk mencetak halaman----------------------//
$nama_dokumen='FORM ADDITIONAL BUDGET DOC NO = '.$kd; //Beri nama file PDF hasil.

include("../mpdf57/mpdf.php");
$mpdf=new mPDF('utf-8 ', 'A4-L'); // Create new mPDF Document
$mpdf->setFooter("Halaman {PAGENO} dari {nb}");


//Beginning Buffer to save PHP variables and HTML tags
ob_start();
//-----------------------Kode program untuk mencetak halaman----------------------//
//-----------------------------Copy juga yang di bawah----------------------------//
?>

<style type="text/css">
	.sami{
		font-weight: bold;
		font-size: 24px;
		text-align: left;
		font-family: "Arial Black", Gadget, sans-serif;
	}
</style>
<table width="100%" border="0">
	<tr>
		<td width="95" class="sami">SAMI</td>
		<td width="554" align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-size: 18px;">PT. SEMARANG AUTOCOMP MANUFACTURING INDONESIA</td>
		<td width="118"><p><img src='..\images\add_budget.jpg' width='150' height='40' alt='sami' /></p></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-style: italic;">Wiring Harness Manufacturer</td>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%" border="0">
	<tr>
		<td align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 20px;">FORM PLAN ADDITIONAL INVEST</td>
	</tr>
</table>
<?php
$ttd="<p><img src='..\img\logo_sami.png' width='80' height='50' alt='sami' /></p>";
$sql_stk1="select distinct periode,doc_no,min(doc_date) as doc_date,pic_updt,sect,sum(dbo.lp_konprc(term,'USD','USD',price*qty)) as amoUSD,sum(dbo.lp_konprc(term,'IDR','USD',price*qty))  as amoIDR,expired from bps_budget_invest_add where doc_no='$kd' group by doc_no,sect,expired,pic_updt,periode";
$tb_stk1=odbc_exec($koneksi_lp,$sql_stk1);

$sect=odbc_result($tb_stk1,"sect");
$docno=odbc_result($tb_stk1,"doc_no");
$doc_date=odbc_result($tb_stk1,"doc_date");
$pic=odbc_result($tb_stk1,"pic_updt");
$est=odbc_result($tb_stk1,"expaired");
$amoIDR=odbc_result($tb_stk1,"amoIDR");
$amoUSD=odbc_result($tb_stk1,"amoUSD");
?>
<table width="100%" height="122">
	<tr>
		<td width="50%">

			<table style="font-size:12px;">
				<tr><td>DATE</td><td width="10">:</td><td width="117"><?php echo date("d F Y",strtotime($doc_date));?></td></tr>
				<tr><td>NO DOC ADD</td><td>:</td><td><?php echo $kd;?></td></tr>
				<tr><td width="113">DEPT/SECTION</td><td>:</td><td><?php echo str_replace("-","/",$sect);?></td></tr>
				<tr><td width="113">PIC</td><td>:</td><td><?php echo $pic;?></td></tr>
				<tr><td width="113">ADD PERIOD</td><td>:</td><td><?php echo odbc_result($tb_stk1,"periode");?></td></tr>
			</table>
		</td>
		<td width="456" align="right">
			<table width="388" border="1" style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
				<?php
				$sql_aprv="select * from bps_approve where jns_doc='ADD' and no_doc='$kd' order by no_aprv desc";
				$tb_aprv=odbc_exec($koneksi_lp,$sql_aprv);
				$bar1="";$bar2="";$bar3="";
				while(odbc_fetch_array($tb_aprv)){
					$bar1=$bar1.'<td width="90" align="center">'.odbc_result($tb_aprv,"approve").'</td>';
					$bar2=$bar2.'<td height="54" align="center" valign="bottom" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">'.odbc_result($tb_aprv,"pic_act").'</td>';	
					$bar3=$bar3.'<td width="90" align="center">'.odbc_result($tb_aprv,"initial").'</td>';
					$bar4=$bar4.'<td height="12" align="left">date :</td>';
				}
				echo '<tr align="center">'.$bar1.'</tr>';
				echo '<tr align="center" valign="bottom">'.$bar2.'</tr>';
				echo '<tr align="center">'.$bar3.'</tr>';
				echo '<tr align="left">'.$bar4.'</tr>';
				?>
			</table>
		</td>
	</tr>
</table>

<br />
<table width="100%" border="1" style="border-collapse: collapse; font-size:10px; font-weight: bold;">
	<thead>
		<tr>
			<th height="25">NO</th>
			<th>CIP NO</th>
			<th>GROUP EQUIPMENT</th>
			<th>QTY</th>
			<th>UNIT</th>
			<th>CURR</th>
			<th>PRICE</th>
			<th>ORG AMOUNT</th>
			<th>USD AMOUNT </th>
			<th>CATEGORY</th>
			<th>REASON</th>
		</tr>
	</thead>
	<tbody>

		<?php
		$sql_stk31="select doc_no,doc_date,term,periode,sect,no_ctrl_add,cip_no,qty,kode_chg,bud_group,
		ket_chg,dbo.lp_konprc(term,'USD','USD',price) as prcUSD,dbo.lp_konprc(term,'IDR','USD',price) as prcIDR,expired,remark 
		from bps_budget_invest_add where doc_no='$kd' order by cip_no asc";
		$tb_stk31=odbc_exec($koneksi_lp,$sql_stk31);
		$nop=0;$t_Amo=0;
		while(odbc_fetch_array($tb_stk31))
		{
			$nop++;
			$uo=odbc_result($tb_stk31,"uom");
			$angka=odbc_result($tb_stk31,"kode_chg");
	//if($angka==2 or $angka==3){
	//$prc=odbc_result($tb_stk31,"price_add");
	//}else{$prc=odbc_result($tb_stk31,"prcIDR");}
			$prc=odbc_result($tb_stk31,"prcIDR");
			$qt=odbc_result($tb_stk31,"qty");
			$prcUSD=odbc_result($tb_stk31,"prcUSD");
			$Amo=$prc*$qt;
			$AmoUSD=$prcUSD*$qt;
			$t_Amo=$t_Amo+$Amo;
			$t_AmoUSD=$t_AmoUSD+$AmoUSD;
			?>
			<tr class="odd gradeX">
				<td width="10" height="23" align="center" valign="middle" nowrap="nowrap"><?php echo $nop;?></td>
				<td width="20" align="left" valign="middle" nowrap="nowrap">CIP No. <?php echo odbc_result($tb_stk31,"cip_no");?></td>
				<td width="50" align="left" valign="middle" nowrap="wrap"><?php echo odbc_result($tb_stk31,"bud_group");?></td>
				<td width="25" align="center" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$qt),2,'.',',');?></td>
				<td width="25" align="center" nowrap="nowrap"><?php echo "SET";?></td>
				<td width="25" align="center" nowrap="nowrap"><?php echo "USD";?></td>
				<td width="70" align="right" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$prcUSD),2,'.',',')?></td>
				<td width="80" align="right" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$AmoUSD),2,'.',',');?></td>
				<td width="80" align="right" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$AmoUSD),2,'.',',');?></td>
				<td width="60" align="left" nowrap="nowrap"><?php 
				switch ($angka) {
					case 1:
					echo "QTY KURANG";
					break;
					case 2:
					echo "HARGA NAIK";
					break;
					case 3:
					echo "QTY KURANG DAN HARGA NAIK";
					break;
					case 4:
					echo "PERIODE BERUBAH";
					break;
					case 5:
					echo "TIDAK ADA PLAN";
					break;
				}
				?></td>
				<td align="left" valign="middle" nowrap="nowrap"><?php echo odbc_result($tb_stk31,"remark");?></td>
			</tr>

			<?php
		}

		$fg=7-$nop;

		if($nop<7){
			$vzz=0;
			while($vzz<$fg){
				?>
				<tr class="odd gradeX">
					<td height="20" align="center" valign="middle" nowrap="nowrap"></td>
					<td align="center" valign="middle" nowrap="nowrap"></td>
					<td align="center" valign="middle" nowrap="nowrap"></td>
					<td align="center" valign="middle" nowrap="nowrap"></td>
					<td align="center" valign="middle" nowrap="nowrap"></td>
					<td align="center" valign="middle" nowrap="nowrap"></td>
					<td align="center" valign="middle" nowrap="nowrap"></td>
					<td align="right" valign="middle" nowrap="nowrap"></td>
					<td align="right" valign="middle" nowrap="nowrap"></td>
					<td align="center" valign="middle" nowrap="nowrap"></td>
					<td align="left" valign="middle" nowrap="nowrap"></td>
				</tr>
				<?php
				$vzz++;
			}?>
			<?php
		}
		?>

		<tr align="center" valign="middle">
			<td height="22" colspan="7" align="center" valign="middle" nowrap="nowrap">TOTAL :</td>
			<td align="right	" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$t_AmoUSD),2,'.',',');?></td>
			<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$t_AmoUSD),2,'.',',');?></td>
			<td height="22" align="center" valign="middle" nowrap="nowrap"></td>
			<td height="22" align="center" valign="middle" nowrap="nowrap"></td>
		</tr>
	</tbody>
</table>

<!--table style="font-size:10px;">
	<tr><td>&nbsp;</td></tr>
	<tr><td>REASON ADDITIONAL BUDGET</td></tr>
	<tr><td>1. QTY KURANG</td></tr>
	<tr><td>2. HARGA NAIK</td></tr>
	<tr><td>3. QTY KURANG DAN HARGA NAIK</td></tr>
	<tr><td>4. PERIODE BERUBAH</td></tr>
	<tr><td>5. TIDAK ADA PLAN</td></tr>
</table-->

<?php
	//-----------------------Kode program untuk mencetak halaman----------------------//
	$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	ob_end_clean();
	//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
	$mpdf->WriteHTML(utf8_encode($html));
	$mpdf->Output($nama_dokumen.".pdf" ,'I');

	
	exit;
	//-----------------------Kode program untuk mencetak halaman----------------------//
	?>