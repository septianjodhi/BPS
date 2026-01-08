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

if(isset($_POST['smpn_pr']) )
{
	$sect= $_SESSION["area"];
	$pic=$_SESSION["nama"];

	$pr_date=$_POST["pr_date"];
	$req_date=$_POST["req_date"];
	$rmk_pr=strtoupper($_POST["rmk_pr"]);
	
	$plh=$_POST['plh'] ;
	$qty=$_POST["qty"];
	$set_qty=$_POST["set_qty"];
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

	$qry_nopr="select max(RIGHT(pr_no,3)) as jj from bps_pr where sect='$sect' and convert(nvarchar(6),pr_date,112)='$bln' and equipment_no is not null ";
	$tb_nopr=odbc_exec($koneksi_lp,$qry_nopr);
	while($bar_nopr=odbc_fetch_array($tb_nopr)){
		$nopr=odbc_result($tb_nopr,"jj");
	}
	$nopr=$nopr+1;	
	$nopr3=substr('000'.$nopr,-3);
	$idtmp=$pic."-".date("Ymd-His");
	$pr_no=$sect."-".date("ym",strtotime($pr_date))."-".$nopr3."-INVEST";

	for ($i=0; $i < $jml; $i++) 
	{
		if($qty[$i]>0)
		{
			$pisah=explode("|", $plh[$i]) ;				
			$no_ctrl_p=$pisah[0];
			$p_no=$pisah[1];
			$no_ctrl=$pisah[3];
			$expired=$pisah[4];
			$car=$pisah[5];
			$qty_plan=$pisah[6];
			$price_plan=$pisah[7];

			$q_order=min($qty_plan,$qty[$i]);

			$cr_quo="select top 1 kode_supp,No_Quo,price from bps_Quotation where lp_rekom='YES' and 
			part_no='$p_no' and Exp_Quo>='$expired' order by tgl_updt desc";
			$tb_cr_quo=odbc_exec($koneksi_lp,$cr_quo);
			$supkod=odbc_result($tb_cr_quo, "kode_supp");
			$noquo=odbc_result($tb_cr_quo, "No_Quo");
			$price_quo=odbc_result($tb_cr_quo, "price");

			$amount=$price_quo*$set_qty*$qty[$i];

			$cr_cccode=odbc_exec($koneksi_lp, "SELECT top 1 * FROM LP_CV where CARLINE='$car' order by CV_CODE asc ") ;
			$cvcode=odbc_result($cr_cccode, "CV_CODE");

			$q_update2="insert into bps_tmpPR (id_tmp_pr,periode,no_ctrl,part_no,part_nm,part_dtl,uom,
			qty_plan,curr,price_plan,exp_pr,penawaran,price_quo,qty_tot,price_tot,amount,pic_updt,tgl_updt,pr_date,pr_no,term,kode_supp,no_quo,cccode,lp,qty_act,phase,account,carline_code,dept_code,req_date,equipment,ket_temp,qty_equipment) ";

			$q_update2val="SELECT top 1 '$idtmp' as id_tmp_pr, periode, no_ctrl_bud, part_no, part_nm,
			part_dtl,uom, qty as qty_plan, curr,$price_plan as price_plan,'$expired' as exp_pr,'YES' as penawaran, '$price_quo' as price_quo,$qty[$i] as qty_tot,'$price_quo' as price_tot,'$amount' as amount,'".$pic."' as pic_updt,getdate() as tgl_updt,'$pr_date' as pr_date,'$pr_no' as pr_no,term,'$supkod' as kode_supp,'$noquo' as no_quo,'$cvcode' as cccode,lp,'$qty[$i]' as qty_act,'INVEST' as phase,0 as account,'$car' as carline_code,'$dept_cd' as dept_code, '$req_date' as req_date,no_ctrl,'INVEST' as ket_temp,
			'$set_qty' as qty_equipment from bps_budinvest_dtl where no_ctrl_bud='$no_ctrl_p'";
			// echo $q_update2." ".$q_update2val;
			$tb_part=odbc_exec($koneksi_lp,$q_update2." ".$q_update2val);
		}


		$qry_tmp="select distinct periode,part_nm from bps_tmpPR where id_tmp_pr='$idtmp' order by periode";
		$tb_tmp=odbc_exec($koneksi_lp,$qry_tmp);
		while($bar_tmp=odbc_fetch_array($tb_tmp)){
			$per_tmp=odbc_result($tb_tmp,"periode");
			$partnm_tmp=odbc_result($tb_tmp,"part_nm");

			$qry_adpr="insert into bps_pr(pr_no,remark,no_ctrl,pr_date,qty,price,curr,term,periode,sect,cccode,pic_updt,tgl_updt,equipment_no,qty_equipment,req_date) select pr_no as pr_no,
			'$rmk_pr' as remark,no_ctrl,pr_date,qty_act as qty,price_tot as price,curr,term,periode,
			'$sect' as sect,cccode,'$pic' as pic_updt,getdate() as tgl_updt,equipment,
			qty_equipment,req_date from bps_tmpPR where id_tmp_pr='$idtmp' and periode='$per_tmp'";
				// echo $qry_adpr;
			$tb_adpr=odbc_exec($koneksi_lp,$qry_adpr);
		}

		$amoun_USD=0;
		$amoun_IDR=0;

		$sql_amount="select distinct pr_no,sum(dbo.lp_konprc(term,'IDR',curr,qty_tot*price_tot)) as idr,sum(dbo.lp_konprc(term,'USD',curr,qty_tot*price_tot)) as dolar,sum(qty_add) as qty_add,sum(price_add) as prc_add from bps_tmppr where pr_no='$pr_no' group by pr_no";
		$tb_amount=odbc_exec($koneksi_lp,$sql_amount);
		$qty_add="";$prc_add="";
		while($bar_moun=odbc_fetch_array($tb_amount)){
			$amoun_USD=odbc_result($tb_amount,"dolar");
			$amoun_IDR=odbc_result($tb_amount,"idr");
			$qty_add=odbc_result($tb_amount,"qty_add");
			$prc_add=odbc_result($tb_amount,"prc_add");
		}

		$pchsec=explode("-",$sect);
		$dept=$pchsec[0];
		$qry_delaprv="delete from bps_approve where jns_doc in('PR') and no_doc='$pr_no'";
		$tb_delaprv=odbc_exec($koneksi_lp,$qry_delaprv);
		$qry_adaprv="insert into bps_approve(pic_plan,email_plan,no_doc,tgl_prepaire,jns_doc,sect,initial,approve,no_aprv,nik)
		SELECT nama as pic_plan,email as email_plan,'$pr_no' as no_doc,getdate() as tgl_prepaire,
		'PR' as jns_doc,sect,initial,approve,no_aprv,right('000000'+nik,6)[nik]  FROM bps_setApprove where status_akun='aktif' and jns_dok in('PR') and 
		(sect='$sect' or sect='$dept-ALL' or (sect='SAMI-ALL' AND (max_amount='0' or 
		(min_amount<='$amoun_IDR' and max_amount>'$amoun_IDR'))))";

		$tb_delaprv=odbc_exec($koneksi_lp,$qry_adaprv);

		echo "<script>alert('DATA BERHASIL DISIMPAN DENGAN NO PR $pr_no');</script>";
	}
}

// print_r(count($plh));
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
											<select class="selectpicker" style="width: 100%;"  name="peri" id="peri" required>
												<option selected="selected" value="">--Phase--</option>
												<?php
												$tbl_periode=odbc_exec($koneksi_lp,"select distinct periode from bps_budget_invest where sect='$sect' and periode>=convert(nvarchar(6),getdate(),112) ");
												$row=0;
												while($baris=odbc_fetch_array($tbl_periode))
												{
													$row++;
													$periode=$baris["periode"];
													echo '<option value="'.$periode.'">'.$periode.'</option>';
												}
												?>												
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-3">	
									<div class="form-group">
										<label>Group Equipment</label>
										<div class="input-group">
											<select class="selectpicker" style="width: 100%;"  name="dt_phs" id="dt_phs" required>
												<option selected="selected" value="">--Phase--</option>
												<?php
												$tb_phs=odbc_exec($koneksi_lp,"select distinct bud_group from bps_budget_invest where sect='$sect' and periode>=convert(nvarchar(6),getdate(),112) ");
												$row=0;
												while($tb_phs_code=odbc_fetch_array($tb_phs))
												{
													$row++;
													$phs_code=odbc_result($tb_phs,"bud_group");
													echo '<option value="'.$phs_code.'">'.$phs_code.'</option>';
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
			$whrfix="a.sect='$sect' and a.periode='$peri' and a.bud_group='$bud_group' and a.curr='$curr' ";
			$qrycrdt="select distinct count(*) as jmc,term from bps_budinvest_dtl a where $whrfix $whr group by term";
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

				$cr_data="select sum(qty) as qty_phs,price,sum(dbo.lp_konprc(term,'IDR','USD',qty*price)) as tot_amn from bps_budget_invest a where a.sect='$sect' and a.periode='$peri' and a.bud_group='$bud_group' group by price";
				// echo $cr_data;
				$tb_data=odbc_exec($koneksi_lp, $cr_data);
				while($baris=odbc_fetch_array($tb_data)){
					$tot_amn=$baris["tot_amn"];
					$qty_phs=$baris["qty_phs"];
					$price_g=$baris["price"];
				}
				$amn=$tot_amn;
				$sq_acc="select a.no_ctrl, a.no_ctrl_bud,a.part_no,a.part_nm,a.part_dtl, a.qty,b.qty as qty_set,a.uom,a.curr,a.lp,a.price,isnull((select top 1 price from bps_Quotation where lp_rekom='YES' and Exp_Quo>=b.expired and part_no=a.part_no),0) as price_quo,b.carline,b.expired, b.price as plan_bud from bps_budinvest_dtl a inner join bps_budget_invest b on a.no_ctrl=b.no_ctrl where $whrfix $whr ";
				?>

				<div class="row clearfix">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="card">
							<div class="header">
								<h2>Buat Purchase Requisition (PR) Section <?php echo $sect; ?></h2>
							</div>

							<form action="" id="frmcari" name="frmcari" method="post">
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
													<input type="text" name="req_date" id="req_date" value="<?php echo date("Y-m-d",strtotime("now"));?>" class="form-control date-min" required placeholder="Tanggal Kedatangan" >
												</div>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">

											</div>
										</div>
									</div>
									<div class="row clearfix">
										<div class="col-sm-9">
											<div class="form-group">
												<label>Remark PR</label>
												<div class="form-line">
													<input type="text" name="rmk_pr" id="rmk_pr" class="form-control">
												</div>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label class="text-center">Sisa Plan Budget (<?= $curr ?>) </label>
												<div class="form-line">
													<input type="text" value="<?= number_format(round($amn,0),2) ;?>" name="amount" id="txt3" class="form-control">
													<!-- <h2 class="text-center"><?= number_format(round($amn,0),2) ;?></h2> -->
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
							<div class="row clearfix">
								<div class="body">
									<div class="table-wrapper-scroll-y my-custom-scrollbar">
										
										<table id="nilai" class="table table-striped table-bordered " cellspacing="0" width="100%">
											<tr>
												<th>Pilih</th>
												<th>Control No.</th>
												<th>Part No</th>
												<th>Desc</th>
												<th>Qty Set Group</th>
												<th>Uom</th>
												<!-- <th>Curr</th> -->
												<!-- <th>Price Plan</th> -->
												<th>Price Quotation</th>
												<th>Qty</th>
												<th>Purchasing</th>
											</tr>
											<?php
											// echo $sq_acc;
											$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
											$row=0;
											while($baris1=odbc_fetch_array($tb_acc)){
												$row++;
												$price_quo=$baris1['price_quo'];
												$price=$baris1['price'];
												$qty=$baris1['qty'];
												$no_ctrl=$baris1['no_ctrl'];
												$no_ctrl_p=$baris1['no_ctrl_bud'];
												$part_no=$baris1['part_no'] ;
												$part_nm=$baris1['part_nm'];
												$curr_ori=$baris1['curr'] ;
												$carline=$baris1['carline'] ;
												$expired=$baris1['expired'] ;
												$qtyset=$baris1['qty_set'] ;
												$plh="on";

												if($price_quo<=0 ){

													$plh="off";
												}
												else{
													$plh="on";
												}

												?>
												<tr>
													<td >
														<?php if($plh=="on"){ ?>
															<div class="switch" >
																<label>
																	<input type="checkbox" name="plh[]" id="plh" 
																	value="<?= $no_ctrl_p."|".$part_no."|".$curr_ori."|".$no_ctrl."|".$expired."|".$carline."|".$qty."|".$price ; ?>" onclick="dipilih(this.form);">
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
													<td><?= $no_ctrl_p; ?></td>
													<td><?= $baris1["part_no"]; ?></td>
													<td><?= $part_nm." ".$baris1['part_dtl'] ; ?> </td>
													<td><input type="number" min=0 name="qty_s<?= $row; ?>" id="qty_s<?= $row; ?>" max="<?= $qtyset ; ?>" value="<?= $qtyset ; ?>" 
														onchange="total()" class="form-control">
													</td>
													<td><?= $baris1['uom'] ; ?> </td>
													<!-- <td><?= $curr_ori ; ?> </td> -->
													<!-- <td><?= $baris1["price"]; ?></td> -->
													<td><input type="text" name="price <?= $row; ?>" id="price<?= $row; ?>" value="<?= $price_quo; ?>" class="form-control" readonly ></td>
													<td>
														<!-- <?php if($price_quo==0){ ?> -->
													<!-- <?php }else{ ?> -->
														<input type="number" min=0 name="qty<?= $row; ?>" id="qty<?= $row; ?>" value="0" onchange="total()" class="form-control" <?php if($price_quo==0){ echo "disabled" ;}?> >
													<!-- <?php } ?> -->
													</td>
													<td><?= $baris1['lp'] ; ?></td>
												</tr>
												<?php 
											}
										}
										?>
										
									</table>
								
								</div>
								<table class="table table-striped table-bordered " cellspacing="0" width="100%">
									<tr>
										<td style="text-align:right">jumlah total</td>
										<td><input class="form-control" type="text" name="total_jumlah" id="total" value="" readonly></td>
										<td><button class="btn bttn" >TAMPILKAN</button>
											<button type="button" class="btn bg-green" name="smpn_pr" id="smpn_pr" ><i class="material-icons">search</i>Checkout</button>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php 
		} 
		?>
	</div>
</section>
<script type="text/javascript">
	function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
		try {
			decimalCount = Math.abs(decimalCount);
			decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

			const negativeSign = amount < 0 ? "-" : "";

			let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
			let j = (i.length > 3) ? i.length % 3 : 0;

			return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
		} catch (e) {
			console.log(e)
		}
	};

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

function total() {
	var table = document.getElementById("nilai");
	var total = 0;
	for(var i = 0; i < table.rows.length; i++)
	{
		qty_s="qty_s"+(i+1);
		id="price"+(i+1);
		hrg="qty"+(i+1);
		var idt=parseInt(document.getElementById(id).value);
		var hrgt=parseInt(document.getElementById(hrg).value);
		var qty_st=parseInt(document.getElementById(qty_s).value);
		var amn=idt*hrgt*qty_st;
		var total=total+amn;

		if (!isNaN(total)) {	
			document.getElementById('total').value = formatMoney(total);
		}
		if (isNaN(total)) {
			document.getElementById('total').value = 0;
		}
	}
}

function sum() {
	var txtFirstNumberValue=document.frmcari.set_qty.value;
	var txtSecondNumberValue=document.frmcari.price_g.value;
	var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue);
	if (!isNaN(result)) {
		document.getElementById('txt3').value = formatMoney(result);
	}
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

function pilih(row){
	var kd_pel4=row.cells[3].innerHTML;
	alert(kd_pel4);
}
</script>

<script type="text/javascript">
 $('.bttn').click(function(){
 $("input[type=checkbox]:checked").each(function() {
    alert( $(this).val() );
 });
 });
</script>