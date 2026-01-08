<?php
$nctrl=$_GET['ctrl'];
$_SESSION['lok']=$_GET['sesi'];	
include "../koneksi.php";
$list_nctrl=str_replace(",","','",$nctrl);	  

?> 
<table class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
	<thead>
		<tr>	
			<th>No</th>
			<th>NO CONTROL</th>
			<th>PART NO</th>
			<th>PART NAME</th>
			<th>DETAIL PART</th>
			<th>DESC PART</th>
			<th>REPORT BEACUKAI</th>
			<th>QTY PLAN</th>
			<th>QTY ORDER</th>
			<th>PRICE</th>
		</tr>	
	</thead>
	<tbody>
		<?php
		$sqCC="select no_ctrl,part_no,part_nm,part_dtl,part_desc,(qty+qty_add)-act_qty as qty_max,
		(case when isnull(dbo.lp_minmaxquo(no_ctrl,dbo.cr_waktulp('po',no_ctrl),'rekom'),0)=0 then price else dbo.lp_minmaxquo
		(no_ctrl,dbo.cr_waktulp('po',no_ctrl),'rekom') end) as price from mstr_budget where no_ctrl in ('$list_nctrl')";
		$tbsqCC=odbc_exec($koneksi_lp,$sqCC);
		$row=0;
		while($DCC=odbc_fetch_array($tbsqCC)){
			$row++;
			$qty_max=odbc_result($tbsqCC,"qty_max");
			?>
			<tr>			
				<td><?php echo $row;?></td>		
				<td><?php echo odbc_result($tbsqCC,"no_ctrl");?></td>	
				<td><?php echo odbc_result($tbsqCC,"part_no");?></td>			
				<td><?php echo odbc_result($tbsqCC,"part_nm");?></td>
				<td><?php echo odbc_result($tbsqCC,"part_dtl");?></td>			
				<td><?php echo odbc_result($tbsqCC,"part_desc");?></td>
				<td>
					<select class="form-control">
						<option>Yes</option>
						<option>No</option>
					</select>
					<!-- <select class="selectpicker" style="width: 100%;" name="bc" id="bc" >
						<option selected="selected" value="">---Pilih Kolom---</option>
						<option>Yes</option>
						<option>No</option>
					</select> -->
				</td>
				<td><?php echo $qty_max;?></td>	
				<td><input type="number" min="0" step="0.00000000000000001" max="<?= $qty_max;?>" name="q_pln[]" id="q_pln" value="<?= $qty_max;?>" class="form-control">
				</td>		
				<td><?php echo odbc_result($tbsqCC,"price");?></td>			
			</tr>
			<?php
		}
		?>
	</tbody>
</table>