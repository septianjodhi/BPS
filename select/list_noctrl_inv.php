<?php
$_SESSION['lok']=$_GET['sesi'];	
$nctrl=$_GET['ctrl'];
$list_nctrl=str_replace(",","','",$nctrl);	  
include "../koneksi.php";
?> 
<table class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
	<thead>
		<tr>	
			<th>No</th>
			<th>NO CONTROL</th>
			<th>PART NAME</th>
			<th>DETAIL PART</th>
			<th>QTY</th>
			<th>PRICE</th>
		</tr>	
	</thead>
	<tbody>
		<?php
		$sqCC="select no_ctrl_bud,part_no,part_nm,part_dtl,qty,
		(select top 1 price from bps_quotation where lp_rekom='YES' and Exp_Quo>=a.expired and part_no=a.part_no) as price
		from bps_v_dtlinvest a where no_ctrl_bud in('$list_nctrl')";
		$tbsqCC=odbc_exec($koneksi_lp,$sqCC);
		$row=0;
		while($DCC=odbc_fetch_array($tbsqCC)){$row++;
			?>
			<tr>			
				<td><?php echo $row;?></td>		
				<td><?php echo $DCC['no_ctrl_bud']; ?></td>				
				<td><?php echo $DCC['part_no']; ?></td>		
				<td><?php echo $DCC['part_nm']." ".$DCC['part_dtl'] ;?></td>				
				<td><?php echo $DCC['qty'];?></td>		
				<td><?php echo number_format($DCC['price'],2);?></td>			
			</tr>
		<?php } ?>  	
	</tbody>
</table>