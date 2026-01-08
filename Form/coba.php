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
											<input type="number" class="periodemn form-control" id="peri" name="peri" value="<?php echo date("Ym"); ?>" placeholder="Periode Plan" required>
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
												$tb_phs=odbc_exec($koneksi_lp,"select distinct qty,no_ctrl,cip_no,bud_group,price from bps_budget_invest where 
													sect='$sect' and periode>=convert(nvarchar(6),getdate(),112) ");
												$row=0;
												while($tb_phs_code=odbc_fetch_array($tb_phs))
												{
													$row++;
													$phs_code=odbc_result($tb_phs,"bud_group");
													$qty=odbc_result($tb_phs,"qty");
													$no_ctrl=odbc_result($tb_phs,"no_ctrl");
													$price_g=odbc_result($tb_phs,"price");
													$phase_group=$qty."|".$phs_code."|".$no_ctrl."|".$price_g;
													echo '<option value="'.$phase_group.'">'.$phs_code.'</option>';
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
			$phs=$_POST['dt_phs'];
			$pch_phs=explode("|", $phs);
			$qty_phs=$pch_phs[0];
			$dt_phs=$pch_phs[1];
			$no_ctrl_g=$pch_phs[2];
			$price_g=$pch_phs[3];
			$cmd_cari=$_POST['cmd_cari'];
			$txt_cari=str_replace(" ","",$_POST['txt_cari']);
			if($txt_cari==""){
				$whr=""; 
			}else{
				$whr=" and replace($cmd_cari,' ','') like '%$txt_cari%'";
			}
			$whrfix="a.sect='$sect' and a.periode='$peri' and a.no_ctrl='$no_ctrl_g' and a.curr='$curr' ";
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
				$amn=$kurs*$price_g*$qty_phs;
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
													<input type="text" name="req_date" id="req_date" value="<?php echo date("Y-m-d",strtotime("now"));?>" class="form-control date-min" required placeholder="Tanggal Kedatangan" >
												</div>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label>Jumlah Order</label>
												<div class="form-line">
													<input type="number" class="form-control" min=1 max="<?= $qty_phs ; ?>" id="set_qty" name="set_qty" value="<?= round($qty_phs) ; ?>" onchange="sum();" required/>
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
													<input type="text" id="price_g" name="price_g" value="<?= round($kurs*$price_g,2) ;?>" class="form-control" readonly/>
												</div>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label class="text-center">Total Plan Budget (<?= $curr ?>) </label>
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
												<!-- <th>Qty</th> -->
												<th>Uom</th>
												<!-- <th>Curr</th> -->
												<!-- <th>Price Plan</th> -->
												<th>Price Quotation</th>
												<th>Qty</th>
												<th>Purchasing</th>
											</tr>
											<?php
											$sq_acc="select a.no_ctrl, a.no_ctrl_bud,a.part_no,a.part_nm,a.part_dtl, a.qty,a.uom,a.curr,a.lp,a.price,isnull((select top 1 price from bps_Quotation where lp_rekom='YES' and Exp_Quo>=b.expired and part_no=a.part_no),0) as price_quo,b.carline,b.expired, b.price as plan_bud from bps_budinvest_dtl a inner join bps_budget_invest b on a.no_ctrl=b.no_ctrl where a.sect='QA-QS' and a.periode='202007' and a.no_ctrl='80-QS-07-0004' and a.curr='IDR' ";
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
																	<input type="checkbox" name="plh[]" id="plh" value="<?= $no_ctrl_p."|".$part_no."|".$curr_ori."|".$no_ctrl."|".$expired."|".$carline."|".$qty."|".$price ; ?>" onclick="dipilih(this.form);">
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
													<td><?= $no_ctrl; ?></td>
													<td><?= $baris1["part_no"]; ?></td>
													<td><?= $part_nm." ".$baris1['part_dtl'] ; ?> </td>
													<!-- <td><?= $qty ; ?> </td> -->
													<td><?= $baris1['uom'] ; ?> </td>
													<!-- <td><?= $curr_ori ; ?> </td> -->
													<!-- <td><?= $baris1["price"]; ?></td> -->
													<td><input type="text" name="price <?= $row; ?>" id="price<?= $row; ?>" value="<?= $price_quo; ?>" class="form-control"></td>
													<td><input type="number" min=0 name="qty<?= $row; ?>" id="qty<?= $row; ?>" value="0" onchange="total()" class="form-control"></td>
													<td><?= $baris1['lp'] ; ?></td>
												</tr>
												<?php 
											} 
											?>
											<tr>
												<td colspan="6" style="text-align:right">jumlah total</td>
												<td><input class="form-control" type="text" name="total_jumlah" id="total" value="" readonly></td>
												<td><button type="button" class="btn bg-green" onclick="pil_add(); return false;"><i class="material-icons">search</i>Checkout</button></td>
											</tr>
										</table>

											<!-- <div class="row clearfix">
												<div class="body">
													<button type="button" class="btn" onclick="pil_add(); return false;"><i class="material-icons">search</i></button>
												</div>
											</div> -->

										</div>
									</div>
								</div>

							</div>
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
					<?php 
				}
			}
			?>
		</div>

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
													<td>
														<div class="form-line">
															<input type="text" readonly name="prno1[]" id="prno1" value="<?php echo $prno; ?>" class="form-control"  required>
														</div>
													</td>
													<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_pr,"pr_date"))); ?></td>
													<td><?php echo odbc_result($tb_pr,"periode"); ?></td>
													<td><?php echo odbc_result($tb_pr,"qty"); ?></td>
													<td><?php echo number_format(odbc_result($tb_pr,"price"),2,".",","); ?></td>
													<td><?php echo number_format(odbc_result($tb_pr,"amUSD"),2,".",","); ?></td>
													<td><?php echo odbc_result($tb_pr,"sect"); ?></td>
													<td><?php echo $remark; ?></td>
													<td><button type="button" class="btn bg-green waves-effect" onclick="open_child('Exp_pdf/print_pr_invest.php?nomor=<?php echo $i;?>&nopr=<?php echo $prno;?>','Print PR <?php echo $prno;?>','800','500'); return false;"><i class="material-icons">print</i></button>
													</td>
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
		id="price"+(i+1);
		hrg="qty"+(i+1);
		var idt=parseInt(document.getElementById(id).value);
		var hrgt=parseInt(document.getElementById(hrg).value);
		var amn=idt*hrgt;
		var total=total+amn;

		if (!isNaN(total)) {	
			document.getElementById('total').value = total;
		}
		if (isNaN(total)) {
			document.getElementById('total').value = 0;
		}
	}
}

function sum() {
	var txtFirstNumberValue=document.frmcari.set_qty.value;
	var txtSecondNumberValue=document.frmcari.price_g.value;
		// alert(txtFirstNumberValue);
		// var txtFirstNumberValue = document.getElementById('txt1').value;
		// var txtSecondNumberValue = document.getElementById('txt2').value;
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
