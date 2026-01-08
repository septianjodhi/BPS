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
if($sect_s=="ALL" || $sect_s=="" ){
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

$rev_s1="update bps_budget_STP set category=phase where term='$term_s' and revisi='$rev_s' AND category is null and phase not like 'PROJECT%'";
$tb_rev=odbc_exec($koneksi_lp,$rev_s1);

$rev_s1="update bps_budget_STP set category='PROJECT' where term='$term_s' and revisi='$rev_s' AND category is null and phase like 'PROJECT%'";
$tb_rev=odbc_exec($koneksi_lp,$rev_s1);

/*disable sementara		
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
LEFT JOIN lp_cv cv ON bt.cccode = cv.COST_CENTER_CODE and bt.term=cv.term
LEFT JOIN bps_part pt ON bt.part_no = pt.part_no
WHERE bt.term='$term_s' and bt.revisi='$rev_s'";
$tb_rev=odbc_exec($koneksi_lp,$rev_s1);
*/

$rev_s1="UPDATE bt
SET 
    bt.hfm_code = acc.hfm_code,
	bt.hfm_desc=acc.hfm_desc,
	bt.account_sub=bt.account+'-'+sub.acc_sub
FROM bps_budget_stp bt
left JOIN LP_acc acc ON bt.account = acc.acc_no
left join bps_subacc sub on bt.account=sub.acc_no and bt.sub_acc_desc=sub.acc_subdesc
WHERE bt.term='$term_s' and bt.revisi='$rev_s'";
$tb_rev=odbc_exec($koneksi_lp,$rev_s1);

$term=$term_s;
$year=$term-82+2022;
$year2=$year+1;


$tgl31=date("Y-m-01",strtotime($year."-07-01"));
			$tgl41=date("Y-m-01",strtotime($year2."-06-01"));
				
		$bar=0;	
			
			$tglnyac="";
			$tglnyacPA="";
			$tglnyacFA="";
			$cari="";
for($ii=0;$ii<=12;$ii++){
	$tglnya2=date("Y-m-01",strtotime($tgl31."+$ii month"));
		if($tglnyac==""){
			$tglnyac="[".$tglnya2."]";
			$tglnyacPA="[".$tglnya2."PA]";
			$tglnyacFA="[".$tglnya2."FA]";
			
		}else{
			$tglnyac=$tglnyac.",[".$tglnya2."]";
			$tglnyacPA=$tglnyacPA.",[".$tglnya2."PA]";
			$tglnyacFA=$tglnyacFA.",[".$tglnya2."FA]";
			
			
		}
		
		$cari=$cari.",MAX([".$tglnya2."]) AS [".$tglnya2."],MAX([".$tglnya2."PA]) AS [".$tglnya2."PA],MAX([".$tglnya2."FA]) AS  [".$tglnya2."FA] ";
		
	}
	
			$res5	= "SELECT * FROM   
			(
				SELECT distinct term,Bulan,JmlHari from PS.dbo.PS_MHMP_WorkingDays where Customer like '%SAMI%' AND term='$term') t
					PIVOT(
				MAX(JmlHari)
				FOR Bulan IN (
					".$tglnyac." )) AS pivot_table";
			$tb_part5=odbc_exec($koneksi_lp,$res5);

			while($row5=odbc_fetch_array($tb_part5)){
				for($i=0;$i<=12;$i++){
															
															$tglnya=date("Y-m-d",strtotime($tgl31."+$i month"));
															$harikerja[$i]=odbc_result($tb_part5,$tglnya);
				}
				
			} 

			$res2	= "SELECT * FROM   
						(
							SELECT Bulan,JmlJam from PS.dbo.PS_MHMP_WorkingHours where term='$term') t
								PIVOT(
							SUM(JmlJam) 
							FOR Bulan IN (
								".$tglnyac." )) AS pivot_table
							 ";
								
						$tb_part2=odbc_exec($koneksi_lp,$res2);
						//echo $res2;
						while($row2=odbc_fetch_array($tb_part2)){
							for($j=0;$j<=12;$j++){
								
								$tglnya=date("Y-m-d",strtotime($tgl31."+$j month"));
								$wkh=odbc_result($tb_part2,$tglnya);
								
								if($wkh==""){
									$wkh=8;
								}
								
								$jmljam[$j]=$wkh;
							}
							
						}
						


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
					   
// Set properties
$excelku->getProperties()->setCreator("PLAN BUDGET STP SAMI-".$lokasi)
                         ->setLastModifiedBy("FA SAMI");

	
//MULAI SHEET 1 (PRD MH)					   
$SI = $excelku->setActiveSheetIndex(0);
//Memberi nama sheet
$excelku->getActiveSheet()->setTitle('Master A-Table');

// Set lebar kolom
$excelku->getActiveSheet()->getColumnDimension('A')->setWidth(17);
$excelku->getActiveSheet()->getColumnDimension('B')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('C')->setWidth(31);
$excelku->getActiveSheet()->getColumnDimension('D')->setWidth(24);
$excelku->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('G')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('H')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('I')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('J')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('K')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('L')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('M')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('N')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('O')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('P')->setWidth(11);  // P SAMPAI BN 12
$excelku->getActiveSheet()->getColumnDimension('Q')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('R')->setWidth(24);
$excelku->getActiveSheet()->getColumnDimension('S')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('T')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('U')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('V')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('W')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('X')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('Y')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('Z')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AA')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AB')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AC')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AD')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AE')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AF')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AG')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AH')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AI')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AJ')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AK')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AL')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AM')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AN')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AO')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AP')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AQ')->setWidth(11);

$Jdl='Output Report A-Table Term '.$term_s;

$SI->setCellValue('B2', 'HFM Code'); 
$SI->setCellValue('C2', 'HFM Code & Description'); 
$SI->setCellValue('E2', 'Section Category'); 


$SI->setCellValue('B3', 'RCR013'); 	
$SI->setCellValue('C3', 'RCR013:: Packing Cost'); 	
$SI->setCellValue('D3', 'Direct Charging'); 	
$SI->setCellValue('E3', 'FOH'); 
$SI->setCellValue('B4', 'RCR027'); 
$SI->setCellValue('C4', 'RCR027:: Insurance expense'); 	
$SI->setCellValue('D4', 'Direct Charging');
$SI->setCellValue('E4', 'FOH'); 
$SI->setCellValue('B5', 'RCR028');
$SI->setCellValue('C5', 'RCR028:: Warehouse expense'); 	
$SI->setCellValue('D5', 'Direct Charging'); 	
$SI->setCellValue('E5', 'FOH'); 
$SI->setCellValue('B6', 'RCR029'); 	$SI->setCellValue('C6', 'RCR029:: Taxes & public dues'); 	$SI->setCellValue('D6', 'Direct Charging'); 	$SI->setCellValue('E6', 'FOH'); 
$SI->setCellValue('B7', 'RCR030'); 	$SI->setCellValue('C7', 'RCR030:: Other fixed costs'); 	$SI->setCellValue('D7', 'Direct Charging'); 	$SI->setCellValue('E7', 'FOH'); 
$SI->setCellValue('B8', 'RCR032'); 	$SI->setCellValue('C8', 'RCR032:: Royalty to YC'); 	$SI->setCellValue('D8', 'Direct Charging'); 	$SI->setCellValue('E8', 'FOH'); 
$SI->setCellValue('B9', 'RCR035'); 	$SI->setCellValue('C9', 'RCR035:: License fee and others'); 	$SI->setCellValue('D9', 'Direct Charging'); 	$SI->setCellValue('E9', 'FOH'); 
$SI->setCellValue('B10', 'RCR037'); 	$SI->setCellValue('C10', 'RCR037:: Research & development expense'); 	$SI->setCellValue('D10', 'Direct Charging'); 	$SI->setCellValue('E10', 'FOH'); 
$SI->setCellValue('B11', 'RCR038-11'); 	$SI->setCellValue('C11', 'RCR038-11:: Ware & tear cost Direct charging(Domestic) 101:Equipment Cutting machine'); 	$SI->setCellValue('D11', 'Direct Charging'); 	$SI->setCellValue('E11', 'FOH'); 
$SI->setCellValue('B12', 'RCR038-12'); 	$SI->setCellValue('C12', 'RCR038-12:: Ware & tear cost Direct charging(Domestic) 102:Equipment Applicator'); 	$SI->setCellValue('D12', 'Direct Charging'); 	$SI->setCellValue('E12', 'FOH'); 
$SI->setCellValue('B13', 'RCR038-13'); 	$SI->setCellValue('C13', 'RCR038-13:: Ware & tear cost Direct charging(Domestic) 104:Equipment Conveyer'); 	$SI->setCellValue('D13', 'Direct Charging'); 	$SI->setCellValue('E13', 'FOH'); 
$SI->setCellValue('B14', 'RCR038-14'); 	$SI->setCellValue('C14', 'RCR038-14:: Ware & tear cost Direct charging(Domestic) 105:Equipment Jig board'); 	$SI->setCellValue('D14', 'Direct Charging'); 	$SI->setCellValue('E14', 'FOH'); 
$SI->setCellValue('B15', 'RCR038-15'); 	$SI->setCellValue('C15', 'RCR038-15:: Ware & tear cost Direct charging(Domestic) 106:Equipment Electrical inspection unit'); 	$SI->setCellValue('D15', 'Direct Charging'); 	$SI->setCellValue('E15', 'FOH'); 
$SI->setCellValue('B16', 'RCR038-16'); 	$SI->setCellValue('C16', 'RCR038-16:: Ware & tear cost Direct charging(Domestic) 108:Other'); 	$SI->setCellValue('D16', 'Direct Charging'); 	$SI->setCellValue('E16', 'FOH'); 
$SI->setCellValue('B17', 'RCR038-21'); 	$SI->setCellValue('C17', 'RCR038-21:: Ware & tear cost Direct charging(Import) 101:Equipment Cutting machine'); 	$SI->setCellValue('D17', 'Direct Charging'); 	$SI->setCellValue('E17', 'FOH'); 
$SI->setCellValue('B18', 'RCR038-22'); 	$SI->setCellValue('C18', 'RCR038-22:: Ware & tear cost Direct charging(Import) 102:Equipment Applicator'); 	$SI->setCellValue('D18', 'Direct Charging'); 	$SI->setCellValue('E18', 'FOH'); 
$SI->setCellValue('B19', 'RCR038-23'); 	$SI->setCellValue('C19', 'RCR038-23:: Ware & tear cost Direct charging(Import) 104:Equipment Conveyer'); 	$SI->setCellValue('D19', 'Direct Charging'); 	$SI->setCellValue('E19', 'FOH'); 
$SI->setCellValue('B20', 'RCR038-24'); 	$SI->setCellValue('C20', 'RCR038-24:: Ware & tear cost Direct charging(Import) 105:Equipment Jig board'); 	$SI->setCellValue('D20', 'Direct Charging'); 	$SI->setCellValue('E20', 'FOH'); 
$SI->setCellValue('B21', 'RCR038-25'); 	$SI->setCellValue('C21', 'RCR038-25:: Ware & tear cost Direct charging(Import) 106:Equipment Electrical inspection unit'); 	$SI->setCellValue('D21', 'Direct Charging'); 	$SI->setCellValue('E21', 'FOH'); 
$SI->setCellValue('B22', 'RCR038-26'); 	$SI->setCellValue('C22', 'RCR038-26:: Ware & tear cost Direct charging(Import) 108:Other'); 	$SI->setCellValue('D22', 'Direct Charging'); 	$SI->setCellValue('E22', 'FOH'); 
$SI->setCellValue('B23', 'RCR039'); 	$SI->setCellValue('C23', 'RCR039:: Repair & maintenance cost'); 	$SI->setCellValue('D23', 'Direct Charging'); 	$SI->setCellValue('E23', 'FOH'); 
$SI->setCellValue('B24', 'RCR040'); 	$SI->setCellValue('C24', 'RCR040:: Freight Cost'); 	$SI->setCellValue('D24', 'Direct Charging'); 	$SI->setCellValue('E24', 'FOH'); 
$SI->setCellValue('B25', 'RCR041'); 	$SI->setCellValue('C25', 'RCR041:: Utility & power expenses'); 	$SI->setCellValue('D25', 'Direct Charging'); 	$SI->setCellValue('E25', 'FOH'); 
$SI->setCellValue('B26', 'RCR042'); 	$SI->setCellValue('C26', 'RCR042:: Office supplies'); 	$SI->setCellValue('D26', 'Direct Charging'); 	$SI->setCellValue('E26', 'FOH'); 
$SI->setCellValue('B27', 'RCR043'); 	$SI->setCellValue('C27', 'RCR043:: Other production costs'); 	$SI->setCellValue('D27', 'Direct Charging'); 	$SI->setCellValue('E27', 'FOH'); 
$SI->setCellValue('B28', 'RPL025'); 	$SI->setCellValue('C28', 'RPL025:: Sales expense & commission'); 	$SI->setCellValue('D28', 'Direct Charging'); 	$SI->setCellValue('E28', 'OPEX'); 
$SI->setCellValue('B29', 'RPL026'); 	$SI->setCellValue('C29', 'RPL026:: Transportation expenses'); 	$SI->setCellValue('D29', 'Direct Charging'); 	$SI->setCellValue('E29', 'OPEX'); 
$SI->setCellValue('B30', 'RPL027'); 	$SI->setCellValue('C30', 'RPL027:: Packing expense'); 	$SI->setCellValue('D30', 'Direct Charging'); 	$SI->setCellValue('E30', 'OPEX'); 
$SI->setCellValue('B31', 'RPL107'); 	$SI->setCellValue('C31', 'RPL107:: Warehouse expenses'); 	$SI->setCellValue('D31', 'Direct Charging'); 	$SI->setCellValue('E31', 'OPEX'); 
$SI->setCellValue('B32', 'RPL030'); 	$SI->setCellValue('C32', 'RPL030:: Bad debt & Prov. for doubtful '); 	$SI->setCellValue('D32', 'Direct Charging'); 	$SI->setCellValue('E32', 'OPEX'); 
$SI->setCellValue('B33', 'RPL031'); 	$SI->setCellValue('C33', 'RPL031:: Claim expense & warranty expense'); 	$SI->setCellValue('D33', 'Direct Charging'); 	$SI->setCellValue('E33', 'OPEX'); 
$SI->setCellValue('B34', 'RPL047'); 	$SI->setCellValue('C34', 'RPL047:: Rent expense'); 	$SI->setCellValue('D34', 'Allocation'); 	$SI->setCellValue('E34', 'OPEX'); 
$SI->setCellValue('B35', 'RPL051'); 	$SI->setCellValue('C35', 'RPL051:: Other fixed expense'); 	$SI->setCellValue('D35', 'Direct Charging'); 	$SI->setCellValue('E35', 'OPEX'); 
$SI->setCellValue('B36', 'RPL053'); 	$SI->setCellValue('C36', 'RPL053:: Research & development expense'); 	$SI->setCellValue('D36', 'Direct Charging'); 	$SI->setCellValue('E36', 'OPEX'); 
$SI->setCellValue('B37', 'RPL058'); 	$SI->setCellValue('C37', 'RPL058:: Other G&A expense'); 	$SI->setCellValue('D37', 'Direct Charging'); 	$SI->setCellValue('E37', 'OPEX'); 
$SI->setCellValue('B38', 'RCR020'); 	$SI->setCellValue('C38', 'RCR020:: Employee welfare'); 	$SI->setCellValue('D38', 'Allocation'); 	$SI->setCellValue('E38', 'FOH'); 
$SI->setCellValue('B39', 'RCR026'); 	$SI->setCellValue('C39', 'RCR026:: Rent expense'); 	$SI->setCellValue('D39', 'Allocation'); 	$SI->setCellValue('E39', 'FOH'); 
$SI->setCellValue('B40', 'RPL040'); 	$SI->setCellValue('C40', 'RPL040:: Employee welfare'); 	$SI->setCellValue('D40', 'Allocation'); 	$SI->setCellValue('E40', 'OPEX'); 
$SI->setCellValue('B41', 'RPL041'); 	$SI->setCellValue('C41', 'RPL041:: Other labor expense'); 	$SI->setCellValue('D41', 'Allocation'); 	$SI->setCellValue('E41', 'OPEX'); 

//END SHEET 1

//START SHEET 2

$tgl31=date("Y-m-01",strtotime($year."-07-01"));
	$tgl21=date("Y-m-t",strtotime($year2."-06-01"));
	
	$tgl_awal=new DateTime($tgl31);
	$tgl_akhir=new DateTime($tgl21);
	
// MULAI MEMBUAT SHEET KE 2 ( MH-MP )
$excelku->CreateSheet(); //harus setelah default sheet 0

$excelku->setActiveSheetIndex(1);

// Buat Kolom judul tabel
$SI = $excelku->setActiveSheetIndex(1);
//Memberi nama sheet
$excelku->getActiveSheet()->setTitle('Mater Account');

// Set lebar kolom
$excelku->getActiveSheet()->getColumnDimension('A')->setWidth(4);
$excelku->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('D')->setWidth(8);
$excelku->getActiveSheet()->getColumnDimension('E')->setWidth(6);
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(31);
$excelku->getActiveSheet()->getColumnDimension('G')->setWidth(9);
$excelku->getActiveSheet()->getColumnDimension('H')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('I')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('J')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('K')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('L')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('M')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('N')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('O')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('P')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('Q')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('R')->setWidth(11);

$SI->setCellValue('C1', 'Account'); 		
$SI->setCellValue('D1', 'Account Description'); 	
$SI->setCellValue('E1', 'A Table Account'); 		
$SI->setCellValue('F1', 'A Table Description'); 		
$SI->setCellValue('G1', 'HFM CODE'); 		
$SI->setCellValue('H1', 'HFM DESCRIPTION'); 	
$SI->setCellValue('I1', 'Cek'); 	

$Qry1="
select acc.ACC_NO,acc.ACC_DESC,subacc.acc_no+'-'+subacc.acc_sub as atable_acc,(case when subacc.acc_no<>'' and RIGHT(subacc.acc_no,1)='1' then subacc.hfm_code+': Wear and tear cost Direct Charging(Import) '+subacc.acc_sub+' :'+subacc.acc_subdesc when subacc.acc_no<>'' and RIGHT(subacc.acc_no,1)='2' then subacc.hfm_code+': Wear and tear cost Direct Charging(Local) '+subacc.acc_sub+' :'+subacc.acc_subdesc  else '' end) as atable_desc,(case when subacc.acc_no<>'' then subacc.hfm_code else acc.hfm_code end) as hfm_code,(case when subacc.acc_no<>'' then 'Wear and tear cost' else acc.HFM_Desc end) as hfm_desc FROM lp_acc acc left join bps_subacc subacc on acc.ACC_NO=subacc.acc_no
";

$barismasteracc  = 2;
		$tb_part=odbc_exec($koneksi_lp,$Qry1);
//echo $Qry1;
		$row=0;
		

				while($baris1=odbc_fetch_array($tb_part)){
					$row++;
					$ACC_NO=odbc_result($tb_part,"ACC_NO");
						$ACC_DESC=odbc_result($tb_part,"ACC_DESC");
						$atable_acc=odbc_result($tb_part,"atable_acc");
						$atable_desc=odbc_result($tb_part,"atable_desc");
						$hfm_code=odbc_result($tb_part,"hfm_code");
						$hfm_desc=odbc_result($tb_part,"hfm_desc");
						
						
						
						
						$SI->setCellValueByColumnAndRow(1,$barismasteracc,$ACC_NO);
						$SI->setCellValueByColumnAndRow(2,$barismasteracc,$ACC_DESC); 
						$SI->setCellValueByColumnAndRow(3,$barismasteracc,$atable_acc); 
						$SI->setCellValueByColumnAndRow(4,$barismasteracc,$atable_desc); 
						$SI->setCellValueByColumnAndRow(5,$barismasteracc,$hfm_code); 
						$SI->setCellValueByColumnAndRow(6,$barismasteracc,$hfm_desc);
						$SI->setCellValueByColumnAndRow(7,$barismasteracc,'=VLOOKUP(G'.$barismasteracc.','."'Master A-Table'".'!$B$2:$E$41,2,0)'); 						
						
						$barismasteracc++;
				}
//END SHEET 2



//START SHEET 3

$tgl31=date("Y-m-01",strtotime($year."-07-01"));
	$tgl21=date("Y-m-t",strtotime($year2."-06-01"));
	
	$tgl_awal=new DateTime($tgl31);
	$tgl_akhir=new DateTime($tgl21);
	
// MULAI MEMBUAT SHEET KE 3 
$excelku->CreateSheet(); //harus setelah default sheet 0

$excelku->setActiveSheetIndex(2);

// Buat Kolom judul tabel
$SI = $excelku->setActiveSheetIndex(2);
//Memberi nama sheet
$excelku->getActiveSheet()->setTitle('CC Code');

// Set lebar kolom
$excelku->getActiveSheet()->getColumnDimension('A')->setWidth(4);
$excelku->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('D')->setWidth(8);
$excelku->getActiveSheet()->getColumnDimension('E')->setWidth(6);
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(31);
$excelku->getActiveSheet()->getColumnDimension('G')->setWidth(9);
$excelku->getActiveSheet()->getColumnDimension('H')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('I')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('J')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('K')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('L')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('M')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('N')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('O')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('P')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('Q')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('R')->setWidth(11);

$SI->setCellValue('A2', 'CC Code'); 		
$SI->setCellValue('B2', 'Area'); 	
$SI->setCellValue('C2', 'Commodity Code'); 		
$SI->setCellValue('D2', 'Destination code (Factory code)'); 		
$SI->setCellValue('E2', 'Carmaker'); 		
$SI->setCellValue('F2', 'Carline Code'); 	
	

$Qry1="
select * from (select distinct cv,'Final Assy' as area,Cust_Group,dest,CARMAKER,carline from PS.dbo.ps_mhmp_sr where term='$term' and bulan between '$tgl31' and '$tgl21'
union
select distinct b.CommArea as cv,(case when LEFT(b.CommArea,2)='AB' then 'Final Assy' else 'Pre Assy' end) as area,a.Cust_Group,a.dest,a.CARMAKER,a.carline from PS.dbo.ps_mhmp_sr a inner join PS.dbo.PS_MHMP_CommonArea b on a.cv=b.CV and a.term=b.term where b.term='$term' and b.bulan between '$tgl31' and '$tgl21'
union
select distinct a.COST_CENTER_CODE as cv,'Direct Carline' as area,(case when a.Commodity like '%HV%' then 'Hign Voltage' else 'Low Voltage' end ) as Cust_group,a.dest,a.CARMAKER,a.CARLINE from lp_cv a where a.term='$term' and NOT EXISTS (select distinct b.CommArea from PS.dbo.PS_MHMP_CommonArea b where a.COST_CENTER_CODE=b.CommArea)  and NOT EXISTS (select distinct b.CV from PS.dbo.PS_MHMP_CommonArea b where a.COST_CENTER_CODE=b.CV)
union
select 'JPI000' as cv,'FOH Common' as area,'LV' Cust_Group,'Common Area' as dest, 'Common Area' as CARMAKER, 'Common Area' as carline
union
select 'JAD000' as cv,'OPEX Common' as area,'LV' Cust_Group,'Common Area' as dest, 'Common Area' as CARMAKER, 'Common Area' as carline) t order by area,cv,carline,carmaker,dest
";

$bariscccode  = 3;
		$tb_part=odbc_exec($koneksi_lp,$Qry1);
//echo $Qry1;
		$row=0;
		

				while($baris1=odbc_fetch_array($tb_part)){
					$row++;
						$cv=odbc_result($tb_part,"cv");
						$area=odbc_result($tb_part,"area");
						$Cust_Group=odbc_result($tb_part,"Cust_Group");
						$dest=odbc_result($tb_part,"dest");
						$CARMAKER=odbc_result($tb_part,"CARMAKER");
						$carline=odbc_result($tb_part,"carline");
						
						
						
						$SI->setCellValueByColumnAndRow(0,$bariscccode,$cv); 
						$SI->setCellValueByColumnAndRow(1,$bariscccode,$area);
						$SI->setCellValueByColumnAndRow(2,$bariscccode,$Cust_Group); 
						$SI->setCellValueByColumnAndRow(3,$bariscccode,$dest); 
						$SI->setCellValueByColumnAndRow(4,$bariscccode,$CARMAKER); 
						$SI->setCellValueByColumnAndRow(5,$bariscccode,$carline); 
						
						
						$bariscccode++;
				}
//END SHEET 3

//START SHEET 4

$tgl31=date("Y-m-01",strtotime($year."-07-01"));
	$tgl21=date("Y-m-t",strtotime($year2."-06-01"));
	
	$tgl_awal=new DateTime($tgl31);
	$tgl_akhir=new DateTime($tgl21);
	
// MULAI MEMBUAT SHEET KE 4
$excelku->CreateSheet(); //harus setelah default sheet 0

$excelku->setActiveSheetIndex(3);

// Buat Kolom judul tabel
$SI = $excelku->setActiveSheetIndex(3);
//Memberi nama sheet
$excelku->getActiveSheet()->setTitle('PRD MH');

// Set lebar kolom
$excelku->getActiveSheet()->getColumnDimension('A')->setWidth(17);
$excelku->getActiveSheet()->getColumnDimension('B')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('C')->setWidth(31);
$excelku->getActiveSheet()->getColumnDimension('D')->setWidth(24);
$excelku->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('G')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('H')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('I')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('J')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('K')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('L')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('M')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('N')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('O')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('P')->setWidth(11);  // P SAMPAI BN 12
$excelku->getActiveSheet()->getColumnDimension('Q')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('R')->setWidth(24);
$excelku->getActiveSheet()->getColumnDimension('S')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('T')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('U')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('V')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('W')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('X')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('Y')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('Z')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AA')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AB')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AC')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AD')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AE')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AF')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AG')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AH')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AI')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AJ')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AK')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AL')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AM')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AN')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AO')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AP')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('AQ')->setWidth(11);

$SI->setCellValue('F2', 'Total'); //0
$SI->setCellValue('A3', 'code'); //0
$SI->setCellValue('B3', 'Destination'); //0
$SI->setCellValue('C3', 'Carmaker'); //0
$SI->setCellValue('D3', 'Carline'); //0
$SI->setCellValue('E3', 'Conveyor'); //0
$SI->setCellValue('F3', '07'); //0
$SI->setCellValue('G3', '08'); //0
$SI->setCellValue('H3', '09'); //0
$SI->setCellValue('I3', '10'); //0
$SI->setCellValue('J3', '11'); //0
$SI->setCellValue('K3', '12'); //0
$SI->setCellValue('L3', '01'); //0
$SI->setCellValue('M3', '02'); //0
$SI->setCellValue('N3', '03'); //0
$SI->setCellValue('O3', '04'); //0
$SI->setCellValue('P3', '05'); //0
$SI->setCellValue('Q3', '06'); //0


$SI->setCellValue('S2', 'Pre Assy'); //0
$SI->setCellValue('S3', '07'); //0
$SI->setCellValue('T3', '08'); //0
$SI->setCellValue('U3', '09'); //0
$SI->setCellValue('V3', '10'); //0
$SI->setCellValue('W3', '11'); //0
$SI->setCellValue('X3', '12'); //0
$SI->setCellValue('Y3', '01'); //0
$SI->setCellValue('Z3', '02'); //0
$SI->setCellValue('AA3', '03'); //0
$SI->setCellValue('AB3', '04'); //0
$SI->setCellValue('AC3', '05'); //0
$SI->setCellValue('AD3', '06'); //0


$SI->setCellValue('AF2', 'Final Assy'); //0
$SI->setCellValue('AF3', '07'); //0
$SI->setCellValue('AG3', '08'); //0
$SI->setCellValue('AH3', '09'); //0
$SI->setCellValue('AI3', '10'); //0
$SI->setCellValue('AJ3', '11'); //0
$SI->setCellValue('AK3', '12'); //0
$SI->setCellValue('AL3', '01'); //0
$SI->setCellValue('AM3', '02'); //0
$SI->setCellValue('AN3', '03'); //0
$SI->setCellValue('AO3', '04'); //0
$SI->setCellValue('AP3', '05'); //0
$SI->setCellValue('AQ3', '06'); //0


			$res2	= "SELECT distinct cv,dest,carline,carmaker$cari FROM   
			(
				SELECT distinct cv,Bulan,Bulan+'PA' as BulanA,Bulan+'FA' as BulanB,dest,carline,carmaker,sum(prod_mh) as prod_mh,sum(prod_pa_mh) as prod_pa_mh,sum(prod_fa_mh) as prod_fa_mh from PS.dbo.ps_mhmp_sr where term='$term' group by cv,bulan,dest,carline,carmaker) t
					PIVOT(
				SUM(prod_mh) 
				FOR Bulan IN (
					".$tglnyac."  )) AS pivot_table
					PIVOT(
	 SUM(prod_pa_mh) 
    FOR BulanA IN (
        ".$tglnyacPA.")) AS pivot_tableA

		 PIVOT(
	 SUM(prod_fa_mh) 
    FOR BulanB IN (
         ".$tglnyacFA.")) AS pivot_tableB
				group by cv,dest,carline,carmaker ORDER by cv,dest,carline,carmaker   ";
					
			$tb_part2=odbc_exec($koneksi_lp,$res2);
			//echo $res2;
			$barisprdmh=4;
			while($row2=odbc_fetch_array($tb_part2)){
				
				$SI->setCellValueByColumnAndRow(0,$barisprdmh,'=CONCATENATE(B'.$barisprdmh.',D'.$barisprdmh.',E'.$barisprdmh.')');
				$SI->setCellValueByColumnAndRow(1,$barisprdmh,odbc_result($tb_part2,"dest"));
				$SI->setCellValueByColumnAndRow(2,$barisprdmh,odbc_result($tb_part2,"CARMAKER"));
				$SI->setCellValueByColumnAndRow(3,$barisprdmh,odbc_result($tb_part2,"CARLINE"));
				$SI->setCellValueByColumnAndRow(4,$barisprdmh,odbc_result($tb_part2,"CV"));
				
				for($j=0;$j<12;$j++){
					
					$tglnya=date("Y-m-d",strtotime($tgl31."+$j month"));
					$tglnyaPA=date("Y-m-d",strtotime($tgl31."+$j month"))."PA";
					$tglnyaFA=date("Y-m-d",strtotime($tgl31."+$j month"))."FA";
												
					$prodmhA=odbc_result($tb_part2,$tglnya);
					$prodmhAPA=odbc_result($tb_part2,$tglnyaPA);
					$prodmhAFA=odbc_result($tb_part2,$tglnyaFA);
												
												if($prodmhA=="" || $prodmhA==0){
													$prodmhA=0.01;
												}
												if($prodmhAPA==""){
													$prodmhAPA=0;
												}
												if($prodmhAFA=="" || $prodmhAFA==0){
													$prodmhAFA=0.01;
												}
					
					$SI->setCellValueByColumnAndRow(5+$j,$barisprdmh,$prodmhA);
					//$SI->setCellValueByColumnAndRow(18+$j,$barisprdmh,$prodmhAPA);
					$SI->setCellValueByColumnAndRow(18+$j,$barisprdmh,'='.$alphabet[5+$j].$barisprdmh.'-'.$alphabet[31+$j].$barisprdmh);
					$SI->setCellValueByColumnAndRow(31+$j,$barisprdmh,$prodmhAFA);
				}
				
				$barisprdmh++;
				
			}										
			
			
//END SHEET 4

//START SHEET 5

$tgl31=date("Y-m-01",strtotime($year."-07-01"));
	$tgl21=date("Y-m-t",strtotime($year2."-06-01"));
	
	$tgl_awal=new DateTime($tgl31);
	$tgl_akhir=new DateTime($tgl21);
	
// MULAI MEMBUAT SHEET KE 5
$excelku->CreateSheet(); //harus setelah default sheet 0

$excelku->setActiveSheetIndex(4);

// Buat Kolom judul tabel
$SI = $excelku->setActiveSheetIndex(4);
//Memberi nama sheet
$excelku->getActiveSheet()->setTitle('Ratio FA');

// Set lebar kolom
$excelku->getActiveSheet()->getColumnDimension('A')->setWidth(4);
$excelku->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('D')->setWidth(8);
$excelku->getActiveSheet()->getColumnDimension('E')->setWidth(6);
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(31);
$excelku->getActiveSheet()->getColumnDimension('G')->setWidth(9);
$excelku->getActiveSheet()->getColumnDimension('H')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('I')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('J')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('K')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('L')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('M')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('N')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('O')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('P')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('Q')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('R')->setWidth(11);

$SI->setCellValue('A2', 'Code'); 	
$SI->setCellValue('B2', 'CC Code Final Assy'); 		
$SI->setCellValue('C2', 'Area'); 	
$SI->setCellValue('D2', 'Commodity Code'); 		
$SI->setCellValue('E2', 'Destination code (Factory code)'); 		
$SI->setCellValue('F2', 'Carmaker'); 		
$SI->setCellValue('G2', 'Carline Code'); 	
$SI->setCellValue('H2', '7'); //0
$SI->setCellValue('I2', '8'); //0
$SI->setCellValue('J2', '9'); //0
$SI->setCellValue('K2', '10'); //0
$SI->setCellValue('L2', '11'); //0
$SI->setCellValue('M2', '12'); //0
$SI->setCellValue('N2', '1'); //0
$SI->setCellValue('O2', '2'); //0
$SI->setCellValue('P2', '3'); //0
$SI->setCellValue('Q2', '4'); //0
$SI->setCellValue('R2', '5'); //0
$SI->setCellValue('S2', '6'); //0
	

$Qry1="select * from (
select distinct cv,'Final Assy' as area,Cust_Group,dest,CARMAKER,carline from PS.dbo.ps_mhmp_sr where term='$term' and bulan between '$tgl31' and '$tgl21'
union
select distinct b.CommArea as cv,(case when LEFT(b.CommArea,2)='AB' then 'Final Assy' else 'Pre Assy' end) as area,a.Cust_Group,a.dest,a.CARMAKER,a.carline from PS.dbo.ps_mhmp_sr a inner join PS.dbo.PS_MHMP_CommonArea b on a.cv=b.CV and a.term=b.term where b.term='$term' and b.bulan between '$tgl31' and '$tgl21' and b.CommArea like '%AB%') t order by area,cv,carline,carmaker,dest
";

$barisratiofa  = 3;
		$tb_part=odbc_exec($koneksi_lp,$Qry1);
//echo $Qry1;
		$row=0;
		

				while($baris1=odbc_fetch_array($tb_part)){
					$row++;
						$cv=odbc_result($tb_part,"cv");
						$area=odbc_result($tb_part,"area");
						$Cust_Group=odbc_result($tb_part,"Cust_Group");
						$dest=odbc_result($tb_part,"dest");
						$CARMAKER=odbc_result($tb_part,"CARMAKER");
						$carline=odbc_result($tb_part,"carline");
						
						
						$SI->setCellValueByColumnAndRow(0,$barisratiofa,'=CONCATENATE(B'.$barisratiofa.',E'.$barisratiofa.'," ",G'.$barisratiofa.')');
						$SI->setCellValueByColumnAndRow(1,$barisratiofa,$cv); 
						$SI->setCellValueByColumnAndRow(2,$barisratiofa,$area);
						$SI->setCellValueByColumnAndRow(3,$barisratiofa,$Cust_Group); 
						$SI->setCellValueByColumnAndRow(4,$barisratiofa,$dest); 
						$SI->setCellValueByColumnAndRow(5,$barisratiofa,$CARMAKER); 
						$SI->setCellValueByColumnAndRow(6,$barisratiofa,$carline); 
						
						for($j=0;$j<12;$j++){
					
													
							$SI->setCellValueByColumnAndRow(7+$j,$barisratiofa,'=IF(SUMIF('."'PRD MH'".'!$E$4:$E$'.$barisprdmh.',$B'.$barisratiofa.','."'PRD MH'".'!'.$alphabet[$j+31].'$4:'.$alphabet[$j+31].'$'.$barisprdmh.')=0,0,SUMIFS('."'PRD MH'".'!'.$alphabet[$j+31].'$4:'.$alphabet[$j+31].'$'.$barisprdmh.','."'PRD MH'".'!$E$4:$E$'.$barisprdmh.',$B'.$barisratiofa.','."'PRD MH'".'!$B$4:$B$'.$barisprdmh.',$E'.$barisratiofa.','."'PRD MH'".'!$D$4:$D$'.$barisprdmh.',$G'.$barisratiofa.')/SUMIF('."'PRD MH'".'!$E$4:$E$'.$barisprdmh.',$B'.$barisratiofa.','."'PRD MH'".'!'.$alphabet[$j+31].'$4:'.$alphabet[$j+31].'$'.$barisprdmh.'))');
							
							
						}
						
						$barisratiofa++;
				}
//END SHEET 5


//START SHEET 6

$tgl31=date("Y-m-01",strtotime($year."-07-01"));
	$tgl21=date("Y-m-t",strtotime($year2."-06-01"));
	
	$tgl_awal=new DateTime($tgl31);
	$tgl_akhir=new DateTime($tgl21);
	
// MULAI MEMBUAT SHEET KE 6
$excelku->CreateSheet(); //harus setelah default sheet 0

$excelku->setActiveSheetIndex(5);

// Buat Kolom judul tabel
$SI = $excelku->setActiveSheetIndex(5);
//Memberi nama sheet
$excelku->getActiveSheet()->setTitle('Ratio PA');

// Set lebar kolom
$excelku->getActiveSheet()->getColumnDimension('A')->setWidth(4);
$excelku->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$excelku->getActiveSheet()->getColumnDimension('D')->setWidth(8);
$excelku->getActiveSheet()->getColumnDimension('E')->setWidth(6);
$excelku->getActiveSheet()->getColumnDimension('F')->setWidth(31);
$excelku->getActiveSheet()->getColumnDimension('G')->setWidth(9);
$excelku->getActiveSheet()->getColumnDimension('H')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('I')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('J')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('K')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('L')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('M')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('N')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('O')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('P')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('Q')->setWidth(11);
$excelku->getActiveSheet()->getColumnDimension('R')->setWidth(11);

$SI->setCellValue('A2', 'CC Code Pre Assy'); 	
$SI->setCellValue('B2', 'CC Code Final Assy'); 		
$SI->setCellValue('C2', 'Area'); 	
$SI->setCellValue('D2', 'Commodity Code'); 		
$SI->setCellValue('E2', 'Destination code (Factory code)'); 		
$SI->setCellValue('F2', 'Carmaker'); 		
$SI->setCellValue('G2', 'Carline Code'); 	
$SI->setCellValue('H2', '7'); //0
$SI->setCellValue('I2', '8'); //0
$SI->setCellValue('J2', '9'); //0
$SI->setCellValue('K2', '10'); //0
$SI->setCellValue('L2', '11'); //0
$SI->setCellValue('M2', '12'); //0
$SI->setCellValue('N2', '1'); //0
$SI->setCellValue('O2', '2'); //0
$SI->setCellValue('P2', '3'); //0
$SI->setCellValue('Q2', '4'); //0
$SI->setCellValue('R2', '5'); //0
$SI->setCellValue('S2', '6'); //0
	

$Qry1="select * from (
select distinct b.CommArea as CommArea,b.cv,(case when LEFT(b.CommArea,2)='AB' then 'Final Assy' else 'Pre Assy' end) as area,a.Cust_Group,a.dest,a.CARMAKER,a.carline from PS.dbo.ps_mhmp_sr a inner join PS.dbo.PS_MHMP_CommonArea b on a.cv=b.CV and a.term=b.term where b.term='$term' and b.bulan between '$tgl31' and '$tgl21' and b.CommArea NOT LIKE '%AB%') t order by area,cv,carline,carmaker,dest,CommArea
";

$barisratiopa  = 3;
		$tb_part=odbc_exec($koneksi_lp,$Qry1);
//echo $Qry1;
		$row=0;
		

				while($baris1=odbc_fetch_array($tb_part)){
					$row++;
						$cv=odbc_result($tb_part,"cv");
						$CommArea=odbc_result($tb_part,"CommArea");
						$area=odbc_result($tb_part,"area");
						$Cust_Group=odbc_result($tb_part,"Cust_Group");
						$dest=odbc_result($tb_part,"dest");
						$CARMAKER=odbc_result($tb_part,"CARMAKER");
						$carline=odbc_result($tb_part,"carline");
						
						
						$SI->setCellValueByColumnAndRow(0,$barisratiopa,$CommArea); 
						$SI->setCellValueByColumnAndRow(1,$barisratiopa,$cv); 
						$SI->setCellValueByColumnAndRow(2,$barisratiopa,$area);
						$SI->setCellValueByColumnAndRow(3,$barisratiopa,$Cust_Group); 
						$SI->setCellValueByColumnAndRow(4,$barisratiopa,$dest); 
						$SI->setCellValueByColumnAndRow(5,$barisratiopa,$CARMAKER); 
						$SI->setCellValueByColumnAndRow(6,$barisratiopa,$carline); 
						
						for($j=0;$j<12;$j++){
					
													
							$SI->setCellValueByColumnAndRow(7+$j,$barisratiopa,'=SUMIFS('."'PRD MH'".'!'.$alphabet[$j+18].'$4:'.$alphabet[$j+18].'$'.$barisprdmh.','."'PRD MH'".'!$E$4:$E$'.$barisprdmh.',$B'.$barisratiopa.','."'PRD MH'".'!$B$4:$B$'.$barisprdmh.',$E'.$barisratiopa.','."'PRD MH'".'!$D$4:$D$'.$barisprdmh.',$G'.$barisratiopa.')');
							
							
						}
											
						$barisratiopa++;
				}

$SI->setCellValue('A'.($barisratiopa+6), 'SUMMARY'); 	
$SI->setCellValue('A'.($barisratiopa+7), 'Code'); 	
$SI->setCellValue('B'.($barisratiopa+7), 'CC Code Pre Assy'); 		
$SI->setCellValue('C'.($barisratiopa+7), 'Area'); 	
$SI->setCellValue('D'.($barisratiopa+7), 'Commodity Code'); 		
$SI->setCellValue('E'.($barisratiopa+7), 'Destination code (Factory code)'); 		
$SI->setCellValue('F'.($barisratiopa+7), 'Carmaker'); 		
$SI->setCellValue('G'.($barisratiopa+7), 'Carline Code'); 	
$SI->setCellValue('H'.($barisratiopa+7), '7'); //0
$SI->setCellValue('I'.($barisratiopa+7), '8'); //0
$SI->setCellValue('J'.($barisratiopa+7), '9'); //0
$SI->setCellValue('K'.($barisratiopa+7), '10'); //0
$SI->setCellValue('L'.($barisratiopa+7), '11'); //0
$SI->setCellValue('M'.($barisratiopa+7), '12'); //0
$SI->setCellValue('N'.($barisratiopa+7), '1'); //0
$SI->setCellValue('O'.($barisratiopa+7), '2'); //0
$SI->setCellValue('P'.($barisratiopa+7), '3'); //0
$SI->setCellValue('Q'.($barisratiopa+7), '4'); //0
$SI->setCellValue('R'.($barisratiopa+7), '5'); //0
$SI->setCellValue('S'.($barisratiopa+7), '6'); //0

	$barisratiopa1=$barisratiopa+8;			

$Qry1="select * from (
select distinct b.CommArea as CommArea,(case when LEFT(b.CommArea,2)='AB' then 'Final Assy' else 'Pre Assy' end) as area,a.Cust_Group,a.dest,a.CARMAKER,a.carline from PS.dbo.ps_mhmp_sr a inner join PS.dbo.PS_MHMP_CommonArea b on a.cv=b.CV and a.term=b.term where b.term='$term' and b.bulan between '$tgl31' and '$tgl21' and b.CommArea NOT LIKE '%AB%') t order by area,CommArea,carline,carmaker,dest
";


		$tb_part=odbc_exec($koneksi_lp,$Qry1);
//echo $Qry1;
		$row=0;
		

				while($baris1=odbc_fetch_array($tb_part)){
					$row++;
					
						$CommArea=odbc_result($tb_part,"CommArea");
						$area=odbc_result($tb_part,"area");
						$Cust_Group=odbc_result($tb_part,"Cust_Group");
						$dest=odbc_result($tb_part,"dest");
						$CARMAKER=odbc_result($tb_part,"CARMAKER");
						$carline=odbc_result($tb_part,"carline");
						
						
						$SI->setCellValueByColumnAndRow(0,$barisratiopa1,'=CONCATENATE(B'.$barisratiopa1.',E'.$barisratiopa1.'," ",G'.$barisratiopa1.')');
						$SI->setCellValueByColumnAndRow(1,$barisratiopa1,$CommArea); 
						$SI->setCellValueByColumnAndRow(2,$barisratiopa1,$area);
						$SI->setCellValueByColumnAndRow(3,$barisratiopa1,$Cust_Group); 
						$SI->setCellValueByColumnAndRow(4,$barisratiopa1,$dest); 
						$SI->setCellValueByColumnAndRow(5,$barisratiopa1,$CARMAKER); 
						$SI->setCellValueByColumnAndRow(6,$barisratiopa1,$carline); 
						
						for($j=0;$j<12;$j++){
					
													
							$SI->setCellValueByColumnAndRow(7+$j,$barisratiopa1,'=SUMIFS(H$2:H$'.$barisratiopa.',$A$2:$A$'.$barisratiopa.',$B'.$barisratiopa1.',$E$2:$E$'.$barisratiopa.',$E'.$barisratiopa1.',$G$2:$G$'.$barisratiopa.',$G'.$barisratiopa1.')/SUMIF($A$2:$A$'.$barisratiopa.',$B'.$barisratiopa1.',H$2:H$'.$barisratiopa.')');
							
							
						}
											
						$barisratiopa1++;
				}
				
	
//END SHEET 6
		   				   

//START SHEET 7

$tgl31=date("Y-m-01",strtotime($year."-07-01"));
	$tgl21=date("Y-m-t",strtotime($year2."-06-01"));
	
	$tgl_awal=new DateTime($tgl31);
	$tgl_akhir=new DateTime($tgl21);
	
// MULAI MEMBUAT SHEET KE 7
$excelku->CreateSheet(); //harus setelah default sheet 0

$excelku->setActiveSheetIndex(6);

// Buat Kolom judul tabel
$SI = $excelku->setActiveSheetIndex(6);
//Memberi nama sheet
$excelku->getActiveSheet()->setTitle('Copy Paste Budget All');

	
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
$SI->setCellValue('Q10', 'PRICE USD'); 
$SI->setCellValue('R10', 'QTY'); //QTT
$SI->setCellValue('S10', 'AMT'); //AMOUNT USD
$SI->setCellValue('T10', 'SUB ACCOUNT'); 
$SI->setCellValue('S10', 'KODE PROSES'); 
$SI->setCellValue('U10', 'PURCHASING'); 
$SI->setCellValue('V10', 'LEADTIME');
$SI->setCellValue('X11', 'PENAWARAN'); 
$SI->setCellValue('Y11', 'PR'); 
$SI->setCellValue('Z11', 'PO'); 
$SI->setCellValue('AA11', 'KEDATANGAN'); 
$SI->setCellValue('AB11', 'VP'); 
$SI->setCellValue('AC10', 'Wear & Tear Category'); 
$SI->setCellValue('AD10', 'HFM Code'); 
$SI->setCellValue('AE10', 'Direct Charging /Allocation'); 
$SI->setCellValue('AF10', 'Cek CC Code'); 
$SI->setCellValue('AG10', 'Project/MassPro'); 

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

$Qry1="select   sect,part_no,account,acc_desc,sub_acc_desc,part_dtl,uom,term,id_proses,jns_budget,lp,kurs,curr,phase,cccode,part_nm,revisi,fungsi,carline,carmaker,sub_acc,lt_vp,lt_datang,lt_po,lt_pr,lt_Quo,urut,periode,price,(price/kurs) as priceUSD,qty,qty*price/kurs as amt,account_sub from bps_budget_stp where qty>0 and term='$term_s' $sec_s and revisi='$rev_s' ORDER BY sect,urut
";

$barisbudget  = 13; //Ini untuk dimulai baris datanya

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
						$periode=odbc_result($tb_part,"periode");
						$account=odbc_result($tb_part,"account");
						$acc_desc=odbc_result($tb_part,"acc_desc");
						$sub_acc_desc=odbc_result($tb_part,"sub_acc_desc");
						
						$price=odbc_result($tb_part,"price");
						$priceusd=odbc_result($tb_part,"priceusd");
						$amt=odbc_result($tb_part,"amt");
						$qty=odbc_result($tb_part,"qty");
						$account_sub=odbc_result($tb_part,"account_sub");
						
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
												
						$SI->setCellValueByColumnAndRow(0,$barisbudget,$sect);
						$SI->setCellValueByColumnAndRow(2,$barisbudget,$part_no); 
						$SI->setCellValueByColumnAndRow(3,$barisbudget,$part_nm); 
						$SI->setCellValueByColumnAndRow(4,$barisbudget,$part_dtl); 
						$SI->setCellValueByColumnAndRow(5,$barisbudget,$fungsi); 
						$SI->setCellValueByColumnAndRow(6,$barisbudget,$sub_acc);
						$SI->setCellValueByColumnAndRow(7,$barisbudget,$account);
						$SI->setCellValueByColumnAndRow(8,$barisbudget,$acc_desc); 
						$SI->setCellValueByColumnAndRow(9,$barisbudget,$category); 
						$SI->setCellValueByColumnAndRow(10,$barisbudget,$cccode); 
						$SI->setCellValueByColumnAndRow(11,$barisbudget,$carline); 
						$SI->setCellValueByColumnAndRow(12,$barisbudget,$carmaker); 
						$SI->setCellValueByColumnAndRow(13,$barisbudget,$uom); 
						$SI->setCellValueByColumnAndRow(14,$barisbudget,$curr);
						$SI->setCellValueByColumnAndRow(15,$barisbudget,$price);
						$SI->setCellValueByColumnAndRow(16,$barisbudget,$priceusd);
						$SI->setCellValueByColumnAndRow(17,$barisbudget,$qty);
						$SI->setCellValueByColumnAndRow(18,$barisbudget,$amt);
						$SI->setCellValueByColumnAndRow(19,$barisbudget,$account_sub);
						$SI->setCellValueByColumnAndRow(20,$barisbudget,$k_proses);
						$SI->setCellValueByColumnAndRow(21,$barisbudget,$lp);
						$SI->setCellValueByColumnAndRow(22,$barisbudget,$lt_quo);
						$SI->setCellValueByColumnAndRow(23,$barisbudget,$lt_pr);
						$SI->setCellValueByColumnAndRow(24,$barisbudget,$lt_po);
						$SI->setCellValueByColumnAndRow(25,$barisbudget,$lt_datang);
						$SI->setCellValueByColumnAndRow(26,$barisbudget,$lt_vp);
						$SI->setCellValueByColumnAndRow(27,$barisbudget,$periode);
						$SI->setCellValueByColumnAndRow(28,$barisbudget,'=IFERROR(VLOOKUP(T'.$barisbudget.",'Mater Account'".'!$D:$E,2,0),"")');
						$SI->setCellValueByColumnAndRow(29,$barisbudget,'=IF(AC'.$barisbudget.'="",VLOOKUP(H'.$barisbudget.",'Master Account'".'!$C:$G,5,0),LEFT(AC'.$barisbudget.',9))');
						$SI->setCellValueByColumnAndRow(30,$barisbudget,'=IF(K'.$barisbudget.'="JPI000","Allocation",IF(K'.$barisbudget.'="JAD000","Allocation","Direct Charging"))');
						$SI->setCellValueByColumnAndRow(31,$barisbudget,'=VLOOKUP(K'.$barisbudget.",'CC Code'".'!$A$2:$A$'.$bariscccode.',1,0)');
						$SI->setCellValueByColumnAndRow(32,$barisbudget,'=IF(LEFT(J'.$barisbudget.',7)="PROJECT","PROJECT","MASSPRO")');
						
									
					
						$SI->getStyle('A10:BA'.$barisbudget)->getBorders()->getAllBorders() ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						$SI->getStyle('BC10:BZ'.$barisbudget)->getBorders()->getAllBorders() ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


						$SI->getStyle('Q13:Q'.$barisbudget)->getNumberFormat()->setFormatCode('#,##0.00'); 
						$SI->getStyle('R13:R'.$barisbudget)->getNumberFormat()->setFormatCode('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');
						$SI->getStyle('S13:S'.$barisbudget)->getNumberFormat()->setFormatCode('#,##0.00'); 


						$barisbudget++;
											
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
		
		
				
	
//END SHEET 7

//Memberi nama sheet
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