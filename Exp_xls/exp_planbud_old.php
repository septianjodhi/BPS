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
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(10);//ACC NO
$excelku->getActiveSheet()->getColumnDimension('G')->setWidth(30);//DESCRIPTION ACC
$excelku->getActiveSheet()->getColumnDimension('H')->setWidth(20);//CARLINE
$excelku->getActiveSheet()->getColumnDimension('I')->setWidth(20);//QTY
$excelku->getActiveSheet()->getColumnDimension('J')->setWidth(15);//AVG QTY
$excelku->getActiveSheet()->getColumnDimension('K')->setWidth(15);//CURR
$excelku->getActiveSheet()->getColumnDimension('L')->setWidth(10);//PRICE
$excelku->getActiveSheet()->getColumnDimension('M')->setWidth(15);//AMOUNT
$excelku->getActiveSheet()->getColumnDimension('N')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('O')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('P')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('Q')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('R')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('S')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('T')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('U')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('V')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('W')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('X')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('Y')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('Z')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('AA')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('AB')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('AC')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('AD')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('AE')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('AF')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('AG')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('AH')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('AI')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('AJ')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('AK')->setWidth(15);//AVG AMOUNT
$excelku->getActiveSheet()->getColumnDimension('AL')->setWidth(15);//AVG AMOUNT



// Mergecell, menyatukan beberapa kolom
//$excelku->getActiveSheet()->mergeCells('A1:G1');
//$excelku->getActiveSheet()->mergeCells('A2:G2');

// Buat Kolom judul tabel
$SI = $excelku->setActiveSheetIndex(0);
$Jdl='PLAN_BUDGET_'.$sect.'_Term-'.$term;

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
$SI->setCellValue('H7', 'CATEGORY'); //7
$SI->setCellValue('I7', 'COST CENTER'); //8
$SI->setCellValue('J7', 'CARLINE'); //9
$SI->setCellValue('K7', 'CAR MAKER'); //10
$SI->setCellValue('L7', 'UOM'); //11
$SI->setCellValue('M7', 'PRICE JUL-DEC'); //12
$SI->setCellValue('M8', 'USD'); //12
$SI->setCellValue('N7', 'PRICE JAN-JUN'); //13
$SI->setCellValue('N8', 'USD'); //12
$excelku->getActiveSheet()->getStyle('A7:AL8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$qcrperi="select distinct periode from bps_budget where term='$term' order by periode asc";
$nkol=14;$nkolA=26;$isiperi="";
$tb_adkol=odbc_exec($koneksi_lp,$qcrperi);
//==============================================================
while($barkol=odbc_fetch_array($tb_adkol)){
$per=odbc_result($tb_adkol,'periode');	
$isiperi=$isiperi."|".$per;
$SI->setCellValueByColumnAndRow($nkol,7,$per); 
$SI->setCellValueByColumnAndRow($nkol,8,'QTY');
$SI->setCellValueByColumnAndRow($nkolA,7,$per); 
$SI->setCellValueByColumnAndRow($nkolA,8,'AMOUNT 金額'); 
$nkol++;
$nkolA++;
}
$isiperi=$isiperi."||||||||||||";
$pchperi=explode("|",$isiperi);
$Qry="
select distinct a.part_nm,a.part_no,a.part_dtl,
a.uom,a.phase,a.account,a.cccode,a.curr,a.sect,c.ACC_DESC,e.carline,e.CARMAKER,
dbo.lp_konprc(a.term,'USD',d.curr,price1) as price1,
dbo.lp_konprc(a.term,'USD',d.curr,price2) as price2
from bps_budget_FA a
full join LP_ACC c on c.ACC_NO=a.account
full join bps_part d on a.part_no=d.part_no and a.part_nm=d.part_nm
full join LP_CV e on a.cccode=e.CV_CODE
where a.sect='$sect' AND a.TERM='$term'";
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
$part_nm=odbc_result($tb_part,'part_nm');
$part_dtl=odbc_result($tb_part,'part_dtl');
$account=odbc_result($tb_part,'account');
$ndtl=14;$ndtlA=26;
$qdtl=0;$prcdtl=0;$adtl=0;$qdtl_t=0;$prcdtl_t=0;$adtl_t=0;$pembagi=0;

for($i=0;$i<12;$i++){
	$qdtl=0;$prcdtl=0;
$dtperi=$pchperi[$i+1]; 
$qryact="select distinct top 1 periode,sect,part_no,part_nm,part_dtl,part_desc,dbo.lp_konprc(term,'USD',curr,price) as price,qty from bps_budget_FA where periode='$dtperi' and part_no='$partno' and part_nm='$part_nm' and part_dtl='$part_dtl' and sect='$sect' AND TERM='$term' and account='$account'";
$tb_act=odbc_exec($koneksi_lp,$qryact);
while($baract=odbc_fetch_array($tb_act)){
$qdtl=odbc_result($tb_act,'qty');
$prcdtl=odbc_result($tb_act,'price');	
$qdtl_t=$qdtl_t + $qdtl;
$prcdtl_t=$prcdtl_t + $prcdtl;
}


if($qdtl>0){$pembagi++;}
$adtl=$qdtl * $prcdtl;
$SI->setCellValueByColumnAndRow($ndtl,$baris,$qdtl);
$SI->setCellValueByColumnAndRow($ndtlA,$baris,number_format($prcdtl*$qdtl,2,".","")); 
$ndtl++;
$ndtlA++;
}
/*$adtl_t=$qdtl_t * $prcdtl_t;	
$avq=$qdtl_t/$pembagi;
$avp=$prcdtl_t/$pembagi;
$ava=$adtl_t/$pembagi;*/

//==============================================================


$SI->setCellValueByColumnAndRow(0,$baris,$row);
$SI->setCellValueByColumnAndRow(1,$baris,odbc_result($tb_part,'sect'));
$SI->setCellValueByColumnAndRow(2,$baris,$partno); 
$SI->setCellValueByColumnAndRow(3,$baris,odbc_result($tb_part,'part_nm')); 
$SI->setCellValueByColumnAndRow(4,$baris,odbc_result($tb_part,'part_dtl')); 
$SI->setCellValueByColumnAndRow(5,$baris,odbc_result($tb_part,'account')); 
$SI->setCellValueByColumnAndRow(6,$baris,odbc_result($tb_part,'acc_desc'));
$SI->setCellValueByColumnAndRow(7,$baris,odbc_result($tb_part,'phase')); 
$SI->setCellValueByColumnAndRow(8,$baris,odbc_result($tb_part,'cccode')); 
$SI->setCellValueByColumnAndRow(9,$baris,odbc_result($tb_part,'carline')); 
$SI->setCellValueByColumnAndRow(10,$baris,odbc_result($tb_part,'CARMAKER')); 
$SI->setCellValueByColumnAndRow(11,$baris,odbc_result($tb_part,'uom'));
$SI->setCellValueByColumnAndRow(12,$baris,number_format(odbc_result($tb_part,'price1'),2,".","")); 
$SI->setCellValueByColumnAndRow(13,$baris,number_format(odbc_result($tb_part,'price2'),2,".","")); 

	
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
$blk_range="A7:AL".$baris;
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