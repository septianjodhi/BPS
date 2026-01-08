<?php
error_reporting(0);
session_start();

include "../koneksi.php";
$periode=date("d-m-Y H:i:s");
$nomor=$_GET['nomor'];
$pono=$_GET['po_no'];
$supp_code=$_GET['supp_code'];
//-----------------------Kode program untuk mencetak halaman----------------------//
$nama_dokumen='PO NO = '.$pono; //Beri nama file PDF hasil.

include("../mpdf57/mpdf.php");
$mpdf=new mPDF('utf-8', 'A4'); // Create new mPDF Document
$mpdf->setFooter("NB : SETELAH TERIMA PO, MOHON KOLOM KUNING DIISI DAN DIKIRIM KEMBALI KE PT SAMI.               Halaman {PAGENO} dari {nb}");

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
<table width="790" border="0">
	<tr>
		<td width="10" class="sami">SAMI</td>
		<td align="center" width="600" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-size: 18px;">PT. SEMARANG AUTOCOMP MANUFACTURING INDONESIA</td>
		<td rowspan="2">
			<img src="../images/confidential.jpg" height="60" width="80">
		</td>
	</tr>
	<tr>
		<td width="10" class="sami">&nbsp;</td>
		<td align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-style: italic;">Wiring Harness Manufacturer</td>
	</tr>
	<tr>
		<td colspan="3" align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; text-align: center;">Office / Factory: Jl. Walisongo Km 9,8 Kelurahan Tugu Rejo, Kecamatan Tugu</td>
	</tr>
	<tr>
		<td colspan="3" align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; text-align: center;">Semarang 50151 Jawa Tengah - Indonesia</td>
	</tr>
	<tr>
		<td colspan="3" align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; text-align: center;">Phone : 62-24-866 5182	,Fax : 62-24-866 5178</td>
	</tr>
</table>
<hr width="790" align="center">


<?php
//$qry_supp="select distinct a.kode_supp,c.SUPP_NAME,c.ALAMAT,c.kota,c.kode_pos,c.TELP,c.fax,c.EMAIL,c.CP_NAME,a.po_no,a.tgl_updt as tgl_po,convert(nvarchar,DATEADD(DD,14,a.tgl_updt),23) as esti from bps_podtl a inner join lp_supp c on a.kode_supp=c.supp_code where a.po_no='$pono'";
$qry_supp="select distinct a.kode_supp,c.SUPP_NAME,c.ALAMAT,c.kota,c.kode_pos,c.CP_HP,c.TELP,c.fax,c.EMAIL,c.CP_NAME,a.po_no,a.tgl_updt as tgl_po,eta,a.pic_updt from bps_podtl a inner join lp_supp c on a.kode_supp=c.supp_code where a.po_no='$pono'";
$tb_qry_supp=odbc_exec($koneksi_lp,$qry_supp);
?>

<table width="790" border="0">
	<tr>
		<td width="390" valign="top" align="center" colspan="3" rowspan="2"><h2><strong>PURCHASE ORDER </strong></h2></td>
		<td width="2">&nbsp;</td>
		<td width="110">No. Order </td>
		<td>:</td>
		<td width="280"><h3><?php echo $pono; ?></h3></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>Tanggal Order </td>
		<td>:</td>
		<td><?php echo date("d F Y",strtotime(odbc_result($tb_qry_supp,"tgl_po"))); ?></td>
	</tr>
	<tr>
		<td valign="top" align="left" colspan="3"><h3><strong><?php echo odbc_result($tb_qry_supp,"SUPP_NAME"); ?></strong></h3></td>
		<td>&nbsp;</td>
		<td>ETA Request </td>
		<td>:</td>
		<td><?php echo date("d F Y",strtotime(odbc_result($tb_qry_supp,"eta"))); ?></td>
	</tr>
	<tr>
		<td colspan="3"><?php echo ucwords(strtolower(odbc_result($tb_qry_supp,"alamat")))." ".odbc_result($tb_qry_supp,"kota")." ".odbc_result($tb_qry_supp,"kode_pos"); ?></td>
		<td>&nbsp;</td>
		<td colspan="3"><em>Term Of Payment 1 Month After Invoice  Received</em></td>
	</tr>
	<tr>
		<td width="50">Telp</td>
		<td>:</td>
		<td width="340">
			<?php
			$cp=odbc_result($tb_qry_supp,"CP_HP");
			$tlpn=odbc_result($tb_qry_supp,"TELP");
			if($cp!='' and $tlpn!=''){echo $tlpn." / ".$cp;}else{echo $tlpn.$cp;}?></td>
			<td>&nbsp;</td>
			<td colspan="3" rowspan="2"><em>This P/O number and our requisition number must appear on all correspondence, invoice shipping papers.</em></td>
		</tr>
		<tr>
			<td>Fax</td>
			<td>:</td>
			<td><?php echo odbc_result($tb_qry_supp,"fax");?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Attn</td>
			<td>:</td>
			<td><?php echo odbc_result($tb_qry_supp,"cp_name");?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>:</td>
			<td><?php echo strtolower(odbc_result($tb_qry_supp,"email"));?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>

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
			$dtl_po="select distinct pr_no,part_no,part_nm,part_dtl,part_desc,ppn,pph,sum(qty) as qty,price,curr,lp,uom 
			from bps_podtl where po_no='$pono' group by pr_no,part_no,part_nm,part_dtl,part_desc,ppn,pph,price,curr,lp,uom";
//$dtl_po="select bps_podtl.*,(select ppn from lp_supp where supp_code=bps_podtl.kode_supp) as ppn from bps_podtl where po_no='$pono'";
			$tb_dtlpo=odbc_exec($koneksi_lp,$dtl_po);
			$xy=0;$amn_pph=0;
			while(odbc_fetch_array($tb_dtlpo)){

				$qt=odbc_result($tb_dtlpo,"qty");
				$curr=odbc_result($tb_dtlpo,"curr");
				$t_qt=$t_qt+$qt;
				$uo=odbc_result($tb_dtlpo,"uom");
	// $harga=odbc_result($tb_dtlpo,"price");
				$prc=odbc_result($tb_dtlpo,"price");
				
	// IF($curr=='IDR'){$prc=round($harga);}else{$prc=$harga;}
				$lp=odbc_result($tb_dtlpo,"lp");
				$pph=odbc_result($tb_dtlpo,"pph");
				$Amo=$prc*$qt;
				$amnpph=floor($pph*$Amo/100);
				$amn_pph=$amn_pph+$amnpph;
				$t_Amo=$t_Amo+$Amo;
	// if($lp!='LD'){$ppn=floor($t_Amo/odbc_result($tb_dtlpo,"ppn"));}else{$ppn=0;}
				$ppn=floor($t_Amo/odbc_result($tb_dtlpo,"ppn"));
				if($curr=='IDR'){$total_bayar=floor($t_Amo) ;}else{$total_bayar=$t_Amo;}
				$GT=floor($ppn)+$total_bayar-floor($amn_pph);
				
				$xy++
				?>
				<tr class="odd gradeX">
					<td height="19" align="center" valign="middle" nowrap="nowrap"><?php echo $xy;?></td>
					<td width="100" align="center" valign="middle" nowrap="nowrap"><?php echo odbc_result($tb_dtlpo,"part_no");?></td>
					<td align="left" valign="middle" nowrap="nowrap"><?php echo odbc_result($tb_dtlpo,"pr_no");?></td>
					<td align="left" valign="middle" nowrap="wrap"><?php echo odbc_result($tb_dtlpo,"part_nm")." ".odbc_result($tb_dtlpo,"part_dtl")." ".odbc_result($tb_dtlpo,"part_desc");?></td>
					<td align="center" valign="middle" nowrap="nowrap"><?php echo number_format(sprintf("%.2f",$qt),0);if($uo<>"0"){ echo " ".$uo;}?></td>
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
				<td align="center" valign="middle"><?php echo $curr." ".number_format(sprintf("%.2f",$t_Amo),2,'.',',');?></td>
			</tr>
			
			<tr>
				<td colspan="4" align="Center" height="21">PPN 10% </td>
				<td align="center" valign="middle"></td>
				<td align="center" valign="middle"></td>
				<td align="center" valign="middle"><?php echo $curr." ".number_format(sprintf("%.2f",floor($ppn)),2,'.',',');?></td>
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
					<?php echo $curr." ".number_format(sprintf("%.2f",$GT),2,'.',',');?></td>
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
					PT SEMARANG AUTOCOMP MANUFACTURING INDONESIA
					<br>Jl. Walisongo Km 9,8 Tugu Rejo</br>
					<br>Kecamatan Tugu, Semarang 50151 Jawa Tengah</br>
					<br>NPWP No.        : 01.869.469.5-055.000</br>
					<br>Contact Person  : <?php echo odbc_result($tb_qry_supp,"pic_updt"); ?></br>

				</td>
				<td width="440">
					<table width="440" height="296" border="0">
						<tr>
							<td align="center" valign="top" >1</td>
							<td>Delivery ETA PT SAMI : Senin,Rabu,Kamis 07.30 s/d 15 .00 WIB. </td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Jam istirahat PT SAMI : 10.10 s/d 10.25 WIB &amp; 12.40 s/d 13.20 WIB. ( <strong>Pada waktu istirahat, tidak ada proses penerimaan barang </strong>) </td>
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
	$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	ob_end_clean();
	//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
	$mpdf->WriteHTML(utf8_encode($html));
	$mpdf->Output($nama_dokumen.".pdf" ,'I');

	
	exit;
	//-----------------------Kode program untuk mencetak halaman----------------------//
	?>