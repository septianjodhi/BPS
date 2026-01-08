<?php $sect= $_SESSION["area"]; 
$pic=$_SESSION["nama"];
$akses=$_SESSION["akses"];
$user=$_SESSION["user"];
$pch_sec=explode("-",$sect);
$perinow=date("Ym");
?>
<script type="text/javascript">
	function dwndtl_pr(url,title,w,h){
		var sect="<?php echo $sect; ?>";
		var term=document.form1.term.value;
		var rg_tgl=document.form1.rg_tgl.value;
		if(url=="D"){
			ur="Exp_xls/exp_rkpPR.php?s="+sect+"&t="+term+"&p=''&d="+rg_tgl+"&j="+'rpt';
		}else{
			ur="Exp_xls/exp_rkpPR.php?s="+sect+"&t="+term+"&p="+periode+"&d="+rg_tgl+"&j="+'rkp';
		}
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(ur, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};
</script>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>DOWNLOAD REPORT PO</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12">
				<div class="card">
					<div class="header">
						<h2>REPORT PR <?php echo $sect; ?><small>Download Report PR</small></h2>
					</div>
					<div class="body">
						<div class="row clearfix">
							<div class="col-md-12">	
								<form role="form"  name="form1" id="form1" method="post" action="">
									<div class="col-sm-3">	
										<div class="form-group">
											<label>Term</label>
											<div class="group-line">
												<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="term" id="term">
													<option selected="selected" value="">-Pilih Term-</option>
													<?php 
													$tb_term=odbc_exec($koneksi_lp,"select distinct term from bps_PR order by term desc");
													$row=0;
													while($bar_term=odbc_fetch_array($tb_term)){
														$row++;
														$opt_trm=odbc_result($tb_term,"term");
														echo '<option value="'.$opt_trm.'">TERM '.$opt_trm.'</option>';
													}
													
													?>
												</select>
											</div>
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label>Pilih Tanggal PO</label>
											<div class="form-line">
												<input type="text"  class="form-control" id="rg_tgl" name="rg_tgl" placeholder="Detail Pencarian" >
											</div>
										</div></div>

										<?php if($sect=='FA-FIN'){?>
											<div class="col-sm-3">
												<div class="form-group">
													<label>Purchasing</label>
													<div class="form-line">
														<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="lp" id="lp">
															<option selected="selected" value="">--Purchasing--</option>
															<?php
															$tb_lp=odbc_exec($koneksi_lp,"select distinct lp from bps_tmpPR");
															while($tb_lp_code=odbc_fetch_array($tb_lp)){ 
																$lp_code=odbc_result($tb_lp,"lp");
																echo '<option value="'.$lp_code.'">'.$lp_code.'</option>';
															}?>	
														</select>
													</div>		
												</div>
											</div>
										<?php }?>

										<div class="col-sm-2">
											<button type="submit" id="cr_po" name="cr_po" class="btn bg-green waves-effect"><i class="material-icons">search</i></button>
											<!--button type="button" onclick="dwndtl_pr('D','Report PR','800','500'); return false;">Download</button-->
											<!--script>alert('$tgl_d');</script-->
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> 

			<div class="row clearfix">
				<div class="card">
					<form action="" id="frm1" name="frm1" method="post"  enctype="multipart/form-data">
						<div class="header">
							<h2>Record Purchase Order (PO)</h2>
						</div>
						<div class="row clearfix">
							<div class="body">
								<div class="table-responsive">
									<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
										<thead>
											<tr>
												<th>No.</th>
												<th>Section</th>
												<th>PR Date</th>
												<th>PR No</th>
												<th>Part No.</th>
												<th>Part Name</th>
												<th>Part Detail</th>
												<th>Phase</th>
												<th>Purchasing</th>
												<th>Description</th>
												<th>Account</th>
												<th>Supp Name</th>
												<th>Qty</th>
												<th>UoM</th>
												<th>Price Before</th>
												<th>Price After</th>
												<th>Price Differences</th>
												<th>Amount Actual</th>				
												<th>PO No.</th>
												<th>PO Date</th>
												<th>ETA Plan</th>
												<th>Status PO</th>
												<th>Periode Budget</th>
												<th>Tanggal Datang</th>
												<th>Qty RCV</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											if(isset($_POST['cr_po']))
											{
												
												if($sect=='FA-FIN')
												{
													$lp=$_POST['lp'];
													$crlp=" and a.lp='$lp'";}else{$crlp=" and a.lp='$pch_sec[1]'"; 
												}
												
												$term=$_POST['term'];
												if($term==""){$cr_term="";}else{$cr_term=" and a.term='$term'";}
												$rg_tg=$_POST['rg_tgl'];
												$rg_tgl=explode("-",$rg_tg);
												$rg_tgl0=date("Y-m-d",strtotime($rg_tgl[0]))." 00:00:00";
												$rg_tgl1=date("Y-m-d",strtotime($rg_tgl[1]))." 23:59:59";

												// $lht_dt="
												// select distinct left(a.pr_no,len( a.pr_no)-9) as dept ,a.no_ctrl,a.no_quo,
												// a.pr_no,b.pr_date,a.kode_supp, a.part_no,c.SUPP_NAME, a.part_nm, a.part_dtl,
												// a.part_desc,a.qty, a.price,a.po_no, a.lp, a.pic_updt,a.tgl_updt, a.term, a.periode,
												// a.curr, a.uom, eta,status_po,(select top 1 price from bps_Quotation 
												// where part_no=a.part_no and part_nm=a.part_nm and No_Quo=a.no_quo and lp_rekom='YES')
												// as price_plan,d.account from bps_podtl a 
												// inner join bps_tmpPR b on a.pr_no=b.pr_no and a.part_no=b.part_no and
												// a.part_dtl=b.part_dtl 
												// inner join LP_SUPP c on a.kode_supp=c.SUPP_CODE
												// full join mstr_budadd d on b.part_no=d.part_no
												// where a.term='$term' $crlp and a.tgl_updt between '$rg_tgl0' and '$rg_tgl1'
												// order by a.tgl_updt asc";
												$lht_dt="select distinct left(a.pr_no,len( a.pr_no)-9) as dept, a.no_ctrl,
												a.no_quo, a.pr_no,c.pr_date,a.kode_supp,a.part_no,SUPP_NAME, a.part_nm,
												a.part_dtl, a.part_desc,a.qty, a.price,a.po_no,a.lp, a.pic_updt, a.tgl_updt,
												a.term, a.periode, a.curr, a.uom, eta,status_po,c.price_plan,a.account ,d.inv_tgl,d.qty_dtg,c.phase
												from bps_podtl a full join LP_SUPP b on a.kode_supp=SUPP_CODE
												full join bps_tmpPR c on a.pr_no=c.pr_no and a.no_ctrl=c.no_ctrl
												left join bps_kedatangan d on a.no_ctrl=d.no_ctrl and a.pr_no=d.pr_no
												where a.no_ctrl is not null $cr_term $crlp and a.tgl_updt between '$rg_tgl0' and '$rg_tgl1'
												order by a.tgl_updt asc";
												// echo $lht_dt;
												$tb_pr=odbc_exec($koneksi_lp,$lht_dt);
												$i=0;
												while($bar_pr=odbc_fetch_array($tb_pr))
												{
													$po_no=odbc_result($tb_pr,"po_no");
													$part_no=odbc_result($tb_pr,"part_no");
													$part_nm=odbc_result($tb_pr,"part_nm");
													$part_dtl=odbc_result($tb_pr,"part_dtl");
													$part_desc=odbc_result($tb_pr,"part_desc");
													$part_phase=odbc_result($tb_pr,"phase");
													$part_lp=odbc_result($tb_pr,"lp");
													$prno=odbc_result($tb_pr,"pr_no");
													$price_a=odbc_result($tb_pr,"price");
													$price_b=odbc_result($tb_pr,"price_plan");
													$no_ctrl=odbc_result($tb_pr,"no_ctrl");
													$diff_prc=$price_a-$price_b;
													$qty=odbc_result($tb_pr,"qty");
													$amnt=$qty*$price_a;
													$i++;
													?>	
													<!--tr onclick="javascript:pilih(this);" -->
													<tr>
														<td><?php echo $i; ?></td>
														<td><?php echo odbc_result($tb_pr,"dept"); ?></td>
														<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_pr,"pr_date"))); ?></td>
														<td><?php echo $prno; ?></td>
														<td><?php echo $part_no; ?></td>	
														<td><?php echo $part_nm; ?></td>	
														<td><?php echo $part_dtl; ?></td>	
														<td><?php echo $part_phase; ?></td>	
														<td><?php echo $part_lp; ?></td>	
														<td><?php echo $part_nm."~".$part_dtl."~".$part_desc; ?></td>
														<td><?php echo odbc_result($tb_pr,"account"); ?></td>
														<td><?php echo odbc_result($tb_pr,"SUPP_NAME"); ?></td>
														<td><?php echo $qty;?></td>
														<td><?php echo odbc_result($tb_pr,"uom"); ?></td>
														<td><?php echo $price_b; ?></td>	
														<td><?php echo $price_a; ?></td>	
														<td><?php echo $diff_prc; ?></td>	
														<td><?php echo $amnt; ?></td>	
														<td><?php echo $po_no; ?></td>
														<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_pr,"tgl_updt"))); ?></td>
														<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_pr,"eta"))); ?></td>
														<td><?php echo odbc_result($tb_pr,"status_po"); ?></td>
														<td><?php echo odbc_result($tb_pr,"periode"); ?></td>
														<?php $cr_dtg="select isnull(sum(qty_dtg),0) as qty_dtg,max(tgl_updt) as tgl_updt from bps_kedatangan where
														po_no='$po_no' and no_ctrl='$no_ctrl' and pr_no='$prno' and part_no='$part_no' group by po_no,no_ctrl,pr_no,part_no";
														$tb_dtg=odbc_exec($koneksi_lp, $cr_dtg);
														?>
														<td>
															<?php $eta=date("Y-m-d",strtotime(odbc_result($tb_dtg,"tgl_updt")));
															if ($eta=='1970-01-01'){echo '0';}else {echo $eta;}
															?>
														</td>
														<td><?php echo odbc_result($tb_dtg,"qty_dtg"); ?></td>
													</tr>	
													<?php
												}
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
		$(function() {
			$('input[name="rg_tgl"]').daterangepicker({
				opens: 'left'
			}, function(start, end, label) {
				console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
			});
		});
	</script>