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
// Set text center untuk kolom 
    $excelku->getActiveSheet()->getStyle('A7:BS8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Set lebar kolom
$excelku->getActiveSheet()->getColumnDimension('A')->setWidth(10) ; // SECTION
$excelku->getActiveSheet()->getColumnDimension('B')->setWidth(15) ; // BUDGET REF NO
$excelku->getActiveSheet()->getColumnDimension('C')->setWidth(20) ; // PART_NO
$excelku->getActiveSheet()->getColumnDimension('D')->setWidth(25) ; // PART  NAME
$excelku->getActiveSheet()->getColumnDimension('E')->setWidth(70) ; // DETAIL PART
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(20) ; // SECTION CATEGORY
$excelku->getActiveSheet()->getColumnDimension('G')->setWidth(10) ; // ACC NO.
$excelku->getActiveSheet()->getColumnDimension('H')->setWidth(25) ; // ACCOUNT DESCRIPTION
$excelku->getActiveSheet()->getColumnDimension('I')->setWidth(20) ; // CATEGORY
$excelku->getActiveSheet()->getColumnDimension('J')->setWidth(15) ; // COST CENTER
$excelku->getActiveSheet()->getColumnDimension('K')->setWidth(20) ; // CARLINE
$excelku->getActiveSheet()->getColumnDimension('L')->setWidth(20) ; // CARMAKER
$excelku->getActiveSheet()->getColumnDimension('M')->setWidth(10) ; // UOM
$excelku->getActiveSheet()->getColumnDimension('N')->setWidth(10) ; // ORG CURR
$excelku->getActiveSheet()->getColumnDimension('O')->setWidth(15) ; // PRICE ORG CURR
$excelku->getActiveSheet()->getColumnDimension('P')->setWidth(15) ; // 0
$excelku->getActiveSheet()->getColumnDimension('Q')->setWidth(15) ; // 0
$excelku->getActiveSheet()->getColumnDimension('R')->setWidth(15) ; // 0
$excelku->getActiveSheet()->getColumnDimension('S')->setWidth(15) ; // 0
$excelku->getActiveSheet()->getColumnDimension('T')->setWidth(15) ; // 0
$excelku->getActiveSheet()->getColumnDimension('U')->setWidth(15) ; // 0
$excelku->getActiveSheet()->getColumnDimension('V')->setWidth(15) ; // 0
$excelku->getActiveSheet()->getColumnDimension('W')->setWidth(15) ; // 0
$excelku->getActiveSheet()->getColumnDimension('X')->setWidth(15) ; // 0
$excelku->getActiveSheet()->getColumnDimension('Y')->setWidth(15) ; // 0
$excelku->getActiveSheet()->getColumnDimension('Z')->setWidth(15) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AA')->setWidth(10) ; // PRICE USD
$excelku->getActiveSheet()->getColumnDimension('AB')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AC')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AD')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AE')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AF')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AG')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AH')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AI')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AJ')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AK')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AL')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AM')->setWidth(10) ; // QTY
$excelku->getActiveSheet()->getColumnDimension('AN')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AO')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AP')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AQ')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AR')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AS')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AT')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AU')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AV')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AW')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AX')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('AY')->setWidth(10) ; // TOTAL
$excelku->getActiveSheet()->getColumnDimension('AZ')->setWidth(10) ; // AVERAGE
$excelku->getActiveSheet()->getColumnDimension('BA')->setWidth(15) ; // 0
$excelku->getActiveSheet()->getColumnDimension('BB')->setWidth(10) ; // AMT
$excelku->getActiveSheet()->getColumnDimension('BC')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('BD')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('BE')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('BF')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('BG')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('BH')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('BI')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('BJ')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('BK')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('BL')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('BM')->setWidth(10) ; // 0
$excelku->getActiveSheet()->getColumnDimension('BN')->setWidth(15) ; // TOTAL
$excelku->getActiveSheet()->getColumnDimension('BO')->setWidth(15) ; // AVERAGE
$excelku->getActiveSheet()->getColumnDimension('BP')->setWidth(15) ; // AVERAGE
$excelku->getActiveSheet()->getColumnDimension('BQ')->setWidth(15) ; // AVERAGE
$excelku->getActiveSheet()->getColumnDimension('BR')->setWidth(15) ; // AVERAGE
$excelku->getActiveSheet()->getColumnDimension('BS')->setWidth(15) ; // AVERAGE


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

$SI->setCellValue('A7', 'SECTION');
$SI->setCellValue('B7', 'BUDGET REF NO');
$SI->setCellValue('C7', 'PART_NO');
$SI->setCellValue('D7', 'PART  NAME');
$SI->setCellValue('E7', 'DETAIL PART');
$SI->setCellValue('F7', 'SECTION CATEGORY');
$SI->setCellValue('G7', 'ACC NO.');
$SI->setCellValue('H7', 'ACCOUNT DESCRIPTION');
$SI->setCellValue('I7', 'CATEGORY');
$SI->setCellValue('J7', 'COST CENTER');
$SI->setCellValue('K7', 'CARLINE');
$SI->setCellValue('L7', 'CARMAKER');
$SI->setCellValue('M7', 'UOM');
$SI->setCellValue('N7', 'ORG CURR');
$SI->setCellValue('O7', 'PRICE ORG CURR');
$SI->setCellValue('O8', '07');
$SI->setCellValue('P8', '08');
$SI->setCellValue('Q8', '09');
$SI->setCellValue('R8', '10');
$SI->setCellValue('S8', '11');
$SI->setCellValue('T8', '12');
$SI->setCellValue('U8', '01');
$SI->setCellValue('V8', '02');
$SI->setCellValue('W8', '03');
$SI->setCellValue('X8', '04');
$SI->setCellValue('Y8', '05');
$SI->setCellValue('Z8', '06');
$SI->setCellValue('AA7', 'PRICE USD');
$SI->setCellValue('AA8', '07');
$SI->setCellValue('AB8', '08');
$SI->setCellValue('AC8', '09');
$SI->setCellValue('AD8', '10');
$SI->setCellValue('AE8', '11');
$SI->setCellValue('AF8', '12');
$SI->setCellValue('AG8', '01');
$SI->setCellValue('AH8', '02');
$SI->setCellValue('AI8', '03');
$SI->setCellValue('AJ8', '04');
$SI->setCellValue('AK8', '05');
$SI->setCellValue('AL8', '06');
$SI->setCellValue('AM7', 'QTY');
$SI->setCellValue('AM8', '07');
$SI->setCellValue('AN8', '08');
$SI->setCellValue('AO8', '09');
$SI->setCellValue('AP8', '10');
$SI->setCellValue('AQ8', '11');
$SI->setCellValue('AR8', '12');
$SI->setCellValue('AS8', '01');
$SI->setCellValue('AT8', '02');
$SI->setCellValue('AU8', '03');
$SI->setCellValue('AV8', '04');
$SI->setCellValue('AW8', '05');
$SI->setCellValue('AX8', '06');
$SI->setCellValue('AY7', 'TOTAL');
$SI->setCellValue('AZ7', 'AVERAGE');
$SI->setCellValue('BA7', '');
$SI->setCellValue('BB7', 'AMT');
$SI->setCellValue('BB8', '07');
$SI->setCellValue('BC8', '08');
$SI->setCellValue('BD8', '09');
$SI->setCellValue('BE8', '10');
$SI->setCellValue('BF8', '11');
$SI->setCellValue('BG8', '12');
$SI->setCellValue('BH8', '01');
$SI->setCellValue('BI8', '02');
$SI->setCellValue('BJ8', '03');
$SI->setCellValue('BK8', '04');
$SI->setCellValue('BL8', '05');
$SI->setCellValue('BM8', '06');
$SI->setCellValue('BN7', 'TOTAL');
$SI->setCellValue('BO7', 'AVERAGE');
$SI->setCellValue('BP7', '');
$SI->setCellValue('BQ7', 'SUB ACCOUNT');
$SI->setCellValue('BR7', 'KODE PROSES');
$SI->setCellValue('BS7', 'PURCHASING');


$query="SELECT term,sect,part_no,part_desc,part_dtl,uom,account,id_proses,lp,
sub_acc,curr,phase,cccode,cv_code,part_nm,Qact_07,Qact_08,Qact_09,Qact_10,Qact_11,Qact_12,
Qact_01,Qact_02,Qact_03,Qact_04,Qact_05,Qact_06,term_p,sect_p,part_p,prc_07,prc_08,prc_09,prc_10,
prc_11,prc_12,prc_01,prc_02,prc_03,prc_04,prc_05,prc_06,
dbo.lp_konprc(term,'USD',curr,prc_07) as prc_07U,dbo.lp_konprc(term,'USD',curr,prc_08) 
as prc_08U,dbo.lp_konprc(term,'USD',curr,prc_09) as prc_09U,
dbo.lp_konprc(term,'USD',curr,prc_10) as prc_10U,dbo.lp_konprc(term,'USD',curr,prc_11) 
as prc_11U,dbo.lp_konprc(term,'USD',curr,prc_12) as prc_12U,
dbo.lp_konprc(term,'USD',curr,prc_01) as prc_01U,dbo.lp_konprc(term,'USD',curr,prc_02) 
as prc_02U,dbo.lp_konprc(term,'USD',curr,prc_03) as prc_03U,
dbo.lp_konprc(term,'USD',curr,prc_04) as prc_04U,dbo.lp_konprc(term,'USD',curr,prc_05) 
as prc_05U,dbo.lp_konprc(term,'USD',curr,prc_06) as prc_06U,ACC_DESC,CARLINE,CARMAKER
FROM dbo.mstr_budact_hor a
where term='$term' and sect='$sect' ";
$tb_part=odbc_exec($koneksi_lp, $query);

$baris  = 9; //Ini untuk dimulai baris datanya
$no     = 1;
$row=0;$Qsub_total=0;$Asub_total=0;$A_total=0;
while($data=odbc_fetch_array($tb_part)){
  $row++;
  $Qact_07=odbc_result($tb_part,'Qact_07');
  $Qact_08=odbc_result($tb_part,'Qact_08');
  $Qact_09=odbc_result($tb_part,'Qact_09');
  $Qact_10=odbc_result($tb_part,'Qact_10');
  $Qact_11=odbc_result($tb_part,'Qact_11');
  $Qact_12=odbc_result($tb_part,'Qact_12');
  $Qact_01=odbc_result($tb_part,'Qact_01');
  $Qact_02=odbc_result($tb_part,'Qact_02');
  $Qact_03=odbc_result($tb_part,'Qact_03');
  $Qact_04=odbc_result($tb_part,'Qact_04');
  $Qact_05=odbc_result($tb_part,'Qact_05');
  $Qact_06=odbc_result($tb_part,'Qact_06');

  if($Qact_07==0){$cq_07=0;}else{$cq_07=1;}
  if($Qact_08==0){$cq_08=0;}else{$cq_08=1;}
  if($Qact_09==0){$cq_09=0;}else{$cq_09=1;}
  if($Qact_10==0){$cq_10=0;}else{$cq_10=1;}
  if($Qact_11==0){$cq_11=0;}else{$cq_11=1;}
  if($Qact_12==0){$cq_12=0;}else{$cq_12=1;}
  if($Qact_01==0){$cq_01=0;}else{$cq_01=1;}
  if($Qact_02==0){$cq_02=0;}else{$cq_02=1;}
  if($Qact_03==0){$cq_03=0;}else{$cq_03=1;}
  if($Qact_04==0){$cq_04=0;}else{$cq_04=1;}
  if($Qact_05==0){$cq_05=0;}else{$cq_05=1;}
  if($Qact_06==0){$cq_06=0;}else{$cq_06=1;}

  $Qsub_total=$Qact_07+$Qact_08+$Qact_09+$Qact_10+$Qact_11+$Qact_12+$Qact_01+$Qact_02+$Qact_03+$Qact_04+$Qact_05+$Qact_06;
  $cq_sub=$cq_07+$cq_08+$cq_09+$cq_10+$cq_11+$cq_12+$cq_01+$cq_02+$cq_03+$cq_04+$cq_05+$cq_06;

  $pembulatan=2;
  $prc_07U=odbc_result($tb_part,'prc_07U');
  $prc_08U=odbc_result($tb_part,'prc_08U');
  $prc_09U=odbc_result($tb_part,'prc_09U');
  $prc_10U=odbc_result($tb_part,'prc_10U');
  $prc_11U=odbc_result($tb_part,'prc_11U');
  $prc_12U=odbc_result($tb_part,'prc_12U');
  $prc_01U=odbc_result($tb_part,'prc_01U');
  $prc_02U=odbc_result($tb_part,'prc_02U');
  $prc_03U=odbc_result($tb_part,'prc_03U');
  $prc_04U=odbc_result($tb_part,'prc_04U');
  $prc_05U=odbc_result($tb_part,'prc_05U');
  $prc_06U=odbc_result($tb_part,'prc_06U');

  $amn_07=$Qact_07*$prc_07U;
  $amn_08=$Qact_08*$prc_08U;
  $amn_09=$Qact_09*$prc_09U;
  $amn_10=$Qact_10*$prc_10U;
  $amn_11=$Qact_11*$prc_11U;
  $amn_12=$Qact_12*$prc_12U;
  $amn_01=$Qact_01*$prc_01U;
  $amn_02=$Qact_02*$prc_02U;
  $amn_03=$Qact_03*$prc_03U;
  $amn_04=$Qact_04*$prc_04U;
  $amn_05=$Qact_05*$prc_05U;
  $amn_06=$Qact_06*$prc_06U;
  $Asub_total=$amn_07+$amn_08+$amn_09+$amn_10+$amn_11+$amn_12+$amn_01+$amn_02+$amn_03+$amn_04+$amn_05+$amn_06;
  if($cq_sub==0){$A_avrg=0;}else
  {$A_avrg=$Asub_total/$cq_sub;}
  $A_total=$Asub_total+$A_total;

  $SI->setCellValueByColumnAndRow(0,$baris,odbc_result($tb_part,'sect')); 
  $SI->setCellValueByColumnAndRow(1,$baris,''); 
  $SI->setCellValueByColumnAndRow(2,$baris,odbc_result($tb_part,'part_no')); 
  $SI->setCellValueByColumnAndRow(3,$baris,odbc_result($tb_part,'part_nm')); 
  $SI->setCellValueByColumnAndRow(4,$baris,odbc_result($tb_part,'part_dtl')); 
  $SI->setCellValueByColumnAndRow(5,$baris,''); 
  $SI->setCellValueByColumnAndRow(6,$baris,odbc_result($tb_part,'account')); 
  $SI->setCellValueByColumnAndRow(7,$baris,odbc_result($tb_part,'ACC_DESC')); 
  $SI->setCellValueByColumnAndRow(8,$baris,odbc_result($tb_part,'phase')); 
  $SI->setCellValueByColumnAndRow(9,$baris,odbc_result($tb_part,'cccode')); 
  $SI->setCellValueByColumnAndRow(10,$baris,odbc_result($tb_part,'CARLINE')); 
  $SI->setCellValueByColumnAndRow(11,$baris,odbc_result($tb_part,'CARMAKER'));
  $SI->setCellValueByColumnAndRow(12,$baris,odbc_result($tb_part,'uom'));
  $SI->setCellValueByColumnAndRow(13,$baris,odbc_result($tb_part,'curr')); 
  $SI->setCellValueByColumnAndRow(14,$baris,round(odbc_result($tb_part,'prc_07'),$pembulatan));
  $SI->setCellValueByColumnAndRow(15,$baris,round(odbc_result($tb_part,'prc_08'),$pembulatan)); 
  $SI->setCellValueByColumnAndRow(16,$baris,round(odbc_result($tb_part,'prc_09'),$pembulatan)); 
  $SI->setCellValueByColumnAndRow(17,$baris,round(odbc_result($tb_part,'prc_10'),$pembulatan)); 
  $SI->setCellValueByColumnAndRow(18,$baris,round(odbc_result($tb_part,'prc_11'),$pembulatan)); 
  $SI->setCellValueByColumnAndRow(19,$baris,round(odbc_result($tb_part,'prc_12'),$pembulatan)); 
  $SI->setCellValueByColumnAndRow(20,$baris,round(odbc_result($tb_part,'prc_01'),$pembulatan)); 
  $SI->setCellValueByColumnAndRow(21,$baris,round(odbc_result($tb_part,'prc_02'),$pembulatan)); 
  $SI->setCellValueByColumnAndRow(22,$baris,round(odbc_result($tb_part,'prc_03'),$pembulatan)); 
  $SI->setCellValueByColumnAndRow(23,$baris,round(odbc_result($tb_part,'prc_04'),$pembulatan)); 
  $SI->setCellValueByColumnAndRow(24,$baris,round(odbc_result($tb_part,'prc_05'),$pembulatan)); 
  $SI->setCellValueByColumnAndRow(25,$baris,round(odbc_result($tb_part,'prc_06'),$pembulatan)); 
  $SI->setCellValueByColumnAndRow(26,$baris,round($prc_07U,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(27,$baris,round($prc_08U,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(28,$baris,round($prc_09U,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(29,$baris,round($prc_10U,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(30,$baris,round($prc_11U,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(31,$baris,round($prc_12U,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(32,$baris,round($prc_01U,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(33,$baris,round($prc_02U,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(34,$baris,round($prc_03U,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(35,$baris,round($prc_04U,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(36,$baris,round($prc_05U,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(37,$baris,round($prc_06U,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(38,$baris,$Qact_07); 
  $SI->setCellValueByColumnAndRow(39,$baris,$Qact_08); 
  $SI->setCellValueByColumnAndRow(40,$baris,$Qact_09); 
  $SI->setCellValueByColumnAndRow(41,$baris,$Qact_10); 
  $SI->setCellValueByColumnAndRow(42,$baris,$Qact_11); 
  $SI->setCellValueByColumnAndRow(43,$baris,$Qact_12); 
  $SI->setCellValueByColumnAndRow(44,$baris,$Qact_01); 
  $SI->setCellValueByColumnAndRow(45,$baris,$Qact_02); 
  $SI->setCellValueByColumnAndRow(46,$baris,$Qact_03); 
  $SI->setCellValueByColumnAndRow(47,$baris,$Qact_04); 
  $SI->setCellValueByColumnAndRow(48,$baris,$Qact_05); 
  $SI->setCellValueByColumnAndRow(49,$baris,$Qact_06); 
  $SI->setCellValueByColumnAndRow(50,$baris,$Qsub_total); 
  $SI->setCellValueByColumnAndRow(51,$baris,round($Qsub_total/$cq_sub,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(52,$baris,''); 
  $SI->setCellValueByColumnAndRow(53,$baris,round($amn_07,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(54,$baris,round($amn_08,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(55,$baris,round($amn_09,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(56,$baris,round($amn_10,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(57,$baris,round($amn_11,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(58,$baris,round($amn_12,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(59,$baris,round($amn_01,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(60,$baris,round($amn_02,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(61,$baris,round($amn_03,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(62,$baris,round($amn_04,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(63,$baris,round($amn_05,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(64,$baris,round($amn_06,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(65,$baris,$Asub_total); 
  $SI->setCellValueByColumnAndRow(66,$baris,round($Asub_total/$cq_sub,$pembulatan)); 
  $SI->setCellValueByColumnAndRow(67,$baris,''); 
  $SI->setCellValueByColumnAndRow(68,$baris,odbc_result($tb_part,'sub_acc')); 
  $SI->setCellValueByColumnAndRow(69,$baris,odbc_result($tb_part,'id_proses')); 
  $SI->setCellValueByColumnAndRow(70,$baris,odbc_result($tb_part,'lp')); 
  
  $baris++;
}
// $SI->setCellValueByColumnAndRow(71,$baris+1,$query);ya i
// $excelku->getActiveSheet()->mergeCells('A'.$baris.':L'.$baris);
$excelku->getActiveSheet()->mergeCells('A7:A8');
$excelku->getActiveSheet()->mergeCells('B7:B8');
$excelku->getActiveSheet()->mergeCells('C7:C8');
$excelku->getActiveSheet()->mergeCells('D7:D8');
$excelku->getActiveSheet()->mergeCells('E7:E8');
$excelku->getActiveSheet()->mergeCells('F7:F8');
$excelku->getActiveSheet()->mergeCells('G7:G8');
$excelku->getActiveSheet()->mergeCells('H7:H8');
$excelku->getActiveSheet()->mergeCells('I7:I8');
$excelku->getActiveSheet()->mergeCells('J7:J8');
$excelku->getActiveSheet()->mergeCells('K7:K8');
$excelku->getActiveSheet()->mergeCells('L7:L8');
$excelku->getActiveSheet()->mergeCells('M7:M8');
$excelku->getActiveSheet()->mergeCells('N7:N8');

$excelku->getActiveSheet()->mergeCells('AY7:AY8');
$excelku->getActiveSheet()->mergeCells('AZ7:AZ8');

$excelku->getActiveSheet()->mergeCells('BN7:BN8');
$excelku->getActiveSheet()->mergeCells('BO7:BO8');

$excelku->getActiveSheet()->mergeCells('BQ7:BQ8');
$excelku->getActiveSheet()->mergeCells('BR7:BR8');
$excelku->getActiveSheet()->mergeCells('BS7:BS8');

$excelku->getActiveSheet()->mergeCells('O7:Z7');
$excelku->getActiveSheet()->mergeCells('AA7:AL7');
$excelku->getActiveSheet()->mergeCells('AM7:AX7');
$excelku->getActiveSheet()->mergeCells('BB7:BM7');
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
$blk_range="A7:AZ".$baris;
$excelku->getActiveSheet()->getStyle($blk_range)->applyFromArray($styleArray);
// unset($styleArray);
$border2="BB7:BO".$baris;
$excelku->getActiveSheet()->getStyle($border2)->applyFromArray($styleArray);
// unset($styleArray);
$border3="BQ7:BS".$baris;
$excelku->getActiveSheet()->getStyle($border3)->applyFromArray($styleArray);
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