<style>
	.my-custom-scrollbar {
		position: relative;
		height: 400px;
		overflow: auto;
	}
	.table-wrapper-scroll-y {
		display: block;
	}
</style>
<script>

	function open_childX(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};
	function pil_add(){
		$("#list_part").html('');
		var lstctrl=document.frmcari.noctrlplh.value;
		if(lstctrl==""){alert('ANDA BELUM MEMILIH DATA');}else{
			jQuery.ajax({
			type: 'GET', // Post / Get method
			url: 'select/list_noctrl2.php',
			dataType:"text", 
			data: {'ctrl':lstctrl}, 
			success:function(response){
				$("#list_part").append(response);
				$('#mdplhpr').modal('show');
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}
		});
		}
	};
</script>
<?php 
$sect= $_SESSION["area"];
$pic=$_SESSION["nama"];
$dept_code=odbc_exec($koneksi_lp,"select dept_code from bps_dept where sect='$sect' ");
$dpt_cd=odbc_result($dept_code,"dept_code");
IF($dpt_cd==''){$dept_cd='0000';}else{$dept_cd=$dpt_cd;}

if(isset($_POST['smpn_pr']) ){
	$bln=date("Ym");
	$nopr=0;
	$qry_nopr="select max(RIGHT(pr_no,3)) as jj from bps_pr where sect='$sect' and convert(nvarchar(6),pr_date,112)='$bln'";
	//periode='$per_tmp'";
	$tb_nopr=odbc_exec($koneksi_lp,$qry_nopr);
	while($bar_nopr=odbc_fetch_array($tb_nopr)){
		$nopr=odbc_result($tb_nopr,"jj");
	}
	$nopr=$nopr+1;	
	$nopr3=substr('000'.$nopr,-3);

	$idtmp=$pic."-".date("Ymd-His");
	$pr_date=$_POST["pr_date"];
	// $req_date=$_POST["req_date"];
	$rmk_pr=strtoupper($_POST["rmk_pr"]);
	$pr_no=$sect."-".date("ym",strtotime($pr_date))."-".$nopr3;
	foreach ($_POST['plh'] as $_boxValue2)
	{
		
		$np2=explode("|",$_boxValue2);	

		$qrycrdtquo="select top 1 kode_supp,No_Quo from bps_Quotation where lp_rekom='YES' and part_no='$np2[9]' and Exp_Quo>='$np2[10]' order by tgl_updt desc";

		$tb_crdtquo=odbc_exec($koneksi_lp,$qrycrdtquo);
		$supkod="";$noquo="";
		while($bar_crdtquo=odbc_fetch_array($tb_crdtquo)){
			$supkod=odbc_result($tb_crdtquo,"kode_supp");
			$noquo=odbc_result($tb_crdtquo,"No_Quo");
		}	
		$q_update2="insert into bps_tmpPR(id_tmp_pr,periode,no_ctrl,part_no,part_nm,part_dtl,part_desc,uom,qty_plan,curr,price_plan,Qty_add,Price_add,exp_pr,penawaran,pemakaian,price_quo,qty_tot,price_tot,amount,sisa_bud,pic_updt,tgl_updt,pr_date,pr_no,term,kode_supp,no_quo,cccode,lp,qty_act,phase,account,carline_code,dept_code,req_date) ";

		$q_update2val="SELECT top 1 '".$idtmp."' as id_tmp_pr, periode, no_ctrl, part_no, part_nm, part_dtl,(case when part_desc is null then '-' else part_desc end) as part_desc,uom, qty as qty_plan, curr,price as price_plan,isnull ( dbo.lp_cr_QPadd ('Qty',no_ctrl,'OPEN'),0) as Qty_add,isnull(dbo.lp_cr_QPadd('Price',no_ctrl,'OPEN'),0) as Price_add, dbo.cr_waktulp ('pr',no_ctrl) as exp_pr,dbo.cr_proseslp ('quo',id_proses) as penawaran,'".$np2[6]."' as pemakaian, '".$np2[7]."' as price_quo,qty + isnull(dbo.lp_cr_QPadd ('Qty',no_ctrl,'OPEN'),0) as qty_tot,'".$np2[2]."' as price_tot,'".$np2[3]."' as amount,'".$np2[5]."' as sisa_bud,'".$pic."' as pic_updt,getdate() as tgl_updt,'$pr_date' as pr_date,'$pr_no' as pr_no,term,'$supkod' as kode_supp,'$noquo' as no_quo,cccode,lp,'".$np2[1]."' as qty_act,'".$np2[8]."' as phase,'".$np2[12]."' as account,'".$np2[11]."' as carline_code,'$dept_cd' as dept_code, dbo.cr_waktulp ('vp',no_ctrl) as req_date from bps_budget  where no_ctrl='".$np2[0]."' and no_ctrl not in (select no_ctrl from bps_budget_add where no_ctrl=bps_budget_add.no_ctrl and kode_chg in (4,5))
		UNION
		SELECT top 1 '".$idtmp."' as id_tmp_pr,periode,no_ctrl,part_no,part_nm,part_dtl,(case when part_desc is null then '-' else part_desc end) as part_desc,uom, (case when kode_chg in (4,5) then 0 else (select qty from bps_budget where no_ctrl=bps_budget_add.no_ctrl and no_ctrl='".$np2[0]."') end ) as qty_plan, curr,(case when kode_chg in (4,5) then 0 else (select price from bps_budget where no_ctrl=bps_budget_add.no_ctrl and no_ctrl='".$np2[0]."') end ) as price_plan,isnull( dbo.lp_cr_QPadd ('Qty',no_ctrl,'OPEN'),0) as Qty_add,isnull(dbo.lp_cr_QPadd('Price',no_ctrl,'OPEN'),0) as Price_add, dateadd(day,-(lt_po+lt_vp+lt_datang+1),expaired) as exp_pr,dbo.cr_proseslp('quo',id_proses) as penawaran,'".$np2[6]."' as pemakaian, '".$np2[7]."' as price_quo,(case when kode_chg in (4,5) then 0 else (select qty from bps_budget where no_ctrl=bps_budget_add.no_ctrl and no_ctrl='".$np2[0]."') end ) + isnull(dbo.lp_cr_QPadd ('Qty',no_ctrl,'OPEN'),0) as qty_tot,
		'".$np2[2]."' as price_tot,'".$np2[3]."' as amount,'".$np2[5]."' as sisa_bud,'".$pic."' as pic_updt,getdate() as tgl_updt,'$pr_date' as pr_date,'$pr_no' as pr_no,term,'$supkod' as kode_supp,'$noquo' as no_quo,cccode,lp,'".$np2[1]."' as qty_act,'".$np2[8]."' as phase,'".$np2[12]."' as account,'".$np2[11]."' as carline_code,'$dept_cd' as dept_code, dbo.cr_waktulp('vp',no_ctrl) as req_date  from bps_budget_add  where no_ctrl='".$np2[0]."' and kode_chg not in (1,2,3)";

		// echo $q_update2val." ".$req_date;
		$tb_part=odbc_exec($koneksi_lp,$q_update2." ".$q_update2val);
//echo "<script>alert('$np2[0]');</script>";
//echo "<script>alert('$i - $np2[6] - $np2[2] - $np2[3] - $np2[5] - $np2[0] - $np2[1] - $noctrl - $lsctrl[$i]');</script>";
	}

	$qry_tmp="select distinct periode,part_nm from bps_tmpPR where id_tmp_pr='$idtmp' order by periode";
	$tb_tmp=odbc_exec($koneksi_lp,$qry_tmp);
	while($bar_tmp=odbc_fetch_array($tb_tmp)){
		$per_tmp=odbc_result($tb_tmp,"periode");
		$partnm_tmp=odbc_result($tb_tmp,"part_nm");

		$qry_adpr="insert into bps_pr(pr_no,remark,no_ctrl,pr_date,qty,price,curr,term,periode,sect,cccode,pic_updt,tgl_updt) select pr_no as pr_no,'$rmk_pr' as remark,no_ctrl,pr_date,qty_act as qty,price_tot as price,curr,term,periode,'$sect' as sect,cccode,'$pic' as pic_updt,getdate() as tgl_updt from bps_tmpPR where id_tmp_pr='$idtmp' and periode='$per_tmp'";
		// echo $qry_adpr;
		$tb_adpr=odbc_exec($koneksi_lp,$qry_adpr);
//echo $qry_adpr;
	}
	$amoun_USD=0;
	$amoun_IDR=0;
//$sql_amount="select pr_no,sum(dbo.lp_konprc(term,'IDR',curr,qty*price)) as idr,sum(dbo.lp_konprc(term,'USD',curr,qty*price)) as dolar from bps_pr where pr_no='$pr_no' group by pr_no";
	$sql_amount="select distinct pr_no,sum(dbo.lp_konprc(term,'IDR',curr,qty_tot*price_tot)) as idr,sum(dbo.lp_konprc(term,'USD',curr,qty_tot*price_tot)) as dolar,sum(qty_add) as qty_add,sum(price_add) as prc_add from bps_tmppr where pr_no='$pr_no' group by pr_no";
	$tb_amount=odbc_exec($koneksi_lp,$sql_amount);
	$qty_add="";$prc_add="";
	while($bar_moun=odbc_fetch_array($tb_amount)){
		$amoun_USD=odbc_result($tb_amount,"dolar");
		$amoun_IDR=odbc_result($tb_amount,"idr");
		$qty_add=odbc_result($tb_amount,"qty_add");
		$prc_add=odbc_result($tb_amount,"prc_add");
	}
//if($qty_add!="" or $prc_add!=""){$dokaprv="'PR','ADD'";}else{$dokaprv="'PR'";}
	$pchsec=explode("-",$sect);
	$dept=$pchsec[0];
	$qry_delaprv="delete from bps_approve where jns_doc in('PR') and no_doc='$pr_no'";
	$tb_delaprv=odbc_exec($koneksi_lp,$qry_delaprv);
	$qry_adaprv="insert into bps_approve(pic_plan,email_plan,no_doc,tgl_prepaire,jns_doc,sect,initial,approve,no_aprv,nik)
	SELECT nama as pic_plan,email as email_plan,'$pr_no' as no_doc,getdate() as tgl_prepaire,
	'PR' as jns_doc,sect,initial,approve,no_aprv,right('000000'+nik,6)[nik]  FROM bps_setApprove where jns_dok in('PR') and 
	(sect='$sect' or sect='$dept-ALL' or (sect='SAMI-ALL' AND (max_amount='0' or 
	(min_amount<='$amoun_IDR' and max_amount>'$amoun_IDR'))))";
//$amoun_USD
	$tb_delaprv=odbc_exec($koneksi_lp,$qry_adaprv);
//echo $qry_adaprv;
//echo "<script>window.close();</script>";
	echo "<script>alert('DATA BERHASIL DISIMPAN DENGAN NO PR $pr_no');</script>";
}
?>

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Purchase Requisition</h2>
		</div>
		
		<div class="row clearfix">	
			<div class="card">
				<div class="row clearfix">		
					<div class="header">
						<h2>Record<small>Cari Budget untuk Pembbuatan PR</small></h2>
					</div>
					<div class="body">
						<form action="" id="frmcari" method="post"  enctype="multipart/form-data">

							<div class="col-sm-2">	
								<div class="form-group">
									<label>Periode</label>
									<select class="selectpicker" style="width: 100%;"  name="peri" id="peri" required>
										<option selected="selected" value="">--Pilih Periode--</option>
										<?php
			//$tb_peri=odbc_exec($koneksi_lp,"select distinct periode from bps_budget where periode>=convert(nvarchar(6),getdate(),112) order by periode asc");
										$tb_peri=odbc_exec($koneksi_lp,"select distinct periode from bps_budget where periode>=convert(nvarchar(6),getdate(),112) order by periode asc");
										while($baris1=odbc_fetch_array($tb_peri)){ 
											$peri=odbc_result($tb_peri,"periode");
											echo '<option value="'.$peri.'">'.$peri.'</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-sm-2">	
								<div class="form-group">
									<label>Curr</label>
									<select class="selectpicker" style="width: 100%;"  name="dt_cur" id="dt_cur" required>
										<option selected="selected" value="">--Curr--</option>
										<?php
										$tb_kurs_code=odbc_exec($koneksi_lp,"select distinct curr from bps_budget where sect='$sect' union select distinct curr from bps_budget_add where sect='$sect' and kode_chg in (4,5)");
										while($barkurs_code=odbc_fetch_array($tb_kurs_code)){ 
											$kurs_code=odbc_result($tb_kurs_code,"curr");
											echo '<option value="'.$kurs_code.'">'.$kurs_code.'</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-sm-2">	
								<div class="form-group">
									<label>Phase</label>
									<select class="selectpicker" style="width: 100%;"  name="dt_phs" id="dt_phs" required>
										<option selected="selected" value="">--Phase--</option>
										<?php
										$tb_phs=odbc_exec($koneksi_lp,"select distinct phase from bps_budget where sect='$sect' union select distinct phase from bps_budget_add where sect='$sect' and kode_chg in (4,5)");
										while($tb_phs_code=odbc_fetch_array($tb_phs)){ 
											$phs_code=odbc_result($tb_phs,"phase");
											echo '<option value="'.$phs_code.'">'.$phs_code.'</option>';
										}
										?>												
									</select>
								</div>
							</div>

							<div class="col-sm-3">	
								<div class="form-group">
									<label>Optional Filter</label>
									<select class="selectpicker" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
										<option selected="selected" value="">---Pilih Kolom---</option>
										<option value="no_ctrl">CONTROL NO</option>
										<option value="lp">PURCHASING</option>
										<option value="id_proses">KODE PROSES</option>
										<option value="account">ACCOUNT</option>
										<option value="sub_acc">SUB ACCOUNT</option>
										<option value="part_no">PART NO</option>
										<option value="part_nm">PART NAME</option>
										<option value="part_dtl">DETAIL PART</option>
										<option value="cv_code">Conveyor</option>
										<option value="qty">QTY</option>
										<option value="uom">UOM</option>
										<option value="price">PRICE</option>
										<option value="expaired">EXPAIRED DATE</option>
									</select>
								</div>
							</div>

							<div class="col-sm-3">	
								<div class="form-group">
									<label>Detail Filter</label>
									<div class="form-line">
										<input type="text" class="form-control" data-role="tagsinput" id="txt_cari" name="txt_cari" placeholder="Detail Pencarian">
									</div> 
								</div>
							</div>

							<div class="col-sm-2">
								<button type="submit" name="cr_b" id="cr_b" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">search</i> </button>
								<button type="reset" name="reset" id="reset" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">clear</i> </button>
							</div>
						</form>
					</div>	
				</div>
			</div>
		</div>
		<?php
		if(isset($_POST['cr_b']) ){	
			$peri=$_POST['peri'];
			$dt_phs=$_POST['dt_phs'];
			$dt_cur=$_POST['dt_cur'];
			$cmd_cari=$_POST['cmd_cari'];
			$txt_cari=str_replace(" ","",$_POST['txt_cari']);
			if($txt_cari==""){$whr=""; }else{
				$whr=" and replace($cmd_cari,' ','') like '%$txt_cari%'";}
				$whrfix="sect='$sect' and periode='$peri' and curr='$dt_cur' and phase='$dt_phs'";
				$qrycrdt="select (count(*)+(select count(*) as jmc from bps_budget_add where $whrfix $whr)) as jmc from bps_budget where $whrfix $whr";
				$tb_crdt=odbc_exec($koneksi_lp,$qrycrdt);
				$jm=0;
				while($barcrdt=odbc_fetch_array($tb_crdt)){
					$jm=odbc_result($tb_crdt,"jmc");
				}
				if($jm==0){
					echo "<script>alert('TIDAK ADA DATA YANG DI CARI');</script>";
					//echo $qrycrdt;
				}
				else
				{	
					?>

					<div class="row clearfix">
						<div class="card">
							<form action="" id="frmcari" name="frmcari" method="post" enctype="multipart/form-data">
								<div class="row clearfix">				
									<div class="header">
										<h2>Buat Purchase Requisition (PR) Section <?php echo $sect; ?></h2>
									</div>
									<div class="body">
										<div class="col-sm-3">	
											<div class="form-group">
												<label>Periode</label>
												<div class="form-line">
													<input type="text" readonly name="plhperi" id="plhperi" value="<?php echo $peri; ?>" class="form-control"  required>
												</div>
											</div>
										</div>
										<div class="col-sm-3">	
											<div class="form-group">
												<label>PR Date</label>
												<div class="form-line">
													<input type="text" name="pr_date" id="pr_date" value="<?php echo date("Y-m-d",strtotime("now"));?>" class="form-control date-min"  required>
												</div>
											</div>
										</div>
										<!-- <div class="col-sm-3">	
											<div class="form-group">
												<label>Req Date</label>
												<div class="form-line">
													<input type="text" name="req_date" id="req_date" value="<?php // echo date("Y-m-d",strtotime("now"));?>" class="form-control date-min"  required>
												</div>
											</div>
										</div> -->
										<div class="col-sm-3">	
											<div class="form-group">
												<label>Remark PR</label>
												<div class="form-line">
													<textarea type="text" name="rmk_pr" id="rmk_pr" class="form-control"  required> </textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="body">
										<div class="table-wrapper-scroll-y my-custom-scrollbar">
											<table id="dtVerticalScroll_vvvv" class="table table-striped table-bordered " cellspacing="0" width="100%">	
												<thead>
													<tr>
														<th>Pilih</th>
														<!-- <th>Ada BC</th> -->
														<th>No Control</th>
														<th>Part No</th>
														<th>Part Name</th>
														<th>Part Detail</th>
														<th>Part Desc</th>
														<!--th>UOM</th-->
														<th>Plan Qty</th>
														<th>Add Qty</th>
														<th>Sisa Qty</th>
														<th>Curr</th>
														<th>Plan Price</th>
														<th>Add Price</th>
														<th>Tot. Price</th>
														<th>Amount Plan</th>
														<th>Qty Pakai</th>
														<th>Price pakai</th>
														<th>Bal. Amount</th>
														<th>Kebutuhan Quo.</th>
														<th>Price Quo.</th>
														<th>Expaired PR</th>
														<th>Purchasing</th>
														<th>Remark</th>
														<th>Cost Center</th>
														<th>CV Code</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sq_acc="select periode,phase,lp,no_ctrl,part_no,part_nm,part_dtl,part_desc,uom,qty,qty_add,curr,price,price_add,exp_pr,dbo.cr_proseslp('quo',id_proses)
													as penawaran ,account,act_bud,act_qty,(select top 1 isnull(price,0) from 
													bps_Quotation where part_no=b.part_no and lp_rekom='YES' and Exp_Quo>=b.expaired order by tgl_updt desc) as price_quo,cccode,expaired
													from mstr_budget b where $whrfix $whr and (qty+qty_add)>act_qty order by part_no asc";
																		// echo $sq_acc;
													$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
													$row=0;
													while($baris1=odbc_fetch_array($tb_acc)){
														$exp_bud=odbc_result($tb_acc,"expaired");
														$part_no=odbc_result($tb_acc,"part_no");	
														$act_bud=odbc_result($tb_acc,"act_bud");
														$Qplan=odbc_result($tb_acc,"qty");
														$price_quo=odbc_result($tb_acc,"price_quo");
														$act_qty=odbc_result($tb_acc,"act_qty");
														$prcplan=odbc_result($tb_acc,"price");
														$prcadd=odbc_result($tb_acc,"price_add");
														$Qadd=odbc_result($tb_acc,"qty_add");
														$no_ctrl=odbc_result($tb_acc,"no_ctrl"); 
														$ketquo=odbc_result($tb_acc,"penawaran");
														$cr_prc_quo=odbc_exec($koneksi_lp,"select top 1 price from bps_quotation where part_no='$part_no' and
															lp_rekom='YES' and exp_quo>='$exp_bud' order by tgl_updt desc");
														$prc_tgh=odbc_result($cr_prc_quo,"price");

														if($ketquo=='NO'){if($prc_tgh!=''){$price_quot=$prc_tgh;}else{$price_quot=$prcplan+$prcadd;}}else{$price_quot=$prc_tgh;}

														$phase=odbc_result($tb_acc,"phase");
														$account=odbc_result($tb_acc,"account");
														if($Qadd==0){$tot_qty=$Qplan-$act_qty;}else{$tot_qty=$Qplan+$Qadd-$act_qty;}
														if($price_quot==0){$price_ok=$prcplan;}else{$price_ok=$price_quot;}

														if($prcadd+$prcplan<$price_quot){$tot_prc=$prcplan;}
														else if($prcadd+$prcplan>$price_quot and $price_quot>0) {$tot_prc=$price_quot;}
														else {$tot_prc=$prcplan+$prcadd;}

														$amount_pln=($prcplan+$prcadd)*($Qplan+$Qadd);
														$amount=$tot_qty*$tot_prc;
																			//$sis_bud=$amount-$act_bud;
														$sis_bud=$amount_pln-$act_bud;
														$sis_bud1=$sis_bud-$amount;
														if($Qadd==0){$mount_quo=$price_quot;}else{
															$mount_quo=$price_quot*$Qadd;}
															if($sis_bud>0){
																$row++;
																$plh="on";$rmx_x="";

																$cccode=odbc_result($tb_acc,"cccode");
																$cr_car=odbc_exec($koneksi_lp,"select cv_code from lp_cv where cost_center_code='$cccode'");
																if($cccode==''){$cv_code='000';} else
																{$cv_code=odbc_result($cr_car,"cv_code");}
																if($tot_prc<$price_quot or $sis_bud<$tot_prc or $act_qty>=($Qadd+$Qplan)){$plh="off";}
																//$rmx_x="Harga Kurang";}
																if($ketquo=="YES" and $mount_quo<=0){$plh="off";}
																//$mount_quo$rmx_x=$rmx_x." Penawaran Belum";}
																?>	
																<!--tr onclick="pilih(this);"-->
																<tr>				
																	<td >
																		<?php if($plh=="on"){ ?>
																			<div class="switch" >
																				<label>
																					<input type="checkbox" name="plh[]" id="plh" value="<?php echo $no_ctrl.'|'.$tot_qty.'|'.$tot_prc.'|'.$amount_pln.'|'.$sis_bud.'|'.$sis_bud1.'|'.$amount.'|'.$price_quot.'|'.$phase.'|'.$part_no.'|'.$exp_bud."|".$cv_code."|".$account; ?>" onclick="dipilih(this.form);"><span class="lever"></span>
																					<input type="hidden" name="bc" id="bc[]">
																					<input type="hidden" name="bc" id="bc[]">
																				</label>
																			</div>
																		<?php } else{ echo '<i class="material-icons">clear</i>';} ?>
																	</td>
																	<!-- <td>
																		<select class="selectpicker" style="width: 100%;"  name="bc" id="bc" >
																			<option selected="selected" value="">---Pilih Kolom---</option>
																			<option value="yes">Yes</option>
																			<option value="no">No</option>
																		</select>
																	</td> -->
																	<!-- <td><i class="material-icons">add_circle</i></td> -->
																	<!-- <td><?php //echo $no_ctrl; ?></td> -->
																	<!--button onclick="kol(this);" type="button" >OPEN</button-->
																	<td><?php echo odbc_result($tb_acc,"no_ctrl"); ?></td>
																	<td><?php echo odbc_result($tb_acc,"part_no"); ?></td>
																	<td><?php echo odbc_result($tb_acc,"part_nm"); ?></td>
																	<td><?php echo odbc_result($tb_acc,"part_dtl"); ?></td>
																	<td><?php echo odbc_result($tb_acc,"part_desc"); ?></td>
																	<!--td><?php //echo odbc_result($tb_acc,"uom"); ?></td-->
																	<td><?php echo $Qplan; ?></td>
																	<td><?php echo $Qadd; ?></td>
																	<td><?php echo $tot_qty; ?></td>
																	<td><?php echo odbc_result($tb_acc,"curr"); ?></td>
																	<td><?php echo number_format($prcplan,2,".",","); ?></td>
																	<td><?php echo number_format($prcadd,2,".",","); ?></td>
																	<td><?php echo number_format($prcplan+$prcadd,2,".",","); ?></td>
																	<td><?php echo number_format($amount_pln,2,".",","); ?></td>
																	<td><?php echo number_format($act_qty,2,".",",");?></td>
																	<td><?php echo number_format($tot_prc,2,".",",");?></td>
																	<td><?php echo number_format($amount_pln-$act_bud,2,".",","); ?></td>
																	<td><?php echo $ketquo; ?></td>
																	<td><?php echo number_format($price_quot,2,".",","); ?></td>
																	<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_acc,"exp_pr"))); ?></td>
																	<td><?php echo odbc_result($tb_acc,"lp"); ?></td>
																	<td><?php echo $phase; ?></td>
																	<td><?php echo $cccode; ?></td>
																	<td><?php echo $cv_code; ?></td>
																</tr>	
																<?php
															}
														}
														?>
														<tr class="odd gradeX">
															<td align="center" valign="middle" nowrap="nowrap"><input type="checkbox"  name="plh[]" id="plh" value="-|0|0|0|0|0|0" ></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
															<td align="center" valign="middle" nowrap="nowrap"></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<?php if(isset($_POST['cr_b']) and $row>0){ ?>
										<div class="row clearfix">	
											<div class="body">		
												<button type="button" class="btn "  onclick="pil_add(); return false;"><i class="material-icons">search</i></button>		
											</div>
										</div>
									<?php } ?>
									<div class="modal fade" id="mdplhpr" tabindex="-1" role="dialog">
										<div class="modal-dialog modal-lg" role="document">
											<div class="modal-content">
												<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">List Budget Dipilih</h4>
												</div>
												<div class="modal-body">
													<div class="body">
														<input type="hidden" class="form-control" id="noctrlplh" name="noctrlplh" required>
														<div id="list_part">
														</div>
													</div>
													<div class="modal-footer">
														<button type="submit" id="smpn_pr" name="smpn_pr" class="btn bg-green waves-effect"><i class="material-icons">saves</i>Save</button>		
														<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>  
					<?php }
				} ?>
				<div class="row clearfix">
					<div class="card">
						<div class="header">
							<h2>Print Purchase Requisition (PR) Section <?php echo $sect; ?></h2>
						</div>
						<form action="" id="frm_rmk" name="frm_rmk" method="post"  enctype="multipart/form-data">
							<div class="row clearfix">
								<div class="body">
									<div class="table-responsive">
										<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
											<thead>
												<tr>	
													<th>PR NO</th>
													<th>PR DATE</th>
													<th>PERIODE</th>
													<th>QTY</th>
													<th>AMOUNT PR</th>
													<th>AMOUNT USD</th>
													<th>SECT</th>
													<th>REMARK</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sq_pr="SELECT distinct periode,pr_no,remark,pr_date,a.sect,request,sum(qty) as qty,sum(qty*price) as price,dbo.lp_konprc(term,'USD',curr,sum(qty*price)) as amUSD
												from bps_pr a inner join bps_approve b on a.PR_NO=b.no_doc 
												and a.sect=b.sect where request is null and a.sect='$sect' and b.status is null
												group by pr_no,remark,pr_date,a.sect,request,periode,term,curr order by pr_no,pr_date desc";
												$tb_pr=odbc_exec($koneksi_lp,$sq_pr);
												$i=0;
												while($bar_pr=odbc_fetch_array($tb_pr)){ $i++;
													$prno=odbc_result($tb_pr,"pr_no");
													$remark=odbc_result($tb_pr,"remark");
													?>	
													<tr >
														<td><div class="form-line">
															<input type="text" readonly name="prno1[]" id="prno1" value="<?php echo $prno; ?>" class="form-control"  required></div></td>
															<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_pr,"pr_date"))); ?></td>
															<td><?php echo odbc_result($tb_pr,"periode"); ?></td>
															<td><?php echo odbc_result($tb_pr,"qty"); ?></td>
															<td><?php echo number_format(odbc_result($tb_pr,"price"),2,".",","); ?></td>
															<td><?php echo number_format(odbc_result($tb_pr,"amUSD"),2,".",","); ?></td>
															<td><?php echo odbc_result($tb_pr,"sect"); ?></td>
															<td><?php echo $remark; ?></td>
															<td><button type="button" class="btn bg-green waves-effect" onclick="open_child('Exp_pdf/print_pr.php?nomor=<?php echo $i;?>&nopr=<?php echo $prno;?>','Print PR <?php echo $prno;?>','800','500'); return false;"><i class="material-icons">print</i></button></td>
														</tr>	
														<?php 
													}
													?>	
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</form> 
						</div>
					</div>
				</div>
			</section>
			<script>
				function dipilih(frm){
					var PlhData="";
					var PchData="";
					var data0="";
					var data1="<?php echo $row; ?>";
					if(data1==1){
						data0 += "<?php echo $no_ctrl; ?>,";
					}else{
						for (i = 0; i < frm.plh.length; i++){
							if (frm.plh[i].checked){
				//PlhData += frm.plh[i].value +",";
				var dataisi=frm.plh[i].value;
				PchData=dataisi.split('|');
				data0 += PchData[0] +",";
			}else{	
			}	
		}
	}
	document.frmcari.noctrlplh.value=data0;
}	
</script>

<script>
	function pilih(row){
		var kd_pel4=row.cells[3].innerHTML;
		alert(kd_pel4);
	}
	function kol(kol){
	// var kd2=kol.cellIndex;
	alert(kol+' dari tombol');
	var kd_pel1=kol.cells[1].innerHTML;
	var icoplus='<i class="material-icons">add_circle</i>';
	var icomin='<i class="material-icons">remove_circle</i>';
	alert(kd_pel1+icoplus);
	if(kd_pel1==icoplus){
		kol.cells[1].innerHTML=icomin;
	}else{
		kol.cells[1].innerHTML=icoplus;}
	}
</script>