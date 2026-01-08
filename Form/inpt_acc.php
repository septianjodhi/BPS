
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>ACCOUNT BUDGET</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-9">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Manual Input Data Account</small></h2>
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
          			
          			<div class="col-md-2">				
          				<div class="form-group">
          					<label>Group</label>
          					<div class="form-line">
          						<input type="text" class="form-control" id="grp_acc" name="grp_acc" placeholder="Account Group" required>
          					</div>
          				</div>				
          			</div>
          			<div class="col-md-2">				
          				<div class="form-group">
          					<label>Account No</label>
          					<div class="form-line">
          						<input type="text" class="form-control" id="no_acc" name="no_acc" placeholder="Account No" required>
          					</div>
          				</div>				
          			</div>
          			<div class="col-md-2">				
          				<div class="form-group">
          					<label>Fiscal</label>
          					<div class="form-line">
          						<select class="selectpicker" style="width: 100%;"  name="cmd_fisc" id="cmd_fisc" required>
								<option selected="selected" value="">---Pilih---</option>
								<option value="DE">DE</option>
								<option value="NDE">NDE</option>
								</select>
          					</div>
          				</div>				
          			</div>
				
					
					
					
          			</div>
					
					<div class="row clearfix">
          			
          			<div class="col-md-2">
          				<div class="form-group">
          					<label>Description</label>
          					<div class="form-line">
          						<input type="text" class="form-control" id="desc" name="desc" placeholder="Description" required>
          					</div>
          				</div>
          			</div>
          			<div class="col-md-2">				
          				<div class="form-group">
          					<label>HFM Code</label>
          					<div class="form-line">
          						<input type="text" class="form-control" id="hfmcode" name="hfmcode" placeholder="HFM Code" required>
          					</div>
          				</div>				
          			</div>
          		
					
					<div class="col-md-2">
          				<div class="form-group">
          					<label>HFM Description</label>
          					<div class="form-line">
          						<input type="text" class="form-control" id="hfmdesc" name="hfmdesc" placeholder="HFM Description" required>
          					</div>
          				</div>
          			</div>
					
          			</div>
					
					
          			
          			
          		
          		<div class="row clearfix">		 
          			<button type="submit" id="smpn_acc" name="smpn_acc" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
          			<button type="submit" id="del_acc" name="del_acc" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>
          			
          		</div>  
          	</form>
          </div>
      </div>	                   
  </div>
  <?php
  if(isset($_POST['smpn_acc']) or isset($_POST['del_acc'])){	
  	$grp_acc=$_POST['grp_acc'];	
  	$no_acc=$_POST['no_acc'];	
  	$desc=$_POST['desc'];
  	$fisc=$_POST['cmd_fisc'];
	$hfmdesc=$_POST['hfmdesc'];
  	$hfmcode=$_POST['hfmcode'];
  	$pic=$_SESSION['nama'];;
  	$qry_del="delete from lp_acc where acc_no='$no_acc'";
  	$qry_add="insert into lp_acc(acc_group,acc_no,acc_desc,fiscal,pic_update,tgl_update,hfm_code,hfm_desc) values('$grp_acc','$no_acc','$desc','$fisc','$pic',getdate(),'$hfmcode','$hfmdesc')";
  	$tb_del=odbc_exec($koneksi_lp,$qry_del);
  }
  if(isset($_POST['smpn_acc']) ){	
  	$tb_add=odbc_exec($koneksi_lp,$qry_add);
  }
  ?>	 
  <div class="col-lg-3">
  	<div class="card">
  		<div class="header">
  			<h2>INPUT<small>Upload Data Account</small></h2>
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
  					<button type="submit" id="upld_acc" name="upld_acc" class="btn bg-orange waves-effect">
  						<i class="material-icons">saves</i>UPLOAD
  					</button>
  				</form>
  			</div></div>	                   
  		</div>
  	</div>
  	<?php
  	if(isset($_POST['upld_acc']) ){
  		require_once "excel_reader2.php";
	//	echo "<script>alert('upload data');</script>"; 
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
$kolA=$data->val($i,1);//Group	
$kolB=$data->val($i,2);//Account	
$kolC=$data->val($i,3);//Desc
$kolD=$data->val($i,4);//FISCAL
$kolE=$data->val($i,5);//HFM Code
$kolF=$data->val($i,6);//HFM Desc

if($kolB!=""){	
	$sql_del="Delete from lp_acc where acc_no='$kolB'";
	$hilang=odbc_exec($koneksi_lp,$sql_del);	
	$sql_updt="insert into lp_acc(acc_group,acc_no,acc_desc,fiscal,pic_update,tgl_update,hfm_code,hfm_desc) values
	('$kolA','$kolB','$kolC','$kolD','$pic',getdate(),'$kolE','$kolF')";
	$hasil = odbc_exec($koneksi_lp, $sql_updt);
// echo "<br>lht ".$i.$sql_updt;
	if(!$hasil){
		echo "<br>Error ".$i.$sql_updt;
		print(odbc_error());
	}else{}
}
}
unlink($_FILES['file']['name']);	

}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_acc.php'</script>"; }

}
?>	 
<div class="row clearfix">
	<div class="card">
		<div class="row clearfix">				
			<div class="header">
				<h2>Record<small>Cari Data Account</small></h2>
			</div>
			<div class="body">
				<form action="" id="frmcari" method="post"  enctype="multipart/form-data">
					
					<div class="col-sm-3">	
						<div class="form-group">
							<!--label>Kolom</label-->
							<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
								<option selected="selected" value="">---Pilih Kolom---</option>
								<option value="ACC_DESC">Nama Account</option>
								<option value="ACC_NO">Account No</option>
								<option value="ACC_GROUP">Account Group</option>
								<option value="fiscal">Fiscal</option>
								<option value="hfm_code">HFM Code</option>
								<option value="hfm_desc">HFM Description</option>

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
									<th>Group</th>
									<th>Account No</th>
									<th>Description</th>
									<th>Fiscal</th>
									<th>HFM Code</th>
									<th>HFM Description</th>
								</tr>
							</thead>
							
							<tbody>
								<?php
								if(isset($_POST['cr_b']) ){	
									$cmd_cari=$_POST['cmd_cari'];
									$txt_cari=str_replace(" ","",$_POST['txt_cari']);
									if($txt_cari==""){$whr="acc_no is not null"; }else{
										$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
										$sq_acc="select * from lp_acc where $whr";
										$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
										$row=0;
										while($baris1=odbc_fetch_array($tb_acc)){ $row++;
											?>	
											<tr  onclick="javascript:pilih(this);">
												<td><?php echo $row; ?></td>
												<td><?php echo odbc_result($tb_acc,"acc_group"); ?></td>
												<td><?php echo odbc_result($tb_acc,"acc_no"); ?></td>
												<td><?php echo odbc_result($tb_acc,"acc_desc"); ?></td>
												<td><?php echo odbc_result($tb_acc,"fiscal"); ?></td>
												<td><?php echo odbc_result($tb_acc,"hfm_code"); ?></td>
												<td><?php echo odbc_result($tb_acc,"hfm_desc"); ?></td>
											</tr>	
											<?php 
										}}
										
										?>	
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
				
				var kd_pel5=row.cells[5].innerHTML;
				var kd_pel6=row.cells[6].innerHTML;
				document.form1.grp_acc.value=kd_pel1;
				document.form1.no_acc.value=kd_pel2;
				document.form1.desc.value=kd_pel3;
				document.form1.hfmcode.value=kd_pel5;
				document.form1.hfmdesc.value=kd_pel6;
				
			}
		</script>