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
$excelku->getActiveSheet()->getColumnDimension('C')->setWidth(25);//PART  NAME
$excelku->getActiveSheet()->getColumnDimension('D')->setWidth(35);//DETAIL PART
$excelku->getActiveSheet()->getColumnDimension('E')->setWidth(20);//ACC NO.
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(25);//ACCOUNT DESCRIPTION
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
$excelku->getActiveSheet()->getColumnDimension('U')->setWidth(50);//REASON
$excelku->getActiveSheet()->getColumnDimension('V')->setWidth(50);//ACTION
$excelku->getActiveSheet()->getColumnDimension('W')->setWidth(20);//PIC
$excelku->getActiveSheet()->getColumnDimension('X')->setWidth(20);//D-D
$excelku->getActiveSheet()->getColumnDimension('Y')->setWidth(20);//PR No
$excelku->getActiveSheet()->getColumnDimension('Z')->setWidth(15);//PR No

// Set text center untuk kolom 
$excelku->getActiveSheet()->getStyle('A7:AD9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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
$excelku->getActiveSheet()->mergeCells('L7:N7');
$excelku->getActiveSheet()->mergeCells('O7:Q7');
$excelku->getActiveSheet()->mergeCells('R7:T7');
$excelku->getActiveSheet()->mergeCells('U7:U9');
$excelku->getActiveSheet()->mergeCells('V7:V9');
$excelku->getActiveSheet()->mergeCells('W7:W9');
$excelku->getActiveSheet()->mergeCells('X7:X9');
$excelku->getActiveSheet()->mergeCells('Y7:Y9');
$excelku->getActiveSheet()->mergeCells('Z7:Z9');
$excelku->getActiveSheet()->mergeCells('AA7:AA9');
$excelku->getActiveSheet()->mergeCells('AB7:AB9');
$excelku->getActiveSheet()->mergeCells('AC7:AC9');
$excelku->getActiveSheet()->mergeCells('AD7:AD9');


//$excelku->getActiveSheet()->mergeCells('A2:G2');

// Buat Kolom judul tabel
$SI = $excelku->setActiveSheetIndex(0);
$Jdl='EXPENSE_BUDGET_ADD_REPORT 予算統制報告';
$Jdl2='Actual_Budget_Add';

$SI->setCellValue('A1', 'PT. Semarang Autocomp Manufacturing Indonesia'); //0
$SI->setCellValue('A2', $Jdl); //0
$SI->setCellValue('A3', 'PERIOD : 月度：  '.$period); //0
$SI->setCellValue('A4', 'DEPT : 部署名：  '.$sec); //0
$SI->setCellValue('A6', 'Download Time= '.date("Y-m-d H:i:s")); //0
$SI->setCellValue('A7', 'SECTION セク ション'); //0
$SI->setCellValue('B7', 'PART_NO'); //1;
$SI->setCellValue('C7', 'PART  NAME'); //2;
$SI->setCellValue('D7', 'DETAIL PART'); //3;
$SI->setCellValue('E7', 'ACC NO.'); //4;
$SI->setCellValue('F7', 'ACCOUNT DESCRIPTION'); //5;
$SI->setCellValue('G7', 'CATEGORY'); //6;
$SI->setCellValue('H7', 'COST CENTER'); //7;
$SI->setCellValue('I7', 'CARLINE'); //8;
$SI->setCellValue('J7', 'CARMAKER'); //9;
$SI->setCellValue('K7', 'UOM'); //10;
$SI->setCellValue('L7', 'STP (A) 実計'); //11;
$SI->setCellValue('L8', 'QTY 数量'); //11;
$SI->setCellValue('M8', 'PRICE 単価'); //11;
$SI->setCellValue('M9', 'USD'); //11;
$SI->setCellValue('N8', 'AMOUNT 金額'); //11;
$SI->setCellValue('N9', 'USD'); //11;
$SI->setCellValue('O7', 'ACTUAL (B) 実績'); //11;
$SI->setCellValue('O8', 'QTY 数量'); //11;
$SI->setCellValue('P8', 'PRICE 単価'); //11;
$SI->setCellValue('P9', 'USD'); //11;
$SI->setCellValue('Q8', 'AMOUNT 金額'); //11;
$SI->setCellValue('Q9', 'USD'); //11;
$SI->setCellValue('R7', 'DIFFERENCE (B-A) 差異'); //11;
$SI->setCellValue('R8', 'QTY 数量'); //11;
$SI->setCellValue('S8', 'PRICE 単価'); //11;
$SI->setCellValue('S9', 'USD'); //11;
$SI->setCellValue('T8', 'AMOUNT 金額'); //11;
$SI->setCellValue('T9', 'USD'); //11;
$SI->setCellValue('U7', 'Reason 理由'); //12;
$SI->setCellValue('V7', 'Action 対策'); //13;
$SI->setCellValue('W7', 'PIC 担当者'); //14;
$SI->setCellValue('X7', 'Due Date 納期'); //15;
$SI->setCellValue('Y7', 'Kategori Add'); //15;
$SI->setCellValue('Z7', 'Periode Add'); //15;
$SI->setCellValue('AA7', 'No Control'); //15;
$SI->setCellValue('AB7', 'No Dokumen ADD'); //15;
$SI->setCellValue('AC7', 'PR NO'); //15;
$SI->setCellValue('AD7', 'Status Approval'); //15;

/*$Qry="select distinct a.periode,a.sect,a.no_ctrl,a.part_no,a.part_nm,a.part_dtl,a.part_desc,a.account,a.phase,a.cccode,a.kode_chg,a.ket_chg,
c.ACC_DESC,d.CARLINE,d.CARMAKER,a.uom,a.qty as qty_AP,dbo.lp_konprc(a.term,'USD',a.curr,a.price) as price_plan,sum(b.qty_act) as qty_act,
dbo.lp_konprc(b.term,'USD',b.curr,b.price_tot) as price_act,isnull(e.qty,0) as qty_stp,isnull(dbo.lp_konprc(e.term,'USD',e.curr,e.price),0) as price_stp 
from bps_budget_add a 
inner join bps_tmpPR b on a.periode=b.periode and a.no_ctrl=b.no_ctrl
full join LP_ACC c on a.account=c.ACC_NO
full join LP_CV d on a.cccode=d.COST_CENTER_CODE
full join bps_budget e on a.periode=e.periode and a.no_ctrl=e.no_ctrl and a.sect=e.sect
where doc_no is not null and a.sect='$sect' and a.periode='$periode' and a.term='$term'
group by a.periode,a.sect,a.no_ctrl,a.part_no,a.part_nm,a.part_dtl,a.part_desc,a.account,a.phase,a.cccode,a.kode_chg,a.ket_chg,
c.ACC_DESC,d.CARLINE,d.CARMAKER,a.uom,a.qty,a.price,b.price_tot,e.qty,e.price,e.curr,a.curr,b.curr,a.term,b.term,e.term";*/

if($period=='ALL'){$per='';}else{$per=" and a.periode='$period'";}

// $Qry="select distinct doc_no, a.periode, a.sect, a.no_ctrl, a.part_no, a.part_nm, a.part_dtl,
// a.part_desc, a.account,a.phase, a.cccode,a.kode_chg, a.ket_chg, c.ACC_DESC, d.CARLINE, d.CARMAKER,
// a.uom,a.qty as qty_AP, dbo.lp_konprc(a.term,'USD',a.curr,a.price) as price_plan,remark
// from bps_budget_add a 
// full join LP_ACC c on a.account=c.ACC_NO
// full join LP_CV d on a.cccode=d.COST_CENTER_CODE
// where doc_no is not null and a.sect='$sect' $per and a.term='$term'
// group by doc_no, a.periode, a.sect, a.part_no, a.part_nm, a.part_dtl, a.part_desc, a.account,
// a.phase, a.cccode, a.kode_chg, a.ket_chg, a.no_ctrl, remark, c.ACC_DESC, d.CARLINE, d.CARMAKER,
// a.uom,a.qty,a.price,a.curr, a.term";

// 20210202
// $Qry="select a.sect,a.periode,doc_no,a.ket_chg,a.kode_chg,a.no_ctrl,a.part_no, 
// a.part_nm, a.part_dtl,a.part_desc, a.account,a.phase, a.cccode, c.ACC_DESC, d.CARLINE,
// d.CARMAKER,a.uom,a.remark, (case when a.kode_chg>3 then b.Qty else a.qty end) as qty,
// (case when a.kode_chg>3 then dbo.lp_konprc(b.term,'USD',b.curr,(case when a.price > b.price 
// then b.price else a.price end)) else dbo.lp_konprc(a.term,'USD',a.curr,a.price) end) as price,
// (case when a.kode_chg>3 then dbo.lp_konprc(b.term,'USD',b.curr,(case when a.price > b.price 
// then b.price else a.price end))*b.Qty else dbo.lp_konprc(a.term,'USD',a.curr,a.price)*a.Qty end) 
// as amn from bps_budget_add a 
// inner join bps_pr b on a.no_ctrl=b.no_ctrl and a.periode=b.periode
// full join LP_ACC c on a.account=c.ACC_NO
// full join LP_CV d on a.cccode=d.COST_CENTER_CODE and a.term=d.term
// left join bps_approve e on a.doc_no=e.no_doc and a.sect=e.sect
// where doc_no is not null and a.term='$term' and e.status='FINISH' $sect $per 
// order by a.sect,a.periode,doc_no,b.tgl_updt asc";

$Qry="select a.sect,a.periode,doc_no,a.ket_chg,a.kode_chg,a.no_ctrl,a.part_no, 
a.part_nm, a.part_dtl,a.part_desc, a.account,a.phase, a.cccode, c.ACC_DESC, d.CARLINE,
d.CARMAKER,a.uom,a.remark, (case when a.kode_chg>3 then isnull(dbo.lp_sumActBud(a.no_ctrl,'qty'),0) else a.qty end) as qty,
(case when a.kode_chg>3 then dbo.lp_konprc(a.term,'USD',a.curr,(case when a.price > isnull(dbo.lp_sumActBud(a.no_ctrl,'price'),0)
then isnull(dbo.lp_sumActBud(a.no_ctrl,'price'),0) else a.price end)) else dbo.lp_konprc(a.term,'USD',a.curr,a.price) end) as price,
(case when a.kode_chg>3 then dbo.lp_konprc(a.term,'USD',a.curr,(case when a.price > isnull(dbo.lp_sumActBud(a.no_ctrl,'price'),0)
then isnull(dbo.lp_sumActBud(a.no_ctrl,'price'),0) else a.price end))*isnull(dbo.lp_sumActBud(a.no_ctrl,'qty'),0) 
else dbo.lp_konprc(a.term,'USD',a.curr,a.price)*a.Qty end) 
as amn from bps_budget_add a 
full join LP_ACC c on a.account=c.ACC_NO
full join LP_CV d on a.cccode=d.COST_CENTER_CODE and a.term=d.term
left join bps_approve e on a.doc_no=e.no_doc and a.sect=e.sect
where doc_no is not null and a.term='$term' and e.status='FINISH' $sect $per 
order by a.sect,a.periode,doc_no,a.tgl_updt asc";
// echo $Qry;
$tb_part=odbc_exec($koneksi_lp,$Qry);
$row=0;	$nkol=10; $baris  = 0;//Ini untuk dimulai baris datanya	
$Tqty=0;$Tamn=0;
while($baris1=odbc_fetch_array($tb_part)){
	$row++;
	$depsect=odbc_result($tb_part,'sect');
	$periode=odbc_result($tb_part,'periode');
	$doc_no	=odbc_result($tb_part,'doc_no');
	$ket_chg=odbc_result($tb_part,'ket_chg');
	$kode_chg=odbc_result($tb_part,'kode_chg');
	$no_ctrl=odbc_result($tb_part,'no_ctrl');
	$part_no=odbc_result($tb_part,'part_no');
	$part_nm=odbc_result($tb_part,'part_nm');
	$part_dtl=odbc_result($tb_part,'part_dtl');
	$part_desc=odbc_result($tb_part,'part_desc');
	$account=odbc_result($tb_part,'account');
	$phase=odbc_result($tb_part,'phase');
	$cccode=odbc_result($tb_part,'cccode');
	$acc_desc=odbc_result($tb_part,'ACC_DESC');
	$carline=odbc_result($tb_part,'CARLINE');
	$carmaker=odbc_result($tb_part,'CARMAKER');
	$uom=odbc_result($tb_part,'uom');
	$remark=odbc_result($tb_part,'remark');
	$qty=odbc_result($tb_part,'qty');
	$price=odbc_result($tb_part,'price');
	$amn=odbc_result($tb_part,'amn');
	
	$Tqty=$Tqty+$qty;
	$Tamn=$Tamn+$amn;
	
	$crpr="select pr_no,qty_act,dbo.lp_konprc(term,'USD',curr,price_tot) as price_pr from bps_tmpPR where no_ctrl='$no_ctrl' and periode='$periode' ";
	$tb_crpr=odbc_exec($koneksi_lp,$crpr);
	$pr_no="";
	while ($baris2=odbc_fetch_array($tb_crpr)){
		$q_act=odbc_result($tb_crpr,'qty_act');
		$prno=odbc_result($tb_crpr,'pr_no');
		$p_act=odbc_result($tb_crpr,'price_pr');
		$pr_no=$prno.",".$pr_no;
	}

	$SI->setCellValueByColumnAndRow($baris,$nkol,$depsect);
	$SI->setCellValueByColumnAndRow($baris+1,$nkol,$part_no);
	$SI->setCellValueByColumnAndRow($baris+2,$nkol,$part_nm);
	$SI->setCellValueByColumnAndRow($baris+3,$nkol,$part_dtl." ".$part_desc);
	$SI->setCellValueByColumnAndRow($baris+4,$nkol,$account);
	$SI->setCellValueByColumnAndRow($baris+5,$nkol,$acc_desc); 
	$SI->setCellValueByColumnAndRow($baris+6,$nkol,$phase); 
	$SI->setCellValueByColumnAndRow($baris+7,$nkol,$cccode); 
	$SI->setCellValueByColumnAndRow($baris+8,$nkol,$carline);
	$SI->setCellValueByColumnAndRow($baris+9,$nkol,$carmaker); 
	$SI->setCellValueByColumnAndRow($baris+10,$nkol,$uom); 
	$SI->setCellValueByColumnAndRow($baris+11,$nkol,$qty);
	$SI->setCellValueByColumnAndRow($baris+12,$nkol,$price);
	$SI->setCellValueByColumnAndRow($baris+13,$nkol,$amn);
	$SI->setCellValueByColumnAndRow($baris+14,$nkol,$qty); 
	$SI->setCellValueByColumnAndRow($baris+15,$nkol,$price); 
	$SI->setCellValueByColumnAndRow($baris+16,$nkol,$amn);
	$SI->setCellValueByColumnAndRow($baris+17,$nkol,0);
	$SI->setCellValueByColumnAndRow($baris+18,$nkol,0);
	$SI->setCellValueByColumnAndRow($baris+19,$nkol,0);
	$SI->setCellValueByColumnAndRow($baris+20,$nkol,trim($remark));
	$SI->setCellValueByColumnAndRow($baris+24,$nkol,$ket_chg);
	$SI->setCellValueByColumnAndRow($baris+25,$nkol,$periode);
	$SI->setCellValueByColumnAndRow($baris+26,$nkol,$no_ctrl);
	$SI->setCellValueByColumnAndRow($baris+27,$nkol,$doc_no);
	$SI->setCellValueByColumnAndRow($baris+28,$nkol,$pr_no);
	$nkol++;
}
$akhir=$nkol+1;

$SI->setCellValueByColumnAndRow($baris+1,$nkol,'TOTAL 合計');
	$excelku->getActiveSheet()->getStyle('B'.$baris+1)->getFont()->setBold(TRUE); // Set bold kolom A1
	$SI->setCellValueByColumnAndRow($baris+11,$nkol,$Tqty); 
	$SI->setCellValueByColumnAndRow($baris+13,$nkol,$Tamn);//$Tamn_p); 
	$SI->setCellValueByColumnAndRow($baris+14,$nkol,$Tqty);//$Tqty_a); 
	$SI->setCellValueByColumnAndRow($baris+16,$nkol,$Tamn)	;
	$SI->setCellValueByColumnAndRow($baris+17,$nkol,0);//$Tqty_a-$Tqty_p);
	$SI->setCellValueByColumnAndRow($baris+19,$nkol,0);//$Tamn_a-$Tamn_p);

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
	$blk_range="A7:AD".$nkol;
	$excelku->getActiveSheet()->getStyle($blk_range)->applyFromArray($styleArray);
	unset($styleArray);
	$objWriter = PHPExcel_IOFactory::createWriter($excelku, 'Excel2007');
	$objWriter->save('php://output');
	exit;
	echo "<h3>EXPORT DATA ".$Jdl2." ".$sec." SUDAH SELESAI DENGAN JUMLAH DATA ".$row." BARIS</h3>";
	?>