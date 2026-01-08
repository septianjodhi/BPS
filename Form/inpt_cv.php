<section class="content">
		<div class="container-fluid">
		<div class="block-header">
			<h2>COST CENTER (AREA)</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-9">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Manual Input Master Area</small></h2>
                <!--ul class="header-dropdown m-r--5">
                 <li class="dropdown">
                 <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                 <i class="material-icons">more_vert</i>
                 </a>
                 <ul class="dropdown-menu pull-right">
                  <li><a href="javascript:void(0);">Action</a></li>
                  </ul>
              </li> </ul-->
          </div>
          <div class="body">
          	<form role="form"  name="form1" id="form1" method="post" action="">
          		<div class="row clearfix">

          			<div class="col-md-4">
          				<div class="form-group">
          					<label>Term</label>
          					<div class="form-line">
          						<select class="selectpicker"  style="width: 50%;"  name="term" id="term" required>
          							<option selected="selected" value="">-Pilih Term-</option>
          							<?php 
          							$tb_term=odbc_exec($koneksi_lp,"select distinct top 2 term from bps_setterm where start_prepaire<=getdate() and finish_term >=getdate() order by term desc");
          							$opt_term="";
          							while($bar_term=odbc_fetch_array($tb_term)){
          								$opt_trm=odbc_result($tb_term,"term");
          								$opt_term= $opt_term.'<option value="'.$opt_trm.'">TERM '.$opt_trm.'</option>';
          							}
          							echo $opt_term;
          							?>
          						</select>
          						<!-- <input type="text" class="form-control" id="term" name="term" placeholder="term" required> -->
          					</div>
          				</div>

          				<div class="form-group">
          					<label>Car Maker</label>
          					<div class="form-line">
          						<input type="text" class="form-control" id="mkr" name="mkr" placeholder="Car Maker" required>
          					</div>
          				</div>							
          				<div class="form-group">
          					<label>Cost Center Code</label>
          					<div class="form-line">
          						<input type="text" class="form-control" id="cccode" name="cccode" placeholder="Cost Center Code" required>
          					</div>
          				</div>				
          			</div>   
          			<div class="col-md-4">
          				<div class="form-group">
          					<label>Code Carline</label>
          					<div class="form-line">
          						<input type="text" class="form-control" id="kd_car" name="kd_car" placeholder="Code Carline" required>
          					</div></div>
          					<div class="form-group">
          						<label>Carline</label>
          						<div class="form-line">
          							<input type="text" class="form-control" id="nm_car" name="nm_car" placeholder="Carline" required>
          						</div></div>
          					</div>        
          					<div class="col-md-4">
          						<div class="form-group">
          							<label>Code Conveyor</label>
          							<div class="form-line">
          								<input type="text" class="form-control" id="kd_cv" name="kd_cv" placeholder="Code Conveyor" required>
          							</div></div>
          							<div class="form-group">
          								<label>Conveyor</label>
          								<div class="form-line">
          									<input type="text" class="form-control" id="nm_cv" name="nm_cv" placeholder="Conveyor" required>
          								</div></div>

          							</div>     

          						</div>
          						<div class="row clearfix">		 
          							<button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
          							<button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>

          						</div>  
          					</form>
          				</div></div>	                   
          			</div>
          			<?php
          			if(isset($_POST['smpn']) or isset($_POST['del'])){	
          				$mkr=$_POST['mkr'];	
          				$cccode=$_POST['cccode'];
          				$kd_cv=$_POST['kd_cv'];
          				$nm_cv=$_POST['nm_cv'];
          				$kd_car=$_POST['kd_car'];
          				$nm_car=$_POST['nm_car'];
          				$term=$_POST['term'];

          				$pic=$_SESSION['nama'];;
          				$qry_del="delete from lp_cv where cv_code='$kd_cv' and term='$term' ";
          				$qry_add="u into lp_cv(carmaker,cost_center_code,cv_code,cv_desc,carline_code,carline,pic_update,tgl_update,term) values('$mkr','$cccode','$kd_cv','$nm_cv','$kd_car','$nm_car','$pic',getdate(),'$term')";
          				$tb_del=odbc_exec($koneksi_lp,$qry_del);
          			}
          			if(isset($_POST['smpn']) ){	
          				$tb_add=odbc_exec($koneksi_lp,$qry_add);
          			}
          			?>	 
          			<div class="col-lg-3">
          				<div class="card">
          					<div class="header">
          						<h2>INPUT<small>Upload Master Carline</small></h2>
          						<ul class="header-dropdown m-r--5">
          							<li class="dropdown">
          								<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          									<i class="material-icons">more_vert</i>
          								</a>
          								<ul class="dropdown-menu pull-right">
          									<li><a href="javascript:void(0);">Action</a></li>
          								</ul>
          							</li> </ul>
          						</div>
          						<div class="body">
          							<form role="form" enctype="multipart/form-data" name="form2" id="form2" method="post" action="">
          								<div class="form-group">
          									<label>Open File</label>
          									<div class="form-line">
          										<input type="file" class="form-control" id="file" name="file" placeholder="Cari File" required>
          									</div>
          								</div>
          								<button type="submit" id="upld" name="upld" class="btn bg-orange waves-effect">
          									<i class="material-icons">saves</i>UPLOAD
          								</button>
          							</form>
          						</div></div>	                   
          					</div>
          				</div>
          				<?php
          				if(isset($_POST['upld']) ){
          					$date=date("Y-m-d H:i");

          					require_once "excel_reader2.php";
	echo "<script>alert('upload data');</script>"; 
		$file_name = $_FILES['file']['name']; //nama file (tanpa path)
		$tmp_name  = $_FILES['file']['tmp_name']; //nama local temp file di server
		$file_size = $_FILES['file']['size']; //ukuran file (dalam bytes)
		$file_type = $_FILES['file']['type']; //tipe filenya (langsung detect MIMEnya)
		$fp1 = fopen($tmp_name, 'r'); // open file (read-only, binary)
		$fp = fopen($tmp_name, 'r');		
		$pecah=explode(".",$file_name);
		$ekstensi=$pecah[1];
		$extensionList=array("xls","XLS");
		if(in_array($ekstensi,$extensionList)){		
			$target = basename($_FILES['file']['name']) ;
			move_uploaded_file($_FILES['file']['tmp_name'], $target);			 
			$data = new Spreadsheet_Excel_Reader($_FILES['file']['name'],false);  
			$baris = $data->rowcount($sheet_index=0);
			$fixedbaris = $baris;	 
			
			$pic=$_SESSION['nama'];
			for ($i=5; $i<=$fixedbaris; $i++){		
$kolA=$data->val($i,1);//MAKER	
$kolB=$data->val($i,2);//CC Code
$kolC=$data->val($i,3);//CODE Carline
$kolD=$data->val($i,4);//NAMA Carline
$kolE=$data->val($i,5);//CODE CV
$kolF=$data->val($i,6);//NAMA CV
$kolG=$data->val($i,7);//COMMODITY
$kolH=$data->val($i,8);//DEST
$kolI=$data->val($i,9);//term	

if($kolE!=""){	
	$sql_del="delete from lp_cv where cv_code='$kolE' and term='$kolI' ";
	$hilang=odbc_exec($koneksi_lp,$sql_del);
	$sql_updt="insert into lp_cv(carmaker,cost_center_code,carline_code,carline,cv_code,cv_desc,pic_update,tgl_update,term,commodity,dest)
	values('$kolA','$kolB','$kolC','$kolD','$kolE','$kolF','$pic','$date','$kolI','$kolG','$kolH' )";
	$hasil = odbc_exec($koneksi_lp, $sql_updt);
	$sql_del2="delete from lp_cv where term='$kolI' and tgl_update<>'$date' ";
	$hilang2=odbc_exec($koneksi_lp,$sql_del2);
//echo "<br>lht ".$i.$sql_updt;
	if(!$hasil){
		echo "<br>Error ".$i.$sql_updt;
		print(odbc_error());
	}else{}
}
}
unlink($_FILES['file']['name']);	

}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_cv.php'</script>"; }

}
?>	 
<div class="row clearfix">
	<div class="card">
		<div class="row clearfix">				
			<div class="header">
				<h2>Record<small>Cari Master Carline</small></h2>
			</div>
			<div class="body">
				<form action="" id="frmcari" method="post"  enctype="multipart/form-data">

					<div class="col-sm-3">	
						<div class="form-group">
							<!--label>Kolom</label-->
							<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
								<option selected="selected" value="">---Pilih Kolom---</option>
								<option value="term">Term</option>
								<option value="carmaker">Maker</option>
								<option value="cost_center_code">Cost Center Code</option>
								<option value="carline_code">Kode Carline</option>
								<option value="carline">Nama Carline</option>
								<option value="cv_code">Kode Cv</option>
								<option value="cv_desc">Nama Cv</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6">	
						<div class="form-group">
							<div class="form-line">
								<input type="text"  class="form-control" data-role="tagsinput" id="txt_cari" name="txt_cari" placeholder="Detail Pencarian">
							</div> 
						</div></div>

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
									<th>Maker</th>
									<th>Cost Center Code</th>
									<th>Kode Carline</th>
									<th>Nama Carline</th>
									<th>Kode Cv</th>
									<th>Nama Cv</th>
									<th>Commodity</th>
									<th>Destination</th>
								</tr>
							</thead>

							<tbody>
								<?php
								if(isset($_POST['cr_b']) ){	
									$cmd_cari=$_POST['cmd_cari'];
									$txt_cari=str_replace(" ","",$_POST['txt_cari']);
									if($txt_cari==""){$whr="cv_code is not null"; }else{
										$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
										$sq_acc="select * from lp_cv where $whr order by term desc,carline asc ";
										$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
										$row=0;
										while($baris1=odbc_fetch_array($tb_acc)){ $row++;
											?>	
											<tr  onclick="javascript:pilih(this);">
												<td><?php echo $row; ?></td>
												<td><?php echo odbc_result($tb_acc,"term"); ?></td>
												<td><?php echo odbc_result($tb_acc,"carmaker"); ?></td>
												<td><?php echo odbc_result($tb_acc,"cost_center_code"); ?></td>
												<td><?php echo odbc_result($tb_acc,"carline_code"); ?></td>
												<td><?php echo odbc_result($tb_acc,"carline"); ?></td>
												<td><?php echo odbc_result($tb_acc,"cv_code"); ?></td>
												<td><?php echo odbc_result($tb_acc,"cv_desc"); ?></td>
												<td><?php echo odbc_result($tb_acc,"Commodity"); ?></td>
												<td><?php echo odbc_result($tb_acc,"Dest"); ?></td>
											</tr>	
											<?php 
										}}?>	
									</tbody>
									<tfoot>
										<tr>	
										</tr>
									</tfoot>
								</table>
							</div>
						</div></div>
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
				document.form1.mkr.value=kd_pel1;
				document.form1.cccode.value=kd_pel2;
				document.form1.kd_car.value=kd_pel3;
				document.form1.nm_car.value=kd_pel4;
				document.form1.kd_cv.value=kd_pel5;
				document.form1.nm_cv.value=kd_pel6;

			}
		</script>