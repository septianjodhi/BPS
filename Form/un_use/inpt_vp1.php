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
                <h2>VOUCHER PAYING</h2>
    </div>
	
	
	<div class="row clearfix">
    <div class="card">
		<div class="header">
             <h2>INPUT VP<small>Manual Input VP</small></h2>
        </div>
		<div class="body">
		 <form role="form-inline"  name="form1" id="form1" class="step_with_validation" method="post" action="">
		 <h3>STEP 1</h3>
		  <fieldset>
			<div class="col-sm-4">	
			<div class="form-group">
				<label>PO</label>
				 <div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="po_no" name="po_no" placeholder="PO No" required>
				</div>
				</div></div>
				<div class="form-group">
				<label>Invoice</label>
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="inv_no" name="inv_no" placeholder="Invoice" required>
                </div></div></div>
			<div class="col-sm-3">
			<div class="form-group">
				<label>Purchasing</label>
				<div class="form-line">
					<input type="text"  readonly class="form-control bg-grey" id="lp" name="lp" placeholder="Purchasing" required>
				</div></div>
				<div class="form-group">
				<label>Kode Supp</label>
				<div class="form-line">
					<input type="text"  readonly class="form-control bg-grey" id="kode_supp" name="kode_supp" placeholder="Kode Supp" >
				</div></div>
			</div>
			<div class="col-sm-2">
			<div class="form-group">
				<label>Total QTY</label>
				<div class="form-line">
					<input type="number"  readonly class="form-control bg-grey" id="qty" name="qty" placeholder="QTY" required>
				</div></div>
				<div class="form-group">
				<label>Total Bayar</label>
				<div class="form-line">
					<input type="number" step="2" class="form-control" id="tot_bayar" name="tot_bayar" placeholder="Bayar" >
				</div></div>
			</div>
			<div class="col-sm-2">
			<div class="form-group">
				<label>Jenis BC</label>
				<div class="form-line">
					<input type="text"  readonly class="form-control bg-grey" id="jns_bc" name="jns_bc" placeholder="Jenis BC" required>
				</div></div>
				<div class="form-group">
				<label>BC No</label>
				<div class="form-line">
					<input type="text" class="form-control" id="no_bc" name="no_bc" placeholder="BC NO" >
				</div></div>
				<div class="form-group">
				<label>Tanggal BC</label>
				<div class="form-line">
					<input type="text" class="form-control date-pick" id="tgl_bc" name="tgl_bc" placeholder="Tgl_BC" >
				</div></div>
			</div>
		</fieldset> 
		
		 <h3>STEP 2</h3>
        <fieldset>
		<div class="col-sm-3"> 
			<div class="form-group">
				<label>VP NO</label>
				<div class="form-line">
					<input type="text" class="form-control" id="vp_no" name="vp_no"  placeholder="VP NO" required>
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
$po_no=$_POST['po_no'];
$inv_no=$_POST['inv_no'];
$tgl_bc=$_POST['tgl_bc'];
$lp=$_POST['lp'];
$kode_supp=$_POST['kode_supp'];
$qty_tot=$_POST['qty'];
$tot_bayar=$_POST['tot_bayar'];
$vp_no=$_POST['vp_no'];
$jns_bc=$_POST['jns_bc'];
$pic_updt=$_SESSION['nama'];
$sect=$_SESSION['area'];

//$qry_del=" where no_ctrl='$no_ctrl'";
$qry_add="insert into bps_vp(inv_no,po_no,lp,kode_supp,qty_tot,tot_bayar,no_bc,tgl_bc,jns_bc,vp_no,pic_updt,tgl_updt) values('$inv_no','$po_no','$lp','$kode_supp','$qty_tot','$tot_bayar'','$no_bc','$tgl_bc','$jns_bc','$vp_no','$pic_updt',getdate())";

if(isset($_POST['smpn']) ){	
$tb_add=odbc_exec($koneksi_lp,$qry_add);
$sq_acc="select * from bps_vp where sect='$sect' and tgl_terima='$tgl_terima'";
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

$sq_acc="select distinct part_no,part_nm,part_dtl,part_desc,pr_no,po_no,kode_supp,no_quo,periode,term from bps_podtl where not exists(select po_no from bps_kedatangan where po_no=bps_podtl.po_no)";
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