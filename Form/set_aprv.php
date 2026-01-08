<?php $sect= $_SESSION["area"]; ?>
 <section class="content">
 <div class="container-fluid">
	<div class="block-header">
                <h2>APPROVE</h2>
    </div>
<div class="row clearfix">
<div class="card">
<div class="header">
 <ul class="nav nav-tabs tab-nav-right" role="tablist">
    <li role="presentation" class="active"><a href="#manual" data-toggle="tab">Manual Input</a></li>
    <li role="presentation"><a href="#by_upload" data-toggle="tab">Upload</a></li>
  </ul>	
</div>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="manual">
		<div class="header"><h2>INPUT<small>Manual Input Master Area</small></h2></div>
	<div class="body">
	 <form role="form"  name="form1" id="form1" method="post" action="">
        <div class="row clearfix">		
                <div class="col-md-3">	
				 <div class="form-group">
				<label>Section</label>
				<div class="form-line">
					<input type="text" readonly class="form-control" id="sect" name="sect" value="<?php echo $sect; ?>" placeholder="SECTION" required>
				</div></div></div>
                <div class="col-md-3">	
                <div class="form-group">
				<label>NIK</label>
				<div class="form-line">
					<input type="text" class="form-control" id="nik" name="nik" placeholder="nik" required>
				</div></div></div>
                <div class="col-md-3">							
                <div class="form-group">
				<label>INNITIAL</label>
				<div class="form-line">
					<input type="text" class="form-control" id="init" name="init" placeholder="Initial" required>
				</div></div></div>
                <div class="col-md-3">							
                <div class="form-group">
				<label>JABATAN</label>
				<div class="form-line">
					<input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Jabatan" required>
				</div></div></div>                				
			</div>
        <div class="row clearfix">		   
                <div class="col-md-6">
                <div class="form-group">
				<label>Nama</label>
				<div class="form-line">
					<input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
				</div></div></div>   
                <div class="col-md-6">
                <div class="form-group">
				<label>EMAIL</label>
				<div class="form-line">
					<input type="text" class="form-control" id="email" name="email" placeholder="EMAIL" required>
				</div></div></div>
			</div>    
        <div class="row clearfix">	    
                <div class="col-md-3">               
                <div class="form-group">
				<label>Jenis Dok</label>
				<div class="form-line">
					<input type="text" class="form-control" id="jns_dok" name="jns_dok" placeholder="Jenis Dok" required>
				</div></div></div>  
                <div class="col-md-3">               
                <div class="form-group">
				<label>Jns Approve</label>
				<div class="form-line">
					<input type="text" class="form-control" id="jns_aprv" name="jns_aprv" placeholder="Jenis Aprove" required>
				</div></div></div>  
                <div class="col-md-2">               
                <div class="form-group">
				<label>No Urut</label>
				<div class="form-line">
					<input type="number" min="0" max="6" class="form-control" id="no_urut" name="no_urut" placeholder="No Urut" required>
				</div></div></div> 
                <div class="col-md-2">               
                <div class="form-group">
				<label>Minimum</label>
				<div class="form-line">
					<input type="number" min="0" class="form-control" id="apv_min" name="apv_min" placeholder="IDR" required>
				</div></div></div> 
                <div class="col-md-2">               
                <div class="form-group">
				<label>Maksimum</label>
				<div class="form-line">
					<input type="number" min="0" class="form-control" id="apv_max" name="apv_max" placeholder="IDR" required>
				</div></div></div> 
		</div>
		<div class="row clearfix">		 
          <button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
          <button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>
            
		</div>  
		</form>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane fade" id="by_upload">
	<div class="header"><h2>INPUT<small>Upload data Approve</small></h2></div>
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
	</div>
	</div>
</div>
</div></div>	
	
<?php
if(isset($_POST['smpn']) or isset($_POST['del'])){	
$sect=$_POST['sect'];	
$nik=$_POST['nik'];
$init=$_POST['init'];
$jabatan=$_POST['jabatan'];
$nama=$_POST['nama'];
$email=$_POST['email'];
$jns_dok=$_POST['jns_dok'];
$jns_aprv=$_POST['jns_aprv'];
$no_urut=$_POST['no_urut'];
$apv_min=$_POST['apv_min'];
$apv_max=$_POST['apv_max'];

$pic=$_SESSION['nama'];;
$qry_del="delete from bps_setApprove where nik='$nik' and sect='$sect' and jns_dok='$jns_dok'";
$qry_add="insert into bps_setApprove(nik,initial,nama,email,sect,no_aprv,approve,jns_dok,jabatan,min_amount,max_amount,pic_updt,tgl_updt) values('$nik','$init','$nama','$email','$sect','$no_urut','$jns_aprv','$jns_dok','$jabatan','$apv_min','$apv_max','$pic',getdate())";
$tb_del=odbc_exec($koneksi_lp,$qry_del);
}
if(isset($_POST['smpn']) ){	
$tb_add=odbc_exec($koneksi_lp,$qry_add);
}

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
			for ($i=6; $i<=$fixedbaris; $i++){		
$kolA=$data->val($i,1);//nik
$kolB=$data->val($i,2);//initial
$kolC=$data->val($i,3);//nama
$kolD=$data->val($i,4);//EMAIL
$kolE=$data->val($i,5);//SECTION
$kolF=$data->val($i,6);//NO URUT
$kolG=$data->val($i,7);//TTD
$kolH=$data->val($i,8);//DOKUMEN
$kolI=$data->val($i,9);//JABATAN
$kolJ=$data->val($i,10);//Minimum Amount
$kolK=$data->val($i,11);//Maximal Amount

if($kolE!=""){	
$sql_del="delete from bps_setApprove where nik='$kolA' and sect='$kolE' and jns_dok='$kolH'";
$hilang=odbc_exec($koneksi_lp,$sql_del);	
$sql_updt="insert into bps_setApprove(nik,initial,nama,email,sect,no_aprv,approve,jns_dok,jabatan,min_amount,max_amount,pic_updt,tgl_updt) values('$kolA','$kolB','$kolC','$kolD','$kolE','$kolF','$kolG','$kolH','$kolI','$kolJ','$kolK','$pic',getdate())";
$hasil = odbc_exec($koneksi_lp, $sql_updt);
//echo "<br>lht ".$i.$query1;
 if(!$hasil){
	echo "<br>Error ".$i.$sql_updt;
	print(odbc_error());
}else{}
	}
			}
unlink($_FILES['file']['name']);	

}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/set_aprv.php'</script>"; }
	
}
?>	 
	   <div class="row clearfix">
      <div class="card">
	<div class="row clearfix">				
	<div class="header">
	 <h2>Record<small>Cari Setting Approve</small></h2>
	</div>
	<div class="body">
    <form action="" id="frmcari" method="post"  enctype="multipart/form-data">
	
	<div class="col-sm-3">	
	 <div class="form-group">
    <!--label>Kolom</label-->
       <select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
			<option selected="selected" value="">---Pilih Kolom---</option>
<option value="nik">NIK</option>
<option value="initial">INITIAL</option>
<option value="nama">NAMA</option>
<option value="email">EMAIL</option>
<option value="approve">APPROVE</option>
<option value="jabatan">JABATAN</option>
<option value="jns_dok">JNS DOK</option>
<option value="min_amount">MIN AMOUNT</option>
<option value="max_amount">MAX AMOUNT</option>

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
<th>NIK</th>
<th>INITIAL</th>
<th>NAMA</th>
<th>EMAIL</th>
<th>SECT</th>
<th>JNS DOK</th>
<th>APPROVE</th>
<th>JABATAN</th>
<th>NO APRV</th>
<th>MIN AMOUNT</th>
<th>MAX AMOUNT</th>

</tr>
                                    </thead>
                                   
                                    <tbody>
                                       <?php
$whr="";
if(isset($_POST['cr_b']) ){	
$cmd_cari=$_POST['cmd_cari'];
$txt_cari=str_replace(" ","",$_POST['txt_cari']);
if($txt_cari==""){$whr=""; }else{
$whr=" and replace($cmd_cari,' ','') like '%$txt_cari%'";}
}
$dep=explode("-",$sect);
$sq_acc="select * from bps_setApprove where sect in('$sect','$dep[0]-ALL','SAMI-ALL') $whr";
$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
$row=0;
while($baris1=odbc_fetch_array($tb_acc)){ $row++;
				?>	
				<tr  onclick="javascript:pilih(this);">
<td><?php echo odbc_result($tb_acc,"nik"); ?></td>
<td><?php echo odbc_result($tb_acc,"initial"); ?></td>
<td><?php echo odbc_result($tb_acc,"nama"); ?></td>
<td><?php echo odbc_result($tb_acc,"email"); ?></td>
<td><?php echo odbc_result($tb_acc,"sect"); ?></td>
<td><?php echo odbc_result($tb_acc,"jns_dok"); ?></td>
<td><?php echo odbc_result($tb_acc,"approve"); ?></td>
<td><?php echo odbc_result($tb_acc,"jabatan"); ?></td>
<td><?php echo odbc_result($tb_acc,"no_aprv"); ?></td>
<td><?php echo odbc_result($tb_acc,"min_amount"); ?></td>
<td><?php echo odbc_result($tb_acc,"max_amount"); ?></td>

				</tr>	
				<?php 
}?>	
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
      	var kd_pel0=row.cells[0].innerHTML;//nik`
      	var kd_pel1=row.cells[1].innerHTML;//initial
      	var kd_pel2=row.cells[2].innerHTML;//nama
      	var kd_pel3=row.cells[3].innerHTML;//email
      	var kd_pel4=row.cells[4].innerHTML;//sect
      	var kd_pel5=row.cells[5].innerHTML;//jns_dok
      	var kd_pel6=row.cells[6].innerHTML;//approve
      	var kd_pel7=row.cells[7].innerHTML;//jabatan
      	var kd_pel8=row.cells[8].innerHTML;//no_urut
      	var kd_pel9=row.cells[9].innerHTML;//min
      	var kd_pel10=row.cells[10].innerHTML;//max
		document.form1.sect.value=kd_pel4;
		document.form1.nik.value=kd_pel0;
		document.form1.init.value=kd_pel1;
		document.form1.jabatan.value=kd_pel7;
		document.form1.nama.value=kd_pel2;
		document.form1.email.value=kd_pel3;
		document.form1.jns_dok.value=kd_pel5;
		document.form1.no_urut.value=kd_pel8;
		document.form1.apv_min.value=kd_pel9;
		document.form1.apv_max.value=kd_pel10;
		document.form1.jns_aprv.value=kd_pel6;
		
 }
 </script>