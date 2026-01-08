 <div class="card">
 	<div class="container-fluid">
 		<?php
 		$price=$_GET['price'] ;
 		$curr=$_GET['curr'];
 		$term=$_GET['term'];

 		$tb_sql=odbc_exec($koneksi_lp,"select KURS from bps_kurs where KURS_CODE='$curr' and 
 		TERM='$term' order by KURS_CODE desc ");
 		$kurs_pembagi=odbc_result($tb_sql, "KURS");

 		$sql1="select * from bps_kurs where TERM='$term' 
 		order by KURS_CODE desc ";
 		?>
 		<form id="form1" name="form1" method="post">
 			<div class="block-header"><h2>Cari Currency</h2> </div>
 			<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
 				<thead>
 					<tr>
 						<th>No</th>
 						<th>TERM</th>
 						<th>KURS_CODE</th>
 						<th>KURS</th>
 						<th>PRICE</th>
 						<th>NILAI KONVERSI</th>						
 					</tr>
 				</thead>
 				<tbody>
 					<?php
 					$tb_area=odbc_exec($koneksi_lp,$sql1);
 					$row=0;
 					while($baris1=odbc_fetch_array($tb_area))
 					{ 
 						$row++;
 						$kurs=$baris1["KURS"];
 						$kurs_kode=$baris1["KURS_CODE"];
 						$n_awal=$price/$kurs_pembagi;
 						?>
 						<tr onclick="javascript:pilih(this);">
 							<td><?= $row; ?></td>
 							<td><?= $baris1["TERM"]; ?></td>
 							<td><?= $baris1["KURS_CODE"]; ?></td>
 							<td><?= $kurs; ?></td>
 							<td><?= $price; ?></td>
 							<td><?= $n_awal*$kurs ;?></td>
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
 	//var kd_pel=row.cells[0].innerHTML;
 	var kd_pel1=row.cells[1].innerHTML;
 	var kd_pel2=row.cells[2].innerHTML;
 	var kd_pel3=row.cells[3].innerHTML;
 	var kd_pel4=row.cells[4].innerHTML;
 	var kd_pel5=row.cells[5].innerHTML;
 	window.opener.parent.document.getElementById("curr").value =kd_pel2;
 	window.opener.parent.document.getElementById("price").value =kd_pel5;
 	window.close();
 }
</script>