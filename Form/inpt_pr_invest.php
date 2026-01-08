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

<script type="text/javascript">
	function open_child(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};
	function pil_add(){
		$("#list_part").html('');
		var lstctrl=document.frmcari.noctrlplh.value;
		if(lstctrl==""){
			alert('ANDA BELUM MEMILIH DATA');
		}else
		{
			jQuery.ajax({
			type: 'GET', // Post / Get method
			url: 'select/list_noctrl_inv.php',
			dataType:"text", 
			data: {'ctrl':lstctrl,'sesi':'<?php echo $_SESSION['lok']; ?>'}, 
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
error_reporting(0);
if(isset($_POST['smpn_pr']) )
{
	$sect= $_SESSION["area"];
	$qty_cip=$_POST["qty_cip"];
	$amount_plan=$_POST["amount"];
	$pic=$_SESSION["nama"];
	$pr_date=$_POST["pr_date"];
	$req_date=$_POST["req_date"];
	$rmk_pr=strtoupper($_POST["rmk_pr"]);
	$plh=$_POST['plh'] ;
	$qty=$_POST["qty"];
	// $set_qty=$_POST["qty_s"];
	$jml=count($plh);
	$bln=date("Ym");
	$nopr=0;

	$dept_code=odbc_exec($koneksi_lp,"select dept_code from bps_dept where sect='$sect' ");
	$dpt_cd=odbc_result($dept_code,"dept_code");

	IF($dpt_cd=='')
	{
		$dept_cd='0000';
	} else{
		$dept_cd=$dpt_cd;
	}

	$qry_nopr=odbc_exec($koneksi_lp,"select top 1 isnull(pr_no,'0-0-0-0') as pr_no from bps_pr where sect='$sect' and convert(nvarchar(6),pr_date,112)='$bln' and equipment_no is not null order by tgl_updt desc");
	$nomor_pr=odbc_result($qry_nopr,"pr_no");

	$pcpr=explode("-",$nomor_pr);
	$nopr=$pcpr[3]+1;
	$nopr3=substr('000'.$nopr,-3);
	$idtmp=$pic."-".date("Ymd-His");
	$pr_no=$sect."-".date("ym",strtotime($pr_date))."-".$nopr3."-INVEST";

	// if($qty[$i]!=0)
	// {
	for ($i=0; $i < $jml; $i++) 
	{
		$pisah=explode("|", $plh[$i]) ;
		$no_ctrl_p=$pisah[0];
		$p_no=$pisah[1];
		$no_ctrl=$pisah[3];
		$expired=$pisah[4];
		$car=$pisah[5];
		$qty_plan=$pisah[6];
		$price_plan=$pisah[7];
		$term_p=$pisah[8];

		$cr_quo="select top 1 kode_supp,No_Quo,price from bps_Quotation where lp_rekom='YES' and 
		part_no='$p_no' and Exp_Quo>='$expired' order by tgl_updt desc";
		$tb_cr_quo=odbc_exec($koneksi_lp,$cr_quo);
		$supkod=odbc_result($tb_cr_quo, "kode_supp");
		$noquo=odbc_result($tb_cr_quo, "No_Quo");
		$price_quo=odbc_result($tb_cr_quo, "price");

		$amount=$price_quo*$set_qty[$i]*$qty[$i];

		$cr_cccode=odbc_exec($koneksi_lp, "SELECT top 1 * FROM LP_CV where CARLINE='$car' and term='$term_p'  order by CV_CODE asc ") ;
		$cvcode=odbc_result($cr_cccode, "CV_CODE");

		$q_update2="insert into bps_tmpPR (id_tmp_pr,periode,no_ctrl,part_no,part_nm,part_dtl,uom,
		qty_plan,curr,price_plan,exp_pr,penawaran,price_quo,qty_tot,price_tot,amount,pic_updt,tgl_updt,pr_date,pr_no,term,kode_supp,no_quo,cccode,lp,qty_act,phase,account,carline_code,dept_code,req_date,equipment,ket_temp,qty_equipment) ";

		$q_update2val="SELECT top 1 '$idtmp' as id_tmp_pr, periode, no_ctrl_bud, part_no, part_nm,
		part_dtl,uom, qty as qty_plan, curr,$price_plan as price_plan,'$expired' as exp_pr,'YES' as penawaran, '$price_quo' as price_quo,$qty[$i] as qty_tot,'$price_quo' as price_tot,
		'$amount' as amount,'".$pic."' as pic_updt,getdate() as tgl_updt,'$pr_date' as pr_date,
		'$pr_no' as pr_no,term,'$supkod' as kode_supp,'$noquo' as no_quo,'$cvcode' as cccode,lp,
		'$qty[$i]' as qty_act,'INVEST' as phase,0 as account,'$car' as carline_code,
		'$dept_cd' as dept_code, '$req_date' as req_date,no_ctrl,'INVEST' as ket_temp,
		$qty_cip as qty_equipment from bps_budinvest_dtl where no_ctrl_bud='$no_ctrl_p'";

		echo $q_update2." ".$q_update2val;

		$tb_part=odbc_exec($koneksi_lp,$q_update2." ".$q_update2val);
	}
	// }
	$lht_pr=odbc_exec($koneksi_lp, "select sum(qty_act*price_tot) as amn from bps_tmpPR where pr_no='$pr_no' ") ;
	$total_bayar=odbc_result($lht_pr,'amn');

	if($total_bayar==0 or $total_bayar > $amount_plan){
		$del_tmppr=odbc_exec($koneksi_lp, "delete from bps_tmpPR where pr_no='$pr_no'" );
		// $del_pr=odbc_exec($koneksi_lp, "delete from bps_PR where pr_no='$pr_no'" );
		// $del_aprv=odbc_exec($koneksi_lp, "delete from bps_approve where no_doc='$pr_no'" );

		echo "<script>alert('AMOUNT PR TIDAK BOLEH = 0 atau AMOUNT PR TIDAK BOLEH LEBIH DARI PLAN BUDGET. CEK QTY ORDER DAN QTY SET. AMOUNT ORDER = $total_bayar DAN AMOUNT PLAN = $amount_plan ' );</script>";
	}
	/*
	else
	{
		*/
		$qry_adpr="insert into bps_pr(pr_no, remark, no_ctrl, pr_date, qty, price, curr, term, periode, sect, cccode, pic_updt, tgl_updt, equipment_no,
		qty_equipment,req_date)";
		
		$cr_pr="select pr_no as pr_no,'$rmk_pr' as remark,no_ctrl,pr_date,qty_act as qty,price_tot as price,curr,term,periode,
		'$sect' as sect,cccode,'$pic' as pic_updt,getdate() as tgl_updt,equipment,
		qty_equipment,req_date from bps_tmpPR where id_tmp_pr='$idtmp' ";
		// echo $qry_adpr;
		$tb_adpr=odbc_exec($koneksi_lp,$qry_adpr." ".$cr_pr);

		$sql_amount="select distinct pr_no,sum(dbo.lp_konprc(term,'IDR',curr,qty_tot*price_tot)) as idr,sum(dbo.lp_konprc(term,'USD',curr,qty_tot*price_tot)) as dolar,sum(qty_add) as qty_add,sum(price_add) as prc_add from bps_tmppr where pr_no='$pr_no' group by pr_no";
		$tb_amount=odbc_exec($koneksi_lp,$sql_amount);
		$amoun_USD=0;
		$amoun_IDR=0;
		$qty_add="";$prc_add="";
		while($bar_moun=odbc_fetch_array($tb_amount))
		{
			$amoun_USD=odbc_result($tb_amount,"dolar");
			$amoun_IDR=odbc_result($tb_amount,"idr");
			$qty_add=odbc_result($tb_amount,"qty_add");
			$prc_add=odbc_result($tb_amount,"prc_add");
		}

		$pchsec=explode("-",$sect);
		$dept=$pchsec[0];
		$qry_delaprv="delete from bps_approve where jns_doc in('PR') and no_doc='$pr_no'";
		$tb_delaprv=odbc_exec($koneksi_lp,$qry_delaprv);
		$qry_adaprv="insert into bps_approve(pic_plan, email_plan,no_doc,tgl_prepaire, jns_doc, sect,
		initial,approve,no_aprv,nik)
		SELECT nama as pic_plan,email as email_plan,'$pr_no' as no_doc,getdate() as tgl_prepaire,
		'PR' as jns_doc,sect,initial,approve,no_aprv,right('000000'+nik,6)[nik]  FROM bps_setApprove where status_akun='aktif' 
		and jns_dok in('PR','PR-INVEST') and (sect='$sect' or sect='$dept-ALL' or (sect='SAMI-ALL' AND 
		(max_amount='0' or (min_amount<='$amoun_IDR' and max_amount>'$amoun_IDR'))))";

		$tb_delaprv=odbc_exec($koneksi_lp,$qry_adaprv);

		$tb_creatpr=odbc_exec($koneksi_lp,$cr_pr);
		if($amoun_USD>0){
			echo "<script>alert('DATA BERHASIL DISIMPAN DENGAN NO PR $pr_no. AMOUNT ORDER = $total_bayar DAN AMOUNT PLAN = $amount_plan');</script>";
		}

	// if($total_bayar==0 or $total_bayar>$amount_plan){
	// 	$del_tmppr=odbc_exec($koneksi_lp, "delete from bps_tmpPR where pr_no='$pr_no'" );
	// 	$del_pr=odbc_exec($koneksi_lp, "delete from bps_PR where pr_no='$pr_no'" );
	// 	$del_aprv=odbc_exec($koneksi_lp, "delete from bps_approve where no_doc='$pr_no'" );

		// echo "<script>alert('AMOUNT PR TIDAK BOLEH = 0 atau AMOUNT PR TIDAK BOLEH LEBIH DARI PLAN BUDGET. CEK QTY ORDER DAN QTY SET');</script>";
	// }
	}

	?>

	<section class="content">
		<div class="container-fluid">
			<div class="block-header">
				<h2>Purchase Requisition Budget Invest</h2>
			</div>

			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>Record<small>Cari Budget untuk Pembbuatan PR Invest</small></h2>
						</div>
						<div class="row clearfix">
							<div class="body">
								<form action="" id="frmcari" method="post"  enctype="multipart/form-data">

									<div class="col-sm-2">	
										<div class="form-group">
											<label>Delivery Order</label>
											<div class="input-group">
												<input type="number" readonly class="periodemn bg-grey form-control" id="peri" name="peri" value="<?php echo date("Ym"); ?>" placeholder="Periode Plan" required>
											</div>
										</div>
									</div>
									<div class="col-sm-3">	
										<div class="form-group">
											<label>CIP NO</label>
											<div class="input-group">
												<select class="selectpicker" style="width: 100%;"  name="dt_phs" id="dt_phs" required>
													<option selected="selected" value="">--Phase--</option>
													<?php
													$tb_phs=odbc_exec($koneksi_lp,"select distinct no_ctrl,cip_no,bud_group from bps_budget_invest where sect='$sect' and periode>=convert(nvarchar(6),getdate(),112)
														union
														select distinct no_ctrl,cip_no,bud_group from bps_budget_invest_add where sect='$sect' and periode>=convert(nvarchar(6),getdate(),112) 
														and doc_no is not null and kode_chg in (4,5) order by cip_no asc ");
													// $row=0;
													while($tb_phs_code=odbc_fetch_array($tb_phs))
													{
														// $row++;
														$no_ctrl_g=odbc_result($tb_phs,"no_ctrl");
														$phs_code=odbc_result($tb_phs,"cip_no");
														$bud_group=odbc_result($tb_phs,"bud_group");
														echo '<option value="'.$phs_code.'|'.$no_ctrl_g.'|'.$bud_group.'">CIP '.round($phs_code).' - '.$bud_group.'</option>';
													}
													?>												
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label>Currency</label>
											<select class="selectpicker form-control show-tick" style="width: 100%;"  name="curr" id="curr" required>
												<option selected="selected" value="">--Currency--</option>
												<?php
												$tb_kurs_code=odbc_exec($koneksi_lp,"select distinct curr from bps_budinvest_dtl where sect='$sect' ");
												while($barkurs_code=odbc_fetch_array($tb_kurs_code)){ 
													$kurs_code=odbc_result($tb_kurs_code,"curr");
													echo '<option value="'.$kurs_code.'">'.$kurs_code.'</option>';
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
												<option value="part_no">PART NO</option>
												<option value="part_nm">PART NAME</option>
												<option value="part_dtl">PART DETAIL</option>
												<option value="uom">UOM</option>
												<option value="lp">PURCHASING</option>
											</select>
										</div>
									</div>

									<div class="col-sm-2">	
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
			</div>
			<?php
			if(isset($_POST['cr_b']) ){
				$peri=$_POST['peri'];
				$curr=$_POST["curr"];
				$bud_group=$_POST['dt_phs'];
				$cmd_cari=$_POST['cmd_cari'];
				$txt_cari=str_replace(" ","",$_POST['txt_cari']);
				if($txt_cari==""){
					$whr=""; 
				}else{
					$whr=" and replace($cmd_cari,' ','') like '%$txt_cari%'";
				}
				$pch_group=explode("|", $bud_group);
			// $whrfix="a.sect='$sect' and a.periode='$peri' and a.bud_group='$bud_group' and a.curr='$curr' ";
				$whrfix="a.sect='$sect' and a.periode='$peri' and a.no_ctrl='$pch_group[1]' and a.curr='$curr' ";
				$qrycrdt="select distinct count(*) as jmc,term from bps_budinvest_dtl a where $whrfix $whr group by TERM";
			//	echo $qrycrdt;
				$tb_crdt=odbc_exec($koneksi_lp,$qrycrdt);
				$jm=0;
				while($barcrdt=odbc_fetch_array($tb_crdt)){
					$jm=odbc_result($tb_crdt,"jmc");
					$term=odbc_result($tb_crdt,"term");
				}
				if($jm==0){
					echo "<script>alert('TIDAK ADA DATA YANG DI CARI');</script>";
					// echo $qrycrdt;
				}
				else
				{
					$cr_kurs=odbc_exec($koneksi_lp, "SELECT distinct KURS_CODE,KURS,TERM FROM bps_kurs
						where KURS_CODE='$curr' and term='$term' ") ;
					$kurs=odbc_result($cr_kurs, "KURS");

					// $cr_data="select distinct a.no_ctrl,a.qty as qty_plan,
					// dbo.lp_konprc(a.term,'$curr','USD',a.price) as price_g,
					// a.qty*dbo.lp_konprc(a.term,'$curr','USD',a.price) as amn_pln,SUM(b.Qty*b.price) AS 
					// act_amn,qty_equipment,
					// isnull( dbo.lp_cr_QPadd_inv ('Qty',a.no_ctrl,'OPEN'),0) as Qty_add,
					// dbo.lp_konprc(a.term,'$curr','USD',isnull( dbo.lp_cr_QPadd_inv ('price',a.no_ctrl,'OPEN'),0)) as Price_add 
					// from bps_budget_invest a left join bps_PR b
					// on a.no_ctrl=b.equipment_no where a.sect='$sect' and a.periode='$peri' 
					// and	a.no_ctrl='$pch_group[1]'
					// group by a.sect,a.no_ctrl,a.qty,a.price,qty_equipment,a.periode,a.term";
//bps_budget_invest
//bps_v_dtlinvest
					$cr_data="select distinct a.no_ctrl,a.qty as qty_plan, 
					dbo.lp_konprc(a.term,'$curr','USD',a.price) as price_g, 
					a.qty*dbo.lp_konprc(a.term,'$curr','USD',a.price) as amn_pln,
					isnull(SUM(b.Qty*b.price),0) AS act_amn,isnull(qty_equipment,0) as qty_equipment, 
					isnull( dbo.lp_cr_QPadd_inv ('Qty',a.no_ctrl,'OPEN'),0) as Qty_add, 
					isnull( dbo.lp_konprc(a.term,'$curr','USD',dbo.lp_cr_QPadd_inv ('price',a.no_ctrl,'OPEN')),0) as Price_add from bps_budget_invest a 
					left join bps_PR b on a.no_ctrl=b.equipment_no where a.sect='$sect' and a.periode='$peri' and	a.no_ctrl='$pch_group[1]'
					group by a.sect,a.no_ctrl,a.qty,a.price,qty_equipment,a.periode,a.term
					union
					select distinct a.no_ctrl,0 as qty_plan,0 as price_g, a.qty*dbo.lp_konprc(a.term,'$curr','USD',a.price) as amn_pln,
					isnull(SUM(b.Qty*b.price),0) AS act_amn,isnull(b.qty_equipment,0) as qty_equipment, 
					a.qty as Qty_add, isnull( dbo.lp_konprc(a.term,'$curr','USD',a.price),0)  as Price_add from bps_budget_invest_add a 
					left join bps_PR b on a.no_ctrl=b.equipment_no where a.sect='$sect' and a.periode='$peri' and	a.no_ctrl='$pch_group[1]' and kode_chg in (4,5)
					group by a.sect,a.no_ctrl,a.qty,a.price,qty_equipment,a.periode,a.term ";


				// $cr_data="select sum(dbo.lp_konprc(term,'$curr','USD',qty*price)) as plan_amn ,
				// (select distinct isnull(SUM(Qty*price),0) from bps_PR where pr_no like '%invest%' and 
				// sect=a.sect and periode=a.periode and equipment_no=a.no_ctrl) as act_amn
				// from bps_budget_invest a where a.sect='$sect' and a.periode='$peri' and 
				// a.no_ctrl='$pch_group[1]' group by a.sect,a.periode,a.no_ctrl";
				//echo $cr_data;

					$tb_data=odbc_exec($koneksi_lp, $cr_data);
					$qty_equipment=0;$amn=0;
					while($baris=odbc_fetch_array($tb_data)){
						$price_add=$baris["Price_add"];
						$qty_add=$baris["Qty_add"];
						$price_g=$baris["price_g"];
						$qty_plan=$baris["qty_plan"];
						$qty_equipment=$qty_equipment+$baris["qty_equipment"];
						$qty_sisa=$qty_plan-$qty_equipment;
						$qty_tot=$qty_plan+$qty_add;
						$price_tot=$price_g+$price_add;
						$amn_tot=$price_tot*$qty_tot;

						$amn=$amn+$baris["act_amn"];
						// $plan_amn=$amn_tot["amn_pln"];
						// $plan_amn=$amn_tot["amn_pln"];
						// $amn=$amn+$amn_tot;
						// $tot_amn=$plan_amn-$amn;
						if($curr=="IDR"){
							$sisa_amn=round($amn_tot-$amn,0);
						}
						else{
							$sisa_amn=$amn_tot-$amn;
						}
					}
					?>
					<div class="row clearfix">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="card">
								<div class="header">
									<h2>Buat Purchase Requisition (PR) Section <?php echo $sect; ?></h2>
								</div>
								<form action="" id="frmcari" name="frmcari" method="post" enctype="multipart/form-data">
									<div class="body">
										<input type="hidden" name="curr_plh" value="<?= '$curr'; ?>" />
										<div class="row clearfix">
											<div class="col-sm-3">
												<div class="form-group">
													<label>Periode</label>
													<div class="form-line">
														<input type="text" name="plhperi" id="plhperi" value="<?php echo $peri; ?>" class="form-control"  required>
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

											<div class="col-sm-3">
												<div class="form-group">
													<label>Required Date</label>
													<div class="form-line">
														<input type="text" name="req_date" id="req_date" value="" class="form-control date-min" required placeholder="Tanggal Kedatangan" >
													</div>
												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label>Set Plan Qty</label>
													<div class="form-line">
														<input type="number" name="qty_cip" id="qty_cip" min=1 max="<?= max(round($sisa_amn/$price_tot),$qty_sisa); ?>" step=1 value="<?= max(round($sisa_amn/$price_tot),$qty_sisa); ?>" class="form-control" onchange="sum();" required/>													
													</div>
												</div>
											</div>

										</div>
										<div class="row clearfix">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Remark PR</label>
													<div class="form-line">
														<input type="text" name="rmk_pr" id="rmk_pr" class="form-control">
													</div>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label class="text-center">Price CIF</label>
													<div class="form-line">
														<input type="text" id="price_g" name="price_g" value="<?= round($price_tot,0) ;?>" class="form-control" readonly/>
													</div>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label class="text-center">Total Plan Budget (<?= $curr ?>) </label>
													<div class="form-line">
														<input type="hidden" value="<?= $sisa_amn ;?>" name="amount" id="amount" class="form-control">
														<input type="text" value="<?= number_format(round($sisa_amn,0),2) ;?>" name="amount_p" id="amount_p" class="form-control">
													</div>
												</div>
											</div>
										</div>
										<?php if($sisa_amn<($plan_amn/4)){ ?>
											<div class="row clearfix">
												<div class="alert bg-red alert-dismissible" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													Budget INVEST Section anda sudah limit
												</div>
											</div>
										<?php } ?>

									</div>
									<div class="row clearfix">
										<div class="body">
											<div class="nilai table-wrapper-scroll-y my-custom-scrollbar">
												<table id="nilai" class="table table-striped table-bordered " cellspacing="0" width="100%">
													<thead>
														<tr>
															<th class='with-checkbox'>
																<input type="checkbox" name="check_all" id="check_all" onclick="dipilihALL(this.form)" />Pilih
															</th>
															<th>CIP No.</th>
															<th>Part No</th>
															<th>Desc</th>
															<!-- <th>Qty set</th> -->
															<th>Uom</th>
															<th>Curr</th>
															<th>Price Plan</th>
															<th>Price Quotation</th>
															<th>Purchasing</th>
															<th>Qty Order</th>
															<th>Reason</th>
														</tr>
													</thead>
													<tbody>
														<?php
														//and a.periode=b.periode
														$sq_acc="select a.no_ctrl, a.no_ctrl_bud,a.part_no,a.part_nm,a.part_dtl,
														b.qty,a.qty as qty_p,a.uom,a.curr,a.lp,a.price,
														isnull((select top 1 price from bps_Quotation where lp_rekom='YES' 
														and Exp_Quo>=b.expired and part_no=a.part_no order by exp_quo desc,tgl_updt desc),0) as price_quo,
														b.carline, b.expired,b.price as plan_bud
														from bps_budinvest_dtl a inner join bps_budget_invest b 
														on a.no_ctrl=b.no_ctrl  and a.periode=b.periode
														where $whrfix
														union 
														select a.no_ctrl, a.no_ctrl_bud,a.part_no,a.part_nm,a.part_dtl,
														b.qty,a.qty as qty_p,a.uom,a.curr,a.lp,a.price,
														isnull((select top 1 price from bps_Quotation where lp_rekom='YES' 
														and Exp_Quo>=b.expired and part_no=a.part_no  order by exp_quo desc,tgl_updt desc),0) as price_quo,
														b.carline, b.expired,b.price as plan_bud
														from bps_budinvest_dtl a inner join bps_budget_invest_add b 
														on a.no_ctrl=b.no_ctrl and a.periode=b.periode
														where $whrfix and kode_chg in (4,5) ";
													//echo $sq_acc;
														$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
														$row=0;$amount=0;
														while($baris1=odbc_fetch_array($tb_acc)){
															$row++;
															$price_quo=$baris1['price_quo'];
															$price=round($baris1['price'],0);
															$qty_s=$baris1['qty'];
															$qty_p=$baris1['qty_p'];
															$no_ctrl=$baris1['no_ctrl'];
															$no_ctrl_p=$baris1['no_ctrl_bud'];
															$part_no=$baris1['part_no'] ;
															$part_nm=$baris1['part_nm'];
															$curr_ori=$baris1['curr'] ;
															$carline=$baris1['carline'] ;
															$expired=$baris1['expired'] ;

														// if($price_quo<=0 or $price_quo>$amn)
															if($price_quo<=0 ){
																$row++;
																$reason="Budget sudah kosong";
																$plh="off";
															} else if( $sisa_amn<=1 ){
																$row++;
																$reason="Qty Kurang";
																$plh="off";
															}
															else if($sisa_amn<$price_quo){
																$row++;
																$reason="Budget kurang" ;
																$plh="off";
															}
															else{
																$plh="on";
															}
															// echo $price_quo."<br>".$sisa_amn;
															?>
															<tr>
																<td >
																	<?php if($plh=="on"){ ?>
																		<div class="switch" >
																			<label>
																				<input type="checkbox" name="plh[]" id="plh" value="<?= $no_ctrl_p."|".$part_no."|".$curr_ori."|".$no_ctrl."|".$expired."|".$carline."|".$qty_s."|".$price."|".$term ; ?>" onclick="dipilih(this.form);">
																				<span class="lever"></span>
																			</label>
																		</div>
																	<?php }
																	else
																	{ 
																		echo '<i class="material-icons">clear</i>';
																	} 
																	?>
																</td>
																<td align="center">CIP <?= round($pch_group[0],0) ; ?> </td>
																<td><?= $part_no ; ?> </td>
																<td><?= $part_nm." ".$baris1['part_dtl'] ; ?> </td>
																<!-- <td><input type="number" step="any" min=1 name="qty_s[]" id="qty_s<?= $i; ?>" max="<?= $qty_s ; ?>" value="<?= $qty_s ; ?>" onchange="total()" class="form-control text-center" /> </td> -->
																<td><?= $baris1['uom'] ; ?> </td>
																<td><?= $curr_ori ; ?> </td>
																
																<td><?= number_format($baris1['price'],2)  ; ?> </td>
																<td><input type="text" name="price_quo[]" id="price_quo<?= $i; ?>" value="<?= number_format($baris1['price_quo'],2)  ; ?>" onchange="total()" class="form-control text-center" readonly />
																</td>
																<td><?= $baris1['lp'] ; ?> </td>
																<td>
																	<?php if($plh=="on"){ ?>
																		<input type="number" step="any" min=0 name="qty[]" id="qty<?= $i; ?>" value="<?= $qty_p ; ?>" onchange="total()" class="form-control text-center" />
																		<!-- <input type="number" min=0 max="<?= $qty ;?>" name="qty[]" class="form-control text-center" value="<?= $qty ;?>"> -->
																	<?php }else { ?>
																		<input type="number" class="form-control" placeholder="Disabled" disabled />
																	<?php } ?>
																</td>
																<td><?= $reason ; ?></td>
															</tr>
															<?php
														}
													}
													?>
													<tr class="odd gradeX">
														<td colspan="11" align="center" valign="middle" nowrap="nowrap"><input type="checkbox"  name="plh[]" id="plh" value="-|0|0|0|0|0|0" ></td>	
													</tr>
												</tbody>
											</table>
										</div>
										<?php if(isset($_POST['cr_b']) and $row>0){ ?>
											<div class="row clearfix">
												<div class="body">
													<button type="button" class="btn " onclick="pil_add(); return false;"><i class="material-icons">search</i></button>
												</div>
											</div>
											<?php 
										} 
										?>
									</div>
								</div>
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
				</div>
			</div>
			<?php 
		}
		?>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
											and a.sect=b.sect where request is null and a.sect='$sect' and b.status is null and pr_no like '%INVEST'
											group by pr_no,remark,pr_date,a.sect,request,periode,term,curr order by pr_no,pr_date desc";
									// echo $sq_pr;
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
														<td><button type="button" class="btn bg-green waves-effect" onclick="open_child('Exp_pdf/print_pr_invest.php?nomor=<?php echo $i;?>&nopr=<?php echo $prno;?>','Print PR <?php echo $prno;?>','800','500'); return false;"><i class="material-icons">print</i></button></td>
													</tr>	
												<?php }
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
		


		<script type="text/javascript">
			function dipilih(frm){
				var PlhData="";
				var PchData="";
				var data0="";
				var data1="<?php echo $row; ?>";
				if(data1==1){
					data0 += "<?php echo $no_ctrl_p; ?>,";
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

function pilih(row){
	var kd_pel4=row.cells[3].innerHTML;
	alert(kd_pel4);
}

$(document).ready(function()
{
	$('.periodemn').bootstrapMaterialDatePicker({
		format: 'YYYYMM', minDate : new Date(),
		clearButton: true,
		weekStart: 0,
		time: false
	});	
	$('.date_req').bootstrapMaterialDatePicker({
		format: 'YYYY-MM-DD',
		clearButton: true,
		weekStart: 0,
		time: false
	});	
});

function sum() {
	var txtFirstNumberValue=document.frmcari.qty_cip.value;
	var txtSecondNumberValue=document.frmcari.price_g.value;
	var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue);
	if (!isNaN(result)) {
		document.getElementById('amount').value = formatMoney(result);
	}
}
</script>