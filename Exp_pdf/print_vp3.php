<!-- JIKA ADA DISCOUNT, PPN DI AMBIL DARI AMOUNT ASLI, DAN PPH DI AMBIL DARI AMOUNT YANG SUDAH DI KURANGI DENGAN DISCOUNT -->
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
$sql_stk1="select *,(tot_bayar+(tot_bayar*a.ppn/100)-(tot_bayar*pph/100)) as byr from bps_vp a inner join LP_SUPP b on a.kode_supp=b.SUPP_CODE where vp_no='$kd' order by inv_no asc";
$tb_stk1=odbc_exec($koneksi_lp,$sql_stk1);
//echo $sql_stk1;	
	//$supp_name="xxxxxx";
$t_amn=0;$t_byr=0;$t_amn2;
while($baris=odbc_fetch_array($tb_stk1)){
	$pph=odbc_result($tb_stk1,"pph");
	$novp=odbc_result($tb_stk1,"vp_no");
	$supp_name=odbc_result($tb_stk1,"supp_name");
	$tgl_doc= date("d-m-Y",strtotime(odbc_result($tb_stk1,"rcv_inv_date")));
	$lp=odbc_result($tb_stk1,"lp");
	$ppn=odbc_result($tb_stk1,"ppn");
	$curr=odbc_result($tb_stk1,"curr");
	$pic_updt=odbc_result($tb_stk1,"pic_updt");
	$no_doc=odbc_result($tb_stk1,"po_no");
	$reason=odbc_result($tb_stk1,"reason");
	$paid_thru=odbc_result($tb_stk1,"paid_thru");
	$discount=odbc_result($tb_stk1,"discount");
	//$paid_date=date("d-m-Y",strtotime(odbc_result($tb_stk1,"paid_date")));
	//$cenvertedTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes +45 seconds',strtotime($startTime)));
	$paid_date=date("d-m-Y",strtotime('+30 day',strtotime($tgl_doc)));
	$amn=odbc_result($tb_stk1,"tot_bayar");
	$t_amn=$t_amn+$amn-$discount;
	$t_amn2=$t_amn2+$amn;
	$prc_ppn=$t_amn*($ppn/100);
	$prc_pph=$amn*($pph/100);
	$tot_bayar=$t_amn+$prc_ppn-$prc_pph;
	$byr=odbc_result($tb_stk1,"byr");
	$t_byr=$t_byr+$tot_bayar;
}

if($curr=='IDR'){
	$total=floor($t_byr);
}else{
	$total=$t_byr;
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
		<td width="200" colspan="6" height="35"><?php echo "Paid To :  ".$supp_name;?></td>
		<td colspan="10" rowspan="2">
			<p>Amount <strong><?php 
			if($curr=='IDR'){
				$kd_curr="Rp. ";
				$id_curr=" Rupiah";
			}
			else if($curr=='JPY'){
				$kd_curr="JPY ";
				$id_curr=" Japan Yen";
			}
			else {
				$kd_curr="$ ";
				$id_curr=" Dolar USD";
			}

			echo $kd_curr.number_format($total,2,",",".");?></strong></p>
			<br/>
			<p>Say  : <em><u><strong><?php echo ucwords(terbilang($total+1)).$id_curr;?></strong></u></em></p>
		</td>
		</tr>
		<tr>
			<td colspan="6" height="35">Date :  <?php echo $paid_date;?></td>
		</tr>
	</table>

	<table width="780" height="163" border="1" style="font-family: Arial Narrow, Helvetica, sans-serif; border-collapse: collapse; font-size:14p;">
		<tr>
			<td height="90" valign="top"><p>Payment For :</p>
				<?php 
				$tb_stk1=odbc_exec($koneksi_lp,$sql_stk1);
				$i=0;$t_amn=0;
				while($baris=odbc_fetch_array($tb_stk1)){
					$i++;
					$novp=odbc_result($tb_stk1,"vp_no");
					$pph=odbc_result($tb_stk1,"pph");					
					$ppn=odbc_result($tb_stk1,"ppn");
					$curr=odbc_result($tb_stk1,"curr");
					$no_doc=odbc_result($tb_stk1,"po_no");
					$amn=odbc_result($tb_stk1,"tot_bayar");
					$discount=odbc_result($tb_stk1,"discount");
					$t_amn=$t_amn+$amn-$discount;
					$t_amn2=$t_amn2+$amn;
					$prc_ppn=floor($t_amn*($ppn/100));
					$prc_pph=floor($amn*($pph/100));
					$tot_bayar=floor($t_amn+$prc_ppn-$prc_pph);
					$po=odbc_result($tb_stk1,"inv_no");
					$amn_inv=$amn+floor($amn*($ppn/100))-floor($amn*($pph/100));
						// echo "Invoice : ".$po."
						// <br> Total Tagihan = ".$curr." ".number_format(floor($amn),2).
						// "<br> PPn = ".$curr." ".number_format(floor($prc_ppn),2).
						// "<br> PPh = ".$curr." ".number_format(floor($prc_pph),2)."<br>";
				}

					// echo $gpo;
					// echo "Discount = ".$curr." ".number_format($discount,2);
				?>
				<table>
					<tr><td>Invoice</td><td>:</td><td><?= $po; ?></td></tr>
					<tr><td>Total Tagihan</td><td>:</td><td><?= $curr." ".number_format(floor($amn),2) ; ?></td></tr>					
					<tr><td>PPn</td><td>:</td><td><?= $curr." ".number_format(floor($prc_ppn),2) ; ?></td></tr>
					<tr><td>PPh</td><td>:</td><td><?= $curr." ".number_format(floor($prc_pph),2) ; ?></td></tr>
					<tr><br></tr>
					<tr><br></tr>
					<tr><td>Discount</td><td>:</td><td><?= $curr." ".number_format($discount,2) ; ?></td></tr>
					<tr><td colspan="3"><?php echo $reason;?></td></tr>
				</table>
				<!-- <p><?php echo $reason;?></p></td> -->
			</tr>
			<tr>
				<td height="40" valign="top">Paid Thru  : <?php echo ucwords($paid_thru);?></td>
			</tr>
		</table>

		<?php /**/ ?>
		<table border="1" style="font-family: Arial Narrow, Helvetica, sans-serif; border-collapse: collapse; font-size:14p;">
			<?php
			$sql_aprv="select * from bps_approve where jns_doc='VP' and no_doc='$kd' order by no_aprv desc";
			$tb_aprv=odbc_exec($koneksi_lp,$sql_aprv);
			$bar1="";$bar2="";$bar3="";
			while(odbc_fetch_array($tb_aprv)){
				$bar1=$bar1.'<td width="150" colspan="2" align="center">'.odbc_result($tb_aprv,"approve").'</td>';
				$bar2=$bar2.'<td height="90" align="center" valign="bottom" colspan="2" style="font-family: Arial Narrow; font-size:11;">'.odbc_result($tb_aprv,"initial").'</td>';
				$bar3=$bar3.'<td height="15" colspan="2" align="left">date:</td>';
			}
			echo '<tr align="center">'.$bar1.'</tr>';
			echo '<tr align="center" valign="bottom">'.$bar2.'</tr>';
			echo '<tr align="left">'.$bar3.'</tr>';
			?>
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