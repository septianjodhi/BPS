 <div class="card">
 	<div class="container-fluid">
 		<?php
 		$sect=$_GET['s'];	
 		$term=$_GET['t'];
 		$periode=$_GET['p'];
 		$grpobjt=$_GET['og'];
 		$objt=explode(",",$grpobjt);
 		if($objt[1]=="" and $objt[2]=="" and $objt[3]=="" and $objt[4]==""){
 			$sql1="select * from(select *,(select isnull(sum(act_qty),0) as act_qty from mstr_budget where no_ctrl=a.no_ctrl and periode=a.periode) as act_qty from mstr_budadd a where term='$term' and periode='$periode' and sect='$sect') mstr_budadd where act_qty<qty ";
	// and qty>(select sum(act_qty) as act_qty from mstr_budget where no_ctrl=a.no_ctrl and periode=a.periode) order by no_ctrl";
 		}else{
 			$sql1="select * from (select no_ctrl,lp,id_proses,part_no,part_nm,part_dtl,part_desc,cccode,qty+ qty_add as qty,uom,price+price_add as price,curr,(select isnull(sum(act_qty),0) as act_qty from mstr_budget where no_ctrl=a.no_ctrl and periode=a.periode) as act_qty from mstr_budadd a where term='$term' and periode='$periode' and sect='$sect') mstr_budadd where act_qty<qty";
	//qty>act_qty ";//and qty+qty_add>(select isnull(sum(act_qty),0) as act_qty from mstr_budget where no_ctrl=a.no_ctrl and periode=a.periode) ";='0'
 		}
 		// echo $sql1;
// select no_ctrl,lp,id_proses,part_no,part_nm,part_dtl,part_desc,qty,uom,price,curr
// from mstr_budadd a where jns_budget='Normal' and term='79' and periode='202004' and 
// sect='PE-MTP' and (qty+qty_add)>(select act_qty from mstr_budget where no_ctrl=a.no_ctrl 
// 	and periode=a.periode)
 		// echo  $sql1;
 		?>

 		<form id="form1" name="form1" method="post">
 			<div class="block-header"><h2>Cari Budget</h2>  </div>
 			<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
 				<thead>
 					<tr>
 						<th>No</th>
 						<th>No Control</th>
 						<th>Local Purchase</th>
 						<th>Kode Proses</th>
 						<th>Part No</th>
 						<th>Nama Part</th>
 						<th>Detail Part</th>
 						<th>Keterangan</th>
 						<th>Quantity</th>
 						<th>Uom</th>
 						<th>Price</th>
 						<th>Currency</th>
						<th>CC Code</th>
 					</tr>
 				</thead>
 				<tbody>
 					<!--data ini bisa di loop dari database-->
 					<?php
 					// ECHO $sql1;
 					$tb_area=odbc_exec($koneksi_lp,$sql1);
 					$row=0;
 					while($baris1=odbc_fetch_array($tb_area)){ $row++;
 						?>
 						<tr onclick="javascript:pilih(this);">
 							<td><?php echo $row; ?></td>
 							<td><?php echo odbc_result($tb_area,"no_ctrl"); ?></td>
 							<td><?php echo odbc_result($tb_area,"lp"); ?></td>
 							<td><?php echo odbc_result($tb_area,"id_proses"); ?></td>
 							<td><?php echo odbc_result($tb_area,"part_no"); ?></td>
 							<td><?php echo odbc_result($tb_area,"part_nm"); ?></td>
 							<td><?php echo odbc_result($tb_area,"part_dtl"); ?></td>
 							<td><?php echo odbc_result($tb_area,"part_desc"); ?></td>
 							<td><?php echo odbc_result($tb_area,"qty"); ?></td>
 							<td><?php echo odbc_result($tb_area,"uom"); ?></td>	
 							<td><?php echo odbc_result($tb_area,"price"); ?></td>	
 							<td><?php echo odbc_result($tb_area,"curr"); ?></td>
							<td><?php echo odbc_result($tb_area,"cccode"); ?></td>							
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
 		var kd_pel8=row.cells[8].innerHTML;
 		var kd_pel10=row.cells[10].innerHTML;
 		var obj0="<?php echo $objt[0] ; ?>";
 		var obj1="<?php echo $objt[1] ; ?>";
 		var obj2="<?php echo $objt[2] ; ?>";
 		var obj3="<?php echo $objt[3] ; ?>";
 		var obj4="<?php echo $objt[4] ; ?>";
 		window.opener.parent.document.getElementById(obj0).value =kd_pel1;
		//window.opener.parent.document.getElementById("no_ctrl_add").value ='';
		if(obj1!=""){
			window.opener.parent.document.getElementById(obj1).value = kd_pel8;
		}
		if(obj2!=""){
			window.opener.parent.document.getElementById(obj2).value = kd_pel10;
		}
		if(obj3!=""){
			window.opener.parent.document.getElementById(obj3).value = kd_pel8;
		}
		if(obj4!=""){
			window.opener.parent.document.getElementById(obj4).value = kd_pel10;
		}
		window.close();
	}
</script>