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
			<h2>SETTING PERIODE</h2>
		</div>
		<div class="row clearfix">
			<div class="card">
				<div class="header">
					<h2>INPUT<small>Manual Periode</small></h2>
				</div>
				<div class="body">
					<form role="form"  name="form1" id="form1" method="post" action="">
						<div class="row clearfix">
							<div class="col-md-4">				
								<div class="form-group">
									<div class="form-group">
										<label>Term</label>
										<div class="form-line">
											<select class="selectpicker" style="width: 100%;"  name="term" id="term"  required>
												<option selected="selected" value="">---Pilih Term---</option>
												<?php
												$qterm="select distinct term from bps_setterm order by term desc";
												$tb_qterm=odbc_exec($koneksi_lp,$qterm);
												$opt_term="";
												while($bar_qterm=odbc_fetch_array($tb_qterm)){
													$term=odbc_result($tb_qterm,"term");
													$opt_term=$opt_term.'<option value="'.$term.'">'.$term.'</option>';
												}
												echo $opt_term;
												?>
											</select>
											<!-- <input type="number" class="form-control" min="50" id="term" name="term" placeholder="TERM" required> -->
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Start Periode</label>
									<div class="form-line">
										<input type="text" class="form-control date-min" id="start_date" name="start_date" placeholder="Start Date" required>
									</div>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Finish Periode</label>
									<div class="form-line">
										<input type="text" class="form-control date-min" id="finish_date" name="finish_date" placeholder="Finish Date" required>
									</div>
								</div>
							</div>
							
							
							
							
						</div>
						
						<div class="row clearfix">		 
							<div class="col-md-4">				
								<div class="form-group">
									<div class="form-group">
										<label>For Review</label>
										<div class="form-line">
											<input type="number" class="form-control" min="1" id="review" name="review" placeholder="For Review" required>
										</div>
									</div>
								</div>				
							</div>
							
							
							<div class="col-md-4">				
								<div class="form-group">
									<div class="form-group">
										<label>Remark</label>
											<div class="form-line">
												<input type="text" class="form-control" id="remark" name="remark" placeholder="Remark" required>
											</div>
									</div>
								</div>				
							</div>
							
							
						</div>  
						
						<div class="row clearfix">		 
							<button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>	
							<button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>
						</div>  
					</form>
					<?php
		// $sq_crpart="select * from bps_setperiode";
					if(isset($_POST['smpn']) or isset($_POST['del'])){	
						$term=$_POST['term'];	
						$review=$_POST['review'];
						$start_period=$_POST['start_date'];	
						$finish_period=$_POST['finish_date'];
						$remark=$_POST['remark'];	
						
					
						$pic=$_SESSION['nama'];
						
						$qry_del="delete from bps_stpperiode where term='$term' and review='$review'";
						$qry_add="insert into bps_stpperiode (term,start_period,finish_period,review,remark,pic_updt,tgl_updt) values('$term','$start_period','$finish_period','$review','$remark','$pic',getdate())";
						$tb_del=odbc_exec($koneksi_lp,$qry_del);
					}
					if(isset($_POST['smpn']) ){	
//echo $qry_add;
						$tb_add=odbc_exec($koneksi_lp,$qry_add);
						$sq_crpart="select * from bps_stpperiode where  term='$term'";
					}
					?>

				</div>
			</div>
		</div>
		
		<div class="row clearfix">
			<div class="card">
				<div class="row clearfix">				
					<div class="header">
						<h2>Record<small>Periode</small></h2>
					</div>
					<div class="body">
						<form action="" id="frmcari" method="post"  enctype="multipart/form-data">

							<div class="col-sm-3">	
								<div class="form-group">
									<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
										<option selected="selected" value="">---Pilih Kolom---</option>
										<option value="Term">Term</option>
										<option value="review">For Review</option>
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
										<th>Term</th>
										<th>Start Periode</th>
										<th>Finish Periode</th>
										<th>For Review</th>
										<th>Remark</th>
									</tr>
								</thead>

								<tbody>
									<?php
									if(isset($_POST['cr_b']))
									{
										$cmd_cari=$_POST['cmd_cari'];
										$txt_cari=str_replace(" ","",$_POST['txt_cari']);
										if($txt_cari==""){$whr="term is not null"; }else{
											$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
											$sq_crpart="select * from bps_stpperiode where $whr";
        								// }
        								// if(isset($_POST['smpn']) or isset($_POST['cr_b']))
        								// {	
											$tb_acc=odbc_exec($koneksi_lp,$sq_crpart);
											$row=0;
											while($baris1=odbc_fetch_array($tb_acc)){ $row++;
												?>	
												<tr onclick="javascript:pilih(this);">
													<td><?php echo $row; ?></td>
													<td><?php echo odbc_result($tb_acc,"term"); ?></td>
													<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_acc,"start_period"))); ?></td>
													<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_acc,"finish_period"))); ?></td>
													<td><?php echo odbc_result($tb_acc,"review"); ?></td>
													<td><?php echo odbc_result($tb_acc,"remark"); ?></td>
													<td></td>
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
			var kd_pel4=row.cells[4].innerHTML;
			var kd_pel5=row.cells[5].innerHTML;
			var kd_pel6=row.cells[6].innerHTML;
			document.form1.term.value=kd_pel1;
			document.form1.start_date.value=kd_pel2;
			document.form1.finish_date.value=kd_pel3;
			document.form1.review.value=kd_pel4;
			document.form1.remark.value=kd_pel5;
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function()
		{

			$('.periodemn').bootstrapMaterialDatePicker({
				format: 'YYYYMM', minDate : new Date(),
				clearButton: true,
				weekStart: 0,
				time: false
			});	
			$('.periodeflex').bootstrapMaterialDatePicker({
				format: 'YYYYMM',
				clearButton: true,
				weekStart: 0,
				time: false
			});	
		});
	</script>