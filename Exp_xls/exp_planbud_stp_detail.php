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
if($sect_s=="ALL"){
	$sec_s="" ;
	$sec_sa="" ;
	} else {
		//$sect_s=" and sect='$sect_s' ";
		$sec_s=" and sect='$sect_s' ";
		$sec_sa=" and sect like '$sect_s%' ";
		}
$rev_s=$_GET['r'];
$lokasi=$_GET['f'];
$rev_s1="select max(revisi) as revisi from bps_budget_stp where term='$term_s'";
$tb_rev=odbc_exec($koneksi_lp,$rev_s1);
				while($baris1_rev=odbc_fetch_array($tb_rev)){
					$rev_s=odbc_result($tb_rev,"revisi");
				}
				

// Set properties
$excelku->getProperties()->setCreator("PLAN BUDGET STP SAMI-".$lokasi)
                         ->setLastModifiedBy("FA SAMI-JF");

	
// Set lebar kolom
$excelku->getActiveSheet()->getColumnDimension('A')->setWidth(8.50);
$excelku->getActiveSheet()->getColumnDimension('B')->setWidth(17.50);
$excelku->getActiveSheet()->getColumnDimension('C')->setWidth(17.50);
$excelku->getActiveSheet()->getColumnDimension('D')->setWidth(28.50);
$excelku->getActiveSheet()->getColumnDimension('E')->setWidth(50);
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(18.50);
$excelku->getActiveSheet()->getColumnDimension('G')->setWidth(13);
$excelku->getActiveSheet()->getColumnDimension('H')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('I')->setWidth(30);
$excelku->getActiveSheet()->getColumnDimension('J')->setWidth(19);
$excelku->getActiveSheet()->getColumnDimension('K')->setWidth(19);
$excelku->getActiveSheet()->getColumnDimension('L')->setWidth(19);
$excelku->getActiveSheet()->getColumnDimension('M')->setWidth(19);
$excelku->getActiveSheet()->getColumnDimension('N')->setWidth(10);
$excelku->getActiveSheet()->getColumnDimension('O')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('P')->setWidth(12);  // P SAMPAI BN 12
$excelku->getActiveSheet()->getColumnDimension('Q')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('R')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('S')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('T')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('U')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('V')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('W')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('X')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('Y')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('Z')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AA')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AB')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AC')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AD')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AE')->setWidth(12); //add
$excelku->getActiveSheet()->getColumnDimension('AF')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AG')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AH')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AI')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AJ')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AK')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AL')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AM')->setWidth(12); //add
$excelku->getActiveSheet()->getColumnDimension('AN')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AO')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AP')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AQ')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AR')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AS')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AT')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AU')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AV')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AW')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AX')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('AY')->setWidth(12); //add
$excelku->getActiveSheet()->getColumnDimension('AZ')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('BA')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('BB')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('BC')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('BD')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('BE')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('BF')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('BG')->setWidth(12); 
$excelku->getActiveSheet()->getColumnDimension('BH')->setWidth(12); //add
$excelku->getActiveSheet()->getColumnDimension('BI')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('BJ')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('BK')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('BL')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('BM')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('BN')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('BO')->setWidth(18);
$excelku->getActiveSheet()->getColumnDimension('BP')->setWidth(18);
$excelku->getActiveSheet()->getColumnDimension('BQ')->setWidth(18); //add

$excelku->getActiveSheet()->getColumnDimension('BR')->setWidth(9);
$excelku->getActiveSheet()->getColumnDimension('BS')->setWidth(9);
$excelku->getActiveSheet()->getColumnDimension('BT')->setWidth(9);
$excelku->getActiveSheet()->getColumnDimension('BU')->setWidth(9);
$excelku->getActiveSheet()->getColumnDimension('BV')->setWidth(9);
$excelku->getActiveSheet()->getColumnDimension('BW')->setWidth(9);
$excelku->getActiveSheet()->getColumnDimension('BX')->setWidth(9);
$excelku->getActiveSheet()->getColumnDimension('BY')->setWidth(9); //add
$excelku->getActiveSheet()->getColumnDimension('BZ')->setWidth(9);

//set tinggi row
$excelku->getActiveSheet()->getRowDimension('11')->setrowHeight(30);
$excelku->getActiveSheet()->getRowDimension('12')->setrowHeight(20.50);
/* $excelku->getActiveSheet()->getRowDimension('2')->setrowHeight(67.50);
$excelku->getActiveSheet()->getRowDimension('3')->setrowHeight(67.50);
$excelku->getActiveSheet()->getRowDimension('4')->setrowHeight(67.50);
$excelku->getActiveSheet()->getRowDimension('5')->setrowHeight(60);
$excelku->getActiveSheet()->getRowDimension('6')->setrowHeight(82.50);
$excelku->getActiveSheet()->getRowDimension('7')->setrowHeight(82.50);
$excelku->getActiveSheet()->getRowDimension('8')->setrowHeight(123.75);
$excelku->getActiveSheet()->getRowDimension('9')->setrowHeight(123.75);
$excelku->getActiveSheet()->getRowDimension('10')->setrowHeight(114.75);
*/

// Mergecell, menyatukan beberapa kolom
$excelku->getActiveSheet()->mergeCells('A10:A11');  
$excelku->getActiveSheet()->mergeCells('B10:B11');  
$excelku->getActiveSheet()->mergeCells('C10:C11');  
$excelku->getActiveSheet()->mergeCells('D10:D11');  
$excelku->getActiveSheet()->mergeCells('E10:E11');  
$excelku->getActiveSheet()->mergeCells('F10:F11');  
$excelku->getActiveSheet()->mergeCells('G10:G11');  
$excelku->getActiveSheet()->mergeCells('H10:H11');  
$excelku->getActiveSheet()->mergeCells('I10:I11');  
$excelku->getActiveSheet()->mergeCells('J10:J11');  
$excelku->getActiveSheet()->mergeCells('K10:K11');  
$excelku->getActiveSheet()->mergeCells('L10:L11');  
$excelku->getActiveSheet()->mergeCells('M10:M11');  
$excelku->getActiveSheet()->mergeCells('N10:N11');  
$excelku->getActiveSheet()->mergeCells('O10:O11');  
$excelku->getActiveSheet()->mergeCells('P10:AA10');  
$excelku->getActiveSheet()->mergeCells('AB10:AM10');  
$excelku->getActiveSheet()->mergeCells('AZ10:AZ11');  
$excelku->getActiveSheet()->mergeCells('BA10:BA11');  
$excelku->getActiveSheet()->mergeCells('BO10:BO11');  
$excelku->getActiveSheet()->mergeCells('BP10:BP11');  
$excelku->getActiveSheet()->mergeCells('BR10:BR11');  
$excelku->getActiveSheet()->mergeCells('BS10:BS11');  
$excelku->getActiveSheet()->mergeCells('BT10:BT11');  
$excelku->getActiveSheet()->mergeCells('BU10:BZ10');  


//set zoom view
//$excelku->getActiveSheet()->getSheetView()->setZoomScale(25);

// Buat Kolom judul tabel
$SI = $excelku->setActiveSheetIndex(0);
$Jdl='PLAN BUDGET SAMI-'.$lokasi;

$SI->setCellValue('A1', 'PT. SEMARANG AUTOCOMP MANUFACTURING INDONESIA'); 
$SI->setCellValue('A2', 'BUDGET EXPENSE FORM'); 

$SI->setCellValue('A4', 'DEPARTMENT-SECTION : '.$sect_s); //NANTI DIPINDAH KE VARIABEL SECTION
$SI->setCellValue('N2', 'EXCHANGE RATE TO USD'); 
/* $SI->setCellValue('N4', 'IDR'); 
$SI->setCellValue('N5', 'JPY'); 
$SI->setCellValue('N6', 'USD'); 
$SI->setCellValue('N7', 'EUR'); 
$SI->setCellValue('N8', 'CHF'); 
$SI->setCellValue('N9', 'THB'); */

$SI->setCellValue('A10', 'SECTION'); 
$SI->setCellValue('B10', 'BUDGET REF NO'); 
$SI->setCellValue('C10', 'PART_NO');
$SI->setCellValue('D10', 'PART  NAME');
$SI->setCellValue('E10', 'DETAIL PART');
$SI->setCellValue('F10', 'FUNGSI / TUJUAN');
$SI->setCellValue('G10', 'SECTION CATEGORY');
$SI->setCellValue('H10', 'ACC NO.');
$SI->setCellValue('I10', 'ACCOUNT DESCRIPTION');
$SI->setCellValue('J10', 'CATEGORY');
$SI->setCellValue('K10', 'COST CENTER');
$SI->setCellValue('L10', 'CARLINE');
$SI->setCellValue('M10', 'CARMAKER'); 
$SI->setCellValue('N10', 'UOM'); 
$SI->setCellValue('O10', 'ORG CURR'); 
$SI->setCellValue('P10', 'PRICE ORG CURR'); 
$SI->setCellValue('AB10', 'PRICE USD'); 
/*
$SI->setCellValue('P11'); 
$SI->setCellValue('Q11');
$SI->setCellValue('R11'); 
$SI->setCellValue('S11'); 
$SI->setCellValue('T11'); 
$SI->setCellValue('U11'); 
$SI->setCellValue('V11'); 
$SI->setCellValue('W11'); 
$SI->setCellValue('X11'); 
$SI->setCellValue('Y11'); 
$SI->setCellValue('Z11'); 	SET PRICE IDR AND USD RUMUS
$SI->setCellValue('AA11'); 
$SI->setCellValue('AB11'); 
$SI->setCellValue('AC11'); 
$SI->setCellValue('AD11'); 
$SI->setCellValue('AE11'); 
$SI->setCellValue('AF11'); 
$SI->setCellValue('AG11'); 
$SI->setCellValue('AH11'); 
$SI->setCellValue('AI11'); 
$SI->setCellValue('AJ11'); 
$SI->setCellValue('AK11'); 
$SI->setCellValue('AL11'); 
$SI->setCellValue('AM11');  */ 

$SI->setCellValue('AN11', 'QTY'); //QTY
$SI->setCellValue('AO11', 'QTY'); //QTY
$SI->setCellValue('AP11', 'QTY'); //QTY
$SI->setCellValue('AQ11', 'QTY'); //QTY
$SI->setCellValue('AR11', 'QTY'); //QTY
$SI->setCellValue('AS11', 'QTY'); //QTY
$SI->setCellValue('AT11', 'QTY'); //QTY
$SI->setCellValue('AU11', 'QTY'); //QTY
$SI->setCellValue('AV11', 'QTY'); //QTY
$SI->setCellValue('AW11', 'QTY'); //QTY
$SI->setCellValue('AX11', 'QTY'); //QTY
$SI->setCellValue('AY11', 'QTY'); //QTY

$SI->setCellValue('AZ10', 'TOTAL'); 
$SI->setCellValue('BA10', 'AVERAGE'); 
$SI->setCellValue('BB10'); // KOSONG
$SI->setCellValue('BC11', 'AMT'); //AMOUNT USD
$SI->setCellValue('BD11', 'AMT'); //AMOUNT USD
$SI->setCellValue('BE11', 'AMT'); //AMOUNT USD
$SI->setCellValue('BF11', 'AMT'); //AMOUNT USD
$SI->setCellValue('BG11', 'AMT'); //AMOUNT USD
$SI->setCellValue('BH11', 'AMT'); //AMOUNT USD
$SI->setCellValue('BI11', 'AMT'); //AMOUNT USD
$SI->setCellValue('BJ11', 'AMT'); //AMOUNT USD
$SI->setCellValue('BK11', 'AMT'); //AMOUNT USD
$SI->setCellValue('BL11', 'AMT'); //AMOUNT USD
$SI->setCellValue('BM11', 'AMT'); //AMOUNT USD
$SI->setCellValue('BN11', 'AMT'); //AMOUNT USD
$SI->setCellValue('BO10', 'TOTAL'); //TOTAL AMOUNT USD
$SI->setCellValue('BP10', 'AVERAGE'); //AVERAGE AMOUNT USD
 
$SI->setCellValue('BQ10'); //KOSONG
$SI->setCellValue('BR10', 'SUB ACCOUNT'); 
$SI->setCellValue('BS10', 'KODE PROSES'); 
$SI->setCellValue('BT10', 'PURCHASING'); 
$SI->setCellValue('BU10', 'LEADTIME');
$SI->setCellValue('BU11', 'PENAWARAN'); 
$SI->setCellValue('BV11', 'PR'); 
$SI->setCellValue('BW11', 'PO'); 
$SI->setCellValue('BX11', 'KEDATANGAN'); 
$SI->setCellValue('BY11', 'VP'); 
$SI->setCellValue('BZ11'); 

// set format
//$SI->getStyle('A10:BQ11')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_MYMINUS);
//SET style
$SI->getStyle('BR10:BZ11')->getAlignment()->setWrapText(true);
$SI->getStyle('G10')->getAlignment()->setWrapText(true);
$SI->getStyle('BR10:BZ11')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$SI->getStyle('BR10:BZ11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$SI->getStyle('A10:BQ11')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$SI->getStyle('A10:BQ11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//set style font
$SI->getStyle('A1:A5')->getFont()->setBold(true)->setName('Calibri')->setSize(10)->getColor()->setRGB('000000');
$SI->getStyle('P11:AM11')->getFont()->setBold(true)->setName('Calibri')->setSize(10)->getColor()->setRGB('000000');
$SI->getStyle('A10:BQ11')->getFont()->setBold(true)->setName('Calibri')->setSize(10)->getColor()->setRGB('000000');
$SI->getStyle('N2:O8')->getFont()->setBold(false)->setName('Calibri')->setSize(10)->getColor()->setRGB('000000');

//set fill
$SI->getStyle('A10:BA11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffff00');
$SI->getStyle('BC10:BQ11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffff00');
$SI->getStyle('N2:O8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('92CDDC');

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
						
						for($ii=0;$ii<=11;$ii++){
							$tglnya2=date("Ym",strtotime($tgl31."+$ii month"));
							$SI->setCellValueByColumnAndRow($column,$bariscolp,$tglnya2);
							$SI->setCellValueByColumnAndRow($column+12,$bariscolp,$tglnya2);
							$SI->setCellValueByColumnAndRow($column+24,$bariscolp-1,$tglnya2);
							$SI->setCellValueByColumnAndRow($column+39,$bariscolp-1,$tglnya2);
							
							$column++;
						}
						
						
$SI->setCellValue('A3', 'PERIODE ' .date("M-y",strtotime($tgl31)). ' SD ' .date("M-y",strtotime($tgl31."+11 month")) ); //NANTI DIPINDAH KE VARIABEL 
$tglnyacPRICE="";
$cari="";
for($ii=0;$ii<=11;$ii++){
	$tglnya2=date("Ym",strtotime($tgl31."+$ii month"));
		if($tglnyacPRICE==""){
			
			$tglnyacPRICE="[".$tglnya2."PRICE]";
			$tglnyacPRICEUSD="[".$tglnya2."PRICEUSD]";
			$tglnyacQTY="[".$tglnya2."QTY]";
			$tglnyacAMT="[".$tglnya2."AMT]";
			
		}else{
			$tglnyacPRICE=$tglnyacPRICE.",[".$tglnya2."PRICE]";
			$tglnyacPRICEUSD=$tglnyacPRICEUSD.",[".$tglnya2."PRICEUSD]";
			$tglnyacQTY=$tglnyacQTY.",[".$tglnya2."QTY]";
			$tglnyacAMT=$tglnyacAMT.",[".$tglnya2."AMT]";
			
		}
		$cari=$cari.",MAX([".$tglnya2."PRICE]) AS [".$tglnya2."PRICE],MAX([".$tglnya2."PRICEUSD]) AS  [".$tglnya2."PRICEUSD],MAX([".$tglnya2."QTY]) AS  [".$tglnya2."QTY],MAX([".$tglnya2."AMT]) AS  [".$tglnya2."AMT] ";
	}

$Qry1="select distinct  sect,part_no,part_dtl,uom,term,id_proses,jns_budget,lp,kurs,curr,phase,cccode,part_nm,revisi,fungsi,carline,carmaker,sub_acc,lt_vp,lt_datang,lt_po,lt_pr,lt_Quo,urut$cari from
 (
 select sect,part_no,part_dtl,uom,term,id_proses,jns_budget,lp,kurs,curr,phase,cccode,part_nm,revisi,fungsi,carline,carmaker,sub_acc,lt_vp,lt_datang,lt_po,lt_pr,lt_Quo,urut,convert(nvarchar(20),periode)+'PRICE' as periodeA,convert(nvarchar(20),periode)+'PRICEUSD' as periodeB,
convert(nvarchar(20),periode)+'QTY' as periodeC,convert(nvarchar(20),periode)+'AMT' as periodeD,sum(price) as price,sum(price/kurs) as priceUSD,sum(qty) as qty,SUM(qty*price/kurs) as amt
from bps_budget_stp where term='$term_s' and revisi='$rev_s' group by sect,part_no,part_dtl,uom,term,id_proses,jns_budget,lp,kurs,curr,phase,cccode,part_nm,revisi,fungsi,carline,carmaker,sub_acc,lt_vp,lt_datang,lt_po,lt_pr,lt_Quo,urut,periode
) t
PIVOT(
SUM(price)
FOR periodeA IN 
( ".$tglnyacPRICE.")
) as pivot_price

PIVOT(
SUM(priceUSD)
FOR periodeB IN 
( ".$tglnyacPRICEUSD.")
) as pivot_priceusd

PIVOT(
SUM(QTY)
FOR periodeC IN 
( ".$tglnyacQTY.")
) as pivot_qty

PIVOT(
SUM(amt)
FOR periodeD IN 
( ".$tglnyacAMT.")
) as pivot_amt

 where term='$term_s' $sec_s and revisi='$rev_s' 
 
group by sect,part_no,part_dtl,uom,term,id_proses,jns_budget,lp,kurs,curr,phase,cccode,part_nm,revisi,fungsi,carline,carmaker,sub_acc,lt_vp,lt_datang,lt_po,lt_pr,lt_Quo,urut ORDER BY sect,urut
";

$baris  = 13; //Ini untuk dimulai baris datanya

		$tb_part=odbc_exec($koneksi_lp,$Qry1);
//echo $Qry1;
		$row=0;
		$row2=0;

				while($baris1=odbc_fetch_array($tb_part)){
					$row++;
					
						$sect=odbc_result($tb_part,"sect");
						$part_no=odbc_result($tb_part,"part_no");
						$part_nm=odbc_result($tb_part,"part_nm");
						$part_dtl=odbc_result($tb_part,"part_dtl");
						$fungsi=odbc_result($tb_part,"fungsi");
						$sub_acc=odbc_result($tb_part,"sub_acc");
						$category=odbc_result($tb_part,"phase");
						$cccode=odbc_result($tb_part,"cccode"); 
						$carline=odbc_result($tb_part,"carline");
						$carmaker=odbc_result($tb_part,"carmaker");
						$uom=odbc_result($tb_part,"uom");
						$curr=odbc_result($tb_part,"curr");
						$term_s=odbc_result($tb_part,"term");
						$k_proses=odbc_result($tb_part,"id_proses");
						$lt_vp=odbc_result($tb_part,"lt_vp");
						$lt_datang=odbc_result($tb_part,"lt_datang");
						$lt_po=odbc_result($tb_part,"lt_po");
						$lt_pr=odbc_result($tb_part,"lt_pr");
						$lt_quo=odbc_result($tb_part,"lt_quo");
						$lp=odbc_result($tb_part,"lp");
						
						$SI->setCellValueByColumnAndRow(0,$baris,$sect);
						$SI->setCellValueByColumnAndRow(2,$baris,$part_no); 
						$SI->setCellValueByColumnAndRow(3,$baris,$part_nm); 
						$SI->setCellValueByColumnAndRow(4,$baris,$part_dtl); 
						$SI->setCellValueByColumnAndRow(5,$baris,$fungsi); 
						$SI->setCellValueByColumnAndRow(6,$baris,$sub_acc); 
						$SI->setCellValueByColumnAndRow(9,$baris,$category); 
						$SI->setCellValueByColumnAndRow(10,$baris,$cccode); 
						$SI->setCellValueByColumnAndRow(11,$baris,$carline); 
						$SI->setCellValueByColumnAndRow(12,$baris,$carmaker); 
						$SI->setCellValueByColumnAndRow(13,$baris,$uom); 
						$SI->setCellValueByColumnAndRow(14,$baris,$curr);
						$SI->setCellValueByColumnAndRow(70,$baris,$k_proses);
						$SI->setCellValueByColumnAndRow(71,$baris,$lp);
						$SI->setCellValueByColumnAndRow(72,$baris,$lt_quo);
						$SI->setCellValueByColumnAndRow(73,$baris,$lt_pr);
						$SI->setCellValueByColumnAndRow(74,$baris,$lt_po);
						$SI->setCellValueByColumnAndRow(75,$baris,$lt_datang);
						$SI->setCellValueByColumnAndRow(76,$baris,$lt_vp);
						
					
						$bariscol=13;
						$column1=15;
						
												for($i=0;$i<=11;$i++){
												
												
												$tglnyaPRICE=date("Ym",strtotime($tgl31."+$i month"))."PRICE";
												$tglnyaPRICEUSD=date("Ym",strtotime($tgl31."+$i month"))."PRICEUSD";
												$tglnyaQTY=date("Ym",strtotime($tgl31."+$i month"))."QTY";
												$tglnyaAMT=date("Ym",strtotime($tgl31."+$i month"))."AMT";
												
												$price=odbc_result($tb_part,$tglnyaPRICE);
												$priceusd=odbc_result($tb_part,$tglnyaPRICEUSD);
												$qty=odbc_result($tb_part,$tglnyaQTY);
												$amt=odbc_result($tb_part,$tglnyaAMT);
												
												if($price==""){
													$price=0;
												}
												if($priceusd==""){
													$priceusd=0;
												}
												if($qty==""){
													$qty=0;
												}
												
												if($amt==""){
													$amt=0;
												}
			
												$SI->setCellValueByColumnAndRow($column1,$baris,$price);
												$SI->setCellValueByColumnAndRow($column1+12,$baris,$priceusd);
												$SI->setCellValueByColumnAndRow($column1+24,$baris,$qty);
												$SI->setCellValueByColumnAndRow($column1+25,$baris,"=SUM(AN".$baris.":AY".$baris.")");
												$SI->setCellValueByColumnAndRow($column1+26,$baris,"=AZ".$baris."/12");
												$SI->setCellValueByColumnAndRow($column1+39,$baris,$amt);
												$SI->setCellValueByColumnAndRow($column1+40,$baris,"=SUM(BC".$baris.":BN".$baris.")");
												$SI->setCellValueByColumnAndRow($column1+41,$baris,"=BO".$baris."/12");
									
																							
												
												$column1++;
											}
						
					
						$SI->getStyle('A10:BA'.$baris)->getBorders()->getAllBorders() ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						$SI->getStyle('BC10:BZ'.$baris)->getBorders()->getAllBorders() ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


						$SI->getStyle('AB13:AM'.$baris)->getNumberFormat()->setFormatCode('#,##0.00'); 
						$SI->getStyle('AN13:AY'.$baris)->getNumberFormat()->setFormatCode('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');
						$SI->getStyle('BA13:BA'.$baris)->getNumberFormat()->setFormatCode('#,##0'); 
						$SI->getStyle('BC13:BP'.$baris)->getNumberFormat()->setFormatCode('_(* #,##0.0_);_(* (#,##0.0);_(* "-"??_);_(@_)'); 


						$baris++;
											
				}
				


$baris11  = 3;

$qry_kurs= "select distinct kurs_code,kurs,term from bps_kurs where term='$term_s' order by kurs desc";
//$tb_kurs=odbc_exec($koneksi_lp,"select * from bps_kurs where term='$term_s' order by kurs desc");
$tb_kurs=odbc_exec($koneksi_lp,$qry_kurs);
$row1=0;
		while($barisss=odbc_fetch_array($tb_kurs)){
			$row1++;
			$SI->setCellValueByColumnAndRow(13,$baris11,strtoupper(odbc_result($tb_kurs,"kurs_code"))); 
			$SI->setCellValueByColumnAndRow(14,$baris11,odbc_result($tb_kurs,"kurs"));
			
			$SI->getStyle('N2:O8')->getNumberFormat()->setFormatCode('_ * #,##0.00_ ;_ * -#,##0.00_ ;_ * "-"_ ;_ @_ '); 
			
		$baris11++;	
		}
			

	


//Memberi nama sheet
$excelku->getActiveSheet()->setTitle($Jdl);
$excelku->getActiveSheet()->getSheetView()->setZoomScale(70);
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
echo "<h3>EXPORT DATA ".$Jdl." SUDAH SELESAI DENGAN JUMLAH DATA ".$bar." BARIS</h3>";
echo $Qry;
?>