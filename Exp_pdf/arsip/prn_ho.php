<?php
session_start();
include "../koneksi.php";
//$res	= base64_decode($_GET['Qry']);
$whr= base64_decode($_GET['Qry']);

$tbl1="bps_serahterima";
$tbl2="bps_part";
$res="select $tbl1.type_brg,$tbl1.part_no,$tbl1.qty,$tbl2.part_nm,$tbl2.part_dtl from $tbl1 left join $tbl2 on $tbl1.part_no=$tbl2.part_no $whr ";
$Jdl='HANDOVER';
$periode=date("Y-m-d H:i:s");
//$almt="JL. RAYA WALISONGO KM 9.8 TUGUREJO KEC TUGU SEMARANG 50151";

//-----------------------Kode program untuk mencetak halaman----------------------//
$nama_dokumen=$Jdl; //Beri nama file PDF hasil.

include("../MPDF57/mpdf.php");
$mpdf=new mPDF('utf-8','A4'); // Create new mPDF Document

//Beginning Buffer to save PHP variables and HTML tags
ob_start();
//-----------------------Kode program untuk mencetak halaman----------------------//
//-----------------------------Copy juga yang di bawah----------------------------//
$html = '
<style>
body {font-family: sans-serif;
	font-size: 9pt;
	background: transparent url(\'bgbarcode.png\') repeat-y scroll left top;
}
h5, p {	margin: 0pt;
}
table.items {
	font-size: 9pt; 
	border-collapse: collapse;
	border: 3px solid #880000; 
}
td { vertical-align: top; 
}
table thead td { background-color: #EEEEEE;
	text-align: center;
}
table tfoot td { background-color: #AAFFEE;
	text-align: center;
}
.barcode {
	padding: 1.5mm;
	margin: 0;
	vertical-align: top;
	color: #000000;
}
.barcodecell {
	text-align: center;
	vertical-align: middle;
	padding: 0;
}
</style>';

$header = '
<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: center; font-family:
serif; font-size: 10pt; color: #000088;"><tr>
<td  bgcolor="#FFFF00"  width="75%"><span style="font-size:12pt;"><h5 ><u>'.$home.'</u><br><p style="font-size:8px"><h3>'.$almt.'</p></h5></span></td>
<td bgcolor="#D3D3D3" width="25%" style="text-align: center;"><span style="font-weight: bold;"><h5><u>'.$_SESSION['nama'].'</u><br><p style="font-weight">'.$periode.'</p></h5></span></td>
</tr></table>';
$mpdf->mirrorMargins = 1;
$mpdf->SetHTMLHeader($header);
$mpdf->mirrorMargins = 1;
$mpdf->SetFooter('{DATE j-m-Y}|{PAGENO}/{nb}|'.$Jdl);
//echo $res;
	?>
		<br>
		
<br><span id="idf" align='center'><h4><u><?php echo $Jdl; ?></u><br><?php echo $periode;?></h4></span></p>
<table width="100%" border="1" style="border-collapse: collapse; font-size:12px;">
  <thead>
  <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
		<tr style="font-size:20px;text-align:center;">
<th>TYPE BARANG</th>
<th>PART NO</th>
<th>NAMA PART</th>
<th>DETAIL PART</th>
<th>QTY</th>
		</tr>
	</thead>
	<tbody>
       
<?php		
$tb_part=odbc_exec($koneksi_lp,$res);
	while($baris0=odbc_fetch_array($tb_part)){$row++;
	$pn=odbc_result($tb_part,"part_no");				
					
				?>
				
				<tr>
<td><?php echo odbc_result($tb_part,"type_brg"); ?></td>
<td style="font-size:15px;text-align:center;"><?php echo '<barcode code="'.$pn.'" type="C128A" class="barcode" /><br>'.$pn ; ?></td>
<td><?php echo odbc_result($tb_part,"part_nm"); ?></td>
<td><?php echo odbc_result($tb_part,"part_dtl"); ?></td>
<td><?php echo odbc_result($tb_part,"QTY"); ?></td>		
				</tr>
		<?php 	}	?>



  </tbody>
</table>


<?php
//echo $sql_sum;
	//-----------------------Kode program untuk mencetak halaman----------------------//
	$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	ob_end_clean();
	//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
	$mpdf->WriteHTML(utf8_encode($html));
	$mpdf->Output($nama_dokumen.".pdf" ,'I');

	exit;
	//-----------------------Kode program untuk mencetak halaman----------------------//
?>