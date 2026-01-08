<?php
error_reporting(0);
session_start();

include "../koneksi.php";
$periode=date("d-m-Y H:i:s");
$nomor=$_GET['nomor'];
$kd=$_GET['nopr'];
//-----------------------Kode program untuk mencetak halaman----------------------//
$nama_dokumen='PR NO = '.$kd; //Beri nama file PDF hasil.

include("../mpdf57/mpdf.php");
$mpdf=new mPDF('utf-8', 'A4'); // Create new mPDF Document
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
<?php
$ttd="<p><img src='..\..\img\logo_sami.png' width='80' height='50' alt='sami' /></p>";
$sql_stk1="select * from bps_PR where PR_NO='$kd'";
$tb_stk1=odbc_exec($koneksi_lp,$sql_stk1);	
								   
while(odbc_fetch_array($tb_stk1))
{
	$per=odbc_result($tb_stk1,"periode");
	$per_bud=date("M-Y",strtotime($per."01"));
	$sec=odbc_result($tb_stk1,"sect");
	$sec_bud=explode("-",$sec);
	$prno=odbc_result($tb_stk1,"PR_NO");
	$remarky=odbc_result($tb_stk1,"REMARK");
	$prdate=odbc_result($tb_stk1,"PR_DATE");
	}

	$sql_stk2="select (a.qty*a.price) as tambah from bps_budget_add a inner join bps_pr b on a.no_ctrl=b.no_ctrl where pr_no='$kd'";
	$tb_stk2=odbc_exec($koneksi_lp,$sql_stk2);
	$tambah=odbc_result($tb_stk2,"tambah");
	if($tambah!=""){echo '<h3 style="text-align:right;"><i>ADDITIONAL</i></h3>';}
$qry_crphase="select distinct bps_budget.phase from bps_pr inner join bps_budget on bps_pr.no_ctrl=bps_budget.no_ctrl where bps_pr.PR_NO='$kd'
union
select distinct bps_budget_add.phase from bps_pr inner join bps_budget_add on bps_pr.no_ctrl=bps_budget_add.no_ctrl where bps_pr.PR_NO='$kd'";
$tb_crphase=odbc_exec($koneksi_lp,$qry_crphase);
while(odbc_fetch_array($tb_crphase)){
$phs=odbc_result($tb_crphase,"phase");
}

?>
<table width="781" border="0">
  <tr>
    <td width="95" class="sami">SAMI</td>
    <td width="554" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-size: 18px;">PT. SEMARANG AUTOCOMP MANUFACTURING INDONESIA</td>
    <td width="118">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-style: italic;">Wiring Harness Manufacturer</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="781" border="0">
  <tr>
    <td align="right" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 20px;">PURCHASE REQUISITION</td>
  </tr>
</table>
<?php

	
?>
<table width="782" height="122">
  <tr>
<td width="314">
  
  <table style="font-size:12px;">
  <tr><td>DATE</td><td width="10">:</td><td width="117"><?php echo date("d F Y",strtotime($prdate));?></td></tr>
  <tr><td>REGISTERED NO.</td><td>:</td><td><?php echo $prno;?></td></tr>
  <tr><td width="113">DEPT/SECTION</td><td>:</td><td><?php echo $sec_bud[0]." / ".$sec_bud[1];?></td></tr>
  <tr><td width="113">PERIODE</td><td>:</td><td><?php echo $per_bud;?></td></tr>
  <tr><td width="113">PHASE</td><td>:</td><td><?php echo $phs;?></td></tr>
  </table>
</td>
<td width="456" align="right">
  <table width="388" border="1" style="border-collapse: collapse;">
  <?php
  $sql_aprv="select * from bps_approve where jns_doc='PR' and no_doc='$kd' order by no_aprv desc";
$tb_aprv=odbc_exec($koneksi_lp,$sql_aprv);
$bar1="";$bar2="";$bar3="";
while(odbc_fetch_array($tb_aprv)){
$bar1=$bar1.'<td width="90" align="center">'.odbc_result($tb_aprv,"approve").'</td>';
$bar2=$bar2.'<td height="54" align="center" valign="bottom" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">'.odbc_result($tb_aprv,"pic_act").'</td>';	
$bar3=$bar3.'<td width="90" align="center">'.odbc_result($tb_aprv,"initial").'</td>';
}
echo '<tr align="center">'.$bar1.'</tr>';
echo '<tr align="center" valign="bottom">'.$bar2.'</tr>';
echo '<tr align="center">'.$bar3.'</tr>';
  ?>
  </table>
</td>
</tr>
</table>

<br />
<table border="1" style="border-collapse: collapse; font-size:10px; width:800px; font-weight: bold;">
	<thead>
		<tr>
			<th width="29">NO.</th>
			<th width="71">BUDGET <p>REF.</p></th>
			<th width="260">DETAILS OF GOODS / SERVICES</th>
			<th width="36">QTY</th>
			<th width="36">CURR</th>
			<th width="93">PRICE</th>
			<th width="109">AMOUNT</th>
			<th width="73">REQUIRED DATE</th>
			<th width="77">CARLINE</th>
		</tr>
	</thead>
	<tbody>
                                       
        
<?php
/*--->>>$sql_stk31="select no_ctrl,part_no,part_nm,part_dtl,part_desc,uom,cccode,curr,price_tot,dbo.cr_waktulp('vp',no_ctrl)as esti,qty_act as qty,dbo.lp_konprc(term,'USD',curr,sum(price_tot*qty_act)) as amoUSD 
from bps_tmpPR where pr_no='$prno' group by part_no,part_nm,part_dtl,part_desc,uom,cccode,curr,price_quo,price_tot,no_ctrl,qty_act,term order by part_no";*/
//$sql_stk31="select bps_pr.PR_NO,dbo.cr_waktulp('rcv',bps_budget.no_ctrl) as esti,bps_budget.* from bps_PR inner join bps_budget on bps_PR.no_ctrl=bps_budget.no_ctrl where bps_PR.PR_NO='$prno'";

$sql_stk31="select no_ctrl,part_no,part_nm,part_dtl,part_desc,uom,cccode,curr,price_tot,(case when exists (select top 1 no_ctrl from bps_budget_add where no_ctrl=a.no_ctrl) 
then (select top 1 expaired from bps_budget_add where no_ctrl=a.no_ctrl and periode=a.periode) else dbo.cr_waktulp('vp',no_ctrl) end) as esti,
qty_act as qty,dbo.lp_konprc(term,'USD',curr,sum(price_tot*qty_act)) as amoUSD from bps_tmpPR a where pr_no='$kd'
group by part_no,exp_pr,part_nm,part_dtl,part_desc,uom,cccode,curr,price_quo,price_tot,no_ctrl,qty_act,term,periode order by part_no";
echo $sql_stk31;
	$tb_stk31=odbc_exec($koneksi_lp,$sql_stk31);

	$nop=0;$t_Amo=0;$t_amoUSD=0;
	while(odbc_fetch_array($tb_stk31))
	{
	$nop++;
	$uo=odbc_result($tb_stk31,"uom");
	$curr=odbc_result($tb_stk31,"curr");
	$amoUSD=odbc_result($tb_stk31,"amoUSD");
	//$prc_quo=odbc_result($tb_stk31,"PRICE");
	$prc_tot=odbc_result($tb_stk31,"price_tot");
	//if($prc_quo==""){$prc=$prc_tot;}else{$prc=$prc_quo;}
	$qt=odbc_result($tb_stk31,"qty");
	$Amo=$prc_tot*$qt;
	$esti=date("d-M-Y",strtotime(odbc_result($tb_stk31,"esti")));
	$t_Amo=$t_Amo+$Amo;
	$t_amoUSD=$t_amoUSD+$amoUSD;
?>
   <tr class="odd gradeX">
   <td height="20" align="right" valign="middle" nowrap="nowrap"><?php echo $nop;?></td>
   <td align="left" valign="middle" nowrap="nowrap"><?php echo odbc_result($tb_stk31,"part_nm");?></td>
   <td align="left" valign="middle" nowrap="wrap"><?php echo odbc_result($tb_stk31,"part_no")." ".odbc_result($tb_stk31,"part_dtl")." ".odbc_result($tb_stk31,"part_desc");?></td>
   <td align="center" valign="middle" nowrap="nowrap"><?php echo round($qt,4);if($uo<>"0"){ echo " ".$uo;}?></td>
   <td align="center" valign="middle" nowrap="nowrap"><?php echo $curr;?></td>
   <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$prc_tot),2,'.',',');?></td>
   <td align="center" valign="middle" nowrap="nowrap"><?php 
   if($curr=='IDR'){
   echo number_format(round($Amo),2,".",",");}
   else {
   echo number_format(sprintf("%.2f",$Amo),2,'.',',');}?>
</td>
   
   <td align="center" valign="middle" nowrap="nowrap"><?php echo $esti;?></td>
   <td align="center" valign="middle" nowrap="nowrap"><?php echo odbc_result($tb_stk31,"cccode");?></td>
    </tr>
	
	<?php
	}
	
	$fg=6-$nop;
	
	if($nop<6){
		$vzz=0;
		while($vzz<$fg){
		?>
		<tr class="odd gradeX">
		   <td height="20" align="center" valign="middle" nowrap="nowrap"></td>
		   <td align="center" valign="middle" nowrap="nowrap"></td>
		   <td align="left" valign="middle" nowrap="nowrap"></td>
		   <td align="center" valign="middle" nowrap="nowrap"></td>
		   <td align="center" valign="middle" nowrap="nowrap"></td>
		   <td align="center" valign="middle" nowrap="nowrap"></td>
		   <td align="center" valign="middle" nowrap="nowrap"></td>
		   <td align="center" valign="middle" nowrap="nowrap"></td>
		   <td align="center" valign="middle" nowrap="nowrap"></td>
		  </tr>
		<?php
		$vzz++;
		}
	}
	?>
    <tr align="center" valign="middle">
      <td height="21" colspan="5" rowspan="2" align="center" valign="middle" nowrap="nowrap">TOTAL :</td>
	  <td height="21" colspan="1" align="center" valign="middle" nowrap="nowrap"><?php echo odbc_result($tb_stk31,"curr");?></td>
      <td align="center" valign="middle" nowrap="nowrap"><?php    if($curr=='IDR'){
   echo number_format(round($t_Amo),2,".",",");}
   else {
   echo number_format(sprintf("%.2f",$t_Amo),2,'.',',');}?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<tr align="center" valign="middle">
	  <td height="22" colspan="1" align="center" valign="middle" nowrap="nowrap">USD</td>
      <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$t_amoUSD),2,'.',',');?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<?php 
	//$qry_bal="select '$sec' AS SECT,'$per' AS PERIODE,(select sum(dbo.lp_konprc(term,'USD',curr,price*qty)) as sp from bps_budget where sect='$sec' and periode='$per') AS PLN,(select sum(dbo.lp_konprc(term,'USD',curr,price*qty)) as sp from bps_pr where sect='$sec' and periode='$per') AS ACT;";
	//$qry_bal="select  left(pr_no,len(pr_no)-9) as sect,periode,pr_no,(select sum(dbo.lp_konprc(term,'USD',curr,price*qty)) from bps_budget where sect='$sec' and periode='$per') as PLN,sum(dbo.lp_konprc(term,'USD',curr,pemakaian)) as ACT from bps_tmpPR WHERE periode='$per' and pr_no like '%$sec%' and replace(right(pr_no,8),'-','')<=replace(right('$prno',8),'-','') group by pr_no,periode order by pr_no asc";
	$qry_bal="select periode,sect,(select sum(dbo.lp_konprc(term,'USD',curr,price*qty)) from bps_budget_FA where sect='$sec' and periode='$per') as PLN,sum(dbo.lp_konprc(term,'USD',curr,price*qty)) as ACT from bps_pr where sect='$sec' and periode='$per' and replace(right(pr_no,8),'-','')<=replace(right('$prno',8),'-','') group by periode,sect";
	$tb_bal=odbc_exec($koneksi_lp,$qry_bal);
	$pln=0;$act=0;$bal=0;
	while(odbc_fetch_array($tb_bal))
	{
	$pln=odbc_result($tb_bal,"PLN");	
	$act=odbc_result($tb_bal,"ACT");
	$bal=$pln-$act;
	}
	?>
    <tr>
      <td colspan="6" align="left" height="21">REMARKS/REASONS : </td>
      <td  colspan="2"  rowspan="3">
	  <ul>
	  <li>PLAN STP:USD <?php echo number_format(sprintf("%.2f",$pln),2,'.',','); ?></li>
	  <li>ACT STP :USD <?php echo number_format(sprintf("%.2f",$act),2,'.',','); ?></li>
	  <li>BAL STP :USD <?php echo number_format(sprintf("%.2f",$bal),2,'.',','); ?></li>
	<?php /*$crbal="select sum(((case when a.qty-isnull(b.Qty,0)<0 then 0 else a.qty-isnull(b.Qty,0)end)*dbo.lp_konprc(a.term,'USD',a.curr,a.price))) as ambal 
	from bps_budget_FA a full join bps_pr b on a.periode=b.periode and a.sect=b.sect and a.no_ctrl=b.no_ctrl and b.tgl_updt<=(select top 1 tgl_updt from bps_pr where PR_NO='$prno' ) 
	where a.sect='$sec' and a.periode='$per'";
	$tb_crbal=odbc_exec($koneksi_lp,$crbal);
	$ambal=odbc_result($tb_crbal,"ambal");*/
	//echo $crbal;
	  ?>
	  <!--li>BAL BUDGET :USD <?php //echo number_format(sprintf("%.2f",$ambal),2,'.',','); ?></li-->
	  </ul>
	  </td>
      <td align="center" valign="middle">RECEIVED</td>
    </tr>
    <tr>
      <td height="50" colspan="6" rowspan="2" align="left" valign="top"><?php echo $remarky;?></td>
      
      <td height="50">&nbsp;</td>
    </tr>
    <tr>
<!--td colspan="5" align="left" height="22">&nbsp;</td>
<td align="center"></td>
<td><b></b></td-->
<td align="center" valign="middle"><b>PURCHASING</b></td>
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