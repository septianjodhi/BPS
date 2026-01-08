
		<?php $sect= $_SESSION["area"]; ?>	 

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

<div id="inpt"></div>	 
<div class="row clearfix">
<div class="card">
<div class="row clearfix">				
<div class="header">
<h2>Record Additional Budget<small>Cari Additional Budget</small></h2>
</div>
<div class="body">
<form action="" id="frmcari" method="post"  enctype="multipart/form-data">
<div class="col-sm-3">	
<div class="form-group">
<!--label>Kolom</label-->
<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
<option selected="selected" value="">---Pilih Kolom---</option>
<option value="bps_budget.sect">SECTION</option>
<option value="bps_budget.term">TERM</option>
<option value="bps_budget.no_ctrl">CONTROL NO</option>
<option value="bps_budget.lp">PURCHASING</option>
<option value="bps_budget.id_proses">KODE PROSES</option>
<option value="bps_budget.account">ACCOUNT</option>
<option value="bps_budget.sub_acc">SUB ACCOUNT</option>
<option value="bps_budget.part_no">PART NO</option>
<option value="bps_budget.part_nm">PART NAME</option>
<option value="bps_budget.part_dtl">DETAIL PART</option>
<option value="bps_budget.periode">PERIODE</option>
<option value="bps_budget.phase">PHASE</option>
<option value="bps_budget_add.no_ctrl_add">CONTROL NO ADD</option>
<option value="bps_budget_add.Periode">PERIODE</option>
<option value="bps_budget_add.ket_chg">KETERANGAN ADD</option>
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
</div></div>	

<div class="row clearfix">
<div class="body">
<div class="table-responsive">
<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
<thead>
<tr>
<th>PR NO</th>	
<th>TERM</th>
<th>PERIODE</th>
<th>CONTROL NO PLAN</th>
<th>CONTROL NO ADD</th>
<th>PART NO</th>
<th>PART NAME</th>
<th>DETAIL PART</th>
<th>DESCRIPTION PART</th>
<th>QTY PLAN</th>
<th>QTY ADD</th>
<th>UOM</th>
<th>PRICE PLAN</th>
<th>PRICE ADD</th>
<th>KET ADD</th>
<th>STATUS ADD</th>
<th>PRINT FORM</th>

</tr>
</thead>
 <tbody>
<?php
if(isset($_POST['cr_b']) ){	
//$cmd_tbl=$_POST['cmd_tbl'];
//if($cmd_tbl=="real"){$tbl="";}else{$tbl="_temp";}
$cmd_cari=$_POST['cmd_cari'];
$txt_cari=str_replace(" ","",$_POST['txt_cari']);
if($txt_cari==""){$whr="bps_budget_add.no_ctrl is not null"; }else{
$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}

$sq_acc="select bps_pr.pr_no,bps_budget.term,bps_budget.no_ctrl,bps_budget.part_no,bps_budget.part_nm,bps_budget.part_desc,bps_budget.part_dtl,bps_budget.uom,bps_budget.QTY,bps_budget.price,bps_budget_add.periode,bps_budget_add.no_ctrl_add,bps_budget_add.qty as qty_add,bps_budget_add.price as price_add,bps_budget_add.ket_chg,bps_budget_add.status from bps_budget inner join bps_budget_add on bps_budget.no_ctrl=bps_budget_add.no_ctrl inner join bps_pr on bps_budget.no_ctrl=bps_pr.no_ctrl where bps_budget.sect='$sect' and $whr";

//$sq_acc="select b.term,b.periode,a.no_ctrl,a.part_no,a.part_nm,a.part_desc,a.part_dtl,a.uom,a.QTY,a.price,b.no_ctrl_add,b.qty as qty_add,b.price as price_add,b.ket_chg,b.status from bps_budget a inner join bps_budget_add b on a.no_ctrl=b.no_ctrl";

//$sq_acc="select*from bps_budget_add";

$tb_acc=odbc_exec($koneksi_lp,$sq_acc); 
$row=0;
$opsi_del="";
//echo $sq_acc;
while($baris1=odbc_fetch_array($tb_acc)){ $row++;
$prno=odbc_result($tb_acc,"pr_no");
$add_ctrl= odbc_result($tb_acc,"no_ctrl_add");
$add_stts=odbc_result($tb_acc,"status");
if($add_stts="OPEN"){$opsi_del=$opsi_del.'<option value="'.$add_ctrl.'">'.$add_ctrl.'</option>';}
?>	
<tr  onclick="javascript:pilih(this);">
<td><div class="form-line">
<input type="text" readonly name="prno1[]" id="prno1" value="<?php echo $prno; ?>" class="form-control"  required></div></td>
<td><?php echo odbc_result($tb_acc,"term"); ?></td>
<td><?php echo odbc_result($tb_acc,"periode"); ?></td>
<td><?php echo odbc_result($tb_acc,"no_ctrl"); ?></td>
<td><?php echo $add_ctrl; ?></td>
<td><?php echo odbc_result($tb_acc,"part_no"); ?></td>
<td><?php echo odbc_result($tb_acc,"part_nm"); ?></td>
<td><?php echo odbc_result($tb_acc,"part_dtl"); ?></td>
<td><?php echo odbc_result($tb_acc,"part_desc"); ?></td>
<td><?php echo odbc_result($tb_acc,"qty"); ?></td>
<td><?php echo odbc_result($tb_acc,"qty_add"); ?></td>
<td><?php echo odbc_result($tb_acc,"uom"); ?></td>
<td><?php echo odbc_result($tb_acc,"price"); ?></td>
<td><?php echo odbc_result($tb_acc,"price_add"); ?></td>
<td><?php echo odbc_result($tb_acc,"ket_chg"); ?></td>
<td><?php echo $add_stts; ?></td>
<td>
<button type="button" id="ctk_add_bdgt" name="ctk_add_bdgt" class="btn bg-orange waves-effect" onclick="open_child('Exp_pdf/print_add_bud.php?nomor=<?php echo $row;?>&nopr=<?php echo $prno;?>','Print PR <?php echo $prno;?>','800','500'); return false;"><i class="material-icons">printer</i>ADDITIONAL</button>
<button type="button" class="btn bg-green waves-effect" onclick="open_child('Exp_pdf/print_pr.php?nomor=<?php echo $row;?>&nopr=<?php echo $prno;?>','Print PR <?php echo $prno;?>','800','500'); return false;"><i class="material-icons">print</i>PR</button></td>
 
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
</div></div>   
</div>

</section>
			