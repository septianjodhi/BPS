
<script>

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
	function cr_part(url,title,w,h){
	  var pno=document.form1.part_no.value;
	  var pnd=document.form1.part_desc.value;
	  var peri=document.form1.periode.value;
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        w = window.open(url+'&pno='+pno+'&pnd='+pnd+'&p='+peri, title, 'toolbar=no, location=no, directories=no, \n\
        status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
        width='+w+',height='+h+',top='+top+',left='+left);		
  };
  
	function cr_ctrl(url,title,w,h){
	  var pno=document.form1.term.value;
	  var pnd=document.form1.periode.value;
	  var jns_bud=document.form1.jns_bud.value;
	  var pernow = new Date();
	 var nperi=pernow.getFullYear()+''+("0"+(pernow.getMonth()+1)).slice(-2);
	 var balp=parseInt(pnd)-parseInt(nperi);
	 // alert(balp);
	  if(pno=="" || balp<0){alert("Term Belum dipilih Atau Periode Kurang dari tanggal Sekarang");}else{
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        w = window.open(url+'&t='+pno+'&p='+pnd+'&k='+jns_bud, title, 'toolbar=no, location=no, directories=no, \n\
        status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
        width='+w+',height='+h+',top='+top+',left='+left);	
	  }
  };
</script>
<?php $sect= $_SESSION["Areaa"]; ?>
 <section class="content">
 <div class="container-fluid">
	<div class="block-header">
                <h2>BUDGET SECTION</h2>
    </div>
	<div class="row clearfix">
    <div class="card">
		<div class="header">
             <h2>Change Data Budget</h2>
        </div>
		<div class="body">
		 <form role="form"  name="form1" id="form1" method="post" action="">
		 <table class="table" border="1">
		 <thead>
          <tr>	
		<th width="25%"></th>
		<th width="25%"></th>
		<th width="25%"></th>
		<th width="25%"></th>
		</tr>
		 </thead>
		  <tbody>
			<tr>
			<td><div class="col-md-6">
            <div class="form-group">
				<label>Term</label>
				<div class="input-group">
				 <select class="selectpicker" data-live-search="true" style="width: 100%;"  name="term" id="term" required>
				<option selected="selected" value="">-Choose Term-</option>
				 <?php 
				 $tb_term=odbc_exec($koneksi_lp,"select distinct term from bps_setterm where start_prepaire<=getdate() and finish_term >=getdate() order by term desc");
				 while($bar_term=odbc_fetch_array($tb_term)){
					 $opt_trm=odbc_result($tb_term,"term");
					 $opt_term='<option value="'.$opt_trm.'">TERM '.$opt_trm.'</option>';
				 }
				 echo $opt_term;
				 ?>
				</select>
			</div>
			</div></div>
			<div class="col-md-6">
                <div class="form-group">
				<label>Periode</label>
				<div class="form-line">
					<input type="number" class="periode form-control" id="periode" name="periode" value="<?php echo date("Ym"); ?>" placeholder="Periode" required>				               
			</div></div> </div></td>
			<td><div class="form-group">
				<label>Type</label>
				<div class="input-group">
				<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="jns_bud" id="jns_bud"  required>
				<option selected="selected" value="NORMAL">Normal</option>
				<option value="ADDITIONAL">ADD</option>
				</select>
			</div></div></td>
			<td><div class="form-group">
				<label>Control No</label>
				 <div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="no_ctrl" name="no_ctrl" placeholder="No Contro" required>
				</div>
				 <span class="input-group-addon">
                     <button type="button" class="btn bg-red waves-effect"  onclick="cr_ctrl('template.php?plh=select/plh_crctrl.php&s=<?php echo $sect; ?>','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
				</div> </div></td>               
			<td><div class="form-group">
				<label>Cost Center</label>
				  <div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="cccode" name="cccode" placeholder="Cost Center" required>
				</div>
                    <span class="input-group-addon">
                     <button type="button" class="btn bg-purple waves-effect"  onclick="open_child('template.php?plh=select/plh_cccode.php&o=cccode&k=1','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
                </div></div></td>                
				
			</tr>
			<tr>
			<td> <div class="form-group">
				<label>Part No</label>
				 <div class="input-group">
				<div class="form-line">
					<input type="text" class="form-control" id="part_no" name="part_no" placeholder="Part No" required>
				</div>
                    <span class="input-group-addon">
                     <button type="button" class="btn bg-purple waves-effect"  onclick="cr_part('template.php?plh=select/plh_partbud.php','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
				</div>
                </div></td>
			<td><div class="form-group">
				<label>Part Name</label>
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="part_nm" name="part_nm" placeholder="Nama Part" required>
                </div></div></td>
			<td><div class="form-group">
				<label>Part Detail</label>
				<div class="form-line">
					<input type="text"  readonly class="form-control bg-grey" id="part_dtl" name="part_dtl" placeholder="Detail Part" required>
				</div>
                </div></td>
			<td><div class="form-group">
				<label>Part Deskripsi</label>
				<div class="form-line">
					<input type="text" class="form-control" id="part_desc" name="part_desc" placeholder="Deskripsi" required>
				</div>
                </div></td>
			</tr>
			<tr>
			<td>	<div class="col-md-6">
                <div class="form-group">
				<label>Qty</label>
				<div class="form-line">
					<input type="number" readonly class="form-control bg-grey" id="qty" name="qty" placeholder="Qty" required>
				</div>
                </div></div>
				<div class="col-md-6">
                <div class="form-group">
				<label>UOM</label>
				<div class="form-line">
					<input type="text" class="form-control" id="uom" name="uom" placeholder="Uom" required>
				</div>
                </div></div></td>
			<td><div class="col-md-6">
                <div class="form-group">
				<label>Currency</label>
				<div class="input-group">
					<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="curr" id="curr"  required>
				<option selected="selected" value="">Currency</option>
				<?php
				$qcurr="select distinct kurs_code from lp_kurs";
				$tb_curr=odbc_exec($koneksi_lp,$qcurr);
				while($bar_curr=odbc_fetch_array($tb_curr)){
				$dt_curr=odbc_result($tb_curr,"kurs_code");
				echo '<option value="'.$dt_curr.'">'.$dt_curr.'</option>';
				}				
				?>
				</select>
				</div>
                </div></div>	
				<div class="col-md-6">
                <div class="form-group">
				<label>Price</label>
				<div class="form-line">
					<input type="number" readonly class="form-control bg-grey" id="price" name="price" placeholder="Price" required>
				</div>
                </div></div></td>
			<td><div class="form-group">
				<label>Phase</label>
				<div class="input-group">
					<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="phase" id="phase"  required>
				<option selected="selected" value="">-Choose Phase-</option>
				<?php
				$qphase="select distinct phase from bps_phase";
				$tb_phase=odbc_exec($koneksi_lp,$qphase);
				while($bar_qphase=odbc_fetch_array($tb_phase)){
				$dt_phase=odbc_result($tb_phase,"phase");
				echo '<option value="'.$dt_phase.'">'.$dt_phase.'</option>';
				}				
				?>
				</select>
                </div></div></td>
			<td><div class="form-group">
				<label>Process Code</label>
				<div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="id_proses" name="id_proses" placeholder="Kode Proses" required>
				</div> <span class="input-group-addon">
                     <button type="button" class="btn bg-purple waves-effect"  onclick="open_child('template.php?plh=select/plh_pros.php','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
                </div></div></td>
			
				</tr>
			<tr>
			<td><div class="form-group">
				<label>Purchasing</label>
				<div class="input-group">
				<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="lp" id="lp"  required>
				<option selected="selected" value="">-Choose Purchasing-</option>
				<option value="GA">GA</option>
				<option value="MTP">MTP</option>
				<option value="LD">LD</option>
				<option value="MPC">MPC</option>
				</select>
			</div></div>
                </td>
			<td><div class="form-group">
				<label>LT Quotation</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_Quo" name="lt_Quo" placeholder="LT Quotation" required>
				</div></div></td>	
			<td><div class="col-md-6">	
                <div class="form-group">
				<label>LT PR</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_pr" name="lt_pr" placeholder="LT PR" required>
				</div></div>	</div>
               <div class="col-md-6">
                <div class="form-group">
				<label>LT PO</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_po" name="lt_po" placeholder="LT PO" required>
				</div>
                </div>	</div> </td>
			<td><div class="col-md-6">	
                <div class="form-group">
				<label>LT Arrival</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_datang" name="lt_datang" placeholder="LT Arrival" required>
				</div>
                </div>	</div>
			<div class="col-md-6">
                <div class="form-group">
				<label>LT VP</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_vp" name="lt_vp" placeholder="LT VP" required>
				</div>
                </div></div></td>
			
			</tr>
		 </tbody>
		 </table><div class="row clearfix">		 
          <button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
          <button type="reset" id="reset" name="reset" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Clear</button>
            
		</div>
		</form>
        </div></div>	                   
     </div>
<?php
if(isset($_POST['smpn']) or isset($_POST['del'])){	
//$sect=$_POST['sect'];
$term=$_POST['term'];
$jns_budget="NORMAL";
$pic_updt=$_SESSION['nama'];
//$tgl_updt=$_POST['tgl_updt']
$no_ctrl=$_POST['no_ctrl'];
$lp=$_POST['lp'];
$id_proses=$_POST['id_proses'];
//$account=$_POST['account'];
//$sub_acc=$_POST['sub_acc'];
$part_nm=$_POST['part_nm'];
$part_no=$_POST['part_no'];
$part_desc=$_POST['part_desc'];
$part_dtl=$_POST['part_dtl'];
$periode=$_POST['periode'];
$cccode=$_POST['cccode'];
$phase=$_POST['phase'];
$qty=$_POST['qty'];
$uom=$_POST['uom'];
$price=$_POST['price'];
$curr=$_POST['curr'];
$lt_vp=$_POST['lt_vp'];
$lt_datang=$_POST['lt_datang'];
$lt_po=$_POST['lt_po'];
$lt_pr=$_POST['lt_pr'];
$lt_Quo=$_POST['lt_Quo'];
$expaired=date("Y-m-d",strtotime($periode."28"));
$qry_chg="update bps_budget set part_no='$part_no',part_nm='$part_nm',part_desc='$part_desc',lp='$lp',id_proses='$id_proses',curr='$curr',cccode='$cccode',phase='$phase',lt_Quo='$lt_Quo',lt_pr='$lt_pr',lt_po='$lt_po',lt_datang='$lt_datang',lt_vp='$lt_vp',expaired='$expaired',pic_updt='$pic_updt',tgl_updt=getdate() where no_ctrl='$no_ctrl'";

//$qry_del=" where no_ctrl='$no_ctrl'";
//$qry_add="(sect,term,jns_budget,pic_updt,tgl_updt,expaired,no_ctrl,lp,id_proses,account,sub_acc,part_no,part_desc,part_dtl,periode,qty,uom,price,curr,cccode,phase,lt_Quo,lt_pr,lt_po,lt_datang,lt_vp) values('$sect','$term','$jns_budget','$pic_updt',getdate(),'$expaired','$no_ctrl','$lp','$id_proses','$account','$sub_acc','$part_no','$part_desc','$part_dtl','$periode','$qty','$uom','$price','$curr','$cvcode','$phase','$lt_Quo','$lt_pr','$lt_po','$lt_datang','$lt_vp')";
//$tb_del=odbc_exec($koneksi_lp,"delete from bps_budget ".$qry_del);
//$tb_delFA=odbc_exec($koneksi_lp,"delete from bps_budget_FA ".$qry_del);
//$tb_chg=odbc_exec($koneksi_lp,$qry_chg);
if(isset($_POST['smpn']) ){	
$tb_add=odbc_exec($koneksi_lp,$qry_chg);
echo "<script>alert('DATA SUDAH DI UPDATE');</script>";
$sq_acc="select * from bps_budget where no_ctrl='$no_ctrl'";
}}
?>	 
	   <div class="row clearfix">
      <div class="card">
	<div class="row clearfix">				
	<div class="header">
	 <h2>Record<small>Cari Plan Budget</small></h2>
	</div>
	<div class="body">
    <form action="" id="frmcari" method="post"  enctype="multipart/form-data">
	<div class="col-sm-3">	
	 <div class="form-group">
	  <select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_tbl" id="cmd_tbl">
			<option selected="selected" value="">Realisasi</option>
			<option value="_FA">Plan Budget</option>
			<!--option value="_temp">Temporary</option-->
	  </select>
    </div>
	</div>
	<div class="col-sm-3">	
	 <div class="form-group">
    <!--label>Kolom</label-->
       <select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
			<option selected="selected" value="">---Pilih Kolom---</option>
<option value="sect">SECTION</option>
<option value="term">TERM</option>
<option value="no_ctrl">CONTROL NO</option>
<option value="lp">PURCHASING</option>
<option value="id_proses">KODE PROSES</option>
<option value="account">ACCOUNT</option>
<option value="sub_acc">SUB ACCOUNT</option>
<option value="part_no">PART NO</option>
<option value="part_desc">PART NAME</option>
<option value="part_dtl">DETAIL PART</option>
<option value="periode">PERIODE</option>
<option value="phase">PHASE</option>
<option value="cv_code">Conveyor</option>
<option value="qty">QTY</option>
<option value="uom">UOM</option>
<option value="price">PRICE</option>
<option value="curr">CURRENCY</option>
<option value="expaired">EXPAIRED DATE</option>


       </select>
    </div>
	</div>
	<div class="col-sm-4">	
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
<th>SECTION</th>
<th>TERM</th>
<th>TYPE</th>
<th>CONTROL NO</th>
<th>PURCHASING</th>
<th>PROCESS CODE</th>
<th>ACCOUNT</th>
<th>SUB ACC</th>
<th>PART NO</th>
<th>PART NAME</th>
<th>PART DETAIL</th>
<th>PERIODE</th>
<th>QTY</th>
<th>UOM</th>
<th>CURR</th>
<th>PRICE</th>
<th>PHASE</th>
<th>CC CODE</th>
<th>EXPAIRED DATE</th>
<th>QUOTATION</th>
<th>PR</th>
<th>PO</th>
<th>ARRIVAL</th>
<th>VP</th>

</tr>
                                    </thead>
                                   
                                    <tbody>
                                       <?php
if(isset($_POST['cr_b']) ){	
$cmd_tbl=$_POST['cmd_tbl'];
//if($cmd_tbl=="real"){$tbl="";}else{$tbl="_temp";}
$cmd_cari=$_POST['cmd_cari'];
$txt_cari=str_replace(" ","",$_POST['txt_cari']);
if($txt_cari==""){$whr="no_ctrl is not null"; }else{
$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
$sq_acc="select * from bps_budget$cmd_tbl where $whr";
}
if(isset($_POST['smpn']) or isset($_POST['upld']) or isset($_POST['cr_b'])){
$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
$row=0;
while($baris1=odbc_fetch_array($tb_acc)){ $row++;
$expaired=odbc_result($tb_acc,"expaired");
if($cmd_tbl="_FA"){
$view_lt_vp="";$view_lt_datang="";$view_lt_po="";$view_lt_pr="";$view_lt_Quo="";

}else{
$lt_vp=Odbc_result($tb_acc,"lt_vp");
$lt_datang=odbc_result($tb_acc,"lt_datang");
$lt_po=odbc_result($tb_acc,"lt_po");
$lt_pr=odbc_result($tb_acc,"lt_pr");
$lt_Quo=odbc_result($tb_acc,"lt_Quo");
$lt_datang_cumm=$lt_datang+$lt_vp;
$lt_po_cumm=$lt_po+$lt_datang_cumm;
$lt_pr_cumm=$lt_pr+$lt_po_cumm;
$lt_Quo_cumm=$lt_Quo+$lt_pr_cumm;
$view_lt_vp="($lt_vp) ".date('Y-m-d', strtotime($expaired. " - $lt_vp days"));
$view_lt_datang="($lt_datang) ".date('Y-m-d', strtotime($expaired. " - $lt_datang_cumm days"));
$view_lt_po="($lt_po) ".date('Y-m-d', strtotime($expaired. " - $lt_po_cumm days"));
$view_lt_pr="($lt_pr) ".date('Y-m-d', strtotime($expaired. " - $lt_pr_cumm days"));
$view_lt_Quo="($lt_Quo)) ".date('Y-m-d', strtotime($expaired. " - $lt_Quo_cumm days"));
}
				?>	
				<tr  onclick="javascript:pilih(this);">
<td><?php echo odbc_result($tb_acc,"sect"); ?></td>
<td><?php echo odbc_result($tb_acc,"term"); ?></td>
<td><?php echo odbc_result($tb_acc,"jns_budget"); ?></td>
<td><?php echo odbc_result($tb_acc,"no_ctrl"); ?></td>
<td><?php echo odbc_result($tb_acc,"lp"); ?></td>
<td><?php echo odbc_result($tb_acc,"id_proses"); ?></td>
<td><?php echo odbc_result($tb_acc,"account"); ?></td>
<td><?php echo odbc_result($tb_acc,"sub_acc"); ?></td>
<td><?php echo odbc_result($tb_acc,"part_no"); ?></td>
<td><?php echo odbc_result($tb_acc,"part_desc"); ?></td>
<td><?php echo odbc_result($tb_acc,"part_dtl"); ?></td>
<td><?php echo odbc_result($tb_acc,"periode"); ?></td>
<td><?php echo odbc_result($tb_acc,"qty"); ?></td>
<td><?php echo odbc_result($tb_acc,"uom"); ?></td>
<td><?php echo odbc_result($tb_acc,"curr"); ?></td>
<td><?php echo odbc_result($tb_acc,"price"); ?></td>
<td><?php echo odbc_result($tb_acc,"phase"); ?></td>
<td><?php echo odbc_result($tb_acc,"cccode"); ?></td>
<td><?php echo date("Y-m-d",strtotime($expaired)); ?></td>
<td><?php echo $view_lt_Quo; ?></td>
<td><?php echo $view_lt_pr; ?></td>
<td><?php echo $view_lt_po; ?></td>
<td><?php echo $view_lt_datang; ?></td>
<td><?php echo $view_lt_vp; ?></td>

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
            </div></div></div>            
    </div> </div>           
 </div></div>
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
      	var kd_pel12=row.cells[12].innerHTML;
      	var kd_pel11=row.cells[11].innerHTML;
      	var kd_pel15=row.cells[15].innerHTML;
	/*	if(kd_pel2=="NORMAL"){
		document.form2.term_plan.value=kd_pel1;
		document.form2.no_ctrl_plan.value=kd_pel3;
		document.form2.periode_pln.value=kd_pel11;
		document.form2.qty_plan.value=kd_pel12;
		document.form2.price_plan.value=kd_pel15;
		document.form2.periode_add.value=kd_pel11;
		document.form2.qty_add.value=kd_pel12;
		document.form2.price_add.value=kd_pel15;
		}
		*/
 }
 </script>