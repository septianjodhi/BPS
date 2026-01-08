<script type="text/javascript">
	function open_child(url,title,w,h){
	//var des_p=document.form1.FilDesc.value;+'&desP='+des_p
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
		status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
		width='+w+',height='+h+',top='+top+',left='+left);
};
</script>
<link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.js"></script>
<script src="../plugins/jquery-datatable/jquery.dataTables.js"></script>

<div class="card">
	<div class="container-fluid">
		<div class="card">
			<div class="container-fluid">
				<?php
				$inv=$_GET["inv"];
				$pic=$_GET["pic"];
				$lp=$_GET["lp"];
				$lok=$_GET["sesi"];

				include "../koneksi.php";
				$sql1="select * from bps_kedatangan where inv_no='$inv' order by part_no asc";
				$query=odbc_exec($koneksi_lp,$sql1);
				// $jns_bc=odbc_result($sql1,'jns_bc');

				if(isset($_POST['smpn'])){;
//$tb_deltmp=odbc_exec($koneksi_lp,"delete from bps_tmppr where pr_no='$prno'");
					$rev_inv=$_POST['rev_inv'];
					$pr_no=$_POST['pr_no'];
					$count=count($_POST['p_no']);
					$po_no=$_POST['po_no'];
					$no_ctrl=$_POST['no_ctrl'];
					$p_nm=$_POST['p_nm'];
					$p_no=$_POST['p_no'];
					$p_dtl=$_POST['p_dtl'];
					$p_desc=$_POST['p_desc'];
					$q_pln=$_POST['q_pln'];
					$q_dtg=$_POST['q_dtg'];
					$pph=$_POST['pph'];
					$ppn=$_POST['ppn'];
					$lspart_no=explode(",",$_POST['lspart_no']);
//$tb_delaprv=odbc_exec($koneksi_lp,"delete from bs_approve where no_doc='$prno' and jns_doc='PR'");
					for ($i=0;$i<$count;$i++){
						$prno=$pr_no[$i];
						$pono=$po_no[$i];
						$noctrl=$no_ctrl[$i];
						$pnm=$p_nm[$i];
						$pno=$p_no[$i];
						$pdtl=$p_dtl[$i];
						$pdesc=$p_desc[$i];
						$p_ph=$pph[$i];
						if($p_ph==''){$pp_h="";}else{$pp_h=" ,pph=ISNULL($p_ph,0) ";}
						$p_pn=$ppn[$i];
						$qpln=$q_pln[$i];
						if($p_pn==''){$pp_n="";}else{$pp_n=" ,ppn=isnull($p_pn,0) ";}
						$qdtg=$q_dtg[$i];
						if($qdtg==""){$qact=0;}else{$qact=$qdtg;}

						if($qdtg>0){
							$q_update2="update bps_kedatangan set qty_dtg='$qdtg',
							inv_no='$rev_inv' $pp_h $pp_n
							where inv_no='$inv' and po_no='$pono' and pr_no='$prno' and part_no='$pno' and part_nm='$pnm' and qty='$qpln'
							and no_ctrl='$noctrl'";
							echo $q_update2."<br>";
							$tb_part=odbc_exec($koneksi_lp,$q_update2);
	//$tb_updtbud=odbc_exec($koneksi_lp,"update bps_budget set part_no='$pno',part_dtl='$pdtl',part_desc='$pdesc',cccode='$cc_code' where no_ctrl='$noctrl'");
	//echo "<script>alert('$i - $Qbud - $act_bud - $tot_qty - $cum_qty - $qty_sisa - $qpln - $amount - $amount_act - $amount_pln - $tot_prc - $sis_bud - $noctrl - $qpln[$i] - $lsctrl[$i]');</script>";
						}else{
							$tb_deltmp=odbc_exec($koneksi_lp,"delete from bps_kedatangan
								where inv_no='$inv' and po_no='$pono' and pr_no='$prno' and part_no='$pno' and part_nm='$pnm' and part_dtl='$pdtl' and part_desc='$pdesc' and qty='$qpln' and no_ctrl='$noctrl'");}}

							if($rev_inv!=$inv){$updt_inv=odbc_exec($koneksi_lp,"update bps_kedatangan set inv_no='$rev_inv'	where inv_no='$inv' and po_no='$pono' and pr_no='$prno'");}	

							echo "<script>window.close();</script>";
						}

						?>


						<div class="block-header"><h2>REVISI KEDATANGAN INVOICE NO</h2>
						</div>
						<form id="form1" name="form1" method="post">
							<div class="row clearfix">	
								<input type="text" name="rev_inv" id="rev_inv" value="<?php echo $inv;?>" placeholder="Invoice" class="form-control">
								<!-- <div class="col-md-12">
									<div class="col-sm-3">	
										<div class="form-group">
											<label>Jenis BC</label>
											<div class="form-line">
												<select class="selectpicker"  style="width: 100%;"  name="jnbc" id="jnbc">
													<option selected="selected" value=""><?= $jns_bc; ?></option>
													<option value="BC23">BC23</option>
													<option value="BC27M">BC27M</option>
													<option value="BC40">BC40</option>
												</select>
											</div>
										</div>
									</div>

									<div class="col-sm-2">	
										<div class="form-group">
											<label>Nomor BC</label>
											<div class="form-line">
												<input type="text" name="nobc" id="nobc" value="" class="form-control" placeholder="Nomor BC">
											</div>
										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label>Tanggal BC</label>
											<div class="form-line">
												<input type="text" class="form-control datetime" id="tglbc" name="tglbc"  placeholder="Tanggal BC">
											</div>
										</div>
									</div>

									<div class="col-sm-2">	
										<div class="form-group">
											<label>Faktur Pajak</label>
											<div class="form-line">
												<input type="text" name="fakur" id="fakur" value="" class="form-control" placeholder="No Faktur Pajak">
											</div>
										</div>
									</div>
								</div> -->
								<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
									<thead>
										<tr>
											<th>PO NO</th>
											<th>PR NO</th>
											<th>NO CONTROL</th>
											<th>PART NO</th>
											<th>PART NAME</th>
											<th>DETAIL PART</th>
											<th>REMARK PART</th>
											<th>QTY PLAN</th>
											<th>QTY DATANG</th>
											<th>PPH</th>
											<th>PPN</th>
										</tr>
									</thead>
									<tbody>
										<!--data ini bisa di loop dari database-->
										<?php
										$tb_area=odbc_exec($koneksi_lp,$sql1);
										$row=0;$lspart_no="";
										while($baris1=odbc_fetch_array($tb_area)){
											$row++;
											$pph=odbc_result($tb_area,"pph");
											$ppn=odbc_result($tb_area,"ppn");
											$part_no=odbc_result($tb_area,"part_no");
											$part_nm=odbc_result($tb_area,"part_nm");
											$part_dtl=odbc_result($tb_area,"part_dtl");
											$part_desc=odbc_result($tb_area,"part_desc");
											$qplan=odbc_result($tb_area,"qty");
											$qdtg=odbc_result($tb_area,"qty_dtg");
											$lspart_no=$lspart_no.$part_no.",";
											?>
											<tr onclick="javascript:pilih(this);">
												<td><input type="text" name="po_no[]" id="po_no" value="<?php echo odbc_result($tb_area,"po_no");?>" placeholder="Detail" class="form-control" readonly></td>
												<td><input type="text" name="pr_no[]" id="pr_no" value="<?php echo odbc_result($tb_area,"pr_no");?>" placeholder="Detail" class="form-control" readonly></td>
												<td><input type="text" name="no_ctrl[]" id="no_ctrl" value="<?php echo odbc_result($tb_area,"no_ctrl");?>" placeholder="no_ctrl" class="form-control" readonly></td>
												<td><input type="text" name="p_no[]" id="p_no" value="<?php echo $part_no;?>" placeholder="Detail" class="form-control" readonly></td>
												<td><input type="text"readonly name="p_nm[]" id="p_nm" value="<?php echo $part_nm;?>" class="form-control"></td>
												<td><input type="text" name="p_dtl[]" id="p_dtl" value="<?php echo $part_dtl;?>" placeholder="Detail" class="form-control" readonly></td>
												<td><input type="text" name="p_desc[]" id="p_desc" value="<?php echo $part_desc;?>" placeholder="Remark Part" class="form-control" readonly></td>
												<td><input type="number" name="q_pln[]" id="q_pln" step="0.0000000000000001" value="<?php echo $qplan;?>" placeholder="qty pln" class="form-control" readonly></td>
												<td><input type="number" min="0" step="0.0000000000000001" name="q_dtg[]" id="q_dtg" value="<?php echo $qdtg;?>" placeholder="qty_dtg" class="form-control"></td>
												<td>
													<select data-live-search="true" style="width: 100%;"  name="pph[]" id="pph" class="form-control">
														<option selected="selected" value=""><?php echo $pph;?></option>
														<option value="0">0</option>
														<option value="0.5">0.5</option>
														<option value="1.75">1.75</option>
														<option value="2">2</option>
														<option value="2.5">2.5</option>
														<option value="2.65">2.65</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="10">10</option>
													</select>
												</td>
												<td>
													<select data-live-search="true" style="width: 100%;"  name="ppn[]" id="ppn" class="form-control">
														<option selected="selected" value=""><?php echo $ppn;?></option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="10">10</option>
														<option value="11">11</option>
													</select>
												</td>
											</tr>
										<?php } ?>      
									</tbody>
								</table>
							</div>
							<div class="row clearfix">	
								<input type="hidden" id="lspart_no" name="lspart_no" value="<?php echo $lspart_no; ?>">
								<button type="submit" id="smpn" name="smpn" class="btn btn-primary">Simpan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">$('.selectpicker').selectpicker();</script>