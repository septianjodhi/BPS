<?php
include "../../../koneksi.php";
$sect=$_POST["s"];
$buat=$_POST["c"];
$pic=$_POST["p"];
$pilih=$_POST["k"];
$pisah=explode("|", $pilih) ;
		$no_ctrl_p=$pisah[0];
		$p_no=$pisah[1];
		$no_ctrl=$pisah[3];
		$expired=$pisah[4];
		$car=$pisah[5];
		$qty_plan=$pisah[6];
		$price_plan=$pisah[7];
		$term_p=$pisah[8];

$bln=date("Ym",strtotime($buat));
$pr_date=date("Y-m-d",strtotime($buat));
	$dept_code=odbc_exec($koneksi_lp,"select dept_code from bps_dept where sect='$sect' ");
	$dpt_cd=odbc_result($dept_code,"dept_code");

	if($dpt_cd=='')
	{
		$dept_cd='0000';
	}else{
		$dept_cd=$dpt_cd;
	}
	$nomor_pr='0-0-0-0';
	$qry_nopr="select top 1 isnull(pr_no,'0-0-0-0') as pr_no from bps_pr where sect='$sect' and convert(nvarchar(6),pr_date,112)='$bln' and equipment_no is not null order by tgl_updt desc";
	$tb_nopr=odbc_exec($koneksi_lp,$qry_nopr);
	while($baris1=odbc_fetch_array($tb_nopr)){
	$nomor_pr=odbc_result($tb_nopr,"pr_no");
	}
	$pcpr=explode("-",$nomor_pr);
	$nopr=$pcpr[3]+1;
	$nopr3=substr('000'.$nopr,-3);
	$idtmp=$pic."-".date("Ymd-His",strtotime($buat));
	$pr_no=$sect."-".date("ym",strtotime($buat))."-".$nopr3."-INVEST";
	
	$qry_cekbud="select qty*dbo.lp_konprc(term,'IDR','USD',price)[amount],
(select sum(qty_act*dbo.lp_konprc(term,'IDR',curr,price_tot))[amtpr] from bps_tmpPR where term='$term_p' and ket_temp='INVEST' and equipment='$no_ctrl' )[realisasi] FROM bps_budget_invest WHERE term='$term_p' and no_ctrl='$no_ctrl'";
	$tb_cekbud=odbc_exec($koneksi_lp,$qry_cekbud);
	$totbud=odbc_result($tb_cekbud,"amount");
	$totpr=odbc_result($tb_cekbud,"realisasi");
	if($totpr==""){
		$totpr=0;
	}
		$sisabud=$totbud-$totpr;
	

	$arrtkid=array(
	"qry"=>$qry_cekbud,
	"totalbudget"=>$totbud,
	"totalpr"=>$totpr,
	"sisabudget"=>$sisabud,
	"kode_departement"=>$dept_cd,
	"nopr"=>$pr_no, 
         );
$response["list"]=array($arrtkid);
echo json_encode($response);
//echo $qry_nopr;
?>