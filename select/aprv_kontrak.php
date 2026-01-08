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
		<td width="118"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-style: italic;">Wiring Harness Manufacturer</td>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%" border="0">
	<tr>
		<td align="center" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 20px;">DOKUMEN KONTRAK/ PERJANJIAN </td>
	</tr>
</table>
<?php
$ttd="<p><img src='..\img\logo_sami.png' width='80' height='50' alt='sami' /></p>";
$sql_stk1="SELECT *  from bps_kontrak_supp a left join lp_supp b on a.kode_supp=b.supp_code where no_dok='$kd' ";
$tb_stk1=odbc_exec($koneksi_lp,$sql_stk1);

$sect=odbc_result($tb_stk1,"sect");
$docno=odbc_result($tb_stk1,"doc_no");
$doc_date=odbc_result($tb_stk1,"tgl_mulai");
$pic=odbc_result($tb_stk1,"pic_updt");
$est=odbc_result($tb_stk1,"tgl_berakhir");

?>
<br>
<hr width="100%">
<table width="100%" >
	<tr>
		<td width="150">DATE</td>
		<td width="10">:</td>
		<td width="150"><?php echo date("d F Y",strtotime($doc_date));?></td>
	</tr>
	<tr>
		<td>NO DOC </td>
		<td>:</td>
		<td><?php echo $kd;?></td>
	</tr>
	<tr>
		<td>SUPPLIER</td>
		<td>:</td>
		<td><?= odbc_result($tb_stk1,"SUPP_NAME");?></td>
	</tr>
	<tr>
		<td>SUPPLIER CODE</td>
		<td>:</td>
		<td><?= odbc_result($tb_stk1,"kode_supp");?></td>
	</tr>
	<tr>
		<td>KATEGORI DOKUMEN</td>
		<td>:</td>
		<td><?= odbc_result($tb_stk1,"jns_kontrak");?></td>
	</tr>
</tr>
<tr>
	<td>JENIS DOKUMEN</td>
	<td>:</td>
	<td><?= odbc_result($tb_stk1,"jns_dok");?></td>
</tr>
<tr>
	<td>LOKASI PENYIMPANAN DOKUMEN</td>
	<td>:</td>
	<td><?= odbc_result($tb_stk1,"lok_simpan");?></td>
</tr>
<tr>
	<td>PIC</td>
	<td>:</td>
	<td><?php echo $pic;?></td>
</tr>
<tr>
	<td>EXPIRED DOKUMEN</td>
	<td>:</td>
	<td><?= date("d F Y",strtotime(odbc_result($tb_stk1,"tgl_berakhir")));?></td>
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

			$update="UPDATE bps_approve set pic_act='$pic_updt',tgl_updt=getdate(),status='CLOSE' where no_doc='$kd' and jns_doc='$jnsdok' and status is null";
			$squpdtapp=odbc_exec($koneksi_lp,$update);

			$update2="UPDATE bps_kontrak_supp set status_ver=1,pic_ver='$pic_updt',tgl_ver=getdate() where no_dok='$kd' ";
			$squpdtapp2=odbc_exec($koneksi_lp,$update2);
			// $finish=odbc_exec($koneksi_lp,"UPDATE bps_approve set status='FINISH' where no_doc='$kd' and jns_doc='$jnsdok'");

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
			$squpdtapp=odbc_exec($koneksi_lp,"UPDATE bps_approve set pic_act=NULL,tgl_updt=NULL,status=NULL where no_doc='$kd' and jns_doc='$jnsdok' and no_aprv>2");
			$UNfinish=odbc_exec($koneksi_lp,"UPDATE bps_approve set pic_act=pic_plan,status='Close' where no_doc='$kd' and jns_doc='$jnsdok' and no_aprv<3");
			$update2=odbc_exec($koneksi_lp,"UPDATE bps_kontrak_supp set status_ver=0,pic_ver=NULL,tgl_ver=NULL where no_dok='$kd' ");
		}else{
			$squpdtapp=odbc_exec($koneksi_lp,"UPDATE bps_approve set pic_act=NULL,tgl_updt=NULL,status=NULL where no_doc='$kd' and jns_doc='$jnsdok' and no_aprv<4");
		}
//echo $squpdtapp;

		echo "<script>
		alert('UNAPPROVED NO Dokumen $kd');

		window.close();

		</script>";
	}
	?>
	<br />

	<!--===============================================================================================================-->
