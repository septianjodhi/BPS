<?php
include "../../../koneksi.php";

$sect= $_POST["s"];
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
											$sq_pr="select distinct periode,pr_no,remark,pr_date,a.sect,request,sum(qty) as qty,sum(qty*price) as price,dbo.lp_konprc(term,'USD',curr,sum(qty*price)) as amUSD
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
														<td><button type="button" class="btn bg-green waves-effect" onclick="open_child('form/pr/invest/print_pr_invest.php?nomor=<?php echo $i;?>&nopr=<?php echo $prno;?>','Print PR <?php echo $prno;?>','800','500'); return false;"><i class="material-icons">print</i></button></td>
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
		