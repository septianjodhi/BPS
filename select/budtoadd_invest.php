 <div class="card">
 	<div class="container-fluid">
 		<?php
 		$sect=$_GET['s'];	
 		$term=$_GET['t'];
 		$periode=$_GET['p'];
 		$grpobjt=$_GET['og'];
 		$objt=explode(",",$grpobjt);
 		// if($objt[1]=="" and $objt[2]=="" and $objt[3]=="" and $objt[4]==""){
 		$sql1="select periode,cip_no,no_ctrl,qty,price from bps_budget_invest 
 		where term='$term' and sect='$sect' and periode='$periode'
 		union
 		select periode,cip_no,no_ctrl,qty,price from bps_budget_invest_add 
 		where term='$term' and sect='$sect' and periode='$periode'
 		";
 		// }
 		// else{
 		// 	$sql1="select * from (select no_ctrl,lp,id_proses,part_no,part_nm,part_dtl,part_desc,qty+ qty_add as qty,uom,price+price_add as price,curr,(select isnull(sum(act_qty),0) as act_qty from mstr_budget where no_ctrl=a.no_ctrl and periode=a.periode) as act_qty from mstr_budadd a where term='$term' and periode='$periode' and sect='$sect') mstr_budadd where act_qty='0'";
 		// }

 		?>

 		<form id="form1" name="form1" method="post">
 			<div class="block-header"><h2>Cari Budget</h2>  </div>
 			<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
 				<thead>
 					<tr>
 						<th>No</th>
 						<th>Periode</th>
 						<th>CIP No</th>
 						<th>No Ctrl</th>
 						<th>Qty</th>
 						<th>Price</th>
 					</tr>
 				</thead>
 				<tbody>
 					<!--data ini bisa di loop dari database-->
 					<?php
 					// echo $sql1;
 					$tb_area=odbc_exec($koneksi_lp,$sql1);
 					$row=0;
 					while($baris1=odbc_fetch_array($tb_area)){ $row++;
 						?>
 						<tr onclick="javascript:pilih(this);">
 							<td><?php echo $row; ?></td>
 							<td><?php echo odbc_result($tb_area,"periode"); ?></td>
 							<td><?php echo odbc_result($tb_area,"cip_no"); ?></td>
 							<td><?php echo odbc_result($tb_area,"no_ctrl"); ?></td>
 							<td><?php echo odbc_result($tb_area,"qty"); ?></td>
 							<td><?php echo odbc_result($tb_area,"price"); ?></td>
 						</tr>
 						<?php 
 					} 
 					?>      
 				</tbody>
 			</table>
 		</form>
 	</div>
 </div>

 <script>
 	function pilih(row){
 		var kd_pel1=row.cells[1].innerHTML;
 		var kd_pel2=row.cells[2].innerHTML;
 		var kd_pel3=row.cells[3].innerHTML;
 		var kd_pel4=row.cells[4].innerHTML;
 		var kd_pel5=row.cells[5].innerHTML;
 		var obj0="<?php echo $objt[0] ; ?>";
 		var obj1="<?php echo $objt[1] ; ?>";
 		var obj2="<?php echo $objt[2] ; ?>";
 		var obj3="<?php echo $objt[3] ; ?>";
 		var obj4="<?php echo $objt[4] ; ?>";

 		window.opener.parent.document.getElementById(obj0).value =kd_pel3;

		if(obj1!=""){
			window.opener.parent.document.getElementById(obj1).value = kd_pel4;
		}
		if(obj2!=""){
			window.opener.parent.document.getElementById(obj2).value = kd_pel5;
		}
		if(obj3!=""){
			window.opener.parent.document.getElementById(obj3).value = kd_pel4;
		}
		if(obj4!=""){
			window.opener.parent.document.getElementById(obj4).value = kd_pel5;
		}
		window.close();
	}
</script>