	<div class="card">
		<div class="container-fluid">
			<?php
			$area=$_GET['a'];
			// $sect=$_SESSION['area'];
			$lok=$_SESSION['lok'];
			$pc_sect=explode("-", $area);
			$dept=$pc_sect[0];
			
			$periode=date("Ym");
			$sql1="select * from v_dtlkaryawan where periode='$periode' and jbtn!='OPT' and dept like '%$dept%' ";
			// echo $sql1;
			?>

			<form id="form1" name="form1" method="post">
				<div class="block-header"><h2>Cari Atasan Approval</h2>  </div>
				<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
					<thead>
						<tr>
							<th>No</th>
							<th>Nik</th>
							<th>Nama</th>
							<th>Area</th>
							<th>Email</th>
							<th>Jabatan</th>
						</tr>
					</thead>
					<tbody>
						<!-- data ini bisa di loop dari database-->
						<?php						
						$tb_area=odbc_exec($koneksi_hr,$sql1);
						$row=0;
						// while ($baris=mysql_fetch_array($sql1))
						while($baris=odbc_fetch_array($tb_area))
						{ 
							$row++;
							?>
							<tr onclick="javascript:pilih(this);">
								<td><?php echo $row; ?></td>
								<td><?php echo $baris["NIK"]; ?></td>
								<td><?php echo $baris["Nama"]; ?></td>
								<td><?php echo $baris["DEPT"]; ?></td>
								<td><?php echo $baris["SECT"]; ?></td>
								<td><?php	echo $baris["JBTN"] ; ?></td>
							</tr>
						<?php } ?>      
					</tbody>
				</table>
			</form>
		</div></div>

		<script>
			function pilih(row){
				var kd_pel=row.cells[0].innerHTML;
				var kd_pel1=row.cells[1].innerHTML;
				var kd_pel2=row.cells[2].innerHTML;
				var kd_pel3=row.cells[3].innerHTML;
				var kd_pel4=row.cells[4].innerHTML;
				window.opener.parent.document.getElementById("nik").value =kd_pel1;
				window.opener.parent.document.getElementById("nama").value = kd_pel2;
				// window.opener.parent.document.getElementById("area").value = kd_pel3;
				// window.opener.parent.document.getElementById("email").value = kd_pel4;
				window.close();
			}
		</script>