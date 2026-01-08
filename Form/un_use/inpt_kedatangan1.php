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
                <h2>KEDATANGAN BARANG</h2>
    </div>
	
	
	<div class="row clearfix">
    <div class="card">
		<div class="header">
             <h2>INPUT INVOICE<small>Manual Input Invoice</small></h2>
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
		
		 <form role="form-inline"  name="form1" id="form1" class="step_with_validation" method="post" action="">
		 <h3>STEP 1</h3>
		  <fieldset>
			<div class="col-sm-4">	
			<div class="form-group">
				<label>Part No</label>
				 <div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="part_no" name="part_no" placeholder="Part No" required>
				</div>
				</div></div>
				<div class="form-group">
				<label>Part Name</label>
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="part_nm" name="part_nm" placeholder="Nama Part" required>
                </div></div></div>
			<div class="col-sm-8">
			<div class="form-group">
				<label>Part Detail</label>
				<div class="form-line">
					<input type="text"  readonly class="form-control bg-grey" id="part_dtl" name="part_dtl" placeholder="Detail Part" required>
				</div></div>
				<div class="form-group">
				<label>Part Deskripsi</label>
				<div class="form-line">
					<input type="text"  readonly class="form-control bg-grey" id="part_desc" name="part_desc" placeholder="Deskripsi" >
				</div></div>
			</div>
		</fieldset> 
		
		 <h3>STEP 2</h3>
        <fieldset>
		<div class="col-sm-3"> 
			<div class="form-group">
				<label>PR NO</label>
				<div class="form-line">
					<input type="text" class="form-control" id="no_pr" name="no_pr"  placeholder="PR NO" required>
				</div></div>
		<div class="form-group">
				<label>PO No</label>
				<div class="form-line">
					<input type="text" class="form-control" id="no_po" name="no_po"  placeholder="PO no" required>
				</div></div>				
		</div>
		<div class="col-sm-3"> 
		 <div class="form-group">
				<label>Invoice</label>
				<div class="form-line">
					<input type="text" class="form-control" id="no_inv" name="no_inv"  placeholder="Invoice" required>
				</div></div>
		<div class="form-group">
				<label>Tgl Inv</label>
				<div class="form-line">
					<input type="text" class="form-control date-pick" id="tgl_terima" name="tgl_terima"  placeholder="Waktu Datang" required>
				</div></div>					
		</div>		
		<div class="col-sm-3"> 
		<div class="form-group">
				<label>Qty</label>
				<div class="form-line">
					<input type="number" class="form-control" id="qty" name="qty"  placeholder="0" required>
				</div></div>
			<div class="form-group">
				<label>PIC LP</label>
				<div class="form-line">
					<input type="text" class="form-control" id="pic_lp" name="pic_lp"  placeholder="PIC LP" required>
				</div></div>
		<div class="form-group">
				<label>Waktu Kedatangan</label>
				<div class="form-line">
					<input type="text" class="form-control datetime-min" id="inv_tgl" name="inv_tgl"  placeholder="Waktu Datang" required>
				</div></div>		
		</div>
		<div class="col-sm-3"> 
		 <button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SAVE</button>		 
          <button type="reset" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Clear</button>
		</div>		
		</fieldset>
		 
		</form>
        </div></div>	                   
     </div>
<?php
if(isset($_POST['smpn'])){	
$part_no=$_POST['part_no'];
$part_nm=$_POST['part_nm'];
$part_dtl=$_POST['part_dtl'];
$part_desc=$_POST['part_desc'];
$qty=$_POST['qty'];
$pic_lp=$_POST['pic_lp'];
$pr_no=$_POST['no_pr'];
$po_no=$_POST['no_po'];
$inv_no=$_POST['no_inv'];
$inv_tgl=$_POST['inv_tgl'];
$pic_updt=$_SESSION['nama'];
$sect=$_SESSION['area'];

//$qry_del=" where no_ctrl='$no_ctrl'";
$qry_add="insert into bps_kedatangan(part_no,part_nm,part_dtl,part_desc,qty,pr_no,po_no,inv_no,kode_supp,inv_tgl,pic_updt,tgl_updt) values('$part_no','$part_nm','$part_dtl','$part_desc','$qty','$pr_no','$po_no','$inv_no','$kode_supp','$inv_tgl','$pic_updt',getdate())";

if(isset($_POST['smpn']) ){	
$tb_add=odbc_exec($koneksi_lp,$qry_add);
$sq_acc="select * from bps_kedatangan where inv_no='$inv_no";
}}
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
<th>TERM</th>
<th>PERIODE PO</th>		
<th>PART NO</th>	
<th>PART NAME</th>
<th>PART DETAIL</th>
<th>PART DESC</th>
<th>KODE SUPP</th>	
<th>QTY</th>
<th>QUOTATION</th>	
<th>PR NO</th>
<th>PO NO</th>


</tr>
                                    </thead>
                                   
                                    <tbody>
                                       <?php

$sq_acc="select distinct part_no,part_nm,part_dtl,part_desc,pr_no,po_no,kode_supp,no_quo,periode,term,qty from bps_podtl where not exists(select po_no from bps_kedatangan where po_no=bps_podtl.po_no)";
//	echo $sq_acc;
$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
$row=0;
while($baris1=odbc_fetch_array($tb_acc)){ $row++;
			?>	
				<tr  onclick="javascript:pilih(this);">
<td><?php echo odbc_result($tb_acc,"term"); ?></td>
<td><?php echo odbc_result($tb_acc,"periode"); ?></td>
<td><?php echo odbc_result($tb_acc,"part_no"); ?></td>
<td><?php echo odbc_result($tb_acc,"part_nm"); ?></td>
<td><?php echo odbc_result($tb_acc,"part_dtl"); ?></td>
<td><?php echo odbc_result($tb_acc,"part_desc"); ?></td>
<td><?php echo odbc_result($tb_acc,"kode_supp"); ?></td>
<td><?php echo odbc_result($tb_acc,"qty"); ?></td>
<td><?php echo odbc_result($tb_acc,"no_quo"); ?></td>
<td><?php echo odbc_result($tb_acc,"pr_no"); ?></td>
<td><?php echo odbc_result($tb_acc,"po_no"); ?></td>


				</tr>	
				<?php 
}
	
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
function pilih(row){
      	var kd_pel=row.cells[0].innerHTML;
		var kd_pel1=row.cells[1].innerHTML;
		var kd_pel2=row.cells[2].innerHTML;
		var kd_pel3=row.cells[3].innerHTML;
		var kd_pel4=row.cells[4].innerHTML;
		var kd_pel5=row.cells[5].innerHTML;
		var kd_pel6=row.cells[6].innerHTML;
		var kd_pel7=row.cells[7].innerHTML;
		var kd_pel8=row.cells[8].innerHTML;
		var kd_pel9=row.cells[9].innerHTML;
		var kd_pel10=row.cells[10].innerHTML;
		document.form1.part_no.value=kd_pel2;
		document.form1.part_nm.value=kd_pel3;
		//alert(kd_pel10);
		document.form1.part_dtl.value=kd_pel4;
		document.form1.part_desc.value=kd_pel5;
		document.form1.no_pr.value=kd_pel9;
		document.form1.no_po.value=kd_pel10;
    };
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