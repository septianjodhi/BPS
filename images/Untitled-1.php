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
.style3 {font-family: Calibri}
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
    <td width="102" height="21" >&nbsp;</td>
    <td width="408" valign="top" style="font-family: Calibri, Helvetica, sans-serif; font-size: 16px;" align="center"><strong>PT. SEMARANG AUTOCOMP MANUFACTURING INDONESIA</strong></td>
    <td width="257">&nbsp;</td>
  </tr>
  <tr>
    <td width="102" rowspan="2"><img src="confidential.jpg" width="102" height="61"></td>
    <td height="21" align="center" valign="top" style="font-family: Calibri, Helvetica, sans-serif; text-align: center;"><strong>WIRING HARNESS MANUFATURER </strong></td>
    <td width="257" rowspan="2"><table width="260" height="71" border="0">
      <tr>
        <td width="38" height="21"><span class="style3">No.</span></td>
        <td width="10">:</td>
        <td width="198">&nbsp;</td>
      </tr>
      <tr>
        <td height="21"><span class="style3">Date</span></td>
        <td>:</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="21"><span class="style3">Dept.</span></td>
        <td>:</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
   <tr>
    <td width="408" height="32" align="center" valign="bottom" style="font-family: Arial, Helvetica, sans-serif; font-size: 24px;"><strong><u>VOUCHER PAYING</u></strong></td>
  </tr>
</table>
<hr/ width="782" align='left'>
<table width="782" border="0.5">
  <tr>
    <td height="37" colspan="2">Paid To : </td>
    <td colspan="7"><p>Amount Rp.</p>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td height="49" colspan="2">Date : </td>
	<td colspan="7"><p>Say  </p></td>
  </tr>
  <tr>
    <td colspan="3" rowspan="2">&nbsp;</td>
    <td width="88" align="center">Profit Centre</td>
    <td width="104" align="center">Profit Centre</td>
    <td width="113" align="center">Account Code </div></td>
    <td colspan="2" align="center">Activity Centre </div></td>
    <td width="98" div align="center">Amount</div></td>
  </tr>
  <tr>
    <td height="100">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="44" colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="88" align="center">Verified</td>
    <td colspan="2" align="center">Approved</td>
    <td colspan="2" align="center">Checked</td>
    <td colspan="2" align="center">Prepared</td>
    <td colspan="2" align="center">Received</td>
  </tr>
  <tr>
    <td height="121">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>

