<?php
//"s":sect,"c":wkt,"p":pic,"no":pertama,"k":kola,"kddep":kd_dept,"nopr":noprinv,"qty":q_ord,"tgpr":tg_pr,"tgeta":tg_eta,"rmkpr":rmk_pr

include "../../../koneksi.php";
$sect= $_POST["s"];
$pic=$_POST["p"];
$updt=date("Y-m-d H:i:s",strtotime($_POST["c"]));
$pr_date=date("Y-m-d",strtotime($_POST["tgpr"]));
$bln=date("Ym",strtotime($_POST["tgpr"]));
$pr_no=$_POST["nopr"];
$dept_cd=$_POST["kddep"];
$pilih=$_POST["k"];
$qty=$_POST["qty"];
//$set_qty=$_POST["qty_s"];

$idtmp=$pic."-".date("Ymd-His",strtotime($_POST["c"]));
$req_date=$_POST["tgeta"];
	//$qty_cip=$_POST["qty_cip"];
	//$amount_plan=$_POST["amount"];
	//$rmk_pr=strtoupper($_POST["rmk_pr"]);
	/*$plh=$_POST['plh'] ;
	$jml=count($plh);*/

	$pisah=explode("|", $pilih) ;
		$no_ctrl_p=$pisah[0];
		$p_no=$pisah[1];
		$no_ctrl=$pisah[3];
		$expired=$pisah[4];
		$car=$pisah[5];
		$qty_plan=$pisah[6];
		$price_plan=$pisah[7];
		$term_p=$pisah[8];

		$cr_quo="select top 1 kode_supp,No_Quo,price from bps_Quotation where lp_rekom='YES' and 
		part_no='$p_no' and Exp_Quo>='$req_date' order by tgl_updt desc";
		$tb_cr_quo=odbc_exec($koneksi_lp,$cr_quo);
		$supkod=odbc_result($tb_cr_quo, "kode_supp");
		$noquo=odbc_result($tb_cr_quo, "No_Quo");
		$price_quo=odbc_result($tb_cr_quo, "price");

		//$amount=$price_quo*$set_qty*$qty;
		$amount=$price_quo*$qty;
		$qry_cv="select top 1 * FROM LP_CV where CARLINE='$car' and term='$term_p'  order by CV_CODE asc ";
		$cr_cccode=odbc_exec($koneksi_lp, $qry_cv) ;
		$cvcode=odbc_result($cr_cccode, "CV_CODE");
	

		$q_update2="insert into bps_tmpPR (id_tmp_pr,periode,no_ctrl,part_no,part_nm,part_dtl,uom,qty_plan,curr,price_plan,exp_pr,penawaran,price_quo,qty_tot,price_tot,amount,pic_updt,tgl_updt,pr_date,pr_no,term,kode_supp,no_quo,cccode,lp,qty_act,phase,account,carline_code,dept_code,req_date,equipment,ket_temp,qty_equipment) ";

		$q_update2val="select top 1 '$idtmp'[id_tmp_pr],periode,no_ctrl_bud[no_ctrl],part_no,part_nm,part_dtl,uom,QTY[qty_plan],curr,price[price_plan],expired[exp_pr],'YES'[penawaran],'$price_quo'[price_quo],'$qty'[qty_tot],'$price_quo'[price_tot],'$amount'[amount],'$pic'[pic_updt],'$updt'[tgl_updt],'$pr_date'[pr_date],'$pr_no'[pr_no],term,'$supkod'[kode_supp],'$noquo'[no_quo],'$cvcode'[cccode],lp,'$qty'[qty_act],'INVEST'[phase],'0'[account],'$car'[carline_code],'$dept_cd'[dept_code],'$req_date'[req_date],no_ctrl[equipment],'INVEST'[ket_temp],qty[qty_equipment] from bps_v_dtlinvest where no_ctrl_bud='$no_ctrl_p'";

		// echo $q_update2." ".$q_update2val;
	$grpqry=$q_update2." ".$q_update2val;
	$tb_part=odbc_exec($koneksi_lp,$grpqry);
$arrtkid=array(
	"dipilih"=>$pilih,
	"qry_quo"=>$cr_quo,
	"qry_cv"=>$qry_cv,
	"insert"=>$q_update2, 
	"cari_bud"=>$q_update2val,
	"qryindtl"=>$grpqry,
	"kodepr"=>$idtmp
         );
$response["list"]=array($arrtkid);
echo json_encode($response);

?>