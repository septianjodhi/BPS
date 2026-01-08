<?php
error_reporting(0);
session_start();

include "../koneksi.php";
$periode=date("d-m-Y H:i:s");
$nomor=$_GET['nomor'];
$kd=$_GET['hono'];
$pic_update= $_SESSION['nama'];
//-----------------------Kode program untuk mencetak halaman----------------------//
$nama_dokumen='HO NO = '.$kd; //Beri nama file PDF hasil.

include("../mpdf57/mpdf.php");
$mpdf=new mPDF('utf-8', 'A4'); // Create new mPDF Document

//setting footer
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
</style>
<?php
$ttd="<p><img src='..\..\img\logo_sami.png' width='80' height='50' alt='sami' /></p>";
$sql_stk1="
select a.inv_no,a.sect, a.pr_no, a.po_no, a.pic_lp, a.part_no, a.part_nm, a.part_dtl,
a.part_desc, a.pic_terima,a.tgl_terima,sum(a.qty) AS qty,a.uom,b.no_bc,b.tgl_bc,b.jns_bc
from bps_serahterima a left join bps_kedatangan b on a.inv_no=b.inv_no and a.no_ctrl=b.no_ctrl 
and a.po_no=b.po_no and a.pr_no=b.pr_no
where ho_no='$kd' 
group by a.sect,a.pr_no,a.po_no,a.pic_lp,a.part_no,a.part_nm,a.part_dtl,a.part_desc,a.pic_terima,a.tgl_terima,a.uom,a.inv_no,b.no_bc,b.tgl_bc,b.jns_bc";
$tb_stk1=odbc_exec($koneksi_lp,$sql_stk1);
// echo $sql_stk1;
$pr_no="";
while(odbc_fetch_array($tb_stk1))
{
	$sect=odbc_result($tb_stk1,"sect");
	$tgl=date("Y-m-d",strtotime(odbc_result($tb_stk1,"tgl_terima")));
	$pr_no=odbc_result($tb_stk1,"pr_no").",".$pr_no;
	$po_no=odbc_result($tb_stk1,"po_no");
	$pic_lp=odbc_result($tb_stk1,"pic_lp");
	$pic_terima=odbc_result($tb_stk1,"pic_terima");
	$bc_no=odbc_result($tb_stk1,"no_bc");
	$tgl_bc=odbc_result($tb_stk1,"tgl_bc");
	$inv_no=odbc_result($tb_stk1,"inv_no");
}
?>
<table width="781" border="0">
	<tr>
		<td width="95" class="sami">&nbsp;</td>
		<td width="554" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-size: 16px;"><em>PT. Semarang Autocomp Manufacturing Indonesia </em></td>
		<td width="118">&nbsp;</td>
	</tr>
</table>
<table width="781" border="0">
	<tr>
		<td width="75" align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 18px;"><u>BUKTI PENERIMAAN BARANG </u></td>
	</tr>
</table>

<table width="781" style="font-size:12px;">
	<tr>
		<td width="112">DEPT/SECTION</td>
		<td width="10">:</td>
		<td width="229"><?php echo $sect;?></td>
		<td width="112">BC NO. </td>
		<td width="10">:</td>
		<td width="112"><?= $bc_no ;?></td>
	</tr>
	<tr>
		<td>DATE</td>
		<td>:</td>
		<td><?php echo date("d F Y",strtotime($tgl));?></td>
		<td>BC DATE . </td>
		<td>:</td>
		<td><?php if($bc_no!=""){echo date("d-m-Y",strtotime($tgl_bc)); }  ?></td>
	</tr>
	<tr>
		<td>PR NO.</td>
		<td>:</td>
		<td colspan="4">
			<?php
			// $array=array($pr_no);
			// $count_values = array_count_values($array);
			// $pisah_pr=explode(",", $count_values);
			// $jml_pr=count($pisah_pr);
	$sql_stk2="select distinct pr_no from bps_serahterima where ho_no='$kd'";
	$tb_stk2=odbc_exec($koneksi_lp,$sql_stk2);	
	$t_pr='';$x=0;
	while($baris1=odbc_fetch_array($tb_stk2)){
		$x++;
		$pr_no=odbc_result($tb_stk2,"pr_no");
		$t_pr=$pr_no.",".$t_pr;
		}
	// 	$jh=strlen($t_pr);
	// 	echo substr($t_pr,0,-1);
			// for ($i=0; $i < $jml_pr; $i++) { 
			// 	echo $pisah_pr;
			// }
			echo substr($t_pr,0,-1);
			?>
		</td>
	</tr>
	<tr>
		<td>PO NO.</td>
		<td>:</td>
		<td colspan="4"><?php echo $po_no;?></td>
	</tr>
	<tr>
		<td>INV NO.</td>
		<td>:</td>
		<td colspan="4"><?php echo $inv_no;?></td>
	</tr>
</table>

<table width="780" border="1" style="border-collapse: collapse; font-size:10px; width:790px;">
	<tr>
		<th width="30" rowspan="2" align="center">No</th>
		<th width="300" rowspan="2" align="center">NAMA BARANG</th>
		<th width="40" rowspan="2" align="center">QTY</th>
		<th width="20" rowspan="2" align="center">SATUAN</th>
		<th height="22" colspan="2" align="center">STATUS</th>
		<th width="100" rowspan="2" align="center">KETERANGAN</th>
	</tr>
	<tr>
		<th height="22" width="30" align="center">OK</th>
		<th width="30" align="center">NOK</th>
	</tr>

	<?php
	$tb_stk1=odbc_exec($koneksi_lp,$sql_stk1);
	//echo $sql_stk1;
	$row=0;
	while(odbc_fetch_array($tb_stk1))
		{$row++;
			$part_no=odbc_result($tb_stk1,"part_no");
			$part_nm=odbc_result($tb_stk1,"part_nm");
			$part_dtl=odbc_result($tb_stk1,"part_dtl");
			$part_desc=odbc_result($tb_stk1,"part_desc");
			$tgl=date("Y-m-d",strtotime(odbc_result($tb_stk1,"tgl_terima")));
			$qty=odbc_result($tb_stk1,"qty");
			$uom=odbc_result($tb_stk1,"uom");
			?><tr>
				<td height="22" align="center"><?php echo $row;?></td>
				<td><?php echo $part_nm." ".$part_no." ".$part_dtl."".$part_desc;?></td>
				<td align="center"><?php echo $qty;?></td>
				<td align="center"><?php echo $uom;?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<?php
		}
		$fg=8-$row;

		if($row<8){
			$vzz=0;
			while($vzz<$fg){
				?>
				<tr class="odd gradeX">
					<td height="22" align="center" valign="middle" nowrap="nowrap"></td>
					<td align="center" valign="middle" nowrap="nowrap"></td>
					<td align="left" valign="middle" nowrap="nowrap"></td>
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
	</table>
	<table width="780" border="0" style="border-collapse: collapse; font-size:10px; width:790px;">
		<tr>
			<td></td>
		</tr>
	</table>
	<table width="780" border="1" style="border-collapse: collapse; font-size:10px; width:790px;">
		<tr>
			<td width="260" height="22" align="center" >DISERAHKAN OLEH</td>
			<td width="260" align="center">DITERIMA OLEH</td>
			<td width="260" align="center">DIKETAHUI</td>
		</tr>
		<tr>
			<td height="55" align="center" valign="bottom"><?php echo $pic_update;?></td>
			<td align="center" valign="bottom"><?php echo $pic_terima;?></td>
			<td align="center" valign="bottom">&nbsp;</td>
		</tr>
	</table>
<p>
<?php for ($i=0; $i<77 ; $i++) { 
	echo " - " ;
} ?>
	
</p>
<!-- halaman 2 -->
<?php
$ttd="<p><img src='..\..\img\logo_sami.png' width='80' height='50' alt='sami' /></p>";
$sql_stk1="
select a.inv_no,a.sect, a.pr_no, a.po_no, a.pic_lp, a.part_no, a.part_nm, a.part_dtl,
a.part_desc, a.pic_terima,a.tgl_terima,sum(a.qty) AS qty,a.uom,b.no_bc,b.tgl_bc,b.jns_bc
from bps_serahterima a left join bps_kedatangan b on a.inv_no=b.inv_no and a.no_ctrl=b.no_ctrl 
and a.po_no=b.po_no and a.pr_no=b.pr_no
where ho_no='$kd' 
group by a.sect,a.pr_no,a.po_no,a.pic_lp,a.part_no,a.part_nm,a.part_dtl,a.part_desc,a.pic_terima,a.tgl_terima,a.uom,a.inv_no,b.no_bc,b.tgl_bc,b.jns_bc";
$tb_stk1=odbc_exec($koneksi_lp,$sql_stk1);
// echo $sql_stk1;
$pr_no="";
while(odbc_fetch_array($tb_stk1))
{
	$sect=odbc_result($tb_stk1,"sect");
	$tgl=date("Y-m-d",strtotime(odbc_result($tb_stk1,"tgl_terima")));
	$pr_no=odbc_result($tb_stk1,"pr_no").",".$pr_no;
	$po_no=odbc_result($tb_stk1,"po_no");
	$pic_lp=odbc_result($tb_stk1,"pic_lp");
	$pic_terima=odbc_result($tb_stk1,"pic_terima");
	$bc_no=odbc_result($tb_stk1,"no_bc");
	$tgl_bc=odbc_result($tb_stk1,"tgl_bc");
	$inv_no=odbc_result($tb_stk1,"inv_no");
}
?>
<table width="781" border="0">
	<tr>
		<td width="95" class="sami">&nbsp;</td>
		<td width="554" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-size: 16px;"><em>PT. Semarang Autocomp Manufacturing Indonesia </em></td>
		<td width="118">&nbsp;</td>
	</tr>
</table>
<table width="781" border="0">
	<tr>
		<td width="75" align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 18px;"><u>BUKTI PENERIMAAN BARANG </u></td>
	</tr>
</table>

<table width="781" style="font-size:12px;">
	<tr>
		<td width="112">DEPT/SECTION</td>
		<td width="10">:</td>
		<td width="229"><?php echo $sect;?></td>
		<td width="112">BC NO. </td>
		<td width="10">:</td>
		<td width="112"><?= $bc_no ;?></td>
	</tr>
	<tr>
		<td>DATE</td>
		<td>:</td>
		<td><?php echo date("d F Y",strtotime($tgl));?></td>
		<td>BC DATE . </td>
		<td>:</td>
		<td><?php if($bc_no!=""){echo date("d-m-Y",strtotime($tgl_bc)); }  ?></td>
	</tr>
	<tr>
		<td>PR NO.</td>
		<td>:</td>
		<td colspan="4">
			<?php
			// $array=array($pr_no);
			// $count_values = array_count_values($array);
			// $pisah_pr=explode(",", $count_values);
			// $jml_pr=count($pisah_pr);
	$sql_stk2="select distinct pr_no from bps_serahterima where ho_no='$kd'";
	$tb_stk2=odbc_exec($koneksi_lp,$sql_stk2);	
	$t_pr='';$x=0;
	while($baris1=odbc_fetch_array($tb_stk2)){
		$x++;
		$pr_no=odbc_result($tb_stk2,"pr_no");
		$t_pr=$pr_no.",".$t_pr;
		}
	// 	$jh=strlen($t_pr);
	// 	echo substr($t_pr,0,-1);
			// for ($i=0; $i < $jml_pr; $i++) { 
			// 	echo $pisah_pr;
			// }
			echo substr($t_pr,0,-1);
			?>
		</td>
	</tr>
	<tr>
		<td>PO NO.</td>
		<td>:</td>
		<td colspan="4"><?php echo $po_no;?></td>
	</tr>
	<tr>
		<td>INV NO.</td>
		<td>:</td>
		<td colspan="4"><?php echo $inv_no;?></td>
	</tr>
</table>

<table width="780" border="1" style="border-collapse: collapse; font-size:10px; width:790px;">
	<tr>
		<th width="30" rowspan="2" align="center">No</th>
		<th width="300" rowspan="2" align="center">NAMA BARANG</th>
		<th width="40" rowspan="2" align="center">QTY</th>
		<th width="20" rowspan="2" align="center">SATUAN</th>
		<th height="22" colspan="2" align="center">STATUS</th>
		<th width="100" rowspan="2" align="center">KETERANGAN</th>
	</tr>
	<tr>
		<th height="22" width="30" align="center">OK</th>
		<th width="30" align="center">NOK</th>
	</tr>

	<?php
	$tb_stk1=odbc_exec($koneksi_lp,$sql_stk1);
	//echo $sql_stk1;
	$row=0;
	while(odbc_fetch_array($tb_stk1))
		{$row++;
			$part_no=odbc_result($tb_stk1,"part_no");
			$part_nm=odbc_result($tb_stk1,"part_nm");
			$part_dtl=odbc_result($tb_stk1,"part_dtl");
			$part_desc=odbc_result($tb_stk1,"part_desc");
			$tgl=date("Y-m-d",strtotime(odbc_result($tb_stk1,"tgl_terima")));
			$qty=odbc_result($tb_stk1,"qty");
			$uom=odbc_result($tb_stk1,"uom");
			?><tr>
				<td height="22" align="center"><?php echo $row;?></td>
				<td><?php echo $part_nm." ".$part_no." ".$part_dtl."".$part_desc;?></td>
				<td align="center"><?php echo $qty;?></td>
				<td align="center"><?php echo $uom;?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<?php
		}
		$fg=8-$row;

		if($row<8){
			$vzz=0;
			while($vzz<$fg){
				?>
				<tr class="odd gradeX">
					<td height="22" align="center" valign="middle" nowrap="nowrap"></td>
					<td align="center" valign="middle" nowrap="nowrap"></td>
					<td align="left" valign="middle" nowrap="nowrap"></td>
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
	</table>
	<table width="780" border="0" style="border-collapse: collapse; font-size:10px; width:790px;">
		<tr>
			<td></td>
		</tr>
	</table>
	<table width="780" border="1" style="border-collapse: collapse; font-size:10px; width:790px;">
		<tr>
			<td width="260" height="22" align="center" >DISERAHKAN OLEH</td>
			<td width="260" align="center">DITERIMA OLEH</td>
			<td width="260" align="center">DIKETAHUI</td>
		</tr>
		<tr>
			<td height="55" align="center" valign="bottom"><?php echo $pic_update;?></td>
			<td align="center" valign="bottom"><?php echo $pic_terima;?></td>
			<td align="center" valign="bottom">&nbsp;</td>
		</tr>
	</table>
	<p>
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
</p>
