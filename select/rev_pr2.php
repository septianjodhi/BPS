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
				include "../koneksi.php";
				$prno=$_GET["nopr"];
				$pic=$_GET["pic"];
				$sect=$_GET["sec"];
				$sql1="select a.*,remark from bps_tmppr a inner join bps_pr b on a.pr_no=b.pr_no
				and a.no_ctrl=b.no_ctrl
				where a.pr_no='$prno' and exists(select no_doc from bps_approve where no_doc=a.PR_NO
				and jns_doc='PR' and status is null) order by part_no asc";
				$tb_area=odbc_exec($koneksi_lp,$sql1);
				$rmk=odbc_result($tb_area,"remark");

				if(isset($_POST['smpn']))
				{
					$count=count($_POST['p_no']);
					$no_ctrl=$_POST['no_ctrl'];
					$p_nm=$_POST['p_nm'];
					$p_no=$_POST['p_no'];
					$p_dtl=$_POST['p_dtl'];
					$p_desc=$_POST['p_desc'];
					$q_pln=$_POST['q_pln'];					
					$req_date=$_POST['req_date'];
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
						$reqdate=$req_date[$i];
						$cc_code=$area[$i];
						$qpln=number_format($q_pln[$i],11,".","");
						$idtmp=$pic."-".date("Ymd-His");

						// $lht_dt=count(odbc_exec($koneksi_lp, "select * from mstr_budget where no_ctrl='$noctrl' ")) ;

						$sq_acc="SELECT periode,phase,lp,no_ctrl,part_no,part_nm,part_dtl,part_desc,uom,qty as qty_plan,'$qpln' as qty,(select qty from bps_pr where pr_no='$prno' and no_ctrl='$noctrl') as qty_pr,curr,price,dbo.lp_cr_QPadd('Price',no_ctrl,'OPEN') as Price_add,dbo.cr_waktulp('pr',no_ctrl) as exp_pr, dbo.lp_sumactbud(no_ctrl,'amount') as act_bud,dbo.lp_minmaxquo(no_ctrl,dbo.cr_waktulp('po',no_ctrl),'rekom') as price_quo,isnull(dbo.lp_sumActBud(no_ctrl,'qty'),0) as cum_qty from mstr_budget where no_ctrl='$noctrl' order by periode,part_nm asc";
						$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
						while($bar_acc=odbc_fetch_array($tb_acc))
						{
							$act_bud=odbc_result($tb_acc,"act_bud");
							$Qplan=odbc_result($tb_acc,"qty");
							$Qbud=odbc_result($tb_acc,"qty_plan");
							$no_ctrl=odbc_result($tb_acc,"no_ctrl");
							$cum_qty=odbc_result($tb_acc,"cum_qty");
							$qty_pr=odbc_result($tb_acc,"qty_pr");
							$price_quo=number_format(odbc_result($tb_acc,"price_quo"),2,".","");
							$prcplan=number_format(odbc_result($tb_acc,"price"),2,".","");
							$prcadd=number_format(odbc_result($tb_acc,"price_add"),2,".","");

							if($prcadd==0 and $price_quo>=$prcplan){$tot_prc=$prcplan;}
							else if($prcadd==0 and $price_quo<$prcplan){$tot_prc=$price_quo;}
							else {$tot_prc=number_format($prcplan+$prcadd,2,".","");}
							$amountnya=$Qplan*$tot_prc;
							$amount_pln=($prcplan+$prcadd)*$Qbud;
							$amount=$qpln*$tot_prc;
							$qty_sisa=$qty_pr+$qpln;
							$amount_act=$qty_sisa*$tot_prc;
							$sis_bud=$amount_pln-$amount_act;

							$carcode=odbc_exec($koneksi_lp,"select top 1 carline_code from LP_CV 
								where cv_code='$cc_code' ");
							$car=odbc_result($carcode,"carline_code");
							// echo $sq_acc;
							if($Qplan!=0)
							{
								// echo $Qplan;
								$q_update2="update bps_tmppr set part_no='$pno',part_dtl='$pdtl',
								part_desc='$pdesc', cccode='$cc_code',carline_code='$car',
								qty_act='$qpln',pemakaian='$amount',sisa_bud='$sis_bud',req_date='$reqdate' where no_ctrl='$noctrl' 
								and pr_no='$prno' ";
								$tb_part=odbc_exec($koneksi_lp,$q_update2);
							}
							else
							{
								$tb_deltmp=odbc_exec($koneksi_lp,"delete from bps_tmppr where no_ctrl='$no_ctrl' and pr_no='$prno'");
							}
						}
					}

					$del_pr="delete from bps_pr where pr_no='$pr_no'";
					$tb_delpr=odbc_exec($koneksi_lp,$del_pr);

					// $qry_adpr="insert into bps_pr(pr_no, remark, no_ctrl, pr_date, qty, price,
					// curr,term,periode,sect,cccode,pic_updt,tgl_updt,req_date) 
					// select pr_no ,'$rmk_pr' as remark,no_ctrl,pr_date,qty_act as qty, price_tot
					// as price,curr,term,periode,'$sect' as sect,cccode,pic_updt,getdate() as
					// tgl_updt,req_date from bps_tmpPR where pr_no='$pr_no'";
					// $tb_adpr=odbc_exec($koneksi_lp,$qry_adpr);
					// echo $qry_adpr;

					$amoun_USD=0;
					$amoun_IDR=0;
					$sql_amount="select pr_no,COUNT(no_ctrl) as jm_item,sum(qty) as tot_qty,sum(dbo.lp_konprc(term,'IDR',curr,qty*price)) as idr,sum(dbo.lp_konprc(term,'USD',curr,qty*price)) as dolar from bps_pr where pr_no='$prno' group by pr_no";
					$tb_amount=odbc_exec($koneksi_lp,$sql_amount);
					while($bar_moun=odbc_fetch_array($tb_amount)){
						$amoun_IDR=odbc_result($tb_amount,"idr");
						$amoun_USD=odbc_result($tb_amount,"dolar");
						$jm_item=odbc_result($tb_amount,"jm_item");
						$tot_qty=odbc_result($tb_amount,"tot_qty");
					}
					$pchsec=explode("-",$sect);
					$dept=$pchsec[0];
					$qry_delaprv="delete from bps_approve where jns_doc in('PR') and no_doc='$prno'";
					$tb_delaprv=odbc_exec($koneksi_lp,$qry_delaprv);
					$qry_adaprv="insert into bps_approve(pic_plan,email_plan,no_doc,tgl_prepaire,jns_doc,sect,initial,approve,no_aprv) SELECT nama as pic_plan,email as email_plan,'$prno' as no_doc,getdate() as tgl_prepaire,jns_dok as jns_doc,sect,initial,approve,no_aprv  FROM bps_setApprove where  status_akun='aktif' and jns_dok in('PR') and (sect='$sect' or sect='$dept-ALL' or (sect='SAMI-ALL' AND (max_amount='0' or (min_amount<'$amoun_IDR' and max_amount>='$amoun_IDR'))))";

					$tb_adaprv=odbc_exec($koneksi_lp,$qry_adaprv);
				
				?>

				<script>
					var jm_item="<?php echo $jm_item; ?>";
					var tot_qty="<?php echo $tot_qty; ?>";
					var amoun_IDR="<?php echo number_format($amoun_IDR,2,'.',','); ?>";
					var amoun_USD="<?php echo number_format($amoun_USD,2,'.',','); ?>";
					window.opener.parent.document.getElementById("jmitem").value =jm_item;
					window.opener.parent.document.getElementById("tot_qty").value =tot_qty;
					window.opener.parent.document.getElementById("idr").value =amoun_IDR;
					window.opener.parent.document.getElementById("dolar").value =amoun_USD;
						// window.close();
					</script>;

					<?php 
				}
				?>

				<div class="block-header"><h2>REVISI PR (<?php echo $prno ; ?>)</h2></div>
				<form id="form1" name="form1" method="post">
					<div class="row clearfix">	
						<div class="form-group">
							<label>Remark PR</label>
							<div class="form-line">
								<input type="text" name="rmk_pr" id="rmk_pr"
								value="<?php echo $rmk;?>" class="form-control" required>
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
											<input type="text"readonly name="no_ctrl[]" id="no_ctrl" value="<?php echo $nctr;?>" class="form-control">
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
										<td>
											<input type="number" min="0" step="0.00000000000000001" max="<?php echo $qtyplan;?>" name="q_pln[]" id="q_pln" value="<?php echo $qtyplan;?>" placeholder="Remark Part" class="form-control">
										</td>
										<td>
											<input type="text" name="cccode[]" id="cccode" value="<?php echo $cccode;?>" placeholder="Cost Center" class="form-control">
											<button name="bt1[]" onclick="open_child('../template.php?plh=select/plh_cccode.php&k=4&o=cccode&c=carline_code&n=no_ctrl','Data Part Number','800','500'); return false;">...</button>
										</td>
										<td>
											<input type="text"readonly name="req_date[]" id="req_date" value="<?php echo odbc_result($tb_area,"req_date");?>" class="form-control">
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