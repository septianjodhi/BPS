<?php
//--error_reporting(0);
session_start();
include "../../koneksi.php";
$periode=date("d-m-Y H:i:s");
$nomor=$_GET['nomor'];
$pono=$_GET['po_no'];
$supp_code=@$_GET['supp_code'];
$lokasi=$_SESSION['lokasi'];
//-----------------------Kode program untuk mencetak halaman----------------------//
$nama_dokumen='PO NO = '.$pono; //Beri nama file PDF hasil.

include("../../mpdf57/mpdf.php");
$mpdf=new mPDF('c','A4','','',10,10,95,10,10,10); 
//$mpdf=new mPDF('utf-8', 'A4'); // Create new mPDF Document
//$mpdf->setFooter("NB : SETELAH TERIMA PO, MOHON KOLOM KUNING DIISI DAN DIKIRIM KEMBALI KE PT SAMI. Halaman {PAGENO} dari {nb}");

$ng="";
$qry_ceksupp="select * from bps_kontrak_supp where  tgl_berakhir>=getdate() and exists(select * from bps_podtl where po_no='$pono' and kode_supp=bps_kontrak_supp.kode_supp)";
$tb_qry_ceksupp=odbc_exec($koneksi_lp,$qry_ceksupp);
$ng=odbc_result($tb_qry_ceksupp,"kode_supp");
$mpdf->SetWatermarkText('SUPPLIER NOT ACTIVE');
$mpdf->watermark_font = 'DejaVuSansCondensed';
if($ng==""){
$mpdf->showWatermarkText = true;
}else{
$mpdf->showWatermarkText = false;}
//Beginning Buffer to save PHP variables and HTML tags
// ob_start();
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

include 'hdr_po-contoh.php';


//$mpdf->mirrorMargins = 1;
// $mpdf->SetHTMLHeader($header);
//$mpdf->mirrorMargins = 1;
// $mpdf->setFooter("NB : SETELAH TERIMA PO, MOHON KOLOM ACCEPTED BY DAN ETD PLAN DIISI DAN DIKIRIM KEMBALI KE PT SAMI. Halaman {PAGENO} dari {nb}");

?>
<br/>
<br/>
<table width="790" border="1" style="border-collapse: collapse; font-size:10px; width:790px;">
	<thead>
		<tr>
			<th width="5%">NO.</th>
			<th width="7%">CODE<br>ITEM</br></th>
			<th width="10%">REQ NO</th>
			<th width="33%">DETAILS OF GOODS / SERVICES</th>
			<th width="10%">QTY</th>
			<th width="10%">UNIT PRICE</th>
			<th width="15%">AMOUNT</th>
		</tr>

	</thead>

	<tbody>
		<?php
		$dtl_po="select distinct term,pr_no,part_no,part_nm,part_dtl,part_desc,ppn,pph,sum(qty) as qty,price,curr,lp,uom 
		from bps_podtl where po_no='$pono' group by pr_no,part_no,part_nm,part_dtl,part_desc,ppn,pph,price,curr,lp,uom,term";
//$dtl_po="select bps_podtl.*,(select ppn from lp_supp where supp_code=bps_podtl.kode_supp) as ppn from bps_podtl where po_no='$pono'";
		$tb_dtlpo=odbc_exec($koneksi_lp,$dtl_po);
		$xy=0;$amn_pph=0;
		while(odbc_fetch_array($tb_dtlpo)){

			$qt=odbc_result($tb_dtlpo,"qty");
			$term=odbc_result($tb_dtlpo,"term");
			$curr=odbc_result($tb_dtlpo,"curr");
			$t_qt=$t_qt+$qt;
			$uo=odbc_result($tb_dtlpo,"uom");
	// $harga=odbc_result($tb_dtlpo,"price");
			if($curr=='IDRA'){
				$prc=floor(odbc_result($tb_dtlpo,"price"));
			}
			else{$prc=odbc_result($tb_dtlpo,"price");
		}
	// IF($curr=='IDR'){$prc=round($harga);}else{$prc=$harga;}
		$lp=odbc_result($tb_dtlpo,"lp");
		$pph=odbc_result($tb_dtlpo,"pph");
		$Amo=$prc*$qt;
		$amnpph=floor($pph*$Amo/100);
		$amn_pph=$amn_pph+$amnpph;
		$t_Amo=$t_Amo+$Amo;
	// if($lp!='LD'){$ppn=floor($t_Amo/odbc_result($tb_dtlpo,"ppn"));}else{$ppn=0;}
			//$ppn=floor($t_Amo/odbc_result($tb_dtlpo,"ppn"));
		$ppn=floor($t_Amo*(odbc_result($tb_qry_supp,"ppn")/100));
		if($curr=='IDRA'){$total_bayar=floor($t_Amo) ;}else{$total_bayar=$t_Amo;}
		$GT=floor($ppn)+$total_bayar-floor($amn_pph);

		$xy++
		?>
		<tr class="odd gradeX">
			<td height="19" align="center" valign="middle" nowrap="nowrap"><?php echo $xy;?></td>
			<td width="100" align="center" valign="middle" nowrap="nowrap"><?php echo odbc_result($tb_dtlpo,"part_no");?></td>
			<td align="left" valign="middle" nowrap="nowrap"><?php echo odbc_result($tb_dtlpo,"pr_no");?></td>
			<td align="left" valign="middle" nowrap="wrap">
				<?php
				if ($term>80) {
					echo odbc_result($tb_dtlpo,"part_dtl")." ".odbc_result($tb_dtlpo,"part_desc");
				}else{
					echo odbc_result($tb_dtlpo,"part_nm")." ".odbc_result($tb_dtlpo,"part_dtl")." ".odbc_result($tb_dtlpo,"part_desc");
				}
				?>
			</td>
			<td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$qt),0,'.',',');if($uo<>"0"){ echo " ".$uo;}?></td>
			<td align="center" valign="middle" nowrap="nowrap"><?php echo $curr." ".number_format(sprintf("%.2f",$prc),2,'.',',');?></td>
			<td align="center" valign="middle" nowrap="nowrap"><?php echo $curr." ".number_format(sprintf("%.2f",$Amo),2,'.',',');?></td>
		</tr>

		<?php
	}

	$fg=11-$xy;

	if($xy<11){
		$vzz=0;
		while($vzz<$fg){
			?>
			<tr class="odd gradeX">
				<td height="19" align="center" valign="middle" nowrap="nowrap"></td>
				<td align="center" valign="middle" nowrap="nowrap"></td>
				<td align="center" valign="middle" nowrap="nowrap"></td>
				<td align="left" valign="middle" nowrap="nowrap"></td>
				<td align="center" valign="middle" nowrap="nowrap"></td>
				<td align="center" valign="middle" nowrap="nowrap"></td>
				<td align="center" valign="middle" nowrap="nowrap"></td>
			</tr>
			<?php
			$vzz++;
		}
	}
	?>
	<tr>
		<td colspan="4" align="Center" height="21">Total </td>
		<td align="center" valign="middle"></td>
		<td align="center" valign="middle"></td>
		<td align="center" valign="middle"><?php echo $curr." ".number_format(sprintf("%.2f",$t_Amo),0,'.',',');?></td>
	</tr>

	<tr>
		<td colspan="4" align="Center" height="21">PPN <?php echo odbc_result($tb_qry_supp,"ppn"); ?>% </td>
		<td align="center" valign="middle"></td>
		<td align="center" valign="middle"></td>
		<td align="center" valign="middle"><?php echo $curr." ".number_format(sprintf("%.2f",floor($ppn)),0,'.',',');?></td>
	</tr>
	<?php
	if($pph>0){
		?>
		<tr>
			<td colspan="4" align="Center" height="21">PPH <?php echo $pph;?> %</td>
			<td align="center" valign="middle"></td>
			<td align="center" valign="middle"></td>
			<td align="center" valign="middle">
				( <?php echo $curr." ".number_format(sprintf("%.2f",floor($amn_pph)),2,'.',',');?>)
			</td>
		</tr>
	<?php }?>
	<tr>
		<td colspan="4" align="Center" height="21">Grand Total</td>
		<td align="center" valign="middle"></td>
		<td align="center" valign="middle"></td>
		<td align="center" valign="middle">
			<strong><?php echo $curr." ".number_format(sprintf("%.2f",$GT),0,'.',',');?></strong>
		</td>
	</tr>
</tbody>
</table>

<table width="790" border="1" align="left" valign="top" style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; text-align: left; font-size:12px;">
	<tr>
		<td height="20" width="320" align="center">Alamat Pengiriman Barang dan Tagihan</td>
		<td width="460" align="center">Keterangan</td>
	</tr>
	<tr>
		<td width="340">
			<?php if ($lokasi=='TF') { ?>
				PT SEMARANG AUTOCOMP MANUFACTURING INDONESIA
				<br>Jl. Walisongo Km 9,8 Tugu Rejo</br>
				<br>Kecamatan Tugu, Semarang 50151 Jawa Tengah</br>
				<br>NPWP No.        : 01.869.469.5-055.000</br>
				<br>Contact Person  : <?php echo odbc_result($tb_qry_supp,"pic_updt"); ?></br>
			<?php }else{ ?>
				PT SEMARANG AUTOCOMP MANUFACTURING INDONESIA - JEPARA FACTORYY
				<br>Jl. Jepara Kudus KM 28 Sengon Bugel</br>
				<br>Kecamatan Mayong, Jepara 59465 Jawa Tengah</br>
				<br>NPWP No.        : 01.869.469.5-055.000</br>
				<br>Contact Person  : <?php echo odbc_result($tb_qry_supp,"pic_updt"); ?></br>
			<?php } ?>
		</td>
		<td width="440">
			<table width="440" height="296" border="0">
				<tr>
					<td align="center" valign="top" >1</td>						
					<td><?php if ($lokasi=='TF') { ?>
						Delivery ETA PT SAMI : Senin,Rabu,Kamis 07.30 s/d 15 .00 WIB.
					<?php } else { ?> 
						Delivery ETA PT SAMI Setiap hari pukul 07.30 s/d 15.00 WIB.
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<?php if ($lokasi=='TF') { ?>
						Jam istirahat PT SAMI : 10.10 s/d 10.25 WIB &amp; 12.40 s/d 13.20 WIB.
					<?php } else { ?> 
						Jam istirahat PT SAMI : 10.45 s/d 11.00 WIB &amp; 13.30 s/d 14.10 WIB.
					<?php } ?>
					( <strong>Pada waktu istirahat, tidak ada proses penerimaan barang </strong>) 
				</td>
			</tr>
			<tr>
				<td align="center"  valign="top" >2</td>
				<td>Barang yg dikirim ke SAMI harus BEBAS dari :</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Mercury, Cromium Heksavalen, Cadmium, Timbal/ PB</td>
			</tr>
			<tr>
				<td align="center"  valign="top" >3</td>
				<td> BEBAS dari bahan <strong>BERBAHAYA &amp; BERACUN</strong>, Jika ada harap disertai  <em>Material Safety Data Sheet</em> (<strong>MSDS</strong>), Simbol B3, dan kemasan tidak bocor.</td>
			</tr>
			<tr>
				<td align="center" valign="top" >4</td>
				<td>Barang yang dikirim menggunakan armada mobil, wajib memberikan  data uji emisi dari armada tersebut. Kandungan emisi dalam batas normal, dan armada yang masuk di kawasan PT SAMI, dalam kecepatan maksimal  &plusmn; 20 km/jam </td>
			</tr>
			<tr>
				<td align="center" valign="top" >5</td>
				<td>Pada saat pengiriman, setiap supplier wajib menjaga kedisiplinan, kesopanan, dan kebersihan lingkungan PT SAMI </td>
			</tr>
			<tr>
				<td align="center" valign="top" >6</td>
				<td>Barang yang berhubungan dengan kelistrikan harus mempunyai standar minimal <b>SNI</b> </td>
			</tr>
		</table>
	</td>
</tr>
</table>


<br>

<table width="900" border="0" style="font-size:10px; width:900px;" height="122" >
	<tr>
		<td width="30%">
			<table width="90" border="1" style="border-collapse: collapse; background-color: rgb(255,255,153); font-size:10px;">
				<tbody>
					<tr>
						<td width="90" align="center">Accepted By</td>
						<td width="90" align="center">ETD Plan</td>
					</tr>
					<tr>
						<td width="90" align="Left" height="70">&nbsp;</td>
						<td width="90" align="Left" height="70">&nbsp;</td>
					</tr>
					<tr>
					</tr>
				</tbody>
			</table>
		</td>
		<td colspan="2" rowspan="3"></td>
		<td width="70%" align="right">
			<table width="388" border="1" style="border-collapse: collapse; font-size:10px;">
				<tbody>
					<?php
					$sql_aprv="select * from bps_approve where jns_doc='PO' and no_doc='$pono' order by no_aprv desc";
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
				</tbody>
			</table>
		</td>
	</tr>
</table>

<?php

	//-----------------------Kode program untuk mencetak halaman----------------------//
	
	// $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	// ob_end_clean();
	//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);

	// $mpdf->WriteHTML(utf8_encode($html));
	// $mpdf->Output($nama_dokumen.".pdf" ,'I');

	
	// exit;
	//-----------------------Kode program untuk mencetak halaman----------------------//
?>