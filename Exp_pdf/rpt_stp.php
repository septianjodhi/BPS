<?php
error_reporting(0);
session_start();

include "../koneksi.php";
date_default_timezone_set("Asia/Jakarta");
$sec=$_GET['s'];
if($sec=="all"){$sect="" ;}else{$sect=" and a.sect=$sec";}
// $sect=$_GET['s'];
$term=$_GET['t'];
$period=$_GET['p'];
$date=date("d-m-Y H:i:s");
$pic_updt=$_SESSION['nama'];

/*
if(isset($rmk)){
$tb_pr=odbc_exec($koneksi_lp,"update bps_pr set remark='$rmk' where pr_no='$kd' and request is null");
}
*/		
//-----------------------Kode program untuk mencetak halaman----------------------//
$nama_dokumen='Report Budget Actual Periode='.$period; //Beri nama file PDF hasil.

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

<table width="800" border="0">
	<tr>
		<td width="320" style="font-family: Arial, Helvetica, sans-serif; font-size: 10px;">PT. Semarang Autocomp Manufacturing Indonesia</td>
		<td width="320" rowspan="3"></td>
		<td width="400" rowspan="3">
			<table width="200" align="right" border="1" style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
				<tr>

					<td width="80" align="center">Approved</td>
					<td width="80" align="center">Checked</td>
					<td width="80" align="center">Prepared</td>
				</tr>
				<tr>
					<td height="40" align="center" valign="bottom" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;"></td>
					<td height="40" align="center" valign="bottom" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;"></td>
					<td height="40" align="center" valign="bottom" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;"></td>
				</tr>
				<tr>
					<td height="10" width="80" align="center"></td>
					<td height="10" width="80" align="center"></td>
					<td height="10" width="80" align="center"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="font-family: Arial, Helvetica, sans-serif; font-size: 10px;">Actual Budget Exp dan Additional</td>
	</tr>
	<tr>
		<td>
			<table width="100" style="font-family: Arial, Helvetica, sans-serif; font-size: 10px;">
				<tr>
					<td width="30">Periode</td>
					<td width="10">:</td>
					<td width="185"><?php echo $period?></td>
				</tr>
				<tr>
					<td>Dept-Sect</td>
					<td>:</td>
					<td><?php echo $sec?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table width="100%" border="1" style="border-collapse: collapse; font-size:11px;">
	<thead>
		<tr align="center" valign="top">
			<th colspan="2" align="center">Budget Ref</th>
			<th width="85" rowspan="3" align="center">Part No</th>
			<th width="100" rowspan="3" align="center">Part Name</th>
			<th width="73" rowspan="3" align="center">Detail Part</th>
			<th width="55" rowspan="3" align="center">Account No</th>
			<th width="23" rowspan="3" align="center">Qty</th>
			<th colspan="2" align="center">Plan</th>
			<th colspan="2" align="center">Forecast</th>
			<th width="50" align="center">Difference</th>
			<th colspan="3" align="center">Actual STP</th>
			<th colspan="3" align="center">Actual Additional</th>
			<th width="80" align="center">Total Actual</th>
			<th width="50" align="center">Difference</th>
			<th width="110" rowspan="3" align="center">PR No</th>
		</tr>
		<tr align="center" valign="top">
			<th width="50" rowspan="2" align="center">Sect</th>
			<th width="80" rowspan="2" align="center">No. Control</th>
			<th width="40" align="center">Price</th>
			<th width="50" align="center">Amount</th>
			<th width="40" align="center">Price</th>
			<th width="50" align="center">Amount</th>
			<th align="center">(Plan-Forecase)</th>
			<th width="25" rowspan="2" align="center">Qty</th>
			<th width="33" align="center">Price</th>
			<th width="50" align="center">Amount</th>
			<th width="30" rowspan="2" align="center">Qty</th>
			<th width="40" align="center">Price</th>
			<th width="50" align="center">Amount</th>
			<th align="center">(STP+Add)</th>
			<th align="center">(Plan-Actual)</th>
		</tr>
		<tr>
			<th align="center">Rp</th>
			<th align="center">Rp</th>
			<th align="center">Rp</th>
			<th align="center">Rp</th>
			<th align="center">Rp</th>
			<th align="center">Rp</th>
			<th align="center">Rp</th>
			<th align="center">Rp</th>
			<th align="center">Rp</th>
			<th align="center">Rp</th>
			<th align="center">Rp</th>
		</tr>
	</thead>
	<tbody>

		<?php
		$Qry="select distinct  a.term,a.periode,a.sect,a.no_ctrl,a.part_no,a.part_nm,a.part_dtl,
		a.part_desc,a.account,c.ACC_DESC,a.qty as qty_plan,isnull(sum(b.qty_act),0) as qty_act,
		a.uom,a.curr,dbo.lp_konprc(a.term,'IDR',a.curr,a.price) as price_plan,
		dbo.lp_konprc(a.term,'IDR',a.curr,a.price*sum(a.qty)) as amn_p , 
		isnull(dbo.lp_konprc (b.term,'IDR',b.curr,b.price_tot),0) as price_act,
		dbo.lp_konprc (b.term,'IDR',b.curr,b.price_tot*sum(qty_act)) as amn_a,
		isnull(dbo.lp_konprc (b.term,'IDR',b.curr,price_quo),0) as price_quo,
		qty_add,price_add from bps_budget a 
		full join bps_tmpPR b on a.periode=b.periode and a.no_ctrl=b.no_ctrl
		full join LP_ACC c on a.account=c.ACC_NO 
		where a.term='$term' $sect and a.periode='$period'
		group by a.term,a.periode,a.sect,a.no_ctrl,a.part_no,a.part_nm,a.part_dtl,a.part_desc,a.account,c.ACC_DESC,a.uom,a.curr,
		a.price,price_tot,a.qty,b.curr,b.term,price_quo,qty_add,price_add
		union
		select distinct  a.term,a.periode,a.sect,a.no_ctrl,a.part_no,a.part_nm,a.part_dtl,a.part_desc,
		a.account,c.ACC_DESC,a.qty as qty_plan,isnull(sum(b.qty_act),0) as qty_act, 
		a.uom,a.curr,dbo.lp_konprc(a.term,'IDR',a.curr,a.price) as price_plan,
		dbo.lp_konprc(a.term,'IDR',a.curr,a.price*sum(a.qty)) as amn_p , 
		isnull(dbo.lp_konprc (b.term,'IDR',b.curr,price_tot),0) as price_act,
		dbo.lp_konprc (b.term,'IDR',b.curr,isnull(price_tot*sum(qty_act),0)) as amn_a,
		isnull(dbo.lp_konprc (b.term,'IDR',b.curr,price_quo),0) as price_quo,
		qty_add,price_add from bps_budget_add a 
		full join bps_tmpPR b on a.periode=b.periode and a.no_ctrl=b.no_ctrl
		full join LP_ACC c on a.account=c.ACC_NO 
		where and a.term='$term' $sect and a.periode='$period'  and kode_chg in (4,5) 
		and a.doc_no is not null
		group by a.term,a.periode,a.sect,a.no_ctrl,a.part_no,a.part_nm,a.part_dtl,a.part_desc,a.account,c.ACC_DESC,a.uom,a.curr,
		a.price,price_tot,a.qty,b.curr,b.term,price_quo,qty_add,price_add
		order by a.no_ctrl";

//echo $Qry;
		$tb_part=odbc_exec($koneksi_lp,$Qry);
		$row=0;
		$Tamn_p=0;$Tamn_add=0;$Tamn_stp=0;$Tamn_fc=0;
		$Tamn_dfc=0;$Tamn_act=0;$TDiff=0;
		while($baris1=odbc_fetch_array($tb_part)){
			$row++;
			$no_ctrl=odbc_result($tb_part,'no_ctrl');
			$term=odbc_result($tb_part,'term');
			$periode=odbc_result($tb_part,'periode');
			$sect=odbc_result($tb_part,'sect');
			$part_no=odbc_result($tb_part,'part_no');
			$part_nm=odbc_result($tb_part,'part_nm');
			$part_dtl=odbc_result($tb_part,'part_dtl');
			$part_desc=odbc_result($tb_part,'part_desc');
			$account=odbc_result($tb_part,'account');
			$ACC_DESC=odbc_result($tb_part,'ACC_DESC');
			$qty_plan=odbc_result($tb_part,'qty_plan');
			$qty_act=odbc_result($tb_part,'qty_act');
			$uom=odbc_result($tb_part,'uom');
			$curr=odbc_result($tb_part,'curr');
			$price_p=round(odbc_result($tb_part,'price_plan'));
			$price_a=round(odbc_result($tb_part,'price_act'));
			$price_quo=round(odbc_result($tb_part,'price_quo'));
			if($price_quo==0){$prc_fc=$price_p;}else{$prc_fc=$price_quo;}
			$amn_fc=$prc_fc*$qty_plan;
			$amn_p=round(odbc_result($tb_part,'amn_p'));
			$amn_a=round(odbc_result($tb_part,'amn_a'));

			if($amn_a>$amn_p){
				if($qty_act>$qty_plan and $price_a=$price_p) {
					$qty_pk=$qty_plan;
					$qty_add=$qty_act-$qty_plan;
					$price_pk=$price_a;
					$price_add=$price_a;
				}
				else if($qty_act=$qty_plan and $price_a>$price_p) {
					$qty_pk=$qty_plan;
					$qty_add=$qty_plan;
					$price_pk=$price_a;
					$price_add=$price_a-$price_p;
				}
			}
			else{
				$qty_pk=$qty_plan;
				$qty_add=0;
				$price_pk=$price_a;
				$price_add=0;
			}
			$amn_pk=$qty_pk*$price_pk;
			$tb_kdchg=odbc_exec($koneksi_lp,"select distinct top 1 isnull(kode_chg,0) as kode_chg from bps_budget_add where no_ctrl='$no_ctrl' and periode='$periode'");
			$kdchg=odbc_result($tb_kdchg,"kode_chg");
			if($kdchg>3){
				$Qplan=0;$Pplan=0;$Amnplan=0;
				$Qstp=0;$Pstp=0;
				$Qadd=$qty_plan;$Padd=$price_a;
			}
			else{
				$Qplan=$qty_plan;$Pplan=$price_p;$Amnplan=$amn_p;

				if($qty_act>$Qplan){
					$Qstp=$Qplan;
					$Qadd=$qty_act-$Qstp;
					if($kdchg==''){$Padd=0;}else{
						$Padd=$prc_fc;}
					}
					else{
						$Qstp=$qty_act;
						$Qadd=0;$Padd=0;
					}

					if($price_a>$Pplan){
						$Pstp=$price_p;
						$Padd=$price_a-$Pplan;
						if($kdchg==''){$Qadd=0;
						}
						else{
							$Qadd=$Qplan;
						}
					}
					else{
						$Pstp=$price_a;$Padd=0;$Qadd=0;
					}
				}
				$Diff_pfc=$Amnplan-$amn_fc;
				$Amnstp=$Qstp*$Pstp;
				$Amnadd=$Qadd*$Padd;
	//$Amnadd=$qty_add*$price_add;
				$AmnTot=$Amnstp+$Amnadd;
				$DiffTot=$AmnTot-$Amnstp;

				$crjmpr=odbc_exec($koneksi_lp,"select count(no_ctrl) as jm from bps_tmpPR where no_ctrl='$no_ctrl' and periode='$periode'");
				$jm=odbc_result($crjmpr,"jm");

				$crpr=odbc_exec($koneksi_lp,"select distinct pr_no from bps_tmpPR where no_ctrl='$no_ctrl' and periode='$periode' order by pr_no asc");
				$x=0;$gpr="";
				while(odbc_fetch_array($crpr)){
					$x++;
					$pr=odbc_result($crpr,"pr_no");
					$gpr=$pr.","."<br />".$gpr;
				}
				if($jm==0){$pr_no='';}
				else if($jm>1){$pr_no=$gpr;}else{$pr_no=$pr;}
				$Tamn_p=$Tamn_p+$Amnplan;
				$Tamn_fc=$Tamn_fc+$amn_fc;
				$Tamn_dfc=$Tamn_dfc+$Diff_pfc;
				$Tamn_add=$Tamn_add+$Amnadd;
				$Tamn_stp=$Tamn_stp+$Amnstp;
				$Tamn_act=$Tamn_act+$AmnTot;
				$TDiff=$TDiff+$DiffTot;
				?>	
				<tr class="odd gradeX">
					<td height="13" align="center" valign="middle" nowrap="nowrap"><?php echo $sect;?></td>
					<td align="left" valign="middle" nowrap="nowrap"><?php echo $no_ctrl ;?></td>
					<td align="left" valign="middle" nowrap="nowrap"><?php echo $part_no ;?></td>
					<td align="left" valign="middle" nowrap="nowrap"><?php echo $part_nm;?></td>
					<td align="left" valign="middle" nowrap="nowrap"><?php echo $part_dtl." ".$part_desc;?></td>
					<td align="center" valign="middle" nowrap="nowrap"><?php echo $account;?></td>
					<td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",round($Qplan,3)));?></td>
					<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$Pplan));?></td>
					<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$Amnplan));?></td>
					<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$prc_fc));?></td>
					<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$amn_fc));?></td>
					<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$Diff_pfc));?></td>
					<td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",round($Qstp,3)));?></td>
					<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$Pstp));?></td>
					<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$Amnstp));?></td>
					<td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",round($Qadd,3)));?></td>
					<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$Padd));?></td>
					<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$Amnadd));?></td>
					<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$AmnTot));?></td>
					<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$DiffTot));?></td>
					<td align="left" valign="middle" nowrap="nowrap"><?php echo $pr_no;?></td>
				</tr>
				<?php
			}
			?>
			<tr align="center" valign="middle">
				<td height="13" colspan="6" align="center" valign="middle" nowrap="nowrap">TOTAL :</td>
				<td align="right" valign="middle" nowrap="nowrap"></td>
				<td align="center" valign="middle" nowrap="nowrap"></td>
				<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$Tamn_p));?></td>
				<td align="center" valign="middle" nowrap="nowrap"></td>
				<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$Tamn_fc));?></td>
				<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$Tamn_dfc));?></td>
				<td align="center" valign="middle" nowrap="nowrap"></td>
				<td align="center" valign="middle" nowrap="nowrap"></td>
				<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$Tamn_stp));?></td>
				<td align="center" valign="middle" nowrap="nowrap"></td>
				<td align="center" valign="middle" nowrap="nowrap"></td>
				<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$Tamn_add));?></td>
				<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$Tamn_act));?></td>
				<td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$TDiff));?></td>
				<td align="center" valign="middle" nowrap="nowrap"></td>
			</tr>
		</tbody>
	</table>

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