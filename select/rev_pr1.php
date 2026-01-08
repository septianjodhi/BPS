<link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.js"></script>
<script src="../plugins/jquery-datatable/jquery.dataTables.js"></script>

<?php
$lok=$_GET["sesi"];
include "../koneksi.php";
$prno=$_GET["nopr"];
$pic=$_GET["pic"];
$sect=$_GET["sec"];
$sql1="SELECT a.*,remark from bps_tmppr a inner join bps_pr b on a.pr_no=b.pr_no and a.no_ctrl=b.no_ctrl
where a.pr_no='$prno' and exists(SELECT no_doc from bps_approve where no_doc=a.PR_NO and jns_doc='PR'
and status is null) order by part_no asc";

if(isset($_POST['smpn']))
{
	$count=count($_POST['p_no']);
	$no_ctrl=$_POST['no_ctrl'];
	$p_nm=$_POST['p_nm'];
	$p_no=$_POST['p_no'];
	$p_dtl=$_POST['p_dtl'];
	$p_desc=$_POST['p_desc'];
	$q_pln=$_POST['q_pln'];
	$prdt=$_POST['prdt'];
	$area=$_POST['cccode'];
	$rmk_pr=$_POST['rmk_pr'];
	$lsctrl=explode(",",$_POST['lsctrl']);

	for ($i=0;$i<$count;$i++)
	{
		// $noctrl=$no_ctrl[$i];
		$noctrl=$lsctrl[$i];
		$pnm=$p_nm[$i];
		$pno=$p_no[$i];
		$pdtl=$p_dtl[$i];
		$pdesc=$p_desc[$i];
		$pr_date=$prdt[$i];
		$cc_code=$area[$i];
		$qpln=number_format($q_pln[$i],11,".","");
		$idtmp=$pic."-".date("Ymd-His");
		$sq_acc="SELECT top 1 * from bps_tmppr where pr_no='$prno' and no_ctrl='$noctrl' and part_no='$pno' and part_dtl='$pdtl' and part_desc='$pdesc' ";

		
		echo "<script> alert ('$noctrl') </script>";
	}

}

?>

<div class="content-wrapper">
	<div class="col-md-12">
		<section class="content-header">
			<div class="container-fluid">
				<div class="block-header">
					<h2>REVISI PR (<?php echo $prno ; ?>)</h2>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<form id="form1" name="form1" method="post">
									<div class="row clearfix">	
										<div class="form-group">
											<label>Remark PR</label>
											<div class="form-line">
												<input type="text" name="rmk_pr" id="rmk_pr"
												value="<?php 
												$tb_area=odbc_exec($koneksi_lp,$sql1);
												$rmk=odbc_result($tb_area,"remark");
												echo $rmk;?>" class="form-control" required>
											</div>
										</div>
										<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
											<thead>
												<tr>
													<th>NO CONTROL</th>
													<th>PART NAME</th>
													<th>PART NO</th>
													<th>DETAIL PART</th>
													<th>REMARK PART</th>
													<th>QTY PLAN</th>
													<th>COST CENTER</th>
													<th>PR DATE</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$tb_area=odbc_exec($koneksi_lp,$sql1);
												$row=0;$lsctrl="";
												while($baris1=odbc_fetch_array($tb_area)){$row++;
													$part_nm=odbc_result($tb_area,"part_nm");
													$qtyplan=odbc_result($tb_area,"qty_act");
													$cccode=odbc_result($tb_area,"cccode");
													$nctr=odbc_result($tb_area,"no_ctrl");
													$lsctrl=$lsctrl.$nctr.",";
													?>
													<tr onclick="javascript:pilih(this);">
														<td>
															<input type="text"readonly name="no_ctrl[]" id="no_ctrl" value="<?php echo $nctr;?>" class="form-control" />
														</td>
														<td>
															<input type="text"readonly name="p_nm[]" id="p_nm" value="<?php echo $part_nm;?>" class="form-control" />
															<button onclick="open_child('plh_pn_revpr.php?nomor=<?php echo $row;?>&nm=<?php echo $part_nm;?>','Data Part Number','800','500'); return false;">...
															</button>
														</td>
														<td>
															<input type="text" name="p_no[]" id="p_no" value="<?php echo odbc_result($tb_area,"part_no");?>" placeholder="Detail" class="form-control" />
														</td>
														<td>
															<input type="text" name="p_dtl[]" id="p_dtl" value="<?php echo odbc_result($tb_area,"part_dtl");?>" placeholder="Detail" class="form-control" />
														</td>
														<td>
															<input type="text" name="p_desc[]" id="p_desc" value="<?php echo odbc_result($tb_area,"part_desc");?>" placeholder="Remark Part" class="form-control" />
														</td>
														<td>
															<input type="number" min="0" step="0.0000000000000001" max="<?php echo $qtyplan;?>" name="q_pln[]" id="q_pln" value="<?php echo $qtyplan;?>" placeholder="Remark Part" class="form-control" />
														</td>
														<td>
															<input type="text" name="cccode[]" id="cccode" value="<?php echo $cccode;?>" placeholder="Cost Center" class="form-control" />
															<button name="bt1[]" onclick="open_child('../template.php?plh=SELECT/plh_cccode.php&k=4&o=cccode&c=carline_code&n=no_ctrl','Data Part Number','800','500'); return false;">...
															</button>
														</td>
														<td>
															<input type="text"readonly name="prdt[]" id="prdt" value="<?php echo odbc_result($tb_area,"pr_date");?>" class="form-control">
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
									<div class="row clearfix">	
										<input type="hidden" id="lsctrl" name="lsctrl" value="<?php echo $lsctrl; ?>">
										<button type="submit" id="smpn" name="smpn" class="btn btn-primary">Simpan</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>