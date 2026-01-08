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
    // $sect="";
    if($sec=="all" or $sec==""){$sect="" ;}else{$sect=" and a.sect='$sec' ";}
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
$excelku->getActiveSheet()->getColumnDimension('A')->setWidth(20);//SECTION
$excelku->getActiveSheet()->getColumnDimension('B')->setWidth(15);//PART_NO
$excelku->getActiveSheet()->getColumnDimension('C')->setWidth(15);//PART  NAME
$excelku->getActiveSheet()->getColumnDimension('D')->setWidth(15);//DETAIL PART
$excelku->getActiveSheet()->getColumnDimension('E')->setWidth(35);//ACC NO.
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(15);//ACCOUNT DESCRIPTION
$excelku->getActiveSheet()->getColumnDimension('G')->setWidth(25);//CATEGORY
$excelku->getActiveSheet()->getColumnDimension('H')->setWidth(15);//COST CENTER
$excelku->getActiveSheet()->getColumnDimension('I')->setWidth(20);//CARLINE
$excelku->getActiveSheet()->getColumnDimension('J')->setWidth(20);//CAR MAKER
$excelku->getActiveSheet()->getColumnDimension('K')->setWidth(10);//UOM
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
$excelku->getActiveSheet()->getColumnDimension('V')->setWidth(20);//ACTION
$excelku->getActiveSheet()->getColumnDimension('W')->setWidth(20);//PIC
$excelku->getActiveSheet()->getColumnDimension('X')->setWidth(20);//D-D
//$excelku->getActiveSheet()->getColumnDimension('Y')->setWidth(20);//PR No

// Set text center untuk kolom 
$excelku->getActiveSheet()->getStyle('A7:Z9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Mergecell, menyatukan beberapa kolom
$excelku->getActiveSheet()->mergeCells('A7:A9');
$excelku->getActiveSheet()->mergeCells('B7:B9');
$excelku->getActiveSheet()->mergeCells('C7:C9');
$excelku->getActiveSheet()->mergeCells('D7:D9');
$excelku->getActiveSheet()->mergeCells('E7:E9');
$excelku->getActiveSheet()->mergeCells('F7:F9');
$excelku->getActiveSheet()->mergeCells('G7:G9');
$excelku->getActiveSheet()->mergeCells('H7:H9');
$excelku->getActiveSheet()->mergeCells('I7:I9');
$excelku->getActiveSheet()->mergeCells('J7:J9');
$excelku->getActiveSheet()->mergeCells('K7:K9');
$excelku->getActiveSheet()->mergeCells('L7:L9');
$excelku->getActiveSheet()->mergeCells('M7:O7');
$excelku->getActiveSheet()->mergeCells('P7:R7');
$excelku->getActiveSheet()->mergeCells('S7:U7');
$excelku->getActiveSheet()->mergeCells('V7:V9');
$excelku->getActiveSheet()->mergeCells('W7:W9');
$excelku->getActiveSheet()->mergeCells('X7:X9');
$excelku->getActiveSheet()->mergeCells('Y7:Y9');
$excelku->getActiveSheet()->mergeCells('Z7:Z9');
//$excelku->getActiveSheet()->mergeCells('Y7:Y9');

//$excelku->getActiveSheet()->mergeCells('A2:G2');

// Buat Kolom judul tabel
$SI = $excelku->setActiveSheetIndex(0);
$Jdl='EXPENSE_BUDGET_REPORT_予算統制報告';
$Jdl2='Actual_Budget_Exp';

$SI->setCellValue('A1', 'PT. Semarang Autocomp Manufacturing Indonesia'); //0
$SI->setCellValue('A2', $Jdl); //0
$SI->setCellValue('A3', 'PERIOD : 月度：  '.$period); //0
$SI->setCellValue('A4', 'DEPT : 部署名：  '.$sec); //0
$SI->setCellValue('A6', 'Download Time= '.date("Y-m-d H:i:s")); //0
$SI->setCellValue('A7', 'SECTION セク ション'); //0
$SI->setCellValue('B7', 'NO CONTROL'); //1;
$SI->setCellValue('C7', 'PART_NO'); //1;
$SI->setCellValue('D7', 'PART  NAME'); //2;
$SI->setCellValue('E7', 'DETAIL PART'); //3;
$SI->setCellValue('F7', 'ACC NO.'); //4;
$SI->setCellValue('G7', 'ACCOUNT DESCRIPTION'); //5;
$SI->setCellValue('H7', 'CATEGORY'); //6;
$SI->setCellValue('I7', 'COST CENTER'); //7;
$SI->setCellValue('J7', 'CARLINE'); //8;
$SI->setCellValue('K7', 'CARMAKER'); //9;
$SI->setCellValue('L7', 'UOM'); //10;
$SI->setCellValue('M7', 'STP (A) 実計'); //11;
$SI->setCellValue('M8', 'QTY 数量'); //11;
$SI->setCellValue('N8', 'PRICE 単価'); //11;
$SI->setCellValue('N9', 'USD'); //11;
$SI->setCellValue('O8', 'AMOUNT 金額'); //11;
$SI->setCellValue('O9', 'USD'); //11;
$SI->setCellValue('P7', 'ACTUAL (B) 実績'); //11;
$SI->setCellValue('P8', 'QTY 数量'); //11;
$SI->setCellValue('Q8', 'PRICE 単価'); //11;
$SI->setCellValue('Q9', 'USD'); //11;
$SI->setCellValue('R8', 'AMOUNT 金額'); //11;
$SI->setCellValue('R9', 'USD'); //11;
$SI->setCellValue('S7', 'DIFFERENCE (B-A) 差異'); //11;
$SI->setCellValue('S8', 'QTY 数量'); //11;
$SI->setCellValue('T8', 'PRICE 単価'); //11;
$SI->setCellValue('T9', 'USD'); //11;
$SI->setCellValue('U8', 'AMOUNT 金額'); //11;
$SI->setCellValue('U9', 'USD'); //11;
$SI->setCellValue('V7', 'Reason 理由'); //12;
$SI->setCellValue('W7', 'Action 対策'); //13;
$SI->setCellValue('X7', 'PIC 担当者'); //14;
$SI->setCellValue('Y7', 'Due Date 納期'); //15;
$SI->setCellValue('Z7', 'Periode'); //15;


$Qry="select distinct  a.term,a.periode,a.sect,a.no_ctrl,a.part_no,a.part_nm,a.part_dtl,
a.part_desc,a.account,c.ACC_DESC,a.phase,a.cccode as cc_codeA,(case when b.cccode is null then a.cccode else b.cccode end)as cc_codeB,d.CARLINE,
d.CARMAKER,a.qty as qty_plan,
isnull(sum(b.Qty),0) as qty_act, a.uom,a.curr,dbo.lp_konprc(a.term,'USD',a.curr,a.price)
as price_plan ,dbo.lp_konprc(a.term,'USD',a.curr,a.price*a.qty) as amn_p , 
isnull(dbo.lp_konprc (b.term,'USD',b.curr,b.price),0) as price_act,
dbo.lp_konprc (b.term,'USD',b.curr,b.price*sum(b.Qty)) as amn_a from bps_budget a 
full join bps_pr b on a.periode=b.periode and a.sect=b.sect and a.no_ctrl=b.no_ctrl
full join LP_ACC c on a.account=c.ACC_NO full join LP_CV d on b.cccode=d.cv_code and a.term=d.term
where a.term='$term' $sect $per
group by a.term, a.periode, a.sect,a.no_ctrl, a.part_no, a.part_nm, a.part_dtl,a.part_desc,
a.account, c.ACC_DESC, a.phase, a.cccode, d.CARLINE, d.CARMAKER, a.uom, a.curr,
a.price,b.price,a.qty,b.curr,b.term,b.cccode 
order by a.sect,a.periode,a.part_no asc ";

/*$Qry="select distinct  a.term,a.periode,a.sect,a.no_ctrl,a.part_no,a.part_nm,a.part_dtl,
a.part_desc,a.account,c.ACC_DESC,a.phase,a.cccode as cc_codeA,b.cccode as cc_codeB,d.CARLINE,
d.CARMAKER,a.qty as qty_plan,
isnull(sum(b.Qty),0) as qty_act, a.uom,a.curr,dbo.lp_konprc(a.term,'USD',a.curr,a.price)
as price_plan ,dbo.lp_konprc(a.term,'USD',a.curr,a.price*sum(a.qty)) as amn_p , 
isnull(dbo.lp_konprc (b.term,'USD',b.curr,b.price),0) as price_act,
dbo.lp_konprc (b.term,'USD',b.curr,b.price*sum(b.Qty)) as amn_a from bps_budget a 
full join bps_pr b on a.periode=b.periode and a.sect=b.sect and a.no_ctrl=b.no_ctrl
full join LP_ACC c on a.account=c.ACC_NO full join LP_CV d on b.cccode=d.cv_code and a.term=d.term
where a.term='$term' $sect $per
group by a.term, a.periode, a.sect,a.no_ctrl, a.part_no, a.part_nm, a.part_dtl,a.part_desc,
a.account, c.ACC_DESC, a.phase, a.cccode, d.CARLINE, d.CARMAKER, a.uom, a.curr,
a.price,b.price,a.qty,b.curr,b.term,b.cccode 
order by a.sect,a.periode,a.part_no asc ";
*/
// echo $Qry;
// echo $Qry;
//$SI->setCellValue('A5',"qry cek= ".$Qry); //cek QRY
$tb_part=odbc_exec($koneksi_lp,$Qry);
$row=0;	$nkol=10; $baris  = 0; //Ini untuk dimulai baris datanya	
$Tqty_p=0;$Tqty_a=0;$Tamn_p=0;$Tamn_a=0;$Tamn_pk=0;
while($baris1=odbc_fetch_array($tb_part)){
	$row++;
	$no_ctrl=odbc_result($tb_part,'no_ctrl');
	$term=odbc_result($tb_part,'term');
	$periode=odbc_result($tb_part,'periode');
	$section=odbc_result($tb_part,'sect');
	$part_no=odbc_result($tb_part,'part_no');
	$part_nm=odbc_result($tb_part,'part_nm');
	$part_dtl=odbc_result($tb_part,'part_dtl');
	$part_desc=odbc_result($tb_part,'part_desc');
	$account=odbc_result($tb_part,'account');
	$ACC_DESC=odbc_result($tb_part,'ACC_DESC');
	$phase=odbc_result($tb_part,'phase');
	$cccodeA=odbc_result($tb_part,'cc_codeA');	
	$cccodeB=odbc_result($tb_part,'cc_codeB');
	if($cccodeB==""){$cv_code=$cccodeA;}else{$cv_code=$cccodeB;}

	$cr_cv=odbc_exec($koneksi_lp,"select top 1 CARLINE,CARMAKER,count(CARMAKER) as jml from LP_CV 
		where CV_CODE='$cv_code' group by CARLINE,CARMAKER ");
	$jml_row=odbc_result($cr_cv, 'jml');
	$car_db="";
	$maker_db="";
	if($jml_row>0){
		$car_db=odbc_result($cr_cv, 'CARLINE');
		$maker_db=odbc_result($cr_cv, 'CARMAKER');
	}

	$car_act=odbc_result($tb_part,'carline');
	$maker_act=odbc_result($tb_part,'CARMAKER');

	if($car_act==""){
		$carline=$car_db;
	}else if($car_db=="" && $car_act==""){
		$carline=$cv_code;
	}else{
		$carline=$car_act;
	}

	if($maker_act==""){
		$CARMAKER=$maker_db;
	}else if($maker_db=="" and $maker_act==""){
		$CARMAKER=$cv_code;
	}else{
		$CARMAKER=$maker_act;
	}

	$qty_plan=odbc_result($tb_part,'qty_plan');
	$qty_act=odbc_result($tb_part,'qty_act');
	$uom=odbc_result($tb_part,'uom');
	$curr=odbc_result($tb_part,'curr');
	$price_p=odbc_result($tb_part,'price_plan');
	$price_a=odbc_result($tb_part,'price_act');
	$amn_p=odbc_result($tb_part,'amn_p');
	$amn_a=odbc_result($tb_part,'amn_a');

	// $price_p=round(odbc_result($tb_part,'price_plan'),3);
	// $price_a=round(odbc_result($tb_part,'price_act'),3);
	// $amn_p=round(odbc_result($tb_part,'amn_p'),3);
	// $amn_a=round(odbc_result($tb_part,'amn_a'),3);
	
	//PEMAKAIAN
	$cr_stts=odbc_exec($koneksi_lp,"select top 1 b.status from bps_PR a left join bps_approve b on a.pr_no=b.no_doc and a.sect=b.sect where no_ctrl='$no_ctrl' order by b.status desc");
	$stt_doc=odbc_result($cr_stts,'status');
	
	if($stt_doc!='FINISH' or $stt_doc==''){$qty_pk=0;} else if($qty_act>$qty_plan){$qty_pk=$qty_plan;}else{$qty_pk=$qty_act;}
	if($stt_doc!='FINISH' or $stt_doc==''){$price_pk=0;} else if($price_a>$price_p){$price_pk=$price_p;}else{$price_pk=$price_a;}
	
	$Tqty_p=$Tqty_p+$qty_plan;
	$Tqty_a=$Tqty_a+$qty_pk;
	$amn_pk=$qty_pk*$price_pk;
	
	$Tamn_p=$Tamn_p+$amn_p;
	$Tamn_a=$Tamn_a+$amn_a;
	$Tamn_pk=$Tamn_pk+$amn_pk;
	
	$SI->setCellValueByColumnAndRow($baris,$nkol,$section);
	$SI->setCellValueByColumnAndRow($baris+1,$nkol,$no_ctrl);
	$SI->setCellValueByColumnAndRow($baris+2,$nkol,$part_no);
	$SI->setCellValueByColumnAndRow($baris+3,$nkol,$part_nm);
	$SI->setCellValueByColumnAndRow($baris+4,$nkol,$part_dtl." ".$part_desc);
	$SI->setCellValueByColumnAndRow($baris+5,$nkol,$account);
	$SI->setCellValueByColumnAndRow($baris+6,$nkol,$ACC_DESC); 
	$SI->setCellValueByColumnAndRow($baris+7,$nkol,$phase); 
	$SI->setCellValueByColumnAndRow($baris+8,$nkol,$cv_code); 
	$SI->setCellValueByColumnAndRow($baris+9,$nkol,$carline);
	$SI->setCellValueByColumnAndRow($baris+10,$nkol,$CARMAKER); 
	$SI->setCellValueByColumnAndRow($baris+11,$nkol,$uom); 
	$SI->setCellValueByColumnAndRow($baris+12,$nkol,$qty_plan); 
	$SI->setCellValueByColumnAndRow($baris+13,$nkol,$price_p);
	$SI->setCellValueByColumnAndRow($baris+14,$nkol,$amn_p);
	$SI->setCellValueByColumnAndRow($baris+25,$nkol,$periode);

	$SI->setCellValueByColumnAndRow($baris+15,$nkol,$qty_pk); 
	$SI->setCellValueByColumnAndRow($baris+16,$nkol,$price_pk); 
	$SI->setCellValueByColumnAndRow($baris+17,$nkol,$amn_pk);

	$SI->setCellValueByColumnAndRow($baris+18,$nkol,$qty_pk-$qty_plan);
	$SI->setCellValueByColumnAndRow($baris+19,$nkol,$price_pk-$price_p);
	$SI->setCellValueByColumnAndRow($baris+20,$nkol,$amn_pk-$amn_p);
	$nkol++;
}
$akhir=$nkol+1;

$SI->setCellValueByColumnAndRow($baris+1,$nkol,'TOTAL 合計');
$excelku->getActiveSheet()->getStyle('B'.$baris+1)->getFont()->setBold(TRUE); 
	// Set bold kolom A1
$SI->setCellValueByColumnAndRow($baris+12,$nkol,$Tqty_p); 
$SI->setCellValueByColumnAndRow($baris+14,$nkol,$Tamn_p); 
$SI->setCellValueByColumnAndRow($baris+15,$nkol,$Tqty_a); 
$SI->setCellValueByColumnAndRow($baris+17,$nkol,$Tamn_pk)	;
$SI->setCellValueByColumnAndRow($baris+18,$nkol,$Tqty_a-$Tqty_p);
$SI->setCellValueByColumnAndRow($baris+20,$nkol,$Tamn_pk-$Tamn_p);

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
header('Content-Disposition: attachment;filename='.$Jdl2." ".$sec.'.xls');
header('Cache-Control: max-age=0');
$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);
$blk_range="A7:Z".$nkol;
$excelku->getActiveSheet()->getStyle($blk_range)->applyFromArray($styleArray);
unset($styleArray);
$objWriter = PHPExcel_IOFactory::createWriter($excelku, 'Excel2007');
$objWriter->save('php://output');
exit;
echo "<h3>EXPORT DATA ".$Jdl2." ".$sec." SUDAH SELESAI DENGAN JUMLAH DATA ".$row." BARIS</h3>";
?>