<?php
session_start();

include "../koneksi.php";
include "PHPExcel.php";

date_default_timezone_set("Asia/Jakarta");
$excelku = new PHPExcel();
$GAS=$excelku->getActiveSheet();
$sect=$_GET['s'];
$periode=$_GET['p'];

// Set properties
$excelku->getProperties()->setCreator("BPS SAMI")
->setLastModifiedBy("BPS SAMI");
// Set lebar kolom

$GAS->getColumnDimension('A')->setWidth(15);//No
$GAS->getColumnDimension('B')->setWidth(20);//NO ctrl
$GAS->getColumnDimension('C')->setWidth(25);//Part No
$GAS->getColumnDimension('D')->setWidth(25);//Part Name
$GAS->getColumnDimension('E')->setWidth(25);//Part Dtl
$GAS->getColumnDimension('F')->setWidth(10);//Part desc
$GAS->getColumnDimension('G')->setWidth(10);//UOM
$GAS->getColumnDimension('H')->setWidth(10);//Curr
$GAS->getColumnDimension('I')->setWidth(15);//Qty STP
$GAS->getColumnDimension('J')->setWidth(15);//Price STP
$GAS->getColumnDimension('K')->setWidth(15);//Qty fc
$GAS->getColumnDimension('K')->setWidth(15);//Price fc

$SI = $excelku->setActiveSheetIndex(0);
$Jdl='Forecast '.$sect;

$SI->setCellValue('A1', 'PT. Semarang Autocomp Manufacturing Indonesia'); //0
$SI->setCellValue('A2', "FORM FORECAST"); //0
$SI->setCellValue('A3', "Periode :");
$SI->setCellValue('B3', $periode);
$SI->setCellValue('A4', "Dept-Sect :");
$SI->setCellValue('B4', $sect);
$SI->setCellValue('A6', 'Download Time= '.date("Y-m-d H:i:s")); //0

$GAS->getStyle('A7:L8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$Qry="SELECT * FROM bps_budget where sect='$sect' and periode='$periode'";
$tb_part=odbc_exec($koneksi_lp,$Qry);
$row=0;$i=7;$col=0;$baris=9;
$SI->setCellValueByColumnAndRow($col+0,$i,"No");
$SI->setCellValueByColumnAndRow($col+1,$i,"No Control");
$SI->setCellValueByColumnAndRow($col+2,$i,"Part No");
$SI->setCellValueByColumnAndRow($col+3,$i,"Part Name");
$SI->setCellValueByColumnAndRow($col+4,$i,"Part Detail");
$SI->setCellValueByColumnAndRow($col+5,$i,"Part Desc");
$SI->setCellValueByColumnAndRow($col+6,$i,"UoM");
$SI->setCellValueByColumnAndRow($col+7,$i,"Curr");
$SI->setCellValueByColumnAndRow($col+8,$i,"STP");
$SI->setCellValueByColumnAndRow($col+8,$i+1,"Qty");
$SI->setCellValueByColumnAndRow($col+9,$i+1,"Price");
$SI->setCellValueByColumnAndRow($col+10,$i,"Forecast");
$SI->setCellValueByColumnAndRow($col+10,$i+1,"Qty");
$SI->setCellValueByColumnAndRow($col+11,$i+1,"Price");

//marge cell
$GAS->mergeCells('A7:A8');
$GAS->mergeCells('B7:B8');
$GAS->mergeCells('C7:C8');
$GAS->mergeCells('D7:D8');
$GAS->mergeCells('E7:E8');
$GAS->mergeCells('F7:F8');
$GAS->mergeCells('G7:G8');
$GAS->mergeCells('H7:H8');
$GAS->mergeCells('I7:J7');
$GAS->mergeCells('K7:L7');

//Memberi nama sheet
$GAS->setTitle($Jdl);
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
$blk_range="A7:L".$baris;
$excelku->getActiveSheet()->getStyle($blk_range)->applyFromArray($styleArray);
unset($styleArray);


$objWriter = PHPExcel_IOFactory::createWriter($excelku, 'Excel2007');
$objWriter->save('php://output');
exit;
echo "<h3>EXPORT DATA ".$Jdl." SUDAH SELESAI </h3>";
?>