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
			<h2>SETTING TERM</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Manual Term</small></h2>
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
          					<div class="form-group">
          						<label>Term</label>
          						<div class="form-line">
          							<input type="number" class="form-control" min="50" id="term" name="term" placeholder="TERM" required>
          						</div>
          					</div>
          				</div>				
          			</div>
          			<div class="col-md-3">
          				<div class="form-group">
          					<label>Start Prepaire</label>
          					<div class="form-line">
          						<input type="text" class="form-control date-min" id="pre_term" name="pre_term" placeholder="Prepaire" required>
          					</div>
          				</div>
          			</div>
          			<div class="col-md-3">
          				<div class="form-group">
          					<label>Start Term</label>
          					<div class="form-line">
          						<input type="text" class="form-control date-min" id="start_term" name="start_term" placeholder="Start Term" required>
          					</div>
          				</div>
          			</div>
				<!--div class="col-md-3">
				 <div class="form-group">
				<label>Finish Term</label>
				<div class="form-line">
					<input type="text" class="form-control date-min" id="start_term" name="start_term" placeholder="Start Term" required>
				</div>
                </div>
            </div-->


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
$sq_crpart="select * from bps_setterm";
if(isset($_POST['smpn']) or isset($_POST['del'])){	
	$pre_term=$_POST['pre_term'];	
	$start_term=$_POST['start_term'];

	$term=$_POST['term'];
	$pic=$_SESSION['nama'];
	$qry_del="delete from bps_setterm where term='$term'";
	$qry_add="insert into bps_setterm(term,start_prepaire,start_term,finish_term,pic_updt,tgl_updt) values('$term','$pre_term','$start_term',dateadd(day,-1,dateadd(year,1,'$start_term')),'$pic',getdate())";
	$tb_del=odbc_exec($koneksi_lp,$qry_del);
}
if(isset($_POST['smpn']) ){	
//echo $qry_add;
	$tb_add=odbc_exec($koneksi_lp,$qry_add);
	$sq_crpart="select * from bps_setterm where term='$term'";
}
?>	 

<div class="row clearfix">
	<div class="card">
		<div class="row clearfix">				
			<div class="header">
				<h2>Record<small>Term</small></h2>
			</div>
	<!--div class="body">
    <form action="" id="frmcari" method="post"  enctype="multipart/form-data">
	
	<div class="col-sm-3">	
	 <div class="form-group">
       <select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
			<option selected="selected" value="">---Pilih Kolom---</option>
<option value="Term">Term</option>
<option value="kurs_code">Kode Kurs</option>
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
                        </div-->	
                    </div>	   
                    <div class="row clearfix">
                    	<div class="body">
                    		<div class="table-responsive">
                    			<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
                    				<thead>
                    					<tr>	
                    						<th>No</th>
                    						<th>Term</th>
                    						<th>Prepaire</th>
                    						<th>Start</th>
                    						<th>Finish</th>
                    						<th>Keterangan</th>
                    					</tr>
                    				</thead>

                    				<tbody>
                    					<?php
/*if(isset($_POST['cr_b']) ){	
$cmd_cari=$_POST['cmd_cari'];
$txt_cari=str_replace(" ","",$_POST['txt_cari']);
if($txt_cari==""){$whr="Kurs_code is not null"; }else{
$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
$sq_crpart="select * from lp_kurs where $whr";
}
if(isset($_POST['smpn']) or isset($_POST['cr_b'])){	
*/$tb_acc=odbc_exec($koneksi_lp,$sq_crpart);
	$row=0;
	while($baris1=odbc_fetch_array($tb_acc)){ $row++;
		?>	
		<tr  onclick="javascript:pilih(this);">
			<td><?php echo $row; ?></td>
			<td><?php echo odbc_result($tb_acc,"term"); ?></td>
			<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_acc,"start_prepaire"))); ?></td>
			<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_acc,"start_term"))); ?></td>
			<td><?php echo date("Y-m-d",strtotime(odbc_result($tb_acc,"finish_term"))); ?></td>
			<td></td>
		</tr>	
		<?php 
}//}

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
		document.form1.term.value=kd_pel1;
		document.form1.pre_term.value=kd_pel2;
		document.form1.start_term.value=kd_pel3;
	}
</script>