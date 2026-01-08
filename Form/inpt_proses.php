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
                <h2>PROSES BUDGET</h2>
    </div>
	<div class="row clearfix">
    <div class="card">
		<div class="header">
             <h2>INPUT<small>Manual Proses Budget</small></h2>
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
        <div class="col-lg-12">
		<div class="col-md-3">				
            <div class="form-group">
				<label>Kode Proses</label>
				<div class="form-line">
					<input type="text" class="form-control" id="kd_pros" name="kd_pros" placeholder="Kode Proses" required>
				</div>
			</div>
			<div class="form-group">
				<label>Kategori</label>
				<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="kat_pros" id="kat_pros"  required>
				<option selected="selected" value="">---Pilih Kategori---</option>
				<option value="BARANG">BARANG</option>
				<option value="JASA">JASA</option>
				</select>
			</div>
		</div>
        
        <div class="col-md-2">
			<div class="form-group">
				 <label>Penawaran</label>
                 <div class="switch"><label><input type="checkbox" name="quo" id="quo" checked><span class="lever switch-col-pink"></span></label></div>
			</div>
			<div class="form-group">
				 <label>PR</label>
                 <div class="switch"><label><input type="checkbox" name="pr" id="pr" checked><span class="lever switch-col-pink"></span></label></div>
			</div>	
		
		</div>
		 <div class="col-md-2">	
            <div class="form-group">
				 <label>PO</label>
                 <div class="switch"><label><input type="checkbox" name="po" id="po" checked><span class="lever switch-col-pink"></span></label></div>
			</div>	 		 
            <div class="form-group">
				 <label>Invoice</label>
                 <div class="switch"><label><input type="checkbox" name="inv" id="inv" checked><span class="lever switch-col-pink"></span></label></div>
			</div>    
		 </div>
		 <div class="col-md-2">
            <div class="form-group">
				 <label>VP</label>
                 <div class="switch"><label><input type="checkbox" name="vp" id="vp" checked><span class="lever switch-col-pink"></span></label></div>
			</div>	    
            <div class="form-group">
				 <label>Petty Cash</label>
                 <div class="switch"><label><input type="checkbox" name="cash" id="cash" checked><span class="lever switch-col-pink"></span></label></div>
			</div>	    
		 
		 </div>
		<div class="col-md-3">
		   <div class="form-group">
				 <label>Keterangan </label>
		 <textarea name="ket_pros" id="ket_pros"></textarea>
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
$pic_updt=$_SESSION['nama'];
$kd_pros=$_POST['kd_pros'];
$kat_pros=$_POST['kat_pros'];
$ket_pros=$_POST['ket_pros'];
//$inv=$_POST['inv'];
if(isset($_POST['quo'])){$quo="YES";}else{$quo="NO";}
if(isset($_POST['pr'])){$pr="YES";}else{$pr="NO";}
if(isset($_POST['po'])){$po="YES";}else{$po="NO";}
if(isset($_POST['inv'])){$inv="YES";}else{$inv="NO";}
if(isset($_POST['vp'])){$vp="YES";}else{$vp="NO";}
if(isset($_POST['cash'])){$cash="YES";}else{$cash="NO";}

$qry_del="delete from bps_proses where kd_pros='$kd_pros'";
$qry_add="insert into bps_proses(kd_pros,kategori,penawaran,PR,PO,Invoice,vp,cash,Keterangan,pic_updt,tgl_updt) values('$kd_pros','$kat_pros','$quo','$pr','$po','$inv','$vp','$cash','$ket_pros','$pic_updt',getdate())";
//echo "<script>alert('$qry_add')</script>";
$tb_del=odbc_exec($koneksi_lp,$qry_del);

if(isset($_POST['smpn']) ){	
//ECHO $qry_add;
$tb_add=odbc_exec($koneksi_lp,$qry_add);
}}
?>	   <div class="row clearfix">
      <div class="card">
	<!--div class="row clearfix">				
	<div class="header">
	 <h2>Record<small>Cari Proses</small></h2>
	</div>
	<div class="body">
    <form action="" id="frmcari" method="post"  enctype="multipart/form-data">
	
	<div class="col-sm-3">	
	 <div class="form-group">
    <label>Kolom</label>
       <select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
			<option selected="selected" value="">---Pilih Kolom---</option>
<option value="kd_pros">KODE PROSES</option>
<option value="kategori">KATEGORI</option>
<option value="penawaran">PENAWARAN</option>
<option value="PR">PR</option>
<option value="PO">PO</option>
<option value="Invoice">INVOICE</option>
<option value="vp">VP</option>
<option value="cash">P.CASH</option>
<option value="Keterangan">KETERANGAN</option>
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
</div-->	   
						<div class="row clearfix">
                        <div class="body">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
                                    <thead>
                                     <tr>	
<th>KODE</th>
<th>KATEGORY</th>
<th>KETERANGAN</th>
<th>PENAWARAN</th>
<th>PR</th>
<th>PO</th>
<th>INVOICE</th>
<th>VP</th>
<th>PETTY CASH</th>
</tr>
                                    </thead>
                                   
                                    <tbody>
                                       <?php
/*if(isset($_POST['cr_b']) ){	
//$cmd_cari=$_POST['cmd_cari'];
//$txt_cari=str_replace(" ","",$_POST['txt_cari']);
if($cmd_cari==""){$whr="kd_pros is not null"; }else{
$whr="$cmd_cari='YES'";}
$sq_acc="select * from bps_proses where $whr";
*/$sq_acc="select * from bps_proses ";
$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
$row=0;
while($baris1=odbc_fetch_array($tb_acc)){ $row++;
				?>	
				<tr  onclick="javascript:pilih(this);">
<td><?php echo odbc_result($tb_acc,"kd_pros"); ?></td>
<td><?php echo odbc_result($tb_acc,"kategori"); ?></td>
<td><?php echo odbc_result($tb_acc,"Keterangan"); ?></td>
<td><?php echo odbc_result($tb_acc,"penawaran"); ?></td>
<td><?php echo odbc_result($tb_acc,"PR"); ?></td>
<td><?php echo odbc_result($tb_acc,"PO"); ?></td>
<td><?php echo odbc_result($tb_acc,"Invoice"); ?></td>
<td><?php echo odbc_result($tb_acc,"vp"); ?></td>
<td><?php echo odbc_result($tb_acc,"cash"); ?></td>

				</tr>	
				<?php 
}
//}
	
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
      	var kd_pel0=row.cells[0].innerHTML;
      	//var kd_pel1=row.cells[1].innerHTML;
      	var kd_pel2=row.cells[2].innerHTML;
      	var kd_pel3=row.cells[3].innerHTML;
      	var kd_pel4=row.cells[4].innerHTML;
      	var kd_pel5=row.cells[5].innerHTML;
      	var kd_pel6=row.cells[6].innerHTML;
      	var kd_pel7=row.cells[7].innerHTML;
      	var kd_pel8=row.cells[8].innerHTML;
		document.form1.kd_pros.value=kd_pel0;
		//document.form1.kat_pros.value=kd_pel1;
		document.form1.ket_pros.value=kd_pel2;
		document.form1.quo.value=kd_pel3;
		document.form1.pr.value=kd_pel4;
		document.form1.po.value=kd_pel5;
		document.form1.inv.value=kd_pel6;
		document.form1.vp.value=kd_pel7;
		document.form1.cash.value=kd_pel8;
		
 }
 </script>