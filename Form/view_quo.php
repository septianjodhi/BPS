<?php 
$sect= $_SESSION["area"];
$pic=$_SESSION["nama"];
?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Penawaran Harga<small>Record Penawaran</small></h2>
		</div>
		<div class="row clearfix">
			<div class="card">
				<div class="header">
					<h2>Cari Plan Budget
						<small>Data Penawaran berikut adalah Data Budget yang Schedul penawaran dan sesuai waktu yang telah di set sebelumnya</small></h2>
					</div>
					<form role="form"  name="form2" id="form2" method="post" action="" enctype="multipart/form-data">
						<div class="col-sm-3">
							<div class="form-group">
								<label>Range Tanggal</label>
								<div class="form-line">
									<input type="text"  class="form-control" id="rg_tgl" name="rg_tgl" placeholder="Detail Pencarian" required>
								</div>		
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label>Purchasing</label>
								<div class="form-line">
									<select class="selectpicker" style="width: 100%;"  name="lp" id="lp" required="">
										<option selected="selected" value="">--Purchasing--</option>
										<option value="PGA-GA">GA</option>
										<option value="PE-MTP">MTP</option>
										<option value="LOG-LD">LD</option>
										<option value="LOG-EXIM">EXIM</option>
										<?php
										/*
										$tb_lp=odbc_exec($koneksi_lp,"select distinct lp from bps_budget where sect='$sect'");
										while($tb_lp_code=odbc_fetch_array($tb_lp)){ 
											$lp_code=odbc_result($tb_lp,"lp");
											echo '<option value="'.$lp_code.'">'.$lp_code.'</option>';
										}*/
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-3">	
							<div class="form-group">
								<label>Detail Pencarian</label>
								<select class="selectpicker" data-live-search="true" style="width: 100%;" name="cmd_cari" id="cmd_cari" >
									<option selected="selected" value="">---Pilih Kolom---</option>
									<option value="part_no">Part No</option>
									<option value="part_nm">Nama Part</option>
									<option value="part_dtl">Detail Part</option>
									<option value="part_desc">Keterangan Part</option>
									<option value="kode_supp">Kode Supp</option>
									<option value="no_quo">No Penawaran</option>
									<option value="lp_rekom">Rekomendasi LP</option>
								</select>
							</div>
						</div>

						<div class="col-sm-3">	
							<div class="form-group">
								<label>Detail Filter</label>
								<div class="input-group">
									<div class="form-line">
										<input type="text"  class="form-control" data-role="tagsinput" id="txt_cari" name="txt_cari" placeholder="Detail Pencarian">
									</div> 
									<span class="input-group-addon">
										<button type="submit" name="rpt" id="rpt" class="btn bg-purple waves-effect"><i class="material-icons">search</i> </button>
									</span>	
								</div>
							</div>
						</div>

						<div class="row clearfix">
							<div class="col-sm-12">
								<div class="body">
									<div class="table-responsive">
										<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
											<thead>
												<tr>
													<th>KODE SUPPLIER</th>
													<th>NAMA SUPPLIER</th>
													<th>NO PENAWARAN</th>
													<th>PART NO</th>
													<th>NAMA PART</th>
													<th>DETAIL PART</th>
													<th>KET. PART</th>
													<th>BATAS PENAWARAN</th>
													<th>PRICE</th>
													<th>DOK REF</th>
													<th>LINK REF</th>
													<th>PURCHASING</th>
													<th>REKOM LP</th>
													<th>PIC UPDATE</th>
													<th>TANGGAL UPDATE</th>
												</tr>
											</thead>
										</form>

										<tbody>
											<?php 
											if(isset($_POST['rpt'])){
												$pchsect=explode("-",$sect);
												$lp=$_POST['lp'];
												$cmd_cari=$_POST['cmd_cari'];
												$txt_cari=str_replace(" ","",$_POST['txt_cari']);
												if($txt_cari=="")
												{
													$whrfil=""; 
												}else{
													$whrfil=" and replace($cmd_cari,' ','') like '%$txt_cari%'";
												}

												$rg_tg=$_POST['rg_tgl'];
												$rg_tgl=explode("-",$rg_tg);
												$rg_tgl0=date("Y-m-d",strtotime($rg_tgl[0]));
												$rg_tgl1=date("Y-m-d",strtotime($rg_tgl[1]));
												if($rg_tg==""){$whr="";}else{
													$whr=" AND (tgl_updt BETWEEN '$rg_tgl0 00:00:00' AND '$rg_tgl1 23:59:59')";
												}
												$sq_acc="select * FROM bps_quotation a left join lp_supp 
												on kode_supp=supp_code
												where part_no!='' and kode_supp!='' and sect='$lp' $whr $whrfil order by tgl_updt desc";
							//echo $sq_acc;
												$tb_acc=odbc_exec($koneksi_lp,$sq_acc);

												$row=0;
												while($baris1=odbc_fetch_array($tb_acc)){ $row++;
													$dok_ref=odbc_result($tb_acc,"dok_ref");
													$link_ref=odbc_result($tb_acc,"link_ref");
													?>	
													<!--tr  onclick="javascript:pilih(this);"-->
													<tr>
														<td><?php echo odbc_result($tb_acc,"kode_supp"); ?></td>
														<td><?php echo odbc_result($tb_acc,"supp_name"); ?></td>
														<td><?php echo odbc_result($tb_acc,"no_quo"); ?></td>
														<td><?php echo odbc_result($tb_acc,"part_no"); ?></td>
														<td><?php echo odbc_result($tb_acc,"part_nm"); ?></td>
														<td><?php echo odbc_result($tb_acc,"part_dtl"); ?></td>
														<td><?php echo odbc_result($tb_acc,"part_desc"); ?></td>
														<td><?php echo odbc_result($tb_acc,"exp_quo"); ?></td>
														<td><?php echo odbc_result($tb_acc,"price"); ?></td>
														<td>
															<?php if($dok_ref!="")
															{
																echo '<a href="dok_quo/'.$dok_ref.'" target="_blank">'.$dok_ref.'</a>';
															} ?>															
														</td>
														<td><?php if($link_ref!=""){echo '<a href="'.$link_ref.'" target="_blank">'.$link_ref.'</a>';} ?></td>
														<td><?php echo odbc_result($tb_acc,"sect"); ?></td>
														<td><?php echo odbc_result($tb_acc,"lp_rekom"); ?></td>
														<td><?php echo odbc_result($tb_acc,"pic_updt"); ?></td>
														<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_acc,"tgl_updt"))); ?></td>
													</tr>

													<?php 
												}}
												?>
											</tbody>
											<tfoot>
												<tr>	
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>            
						</div>
					</div>
				</div>
			</div>           
		</section>

		<script>
			function pilih(row){
				var kd_pel0=row.cells[0].innerHTML;
				var kd_pel1=row.cells[1].innerHTML;
				var kd_pel2=row.cells[2].innerHTML;
				var kd_pel3=row.cells[3].innerHTML;
				var kd_pel4=row.cells[4].innerHTML;
				var kd_pel5=row.cells[5].innerHTML;
				var kd_pel6=row.cells[6].innerHTML;
				document.form1.part_no.value=kd_pel0;
				document.form1.part_nm.value=kd_pel1;
				document.form1.part_dtl.value=kd_pel2;
				document.form1.part_desc.value=kd_pel3;
				document.form1.co_quo.value=kd_pel4;
				document.form1.est_po.value=kd_pel5;
				document.form1.lp.value=kd_pel6;
			};

			$(function() {
				$('input[name="rg_tgl"]').daterangepicker({
					opens: 'left'
				}, function(start, end, label) {
					console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
				});
			});
				// $(function() {
				// 	$('input[name="rg_tgl"]').daterangepicker({
				// 		timePicker: true,
				// 		startDate: moment().startOf('hour'),
				// 		endDate: moment().startOf('hour').add(32, 'hour'),
				// 		locale: {
				// 			format: 'M/DD/YYYY'
				// 		}
				// 	});
				// });
				$(document).ready(function()
				{

					$('.periodemn').bootstrapMaterialDatePicker({
						format: 'YYYYMM', minDate : new Date(),
						clearButton: true,
						weekStart: 0,
						time: false
					});	
					$('.periodeflex').bootstrapMaterialDatePicker({
						format: 'YYYYMM',
						clearButton: true,
						weekStart: 0,
						time: false
					});	
				});
			</script>