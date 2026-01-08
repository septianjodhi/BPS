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
                <h2>MASTER PHASE</h2>
    </div>
	<div class="row clearfix">
	<div class="col-lg-12">
    <div class="card">
		<div class="header">
             <h2>INPUT<small>Manual Input Phase</small></h2>
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
				<div class="col-md-6">				
                <div class="form-group">
				<label>Phase</label>
				<div class="form-line">
					<input type="text" class="form-control" id="phase" name="phase" placeholder="Phase" required>
				</div>
                </div>				
				</div>
                <div class="col-md-6">
                <div class="form-group">
				<label>Keteranngan</label>
				<div class="form-line">
					<input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Description" required>
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
$phase=$_POST['phase'];	
$keterangan=$_POST['keterangan'];
$pic=$_SESSION['nama'];;
$qry_del="delete from bps_phase where phase='$phase'";
$qry_add="insert into bps_phase(phase,keterangan,pic_updt,tgl_updt) values('$phase','$keterangan','$pic',getdate())";
$tb_del=odbc_exec($koneksi_lp,$qry_del);
}
if(isset($_POST['smpn']) ){	
$tb_add=odbc_exec($koneksi_lp,$qry_add);
$sq_crpart="select * from bps_phase where phase='$phase'";
}
?>	 
	 
	   <div class="row clearfix">
      <div class="card">
	<div class="row clearfix">				
	<div class="header">
	 <h2>Record<small>Cari Phase</small></h2>
	</div>
	<div class="body">
    <form action="" id="frmcari" method="post"  enctype="multipart/form-data">
	
	<div class="col-sm-3">	
	 <div class="form-group">
    <!--label>Kolom</label-->
       <select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
			<option selected="selected" value="">---Pilih Kolom---</option>
<option value="phase">Part</option>
<option value="keterangan">Keteranngan</option>
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
<th>Phase</th>
<th>Keterangan</th>
<th>Pic Update</th>
</tr>
                                    </thead>
                                   
                                    <tbody>
                                       <?php
if(isset($_POST['cr_b']) ){	
$cmd_cari=$_POST['cmd_cari'];
$txt_cari=str_replace(" ","",$_POST['txt_cari']);
if($txt_cari==""){$whr="phase is not null"; }else{
$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
$sq_crpart="select * from bps_phase where $whr";
}
if(isset($_POST['smpn']) or isset($_POST['cr_b'])){	
$tb_acc=odbc_exec($koneksi_lp,$sq_crpart);
$row=0;
while($baris1=odbc_fetch_array($tb_acc)){ $row++;
				?>	
				<tr  onclick="javascript:pilih(this);">
<td><?php echo $row; ?></td>
<td><?php echo odbc_result($tb_acc,"phase"); ?></td>
<td><?php echo odbc_result($tb_acc,"keterangan"); ?></td>
<td><?php echo odbc_result($tb_acc,"pic_updt"); ?></td>
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
		document.form1.phase.value=kd_pel1;
		document.form1.keterangan.value=kd_pel2;
 }
 </script>