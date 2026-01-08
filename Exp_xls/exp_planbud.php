<?php
/*******************************************
    Export Excel dengan PHPExcel
    ******************************************/
    session_start();

    include "../koneksi.php";
    include "PHPExcel.php";

    date_default_timezone_set("Asia/Jakarta");
    $excelku = new PHPExcel();
    $GAS=$excelku->getActiveSheet();
    $sect=$_GET['s'];
    $term=$_GET['t'];
// Set properties
    $excelku->getProperties()->setCreator("BPS SAMI")
    ->setLastModifiedBy("BPS SAMI");
// Set lebar kolom
$GAS->getColumnDimension('A')->setWidth(5);//NO
$GAS->getColumnDimension('B')->setWidth(10);//SECT
$GAS->getColumnDimension('C')->setWidth(15);//PART NUMBER
$GAS->getColumnDimension('D')->setWidth(25);//PART NAME
$GAS->getColumnDimension('E')->setWidth(30);//DETAIL PART
$GAS->getColumnDimension('F')->setWidth(10);//ACC NO
$GAS->getColumnDimension('G')->setWidth(30);//DESCRIPTION ACC
$GAS->getColumnDimension('H')->setWidth(20);//CARLINE
$GAS->getColumnDimension('I')->setWidth(20);//QTY
$GAS->getColumnDimension('J')->setWidth(15);//AVG QTY
$GAS->getColumnDimension('K')->setWidth(15);//CURR

$SI = $excelku->setActiveSheetIndex(0);
$Jdl='PLAN_BUDGET_'.$sect.'_Term-'.$term;

$SI->setCellValue('A1', 'PT. Semarang Autocomp Manufacturing Indonesia'); //0
$SI->setCellValue('A2', "BUDGET EXPENSE FORM"); //0
$SI->setCellValue('A3', "TERM : ".$term);
$SI->setCellValue('A6', 'TERM'); 
$SI->setCellValue('B6', $term); //0
$SI->setCellValue('A7', "DEPARTMENT-SECTION : ");
$sectpch=explode("-",$sect);
$SI->setCellValue('A8', $sectpch[0]); //0
$SI->setCellValue('B8', $sectpch[1]); //0

$SI->setCellValue('A9', 'Download Time= '.date("Y-m-d H:i:s")); //0

$GAS->getStyle('A10:BO11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//$Qry="select k.KURS,(a.price/k.KURS)[prc_usd],a.*,c.ACC_DESC,e.carline,e.CARMAKER from bps_budget_FA a full join LP_ACC c on c.ACC_NO=a.account full join bps_part d on a.part_no=d.part_no and a.part_nm=d.part_nm full join LP_CV e on a.cccode=e.CV_CODE full join bps_kurs k on a.curr=k.KURS_CODE and a.term=k.TERM where a.sect='$sect' AND a.TERM='$term' order by a.phase,a.periode,a.no_ctrl asc";
$Qry="select distinct (nvarchar(20),a.price) + ' ' + a.sect + ' ' + a.part_no + ' ' + a.account + ' ' + a.phase + ' ' + a.cccode + ' ' + a.uom + ' ' + a.curr + ' ' +' ' + e.carline )[ganti],(a.price/k.KURS)[prc_usd],sum(a.qty)[qty],a.periode,a.price,a.sect,a.part_no,a.part_nm,a.part_dtl,a.account,a.phase,a.cccode,a.uom,a.curr,k.KURS,c.ACC_DESC,e.carline,e.CARMAKER from bps_budget_FA a full join LP_ACC c on c.ACC_NO=a.account full join bps_part d on a.part_no=d.part_no and a.part_nm=d.part_nm full join LP_CV e on a.cccode=e.CV_CODE full join bps_kurs k on a.curr=k.KURS_CODE and a.term=k.TERM where a.sect='$sect' AND a.TERM='$term' group by a.periode,a.price,a.sect,a.part_no,a.part_nm,a.part_dtl,a.account,a.phase,a.cccode,a.uom,a.curr,k.KURS,c.ACC_DESC,e.carline,e.CARMAKER
order by a.phase,a.part_no,a.account,a.uom,a.curr asc";
$baris  = 12; //Ini untuk dimulai baris datanya
$no     = 1;
$bar=0;
$bul='';$qbul=0;$pbul=0;$abul=0;
echo $Qry;
$tb_part=odbc_exec($koneksi_lp,$Qry);
$row=0;		
$ary_bulan=explode("|","periode|07|08|09|10|11|12|01|02|03|04|05|06");	
$ary_prcori=explode("|","Price|14|15|16|17|18|19|20|21|22|23|24|25");	
$ary_prcusd=explode("|","Price USD|26|27|28|29|30|31|32|33|34|35|36|37");	
$ary_qty=explode("|","Qty|38|39|40|41|42|43|44|45|46|47|48|49|50|51");	
$ary_amtusd=explode("|","Amount USD|53|54|55|56|57|58|59|60|61|62|63|64|65|66");

$SI->setCellValueByColumnAndRow(0,10,"SECTION");
$SI->setCellValueByColumnAndRow(1,10,"BUDGET REF NO");
$SI->setCellValueByColumnAndRow(2,10,"PART_NO");
$SI->setCellValueByColumnAndRow(3,10,"PART  NAME");
$SI->setCellValueByColumnAndRow(4,10,"DETAIL PART");
$SI->setCellValueByColumnAndRow(5,10,"SECTION CATEGORY");
$SI->setCellValueByColumnAndRow(6,10,"ACC NO.");
$SI->setCellValueByColumnAndRow(7,10,"ACCOUNT DESCRIPTION");
$SI->setCellValueByColumnAndRow(8,10,"CATEGORY");
$SI->setCellValueByColumnAndRow(9,10,"COST CENTER");
$SI->setCellValueByColumnAndRow(10,10,"CARLINE");
$SI->setCellValueByColumnAndRow(11,10,"CARMAKER");
$SI->setCellValueByColumnAndRow(12,10,"UOM");	
$SI->setCellValueByColumnAndRow(13,10,"ORG CURR");	
$SI->setCellValueByColumnAndRow(14,10,"PRICE ORG");	
$SI->setCellValueByColumnAndRow(26,10,"PRICE USD");
$SI->setCellValueByColumnAndRow(38,10,"QTY");
$SI->setCellValueByColumnAndRow(50,10,"TOTAL");
$SI->setCellValueByColumnAndRow(51,10,"AVERAGE");
$SI->setCellValueByColumnAndRow(53,10,"AMOUNT USD");
$SI->setCellValueByColumnAndRow(65,10,"TOTAL");	
$SI->setCellValueByColumnAndRow(66,10,"AVERAGE");	

$prc=0;$prc_usd=0;$qty=0;
$gantibar="";$kisi=0;$jmqty=0;$jmamt=0;$avgqty=0;$avgamt=0;	$row=0;
while($baris1=odbc_fetch_array($tb_part)){
	$row++;
	$prc=0;$prc_usd=0;$qty=0;			
	for ($n=1; $n<=12; $n++){
		$prc=0;$prc_usd=0;$qty=0;
		$periode=odbc_result($tb_part,'periode');
		$bul_periode=substr($periode,5,2);
		$kol_bulan=$ary_bulan[$n];
		$kol_prcori=number_format($ary_prcori[$n],0,"","");
		$kol_prcusd=number_format($ary_prcusd[$n],0,"","");
		$kol_qty=number_format($ary_qty[$n],0,"","");
		$kol_amtusd=number_format($ary_amtusd[$n],0,"","");

		if($row==1){
			$SI->setCellValueByColumnAndRow($kol_prcori,11,$ary_bulan[$n]);	
			$SI->setCellValueByColumnAndRow($kol_prcusd,11,$ary_bulan[$n]);
			$SI->setCellValueByColumnAndRow($kol_qty,11,$ary_bulan[$n]);
			$SI->setCellValueByColumnAndRow($kol_amtusd,11,$ary_bulan[$n]);
		}

		if($bul_periode==$kol_bulan){
			$prc=number_format(odbc_result($tb_part,'price'),20,".","");
			$prc_usd=number_format(odbc_result($tb_part,'prc_usd'),20,".","");
			$qty=number_format(odbc_result($tb_part,'qty'),0,".","");
			$amt=$prc_usd * $qty ;

			$SI->setCellValueByColumnAndRow($kol_prcori,$baris,$prc);
			$SI->setCellValueByColumnAndRow($kol_prcusd,$baris,$prc_usd);
			$SI->setCellValueByColumnAndRow($kol_qty,$baris,$qty);
			$SI->setCellValueByColumnAndRow($kol_amtusd,$baris,$amt);
			$jmqty=$jmqty+$qty;
			$jmamt=$jmamt+$amt;
			$kisi++;
		}
	}

	if($gantibar != odbc_result($tb_part,'ganti')){	
		$SI->setCellValueByColumnAndRow(0,$baris,odbc_result($tb_part,'sect'));
$SI->setCellValueByColumnAndRow(1,$baris,odbc_result($tb_part,'ganti'));//kolom B kosong
$SI->setCellValueByColumnAndRow(2,$baris,odbc_result($tb_part,'part_no')); 
$SI->setCellValueByColumnAndRow(3,$baris,odbc_result($tb_part,'part_nm')); 
$SI->setCellValueByColumnAndRow(4,$baris,odbc_result($tb_part,'part_dtl')); 
//kolom F tidak ada data
$SI->setCellValueByColumnAndRow(6,$baris,odbc_result($tb_part,'account')); 
$SI->setCellValueByColumnAndRow(7,$baris,odbc_result($tb_part,'acc_desc'));
$SI->setCellValueByColumnAndRow(8,$baris,odbc_result($tb_part,'phase')); 
$SI->setCellValueByColumnAndRow(9,$baris,odbc_result($tb_part,'cccode')); 
$SI->setCellValueByColumnAndRow(10,$baris,odbc_result($tb_part,'carline')); 
$SI->setCellValueByColumnAndRow(11,$baris,odbc_result($tb_part,'CARMAKER')); 
$SI->setCellValueByColumnAndRow(12,$baris,odbc_result($tb_part,'uom'));
$SI->setCellValueByColumnAndRow(13,$baris,odbc_result($tb_part,'curr'));


$SI->setCellValueByColumnAndRow($kol_qty+1,$baris,$jmqty);
$SI->setCellValueByColumnAndRow($kol_amtusd+1,$baris,$jmamt);
if($kisi>0){
	$avgqty=$jmqty/$kisi;
	$avgamt=$jmamt/$kisi;
	$SI->setCellValueByColumnAndRow($kol_qty+2,$baris,$avgqty);
	$SI->setCellValueByColumnAndRow($kol_amtusd+2,$baris,$avgamt);
}
$kisi=0;$jmqty=0;$jmamt=0;$avgqty=0;$avgamt=0;	
$baris++;
$gantibar = odbc_result($tb_part,'ganti');
}

}
//marge cell
$GAS->mergeCells('A10:A11');
$GAS->mergeCells('B10:B11');
$GAS->mergeCells('C10:C11');
$GAS->mergeCells('D10:D11');
$GAS->mergeCells('E10:E11');
$GAS->mergeCells('F10:F11');
$GAS->mergeCells('G10:G11');
$GAS->mergeCells('H10:H11');
$GAS->mergeCells('I10:I11');
$GAS->mergeCells('J10:J11');
$GAS->mergeCells('K10:K11');
$GAS->mergeCells('L10:L11');
$GAS->mergeCells('M10:M11');
$GAS->mergeCells('N10:N11');
$GAS->mergeCells('AY10:AY11');
$GAS->mergeCells('AZ10:AZ11');
$GAS->mergeCells('BN10:BN11');
$GAS->mergeCells('BO10:BO11');

$GAS->mergeCells('O10:Z10');
$GAS->mergeCells('AA10:AL10');
$GAS->mergeCells('AM10:AX10');
$GAS->mergeCells('BB10:BM10');

$GAS->getStyle("A10:BO11")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$GAS->getStyle("A10:BO11")->getAlignment()->setWrapText(true);
//format cell
$currencyFormat = '_(#,##0.00_);_((#,##0.00);_("-"??_);_(@_)';
$range_prc="O12:AM".$baris;
$GAS->getStyle($range_prc)->getNumberFormat()->setFormatCode($currencyFormat);
$range_amo="BB12:BO".$baris;
$GAS->getStyle($range_amo)->getNumberFormat()->setFormatCode($currencyFormat);
$range_qty="AM12:AX".$baris;
$GAS->getStyle($range_qty)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

$GAS->mergeCells('A'.$baris.':N'.$baris);
$SI->setCellValueByColumnAndRow(0,$baris,"Jumlah Data : ".$row); 

//Membuat garis di body tabel (isi data)
//$excelku->getActiveSheet()->setSharedStyle($bodyStylenya, "A4 : G4");

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
$blk_range="A10:AZ".$baris;
$excelku->getActiveSheet()->getStyle($blk_range)->applyFromArray($styleArray);
$blk_range2="BB10:BO".$baris;
$excelku->getActiveSheet()->getStyle($blk_range2)->applyFromArray($styleArray);
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