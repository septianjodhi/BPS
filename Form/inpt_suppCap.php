<script>

function cr_pn(url,title,w,h){
		var dt_nama=document.form1.part_nm.value;
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        w = window.open(url+'&w='+dt_nama, title, 'toolbar=no, location=no, directories=no, \n\
        status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
        width='+w+',height='+h+',top='+top+',left='+left);
  };
  </script>
<?php

$pic=$_SESSION['nama'];
$sect= $_SESSION["area"];
$pchsec=explode("-",$sect);
$sec=$pchsec[1];

?>
 <section class="content">
 <div class="container-fluid">
	<div class="block-header">
                <h2>SUPPLIER CAPACITY</h2>
    </div>
	<div class="row clearfix">
	<div class="col-lg-9">
    <div class="card">
		<div class="header">
             <h2>INPUT<small>Manual Input Supplier Capacity</small></h2>
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
				<label>Code Supplier</label>
				 <div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="form-control" id="cd_supp" name="cd_supp" placeholder="Kode Supplier" required>
				</div>
				 <span class="input-group-addon">
                     <button type="button" class="btn bg-red waves-effect"  onclick="open_child('template.php?plh=select/plh_supp.php&c=cd_supp','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
				</div></div>			
				</div> 
			<div class="col-md-3">
                <div class="form-group">
				<label>Part No</label>
				<div class="form-line">
					<input type="text"readonly  class="form-control" id="part_no" name="part_no" placeholder="Part No" required>
				</div></div></div>                
			<div class="col-md-6">	
			<div class="form-group">
				<label>Nama Part</label>
				 <div class="input-group">
				<div class="form-line">
				<input type="text" class="form-control" id="part_nm" name="part_nm" placeholder="Nama Part" required>
				</div>
				<span class="input-group-addon">
                     <button type="button" class="btn bg-red waves-effect"  onclick="cr_pn('template.php?plh=select/plh_pn.php&c1=part_nm&c2=part_no&c3=&c4=&c5=','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
				</div></div>
				</div>  
		</div> 
        <div class="row clearfix">				
                <div class="col-md-3">                							
                <div class="form-group">
				<label>Periode</label>
				<div class="form-line">
					<input type="number" class="periode form-control" id="periode" name="periode" value="<?php echo date("Ym"); ?>" placeholder="Periode" required>
				</div></div>			
				</div>   
                <div class="col-md-3">                								
                <div class="form-group">
				<label>Prioritas</label>
				<div class="form-line">
					<input type="number" min="1" max="50" class="form-control" id="prioritas" name="prioritas" placeholder="Prioritas" required>
				</div></div>			
				</div>   
                <div class="col-md-3">                									
                <div class="form-group">
				<label>Capacity (%)</label>
				<div class="form-line">
					<input type="number" min="1" class="form-control" id="capacity" name="capacity" placeholder="Capacity" required>
				</div></div>                			
				</div>
				<div class="col-md-3">                									
                <div class="form-group">
				<label>Term</label>
				 <div class="input-group">
				 <select class="selectpicker" data-live-search="true" style="width: 100%;"  name="term_cr" id="term_cr" required>
				<option selected="selected" value="">-Pilih Term-</option>
				 <?php 
				 $tb_term=odbc_exec($koneksi_lp,"select distinct term from bps_setterm where start_prepaire<=getdate() and finish_term >=getdate() order by term desc");
				 while($bar_term=odbc_fetch_array($tb_term)){
					 $opt_trm=odbc_result($tb_term,"term");
					 $opt_term='<option value="'.$opt_trm.'">TERM '.$opt_trm.'</option>';
				 }
				 echo $opt_term;
				 ?>
				</select>
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
$cd_supp=$_POST['cd_supp'];	
$periode=$_POST['periode'];
$prioritas=$_POST['prioritas'];
$capacity=$_POST['capacity'];
$part_no=$_POST['part_no'];	
$part_nm=$_POST['part_nm'];
$term=$_POST['term_cr'];

$qry_del="delete from bps_suppcapacity where part_no='$part_no' and supp_code='$cd_supp' and periode='$periode'";
$qry_add="insert into bps_suppcapacity(part_no,part_nm,supp_code,periode,prioritas,kapasitas,pic_updt,tgl_updt,term,lp) values('$part_no','$part_nm','$cd_supp','$periode','$prioritas','$capacity','$pic',getdate(),'$term','$sec')";
$tb_del=odbc_exec($koneksi_lp,$qry_del);
}
if(isset($_POST['smpn']) ){	
$tb_add=odbc_exec($koneksi_lp,$qry_add);
}
?>	 
	<div class="col-lg-3">
    <div class="card">
		<div class="header">
             <h2>INPUT<small>Upload Supplier Capacity (Update Per Periode)</small></h2>
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
			$periode="-";
			$pic=$_SESSION['nama'];
			$supp="";
			for ($i=5; $i<=$fixedbaris; $i++){		
$kolA=$data->val($i,1);//No
$kolB=$data->val($i,2);//Periode
$kolC=$data->val($i,3);//part no
$kolD=$data->val($i,4);//Prioritas
$kolE=$data->val($i,5);//kode Supplier
$kolF=$data->val($i,6);//capacity
$kolG=$data->val($i,7);//term

if($kolC!=""){
$sql_del="delete from bps_suppcapacity where supp_code='$kolE' and Periode='$kolB' and part_no='$kolC'";	

if($kolB !=$periode and $supp!=$kolE and $kolE!=""){$hilang=odbc_exec($koneksi_lp,$sql_del);}
$periode=$kolB;	$supp=$kolE;

$sql_updt="insert into bps_suppcapacity(periode,part_no,prioritas,supp_code,kapasitas,PIC_Updt,TGL_updt,term,lp) values('$kolB','$kolC','$kolD','$kolE','$kolF','$pic',getdate(),'$kolG','$sec')";
$hasil = odbc_exec($koneksi_lp, strtoupper($sql_updt));
//echo "<br>lht ".$i.$query1;
 if(!$hasil){
	echo "<br>Error ".$i.$sql_updt;
	print(odbc_error());
}else{}
	}
		}
$qry_updtnm="update bps_suppcapacity set part_nm=bps_part.part_nm from bps_suppcapacity inner join bps_part on bps_suppcapacity.part_no=bps_part.part_no where bps_suppcapacity.part_nm is null";
$updtnm=odbc_exec($koneksi_lp,$qry_updtnm);
unlink($_FILES['file']['name']);	

}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_suppCap.php'</script>"; }
	
}
?>	 
	   <div class="row clearfix">
      <div class="card">
	<div class="row clearfix">				
	<div class="header">
	 <h2>Record<small>Cari Supplier Capacity</small></h2>
	</div>
	<div class="body">
    <form action="" id="frmcari" method="post"  enctype="multipart/form-data">
	
	<div class="col-sm-3">	
	 <div class="form-group">
    <!--label>Kolom</label-->
       <select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
			<option selected="selected" value="">---Pilih Kolom---</option>
<option value="SUPP_CODE">KODE SUPPLIER</option>
<option value="periode">PERIODE</option>
<option value="part_no">PART NO</option>
<option value="part_nm">PART NAME</option>
<option value="prioritas">PRIORITAS</option>
<option value="kapasitas">CAPACITY</option>
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
<th>PERIODE</th>
<th>PART NO</th>
<th>PART NAME</th>
<th>PRIORITAS</th>
<th>KODE SUPP</th>
<th>CAPACITY</th>
<th>PIC UPDATE</th>

</tr>
                                    </thead>
                                   
                                    <tbody>
                                       <?php
if(isset($_POST['cr_b']) ){	
$cmd_cari=$_POST['cmd_cari'];
$txt_cari=str_replace(" ","",$_POST['txt_cari']);
if($txt_cari==""){$whr="supp_code is not null"; }else{
$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
$sq_acc="select * from bps_suppcapacity where $whr";
$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
$row=0;
while($baris1=odbc_fetch_array($tb_acc)){ $row++;
				?>	
				<tr  onclick="javascript:pilih(this);">
<td><?php echo $row; ?></td>
<td><?php echo odbc_result($tb_acc,'periode'); ?></td>
<td><?php echo odbc_result($tb_acc,'part_no'); ?></td>
<td><?php echo odbc_result($tb_acc,'part_nm'); ?></td>
<td><?php echo odbc_result($tb_acc,'prioritas'); ?></td>
<td><?php echo odbc_result($tb_acc,'SUPP_CODE'); ?></td>
<td><?php echo odbc_result($tb_acc,'kapasitas'); ?></td>
<td><?php echo odbc_result($tb_acc,'pic_updt'); ?></td>
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
  <script type="text/javascript">
		$(document).ready(function()
		{
		$('.periode').bootstrapMaterialDatePicker({
        format: 'YYYYMM', minDate : new Date(),
        clearButton: true,
        weekStart: 1,
        time: false
    });	
			});
</script>
 <script>
 function pilih(row){
      	var kd_pel1=row.cells[1].innerHTML;
      	var kd_pel2=row.cells[2].innerHTML;
      	var kd_pel3=row.cells[3].innerHTML;
      	var kd_pel4=row.cells[4].innerHTML;
      	var kd_pel5=row.cells[5].innerHTML;
      	var kd_pel6=row.cells[6].innerHTML;
		document.form1.periode.value=kd_pel1;
		document.form1.part_no.value=kd_pel2;
		document.form1.part_nm.value=kd_pel3;
		document.form1.prioritas.value=kd_pel4;
		document.form1.cd_supp.value=kd_pel5;
		document.form1.capacity.value=kd_pel6;
		
 }
 </script>