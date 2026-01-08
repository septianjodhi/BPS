<div class="modal fade" id="mdplhvp" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="defaultModalLabel">List VP Open</h4>
			</div>
			<div class="modal-body">
			<form action="" id="frm_sendap" method="post"  enctype="multipart/form-data">	
				<div class="body">
					<input type="hidden" name="nm_pic" id="nm_pic" value="<?= $_SESSION['nama'];?>" required>
					<input type="hidden" name="lks_bps" id="lks_bps" value="<?= $_SESSION['lokasi'];?>" required>
					<div class="row clearfix">
						<div class="col-sm-3">
							<div class="form-group">
								<label>Periode Receive</label>
								<select class="form-control"  style="width: 100%;"  name="pervp_o" id="pervp_o"   onchange="listvp_open()" required>
								</select>
								<!-- data-live-search="true" -->
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>VP No</label>
								<select class="form-control"  style="width: 100%;"  name="vp_o" id="vp_o" required>
								</select>
							</div>
						</div>

				</div>
				</div>
				<div class="modal-footer">
							<button type="submit"  id="sendap" name="sendap" class="btn bg-green waves-effect"><i class="material-icons">send</i>Buat AP</button>
							<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
					
					
				</div>
				<!-- onclick="save_pr();" -->
			</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="mdupldvp" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="defaultModalLabel">List VP Open</h4>
			</div>
			<div class="modal-body">
			<form action="" id="frm_upldvp" method="post"  enctype="multipart/form-data">	
				<div class="body">
					<input type="hidden" name="nm_pic" id="nm_pic" value="<?= $_SESSION['nama'];?>" required>
					<input type="hidden" name="lks_bps" id="lks_bps" value="<?= $_SESSION['lokasi'];?>" required>
					<div class="row clearfix">
							<div class="form-group">
								<label>Cari file</label>
								<input type="file" name="file_ap" id="file_ap" required>
							</div>

				</div>
				</div>
				<div class="modal-footer">
							<button type="submit"  id="sendupldap" name="sendupldap" class="btn bg-green waves-effect"><i class="material-icons">send</i>Buat AP</button>
							<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
					
					
				</div>
				<!-- onclick="save_pr();" -->
			</form>
			</div>
		</div>
	</div>
</div>