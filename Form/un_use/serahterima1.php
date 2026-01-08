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
                <h2>SERAH TERIMA BARANG</h2>
    </div>
	
	
	<div class="row clearfix">
    <div class="card">
		<div class="header">
             <h2>INPUT<small>Manual Input Budget</small></h2>
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
		 <form role="form-inline"  name="form1" id="form1" method="post" action="">
		  <div class="row clearfix">
			<div class="col-sm-2">	<div class="form-group">
				<label>Type</label>
				<div class="input-group">
				<select class="selectpicker" data-live-search="true" style="width: 50%;"  name="type_brg" id="type_brg"  required>
				<option selected="selected" value="">---Pilih Type---</option>
				<option value="Sparepart">Sparepart</option>
				<option value="Konsumtif">Konsumtif</option>
				<option value="Barang">Barang</option>

				</select>
		</div></div></div>
			<div class="col-sm-2"> <div class="form-group">
				<label>Part no</label>
				<div class="form-line">
					<input type="text" class="form-control" id="part_no" name="part_no"  placeholder="Part no" required>
				</div></div></div>
			<div class="col-sm-2"> <div class="form-group">
				<label>Qty</label>
				<div class="form-line">
					<input type="number" class="form-control" id="qty" name="qty"  placeholder="0" required>
				</div></div></div>
			<div class="col-sm-2"> <div class="form-group">
				<label>PIC LP</label>
				<div class="form-line">
					<input type="text" class="form-control" id="pic_lp" name="pic_lp"  placeholder="PIC LP" required>
				</div></div></div>
			<div class="col-sm-2"> <div class="form-group">
				<label>Penerima</label>
				<div class="form-line">
					<input type="text" class="form-control" id="pic_terima" name="pic_terima"  placeholder="Penerima" required>
				</div></div></div>
			<div class="col-sm-2"> <div class="form-group">
				<label>Waktu Terima</label>
				<div class="form-line">
					<input type="text" class="form-control datetime-min" id="tgl_terima" name="tgl_terima"  placeholder="Waktu Terima" required>
				</div></div></div>
		</div>
		
		  <div class="row clearfix">
			
			<div class="col-sm-2"> <div class="form-group">
				<label>PR NO</label>
				<div class="form-line">
					<input type="text" class="form-control" id="no_pr" name="no_pr"  placeholder="PR NO" required>
				</div></div></div>	
			<div class="col-sm-2"> <div class="form-group">
				<label>PO no</label>
				<div class="form-line">
					<input type="text" class="form-control" id="no_po" name="no_po"  placeholder="PO no" required>
				</div></div></div>
			<div class="col-sm-2"> <div class="form-group">
				<label>Invoice</label>
				<div class="form-line">
					<input type="text" class="form-control" id="no_inv" name="no_inv"  placeholder="Invoice" required>
				</div></div></div>
			<div class="col-sm-2"> <div class="form-group">
				<label>VP</label>
				<div class="form-line">
					<input type="text" class="form-control" id="no_vp" name="no_vp"  placeholder="VP" required>
				</div></div></div>	
			<div class="col-sm-2"> <div class="form-group">
				<label>BC</label>
				<div class="form-line">
					<input type="text" class="form-control" id="no_bc" name="no_bc"  placeholder="BC NO" required>
				</div></div></div>	
			
		</div>
		<div class="row clearfix">		 
          <button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SAVE</button>		 
          <button type="reset" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Clear</button>
            
		</div>
		</form>
        </div></div>	                   
     </div>
<?php
if(isset($_POST['smpn'])){	
$type_brg=$_POST['type_brg'];
$part_no=$_POST['part_no'];
$qty=$_POST['qty'];
$pic_lp=$_POST['pic_lp'];
$no_pr=$_POST['no_pr'];
$no_po=$_POST['no_po'];
$no_inv=$_POST['no_inv'];
$no_vp=$_POST['no_vp'];
$no_bc=$_POST['no_bc'];
$tgl_terima=$_POST['tgl_terima'];
$pic_terima=$_POST['pic_terima'];
$pic_updt=$_SESSION['nama'];
$sect=$_SESSION['area'];

//$qry_del=" where no_ctrl='$no_ctrl'";
$qry_add="insert into bps_serahterima(sect,type_brg,part_no,qty,no_pr,no_po,no_inv,no_vp,no_BC,pic_lp,tgl_terima,pic_terima,pic_updt,tgl_updt) values('$sect','$type_brg','$part_no','$qty','$no_pr','$no_po','$no_inv','$no_vp','$no_bc','$pic_lp','$tgl_terima','$pic_terima','$pic_updt',getdate())";

if(isset($_POST['smpn']) ){	
$tb_add=odbc_exec($koneksi_lp,$qry_add);
$sq_acc="select * from bps_serahterima where sect='$sect' and tgl_terima='$tgl_terima'";
}}
?>	 
<div class="row clearfix">
<div class="col-md-3">
    <div class="card">
		<div class="header">
             <h2>INPUT<small>Upload Penerimaan Barang</small></h2>
                       </div>
		<form role="form" enctype="multipart/form-data" name="form2" id="form2" method="post" action="">
		<div class="body">
		 <div class="form-group">
				<label>Open File</label>
				<div class="form-line">
					<input type="file" class="form-control" id="file" name="file" placeholder="Cari File" required>
				</div>
        </div></div>
		<div class="form-group">
		<button type="submit" id="upld" name="upld" class="btn bg-orange waves-effect">
				<i class="material-icons">saves</i>Send</button>
		  
        </div>
		</form>	
		</div>	</div>
<div class="col-md-9">
    <div class="card">
		<div class="header">
             <h2>INPUT<small>Cari Penerimaan Barang</small></h2>
        </div>
		<div class="body">
    <form action="" id="frmcari" method="post"  enctype="multipart/form-data">
	<div class="row clearfix">
	 <div class="form-group">
    <div class="col-sm-3"><label>Range Tanggal</label></div>
	<div class="col-md-9">
	 <div class="form-line">
      <input type="text"  class="form-control" id="rg_tgl" name="rg_tgl" placeholder="Detail Pencarian" required>
    </div></div></div></div>
	<div class="row clearfix">
	<div class="col-sm-3">	
	 <div class="form-group">
    <!--label>Kolom</label-->
	 <div class="input-group">
       <select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
			<option selected="selected" value="">---Pilih Kolom---</option>
<option value="sect">Section</option>
<option value="type_brg">Type Barang</option>
<option value="part_no">Part no</option>
<option value="qty">Qty</option>
<option value="no_pr">PR</option>
<option value="no_po">PO</option>
<option value="no_inv">Invoice</option>
<option value="no_vp">VP</option>
<option value="no_BC">BC</option>
<option value="pic_lp">Pic LP</option>
<option value="pic_terima"></option>
<option value="pic_updt"></option>
       </select>
    </div></div>
	</div>
	<div class="col-sm-4">	
	 <div class="form-group">
    <div class="form-line">
      <input type="text"  class="form-control" data-role="tagsinput" id="txt_cari" name="txt_cari" placeholder="Detail Pencarian">
	  </div> 
    </div></div>
	
	<div class="col-sm-3">
	<button type="submit" name="cr_b" id="cr_b" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">search</i> </button>
	<button type="reset" name="reset" id="reset" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">clear</i> </button>
    </div>
	</div>
                            </form>
       </div>	
		</div>	</div>
		
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
$tgl_terima=$data->val(5,3);
$pic_terima=$data->val(4,8);
$pic_lp=$data->val(5,8);
$pic_updt=$_SESSION['nama'];
$sect=$_SESSION['area'];
			$jmrow=0;
			
			for ($i=8; $i<=$fixedbaris; $i++){		
//$kolA=$data->val($i,1);//no
$kolB=$data->val($i,2);//Part no
$kolC=$data->val($i,3);//Qty
$kolD=$data->val($i,4);//PR
$kolE=$data->val($i,5);//PO
$kolF=$data->val($i,6);//Invoice
$kolG=$data->val($i,7);//VP
$kolH=$data->val($i,8);//BC
$kolI=$data->val($i,9);//Pic LP

	
if($kolB!=""){
$sql_updt="insert into bps_serahterima(sect,type_brg,part_no,qty,no_pr,no_po,no_inv,no_vp,no_BC,pic_lp,tgl_terima,pic_terima,pic_updt,tgl_updt) values('$sect','$kolB','$kolC','$kolD','$kolE','$kolF','$kolG','$kolH','$kolI','$pic_lp','$tgl_terima','$pic_updt',getdate())";	

$hasil = odbc_exec($koneksi_lp,$sql_updt);	
//echo "<br>lht ".$i.$sql_updt;
 if(!$hasil){
	echo "<br>Error ".$i.$sql_updt;
	print(odbc_error());
}else{ $jmrow++; }
	}
			}
unlink($_FILES['file']['name']);	
echo "<script>alert('$jmrow DATA SELESAI DI UPLOAD ');</script>";
$sq_acc="select * from bps_serahterima where tgl_updt=getdate() and pic_updt='$pic_updt'";
}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_budFA.php'</script>"; }
	
}
?>	 
	   <div class="row clearfix">
      <div class="card">
	<div class="row clearfix">				
	<div class="header">
	 <h2>Record<small></small></h2>
	</div>
	
</div>	   
						<div class="row clearfix">
                        <div class="body">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
                                    <thead>
                                     <tr>	
<th>SECTION</th>
<th>TYPE BARANG</th>
<th>PART NO</th>
<th>QTY</th>
<th>PR</th>
<th>PO</th>
<th>INVOICE</th>
<th>VP</th>
<th>BC</th>
<th>PIC LP</th>
<th>PENERIMA</th>
<th>TGL TERIMA</th>


</tr>
                                    </thead>
                                   
                                    <tbody>
                                       <?php
if(isset($_POST['cr_b']) ){	
$sect=$_SESSION["area"];
$rg_tgl=explode("-",$_POST['rg_tgl']);
$whr="(tgl_terima between '".date("Y-m-d H:i:s",strtotime($rg_tgl[0]))."' and '".date("Y-m-d H:i:s",strtotime($rg_tgl[1]))."') and sect='".$sect."'";
$cmd_cari=$_POST['cmd_cari'];
$txt_cari=str_replace(" ","",$_POST['txt_cari']);
if($txt_cari==""){$whr1="";$whrnex2=""; }else{
$whr1=" and replace($cmd_cari,' ','') like '%$txt_cari%'";
$whrnex2=" and replace(bps_serahterima.$cmd_cari,' ','') like '%$txt_cari%'";
}
$sq_acc="select * from bps_serahterima where $whr $whr1";

$whrnex=" where (bps_serahterima.tgl_terima between '".date("Y-m-d H:i:s",strtotime($rg_tgl[0]))."' and '".date("Y-m-d H:i:s",strtotime($rg_tgl[1]))."') and bps_serahterima.sect='".$sect."'".$whrnex2;

}
if(isset($_POST['smpn']) or isset($_POST['upld']) or isset($_POST['cr_b'])){
//	echo $sq_acc;
$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
$row=0;
while($baris1=odbc_fetch_array($tb_acc)){ $row++;
			?>	
				<tr  onclick="javascript:pilih(this);">
<td><?php echo odbc_result($tb_acc,"sect"); ?></td>
<td><?php echo odbc_result($tb_acc,"type_brg"); ?></td>
<td><?php echo odbc_result($tb_acc,"part_no"); ?></td>
<td><?php echo odbc_result($tb_acc,"qty"); ?></td>
<td><?php echo odbc_result($tb_acc,"no_pr"); ?></td>
<td><?php echo odbc_result($tb_acc,"no_po"); ?></td>
<td><?php echo odbc_result($tb_acc,"no_inv"); ?></td>
<td><?php echo odbc_result($tb_acc,"no_vp"); ?></td>
<td><?php echo odbc_result($tb_acc,"no_BC"); ?></td>
<td><?php echo odbc_result($tb_acc,"pic_lp"); ?></td>
<td><?php echo odbc_result($tb_acc,"pic_terima"); ?></td>
<td><?php echo odbc_result($tb_acc,"tgl_terima"); ?></td>


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
	<?php if(isset($_POST['cr_b']) and $row>0 ){	
	$Sqlireng=base64_encode($whrnex);
	?>
		 <!--button type="button" class="btn btn-info btn-flat" onclick="open_child('<?php // echo "Exp_xls/".$dwnld."?peri=".$periX."&lok=".$asst_Lokasi."&sttkon=".$stt_kon;?>','Data Conveyor','800','500'); return false;" >
                    <i class="fa  fa-file-excel-o"></i>Export ke Excel
                  </button-->
		<button type="button" class="btn btn-info btn-flat" onclick="open_child('Exp_pdf/prn_HO.php?Qry=<?php echo $Sqlireng; ?>','Data Conveyor','800','500'); return false;" >
                    <i class="fa  fa-file-pdf-o"></i>Export ke PDF
                  </button>
	<?php } ?>
                        </div></div>
                    </div>
                </div>
 </div>
 </section>
<script>
$(function() {
  $('input[name="rg_tgl"]').daterangepicker({
    timePicker: true,
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
      format: 'M/DD/YYYY HH:mm:ss'
    }
  });
});
</script>