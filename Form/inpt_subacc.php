<script type="text/javascript">
function open_child(url,title,w,h){
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
        status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
        width='+w+',height='+h+',top='+top+',left='+left);
		
  };	
	function cr_nm(url,title,w,h){
	  var nik=document.form1.account.value;
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        w = window.open(url+'&ac='+nik, title, 'toolbar=no, location=no, directories=no, \n\
        status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
        width='+w+',height='+h+',top='+top+',left='+left);
		
  };
</script>
 <section class="content">
 <div class="container-fluid">
	<div class="block-header">
                <h2>SUB ACCOUNT</h2>
    </div>
	<div class="row clearfix">
	<div class="col-lg-9">
    <div class="card">
		<div class="header">
             <h2>INPUT<small>Manual Input Sub Account</small></h2>
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
				<label>Account</label>
				 <div class="input-group">
                    <div class="form-line">
                     <input type="text" class="form-control" id="account" name="account" placeholder="Account" required>
                     </div>
                    <span class="input-group-addon">
                     <button type="button" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float"  onclick="cr_nm('template.php?plh=select/plh_acc.php&acc=account','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
                                        
                  </div>
			</div>
				</div>
                <div class="col-md-3">				
                <div class="form-group">
				<label>Sub Account</label>
				<div class="form-line">
					<input type="text" class="form-control" id="sub_acc" name="sub_acc" placeholder="sub Account" required>
				</div>
                </div>				
				</div>
				
                <div class="col-md-6">
                <div class="form-group">
				<label>Description</label>
				<div class="form-line">
					<input type="text" class="form-control" id="sub_desc" name="sub_desc" placeholder="Description" required>
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
$account=$_POST['account'];	
$sub_acc=$_POST['sub_acc'];
$sub_desc=$_POST['sub_desc'];
$pic=$_SESSION['nama'];;
$qry_del="delete from bps_subacc where acc_sub='$sub_acc'";
$qry_add="insert into bps_subACC(acc_no,acc_sub,acc_subdesc,pic_updt,tgl_updt) values('$account','$sub_acc','$sub_desc','$pic',getdate())";
$tb_del=odbc_exec($koneksi_lp,$qry_del);
}
if(isset($_POST['smpn']) ){	
$tb_add=odbc_exec($koneksi_lp,$qry_add);
}
?>	 
	<div class="col-lg-3">
    <div class="card">
		<div class="header">
             <h2>INPUT<small>Upload Sub Account</small></h2>
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
$dataok=0;$datan=0;			
			$pic=$_SESSION['nama'];
			for ($i=5; $i<=$fixedbaris; $i++){		
$kolA=$data->val($i,1);//ACCOUNT	
$kolB=$data->val($i,2);//Sub Account
$kolC=$data->val($i,3);//Keterangan
$kolD=$data->val($i,4);//HFM cODE
	
if($kolB!=""){	
$sql_del="delete from bps_subacc where acc_no='$kolA' and acc_sub='$kolB'";
$hilang=odbc_exec($koneksi_lp,$sql_del);	
	$sql_updt="insert into bps_subACC(acc_no,acc_sub,acc_subdesc,pic_updt,tgl_updt,HFM_Code) values('$kolA','$kolB','$kolC','$pic',getdate(),'$kolD')";
$hasil = odbc_exec($koneksi_lp, $sql_updt);
//echo "<br>lht ".$i.$query1;
 if(!$hasil){
	echo "<br>Error ".$i.$sql_updt;
	print(odbc_error());
	$datan++;
}else{$dataok++;}
	}
			}
unlink($_FILES['file']['name']);	
echo "<script>alert('Selesai $dataok data OK, $datan Data Gagal');</script>"; 
}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_car.php'</script>"; }
	
}
?>	 
	   <div class="row clearfix">
      <div class="card">
	<div class="row clearfix">				
	<div class="header">
	 <h2>Record<small>Cari Sub Account</small></h2>
	</div>
	<div class="body">
    <form action="" id="frmcari" method="post"  enctype="multipart/form-data">
	
	<div class="col-sm-3">	
	 <div class="form-group">
    <!--label>Kolom</label-->
       <select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
			<option selected="selected" value="">---Pilih Kolom---</option>
<option value="acc_no">Account No</option>
<option value="acc_sub">Sub Acc No</option>
<option value="acc_subdesc">Description</option>
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
<th>Account</th>
<th>Sub Account</th>
<th>Description</th>
<th>HFM Code</th>
<th>Pic Update</th>
<th>Tgl Update</th>
</tr>
                                    </thead>
                                   
                                    <tbody>
                                       <?php
if(isset($_POST['cr_b']) ){	
$cmd_cari=$_POST['cmd_cari'];
$txt_cari=str_replace(" ","",$_POST['txt_cari']);
if($txt_cari==""){$whr="acc_subdesc is not null"; }else{
$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
$sq_acc="select * from bps_subACC where $whr";
$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
$row=0;
while($baris1=odbc_fetch_array($tb_acc)){ $row++;
				?>	
				<tr  onclick="javascript:pilih(this);">
<td><?php echo $row; ?></td>
<td><?php echo odbc_result($tb_acc,"acc_no"); ?></td>
<td><?php echo odbc_result($tb_acc,"acc_sub"); ?></td>
<td><?php echo odbc_result($tb_acc,"acc_subdesc"); ?></td>
<td><?php echo odbc_result($tb_acc,"hfm_code"); ?></td>
<td><?php echo odbc_result($tb_acc,"pic_updt"); ?></td>
<td><?php echo odbc_result($tb_acc,"tgl_updt"); ?></td>
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
		document.form1.account.value=kd_pel1;
		document.form1.sub_acc.value=kd_pel2;
		document.form1.sub_desc.value=kd_pel3;
		
 }
 </script>