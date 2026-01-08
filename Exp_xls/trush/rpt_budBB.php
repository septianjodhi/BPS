<?php
/*******************************************
    Export Excel dengan PHPExcel
******************************************/
session_start();

include "../koneksi.php";
include "PHPExcel.php";

date_default_timezone_set("Asia/Jakarta");
$excelku = new PHPExcel();
$sect=$_GET['s'];
$term=$_GET['t'];
$periode=$_GET['p'];
// Set properties
$excelku->getProperties()->setCreator("BPS SAMI")
                         ->setLastModifiedBy("BPS SAMI");

$style_col = array(
  'font' => array('bold' => true), // Set font nya jadi bold
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP // Set text jadi di tengah secara vertical (middle)
  ),
  'borders' => array(
    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
  )
);
// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = array(
  'alignment' => array(
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
  ),
  'borders' => array(
    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
  )
);



// Set lebar kolom
$excelku->getActiveSheet()->getColumnDimension('A')->setWidth(15);//SECTION
$excelku->getActiveSheet()->getColumnDimension('B')->setWidth(20);//no_ctrl
$excelku->getActiveSheet()->getColumnDimension('C')->setWidth(25);//PART  NAME
$excelku->getActiveSheet()->getColumnDimension('D')->setWidth(35);//DETAIL PART
$excelku->getActiveSheet()->getColumnDimension('E')->setWidth(35);//ACC NO.
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(12);//ACCOUNT DESCRIPTION
$excelku->getActiveSheet()->getColumnDimension('G')->setWidth(40);//CATEGORY
$excelku->getActiveSheet()->getColumnDimension('H')->setWidth(13);//COST CENTER
$excelku->getActiveSheet()->getColumnDimension('I')->setWidth(20);//CARLINE
$excelku->getActiveSheet()->getColumnDimension('J')->setWidth(20);//CAR MAKER
$excelku->getActiveSheet()->getColumnDimension('K')->setWidth(20);//UOM
$excelku->getActiveSheet()->getColumnDimension('L')->setWidth(20);//STP
$excelku->getActiveSheet()->getColumnDimension('M')->setWidth(20);//STP
$excelku->getActiveSheet()->getColumnDimension('N')->setWidth(20);//STP
$excelku->getActiveSheet()->getColumnDimension('O')->setWidth(20);//ACTUAL
$excelku->getActiveSheet()->getColumnDimension('P')->setWidth(20);//ACTUAL
$excelku->getActiveSheet()->getColumnDimension('Q')->setWidth(20);//ACTUAL
$excelku->getActiveSheet()->getColumnDimension('R')->setWidth(20);//DIFFERENCE
$excelku->getActiveSheet()->getColumnDimension('S')->setWidth(20);//DIFFERENCE
$excelku->getActiveSheet()->getColumnDimension('T')->setWidth(20);//DIFFERENCE
$excelku->getActiveSheet()->getColumnDimension('U')->setWidth(20);//REASON
$excelku->getActiveSheet()->getColumnDimension('V')->setWidth(30);//ACTION


// Set text center untuk kolom 
$excelku->getActiveSheet()->getStyle('A7:V9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Mergecell, menyatukan beberapa kolom

$excelku->getActiveSheet()->mergeCells('A7:B7');
$excelku->getActiveSheet()->mergeCells('A8:A9');
$excelku->getActiveSheet()->mergeCells('B8:B9');
$excelku->getActiveSheet()->mergeCells('C7:C9');
$excelku->getActiveSheet()->mergeCells('D7:D9');
$excelku->getActiveSheet()->mergeCells('E7:E9');
$excelku->getActiveSheet()->mergeCells('F7:F9');
$excelku->getActiveSheet()->mergeCells('G7:G9');
$excelku->getActiveSheet()->mergeCells('H7:H9');
$excelku->getActiveSheet()->mergeCells('I7:J7');
$excelku->getActiveSheet()->mergeCells('K7:L7');
$excelku->getActiveSheet()->mergeCells('N7:P7');
$excelku->getActiveSheet()->mergeCells('Q7:S7');
$excelku->getActiveSheet()->mergeCells('V7:V9');



//$excelku->getActiveSheet()->mergeCells('A2:G2');

// Buat Kolom judul tabel
$SI = $excelku->setActiveSheetIndex(0);
$Jdl='Actual_Budget_Exp_&_Additional';
$Jdl2='Actual_Budget_Exp_&_Add';

$SI->setCellValue('A1', 'PT. Semarang Autocomp Manufacturing Indonesia'); //0
$SI->setCellValue('A2', $Jdl); //0
$SI->setCellValue('A3', 'PERIOD (月度):'.$periode); //0
$SI->setCellValue('A4', 'DEPT (部署名):'.$sect); //0
$SI->setCellValue('A6', 'Download Time= '.date("Y-m-d H:i:s")); //0
$SI->setCellValue('A7', 'BUDGET REF'); //0
$SI->setCellValue('A8', 'SECT'); //0
$SI->setCellValue('B8', 'No. Control'); //15;
$SI->setCellValue('C7', 'PART_NO'); //1;
$SI->setCellValue('D7', 'PART  NAME'); //2;
$SI->setCellValue('E7', 'DETAIL PART'); //3;
$SI->setCellValue('F7', 'ACC NO.'); //4;
$SI->setCellValue('G7', 'ACCOUNT DESCRIPTION'); //5;
$SI->setCellValue('H7', 'QTY 数量'); //6;
$SI->setCellValue('I7', 'PLAN'); //7;
$SI->setCellValue('I8', 'PRICE 単価'); //7;
$SI->setCellValue('J8', 'AMOUNT 金額'); //9;
$SI->setCellValue('I9', 'RP'); //7;
$SI->setCellValue('J9', 'RP'); //9;
$SI->setCellValue('K7', 'FORECAST'); //7;
$SI->setCellValue('K8', 'PRICE 単価'); //7;
$SI->setCellValue('L8', 'AMOUNT 金額'); //9;
$SI->setCellValue('K9', 'RP'); //7;
$SI->setCellValue('L9', 'RP'); //9;
$SI->setCellValue('M7', 'DIFFERENCE'); //7;
$SI->setCellValue('M8', '(Plan-Forcase)'); //7;
$SI->setCellValue('M9', 'RP'); //7;
$SI->setCellValue('N7', 'ACTUAL STP'); //7;
$SI->setCellValue('N8', 'QTY 数量'); //6;
$SI->setCellValue('O8', 'PRICE 単価'); //7;
$SI->setCellValue('P8', 'AMOUNT 金額'); //9;
$SI->setCellValue('O9', 'RP'); //7;
$SI->setCellValue('P9', 'RP'); //9;
$SI->setCellValue('Q7', 'ACTUAL ADD'); //7;
$SI->setCellValue('Q8', 'QTY 数量'); //6;
$SI->setCellValue('R8', 'PRICE 単価'); //7;
$SI->setCellValue('S8', 'AMOUNT 金額'); //9;
$SI->setCellValue('R9', 'RP'); //7;
$SI->setCellValue('S9', 'RP'); //9;
$SI->setCellValue('T7', 'TOTAL ACTUAL'); //7;
$SI->setCellValue('T8', '(STP+ADD)'); //7;
$SI->setCellValue('T9', 'RP'); //7;
$SI->setCellValue('U7', 'DIFFERENCE'); //7;
$SI->setCellValue('U8', '(Plan-Actual)'); //7;
$SI->setCellValue('U9', 'RP'); //7;
$SI->setCellValue('V7', 'PR NO'); //14;


$Qry="select distinct  a.term,a.periode,a.sect,a.no_ctrl,a.part_no,a.part_nm,a.part_dtl,a.part_desc,a.account,c.ACC_DESC,
a.qty as qty_plan,isnull(sum(b.qty_act),0) as qty_act, a.uom,a.curr,dbo.lp_konprc(a.term,'IDR',a.curr,a.price) as price_plan,
dbo.lp_konprc(a.term,'IDR',a.curr,a.price*sum(a.qty)) as amn_p , isnull(dbo.lp_konprc (b.term,'IDR',b.curr,b.price_tot),0) as price_act,
dbo.lp_konprc (b.term,'IDR',b.curr,b.price_tot*sum(qty_act)) as amn_a,isnull(dbo.lp_konprc (b.term,'IDR',b.curr,price_quo),0) as price_quo,
qty_add,price_add from bps_budget a 
full join bps_tmpPR b on a.periode=b.periode and a.no_ctrl=b.no_ctrl
full join LP_ACC c on a.account=c.ACC_NO 
where a.sect='$sect' and a.periode='$periode' and a.term='$term'
group by a.term,a.periode,a.sect,a.no_ctrl,a.part_no,a.part_nm,a.part_dtl,a.part_desc,a.account,c.ACC_DESC,a.uom,a.curr,
a.price,price_tot,a.qty,b.curr,b.term,price_quo,qty_add,price_add
union
select distinct  a.term,a.periode,a.sect,a.no_ctrl,a.part_no,a.part_nm,a.part_dtl,a.part_desc,a.account,c.ACC_DESC,
a.qty as qty_plan,isnull(sum(b.qty_act),0) as qty_act, a.uom,a.curr,dbo.lp_konprc(a.term,'IDR',a.curr,a.price) as price_plan,
dbo.lp_konprc(a.term,'IDR',a.curr,a.price*sum(a.qty)) as amn_p , isnull(dbo.lp_konprc (b.term,'IDR',b.curr,price_tot),0) as price_act,
dbo.lp_konprc (b.term,'IDR',b.curr,isnull(price_tot*sum(qty_act),0)) as amn_a,isnull(dbo.lp_konprc (b.term,'IDR',b.curr,price_quo),0) as price_quo,
qty_add,price_add from bps_budget_add a 
full join bps_tmpPR b on a.periode=b.periode and a.no_ctrl=b.no_ctrl
full join LP_ACC c on a.account=c.ACC_NO 
where a.sect='$sect' and a.periode='$periode' and a.term='$term' and kode_chg in (4,5) and a.doc_no is not null
group by a.term,a.periode,a.sect,a.no_ctrl,a.part_no,a.part_nm,a.part_dtl,a.part_desc,a.account,c.ACC_DESC,a.uom,a.curr,
a.price,price_tot,a.qty,b.curr,b.term,price_quo,qty_add,price_add
order by a.no_ctrl";
/*
select a.sect,a.no_ctrl,b.part_no,b.part_nm,b.part_dtl,b.part_desc,b.account,ACC_DESC,c.status,
(case when kode_chg=0 then a.qty else 0 end) as qty,
isnull(dbo.lp_konprc (a.term,'USD',a.curr,(case when kode_chg=0 then a.price else 0 end)),0) as price_p,
isnull(dbo.lp_konprc (b.term,'USD',b.curr,price_tot),0) as price_f,qty_tot as qty_act,
isnull(dbo.lp_konprc (b.term,'USD',b.curr,price_tot),0) as price_act
from mstr_stp a 
full join bps_tmpPR b on a.no_ctrl=b.no_ctrl and a.periode=b.periode
inner join bps_approve c on b.PR_NO=c.no_doc and a.sect=c.sect
full join LP_ACC d on a.account=d.ACC_NO 
inner join bps_part e on b.part_no=e.part_no
where a.sect='PGA-IT' and a.periode='201911'
order by c.status desc,no_ctrl asc
*/
//echo $Qry;
$tb_part=odbc_exec($koneksi_lp,$Qry);
$row=0;	$nkol=10; $baris  = 0;//Ini untuk dimulai baris datanya	
$Tamn_p=0;$Tamn_add=0;$Tamn_stp=0;$Tamn_fc=0;
$Tamn_dfc=0;$Tamn_act=0;$TDiff=0;
	while($baris1=odbc_fetch_array($tb_part)){
	$row++;
	$no_ctrl=odbc_result($tb_part,'no_ctrl');
	$term=odbc_result($tb_part,'term');
	$periode=odbc_result($tb_part,'periode');
	$sect=odbc_result($tb_part,'sect');
	$part_no=odbc_result($tb_part,'part_no');
	$part_nm=odbc_result($tb_part,'part_nm');
	$part_dtl=odbc_result($tb_part,'part_dtl');
	$part_desc=odbc_result($tb_part,'part_desc');
	$account=odbc_result($tb_part,'account');
	$ACC_DESC=odbc_result($tb_part,'ACC_DESC');
	$qty_plan=odbc_result($tb_part,'qty_plan');
	$qty_act=odbc_result($tb_part,'qty_act');
	$uom=odbc_result($tb_part,'uom');
	$curr=odbc_result($tb_part,'curr');
	$price_p=round(odbc_result($tb_part,'price_plan'));
	$price_a=round(odbc_result($tb_part,'price_act'));
	$price_quo=round(odbc_result($tb_part,'price_quo'));
	if($price_quo==0){$prc_fc=$price_p;}else{$prc_fc=$price_quo;}
	$amn_fc=$prc_fc*$qty_plan;
	$amn_p=round(odbc_result($tb_part,'amn_p'));
	$amn_a=round(odbc_result($tb_part,'amn_a'));

	$tb_kdchg=odbc_exec($koneksi_lp,"select distinct no_ctrl,sum(isnull(kode_chg,0)) as kode_chg,isnull(dbo.lp_cr_QPadd('qty',no_ctrl,'OPEN'),0) as qadd from bps_budget_add where doc_no is not null and no_ctrl='$no_ctrl' and periode='$periode' group by no_ctrl");
	$kdchg=odbc_result($tb_kdchg,"kode_chg");
	$Q_add=odbc_result($tb_kdchg,"qadd");
	
if($amn_a>$amn_p){
		if($qty_act>$qty_plan and $price_a=$price_p) {
		$qty_pk=$qty_plan;
		$qty_add=$qty_act-$qty_plan;
		$price_pk=$price_a;
		$price_add=$price_a;}
		else if($qty_act=$qty_plan and $price_a>$price_p) {
		$qty_pk=$qty_plan;
		$qty_add=$qty_plan;
		$price_pk=$price_a;
		$price_add=$price_a-$price_p;}}
		else{
		$qty_pk=$qty_plan;
		$qty_add=0;
		$price_pk=$price_a;
		$price_add=0;
	}
	$amn_pk=$qty_pk*$price_pk;
	


	$tb_kdchg=odbc_exec($koneksi_lp,"select distinct top 1 isnull(kode_chg,0) as kode_chg from bps_budget_add where no_ctrl='$no_ctrl' and periode='$periode'");
	$kdchg=odbc_result($tb_kdchg,"kode_chg");
	if($kdchg>3){
		$Qplan=0;$Pplan=0;$Amnplan=0;
		$Qstp=0;$Pstp=0;
		$Qadd=$qty_plan;$Padd=$price_a;}
		else{
		$Qplan=$qty_plan;$Pplan=$price_p;$Amnplan=$amn_p;
		
		if($qty_act>$Qplan){
			$Qstp=$Qplan;
			$Qadd=$qty_act-$Qstp;
			if($kdchg==''){$Padd=0;}else{
		$Padd=$prc_fc;}
			}else{
			$Qstp=$qty_act;
			$Qadd=0;$Padd=0;}
		
		if($price_a>$Pplan){
			$Pstp=$price_p;
			$Padd=$price_a-$Pplan;
			if($kdchg==''){$Qadd=0;}else{
			$Qadd=$Qplan;}
			}else{
			$Pstp=$price_a;$Padd=0;$Qadd=0;
			}
			}
	$Diff_pfc=$Amnplan-$amn_fc;
	$Amnstp=$Qstp*$Pstp;
	$Amnadd=$Qadd*$Padd;
	//$Amnadd=$qty_add*$price_add;
	$AmnTot=$Amnstp+$Amnadd;
	$DiffTot=$AmnTot-$Amnstp;
	
	$crjmpr=odbc_exec($koneksi_lp,"select count(no_ctrl) as jm from bps_tmpPR where no_ctrl='$no_ctrl' and periode='$periode'");
	$jm=odbc_result($crjmpr,"jm");
	
	$crpr=odbc_exec($koneksi_lp,"select distinct pr_no from bps_tmpPR where no_ctrl='$no_ctrl' and periode='$periode' order by pr_no asc");
	$x=0;$gpr="";
	while(odbc_fetch_array($crpr)){
	$x++;
	$pr=odbc_result($crpr,"pr_no");
	$gpr=$gpr.",".$pr;
	}
	
	//$Amnplan;$Pstp;$Qstp;
	
	if($jm==0){$pr_no='';}
	else if($jm>1){$pr_no=$gpr;}else{$pr_no=$pr;}
	$Tamn_p=$Tamn_p+$Amnplan;
	$Tamn_fc=$Tamn_fc+$amn_fc;
	$Tamn_dfc=$Tamn_fc+$Diff_pfc;
	$Tamn_add=$Tamn_add+$Amnadd;
	$Tamn_stp=$Tamn_stp+$Amnstp;
	$Tamn_act=$Tamn_act+$AmnTot;
	$TDiff=$TDiff+$DiffTot;
	
	
	
	$SI->setCellValueByColumnAndRow($baris,$nkol,$sect);
	$SI->setCellValueByColumnAndRow($baris+1,$nkol,$no_ctrl);
	$SI->setCellValueByColumnAndRow($baris+2,$nkol,$part_no);
	$SI->setCellValueByColumnAndRow($baris+3,$nkol,$part_nm);
	$SI->setCellValueByColumnAndRow($baris+4,$nkol,$part_dtl." ".$part_desc);
	$SI->setCellValueByColumnAndRow($baris+5,$nkol,$account);
	$SI->setCellValueByColumnAndRow($baris+6,$nkol,$ACC_DESC);
	$SI->setCellValueByColumnAndRow($baris+7,$nkol,$Qplan); 
	$SI->setCellValueByColumnAndRow($baris+8,$nkol,$Pplan);
	$SI->setCellValueByColumnAndRow($baris+9,$nkol,$Amnplan);
	$SI->setCellValueByColumnAndRow($baris+10,$nkol,$prc_fc); 
	$SI->setCellValueByColumnAndRow($baris+11,$nkol,$amn_fc);
	$SI->setCellValueByColumnAndRow($baris+12,$nkol,$Diff_pfc);
	$SI->setCellValueByColumnAndRow($baris+13,$nkol,$Qstp);
	$SI->setCellValueByColumnAndRow($baris+14,$nkol,$Pstp);
	$SI->setCellValueByColumnAndRow($baris+15,$nkol,$Amnstp);
	$SI->setCellValueByColumnAndRow($baris+16,$nkol,$Qadd);
	$SI->setCellValueByColumnAndRow($baris+17,$nkol,$Padd);
	$SI->setCellValueByColumnAndRow($baris+18,$nkol,$Amnadd);
	$SI->setCellValueByColumnAndRow($baris+19,$nkol,$AmnTot);
	$SI->setCellValueByColumnAndRow($baris+20,$nkol,$DiffTot);
	$SI->setCellValueByColumnAndRow($baris+21,$nkol,$pr_no);
$nkol++;
	}
	$akhir=$nkol+1;

	$SI->setCellValueByColumnAndRow($baris+1,$nkol,'TOTAL 合計');
	$excelku->getActiveSheet()->getStyle('B'.$baris+1)->getFont()->setBold(TRUE); // Set bold kolom A1
	$SI->setCellValueByColumnAndRow($baris+9,$nkol,$Tamn_p); 
	$SI->setCellValueByColumnAndRow($baris+11,$nkol,$Tamn_fc); 
	$SI->setCellValueByColumnAndRow($baris+12,$nkol,$Tamn_dfc); 
	$SI->setCellValueByColumnAndRow($baris+15,$nkol,$Tamn_stp)	;
	$SI->setCellValueByColumnAndRow($baris+18,$nkol,$Tamn_add);
	$SI->setCellValueByColumnAndRow($baris+19,$nkol,$Tamn_act);
	$SI->setCellValueByColumnAndRow($baris+20,$nkol,$TDiff);

//$excelku->getActiveSheet()->mergeCells('A'.$baris.':L'.$baris);
//$SI->setCellValueByColumnAndRow(0,$baris,"Jumlah Data : ".$row); 
//$SI->setCellValueByColumnAndRow(3,$baris,"Masuk : ".($row - $jmplg)); 
//$SI->setCellValueByColumnAndRow(4,$baris,"Pulang : ".$jmplg); 

//Membuat garis di body tabel (isi data)
//$excelku->getActiveSheet()->setSharedStyle($bodyStylenya, "A7 : Y".$nkol);

//Memberi nama sheet
$excelku->getActiveSheet()->setTitle($Jdl2);

$excelku->setActiveSheetIndex(0);
$excelku->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
// untuk excel 2007 atau yang berekstensi .xlsx
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='.$Jdl2."_".$sect."_".$periode.'.xls');

header('Cache-Control: max-age=0');
 $styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$blk_range="A7:V".$nkol;
$excelku->getActiveSheet()->getStyle($blk_range)->applyFromArray($styleArray);
unset($styleArray);
$objWriter = PHPExcel_IOFactory::createWriter($excelku, 'Excel2007');
$objWriter->save('php://output');
exit;
echo "<h3>EXPORT DATA ".$Jdl2." ".$sect." Periode ".$periode." SUDAH SELESAI DENGAN JUMLAH DATA ".$row." BARIS</h3>";
?>