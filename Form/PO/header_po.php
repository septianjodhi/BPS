<?php 
/*if ($lokasi=='JF') {
$jeparafac=" - JEPARA FACTORY";
$alamatfactory="Jl. Jepara Kudus KM 28 Sengon Bugel, Kecamatan Mayong";
$alamatfactory2="Jepara 59465 Jawa Tengah - Indonesia";
$alamatfactory3="6291-751-2101/ 0828-9109-2000	,Fax : 6291-751-2102";
}else{
$jeparafac="";
$alamatfactory="Jl. Walisongo Km 9,8 Kelurahan Tugu Rejo, Kecamatan Tugu";
$alamatfactory2="Semarang 50151 Jawa Tengah - Indonesia";
$alamatfactory3="62-24-866 5182	,Fax : 62-24-866 5178";
}

$qry_supp="select distinct a.kode_supp,c.SUPP_NAME,c.ALAMAT,c.kota,c.kode_pos,c.CP_HP,c.TELP,c.fax,c.EMAIL,c.CP_NAME,a.po_no,
convert(nvarchar(10), a.tgl_updt,23) as tgl_po,eta,a.pic_updt,a.ppn,a.term_of_payment from bps_podtl a
left join lp_supp c on a.kode_supp=c.supp_code
where a.po_no='$pono'";
$tb_qry_supp=odbc_exec($koneksi_lp,$qry_supp);
$kode_supp=odbc_result($tb_qry_supp,"kode_supp");

$cr_dok=odbc_exec($koneksi_lp,"SELECT jns_dok,no_dok from bps_kontrak_supp where kode_supp='$kode_supp' and getdate()<=tgl_berakhir");
	$gab_dok="";
	while($tb_dok=odbc_fetch_array($cr_dok)){
		$jns_dok=ucwords($tb_dok['jns_dok']);
		$no_dok=$tb_dok['no_dok'];
		$dok=$jns_dok." ".$no_dok;
		$gab_dok=$gab_dok.",".$dok;
	}
	$pch_gab=explode(",", $gab_dok);

$cp=odbc_result($tb_qry_supp,"CP_HP");
$tlpn=odbc_result($tb_qry_supp,"TELP");
	if($cp!='' and $tlpn!=''){$cpsupp=$tlpn." / ".$cp;}else{$cpsupp= $tlpn.$cp;}
*/

$header='
<table width="790" border="0">
	<tr>
		<td width="10" class="sami">SAMI</td>
		<td align="center" width="650" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-size: 18px;">
			PT. SEMARANG AUTOCOMP MANUFACTURING INDONESIA 
		</td>
		<td rowspan="2">
			<img src="../images/confidential.jpg" height="60" width="80">
		</td>
	</tr>
	<tr>
		<td width="10" class="sami">&nbsp;</td>
		<td align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-style: italic;">Wiring Harness Manufacturer</td>
	</tr>
	<tr>
		<td colspan="3" align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; text-align: center;">
			Office / Factory: 
		</td>
	</tr>
	<tr>
		<td colspan="3" align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; text-align: center;">
			
		</td>
	</tr>
	<tr>
		<td colspan="3" align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; text-align: center;">
			Phone : 
	</td>
</tr>
</table>
<hr width="790" align="center">
<table width="790" border="0">
	<tr>
		<td width="390" valign="top" align="center" colspan="3" rowspan="2"><h2><strong>PURCHASE ORDER </strong></h2></td>
		<td width="2">&nbsp;</td>
		<td width="110">No. Order </td>
		<td>:</td>
		<td width="280"><h3></h3></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>Tanggal Order </td>
		<td>:</td>
		<td></td>
	</tr>
	<tr>
		<td valign="top" align="left" colspan="3"><h3><strong></strong></h3></td>
		<td>&nbsp;</td>
		<td>ETA Request </td>
		<td>:</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3"></td>
		<td>&nbsp;</td>
		<td>Document No.</td>
		<td>:</td>
		<td></td>
	</tr>
	<tr>
		<td width="50">Telp</td>
		<td>:</td>
		<td width="340">
			
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
	</tr>
	<tr>
		<td>Fax</td>
		<td>:</td>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td></td>
	</tr>
	<tr>
		<td>Attn</td>
		<td>:</td>
		<td></td>
		<td>&nbsp;</td>
		<td colspan="3"><em>Term Of Payment </em></td>
	</tr>
	<tr>
		<td valign="top">Email</td>
		<td valign="top">:</td>
		<td valign="top"></td>
		<td>&nbsp;</td>
		<td colspan="3"><em>This P/O number and our requisition number must appear on all correspondence, invoice shipping papers.</em></td>
	</tr>
</table>';
?>