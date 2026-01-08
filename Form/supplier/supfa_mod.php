<div class="modal fade" id="mdimportxls" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="defaultModalLabel">Upload Supplier FA</h4>
			</div>
			<div class="modal-body">
			<form action="" id="frm_importsupp" method="post"  enctype="multipart/form-data">	
				<div class="body">
					<input type="hidden" name="nm_pic" id="nm_pic" value="<?= $_SESSION['nama'];?>" required>
					<input type="hidden" name="lks_bps" id="lks_bps" value="<?= $_SESSION['lokasi'];?>" required>
					<div class="row clearfix">
							<div class="form-group">
								<label>Cari File</label>
								<input type="file" name="file_supp" id="file_supp" required>
							</div>
				</div>
				</div>
				<div class="modal-footer">
							<button type="submit"  id="import_supp" name="import_supp" class="btn bg-green waves-effect"><i class="material-icons">cloud_upload</i>Upload file</button>
							<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
					
					
				</div>
				<!-- onclick="save_pr();" -->
			</form>
			</div>
		</div>
	</div>
</div>