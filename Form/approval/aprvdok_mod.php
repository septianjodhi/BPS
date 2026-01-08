<!---- MODAL -->
<div class="modal fade" id="mod_rejectpr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
				<h4 class="modal-title" id="myModalLabel">Reject</h4>
				
			</div>
			<form role="form"  name="frm_reject" id="frm_reject" method="post" action="">
			<div class="box-body">
				<div class="form-group col-md-2">
                  <label>NO Dok</label>
                   <input type="text" readonly class="form-control"  name="no_dok" id="no_dok" required>
               </div>
			  
			  <div class="form-group col-md-2">
                  <label>Catatan</label>
                   <input type="text" class="form-control"  name="rej_note" id="rej_note"  required>
               </div>
			  
			</div>
			<div class="box-footer">
				<button type="button" id="sv_rej" onclick="saverej()" name="sv_rej" class="btn btn-info btn-flat" >
                    <i class="fa  fa-save"></i>Reject
                  </button>
			</div>
			</form>
		</div>
	</div>
</div>

<!-- <div class="modal fade" id="mod_rekap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
				<h4 class="modal-title" >Rekap Cuti <div id="rkpnik"></div></h4>
				<ul>
					<li>Nama : <span id="rkpnm"></span></li>
					<li>No urut :<span id="rkpno"></span></li>
					<li>Diambil :<span id="rkpambil"></span></li>
					<li>Sisa :<span id="rkpsisa"></span></li>
				</ul>
				
			</div>
			<div class="box-body">
				<div id="tblrekap"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="mod_ubah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
				<h4 class="modal-title" >Ubah Cuti <div id="rkpnik"></div></h4>
				
			</div>
			<div class="box-body">
				<div id="tblrekap"></div>
			</div>
		</div>
	</div>
</div> -->