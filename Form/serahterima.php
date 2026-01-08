<script type="text/javascript">
	function open_child(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};
</script>
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

<?php
error_reporting(0);
session_start();
$sect=$_SESSION["area"];
$pic=$_SESSION["nama"];
$pch_sect=explode("-",$sect);
$dept=$pch_sect[0];
$sec=$pch_sect[1];
$tahunlalu=date('Y-m-d', strtotime("-1 year", strtotime(date("Y-m-d"))));

if(isset($_POST['smpn'])){
	$pic_terima=$_POST['pic_terima'];
	$tgl_terima=$_POST['tgl_terima'];
	$type_brg=$_POST['type_brg'];

	$bln=date("Ym");
	$noho=0;
	$qry_noho="select max(RIGHT(ho_no,3)) as jj from bps_Serahterima where lp='$sec' and convert(nvarchar(6),tgl_terima,112)='$bln'";
	$tb_noho=odbc_exec($koneksi_lp,$qry_noho);
	while($bar_noho=odbc_fetch_array($tb_noho)){
		$noho=odbc_result($tb_noho,"jj");
	}
	$noho=$noho+1;
	$noho3=substr('000'.$noho,-3);
	// $ho_no="HO-".$sec."-".date("ym",strtotime($tgl_terima))."-".$noho3;
	$ho_no="HO-".$sec."-".$bln."-".$noho3;

	foreach ($_POST['plh'] as $_boxValue2)
	{
		$jml=count($_POST['plh']);
		$np2=explode("|",$_boxValue2);

		$cr_dt=odbc_exec($koneksi_lp,"SELECT top 1 vp_no,no_bc from bps_vp where po_no='$np2[4]' and inv_no='$np2[5]' and lp='$sec'");

		while($bar_cr_dt=odbc_fetch_array($cr_dt)){
			$vp_no=odbc_result($cr_dt,"vp_no");
			$bc_no=odbc_result($cr_dt,"no_bc");
		}

		$tmbh_data="INSERT into bps_Serahterima (sect,pr_no,po_no,inv_no,type_brg,part_no,part_nm,
			part_dtl,part_desc,qty,uom,pic_lp,pic_terima,tgl_terima,pic_updt, tgl_updt, ho_no, lp,
			vp_no, bc_no,	cccode,no_ctrl)";

		$cr_data="SELECT sect_to,a.pr_no,a.po_no,a.inv_no,'$type_brg' as type_brg,
		a.part_no,a.part_nm,a.part_dtl,a.part_desc,isnull(sum(a.qty_dtg),0) as qty,a.uom,
		'$pic' as pic_lp,'$pic_terima' as pic_terima,'$tgl_terima' as tgl_terima,
		'$pic' as pic_updt,getdate() as tgl_updt,'$ho_no' as ho_no,a.lp,
		'$vp_no' as vp_no,'$bc_no' as bc_no,a.cccode,a.no_ctrl
		from bps_kedatangan a
		where a.lp='$sec' and a.po_no='$np2[4]' and a.inv_no like '%$np2[5]' and a.no_ctrl='$np2[8]'
		and a.pr_no='$np2[3]'
		group by sect_to,a.pr_no,a.po_no,a.inv_no,a.inv_no,a.part_no,a.part_nm,a.part_dtl,
		a.part_desc,a.uom,a.lp,a.cccode,a.no_ctrl";
		// having isnull(sum(a.qty_dtg),0)>isnull(b.qty,0)";

		// echo $cr_data."<br>";
		$in_data=odbc_exec($koneksi_lp,$tmbh_data." ".$cr_data);
		//  echo "<br>".$tmbh_data." ".$cr_data."<br>";
	}
	//echo $tmbh_data." ".$cr_data; 
	echo "<script>alert(' $tmbh_data $cr_data DATA BERHASIL DISIMPAN');</script>";
}

if(isset($_POST['del_ho']) ){	
	$ho_no=$_POST["ho_no"];
	// $tb_del1=odbc_exec($koneksi_lp,"update bps_Serahterima set type_brg='Barang' where ho_no='$ho_no' ");
	//echo "<div id='mendebug'>kkk</div>";
	//var_dump($ho_no);
	//die();
	$tb_del1=odbc_exec($koneksi_lp,"delete from bps_Serahterima where ho_no='$ho_no' ");
}

?>

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>SERAH TERIMA BARANG</h2>
		</div>

		<div class="row clearfix">
			<div class="card">
				<div class="header">
					<h2>INPUT<small>Manual Input Budget</small></h2>
				</div>

				<div class="body">
					<form name="form1" id="form1" method="post" action="">
						<div class="row clearfix">

							<div class="col-sm-3">
								<div class="form-group">
									<label>Section</label>
									<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="sect_t" id="sect_t">
										<option selected="selected" value="">--Section--</option>
										<?php
										$tb_sect=odbc_exec($koneksi_lp,"SELECT distinct sect_to from bps_kedatangan where lp='$sec' and po_no!=pr_no order by sect_to asc");
										// echo $tb_supp;
										while(odbc_fetch_array($tb_sect)){
											$sect_t=odbc_result($tb_sect,"sect_to");
											echo '<option value="'.$sect_t.'">'.$sect_t.'</option>';
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<label>Optional Filter</label>
									<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari">
										<option selected="selected" value="">---Pilih Kolom---</option>
										<option value="a.pr_no">PR No</option>
										<option value="a.po_no">PO No</option>
										<option value="a.inv_no">INV No</option>
										<option value="a.part_no">Part No</option>
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

							<div class="col-sm-1">
								<div class="form-group">
									<button type="submit" name="cr" id="cr" class="btn bg-purple waves-effect"><i class="material-icons">search</i></button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<?php
		if(isset($_POST['cr'])){
			$sect_to=$_POST['sect_t'];
			if($sect_to==''){
				$cr_sect="";}else{$cr_sect=" and sect_to='$sect_to'";
			}
			$rg_tgl=explode("-",$_POST['rg_tgl']);

			$whr="(tgl_terima between '".date("Y-m-d H:i:s",strtotime($rg_tgl[0]))."' and '".date("Y-m-d H:i:s",strtotime($rg_tgl[1]))."') and sect='".$sect."'";
			?>

			<div class="row clearfix">
				<div class="card">

					<form action="" id="frmcari" name="frmcari" method="post" enctype="multipart/form-data">
						<div class="header">
							<h2>Pilih<small>Cari Penerimaan Barang</small></h2>
						</div>

						<div class="row clearfix">
							<div class="body">

								<div class="col-sm-2">
									<div class="form-group">
										<label>Penerima</label>
										<div class="form-line">
											<input type="text" class="form-control" id="pic_terima" name="pic_terima"  placeholder="Penerima" required>
										</div>
									</div>
								</div>

								<div class="col-sm-3">
									<div class="form-group">
										<label>Waktu Terima</label>
										<div class="form-line">
											<input type="text" class="form-control datetime-rg" id="tgl_terima" name="tgl_terima"  placeholder="Waktu Terima" required>
										</div>
									</div>
								</div>

								<div class="col-sm-3">
									<div class="form-group">
										<label>Type Barang</label>
										<div class="form-line">
											<select class="selectpicker" data-live-search="true" style="width: 50%;" name="type_brg" id="type_brg" required>
												<option selected="selected" value="">---Pilih Type---</option>
												<option value="Sparepart">Sparepart</option>
												<option value="Konsumtif">Konsumtif</option>
												<option value="Barang">Barang</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row clearfix">
							<div class="body">
								<div class="table-wrapper-scroll-y my-custom-scrollbar">
									<table id="example" class="table table-bordered table-striped table-hover dataTable tabel2">
										<thead>
											<tr>
												<th>
													<div class="switch" >
														<label>
															<input type="checkbox" onchange="checkAll(this)" name="chk[]" >
															<span class="lever"></span>
														</label>
													</div>
												</th>
												<th>SECTION</th>
												<th>NO CONTROL</th>
												<th>PART NO</th>
												<th>DESCRIPTION</th>
												<th>QTY</th>
												<th>PR</th>
												<th>PO</th>
												<th>INVOICE</th>
											</tr>
										</thead>

										<tbody>
											<?php
											$cmd_cari=$_POST['cmd_cari'];
											$txt_cari=str_replace(" ","",$_POST['txt_cari']);
											if($txt_cari==""){$whr=""; }else{
												$whr=" and replace($cmd_cari,' ','') like '%$txt_cari%'";}

												$sq_acc="SELECT a.no_ctrl, sect_to,a.pr_no,a.po_no,a.inv_no,a.part_no,a.part_nm,a.part_dtl, a.part_desc, isnull(sum(a.qty_dtg),0) as qty_dtg, 
												isnull(b.qty,0) as qty_ho,a.uom, isnull((select sum(qty) from bps_Serahterima where po_no=a.po_no and no_ctrl=a.no_ctrl),0) as qty_act 
												from bps_kedatangan a left join bps_Serahterima b on a.no_ctrl=b.no_ctrl and a.po_no=b.po_no and a.pr_no=b.pr_no
												left join bps_tmpPR c on a.no_ctrl=c.no_ctrl and a.pr_no=c.pr_no
												where a.lp='$sec' and a.tgl_updt>'$tahunlalu'  $cr_sect $whr
												group by a.no_ctrl,sect_to,a.pr_no,a.po_no,a.inv_no,a.part_no,a.part_nm,a.part_dtl,a.part_desc,b.qty,a.uom
												having isnull(sum(a.qty_dtg),0)>isnull(b.qty,0)";
												// having isnull(sum(a.qty_dtg),0)>isnull(b.qty,0)";

												// echo $sq_acc;
												$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
												$row=0;
												while($baris1=odbc_fetch_array($tb_acc)){
													$row++;
													$part_nm=odbc_result($tb_acc,"part_nm");
													$part_dtl=odbc_result($tb_acc,"part_dtl");
													$part_no=odbc_result($tb_acc,"part_no");
													$pr_no=odbc_result($tb_acc,"pr_no");
													$po_no=odbc_result($tb_acc,"po_no");
													$inv_no=odbc_result($tb_acc,"inv_no");
													$sect_to=odbc_result($tb_acc,"sect_to");
													$qty_dtg=odbc_result($tb_acc,"qty_dtg");
													$qty_ho=odbc_result($tb_acc,"qty_ho");
													$no_ctrl=odbc_result($tb_acc,"no_ctrl");
													$qty_act=odbc_result($tb_acc,"qty_act");
													$bal_qty=$qty_dtg-$qty_ho;
													?>

													<!--tr onclick="javascript:pilih(this);"-->
													<tr>
														<td>
															<div class="switch" >
																<label>																		
																	<input type="checkbox" name="plh[]" id="plh" value="<?php echo $part_no."|".$part_nm."|".$part_dtl."|".$pr_no."|".$po_no."|".$inv_no."|".$sect_to."|".$bal_qty."|".$no_ctrl ; ?>" >
																	<span class="lever"></span>
																</label>
															</div>
														</td>
														<td><?php echo $sect_to; ?></td>
														<td><?php echo $no_ctrl; ?></td>
														<td><?php echo $part_no; ?></td>
														<td><?php echo $part_nm." ".$part_dtl; ?></td>
														<td><?php echo $bal_qty; ?></td>
														<td><?php echo $pr_no; ?></td>
														<td><?php echo $po_no; ?></td>
														<td><?php echo $inv_no; ?></td>
													</tr>
													<?php 
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
												</tr>

											</tbody>
										</table>
									</div>
									<div class="body">
										<div class="form-group">
											<button type="submit" name="smpn" id="smpn" class="btn bg-green waves-effect"><i class="material-icons">save</i>Simpan</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<?php 
			} 
			?> 

			<div class="row clearfix">
				<div class="card">
					<div class="header">
						<h2>Record Serah Terima Barang</h2>
					</div>
					<form action="" id="frm_rmk" name="frm_rmk" method="post"  enctype="multipart/form-data">
						<div class="row clearfix">
							<div class="body">
								<div class="table-responsive">
									<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
										<thead>
											<tr>
												<th>Dept/ Sect</th>
												<!-- <th>PR NO</th> -->
												<th>PO NO</th>
												<th>INV NO</th>
												<th>No Serah Terima</th>
												<th>Tanggal Terima</th>
												<th>PIC Terima</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$bln_kemarin= date ("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
											$sq_pr="select distinct sect,po_no,inv_no,ho_no,tgl_terima, pic_terima from bps_Serahterima
											where lp='$sec' and tgl_updt between '$bln_kemarin' and getdate () order by ho_no desc";
											$tb_pr=odbc_exec($koneksi_lp,$sq_pr);
											$i=0;
											// echo $sq_pr;
											while($bar_pr=odbc_fetch_array($tb_pr)){
												$i++;
												$sect=odbc_result($tb_pr,"sect");
												$pr_no=odbc_result($tb_pr,"pr_no");
												$po_no=odbc_result($tb_pr,"po_no");
												$inv_no=odbc_result($tb_pr,"inv_no");
												$ho_no=odbc_result($tb_pr,"ho_no");
												$tgl_terima=odbc_result($tb_pr,"tgl_terima");
												$pic_terima=odbc_result($tb_pr,"pic_terima");
												?>
												<tr onclick="javascript:pilih(this);">
													<td><?php echo $sect; ?></td>
													<!-- <td><?php echo $pr_no; ?></td> -->
													<td><?php echo $po_no; ?></td>
													<td><?php echo $inv_no; ?></td>
													<td><?php echo $ho_no; ?></td>
													<td><?php echo date("Y-m-d",strtotime($tgl_terima)); ?></td>
													<td><?php echo $pic_terima; ?></td>
													<td>
														<?php
														$count=odbc_exec($koneksi_lp,"select count(*) as jm from bps_serahterima where ho_no='$ho_no' ") ;
														$jm=odbc_result($count, "jm");
														if ($jm<=8){
															?>
															<button type="button" class="btn bg-green waves-effect" onclick="open_child('Exp_pdf/print_ho2.php?nomor=<?php echo $i;?>&hono=<?php echo $ho_no;?>','Print HO <?php echo $ho_no;?>','800','500'); return false;"><i class="material-icons">print</i></button> 
														<?php }else { ?>
															<button type="button" class="btn bg-green waves-effect" onclick="open_child('Exp_pdf/print_ho.php?nomor=<?php echo $i;?>&hono=<?php echo $ho_no;?>','Print HO <?php echo $ho_no;?>','800','500'); return false;"><i class="material-icons">print</i></button> 
															<?php 
														}
														?>
														<!--<button type="button" class="btn bg-red waves-effect" onClick="delho()" ><i class="material-icons">delete</i></button>-->
														<button type="button" class="btn bg-red waves-effect" onClick="delho('<?= $ho_no; ?>')" ><i class="material-icons">delete</i></button>
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

	<div class="modal fade" id="mddel" tabindex="1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">HAPUS SERAH TERIMA</h4></div>
				<form action="" id="frmdel" name="frmdel" method="post"  enctype="multipart/form-data">
					<div class="modal-body">
						APAKAH ANDA YAKIN INGIN MENGHAPUS DARI DAFTAR SERAH TERIMA? 
						<input type="text" readonly class="form-control" data-role="tagsinput" id="ho_no" name="ho_no" placeholder="ho_no" required>
						<div class="modal-footer">
							<button type="submit" id="del_ho" name="del_ho" class="btn btn-link waves-effect">HAPUS</button>
							<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(function() {
			$('input[name="rg_tgl"]').daterangepicker({
				timePicker: true,
				startDate: moment().startOf('hour'),
				endDate: moment().startOf('hour').add(32, 'hour'),
				locale: {
					format: 'M/DD/YYYY HH:mm:ss'
				}
			});
		});

		function pilih(row)
        {
            var kd_pel0=row.cells[4].innerHTML;
            // document.frmdel.ho_no.value=kd_pel0;
        }
 
        function delho(hoNo){
            document.frmdel.ho_no.value=hoNo;
            $('#mddel').modal('show');
        };
	</script>

	<script type="text/javascript">
		function checkAll(ele) {
			var checkboxes = document.getElementsByTagName('input');
			if (ele.checked) {
				for (var i = 0; i < checkboxes.length; i++) {
					if (checkboxes[i].type == 'checkbox' ) {
						checkboxes[i].checked = true;
					}
				}
			} else {
				for (var i = 0; i < checkboxes.length; i++) {
					if (checkboxes[i].type == 'checkbox') {
						checkboxes[i].checked = false;
					}
				}
			}
		}
	</script>
