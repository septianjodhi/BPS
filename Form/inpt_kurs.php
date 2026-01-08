<script type="text/javascript">
	function open_child(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};	
</script>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>MASTER KURS</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Manual Input Kurs</small></h2>
					</div>
					<div class="body">
						<form role="form"  name="form1" id="form1" method="post" action="">
							<div class="row clearfix">
								<div class="col-md-4">
									<div class="form-group">
										<label>Kurs Code</label>
										<div class="form-line">
											<input type="text" class="form-control" id="kurs_code" name="kurs_code" placeholder="Kurs Code" required>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Kurs</label>
										<div class="form-line">
											<input type="number" step="0.001" min="0.000"  class="form-control" id="kurs" name="kurs" placeholder="Kurs" required>
										</div>
									</div>
								</div>
								<div class="col-md-4">	
									<div class="form-group">
										<label>Term</label>
										<div class="group-line">
											<select class="selectpicker"style="width: 100%;"  name="term" id="term" required>
												<option selected="selected" value="">-Pilih Term-</option>
												<?php
												$cr_set="select distinct term from bps_setterm order by term desc";
												$qry_cr=odbc_exec($koneksi_lp,$cr_set);
												$row=0;
												while ($baris=odbc_fetch_array($qry_cr)){
												// while ($baris=mysql_fetch_array($sql1)) 
												//
													$row++;
													$term=$baris["term"];
													echo "<option value='$term'>Term $term</option>";
												}
												?>
											</select>
										</div>
									</div>				
								</div>
							</div>
							<div class="row clearfix">		 
								<button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
								<button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>
							</div>  
						</form>
					</div></div>	                   
				</div>
			</div>
			<?php
			if(isset($_POST['smpn']) or isset($_POST['del'])){	
				$kurs_code=$_POST['kurs_code'];	
				$kurs=$_POST['kurs'];
				$term=$_POST['term'];
				$pic=$_SESSION['nama'];
				$qry_del="delete from bps_kurs where kurs_code='$kurs_code' and term='$term'";
				$qry_add="insert into bps_kurs(kurs_code,kurs,term,pic_updt,tgl_updt) values('$kurs_code','$kurs','$term','$pic',getdate())";
				$tb_del=odbc_exec($koneksi_lp,$qry_del);
			}
			if(isset($_POST['smpn']) ){	
				$tb_add=odbc_exec($koneksi_lp,$qry_add);
				$sq_crpart="select * from bps_kurs where kurs_code='$kurs_code'";
			}
			?>

			<div class="row clearfix">
				<div class="card">
					<div class="row clearfix">				
						<div class="header">
							<h2>Record<small>Cari Kurs</small></h2>
						</div>
						<div class="body">
							<form action="" id="frmcari" method="post"  enctype="multipart/form-data">

								<div class="col-sm-3">	
									<div class="form-group">
										<!--label>Kolom</label-->
										<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
											<option selected="selected" value="">---Pilih Kolom---</option>
											<option value="Term">Term</option>
											<option value="kurs_code">Kode Kurs</option>
										</select>
									</div>
								</div>
								<div class="col-sm-6">	
									<div class="form-group">
										<div class="form-line">
											<input type="text"  class="form-control" data-role="tagsinput" id="txt_cari" name="txt_cari" placeholder="Detail Pencarian">
										</div> 
									</div>
								</div>
								<div class="col-sm-2">
									<button type="submit" name="cr_b" id="cr_b" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">search</i> </button>
									<button type="reset" name="reset" id="reset" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">clear</i> </button>
								</div>
							</form>
						</div>	
					</div>	   
					<div class="row clearfix">
						<div class="body">
							<div class="table-responsive">
								<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
									<thead>
										<tr>	
											<th>No</th>
											<th>Kode Kurs</th>
											<th>Kurs</th>
											<th>Term</th>
											<th>Pic Update</th>
										</tr>
									</thead>

									<tbody>
										<?php
										if(isset($_POST['cr_b']) ){	
											$cmd_cari=$_POST['cmd_cari'];
											$txt_cari=str_replace(" ","",$_POST['txt_cari']);
											if($txt_cari==""){$whr="Kurs_code is not null"; }else{
												$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
												$sq_crpart="select * from bps_kurs where $whr";
											}
											if(isset($_POST['smpn']) or isset($_POST['cr_b'])){	
												$tb_acc=odbc_exec($koneksi_lp,$sq_crpart);
												$row=0;
												while($baris1=odbc_fetch_array($tb_acc)){ $row++;
													?>	
													<tr  onclick="javascript:pilih(this);">
														<td><?php echo $row; ?></td>
														<td><?php echo odbc_result($tb_acc,"kurs_code"); ?></td>
														<td><?php echo number_format(odbc_result($tb_acc,"kurs"),3,".",","); ?></td>
														<td><?php echo odbc_result($tb_acc,"term"); ?></td>
														<td><?php echo odbc_result($tb_acc,"pic_updt"); ?></td>
													</tr>	
													<?php 
												}
											}

											?>	
										</tbody>
										<tfoot>
											<tr>	
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<script>
			function pilih(row){
				var kd_pel1=row.cells[1].innerHTML;
				var kd_pel2=row.cells[2].innerHTML;
				var kd_pel3=row.cells[3].innerHTML;
				document.form1.kurs_code.value=kd_pel1;
				document.form1.kurs.value=kd_pel2.replace(",","");
				document.form1.term.value=kd_pel3.replace("TERM ","");
			}
		</script>