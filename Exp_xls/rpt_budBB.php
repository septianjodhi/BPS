<?php
/*******************************************
    Export Excel dengan PHPExcel
******************************************/
session_start();

include "../koneksi.php";
include "PHPExcel.php";

date_default_timezone_set("Asia/Jakarta");
$excelku = new PHPExcel();
$sec=$_GET['s'];
    if($sec=="all"){$sect="" ;}else{$sect=" and a.sect='$sec' ";}
// $sect=$_GET['s'];
$term=$_GET['t'];
$period=$_GET['p'];
if($period=='ALL'){$per='';}else{$per=" and a.periode='$period'";}
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
$SI->setCellValue('A3', 'PERIOD (月度):'.$period); //0
$SI->setCellValue('A4', 'DEPT (部署名):'.$sec); //0
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
$SI->setCellValue('I9', 'USD'); //7;
$SI->setCellValue('J9', 'USD'); //9;
$SI->setCellValue('K7', 'FORECAST'); //7;
$SI->setCellValue('K8', 'PRICE 単価'); //7;
$SI->setCellValue('L8', 'AMOUNT 金額'); //9;
$SI->setCellValue('K9', 'USD'); //7;
$SI->setCellValue('L9', 'USD'); //9;
$SI->setCellValue('M7', 'DIFFERENCE'); //7;
$SI->setCellValue('M8', '(Plan-Forcase)'); //7;
$SI->setCellValue('M9', 'USD'); //7;
$SI->setCellValue('N7', 'ACTUAL STP'); //7;
$SI->setCellValue('N8', 'QTY 数量'); //6;
$SI->setCellValue('O8', 'PRICE 単価'); //7;
$SI->setCellValue('P8', 'AMOUNT 金額'); //9;
$SI->setCellValue('O9', 'USD'); //7;
$SI->setCellValue('P9', 'USD'); //9;
$SI->setCellValue('Q7', 'ACTUAL ADD'); //7;
$SI->setCellValue('Q8', 'QTY 数量'); //6;
$SI->setCellValue('R8', 'PRICE 単価'); //7;
$SI->setCellValue('S8', 'AMOUNT 金額'); //9;
$SI->setCellValue('R9', 'USD'); //7;
$SI->setCellValue('S9', 'USD'); //9;
$SI->setCellValue('T7', 'TOTAL ACTUAL'); //7;
$SI->setCellValue('T8', '(STP+ADD)'); //7;
$SI->setCellValue('T9', 'USD'); //7;
$SI->setCellValue('U7', 'DIFFERENCE'); //7;
$SI->setCellValue('U8', '(Plan-Actual)'); //7;
$SI->setCellValue('U9', 'USD'); //7;
$SI->setCellValue('V7', 'PR NO'); //14;


$Qry="select a.term,a.periode,a.sect,a.no_ctrl,b.part_no,b.part_nm,b.part_dtl,b.part_desc,a.uom,b.account,ACC_DESC,c.status,
(case when kode_chg=0 then a.qty else 0 end) as qty_plan,a.curr,
isnull(dbo.lp_konprc (a.term,'USD',a.curr,(case when kode_chg=0 then a.price else 0 end)),0) as price_plan,
isnull(dbo.lp_konprc (b.term,'USD',b.curr,price_tot),0) as price_quo,sum(qty_act) as qty_act,
isnull(dbo.lp_konprc (b.term,'USD',b.curr,price_tot),0) as price_act
from mstr_stp a 
full join bps_tmpPR b on a.no_ctrl=b.no_ctrl and a.periode=b.periode
inner join bps_approve c on b.PR_NO=c.no_doc and a.sect=c.sect
full join LP_ACC d on a.account=d.ACC_NO 
where c.status='FINISH' and a.term='$term' $sect $per
group by a.sect,a.no_ctrl,b.part_no,b.part_nm,b.part_dtl,b.part_desc,b.account,ACC_DESC,c.status,a.qty,a.term,a.curr,b.term,
b.curr,kode_chg,a.price,price_tot,b.no_ctrl,a.uom,a.periode
order by c.status desc,b.no_ctrl asc";

//echo $Qry;

$tb_part=odbc_exec($koneksi_lp,$Qry);
$row=0;	$nkol=10; $baris  = 0;//Ini untuk dimulai baris datanya	
$Tamn_p=0;$Tamn_add=0;$Tamn_stp=0;$Tamn_fc=0;
$Tamn_dfc=0;$Tamn_act=0;$TDiff=0;$Tamn_actual=0;
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
	$price_p=round(odbc_result($tb_part,'price_plan'),3);
	$price_a=round(odbc_result($tb_part,'price_act'),3);
	$price_quo=round(odbc_result($tb_part,'price_quo'),3);
	
	if($price_p==0){$prc_fc=$price_a;}else{$prc_fc=$price_p;}
	if($qty_plan==0){$qty_fc=$qty_act;}else{$qty_fc=$qty_plan;}
	$amn_fc=$prc_fc*$qty_fc;
	$amn_p=round($price_p*$qty_plan,3);
	$amn_a=round($price_a*$qty_act,3);
	if($amn_a>$amn_p){$ket='add';}else{$ket='normal';}
	$Amnstp=$amn_p;
	$Tamn_stp=$Tamn_stp+$Amnstp;
	
	$Diff_pfc=$amn_p-$amn_fc;
	$Tamn_fc=$Tamn_fc+$amn_fc;
	$Tamn_dfc=$Tamn_fc+$Diff_pfc;
	
	if($amn_p-$amn_a<0){
		if($qty_plan<$qty_act){
			$qty_add=$qty_act-$qty_plan;$qty_actual=$qty_plan;
			}else if($qty_plan>=$qty_act){
	$qty_add=$qty_act;$qty_actual=0;}}else{$qty_add=0;$qty_actual=$qty_act;}
	if($amn_p-$amn_a<0){
		if($price_p<$price_a){
			//Rev Price Additional
			//$Padd=$price_a-$price_p;
			$Padd=$price_a;
			}else if($price_p>=$price_a){
	$Padd=$price_a;}}else{$Padd=0;}
	
	$amn_actual=round($price_a*$qty_actual,3);
	
	$Amnadd=$qty_add*$Padd;
	$Tamn_add=$Tamn_add+$Amnadd;
	
	$AmnTot=$amn_a;
	$Tamn_act=$Tamn_act+$AmnTot;
	$DiffTot=$amn_p-$amn_a;
	$TDiff=$TDiff+$DiffTot;

	$Tamn_p=$Tamn_p+$amn_p;
	
	//Add Total Amount Actual sesuai Plan Budget
	$AmnTotActual=$amn_actual;
	$Tamn_actual=$Tamn_actual+$AmnTotActual;
	//----------------------

	
	//cari PR============
	$crjmpr=odbc_exec($koneksi_lp,"select count(no_ctrl) as jm from bps_tmpPR where no_ctrl='$no_ctrl' and periode='$periode'");
	$jm=odbc_result($crjmpr,"jm");
	
	$crpr=odbc_exec($koneksi_lp,"select distinct pr_no from bps_tmpPR where no_ctrl='$no_ctrl' and periode='$periode' order by pr_no asc");
	$x=0;$gpr="";
	while(odbc_fetch_array($crpr)){
	$x++;
	$pr=odbc_result($crpr,"pr_no");
	$gpr=$gpr.",".$pr;
	}
	if($jm==0){$pr_no='';}
	else if($jm>1){$pr_no=$gpr;}else{$pr_no=$pr;}
	//$Amnplan;$Pstp;$Qstp;

	$SI->setCellValueByColumnAndRow($baris,$nkol,$sect);
	$SI->setCellValueByColumnAndRow($baris+1,$nkol,$no_ctrl);
	$SI->setCellValueByColumnAndRow($baris+2,$nkol,$part_no);
	$SI->setCellValueByColumnAndRow($baris+3,$nkol,$part_nm);
	$SI->setCellValueByColumnAndRow($baris+4,$nkol,$part_dtl." ".$part_desc);
	$SI->setCellValueByColumnAndRow($baris+5,$nkol,$account);
	$SI->setCellValueByColumnAndRow($baris+6,$nkol,$ACC_DESC);
	//qty plan
	$SI->setCellValueByColumnAndRow($baris+7,$nkol,$qty_plan); 
	$SI->setCellValueByColumnAndRow($baris+8,$nkol,$price_p);
	$SI->setCellValueByColumnAndRow($baris+9,$nkol,$amn_p);
	//forcase
	$SI->setCellValueByColumnAndRow($baris+10,$nkol,$prc_fc); 
	$SI->setCellValueByColumnAndRow($baris+11,$nkol,$amn_fc);
	$SI->setCellValueByColumnAndRow($baris+12,$nkol,$Diff_pfc);
	/*
	$SI->setCellValueByColumnAndRow($baris+13,$nkol,$qty_plan);
	$SI->setCellValueByColumnAndRow($baris+14,$nkol,$price_p);
	$SI->setCellValueByColumnAndRow($baris+15,$nkol,$amn_p);
	*/
	//-------------------Rev Actual STP
	$SI->setCellValueByColumnAndRow($baris+13,$nkol,$qty_actual);
	$SI->setCellValueByColumnAndRow($baris+14,$nkol,$price_a);
	$SI->setCellValueByColumnAndRow($baris+15,$nkol,$amn_actual);
	//------------------------
	/*$SI->setCellValueByColumnAndRow($baris+16,$nkol,'');
	$SI->setCellValueByColumnAndRow($baris+17,$nkol,'');*/
	$SI->setCellValueByColumnAndRow($baris+16,$nkol,$qty_add);
	$SI->setCellValueByColumnAndRow($baris+17,$nkol,$Padd);
	//$SI->setCellValueByColumnAndRow($baris+18,$nkol,'');
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
	/*
	$SI->setCellValueByColumnAndRow($baris+15,$nkol,$Tamn_stp);
	*/
	//-------------------Rev Actual STP
	$SI->setCellValueByColumnAndRow($baris+15,$nkol,$Tamn_actual);
	//-------------------------------------------
	//$SI->setCellValueByColumnAndRow($baris+18,$nkol,'');
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
header('Content-Disposition: attachment;filename='.$Jdl2."_".$sec."_".$periode.'.xls');

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
echo "<h3>EXPORT DATA ".$Jdl2." ".$sec." Periode ".$periode." SUDAH SELESAI DENGAN JUMLAH DATA ".$row." BARIS</h3>";
?>