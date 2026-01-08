
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
				$lok=$_GET["sesi"];
				$nodoc=$_GET["nodoc"];
				$sect=$_GET["sec"];
				$sql1="select * from bps_budget_add a where doc_no='$nodoc' order by part_no asc";
			 //echo $sql1;
				include "../koneksi.php";

				if(isset($_POST['smpn'])){
			//$tb_deltmp=odbc_exec($koneksi_lp,"delete from bps_tmppr where pr_no='$prno'");
			//$sect= $_SESSION["area"];

					$count=count($_POST['p_no']);
					$no_ctrl=$_POST['no_ctrl'];
					$p_nm=$_POST['p_nm'];
					$p_no=$_POST['p_no'];
					$p_dtl=$_POST['p_dtl'];
					$p_desc=$_POST['p_desc'];
					$qty=$_POST['qty'];
					$price=$_POST['price'];
					$area=$_POST['cccode'];
					$lsctrl=explode(",",$_POST['lsctrl']);
					$reason=$_POST['reason'];
					$kd_chg=$_POST['kd_chg'];
			//$tb_delaprv=odbc_exec($koneksi_lp,"delete from bs_approve where no_doc='$prno' and jns_doc='PR'");

					for ($i=0;$i<$count;$i++){
			//$noctrl=$no_ctrl[$i];
						$noctrl=$lsctrl[$i];
						$pnm=$p_nm[$i];
						$pno=$p_no[$i];
						$pdtl=$p_dtl[$i];
						$pdesc=$p_desc[$i];
						$cc_code=$area[$i];
						$rea_son=$reason[$i];
						$q_ty=number_format($qty[$i],11,".","");
						$pres=number_format($price[$i],11,".","");
						$kdchg=$kd_chg[$i];
						$amn_add=$q_ty*$pres;


						if($amn_add>0){

							$q_update2="update bps_budget_add set part_no='$pno',part_dtl='$pdtl',part_desc='$pdesc',cccode='$cc_code', qty='$q_ty',price='$pres',remark='$rea_son',tgl_updt=getdate() where no_ctrl='$noctrl' and doc_no='$nodoc' and kode_chg='$kdchg'";
				//echo "alert $q_update2";
							$tb_part=odbc_exec($koneksi_lp,$q_update2);

						}else{
							$del_dt="update bps_budget_add set doc_no=null,doc_date=null where no_ctrl='$noctrl' and doc_no='$nodoc' and kode_chg='$kdchg'";
				//echo "alert $q_update2";
							$tb_del_dt=odbc_exec($koneksi_lp,$del_dt);
							//$tb_deladd=odbc_exec($koneksi_lp,"update bps_budget_add set doc_no is null,doc_date is null where no_ctrl='$no_ctrl' and doc_no='$nodoc' ");
						}
					}

					$amoun_USD=0;
					$amoun_IDR=0;
					$sql_amount="select doc_no,COUNT(no_ctrl) as jm_item,sum(qty) as tot_qty,sum(dbo.lp_konprc(term,'IDR',curr,qty*price)) as idr,sum(dbo.lp_konprc(term,'USD',curr,qty*price)) as dolar from bps_budget_add where doc_no='$nodoc' group by doc_no";
					$tb_amount=odbc_exec($koneksi_lp,$sql_amount);
					while($bar_moun=odbc_fetch_array($tb_amount)){
						$amoun_IDR=odbc_result($tb_amount,"idr");
						$amoun_USD=odbc_result($tb_amount,"dolar");
						$jm_item=odbc_result($tb_amount,"jm_item");
						$tot_qty=odbc_result($tb_amount,"tot_qty");
					}

					$pchsec=explode("-",$sect);
					$dept=$pchsec[0];
					$qry_delaprv="delete from bps_approve where jns_doc in('ADD') and no_doc='$nodoc'";
					$tb_delaprv=odbc_exec($koneksi_lp,$qry_delaprv);
					$qry_adaprv="insert into bps_approve(pic_plan,email_plan,no_doc,tgl_prepaire,jns_doc,sect,initial, approve,no_aprv) SELECT nama as pic_plan,email as email_plan,'$nodoc' as no_doc,getdate() as tgl_prepaire,jns_dok as jns_doc,sect,initial,approve,no_aprv  FROM bps_setApprove where jns_dok in('ADD') and (sect='$sect' or sect='$dept-ALL' or (sect='SAMI-ALL' AND (max_amount='0' or (min_amount<'$amoun_IDR' and max_amount>='$amoun_IDR'))))";
			//$amoun_USD
					$tb_adaprv=odbc_exec($koneksi_lp,$qry_adaprv);
			//}
					?>

					<script>
			//var jm_item="<?php echo $jm_item; ?>";
			//var tot_qty="<?php echo $tot_qty; ?>";
			//var amoun_IDR="<?php echo number_format($amoun_IDR,2,'.',','); ?>";
			//var amoun_USD="<?php echo number_format($amoun_USD,2,'.',','); ?>";
			//window.opener.parent.document.getElementById("jmitem").value =jm_item;
			//window.opener.parent.document.getElementById("tot_qty").value =tot_qty;
			//window.opener.parent.document.getElementById("idr").value =amoun_IDR;
			//window.opener.parent.document.getElementById("dolar").value =amoun_USD;
		window.close();</script>;

	<?php } ?>

	<div class="block-header"><h2>REVISI ADDITIONAL (<?php echo $nodoc ; ?>)</h2></div>
	<form id="form1" name="form1" method="post">
		<div class="row clearfix">

			<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
				<thead>
					<tr>
						<th>NO CONTROL</th>
						<th>PART NAME</th>
						<th>PART NO</th>
						<th>DETAIL PART</th>
						<th>DESC PART</th>
						<th>QTY</th>
						<th>PRICE</th>
						<th>COST CENTER</th>
						<th>REASON</th>
					</tr>
				</thead>
				<tbody>
					<!--data ini bisa di loop dari database-->
					<?php
					$tb_area=odbc_exec($koneksi_lp,$sql1);
					$row=0;$lsctrl="";
					while($baris1=odbc_fetch_array($tb_area)){$row++;
						$part_nm=odbc_result($tb_area,"part_nm");
						$qty=odbc_result($tb_area,"qty");
						$price=odbc_result($tb_area,"price");
						$kode_chg=odbc_result($tb_area,"kode_chg");
						$cccode=odbc_result($tb_area,"cccode");
						$nctr=odbc_result($tb_area,"no_ctrl");
						$lsctrl=$lsctrl.$nctr.",";
						?>
						<tr onclick="javascript:pilih(this);">
							<td>
								<input type="text" readonly name="no_ctrl[]" id="no_ctrl" value="<?php echo $nctr;?>" class="form-control">
							</td>

							<td>
								<input type="text"readonly name="p_nm[]" id="p_nm" value="<?php echo $part_nm;?>" class="form-control">
								<button onclick="open_child('plh_pn_revpr.php?nomor=<?php echo $row;?>&nm=<?php echo $part_nm;?>','Data Part Number','800','500'); return false;">...</button>
							</td>

							<td>
								<input type="text" name="p_no[]" id="p_no" value="<?php echo odbc_result($tb_area,"part_no");?>" placeholder="Detail" class="form-control">
							</td>

							<td>
								<input type="text" name="p_dtl[]" id="p_dtl" value="<?php echo odbc_result($tb_area,"part_dtl");?>" placeholder="Detail" class="form-control">
							</td>

							<td>
								<input type="text" name="p_desc[]" id="p_desc" value="<?php echo odbc_result($tb_area,"part_desc");?>" placeholder="Remark Part" class="form-control">
							</td>

							<!--start cek kode additional-->

							<?php if ($kode_chg==1) { ?>
								<td>
									<input type="number" min="0" step="0.0000000000000001" name="qty[]" id="qty" value="<?php echo $qty;?>" placeholder="Qty" class="form-control">
								</td>

								<td>
									<input type="number" min="0" step="0.001" name="price[]" id="price" value="<?php echo $price;?>" placeholder="Price" class="form-control" readonly>
								</td>

							<?php } else if ($kode_chg==2) {?>
								<td>
									<input type="number" min="0" step="0.0000000000000001" name="qty[]" id="qty" value="<?php echo $qty;?>" placeholder="Qty" class="form-control">
								</td>

								<td>
									<input type="number" min="0" step="0.00000000000001" name="price[]" id="price" value="<?php echo $price;?>" placeholder="Price" class="form-control" >
								</td>
							<?php } else if($kode_chg==4){?>

								<td>
									<input type="number" min="0" step="0.0000000000000001" max="<?php echo $qty;?>" name="qty[]" id="qty" value="<?php echo $qty;?>" placeholder="Qty" class="form-control" >
								</td>

								<td>
									<input type="number" min="0" step="0.00000000000001" name="price[]" id="price" value="<?php echo $price;?>" placeholder="Price" class="form-control" >
								</td>
							<?php } else {?>

								<td>
									<input type="number" min="0" step="0.0000000000000001" name="qty[]" id="qty" value="<?php echo $qty;?>" placeholder="Qty" class="form-control" >
								</td>

								<td>
									<input type="number" min="0" step="0.00000000000001" name="price[]" id="price" value="<?php echo $price;?>" placeholder="Price" class="form-control" >
								</td>
							<?php } ?>

							<!--end cek kode additional-->

							<td><input type="text" name="cccode[]" id="cccode" value="<?php echo $cccode;?>" placeholder="Cost Center" class="form-control">
								<button name="bt1[]" onclick="open_child('../template.php?plh=select/plh_cccode.php&k=4&o=cccode&c=carline_code&n=no_ctrl','Data Part Number','800','500'); return false;">...</button></td>

								<td>
									<input type="text" name="reason[]" id="reason" value="<?php echo odbc_result($tb_area,"remark");?>" placeholder="Reason" class="form-control">
								</td>
								<td><input type="hidden" name="kd_chg[]" id="kd_chg" value="<?php echo $kode_chg;?>">
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
