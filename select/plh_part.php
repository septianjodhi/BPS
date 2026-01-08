 <div class="card">
 	<div class="container-fluid">
 		<?php
 		$lp=$_GET['lp'];
 		$sql1="select * from bps_part where lp='$lp' and status_part=1 ";
 		?>
 		<form id="form1" name="form1" method="post">
 			<div class="block-header"><h2>Cari Part No</h2>  </div>
 			<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
 				<thead>
 					<tr>
 						<th>No</th>
 						<th>Pruchasing</th>
 						<th>Kategori</th>
 						<th>Nama Part</th>
 						<th>Part No</th>
 						<th>Detail Part</th>
 						<th>Uom</th>
 						<th>Currency</th>					
 					</tr>
 				</thead>
 				<tbody>
 					<?php
 					$tb_area=odbc_exec($koneksi_lp,$sql1);
 					$row=0;
 					while($baris1=odbc_fetch_array($tb_area)){ $row++;
 						?>
 						<tr onclick="javascript:pilih(this);">
 							<td><?php echo $row; ?></td>
 							<td><?php echo odbc_result($tb_area,"lp"); ?></td>
 							<td><?php echo odbc_result($tb_area,"part_kat"); ?></td>
 							<td><?php echo odbc_result($tb_area,"part_nm"); ?></td>
 							<td><?php echo odbc_result($tb_area,"part_no"); ?></td>
 							<td><?php echo odbc_result($tb_area,"part_dtl"); ?></td>
 							<td><?php echo odbc_result($tb_area,"uom"); ?></td>
 							<td><?php echo odbc_result($tb_area,"curr"); ?></td>
 						</tr>
 					<?php } ?>      
 				</tbody>
 			</table>
 		</form>
 	</div>
 </div>
 <script>
 	function pilih(row){
 	//var kd_pel=row.cells[0].innerHTML;
 	// var kd_pel1=row.cells[1].innerHTML;
 	// var kd_pel2=row.cells[2].innerHTML;
 	// var kd_pel3=row.cells[3].innerHTML;
 	var kd_pel4=row.cells[4].innerHTML;
 	// var kd_pel5=row.cells[5].innerHTML;
 	// var kd_pel6=row.cells[6].innerHTML;
 	// var kd_pel7=row.cells[7].innerHTML;
 	// var kd_pel8=row.cells[8].innerHTML;
 	// window.opener.parent.document.getElementById("part_nm").value =kd_pel3;
 	window.opener.parent.document.getElementById("old_part").value = kd_pel4;
 	// window.opener.parent.document.getElementById("part_dtl").value = kd_pel5;
 	// window.opener.parent.document.getElementById("uom").value = kd_pel6;
 	// window.opener.parent.document.getElementById("curr").value = kd_pel7;
 	window.close();
 }
</script>