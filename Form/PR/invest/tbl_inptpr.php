<?php
$peri=$_POST['peri'];
$curr=$_POST["curr"];
$bud_group=$_POST['dt_phs'];
$cmd_cari=$_POST['cmd_cari'];
$sect="";
include "../../../koneksi.php";
$txt_cari=str_replace(" ","",$_POST['txt_cari']);
	if($txt_cari==""){
		$whr=""; 
	}else{
		$whr=" and replace($cmd_cari,' ','') like '%$txt_cari%'";
	}
	$pch_group=explode("|", $bud_group);
	// $whrfix="a.sect='$sect' and a.periode='$peri' and a.bud_group='$bud_group' and a.curr='$curr' ";
	$whrfix="a.sect='$sect' and a.periode='$peri' and a.no_ctrl='$pch_group[1]' and a.curr='$curr' ";
$cr_data="select distinct a.no_ctrl,a.qty as qty_plan, 
					dbo.lp_konprc(a.term,'$curr','USD',a.price) as price_g, 
					a.qty*dbo.lp_konprc(a.term,'$curr','USD',a.price) as amn_pln,
					isnull(SUM(b.Qty*b.price),0) AS act_amn,isnull(qty_equipment,0) as qty_equipment, 
					isnull( dbo.lp_cr_QPadd_inv ('Qty',a.no_ctrl,'OPEN'),0) as Qty_add, 
					isnull( dbo.lp_konprc(a.term,'$curr','USD',dbo.lp_cr_QPadd_inv ('price',a.no_ctrl,'OPEN')),0) as Price_add from bps_v_dtlinvest a 
					left join bps_PR b on a.no_ctrl=b.equipment_no where a.periode='$peri'  and a.curr='$curr' and	a.no_ctrl='$pch_group[1]'
					group by a.sect,a.no_ctrl,a.qty,a.price,qty_equipment,a.periode,a.term
					union
					select distinct a.no_ctrl,0 as qty_plan,0 as price_g, a.qty*dbo.lp_konprc(a.term,'$curr','USD',a.price) as amn_pln,
					isnull(SUM(b.Qty*b.price),0) AS act_amn,isnull(b.qty_equipment,0) as qty_equipment, 
					a.qty as Qty_add, isnull( dbo.lp_konprc(a.term,'$curr','USD',a.price),0)  as Price_add from bps_budget_invest_add a 
					left join bps_PR b on a.no_ctrl=b.equipment_no where a.periode='$peri' and	a.no_ctrl='$pch_group[1]' and kode_chg in (4,5)
					group by a.sect,a.no_ctrl,a.qty,a.price,qty_equipment,a.periode,a.term ";
//echo $cr_data;
$tb_data=odbc_exec($koneksi_lp, $cr_data);
	$qty_equipment=0;$amn=0;$amn_tot=0;
	while($baris=odbc_fetch_array($tb_data)){
		$price_add=$baris["Price_add"];
		$qty_add=$baris["Qty_add"];
		$price_g=$baris["price_g"];
		$qty_plan=$baris["qty_plan"];
		$qty_equipment=$qty_equipment+$baris["qty_equipment"];
		$qty_sisa=$qty_plan-$qty_equipment;
		$qty_tot=$qty_plan+$qty_add;
		$price_tot=$price_g+$price_add;
		$amn_tot=$price_tot*$qty_tot;
		$amn=$amn+$baris["act_amn"];
		// $plan_amn=$amn_tot["amn_pln"];
		// $plan_amn=$amn_tot["amn_pln"];
		// $amn=$amn+$amn_tot;
		// $tot_amn=$plan_amn-$amn;
	}
		if($curr=="IDR"){
			$sisa_amn=round($amn_tot-$amn,0);
		}
		else{
			$sisa_amn=$amn_tot-$amn;
		}

?>
<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
			<h2>Buat Purchase Requisition (PR) Section <?php echo $sect; ?></h2>
			</div>
			<form action="" id="frmcari" name="frmcari" method="post" enctype="multipart/form-data">
				<div class="body">
				
				<table id="nilai" class="table table-striped table-bordered " cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class='with-checkbox'>
							<input type="checkbox" name="check_all" id="check_all" onclick="dipilihALL(this.form)" />Pilih</th>
							<th>CIP No.</th>
							<th>Part No</th>
							<th>Desc</th>
							<!-- <th>Qty set</th> -->
							<th>Uom</th>
							<th>Curr</th>
							<th>Price Plan</th>
							<th>Price Quotation</th>
							<th>Purchasing</th>
							<th>Qty Order</th>
							<th>Reason</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$sq_acc="select no_ctrl,no_ctrl_bud,part_no,part_nm,part_dtl,qty,qty as qty_p,uom,curr,lp,price,carline,expired,price as plan_bud,term
,isnull((select top 1 price from bps_Quotation where lp_rekom='YES' and Exp_Quo>=getdate() and part_no=b.part_no),0) as price_quo
from bps_v_dtlinvest b where periode='$peri' and no_ctrl='$pch_group[1]' and curr='$curr' 
						union 
						select a.no_ctrl, a.no_ctrl_bud,a.part_no,a.part_nm,a.part_dtl,
						b.qty,a.qty as qty_p,a.uom,a.curr,a.lp,a.price,
						b.carline, b.expired,b.price as plan_bud,a.term,
						isnull((select top 1 price from bps_Quotation where lp_rekom='YES' 
						and Exp_Quo>=getdate() and part_no=a.part_no),0) as price_quo
						from bps_budinvest_dtl a inner join bps_budget_invest_add b 
						on a.no_ctrl=b.no_ctrl and a.periode=b.periode
						where $whrfix and kode_chg in (4,5) ";
//							 echo $sq_acc;
						$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
							$row=0;$amount=0;//$reason="";
							$baris=0;$displh='disabled';
						while($baris1=odbc_fetch_array($tb_acc)){
							$row++;
							$baris ++;
							$price_quo=$baris1['price_quo'];
							$price=round($baris1['price'],0);
							$qty_s=$baris1['qty'];
							$qty_p=$baris1['qty_p'];
							$no_ctrl=$baris1['no_ctrl'];
							$no_ctrl_p=$baris1['no_ctrl_bud'];
							$part_no=$baris1['part_no'] ;
							$part_nm=$baris1['part_nm'];
							$curr_ori=$baris1['curr'] ;
							$carline=$baris1['carline'] ;
							$expired=$baris1['expired'] ;
							$term=$baris1['term'] ;

							// if($price_quo<=0 or $price_quo>$amn)
								if($price_quo<=0 ){
								$row++;
								$reason="Budget sudah kosong";
								$plh="off";
								} else if( $sisa_amn<=1 ){
								$row++;
								$reason="Qty Kurang";
								$plh="off";
								}
								else if($sisa_amn<$price_quo){
									$row++;
								$reason="Budget kurang" ;
									$plh="off";
								}
								else{
								$reason="";
								$plh="on";
								}
					// echo $price_quo."<br>".$sisa_amn;
					?>
					<tr>
						<td >
							<?php if($plh=="on"){ 
										$dsbl="";
									}else { 
										$dsbl="disabled";
									 } ?>
								<div class="switch" >
								<label>
								<input type="checkbox" name="kola_<?= $baris;?>" id="kola_<?= $baris;?>" value="<?= $no_ctrl_p."|".$part_no."|".$curr_ori."|".$no_ctrl."|".$expired."|".$carline."|".$qty_s."|".$price."|".$term ; ?>" <?=$dsbl;?>>
								<span class="lever"></span>
								</label>
								</div>
								 <?php /*}else{ 
								echo '<i class="material-icons">clear</i>';
								} */
								?> 
								</td>
								<td align="center"  id="kolb_<?= $baris;?>">CIP <?= round($pch_group[0],0) ; ?> </td>
								<td  id="kolc_<?= $baris;?>"><?= $part_no ; ?></td>
								<td  id="kold_<?= $baris;?>"><?= $part_nm." ".$baris1['part_dtl'] ; ?></td>
								<!-- <td><input type="number" step="any" min=1 name="qty_s[]" id="qty_s<?= $i; ?>" max="<?= $qty_s ; ?>" value="<?= $qty_s ; ?>" onchange="total()" class="form-control text-center" /> </td> -->
								<td  id="kole_<?= $baris;?>"><?= $baris1['uom'] ; ?> </td>
								<td  id="kolf_<?= $baris;?>"><?= $curr_ori ; ?> </td>
								<td  id="kolg_<?= $baris;?>"><?= number_format($baris1['price'],2)  ; ?> </td>
								<td><input type="text"  name="kolh_<?= $baris;?>"  id="kolh_<?= $baris;?>" value="<?= number_format($baris1['price_quo'],2)  ; ?>" onchange="total()" class="form-control text-center" readonly />
								</td>
								<td  id="koli_<?= $baris;?>"><?= $baris1['lp'] ; ?> </td>
								<td>
									
								<input type="number" step="any" min=1 max="<?= $qty_p ; ?>" name="kolj_<?= $baris;?>" id="kolj_<?= $baris;?>" value="<?= $qty_p ; ?>"  class="form-control text-center" placeholder="<?=$dsbl;?>" <?=$dsbl;?> />
								</td>
								<td id="kolk_<?= $baris;?>"><?= $reason ; ?></td>
								</tr>
								<?php
								}
													//}
								?>
							<tr class="odd gradeX">
								<td colspan="11" align="center" valign="middle" nowrap="nowrap"><input type="checkbox"  name="plh[]" id="plh" value="-|0|0|0|0|0|0" ></td>	
							</tr>
						</tbody>
					</table>
				</div>
			</form>	
				<div class="footer">
					<div class="body">
						Jumlah Data <span id="jumbar"><?=$baris;?></span> <br>
			<?php if($row>0){ ?>
					<button type="button" class="btn " onclick="cari_header(); return false;"><i class="material-icons">search</i></button>
					<?php }	?>
					</div>
				</div>
											
		</div>
	</div>
</div>
<?php //include "../../../assets/function_obj.php"; ?>
<script>
	//tabel2('nilai'); 
	//date_min('pr_date'); 
</script>