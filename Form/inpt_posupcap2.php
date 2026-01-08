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
<script>
	function open_childX(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};
	
	function pil_add(){
		$("#list_part").html('');
		var lstctrl=document.frmcari.plh.value;
		if(lstctrl==""){alert('ANDA BELUM MEMILIH DATA');}else{
			jQuery.ajax({
			type: 'GET', // Post / Get method
			url: 'select/list_part.php',
			dataType:"text", 
			data: {'part':lstctrl},
			success:function(response){
				$("#list_part").append(response);
				$('#mdplhpo').modal('show');
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}
		});
		}	
	};
</script>

<?php
$no_pr=$_GET["pr_no"];
$sect=$_SESSION["area"];
$pic=$_SESSION["nama"];
$pch_sect=explode("-",$sect);
$dept=$pch_sect[0];
$sec=$pch_sect[1];
// $tabel="bps_podtl_trial";
$tabel="bps_podtl";
$lokasi=$_SESSION["lokasi"];

if(isset($_POST['delpo']) ){	
	$podel=$_POST["podel"];
	$blnb=date("ymdh");
	$revpono=$sec."-".$blnb."-000";
	$tb_del1=odbc_exec($koneksi_lp,"delete from $tabel where po_no='$podel'");
	//echo $tb_del1;
	$tb_del1=odbc_exec($koneksi_lp,"delete from bps_approve where jns_doc='PO' and no_doc='$podel'");
}

if(isset($_POST['smpn_po']) ){
	$bln=date("ym");
	$blnth=date("Ym");
	$nopo=0;
	$plh=$_POST['plh'];
	$jml_plh=count($_POST['plh']);
	$kd_spp=$_POST['ksupp'];
	$eta=$_POST['eta_po'];
	$pph=$_POST['pph'];
	$ppn=$_POST['ppn'];

	$qry_nopo="select max(RIGHT(po_no,3)) as jj from $tabel where lp='$sec' and kode_supp='$kd_spp' and convert(nvarchar(6),tgl_updt,112)='$blnth'";

	$tb_nopo=odbc_exec($koneksi_lp,$qry_nopo);
	while($bar_nopo=odbc_fetch_array($tb_nopo)){
		$nopo=odbc_result($tb_nopo,"jj");
	}
	$nopo=$nopo+1;	
	$nopo3=substr('000'.$nopo,-3);

	if ($lokasi=='TF') {
		$po_no="TF-PO-".$sec."-".$kd_spp.$bln."-".$nopo3;
	} else {
		$po_no="JF-PO-".$sec."-".$kd_spp.$bln."-".$nopo3;
	}

	$i=0;
	foreach ($_POST['plh'] as $_boxValue2){
		$lst=explode("|",$_boxValue2);	

		// $no_ctrl=$_POST['no_ctrl'][$i];
		$no_ctrl=$lst[1];
		// $part_no=$_POST['part_no'][$i];
		// $part_no=$lst[4];
		$qty_order=$_POST['qty_po'][$i];
		$qtysendpo=$_POST['qtysendpo'][$i];

		$insert_po="INSERT into $tabel ( no_quo,kode_supp,pr_no,part_no,part_nm,part_dtl,part_desc,po_no,eta,
			pic_updt,tgl_updt,qty,price,lp,term,periode,curr,uom,account,cccode,no_ctrl,status_po,ppn,pph)";

		$query_po="SELECT distinct no_quo,'$kd_spp' as kode_supp,pr_no,a.part_no,a.part_nm,a.part_dtl,part_desc,
		'$po_no' as po_no,'$eta', '$pic' , getdate(), $qty_order, price_tot ,a.lp,a.term, a.periode,curr,uom, 
		account,cccode,no_ctrl,'OPEN' ,	$ppn ,$pph from bps_tmpPR a
		left join bps_suppcapacity b on a.part_no=b.part_no and a.lp=b.lp
		where a.pr_no='$no_pr' and supp_code='$kd_spp' and a.lp='$sec'	and penawaran='YES' and no_ctrl='$lst[1]'
		group by no_quo,pr_no,a.part_no,a.part_nm,a.part_dtl,a.part_desc,qty_act,price_tot,a.lp,a.term,a.periode,
		curr,uom,account,cccode,no_ctrl,prioritas,kapasitas,a.kode_supp";

		$updt_po=$insert_po." ".$query_po;
		// and (select top 1 status from bps_approve where no_doc=a.pr_no )='FINISH' 

		// echo $updt_po;
		$tbupdt_po=odbc_exec($koneksi_lp,$updt_po);

	//echo "<script>alert('$updt_po -  $po_no - $eta - $sec - $np2[1] - $np2[0] - $np2[2] - $pph -  $ppn');</script>";
		// echo "<script>alert('$lst[1]');</script>";
		$i++;
	}

	$qry_delaprv="delete from bps_approve where jns_doc='PO' and no_doc='$po_no'";
	$tb_delaprv=odbc_exec($koneksi_lp,$qry_delaprv);
	$qry_adaprv="insert into bps_approve(pic_plan,email_plan,no_doc,tgl_prepaire,jns_doc,sect,initial,approve,no_aprv) SELECT nama as pic_plan,email as email_plan,'$po_no' as no_doc,getdate() as tgl_prepaire,'PO',sect,initial,approve,no_aprv  FROM bps_setApprove where jns_dok='PO' and status_akun='aktif'  and (sect='$sect' or sect='$dept-ALL' or sect='SAMI-ALL')";
	$tb_delaprv=odbc_exec($koneksi_lp,$qry_adaprv);
	//echo $qry_adaprv;
	//============================================================================
	//echo "<script>window.close();</script>";
}

?>

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Purchase Order Supplier Capacity PR NO <?= $no_pr; ?></h2>
		</div>

		<div class="row clearfix">
			<div class="card">
				<form action="" id="frmcari" name="frmcari" method="post"  enctype="multipart/form-data">
					<div class="row clearfix">				
						<div class="header">
							<h2>Buat Purchase Order (PO)</h2>
						</div>
						<div class="body">
							<div class="col-sm-3">	
								<div class="form-group">
									<label>Supplier</label>
									<div class="form-line">
										<select class="selectpicker" style="width: 100%;"  name="ksupp" id="ksupp" required>
											<option selected="selected" value="">--Pilih Supplier--</option>
											<?php
											$tb_ksupp=odbc_exec($koneksi_lp,"SELECT distinct supp_code from bps_suppcapacity a left join bps_tmpPR b on a.periode=b.periode and a.lp=b.lp and a.part_no=b.part_no where a.lp='$sec' and pr_no='$no_pr' and a.periode>=convert(nvarchar(6),getdate(),112) and supp_code is not null ");
											while($baris1=odbc_fetch_array($tb_ksupp)){
												$ksupp=odbc_result($tb_ksupp,"supp_code");
												echo '<option value="'.$ksupp.'">'.$ksupp.'</option>';
											}
											?>	
										</select>
									</div> 
								</div>
							</div>
							<div class="col-sm-2">	
								<div class="form-group">
									<label>PO Date</label>
									<div class="form-line">
										<input type="date" name="po_date" id="po_date" value="<?php echo date("Y-m-d");?>" class="form-control date-min">
										<!-- <input type="text" name="po_date" id="po_date" value="<?php echo date("Y-m-d");?>" class="form-control date-min"  required> -->
									</div>
								</div>
							</div>
							<div class="col-sm-2">	
								<div class="form-group">
									<label>ETA SAMI</label>
									<div class="form-line">
										<input type="date" name="eta_po" id="eta_po" class="form-control date-min" value="<?php echo date("Y-m-d");?>" required>
										<!-- <input type="text" name="eta_po" id="eta_po" class="form-control date-min"  required> -->
									</div>
								</div>
							</div>
							<div class="col-sm-2">	
								<div class="form-group">
									<label>PPN</label>
									<div class="form-line">
										<select class="selectpicker" style="width: 100%;"  name="ppn" id="ppn" >
											<option selected="selected" value="0">---Pilih Nominal---</option>
											<option value="0">0%</option>
											<option value="10">10%</option>
										</select>
									</div>
								</div>
							</div> 
							<div class="col-sm-2">	
								<div class="form-group">
									<label>PPH</label>
									<div class="form-line">
										<select class="selectpicker" style="width: 100%;"  name="pph" id="pph" >
											<option selected="selected" value="0">---Pilih Nominal---</option>
											<option value="0">0%</option>
											<option value="2">2%</option>
											<option value="3">3%</option>
											<option value="4">4%</option>
											<option value="5">5%</option>
										</select>
									</div>
								</div>
							</div> 
						</div>	
					</div>

					<div class="row clearfix">
						<div class="body">
							<div class="table-responsive">
								<div class="table-wrapper-scroll-y my-custom-scrollbar">
									<table id="dtVerticalScroll" class="table table-bordered table-striped dataTable tabel2 " cellspacing="0" width="100%">				
										<thead>	
											<tr>
												<th width="80">Pilih
													<!-- <div class="switch" >
														<label>
															<input type="checkbox" onchange="checkAll(this)" name="plh[]">
															<span class="lever"></span>
														</label>
													</div> -->
												</th>
												<th>Part No</th>
												<th>Part Name</th>
												<th>Part Detail</th>
												<th>Price</th>
												<th>UOM</th>
												<th>Qty PR</th>
												<th>Qty sudah PO</th>
												<th>Qty Order</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sq_acc="SELECT * from bps_tmpPR a where pr_no='$no_pr' and a.lp='$sec' and part_no in ( select distinct part_no from bps_suppcapacity where part_no=a.part_no and periode=a.periode and lp=a.lp ) and pr_no not in (select pr_no from $tabel where po_no like '$lokasi-PO-%' and pr_no=a.pr_no and part_no=a.part_no and no_ctrl=a.no_ctrl group by pr_no having sum(qty)>=qty_act)";

											$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
													// ECHO $sq_acc;
											$row=0;
											while($baris1=odbc_fetch_array($tb_acc)){ 
												$row++;
												$periode=odbc_result($tb_acc,"periode");
												$no_ctrl=odbc_result($tb_acc,"no_ctrl");
												$part_no=odbc_result($tb_acc,"part_no");
												$part_nm=odbc_result($tb_acc,"part_nm");
												$part_dtl=odbc_result($tb_acc,"part_dtl");
												$qty_pr=odbc_result($tb_acc,"qty_act");
												$price_pr=odbc_result($tb_acc,"price_tot");
												$uom=odbc_result($tb_acc,"uom");
												?>	
												<tr>				
													<td >
														<div class="switch" ><label><input type="checkbox" name="plh[]" id="plh" value="<?= $no_pr.'|'.$no_ctrl.'|'.$periode.'|'.$row.'|'.$part_no; ?>" onclick="dipilih(this.form);"><span class="lever"></span></label>
															<input type="hidden" name="no_ctrl[]" value="<?= $no_ctrl ; ?>">
															<input type="hidden" name="part_no[]" value="<?= $part_no ; ?>">
														</div>
													</td>
													<td><?php echo $part_no; ?></td>
													<td><?php echo $part_nm; ?></td>
													<td><?php echo $part_dtl; ?></td>
													<td><?php echo $price_pr; ?></td>
													<td><?php echo $uom; ?></td>
													<td><?php echo $qty_pr; ?></td>
													<?php 
													$qry_3=odbc_exec($koneksi_lp,"SELECT isnull(sum(qty),0) as qty from $tabel where pr_no='$no_pr' and no_ctrl='$no_ctrl' "); 
													$qtypo_tot=odbc_result($qry_3,"qty");
													?>
													<td><?php echo $qtypo_tot; ?></td>
													<td><input type="number" class="form-control" step="any" min="0" max="<?= $qty_pr-$qtypo_tot; ?>" value="<?= $qty_pr-$qtypo_tot; ?>" name="qty_po[]" />
														<input type="hidden" name="qtysendpo[]" value="<?= $qtypo_tot; ?>">
													</td>
												</tr>
												<?php 
											}
											?>
											<tr class="odd gradeX">
												<td align="center" valign="middle" nowrap="nowrap"><input type="checkbox"  name="plh[]" id="plh" value="-|0|0" ></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>  

					<?php if($row>0){ ?>
						<div class="row clearfix">
							<div class="body">
								<button type="submit" id="smpn_po" name="smpn_po" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>	
							</div>
						</div>
					<?php } ?> 			
				</form>
			</div>
		</div>

		<div class="row clearfix">
			<div class="card">
				<div class="header">
					<h2>Print Purchase Order (PO)</h2>
				</div>
				<form action="" id="frm_rmk" name="frm_rmk" method="post"  enctype="multipart/form-data">
					<div class="row clearfix">
						<div class="body">
							<div class="table-responsive">
								<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">						
									<thead>
										<tr>	
											<th>NO</th>
											<th>PO NO</th>
											<th>TANGGAL</th>
											<th>SUPPLIER CODE</th>
											<th>SUPPLIER</th>
											<th>LP</th>
											<th></th>
										</tr>
									</thead>  
									<tbody>
										<?php
										$sq_po="select distinct a.po_no,min(a.tgl_updt) as tgl,a.kode_supp,b.SUPP_NAME,a.lp from $tabel a
										left join lp_supp b on a.kode_supp=b.supp_code inner join bps_suppcapacity c on a.kode_supp=c.supp_code and c.periode=a.periode  where a.lp='$sec' and po_no like '$lokasi-PO%' and a.periode>=convert(nvarchar(6),getdate(),112) group by a.po_no,a.kode_supp,b.SUPP_NAME,a.lp order by min(a.tgl_updt) desc";
										$tb_po=odbc_exec($koneksi_lp,$sq_po);
										$i=0;
										while($bar_po=odbc_fetch_array($tb_po)){ $i++;
											$pono=odbc_result($tb_po,"po_no");
											$supp_code=odbc_result($tb_po,"kode_supp");
											?>	
											<tr  onclick="javascript:pilih(this);" >
												<td><?php echo $i; ?></td>
												<td><?php echo $pono; ?></td>
												<td><?php echo date("d-M-Y",strtotime(odbc_result($tb_po,"tgl"))); ?></td>
												<td><?php echo $supp_code; ?></td>
												<td><?php echo odbc_result($tb_po,"SUPP_NAME"); ?></td>
												<td><?php echo odbc_result($tb_po,"lp"); ?></td>
												<td>
													<a href="##"><i onclick="open_child('Exp_pdf/print_po.php?nomor=<?php echo $i;?>&po_no=<?php echo $pono;?>','Print PO <?php echo $pono;?>','800','500'); return false;" class="material-icons">print</i></a>
													<a href="#" onClick="deletepo()" ><i  class="material-icons">delete</i></a>
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
			<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">HAPUS PO</h4></div>
			<form action="" id="frmdel" name="frmdel" method="post"  enctype="multipart/form-data">
				<div class="modal-body">
					APAKAH ANDA YAKIN INGIN MENGHAPUS PO <input type="text" readonly class="form-control" data-role="tagsinput" id="podel" name="podel" placeholder="PO NO" required>
					<div class="modal-footer">
						<button type="submit" id="delpo" name="delpo" class="btn btn-link waves-effect">HAPUS</button>
						<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	function dipilih(frm){
		var PlhData="";
		var PchData="";
		var data0="";
		var data1="<?php echo $row; ?>";
		if(data1==1){
			data0 += "<?php echo $part_no.'|'.$supp.'|'.$pr_no.'|'.$qty; ?>,";
		}else{
			for (i = 0; i < frm.plh.length; i++){
				if (frm.plh[i].checked){
				//PlhData += frm.plh[i].value +",";
				var dataisi=frm.plh[i].value;
				//PchData=dataisi.split('|');
				//data0 += PchData[0] +","+PchData[1]+","+PchData[2]+","+PchData[3]+","+PchData[4]+",";
				data0 += dataisi+",";
			}else{
			}
		}
	}
	document.frmcari.noctrlplh.value=data0;
}	
</script>
<script>
	function pilih(row){
		var kd_pel1=row.cells[1].innerHTML;
//alert(kd_pel1)
document.frmdel.podel.value=kd_pel1;
};
function deletepo(){
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