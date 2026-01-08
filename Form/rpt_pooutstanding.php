
<section class="content">
	<div class="container-fluid">

						<div class="header">
							<h2>Record Purchase Order (PO) Outstanding </h2>
						</div>

						<div class="row clearfix">
							<div class="card">
								<form action="" id="frm1" name="frm1" method="post"  enctype="multipart/form-data">
									<div class="header">
										<h2>Record Purchase Order (PO) Belum Input Kedatangan</h2>
									</div>
									<div class="row clearfix">
										<div class="body">
											<div class="table-responsive">
												<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
													<thead>
														<tr>
															<th>NO</th>
															<th>Periode</th>
															<th>PO NO</th>
															<th>Kode Supp</th>
															<th>Status PO</th>
															<th>Status Approv</th>
															<th>Eta Req</th>
														</tr>
													</thead>
													<tbody>

														<?php 
														 $sect=$_SESSION["area"];
            $pic=$_SESSION["nama"];
            $pch_sect=explode("-",$sect);
            $dept=$pch_sect[0];
            $sec=$pch_sect[1];
			$term=$_GET["trm"];
			$qrypo="select distinct p.po_no,p.kode_supp,a.status,p.status_po,p.periode,p.eta from bps_podtl p inner join bps_approve a on p.po_no=a.no_doc where p.lp='$sec' and p.term='$term' and not exists(select distinct po_no from bps_kedatangan where po_no=p.po_no)";
			$tbl_po=odbc_exec($koneksi_lp,$qrypo);
													
														$i=0;
														while($bar_pr=odbc_fetch_array($tbl_po)){ 
															$i++;
															$streta=strtotime(odbc_result($tbl_po,"eta"));
															?>	
															<tr  onclick="javascript:pilih(this);" >
																<td><?= $i; ?></td>
																<td><?php echo odbc_result($tbl_po,"periode"); ?></td>
																<td><?php echo odbc_result($tbl_po,"po_no"); ?></td>
																<td><?php echo odbc_result($tbl_po,"kode_supp"); ?></td>
																<td><?php echo odbc_result($tbl_po,"status_po"); ?></td>
																<td><?php echo odbc_result($tbl_po,"status"); ?></td>
																<td><?php if(date("Y",$streta)>='2002'){echo date("Y-m-d",$streta);} ?></td>
																	
																
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

