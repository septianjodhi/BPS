<?php
error_reporting(0);
session_start();

$lok=$_GET['lok'];

// $_SESSION['lok']=$_GET['sesi'];	
include "../koneksi.php";

$periode=date("d-m-Y H:i:s");
$nomor=$_GET['nomor'];
$kd=$_GET['nodoc'];
$rmk=$_GET['rmk'];
$pic_updt=$_SESSION['nama'];
$pic_plan=$_GET['picplan'];
$sec= $_SESSION["area"];
$jnsdok=$_GET['jnsdok'];
$no_aprv=$_GET['noaprv'];
$initial=$_GET['initial'];
$user=$_SESSION["user"];
$stts=$_GET['stts'];
$akses=$_SESSION["akses"];
$adm=strpos($akses,'ADM_FA');
$aprv_dok=strpos($akses,'APP_PR');
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
    <td align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 20px;">FORM PLAN ADDITIONAL EXPENSE</td>
  </tr>
</table>
<?php
$ttd="<p><img src='..\img\logo_sami.png' width='80' height='50' alt='sami' /></p>";
//$sql_stk1="select pr_no,pr_date,no_ctrl,qty,price,term,periode,sect,curr,dbo.lp_konprc(term,'IDR',curr,(select price from bps_budget_add where bps_pr.no_ctrl=bps_budget_add.no_ctrl)) as price_add,(select qty from bps_budget_add where bps_pr.no_ctrl=bps_budget_add.no_ctrl) as qty_add,dbo.lp_konprc(term,'USD',curr,(select price from bps_budget_add where bps_pr.no_ctrl=bps_budget_add.no_ctrl)) as CurUSD,dbo.cr_waktulp('rcv',bps_pr.no_ctrl) as est,(select doc_no from bps_budget_add where bps_pr.no_ctrl=bps_budget_add.no_ctrl) as doc_no from bps_pr where PR_NO='$kd'";
//$sql_stk1="select distinct doc_no,min(doc_date) as doc_date,sect,dbo.lp_konprc(term,'USD',curr,sum(price*qty)) as amoUSD,dbo.lp_konprc(term,'IDR',curr,sum(price*qty)) as amoIDR,expaired
//from bps_budget_add where doc_no='$kd' group by doc_no,sect,expaired ";
$sql_stk1="select distinct periode,curr,doc_no,min(doc_date) as doc_date,pic_updt,sect,sum(dbo.lp_konprc(term,'USD',curr,price*qty)) as amoUSD,sum(price*qty) as amoIDR,expaired from bps_budget_add where doc_no='$kd' group by doc_no,sect,expaired,pic_updt,curr,periode";
$tb_stk1=odbc_exec($koneksi_lp,$sql_stk1);

$sect=odbc_result($tb_stk1,"sect");
$curr=odbc_result($tb_stk1,"curr");
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
  <tr><td>DATE</td><td width="10">:</td><td width="150"><?php echo date("d F Y",strtotime($doc_date));?></td></tr>
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
$bar1="";$bar2="";$bar3="";$streq="";
while(odbc_fetch_array($tb_aprv)){
	if(odbc_result($tb_aprv,"approve")=="REQUEST"){
			$pic_plan=odbc_result($tb_aprv,"pic_plan");
			$streq=odbc_result($tb_aprv,"pic_act");
	}
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

<form action="" id="frmcari" method="post"  enctype="multipart/form-data">
	<div class="col-sm-2" align="left">
		<?php if($stts=='BLMCHECKED'){?>
			<button type="submit" align="right" name="apprv" id="apprv" class="btn bg-purple">APPROVE</button>
		<?php }else{ ?>
			<button type="submit" align="left" name="unapprv" id="unapprv" class="btn bg-purple">UNAPPROVE</button><?php }?>
	</div>
</form>

<?php
if(isset($_POST['apprv']) ){
	
	if($streq!="" || $pic_plan==$pic_updt || $aprv_dok!=0 ){
		
	if($adm!==FALSE){
		$update="update bps_approve set pic_act='$pic_updt',tgl_updt=getdate(),status='Close' where no_doc='$kd' and jns_doc='$jnsdok' and status is null";
		$squpdtapp=odbc_exec($koneksi_lp,$update);
		$finish=odbc_exec($koneksi_lp,"update bps_approve set status='FINISH' where no_doc='$kd' and jns_doc='$jnsdok'");
	}
	else{
		$update="update bps_approve set pic_act='$pic_updt',tgl_updt=getdate(),status='Close' where no_doc='$kd' and jns_doc='$jnsdok' and no_aprv<4";
		$squpdtapp=odbc_exec($koneksi_lp,$update);
	}

	$noapr="select top 1 no_aprv,email_plan from bps_approve where no_doc='$kd' and jns_doc='$jnsdok' and pic_act is null asc";
	$tbnoapr=odbc_exec($koneksi_lp,$noapr);
	$email=odbc_result($tbnoapr,"email_plan");

echo "<script>
alert('APPROVED');
window.close();
</script>";

	}else{
				echo "<script>
				alert('NOT ALLOWED');

				window.close();

				</script>";
			}
}


if(isset($_POST['unapprv'])){
	if($adm!==FALSE){
		$squpdtapp=odbc_exec($koneksi_lp,"update bps_approve set pic_act=NULL,tgl_updt=NULL,status=NULL where no_doc='$kd' and jns_doc='$jnsdok' and no_aprv>2");

		$UNfinish=odbc_exec($koneksi_lp,"update bps_approve set pic_act=pic_plan,status='Close' where no_doc='$kd' and jns_doc='$jnsdok' and no_aprv<3");

	}else{
		$squpdtapp=odbc_exec($koneksi_lp,"update bps_approve set pic_act=NULL,tgl_updt=NULL,status=NULL where no_doc='$kd' and jns_doc='$jnsdok' and no_aprv<4");
	}

		$noapr="select no_aprv,email_plan from bps_approve where no_aprv='$no_aprv'+1 and no_doc='$kd' and jns_doc='$jnsdok'";
		$tbnoapr=odbc_exec($koneksi_lp,$noapr);
		$email=odbc_result($tbnoapr,"email_plan");
//echo $squpdtapp;

		echo "<script>
		alert('UNAPPROVED ADDITIONAL NO $kd');

		window.close();

		</script>";
	}
	?>
<br />


<table width="100%" border="1" style="border-collapse: collapse; font-size:10px; font-weight: bold;">
	<thead>
	<tr>
	<th height="25">NO</th>
    <th>PART NAME</th>
    <th>DESCRIPTION</th>
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
	$sql_stk31="select doc_no,doc_date,term,periode,sect,no_ctrl_add,account,part_no,part_nm,part_desc,part_dtl,qty,kode_chg,ket_chg,uom,curr,
	dbo.lp_konprc(term,'USD',curr,price) as prcUSD,price as prcIDR,expaired,remark from bps_budget_add where doc_no='$kd' order by part_no";
	$tb_stk31=odbc_exec($koneksi_lp,$sql_stk31);
	$nop=0;$t_Amo=0;
	while(odbc_fetch_array($tb_stk31))
	{
	$nop++;
	$curr=odbc_result($tb_stk31,"curr") ;
	$uo=odbc_result($tb_stk31,"uom");
	$angka=odbc_result($tb_stk31,"kode_chg");
	//if($angka==2 or $angka==3){
	//$prc=odbc_result($tb_stk31,"price_add");
	//}else{$prc=odbc_result($tb_stk31,"prcIDR");}
	$uo=odbc_result($tb_stk31,"uom");
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
   <td width="100" align="left" valign="middle" nowrap="nowrap"><?php echo odbc_result($tb_stk31,"part_nm");?></td>
   <td width="350" align="left" valign="middle" nowrap="wrap"><?php echo odbc_result($tb_stk31,"part_no")." ".odbc_result($tb_stk31,"part_dtl")." ".odbc_result($tb_stk31,"part_desc");?></td>
   <td width="25" align="center" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$qt),2,'.',',');?></td>
   <td width="25" align="center" nowrap="nowrap"><?php if($uo<>"0"){ echo " ".$uo;}?></td>
   <td width="25" align="center" nowrap="nowrap"><?php echo $curr;?></td>
   <td width="70" align="right" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$prc),2,'.',',')?></td>
   <td width="80" align="right" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$Amo),2,'.',',');?></td>
   <td width="80" align="right" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$AmoUSD),2,'.',',');?></td>
   <td width="100" align="left" nowrap="nowrap"><?php 
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
      <td align="right	" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$t_Amo),2,'.',',');?></td>
      <td align="right" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$t_AmoUSD),2,'.',',');?></td>
	  <td height="22" align="center" valign="middle" nowrap="nowrap"></td>
	  <td height="22" align="center" valign="middle" nowrap="nowrap"></td>
    </tr>
  </tbody>
</table>









<!--===============================================================================================================-->
