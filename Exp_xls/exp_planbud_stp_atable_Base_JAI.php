<?php
/*******************************************
    Export Excel dengan PHPExcel
******************************************/
session_start();

include "../koneksi.php";
include "PHPExcel.php";

date_default_timezone_set("Asia/Jakarta");
$excelku = new PHPExcel();
/*
$sect_s= $_SESSION["area"]; 
$akses_s=$_SESSION["akses"];
$admin_FA_s=strpos($akses,'_FA');
$kd_akses_s=explode(",",$akses);
if(in_array('ADM_FA',$kd_akses_s)){
	$adm_s="";
}else{
	$adm_s=" and sect='$sect_s'";
} */

$term_s=$_GET['t'];
$sect_s=$_GET['s'];
$term_sum=$term_s-1;
$tahunnya=2023+($term_s-83);
$tahunnya1=$tahunnya-1;
//if($sec=="all" or $sec==""){$sect="" ;}else{$sect=" and a.sect='$sec' ";}

$rev_s=$_GET['r'];
$lokasi=$_GET['f'];
$rev_s1="select max(revisi) as revisi from bps_budget_stp where term='$term_s'";
$tb_rev=odbc_exec($koneksi_lp,$rev_s1);
				while($baris1_rev=odbc_fetch_array($tb_rev)){
					$rev_s=odbc_result($tb_rev,"revisi");
				}

$rev_s1="update bps_budget_STP set category=phase where term='$term_s' and revisi='$rev_s' AND category is null and phase not like 'PROJECT%'";
$tb_rev=odbc_exec($koneksi_lp,$rev_s1);

$rev_s1="update bps_budget_STP set category='PROJECT' where term='$term_s' and revisi='$rev_s' AND category is null and phase like 'PROJECT%'";
$tb_rev=odbc_exec($koneksi_lp,$rev_s1);


$rev_s1="UPDATE bps_budget_stp set account=NULL,acc_desc=NULL,commodity=NULL,dest=NULL,hfm_code=NULL,hfm_desc=NULL WHERE term='$term_s' and revisi='$rev_s'";
$tb_rev=odbc_exec($koneksi_lp,$rev_s1);
			
$rev_s1="UPDATE bt
SET 
    bt.account = CASE 
        WHEN bt.sub_acc = 'FOH' THEN pt.acc_no_foh
        WHEN bt.sub_acc = 'OPEX' THEN pt.acc_no_opex
        ELSE bt.account
    END,
    bt.acc_desc = pt.acc_desc,
	bt.commodity=cv.commodity,
	bt.dest=cv.dest
FROM bps_budget_stp bt
INNER JOIN lp_cv cv ON bt.cccode = cv.COST_CENTER_CODE and bt.term=cv.term
INNER JOIN bps_part pt ON bt.part_no = pt.part_no
WHERE bt.term='$term_s' and bt.revisi='$rev_s'";
$tb_rev=odbc_exec($koneksi_lp,$rev_s1);


$rev_s1="UPDATE bt
SET 
    bt.hfm_code = acc.hfm_code,
	bt.hfm_desc=acc.hfm_desc
FROM bps_budget_stp bt
INNER JOIN LP_acc acc ON bt.account = acc.acc_no
WHERE bt.term='$term_s' and bt.revisi='$rev_s'";
$tb_rev=odbc_exec($koneksi_lp,$rev_s1);
							

// Set properties
$excelku->getProperties()->setCreator("PLAN BUDGET STP SAMI-".$lokasi)
                         ->setLastModifiedBy("FA SAMI");

	
// Set lebar kolom
$excelku->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$excelku->getActiveSheet()->getColumnDimension('B')->setWidth(23);
$excelku->getActiveSheet()->getColumnDimension('C')->setWidth(13);
$excelku->getActiveSheet()->getColumnDimension('D')->setWidth(32);
$excelku->getActiveSheet()->getColumnDimension('E')->setWidth(26);
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$excelku->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$excelku->getActiveSheet()->getColumnDimension('H')->setWidth(30);
$excelku->getActiveSheet()->getColumnDimension('I')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('J')->setWidth(28);
$excelku->getActiveSheet()->getColumnDimension('K')->setWidth(15);


//set zoom view
//$excelku->getActiveSheet()->getSheetView()->setZoomScale(25);

// Buat Kolom judul tabel
$SI = $excelku->setActiveSheetIndex(0);
$Jdl='Output Report A-Table Term '.$term_s;

$SI->setCellValue('A1', 'A-Table Expense Report'); 
$SI->setCellValue('A2', 'Term'); 
$SI->setCellValue('A3', 'Unit'); 
$SI->setCellValue('A4', 'Selected Section'); 
$SI->setCellValue('A5', 'Download Time'); 


$SI->setCellValue('B2', $term_s); 
$SI->setCellValue('B3', 'USD'); 
$SI->setCellValue('B4', 'All Sections');
$SI->setCellValue('B5', date("Y-m-d H:i:s"));


$SI->setCellValue('A7', 'No'); //QTY
$SI->setCellValue('B7', 'Parameter'); //QTY
$SI->setCellValue('C7', 'HFM Account'); //QTY
$SI->setCellValue('D7', 'Description'); //QTY
$SI->setCellValue('E7', 'Purpose'); //QTY
$SI->setCellValue('F7', 'Commodity'); //QTY
$SI->setCellValue('G7', 'Destination'); //QTY
$SI->setCellValue('H7', 'Carline'); //QTY
$SI->setCellValue('I7', 'Period'); //QTY
$SI->setCellValue('J7', 'Amount'); //QTY
$SI->setCellValue('K7', 'Cost Center'); //QTY



// set format
//$SI->getStyle('A10:BQ11')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_MYMINUS);
//SET style

$SI->getStyle('A7:K7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$SI->getStyle('A7:K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

//set style font
$SI->getStyle('A1:A7')->getFont()->setBold(true);
$SI->getStyle('A7:K7')->getFont()->setBold(true);


 $alphabet = array( 'A', 'B', 'C', 'D', 'E',
                       'F', 'G', 'H', 'I', 'J',
                       'K', 'L', 'M', 'N', 'O',
                       'P', 'Q', 'R', 'S', 'T',
                       'U', 'V', 'W', 'X', 'Y',
                       'Z',
					   'AA', 'AB', 'AC', 'AD', 'AE',
                       'AF', 'AG', 'AH', 'AI', 'AJ',
                       'AK', 'AL', 'AM', 'AN', 'AO',
                       'AP', 'AQ', 'AR', 'AS', 'AT',
                       'AU', 'AV', 'AW', 'AX', 'AY',
                       'AZ',
					   'BA', 'BB', 'BC', 'BD', 'BE',
                       'BF', 'BG', 'BH', 'BI', 'BJ',
                       'BK', 'BL', 'BM', 'BN', 'BO',
                       'BP', 'BQ', 'BR', 'BS', 'BT',
                       'BU', 'BV', 'BW', 'BX', 'BY',
                       'BZ',
					   'CA', 'CB', 'CC', 'CD', 'CE',
                       'CF', 'CG', 'CH', 'CI', 'CJ',
                       'CK', 'CL', 'CM', 'CN', 'CO',
                       'CP', 'CQ', 'CR', 'CS', 'CT',
                       'CU', 'CV', 'CW', 'CX', 'CY',
                       'CZ',
					   'DA', 'DB', 'DC', 'DD', 'DE',
                       'DF', 'DG', 'DH', 'DI', 'DJ',
                       'DK', 'DL', 'DM', 'DN', 'DO',
                       'DP', 'DQ', 'DR', 'DS', 'DT',
                       'DU', 'DV', 'DW', 'DX', 'DY',
                       'DZ',
					   'EA', 'EB', 'EC', 'ED', 'EE',
                       'EF', 'EG', 'EH', 'EI', 'EJ',
                       'EK', 'EL', 'EM', 'EN', 'EO',
                       'EP', 'EQ', 'ER', 'ES', 'ET',
                       'EU', 'EV', 'EW', 'EX', 'EY',
                       'EZ',
					   'FA', 'FB', 'FC', 'FD', 'FE',
                       'FF', 'FG', 'FH', 'FI', 'FJ',
                       'FK', 'FL', 'FM', 'FN', 'FO',
                       'FP', 'FQ', 'FR', 'FS', 'FT',
                       'FU', 'FV', 'FW', 'FX', 'FY',
                       'FZ'
                       );
					   
					   
$tgl31=$tahunnya."-07-01";
$column=15;

$bariscolp=11;
						
	

$Qry1="SELECT distinct case when carline='ALL' then 'Allocation' else 'Direct Charging' end as parameter,hfm_code,hfm_desc,case when sub_acc='OPEX' then 'GENERAL' else 'PRODUCTION' end + '-' + category as purpose,commodity,dest,carline,periode,cccode,sum(price*qty/kurs) as amount from bps_budget_stp where term='$term_s' and revisi='$rev_s' and qty>0 group by carline,hfm_code,hfm_desc,category,sub_acc,commodity,dest,periode,cccode order by periode,carline,hfm_code,hfm_desc,commodity,dest,cccode";

$baris  = 8; //Ini untuk dimulai baris datanya

		$tb_part=odbc_exec($koneksi_lp,$Qry1);
//echo $Qry1;
		$row=0;
		$row2=0;

				while($baris1=odbc_fetch_array($tb_part)){
					$row++;
					
						$parameter=odbc_result($tb_part,"parameter");
						$hfm_code=odbc_result($tb_part,"hfm_code");
						$hfm_desc=odbc_result($tb_part,"hfm_desc");
						$purpose=odbc_result($tb_part,"purpose");
						$commodity=odbc_result($tb_part,"commodity");
						$dest=odbc_result($tb_part,"dest");
						$carline=odbc_result($tb_part,"carline");
						$periode=odbc_result($tb_part,"periode"); 
						$period=substr($periode,0,4).'-'.substr($periode,4,2);
						$amount=odbc_result($tb_part,"amount");
						$cccode=odbc_result($tb_part,"cccode");
						
						
						$SI->setCellValueByColumnAndRow(0,$baris,$row);
						$SI->setCellValueByColumnAndRow(1,$baris,$parameter);
						$SI->setCellValueByColumnAndRow(2,$baris,$hfm_code); 
						$SI->setCellValueByColumnAndRow(3,$baris,$hfm_desc); 
						$SI->setCellValueByColumnAndRow(4,$baris,$purpose); 
						$SI->setCellValueByColumnAndRow(5,$baris,$commodity); 
						$SI->setCellValueByColumnAndRow(6,$baris,$dest); 
						$SI->setCellValueByColumnAndRow(7,$baris,$carline); 
						
						$SI->setCellValueByColumnAndRow(8,$baris,$period); 
						$SI->setCellValueByColumnAndRow(9,$baris,$amount); 
						$SI->setCellValueByColumnAndRow(10,$baris,$cccode); 
						
						
					
					


						$baris++;
											
				}
				


$baris11  = $baris-1;
		
						$SI->getStyle('A7:K'.$baris11)->getBorders()->getAllBorders() ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						$SI->getStyle('J8:J'.$baris11)->getNumberFormat()->setFormatCode('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');
						
	
$SI->getStyle('A7:A'.$baris11)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$SI->getStyle('A7:A'.$baris11)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

$SI->getStyle('J8:J'.$baris11)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$SI->getStyle('J8:J'.$baris11)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 


//Memberi nama sheet
$excelku->getActiveSheet()->setTitle($Jdl);
$excelku->setActiveSheetIndex(0);


// untuk excel 2007 atau yang berekstensi .xlsx
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='.$Jdl.'.xlsx');
header('Cache-Control: max-age=0');
 $styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);


$objWriter = PHPExcel_IOFactory::createWriter($excelku, 'Excel2007');
//this line is necessary to display chart in excel
$objWriter->setIncludeCharts(TRUE);
$objWriter->save('php://output');
exit;

?>