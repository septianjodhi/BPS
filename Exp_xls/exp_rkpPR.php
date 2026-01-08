<?php
/*******************************************
    Export Excel dengan PHPExcel
    ******************************************/
	//Before
   //$_SESSION['lok']=$_GET['l'];
   //After
    $_SESSION['lokasi']=$_GET['l'];
    // $lok=$_SESSION['lok'];
    include "../koneksi.php";
    include "PHPExcel.php";


    date_default_timezone_set("Asia/Jakarta");
    $excelku = new PHPExcel();
    $sect=$_GET['s'];
    if($sect=='all'){
    	$section="" ;
    }else{
    	$section=" and a.sect='$sect' " ;
    }
    $term=$_GET['t'];
    $period=$_GET['p'];
    $tgl_d=str_replace("%20","",$_GET['d']);
    if($tgl_d==''){$tgl1=date("Y-m-d");}else{
    	$tgl1=date("Y-m-d",strtotime(substr($tgl_d,0,10)));
    	$tgl2=date("Y-m-d",strtotime(substr($tgl_d,-10)));
    }

    $jns=$_GET['j'];
    if($jns=='rpt'){
    	$cr=" a.term='$term' $section and a.pr_date between '$tgl1' and '$tgl2'";
    }else{
    	// if($period=='' and $sect=='' ){
    	// 	$cr=" a.term='$term' ";
    	// }else if($period=='' and $sect!='all' ) {
    	// 	$cr=" a.term='$term' and a.sect='$sect'";
    	// }else {
    	// 	$cr=" a.term='$term' and a.sect='$sect' and a.periode='$period'";
    	// }
    	if($period==''){
    		$cr=" a.term='$term' $section ";
    	}else{
    		$cr=" a.term='$term' $section and a.periode='$period'";
    	}
    }

// Set properties
    $excelku->getProperties()->setCreator("BPS SAMI")
    ->setLastModifiedBy("BPS SAMI");
// Set lebar kolom
$excelku->getActiveSheet()->getColumnDimension('A')->setWidth(5);//no
$excelku->getActiveSheet()->getColumnDimension('B')->setWidth(10);//section
$excelku->getActiveSheet()->getColumnDimension('C')->setWidth(15);//PR No
$excelku->getActiveSheet()->getColumnDimension('D')->setWidth(15);//PR date
$excelku->getActiveSheet()->getColumnDimension('E')->setWidth(20);//No Ctrl
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(15);//Phase
$excelku->getActiveSheet()->getColumnDimension('G')->setWidth(15);//Periode
$excelku->getActiveSheet()->getColumnDimension('H')->setWidth(15);//Part no
$excelku->getActiveSheet()->getColumnDimension('I')->setWidth(20);//Part name
$excelku->getActiveSheet()->getColumnDimension('J')->setWidth(40);//Part dtl
$excelku->getActiveSheet()->getColumnDimension('K')->setWidth(25);//Part desc
$excelku->getActiveSheet()->getColumnDimension('L')->setWidth(15);//account
$excelku->getActiveSheet()->getColumnDimension('M')->setWidth(45);//acc_desc
$excelku->getActiveSheet()->getColumnDimension('N')->setWidth(15);//qty
$excelku->getActiveSheet()->getColumnDimension('O')->setWidth(15);//price
$excelku->getActiveSheet()->getColumnDimension('P')->setWidth(15);//amount
$excelku->getActiveSheet()->getColumnDimension('Q')->setWidth(15);//carline
$excelku->getActiveSheet()->getColumnDimension('R')->setWidth(15);//remark
$excelku->getActiveSheet()->getColumnDimension('S')->setWidth(55);//carline
$excelku->getActiveSheet()->getColumnDimension('T')->setWidth(25);//carline

// Mergecell, menyatukan beberapa kolom
/*==>>$excelku->getActiveSheet()->mergeCells('A7:A9');
$excelku->getActiveSheet()->mergeCells('B7:B9');
$excelku->getActiveSheet()->mergeCells('C7:C9');
$excelku->getActiveSheet()->mergeCells('D7:D9');
$excelku->getActiveSheet()->mergeCells('E7:E9');
$excelku->getActiveSheet()->mergeCells('F7:F9');
$excelku->getActiveSheet()->mergeCells('G7:G9');
*/
// Buat Kolom judul tabel
$SI = $excelku->setActiveSheetIndex(0);
if($jns=='rpt'){
	$Jdl='REPORT_PR';}else{$Jdl='REKAP_PR';}

$SI->setCellValue('A1', 'PT. Semarang Autocomp Manufacturing Indonesia'); //0
$SI->setCellValue('A2', $Jdl); //0
if($jns=='rpt'){
	$SI->setCellValue('A3', 'Tanggal = '.str_replace("%20"," - ",$_GET['d']));}
else{$SI->setCellValue('A3', 'Periode = '.$period);} //0

$SI->setCellValue('A6', 'Download Time= '.date("Y-m-d H:i:s")); //0
$SI->setCellValue('A7', 'No.'); //0
$SI->setCellValue('B7', 'Sect'); //0
$SI->setCellValue('C7', 'Pr No'); //0
$SI->setCellValue('D7', 'PR Date'); //0
$SI->setCellValue('E7', 'No Control'); //0
$SI->setCellValue('F7', 'Phase'); //0
$SI->setCellValue('G7', 'Periode'); //0
$SI->setCellValue('H7', 'Part No.'); //0
$SI->setCellValue('I7', 'Part Name'); //0
$SI->setCellValue('J7', 'Part Detail'); //0
$SI->setCellValue('K7', 'Part Desc'); //0
$SI->setCellValue('L7', 'Account'); //0
$SI->setCellValue('M7', 'Acc Desc'); //0
$SI->setCellValue('N7', 'Qty'); //0
$SI->setCellValue('O7', 'Curr'); //0
$SI->setCellValue('P7', 'Price'); //0
$SI->setCellValue('Q7', 'Amount'); //0
$SI->setCellValue('R7', 'Carline'); //0
$SI->setCellValue('S7', 'Remark'); //0
$SI->setCellValue('T7', 'PIC'); //0
$SI->setCellValue('U7', 'Tanggal PO'); 
$SI->setCellValue('V7', 'Nomor PO'); 
$SI->setCellValue('W7', 'Tanggal Barang Datang'); 
$SI->setCellValue('X7', 'Tanggal Invoice'); 
$SI->setCellValue('Y7', 'Nomor Invoice'); 
$SI->setCellValue('Z7', 'Tanggal VP'); 
$SI->setCellValue('AA7', 'Nomor VP'); 
$SI->setCellValue('AB7', 'Nomor BC'); 


$sql_act="select a.sect, a.pr_date, a.pr_no, a.no_ctrl, b.phase, a.periode, b.part_no, b.part_nm,
b.part_dtl,b.part_desc,b.account,c.ACC_DESC,a.qty,a.price,(a.qty*a.price) as amount, d.carline,
a.remark,a.pic_updt ,b.curr,e.po_no, CONVERT(nvarchar,e.tgl_updt,23) as tgl_po,
f.tgl_updt as tgl_dtg,f.inv_tgl,f.inv_no,g.tgl_updt as tgl_vp,g.vp_no,f.no_bc,f.tgl_bc
from bps_PR a 
full join bps_tmpPR b on a.no_ctrl=b.no_ctrl and a.pr_no=b.pr_no
full join LP_ACC c on b.account=c.ACC_NO 
full join LP_CV d on b.cccode=d.cv_code AND a.term=d.TERM
left join bps_podtl e on a.pr_no=e.pr_no and a.no_ctrl=e.no_ctrl
left join bps_kedatangan f on e.po_no=f.po_no and a.no_ctrl=f.no_ctrl and a.PR_NO=f.pr_no
left join bps_vp g on f.inv_no=g.inv_no and f.po_no=g.po_no
where $cr order by a.pr_date asc ";

// echo $sql_act;
$tb_part=odbc_exec($koneksi_lp,$sql_act);
$row=0;	$nkol=8;
$baris  = 0; //Ini untuk dimulai baris datanya		   		
while($baris1=odbc_fetch_array($tb_part)){
	$row++;
	$sect=odbc_result($tb_part,'sect');
	$pr_date=odbc_result($tb_part,'pr_date');
	$pr_no=odbc_result($tb_part,'pr_no');
	$no_ctrl=odbc_result($tb_part,'no_ctrl');
	$phase=odbc_result($tb_part,'phase');
	$periode=odbc_result($tb_part,'periode');
	$part_no=odbc_result($tb_part,'part_no');
	$part_nm=odbc_result($tb_part,'part_nm');
	$part_dtl=odbc_result($tb_part,'part_dtl');
	$part_desc=odbc_result($tb_part,'part_desc');
	$account=odbc_result($tb_part,'account');
	$ACC_DESC=odbc_result($tb_part,'ACC_DESC');
	$qty=odbc_result($tb_part,'qty');
	$price=odbc_result($tb_part,'price');
	$amount=odbc_result($tb_part,'amount');
	$carline=odbc_result($tb_part,'carline');
	$remark=odbc_result($tb_part,'remark');
	$pic_updt=odbc_result($tb_part,'pic_updt');
	$curr=odbc_result($tb_part,'curr');
	$po_no=odbc_result($tb_part,'po_no');
	$tgl_po=odbc_result($tb_part,'tgl_po');
	$tgl_dtg=odbc_result($tb_part,'tgl_dtg');
	$inv_tgl=odbc_result($tb_part,'inv_tgl');
	$inv_no=odbc_result($tb_part,'inv_no');
	$tgl_vp=odbc_result($tb_part,'tgl_vp');
	$vp_no=odbc_result($tb_part,'vp_no');
	$no_bc=odbc_result($tb_part,'no_bc');

	$SI->setCellValueByColumnAndRow($baris,$nkol,$row); 
	$SI->setCellValueByColumnAndRow($baris+1,$nkol,$sect);
	$SI->setCellValueByColumnAndRow($baris+2,$nkol,$pr_no); 
	$SI->setCellValueByColumnAndRow($baris+3,$nkol,$pr_date); 
	$SI->setCellValueByColumnAndRow($baris+4,$nkol,$no_ctrl);
	$SI->setCellValueByColumnAndRow($baris+5,$nkol,$phase); 
	$SI->setCellValueByColumnAndRow($baris+6,$nkol,$periode); 
	$SI->setCellValueByColumnAndRow($baris+7,$nkol,$part_no); 
	$SI->setCellValueByColumnAndRow($baris+8,$nkol,$part_nm);
	$SI->setCellValueByColumnAndRow($baris+9,$nkol,$part_dtl); 
	$SI->setCellValueByColumnAndRow($baris+10,$nkol,$part_desc); 
	$SI->setCellValueByColumnAndRow($baris+11,$nkol,$account); 
	$SI->setCellValueByColumnAndRow($baris+12,$nkol,$ACC_DESC);
	$SI->setCellValueByColumnAndRow($baris+13,$nkol,$qty);
	$SI->setCellValueByColumnAndRow($baris+14,$nkol,$curr);
	$SI->setCellValueByColumnAndRow($baris+15,$nkol,$price); 
	$SI->setCellValueByColumnAndRow($baris+16,$nkol,$amount); 
	$SI->setCellValueByColumnAndRow($baris+17,$nkol,$carline);
	$SI->setCellValueByColumnAndRow($baris+18,$nkol,$remark);
	$SI->setCellValueByColumnAndRow($baris+19,$nkol,$pic_updt);
	$SI->setCellValueByColumnAndRow($baris+20,$nkol,$baris1["po_no"]);
	$SI->setCellValueByColumnAndRow($baris+21,$nkol,$baris1["tgl_po"]);
	$SI->setCellValueByColumnAndRow($baris+22,$nkol,$baris1["tgl_dtg"]);
	$SI->setCellValueByColumnAndRow($baris+23,$nkol,$baris1["inv_tgl"]);
	$SI->setCellValueByColumnAndRow($baris+24,$nkol,$baris1["inv_no"]);
	$SI->setCellValueByColumnAndRow($baris+25,$nkol,$baris1["tgl_vp"]);
	$SI->setCellValueByColumnAndRow($baris+26,$nkol,$baris1["vp_no"]);
	$SI->setCellValueByColumnAndRow($baris+27,$nkol,$baris1["no_bc"]);


	$nkol++;
}

//$SI->setCellValueByColumnAndRow(0,$baris,"Jumlah Data : ".$row); 
//$SI->setCellValueByColumnAndRow(3,$baris,"Masuk : ".($row - $jmplg)); 
//$SI->setCellValueByColumnAndRow(4,$baris,"Pulang : ".$jmplg); 

//Membuat garis di body tabel (isi data)
//$excelku->getActiveSheet()->setSharedStyle($bodyStylenya, "A4 : G4");

//Memberi nama sheet
$excelku->getActiveSheet()->setTitle($Jdl);

$excelku->setActiveSheetIndex(0);

// untuk excel 2007 atau yang berekstensi .xlsx
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='.$Jdl." ".$sect.'.xls');
header('Cache-Control: max-age=0');
$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);
//$blk_range="A7:BB".$baris;
//$excelku->getActiveSheet()->getStyle($blk_range)->applyFromArray($styleArray);
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
echo "<h3>EXPORT DATA SUDAH SELESAI DENGAN JUMLAH DATA </h3>";
?>