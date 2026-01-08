<?php
error_reporting(0);
session_start();

include "../koneksi.php";
$periode=date("d-m-Y H:i:s");
$nomor=$_GET['nomor'];
$kd=$_GET['no_doc'];
$sect=$_GET['sect'];
//-----------------------Kode program untuk mencetak halaman----------------------//
$nama_dokumen='VP NO = '.$kd; //Beri nama file PDF hasil.

include("../mpdf57/mpdf.php");
$mpdf=new mPDF('utf-8', 'A4'); // Create new mPDF Document
//$mpdf->setFooter("Halaman {PAGENO} dari {nb}");

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
$sql_stk1="select * from bps_vp a inner join LP_SUPP b on a.kode_supp=b.SUPP_CODE where vp_no='$kd'";
$tb_stk1=odbc_exec($koneksi_lp,$sql_stk1);
$pph=odbc_result($tb_stk1,"pph");
//echo $sql_stk1;								   
while(odbc_fetch_array($tb_stk1)){
	$novp=odbc_result($tb_stk1,"vp_no");
	$supp_name=odbc_result($tb_stk1,"supp_name");
	$tgl_doc= date("d-m-Y",strtotime(odbc_result($tb_stk1,"tgl_updt")));
	$lp=odbc_result($tb_stk1,"lp");
	$no_doc=odbc_result($tb_stk1,"po_no");
	$no_doc=odbc_result($tb_stk1,"po_no");
	$reason=odbc_result($tb_stk1,"reason");
	$paid_date=date("d-m-Y",strtotime(odbc_result($tb_stk1,"paid_date")));
	$amn=odbc_result($tb_stk1,"tot_bayar");
	}
?>

<table width="780" height="100" border="0">
  <tr>
    <td width="52"></td>
    <td width="430" colspan="9"align="center" valign="bottom" font size="16px"><font face="Arial Narrow"><strong>PT. SEMARANG AUTOCOMP MANUFACTURING INDONESIA</strong></font></td>
    <td height="20" colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2"><img src='..\images\confidential.jpg' width="70" height="50"></td>
    <td height="20" colspan="9" align="center" font size="14px"><font face="Arial Narrow"><strong>WIRING HARNESS MANUFACTURER </strong></font></td>
    <td width="34" style="font-family: Arial Narrow, Helvetica, sans-serif; font-size: 12px;">No.</td>
    <td width="9">:</td>
    <td width="114" colspan="4">__________________</td>
  </tr>
  <tr>
    <td colspan="9" rowspan="2" align="center" style="font-family: Century Gothic; font-size: 28px;" ><strong><u>VOUCHER PAYING</u></strong></td>
    <td height="20" style="font-family: Arial Narrow, Helvetica, sans-serif; font-size: 12px;">Date</td>
    <td>:</td>
    <td colspan="4" style="font-family: Arial Narrow, Helvetica, sans-serif; font-size: 12px;"><?php echo $tgl_doc;?></td>
  </tr>
  <tr>
  <td style="font-size: 10px;"><?php echo $kd;?></td>
    <td height="20" style="font-size: 12px;">Dept.</td>
    <td>:</td>
    <td colspan="4" style="font-size: 12px;"><?php echo $sect;?></td>
  </tr>
  
</table>
  	<?php 
	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}
 
 
	//$angka = $amn;
	
	?>
<table width="782" border="1" style="font-family: Arial Narrow, Helvetica, sans-serif; border-collapse: collapse;">
<tr>
    <td width="200" colspan="6" height="35">Paid To :  <?php echo $supp_name;?></td>
    <td colspan="10" rowspan="2">
        <p>Amount Rp. <?php 
		$crppn=odbc_exec($koneksi_lp,"select distinct ppn from LP_SUPP where supp_name='$supp_name'");
		$ppn=odbc_result($crppn,"ppn");

		$prc_ppn=$amn*($ppn/100);
		$prc_pph=$amn*($pph/100);
		$tot_bayar=$amn+$prc_ppn-$prc_pph;
		echo number_format($tot_bayar,2,",",".");?></p>
		<br/>
		<p>Say  : <em><u><?php echo ucwords(terbilang($tot_bayar))." Rupiah";?></u></em></p>
		

	</td>
  </tr>
  <tr>
    <td colspan="6" height="35">Date :  <?php //echo $paid_date;?></td>
  </tr>
</table>
<table width="782" border="1" style="font-family: Arial Narrow, Helvetica, sans-serif; border-collapse: collapse; font-size:12p;">
  <tr>
    <td width="300" colspan="7" rowspan="3" valign="top"> Payment For :<br></br>
	<p><?php $crpo=odbc_exec($koneksi_lp,"select distinct inv_no from bps_vp where vp_no='$kd' order by inv_no asc");
	$x=0;$gpo="";
	while(odbc_fetch_array($crpo)){
	$x++;
	$po=odbc_result($crpo,"inv_no");
	$gpo="Invoice : ".$po ."<br/>".$gpo;
	}

	echo $gpo;?></p><br/>
	<p><?php echo $reason;?></p></td>
    <td colspan="9" height="20" align="center" style="font-size: 12px;">General Ledger</td>
  </tr>
  <tr>
    <td width="95" colspan="3" align="center" style="font-size: 12px;">Profit Centre</td>
    <td width="95" colspan="2" align="center" style="font-size: 12px;">Account Code</td>
    <td width="95" colspan="2" align="center" style="font-size: 12px;">Activity Centre</td>
    <td width="95" colspan="2" align="center" style="font-size: 12px;">Amount</td>
  </tr>
  <tr>
    <td height="90" colspan="3">&nbsp;</td>
    <td height="90" colspan="2">&nbsp;</td>
    <td height="90" colspan="2">&nbsp;</td>
    <td height="90" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="16" valign="bottom">Paid Thru  :
	</td>
  </tr>
</table>
<table width="782" border="1" style="font-family: Arial Narrow, Helvetica, sans-serif; border-collapse: collapse; font-size:14p;">
  <tr>
    <td width="150" colspan="3" align="center">Verified</td>
    <td width="150" colspan="2" align="center">Approved</td>
    <td width="150" colspan="2" align="center">Checked</td>
    <td width="150" colspan="2" align="center">Prepared</td>
	<td width="150" colspan="2" align="center">Received</td>
  </tr>
  <tr>
    <td height="90" colspan="3">&nbsp;</td>
    <td height="90" colspan="2">&nbsp;</td>
    <td height="90" colspan="2">&nbsp;</td>
    <td height="90" colspan="2">&nbsp;</td>
	<td height="90" align="center" valign="bottom" colspan="2" style="font-family: Arial Narrow; font-size:10p;">*Only fill if cash payment</td>
  </tr>
</table>
	
	
	
	
<!--table width="782" border="1" style="font-family: Arial Narrow, Helvetica, sans-serif; border-collapse: collapse; font-size:10px; width:800px;">
  <tr>
    <td height="35" colspan="2">Paid To :</td>
    <td rowspan="2" colspan="7" valign="middle">
	<p>Amount Rp. ...........................................................................</p><br>
	<p align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-style: italic; font-size:12px;">Say : <?php echo terbilang($angka);?></p></td>
  </tr>
  <tr>
    <td height="35" colspan="2">Date : </td>
  </tr>
  <tr>
    <td colspan="4" rowspan="3">&nbsp;</td>
    <td height="20" colspan="5" align="center">General Ledger </td>
  </tr>
  <tr>
    <td height="20" width="100" align="center">Profit Centre</td>
    <td width="100" align="center">Account Code</td>
    <td width="100" colspan="2" align="center">Activity Centre</td>
    <td width="100" align="center" div="div">Amount</td>
  </tr>
  <tr>
    <td height="90">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="35" colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="35" colspan="9" valign="bottom">Paid Thru : </td>
  </tr>
  <tr>
    <td height="20" width="150" align="center">Verified</td>
    <td width="150" colspan="2" align="center">Approved</td>
    <td width="140" colspan="2" align="center">Checked</td>
    <td width="90" colspan="2" align="center">Prepared</td>
    <td width="90" colspan="2" align="center">Received</td>
  </tr>
  <tr>
    <td height="90">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>

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