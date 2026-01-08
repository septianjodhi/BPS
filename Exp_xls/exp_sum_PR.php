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
// Set properties
$excelku->getProperties()->setCreator("BPS SAMI")
                         ->setLastModifiedBy("BPS SAMI");
// Set lebar kolom
$excelku->getActiveSheet()->getColumnDimension('A')->setWidth(5);//NO
$excelku->getActiveSheet()->getColumnDimension('B')->setWidth(10);//SECT
$excelku->getActiveSheet()->getColumnDimension('C')->setWidth(15);//PART NUMBER
$excelku->getActiveSheet()->getColumnDimension('D')->setWidth(25);//PART NAME
$excelku->getActiveSheet()->getColumnDimension('E')->setWidth(30);//DETAIL PART
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(5);//ACC NO
$excelku->getActiveSheet()->getColumnDimension('G')->setWidth(30);//DESCRIPTION ACC
$excelku->getActiveSheet()->getColumnDimension('H')->setWidth(15);//CARLINE
$excelku->getActiveSheet()->getColumnDimension('I')->setWidth(10);//QTY
$excelku->getActiveSheet()->getColumnDimension('J')->setWidth(10);//AVG QTY
$excelku->getActiveSheet()->getColumnDimension('K')->setWidth(10);//CURR
$excelku->getActiveSheet()->getColumnDimension('L')->setWidth(10);//PRICE
$excelku->getActiveSheet()->getColumnDimension('M')->setWidth(15);//AMOUNT
$excelku->getActiveSheet()->getColumnDimension('N')->setWidth(15);//AVG AMOUNT


// Mergecell, menyatukan beberapa kolom
//$excelku->getActiveSheet()->mergeCells('A1:G1');
//$excelku->getActiveSheet()->mergeCells('A2:G2');

// Buat Kolom judul tabel
$SI = $excelku->setActiveSheetIndex(0);
$Jdl='ACTUAL BUDGET';

$SI->setCellValue('A1', 'PT. Semarang Autocomp Manufacturing Indonesia'); //0
$SI->setCellValue('A2', $Jdl); //0
$SI->setCellValue('A3', 'TERM = '.$term); //0
$SI->setCellValue('A4', 'SECT = '.$sect); //0

$SI->setCellValue('A6', 'Download Time= '.date("Y-m-d H:i:s")); //0
$SI->setCellValue('A7', 'NO'); //0
$SI->setCellValue('B7', 'SECT'); //1
$SI->setCellValue('C7', 'PART NUMBER'); //2
$SI->setCellValue('D7', 'PART NAME'); //3
$SI->setCellValue('E7', 'DETAIL PART'); //4
$SI->setCellValue('F7', 'ACC NO'); //5
$SI->setCellValue('G7', 'DESCRIPTION'); //6
$SI->setCellValue('H7', 'CARLINE'); //7
$SI->setCellValue('I7', 'QTY'); //8
$SI->setCellValue('J7', 'AVG QTY'); //9
$SI->setCellValue('K7', 'CURR'); //10
$SI->setCellValue('L7', 'PRICE'); //11
$SI->setCellValue('M7', 'AMOUNT'); //12
$SI->setCellValue('N7', 'AVG AMOUNT'); //13

$qcrperi="select distinct periode from bps_budget where term='$term' order by periode asc";

$nkol=14;$isiperi="";
$tb_adkol=odbc_exec($koneksi_lp,$qcrperi);
while($barkol=odbc_fetch_array($tb_adkol)){
$per=odbc_result($tb_adkol,'periode');	
$isiperi=$isiperi."|".$per;
$SI->setCellValueByColumnAndRow($nkol,7,$per); 
$SI->setCellValueByColumnAndRow($nkol,8,'QTY'); 
$SI->setCellValueByColumnAndRow($nkol+1,8,'PRICE'); 
$SI->setCellValueByColumnAndRow($nkol+2,8,'AMOUNT'); 
$nkol=$nkol+3;
}
$isiperi=$isiperi."||||||||||||";
$pchperi=explode("|",$isiperi);
$Qry="select distinct bps_budget.part_nm,bps_budget.part_no,bps_budget.part_dtl,bps_budget.account,bps_budget.cccode,bps_budget.curr,bps_PR.sect,LP_ACC.ACC_DESC from bps_budget inner join bps_PR on bps_budget.sect=bps_PR.sect and bps_budget.term=bps_PR.term and bps_budget.no_ctrl=bps_pr.no_ctrl inner join LP_ACC on LP_ACC.ACC_NO=bps_budget.account where bps_pr.sect='$sect' AND bps_pr.TERM='$term'";
$baris  = 9; //Ini untuk dimulai baris datanya
$no     = 1;
$bar=0;
$bul='';$qbul=0;$pbul=0;$abul=0;
//echo $Qry;
		$tb_part=odbc_exec($koneksi_lp,$Qry);
		$row=0;			   		
				while($baris1=odbc_fetch_array($tb_part)){
				$row++;
$partno=odbc_result($tb_part,'part_no');
$ndtl=14;
$qdtl=0;$prcdtl=0;$adtl=0;$qdtl_t=0;$prcdtl_t=0;$adtl_t=0;$pembagi=0;
for($i=0;$i<12;$i++){
	$qdtl=0;$prcdtl=0;
$dtperi=$pchperi[$i+1]; 
$qryact="select distinct price_tot,part_no,periode,sum(qty_tot) as qty from bps_tmpPR where periode='$dtperi' and part_no='$partno' group by price_tot,part_no,periode";
$tb_act=odbc_exec($koneksi_lp,$qryact);
while($baract=odbc_fetch_array($tb_act)){
$qdtl=odbc_result($tb_act,'qty');
$prcdtl=odbc_result($tb_act,'price_tot');	
$qdtl_t=$qdtl_t + $qdtl;
$prcdtl_t=$prcdtl_t + $prcdtl;
}
if($qdtl>0){$pembagi++;}
$adtl=$qdtl * $prcdtl;
$SI->setCellValueByColumnAndRow($ndtl,$baris,number_format($qdtl,0)); 
$SI->setCellValueByColumnAndRow($ndtl+1,$baris,number_format($prcdtl,2,".","")); 
$SI->setCellValueByColumnAndRow($ndtl+2,$baris,$adtl); 
$ndtl=$ndtl+3;
}

$adtl_t=$qdtl_t * $prcdtl_t;	
$avq=$qdtl_t/$pembagi;
$avp=$prcdtl_t/$pembagi;
$ava=$adtl_t/$pembagi;

$SI->setCellValueByColumnAndRow(0,$baris,$row); 
$SI->setCellValueByColumnAndRow(1,$baris,odbc_result($tb_part,'sect')); 
$SI->setCellValueByColumnAndRow(2,$baris,$partno); 
$SI->setCellValueByColumnAndRow(3,$baris,odbc_result($tb_part,'part_nm')); 
$SI->setCellValueByColumnAndRow(4,$baris,odbc_result($tb_part,'part_dtl')); 
$SI->setCellValueByColumnAndRow(5,$baris,odbc_result($tb_part,'account')); 
$SI->setCellValueByColumnAndRow(6,$baris,odbc_result($tb_part,'acc_desc'));
$SI->setCellValueByColumnAndRow(7,$baris,odbc_result($tb_part,'cccode')); 
$SI->setCellValueByColumnAndRow(8,$baris,$qdtl_t); 
$SI->setCellValueByColumnAndRow(9,$baris,number_format($avq,2,".","")); 
$SI->setCellValueByColumnAndRow(10,$baris,odbc_result($tb_part,'curr')); 
$SI->setCellValueByColumnAndRow(11,$baris,number_format($avp,2,".","")); 
$SI->setCellValueByColumnAndRow(12,$baris,number_format($adtl_t,2,".","")); 
$SI->setCellValueByColumnAndRow(13,$baris,number_format($ava,2,".","")); 

	
$baris++;
}

$excelku->getActiveSheet()->mergeCells('A'.$baris.':L'.$baris);
$SI->setCellValueByColumnAndRow(0,$baris,"Jumlah Data : ".$row); 

//Membuat garis di body tabel (isi data)
//$excelku->getActiveSheet()->setSharedStyle($bodyStylenya, "A4 : G4");

//Memberi nama sheet
$excelku->getActiveSheet()->setTitle($Jdl);

$excelku->setActiveSheetIndex(0);

// untuk excel 2007 atau yang berekstensi .xlsx
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='.$Jdl.'.xls');
header('Cache-Control: max-age=0');
 $styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$blk_range="A7:AX".$baris;
$excelku->getActiveSheet()->getStyle($blk_range)->applyFromArray($styleArray);
unset($styleArray);
/*
const BORDER_NONE = 'none';
const BORDER_DASHDOT = 'dashDot';
const BORDER_DASHDOTDOT = 'dashDotDot';
const BORDER_DASHED = 'dashed';
const BORDER_DOTTED = 'dotted';
const BORDER_DOUBLE = 'double';
const BORDER_HAIR = 'hair';
const BORDER_MEDIUM = 'medium';
const BORDER_MEDIUMDASHDOT = 'mediumDashDot';
const BORDER_MEDIUMDASHDOTDOT = 'mediumDashDotDot';
const BORDER_MEDIUMDASHED = 'mediumDashed';
const BORDER_SLANTDASHDOT = 'slantDashDot';
const BORDER_THICK = 'thick';
const BORDER_THIN = 'thin';
*/ 
$objWriter = PHPExcel_IOFactory::createWriter($excelku, 'Excel2007');
$objWriter->save('php://output');
exit;
echo "<h3>EXPORT DATA ".$Jdl." SUDAH SELESAI DENGAN JUMLAH DATA ".$bar." BARIS</h3>";
?>