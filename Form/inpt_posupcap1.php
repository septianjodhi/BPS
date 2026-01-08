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
$sect=$_SESSION["area"]; 
$pic=$_SESSION["nama"];
$pch_sect=explode("-",$sect);
$dept=$pch_sect[0];
$sec=$pch_sect[1];

if(isset($_POST['delpo']) ){	
	$podel=$_POST["podel"];
	$blnb=date("ymdh");
	$revpono=$sec."-".$blnb."-000";
	$tb_del1=odbc_exec($koneksi_lp,"delete from bps_podtl where po_no='$podel'");
	//echo $tb_del1;
	$tb_del1=odbc_exec($koneksi_lp,"delete from bps_approve where jns_doc='PO' and no_doc='$podel'");}

	if(isset($_POST['smpn_po']) ){
		$bln=date("ym");
		$blnth=date("Ym");
		$nopo=0;
		$plh=$_POST['plh'];
		$kd_spp=$_POST['suppl'];
		$eta=$_POST['eta_po'];
		// $beli=$_POST['bagi'];
		
		$qry_nopo="select max(RIGHT(po_no,3)) as jj from bps_podtl where lp='$sec' and kode_supp='$kd_spp' and convert(nvarchar(6),tgl_updt,112)='$blnth'";

		$tb_nopo=odbc_exec($koneksi_lp,$qry_nopo);
		while($bar_nopo=odbc_fetch_array($tb_nopo)){
			$nopo=odbc_result($tb_nopo,"jj");
		}
		
		$nopo=$nopo+1;	
		$nopo3=substr('000'.$nopo,-3);

		$pph=$_POST['pph'];
		$ppn=$_POST['ppn'];
		$po_no="PO-".$sec."-".$kd_spp.$bln."-".$nopo3;
		
		$qty_po="";
		
		foreach ($plh as $_boxValue2){
			$np2=explode("|",$_boxValue2);

			$cek="";
			// $crqtycap="SELECT top 1 kapasitas FROM bps_suppcapacity where supp_code='$kd_spp' and part_no='' and periode='$np2[2]' ";

			// if($beli=='' or $beli==100 ){
				// $persen_beli="(CASE when (select max(prioritas) from bps_suppcapacity where part_no=a.part_no and
				// supp_code='$kd_spp')> prioritas then round(a.qty_act*(kapasitas/100),0) else floor (a.qty_act * 
				// (kapasitas/100)) end)";

				// $persen_beli="(CASE when (select kapasitas from bps_suppcapacity where part_no=a.part_no and
				// supp_code='$kd_spp' and periode='$np2[2]' )> kapasitas then round(a.qty_act*(kapasitas/100),0) else floor (a.qty_act * 
				// (kapasitas/100)) end)";

				// $persen_beli=" a.qty_act ";
			// }else{
			// 	$persen_beli=" (a.qty_act*$beli/100) ";
			// }

	//$updt_po="update bps_podtl set po_no='$po_no',tgl_updt=getdate(),eta='$eta',status_po='OPEN',ppn='$ppn',pph='$pph'
	//where po_no not like 'PO%' and kode_supp='$np2[1]' and part_no='$np2[0]' and pr_no='$np2[2]' and lp='$sec'";

			$cek_data=odbc_exec($koneksi_lp,"SELECT count(*) as jm from bps_podtl where kode_supp='$kd_spp' and pr_no='$np2[0]' and periode='$np2[2]' and po_no not like 'PO-%' ") ;
			$jm=odbc_result($cek_data, 'jm');

			$max_qty="SELECT sum(qty) as qty from bps_podtl a where pr_no='$np2[0]' and no_ctrl in (SELECT no_ctrl from bps_pr where pr_no=a.pr_no) ";
			$maxi_qty=odbc_exec($koneksi_lp,$max_qty);
			$qty_po=odbc_result($maxi_qty, 'qty');

			$updt_po="insert into bps_podtl ( no_quo,kode_supp,pr_no,part_no,part_nm,part_dtl,part_desc,po_no,eta,pic_updt,tgl_updt,qty,price,lp,term,periode,curr,
			uom,account,cccode,no_ctrl,status_po,ppn,pph)

			select distinct no_quo,'$kd_spp' as kode_supp,pr_no,a.part_no,a.part_nm,a.part_dtl,(case when a.part_desc
			is null then '-' else a.part_desc end) as part_desc,'$po_no' as po_no,'$eta' as eta, '$pic' as pic_updt,
			getdate() as tgl_updt,round(qty_act*0.25,0) as qty,price_tot as price,a.lp,a.term, a.periode,curr,uom, account,cccode,no_ctrl,'OPEN' as status_po,$ppn as ppn,$pph as pph
			from bps_tmpPR a
			inner join bps_suppcapacity b on a.part_no=b.part_no and a.lp=b.lp
			where a.pr_no='$np2[0]' and supp_code='$kd_spp' and (select top 1 status from bps_approve where no_doc=a.pr_no )='FINISH' and a.lp='$sec'
			and penawaran='YES'
			group by no_quo,pr_no,a.part_no,a.part_nm,a.part_dtl,a.part_desc,qty_act,price_tot,a.lp,a.term,a.periode,curr,uom,account,cccode,no_ctrl,prioritas,kapasitas,a.kode_supp";
	//and not exists ( select * from bps_podtl b where pr_no=a.PR_NO and part_no=a.part_no and part_nm=a.part_nm and part_dtl=a.part_dtl and kode_supp=a.kode_supp)

			$tbupdt_po=odbc_exec($koneksi_lp,$updt_po);
	//echo "<script>alert('$updt_po -  $po_no - $eta - $sec - $np2[1] - $np2[0] - $np2[2] - $pph -  $ppn');</script>";
	echo "<script>alert('$qty_po');</script>";

			// echo $updt_po."<br>"."SELECT count(*) as jm from bps_podtl where kode_supp='$kd_spp' and pr_no='$np2[0]' and periode='$np2[2]' and po_no not like 'PO-%' ";
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
				<h2>Purchase Order Supplier Capacity</h2>
			</div>

			<div class="row clearfix">	
				<div class="card">
					<div class="row clearfix">		
						<div class="header">
							<h2>Record<small></small></h2>
						</div>

						<div class="body">
							<form action="" id="frmsupp" method="post"  enctype="multipart/form-data">

								<div class="col-sm-3">	
									<div class="form-group">
										<label>Supplier</label>
										<div class="form-line">
											<select class="selectpicker" style="width: 100%;"  name="ksupp" id="ksupp" required>
												<option selected="selected" value="">--Pilih Supplier--</option>
												<?php
												$tb_ksupp=odbc_exec($koneksi_lp,"select distinct supp_code from bps_suppcapacity a left join bps_tmpPR b on a.periode=b.periode and a.lp=b.lp and a.part_no=b.part_no where a.lp='$sec' and a.periode>=convert(nvarchar(6),getdate(),112) and supp_code is not null ");
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
									<button type="submit" name="cr_s" id="cr_s" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">search</i></button>
									<button type="reset" name="reset" id="reset" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">clear</i> </button>
								</div>
							</form>
						</div>	
					</div>
				</div>
			</div>


			<?php
			if(isset($_POST['cr_s'])){
				$kdsuppi=$_POST['ksupp'];
				?>
				<div class="row clearfix">
					<div class="card">
						<form action="" id="frmcari" name="frmcari" method="post"  enctype="multipart/form-data">
							<div class="row clearfix">				
								<div class="header">
									<h2>Buat Purchase Order (PO)</h2>
								</div>
								<div class="body">
									<div class="col-sm-2">	
										<div class="form-group">
											<label>Supplier</label>
											<div class="form-line">
												<input type="text" readonly name="suppl" id="suppl" value="<?php echo $kdsuppi; ?>" class="form-control"  required>
											</div>
										</div>
									</div>
									<!-- <div class="col-sm-2">	
										<div class="form-group">
											<label>Persentase Capacity(%)</label>
											<div class="form-line">
												<input type="number" class="form-control" id="bagi" name="bagi" placeholder="Persentase Pembelian">
											</div> 
										</div>
									</div> -->
									<div class="col-sm-2">	
										<div class="form-group">
											<label>PO Date</label>
											<div class="form-line">
												<input type="text" name="po_date" id="po_date" value="<?php echo date("Y-m-d");?>" class="form-control date-min"  required>
											</div>
										</div>
									</div>
									<div class="col-sm-2">	
										<div class="form-group">
											<label>ETA SAMI</label>
											<div class="form-line">
												<input type="text" name="eta_po" id="eta_po" class="form-control date-min"  required>
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
														<th width="80"><div class="switch" >
															<label>
																<input type="checkbox" onchange="checkAll(this)" name="plh[]">
																<span class="lever"></span>
															</label>
														</div></th>
														<th>TERM</th>
														<th>PERIODE</th>
														<th>PR NO</th>
														<th>PR DATE</th>
														<th>SUPP</th>
													</tr>
												</thead>
												<tbody>
													<?php
															// $sq_acc="select distinct a.term,a.periode,pr_no,pr_date,supp_code from bps_tmpPR a
															// left join bps_suppcapacity b on a.part_no=b.part_no and a.lp=b.lp and a.periode=b.periode where and a.lp='$sec' and supp_code='$kdsuppi'and b.periode>=convert(nvarchar(6),getdate(),112)
															// and pr_no not in (select pr_no from bps_podtl where pr_no=a.pr_no and part_no=a.part_no and no_ctrl=a.no_ctrl group by pr_no having sum(qty)>=qty_act)";
													$sq_acc="select distinct a.term,a.periode,pr_no,pr_date,supp_code from bps_tmpPR a left join bps_suppcapacity b on a.part_no=b.part_no and a.lp=b.lp and a.periode=b.periode 
													where a.lp='$sec' and b.periode>=convert(nvarchar(6),getdate(),112) and supp_code='$kdsuppi' and pr_no not in (select pr_no from bps_podtl where po_no like 'PO-%' and pr_no=a.pr_no and part_no=a.part_no 
													and no_ctrl=a.no_ctrl group by pr_no having sum(qty)>=qty_act)";
													$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
													// ECHO $sq_acc;
													$row=0;
													while($baris1=odbc_fetch_array($tb_acc)){ 
														$row++;
														$supp=odbc_result($tb_acc,"supp_code");
														$pr_no=odbc_result($tb_acc,"pr_no");
														$periode=odbc_result($tb_acc,"periode"); 
														?>	
														<tr>				
															<td >
																<div class="switch" ><label><input type="checkbox" name="plh[]" id="plh" value="<?php echo $pr_no.'|'.$supp.'|'.$periode; ?>" onclick="dipilih(this.form);"><span class="lever"></span></label></div>
															</td>
															<td><?php echo odbc_result($tb_acc,"term"); ?></td>
															<td><?php echo $periode; ?></td>
															<td><?php echo $pr_no; ?></td>
															<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_acc,"pr_date"))); ?></td>
															<td><?php echo $supp; ?></td>
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

							<?php if(isset($_POST['cr_s']) and $row>0){ ?>
								<div class="row clearfix">	
									<div class="body">		
										<button type="submit" id="smpn_po" name="smpn_po" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>	
									</div>
								</div> 			
							<?php } ?>
						</form>       
					</div>
				</div>
			<?php } ?>

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
											$sq_po="select distinct a.po_no,min(a.tgl_updt) as tgl,a.kode_supp,b.SUPP_NAME,a.lp from bps_podtl a
											left join lp_supp b on a.kode_supp=b.supp_code inner join bps_suppcapacity c on a.kode_supp=c.supp_code and c.periode=a.periode  where a.lp='$sec' and po_no like 'PO%' and a.periode>=convert(nvarchar(6),getdate(),112) group by a.po_no,a.kode_supp,b.SUPP_NAME,a.lp order by min(a.tgl_updt) desc";
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