  
 <script type="text/javascript">
	function open_child(url,title,w,h){
	//var des_p=document.form1.FilDesc.value;+'&desP='+des_p
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
        status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
        width='+w+',height='+h+',top='+top+',left='+left);
		
    };
</script>
<style type="text/css">
.sami{
	font-weight: bold;
	font-size: 24px;
	text-align: left;
	font-family: "Arial Black", Gadget, sans-serif;
}
</style>

 <div class="card">
 <div class="container-fluid">
<div class="card">
 <div class="container-fluid">
 <?php
 include "koneksi.php";
$periode=date("d-m-Y H:i:s");
$dok=$_GET['j'];
$kd=$_GET['nd'];
 $sect= $_SESSION["area"];
$pic_updt=$_SESSION['nama'];
$ttd="<p><img src='..\..\img\logo_sami.png' width='80' height='50' alt='sami' /></p>";
$sql_stk1="select *,(select sum(qty*price) as amonadd from bps_budget_add where no_ctrl=bps_pr.no_ctrl) as tambah from bps_PR where PR_NO='$kd'";
$tb_stk1=odbc_exec($koneksi_lp,$sql_stk1);	
$tambah="";										   
while(odbc_fetch_array($tb_stk1))
{
	$per=odbc_result($tb_stk1,"periode");
	$per_bud=date("M-Y",strtotime($per."01"));
	$sec=odbc_result($tb_stk1,"sect");
	$sec_bud=explode("-",$sec);
	$prno=odbc_result($tb_stk1,"PR_NO");
	$remarky=odbc_result($tb_stk1,"REMARK");
	$prdate=odbc_result($tb_stk1,"PR_DATE");
	$tambah=odbc_result($tb_stk1,"tambah");
	}
	
	if($tambah!=""){echo '<h3 style="text-align:right;"><i>ADDITIONAL</i></h3>';}
$qry_crphase="select distinct bps_budget.phase from bps_pr inner join bps_budget on bps_pr.no_ctrl=bps_budget.no_ctrl where bps_pr.PR_NO='$kd'";
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
  <!--table width="388" border="1" style="border-collapse: collapse;"-->
  <?php
/*  $sql_aprv="select * from bps_approve where jns_doc='PR' and no_doc='$kd' order by no_aprv desc";
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
*/  ?>
  <!--/table-->
  
   <form action="" id="frmcari" method="post"  enctype="multipart/form-data">
   <div class="col-sm-2">
	<button type="submit" align="right" name="apprv" id="apprv" class="btn bg-purple"><i class="material-icons">search</i>APPROVE </button>
	
    </div>
   </form>
</td>
</tr>
</table>
<?php
if(isset($_POST['apprv']) ){	
$squpdtapp="update bps_approve set Pic_act='$pic_updt',tgl_updt=getdate(),status='Close' where no_doc='$prno' and jns_doc='$dok' and sect='$sect'";
$tb_acc=odbc_exec($koneksi_lp,$squpdtapp);
echo "<script>alert('APPROVED');window.close();</script>";
}
?>
<br />
<table border="1" style="border-collapse: collapse; font-size:10px; width:800px; font-weight: bold;">
	<thead>
		<tr>
			<th width="29">NO.</th>
			<th width="71">BUDGET <p>REF.</p></th>
			<th width="260">DETAILS OF GOODS / SERVICES</th>
			<th width="36">QTY</th>
			<th width="36">CURR</th>
			<th width="93">ESTIMATES PRICE</th>
			<th width="109">AMOUNT</th>
			<th width="73">REQUIRED DATE</th>
			<th width="77">CARLINE</th>
		</tr>
	</thead>
	<tbody>
                                       
        
<?php
$sql_stk31="select distinct part_no,part_nm,part_dtl,part_desc,uom,cccode,curr,price_quo as price,dbo.cr_waktulp('rcv',no_ctrl) as esti,sum(qty_tot) as qty  from bps_tmpPR where pr_no='$prno' group  by  part_no,part_nm,part_dtl,part_desc,uom,cccode,curr,price_quo,no_ctrl";
//$sql_stk31="select bps_pr.PR_NO,dbo.cr_waktulp('rcv',bps_budget.no_ctrl) as esti,bps_budget.* from bps_PR inner join bps_budget on bps_PR.no_ctrl=bps_budget.no_ctrl where bps_PR.PR_NO='$prno'";
	$tb_stk31=odbc_exec($koneksi_lp,$sql_stk31);
			
	$nop=0;$t_Amo=0;
	while(odbc_fetch_array($tb_stk31))
	{
	$nop++;
	$uo=odbc_result($tb_stk31,"uom");
	$prc=odbc_result($tb_stk31,"PRICE");
	$qt=odbc_result($tb_stk31,"Qty");
	$Amo=$prc*$qt;
	$esti=date("d-M-Y",strtotime(odbc_result($tb_stk31,"esti")));
	$t_Amo=$t_Amo+$Amo;
?>
   <tr class="odd gradeX">
   <td height="23" align="right" valign="middle" nowrap="nowrap"><?php echo $nop;?></td>
   <td align="left" valign="middle" nowrap="nowrap"><?php echo odbc_result($tb_stk31,"part_nm");?></td>
   <td align="left" valign="middle" nowrap="wrap"><?php echo odbc_result($tb_stk31,"part_no")." ".odbc_result($tb_stk31,"part_dtl")." ".odbc_result($tb_stk31,"part_desc");?></td>
   <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$qt),0);if($uo<>"0"){ echo " ".$uo;}?></td>
   <td align="center" valign="middle" nowrap="nowrap"><?php echo odbc_result($tb_stk31,"curr");?></td>
   <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$prc),2,'.',',');?></td>
   <td align="center" valign="middle" nowrap="nowrap"><?php echo odbc_result($tb_stk31,"curr")." ".number_format(sprintf("%.2f",$Amo),2,'.',',');?></td>
   
   <td align="center" valign="middle" nowrap="nowrap"><?php echo $esti;?></td>
   <td align="center" valign="middle" nowrap="nowrap"><?php echo odbc_result($tb_stk31,"cccode");?></td>
    </tr>
	
	<?php
	}
	
	$fg=9-$nop;
	
	if($nop<9){
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
      <td height="22" colspan="6" align="center" valign="middle" nowrap="nowrap">TOTAL :</td>
      <td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$t_Amo),2,'.',',');?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<?php 
	$qry_bal="select '$sec' AS SECT,'$per' AS PERIODE,(select sum(dbo.lp_konprc(term,'USD',curr,price*qty)) as sp from bps_budget where sect='$sec' and periode='$per') AS PLN
,(select sum(dbo.lp_konprc(term,'USD',curr,price*qty)) as sp from bps_pr where sect='$sec' and periode='$per') AS ACT;";
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
	  <h5>ENDING BUDGET PER <?php echo date("Y-mmm-dd H:i:s"); ?></h5>
	  <ul>
	  <li>PLAN :USD <?php echo number_format(sprintf("%.2f",$pln),2,'.',','); ?></li>
	  <li>ACT  :USD <?php echo number_format(sprintf("%.2f",$act),2,'.',','); ?></li>
	  <li>BAL  :USD <?php echo number_format(sprintf("%.2f",$bal),2,'.',','); ?></li>
	  </ul>
	  </td>
      <td align="center" valign="middle">RECEIVED</td>
    </tr>
    <tr>
      <td height="63" colspan="6" rowspan="2" align="left" valign="top"><?php echo $remarky;?></td>
      
      <td height="60">&nbsp;</td>
    </tr>
    <tr>
<!--td colspan="5" align="left" height="22">&nbsp;</td>
<td align="center"></td>
<td><b></b></td-->
<td align="center" valign="middle"><b>PURCHASING</b></td>
</tr>
  </tbody>
</table>
</div></div></div>
</div>
