<div class="card">
	<div class="container-fluid">
		<?php
		include("koneksi.php");
		$sect=$_SESSION['area'];
		$lok=$_SESSION['lok'];
		$jns_dok=$_GET['j'];
		$pc_sect=explode("-", $sect);
		$dept=$pc_sect[0];
		$sql1="Select distinct approve,jns_dok,no_aprv,jabatan from bps_dokaprv
		where jns_dok= '$jns_dok' ";
		// echo $sql1;
		?>

		<form id="form1" name="form1" method="post">
			<div class="block-header"><h2>Cari Atasan Approval</h2>  </div>
			<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
				<thead>
					<tr>
						<th>No</th>
						<th>Jabatan</th>
						<th>Approved</th>
						<th>Jenis Dokumen</th>
						<th>No Approve</th>
					</tr>
				</thead>
				<tbody>
					<!-- data ini bisa di loop dari database-->
					<?php
					$tb_area=odbc_exec($koneksi_lp,$sql1);
					$row=0;
					// while ($baris=mysql_fetch_array($sql1))
					while($baris=odbc_fetch_array($tb_area))
					{
						$row++;
						?>
						<tr onclick="javascript:pilih(this);">
							<td><?php echo $row; ?></td>
							<td><?php echo $baris["jabatan"]; ?></td>
							<td><?php echo $baris["approve"]; ?></td>
							<td><?php echo $baris["jns_dok"]; ?></td>
							<td><?php echo $baris["no_aprv"]; ?></td>
						</tr>
					<?php } ?>      
				</tbody>
			</table>
		</form>
	</div>
</div>

<script>
	function pilih(row){
		var kd_pel=row.cells[0].innerHTML;
		var kd_pel1=row.cells[1].innerHTML;
		var kd_pel2=row.cells[2].innerHTML;
		var kd_pel3=row.cells[3].innerHTML;
		var kd_pel4=row.cells[4].innerHTML;

		window.opener.parent.document.getElementById("jabatan").value = kd_pel1;
		window.opener.parent.document.getElementById("sign").value = kd_pel4+"-"+kd_pel2;
		window.close();
	}
</script>