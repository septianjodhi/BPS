 <ul class="nav nav-tabs tab-nav-right" role="tablist">
 	<li role="presentation" class="active"><a href="#menu" data-toggle="tab">Profile</a></li>
 	<li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
 </ul>
 <div class="tab-content">
 	<div role="tabpanel" class="tab-pane fade in active in active" id="menu">
 		<?php if($website=="BPS"){ ?>

 			<div class="row clearfix">
 				<div class="card">
 					<div class="body">
 						<div class="form-group">
 							<div class="col-md-6">Lokasi</div>
 							<div class="col-md-6"><?php echo $_SESSION['lok'] ; ?></div>
 						</div>	
 						<div class="form-group">
 							<div class="col-md-6">NIK</div>
 							<div class="col-md-6"><?php echo $_SESSION['nik'] ; ?></div>
 						</div>	
 						<div class="form-group">
 							<div class="col-md-6">Nama</div>
 							<div class="col-md-6"><?php echo $_SESSION['nama'] ; ?></div>
 						</div>	
 						<div class="form-group">
 							<div class="col-md-6">User Login</div>
 							<div class="col-md-6"><?php echo $_SESSION['user'] ; ?></div>
 						</div>	
 						<div class="form-group">
 							<div class="col-md-6">Kode Akses</div>
 							<div class="col-md-6"><?php echo $_SESSION['akses'] ; ?></div>
 						</div>	
 						<div class="form-group">
 							<div class="col-md-6">Area</div>
 							<div class="col-md-6"><?php echo $_SESSION['area'] ; ?></div>
 						</div>	
 						<div class="form-group">
 							<div class="col-md-6">Status</div>
 							<div class="col-md-6"><?php echo $_SESSION['status'] ; ?></div>
 						</div>
 						<div class="form-group">
 							<div class="col-md-6">koordinat</div>
 							<div class="col-md-6"><p id="demo"></p></div>
 						</div>
 					</div>
 				</div>
 			</div>
				<!--p><div class="row clearfix"><div class="card"><div class="body">
				</div></div></div>	</p-->
				
				<div class="legal">
					<div class="card">
						<div class="body">
							<div class="form-group">
								<a href="sisip/logout.php">
									<div class="col-md-1"><i class="material-icons">input</i></div>
									<div class="col-md-4">Sign Out</div>
								</a>
								<a href="##">
									<div class="col-md-1"><i class="material-icons">assignment_ind</i></div>
									<div class="col-md-5">Change Profile</div>
								</a>
							</div>
						</div>
					</div>
				</div>				
			<?php } ?>  


		</div>
		<div role="tabpanel" class="tab-pane fade" id="settings">
			<?php// echo $Sql_menu; ?>
		</div>
	</div>