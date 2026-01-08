<div class="card">
	<div class="container-fluid">
		<?php
		include("koneksi.php");
		$sect=$_SESSION['area'];
		$lok=$_SESSION['lok'];
		$pc_sect=explode("-", $sect);
		$dept=$pc_sect[0];
		if ($sect=='FA-FIN' or $sect=='PGA-IT') {
			$query="select * from tbl_user where app_nm='BPS' and lokasi='$lok'";
		}else{
			$query="select * from tbl_user where app_nm='BPS' and lokasi='$lok' and area like '%$dept-%' ";
		}

		$sql1=mysql_query($query);
		
		echo $query;
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
					$periode=date("Ym");
					// $tb_area=odbc_exec($koneksi_lp,$sql1);
					$row=0;
					while ($baris=mysql_fetch_array($sql1))
					// while($baris1=odbc_fetch_array($tb_area))
					{ 
						$nik=$baris["nik"];
						$row++;
						?>
						<tr onclick="javascript:pilih(this);">
							<td><?php echo $row; ?></td>
							<td><?php echo $baris["nik"]; ?></td>
							<td><?php echo $baris["nama"]; ?></td>
							<td><?php echo $baris["area"]; ?></td>
							<td><?php echo $baris["email"]; ?></td>
							<td><?php if($lok=="TF"){
							$cr_jbtn=odbc_exec($koneksi_hr, "select jbtn from v_dtlkaryawan where periode='$periode' and nik='$nik' ");
							echo odbc_result($cr_jbtn, "jbtn") ; }?></td>
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
			window.opener.parent.document.getElementById("area").value = kd_pel3;
			window.opener.parent.document.getElementById("email").value = kd_pel4;
			window.close();
		}
	</script>