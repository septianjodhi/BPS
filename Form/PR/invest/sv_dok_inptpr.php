<?php
include "../../../koneksi.php";
$sect=$_POST["s"];
$idtmp=$_POST["kp"];
$pic=$_POST["p"];
$rmk_pr=$_POST["rmkpr"];
$pr_no=$_POST["nopr"];
$qry_adpr="insert into bps_pr(pr_no, remark, no_ctrl, pr_date, qty, price, curr, term, periode, sect, cccode, pic_updt, tgl_updt, equipment_no,
		qty_equipment,req_date)";
		
		$cr_pr="select pr_no as pr_no,'$rmk_pr' as remark,no_ctrl,pr_date,qty_act as qty,price_tot as price,curr,term,periode,
		'$sect' as sect,cccode,'$pic' as pic_updt,getdate() as tgl_updt,equipment,
		qty_equipment,req_date from bps_tmpPR where id_tmp_pr='$idtmp' ";
		// echo $qry_adpr;
		$tb_adpr=odbc_exec($koneksi_lp,$qry_adpr." ".$cr_pr);

		$sql_amount="select distinct pr_no,sum(dbo.lp_konprc(term,'IDR',curr,qty_tot*price_tot)) as idr,sum(dbo.lp_konprc(term,'USD',curr,qty_tot*price_tot)) as dolar,sum(qty_add) as qty_add,sum(price_add) as prc_add from bps_tmppr where pr_no='$pr_no' group by pr_no";
		$tb_amount=odbc_exec($koneksi_lp,$sql_amount);
		$amoun_USD=0;
		$amoun_IDR=0;
		$qty_add="";$prc_add="";
		while($bar_moun=odbc_fetch_array($tb_amount))
		{
			$amoun_USD=odbc_result($tb_amount,"dolar");
			$amoun_IDR=odbc_result($tb_amount,"idr");
			$qty_add=odbc_result($tb_amount,"qty_add");
			$prc_add=odbc_result($tb_amount,"prc_add");
		}

		$pchsec=explode("-",$sect);
		$dept=$pchsec[0];
		$qry_delaprv="delete from bps_approve where jns_doc in('PR') and no_doc='$pr_no'";
		$tb_delaprv=odbc_exec($koneksi_lp,$qry_delaprv);
		$qry_adaprv="insert into bps_approve(pic_plan, email_plan,no_doc,tgl_prepaire, jns_doc, sect,
		initial,approve,no_aprv)
		SELECT nama as pic_plan,email as email_plan,'$pr_no' as no_doc,getdate() as tgl_prepaire,
		'PR' as jns_doc,sect,initial,approve,no_aprv  FROM bps_setApprove where status_akun='aktif' 
		and jns_dok in('PR') and (sect='$sect' or sect='$dept-ALL' or (sect='SAMI-ALL' AND 
		(max_amount='0' or (min_amount<='$amoun_IDR' and max_amount>'$amoun_IDR'))))";

		$tb_delaprv=odbc_exec($koneksi_lp,$qry_adaprv);

		//$tb_creatpr=odbc_exec($koneksi_lp,$cr_pr);
		/*if($amoun_USD>0){
			echo "<script>alert('DATA BERHASIL DISIMPAN DENGAN NO PR $pr_no. AMOUNT ORDER = $total_bayar DAN AMOUNT PLAN = $amount_plan');</script>";
		}*/


?>