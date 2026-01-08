<?php
$nctrl=$_GET['ctrl'];
$_SESSION['lok']=$_GET['sesi'];	
$_SESSION['lokasi']=$_GET['sesi'];
include "../koneksi.php";
if(substr($nctrl,-1)==","){
	$nctrl= substr($nctrl,0,strlen($nctrl)-1);
}
$list_nctrl=str_replace(",","','",$nctrl);

// $lokasi=$_SESSION['lok'];

?> 
<table class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
	<thead>
		<tr>	
			<th>No</th>
			<th>NO CONTROL</th>
			<th>PART NAME</th>
			<th>DETAIL PART</th>
			<th>DESC PART</th>
			<th>QTY</th>
			<th>PRICE</th>
		</tr>	
	</thead>
	<tbody>
		<?php
//$sqCC="select no_ctrl,part_nm,part_dtl,part_desc,qty+isnull(dbo.lp_cr_QPadd('Qty',no_ctrl,'OPEN'),0)-isnull(dbo.lp_sumActBud(no_ctrl,'qty'),0) as qty,(case when (dbo.cr_proseslp('quo',id_proses)='YES' or (dbo.lp_minmaxquo(no_ctrl,dbo.cr_waktulp('po',no_ctrl),'rekom') is not NULL and dbo.lp_minmaxquo(no_ctrl,dbo.cr_waktulp('po',no_ctrl),'rekom')<price)) then dbo.lp_minmaxquo(no_ctrl,dbo.cr_waktulp('po',no_ctrl),'rekom') else price+isnull(dbo.lp_cr_QPadd('Price',no_ctrl,'OPEN'),0) end) as price from bps_budget where no_ctrl in('$list_nctrl')";
//echo $list_nctrl."<br>";
		$sqCC="select no_ctrl,part_nm,part_dtl,part_desc,qty+isnull(dbo.lp_cr_QPadd('Qty',no_ctrl,'OPEN'),0)-isnull(dbo.lp_sumActBud(no_ctrl,'qty'),0) as qty,
		(case when isnull(dbo.lp_minmaxquo(no_ctrl,dbo.cr_waktulp('po',no_ctrl),'rekom'),0)=0 then price else dbo.lp_minmaxquo(no_ctrl,dbo.cr_waktulp('po',no_ctrl),'rekom') end) as price
		from bps_budget where no_ctrl in('$list_nctrl')
		and no_ctrl not in (select no_ctrl from bps_budget_add where no_ctrl=bps_budget_add.no_ctrl and kode_chg in (4,5))
		union
		select no_ctrl,part_nm,part_dtl,part_desc,qty-isnull(dbo.lp_sumActBud(no_ctrl,'qty'),0) as qty,
		(case when isnull(dbo.lp_minmaxquo(no_ctrl,dbo.cr_waktulp('po',no_ctrl),'rekom'),0)=0 then price else dbo.lp_minmaxquo(no_ctrl,dbo.cr_waktulp('po',no_ctrl),'rekom') end) as price 
		from bps_budget_add where no_ctrl in('$list_nctrl') and kode_chg in (4,5)";
		// echo $sqCC."<br>";
		echo $home."(".$_SESSION['lok'].")";
		$tbsqCC=odbc_exec($koneksi_lp,$sqCC);
		$row=0;
		while($DCC=odbc_fetch_array($tbsqCC)){$row++;
			?>
			<tr>			
				<td><?php echo $row;?></td>		
				<td><?php echo odbc_result($tbsqCC,"no_ctrl");?></td>				
				<td><?php echo odbc_result($tbsqCC,"part_nm");?></td>		
				<td><?php echo odbc_result($tbsqCC,"part_dtl");?></td>			
				<td><?php echo odbc_result($tbsqCC,"part_desc");?></td>			
				<td><?php echo odbc_result($tbsqCC,"qty");?></td>		
				<td><?php echo odbc_result($tbsqCC,"price");?></td>			
			</tr>
		<?php } ?>  	
	</tbody>
</table>