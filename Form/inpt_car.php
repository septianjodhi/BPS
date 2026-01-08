
 <section class="content">
 <div class="container-fluid">
	<div class="block-header">
                <h2>CARLINE</h2>
    </div>
	<div class="row clearfix">
	<div class="col-lg-9">
    <div class="card">
		<div class="header">
             <h2>INPUT<small>Manual Input Master Carline</small></h2>
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
		
                <div class="col-md-3">				
                <div class="form-group">
				<label>Kode Carline</label>
				<div class="form-line">
					<input type="text" class="form-control" id="kd_car" name="kd_car" placeholder="Kode Carline" required>
				</div>
                </div>				
				</div>
        
                <div class="col-md-9">
                <div class="form-group">
				<label>Description</label>
				<div class="form-line">
					<input type="text" class="form-control" id="nm_car" name="nm_car" placeholder="Description" required>
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
<?php
if(isset($_POST['smpn']) or isset($_POST['del'])){	
$kd_car=$_POST['kd_car'];	
$nm_car=$_POST['nm_car'];
$pic=$_SESSION['nama'];;
$qry_del="delete from lp_car where car_code='$kd_car'";
$qry_add="insert into lp_car(car_code,car_desc,pic_update,tgl_update) values('$kd_car','$nm_car','$pic',getdate())";
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
$kolA=$data->val($i,1);//kode	
$kolB=$data->val($i,2);//nama	
	
if($kolA!=""){	
$sql_del="Delete from lp_car where car_code='$kolA'";
$hilang=odbc_exec($koneksi_lp,$sql_del);	
	$sql_updt="insert into lp_car(car_code,car_desc,pic_update,tgl_update) values('$kolA','$kolB','$pic',getdate())";
$hasil = odbc_exec($koneksi_lp, $sql_updt);
//echo "<br>lht ".$i.$query1;
 if(!$hasil){
	echo "<br>Error ".$i.$sql_updt;
	print(odbc_error());
}else{}
	}
			}
unlink($_FILES['file']['name']);	

}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_car.php'</script>"; }
	
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
<option value="car_code">Kode Carline</option>
<option value="car_desc">Nama Carline</option>

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
<th>Kode Carline</th>
<th>Nama Carline</th>
</tr>
                                    </thead>
                                   
                                    <tbody>
                                       <?php
if(isset($_POST['cr_b']) ){	
$cmd_cari=$_POST['cmd_cari'];
$txt_cari=str_replace(" ","",$_POST['txt_cari']);
if($txt_cari==""){$whr="car_code is not null"; }else{
$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
$sq_acc="select * from lp_car where $whr";
$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
$row=0;
while($baris1=odbc_fetch_array($tb_acc)){ $row++;
				?>	
				<tr  onclick="javascript:pilih(this);">
<td><?php echo $row; ?></td>
<td><?php echo odbc_result($tb_acc,"car_code"); ?></td>
<td><?php echo odbc_result($tb_acc,"car_desc"); ?></td>
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
		document.form1.kd_car.value=kd_pel1;
		document.form1.nm_car.value=kd_pel2;
		
 }
 </script>