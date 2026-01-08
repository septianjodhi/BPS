<div class="row clearfix">
<div class="card">
 <div class="block-header"><h2>Section</h2></div>
 <div class="container-fluid">
 <?php
 $bases=$_SESSION['Bases'];
$sect=$_GET['sect'];	
$term=$_GET['term'];	
//$periode=$_GET['periode'];
	 $sql1="select distinct no_ctrl,part_desc,periode,sum(qty) as qty,dbo.cek_noctrl(no_ctrl) as ceknoctrl,dbo.cek_Qtybud('$sect','$term',periode,part_desc,'No') as cek_Qty,dbo.cek_Qtybud('$sect','$term',periode,part_desc,'Yes') as cek_Amount from bps_budget_temp where sect='$sect' and term='$term' and dbo.cek_noctrl(no_ctrl)<>'Blank' group by no_ctrl,part_desc,periode";
	 echo $sql1;
 ?>
	
<form id="form0" name="form0" enctype="multipart/form-data"  method="post">

<table class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
    <thead>
        <tr>
<th><div class="switch"><label><input type="checkbox" name="checkall1" id="checkall1" onclick="dipilihALL(this.form)"><span class="lever switch-col-GREEN"></span></label></div></th>
<th>Ctrl No</th>
<th>Part Name</th>
<th>Qty</th>
<th>Cek No Ctrl</th>
<th>Cek Qty</th>
<th>Cek Amount</th>
<th>Keterangan</th>
			
        </tr>
    </thead>
    <tbody>
<!--        data ini bisa di loop dari database-->
<?php
	$tb_area=odbc_exec($koneksi_lp,$sql1);
$row=0;$psn="";$chk="user:no Act";$chek="";
while($baris1=odbc_fetch_array($tb_area)){ $row++;$psn="";
$no_ctrl=odbc_result($tb_area,"no_ctrl");
$ceknoctrl= odbc_result($tb_area,"ceknoctrl");
$cek_Qty=odbc_result($tb_area,"cek_Qty");
$cek_Amount=odbc_result($tb_area,"cek_Amount");
if($ceknoctrl="Blank"){$psn=$psn."Approval Oleh FA";$chk="adminFA:$no_ctrl";}
else{
	if($cek_Qty>0 or $cek_Amount>0){$psn="Qty atau Amount lebih dari Plan";$chk="user:no Act";}
	else{$chk="user:$no_ctrl";$chek="checked";}
}
?>
        <tr onclick="javascript:pilih(this);">
	<!--td><input for="checkbox" name="check1[]" id="check1" type="checkbox" /><label  for="checkbox" /></td-->
		<td><div class="switch"><label><input type="checkbox" name="check1[]" id="check1"  value="<?php echo $chk;?>" <?php echo $chek;?>><span class="lever switch-col-GREEN"></span></label></div></td>
			<td><?php echo $no_ctrl;?></td>
            <td><?php echo odbc_result($tb_area,"part_desc");?></td>	
            <td><?php echo odbc_result($tb_area,"qty");?></td>	
            <td><?php echo $ceknoctrl; ?></td>	
            <td><?php echo $cek_Qty;?></td>		
            <td><?php echo $cek_Amount;?></td>	
            <td><?php echo $psn; ?></td>	
        </tr>
		<?php } ?>      
    </tbody>
</table>
</form>
</div></div></div>
<div class="row clearfix">
<div class="card">
 <div class="block-header"><h2>Finance</h2></div>
 <div class="container-fluid">
 <?php
//$sect=$_GET['sect'];	
//$term=$_GET['term'];	
//$periode=$_GET['periode'];
	 $sql1="select distinct no_ctrl,part_desc,periode,sum(qty) as qty,dbo.cek_noctrl(no_ctrl) as ceknoctrl,dbo.cek_Qtybud('$sect','$term',periode,part_desc,'No') as cek_Qty,dbo.cek_Qtybud('$sect','$term',periode,part_desc,'Yes') as cek_Amount from bps_budget_temp where sect='$sect' and term='$term'  and dbo.cek_noctrl(no_ctrl)='Blank' group by no_ctrl,part_desc,periode";
	 //echo $sql1;
 ?>
	
<form id="form1" name="form1" enctype="multipart/form-data"  method="post">

<table class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
    <thead>
        <tr>

<th>Ctrl No</th>
<th>Part Name</th>
<th>Qty</th>
<th>Cek No Ctrl</th>
<th>Cek Qty</th>
<th>Cek Amount</th>
<th>Keterangan</th>
			
        </tr>
    </thead>
    <tbody>
<!--        data ini bisa di loop dari database-->
<?php
	$tb_area=odbc_exec($koneksi_lp,$sql1);
$row=0;$psn="";$chk="user:no Act";$chek="";
while($baris1=odbc_fetch_array($tb_area)){ $row++;$psn="";
$no_ctrl=odbc_result($tb_area,"no_ctrl");
$ceknoctrl= odbc_result($tb_area,"ceknoctrl");
$cek_Qty=odbc_result($tb_area,"cek_Qty");
$cek_Amount=odbc_result($tb_area,"cek_Amount");
if($ceknoctrl="Blank"){$psn=$psn."Approval Oleh FA";$chk="admin:$no_ctrl";}
else{
	if($cek_Qty>0 or $cek_Amount>0){$psn="Qty atau Amount lebih dari Plan";$chk="user:no Act";}
	else{$chk="user:$no_ctrl";$chek="checked";}
}
?>
        <tr onclick="javascript:pilih(this);">
			<td><?php echo $no_ctrl;?></td>
            <td><?php echo odbc_result($tb_area,"part_desc");?></td>	
            <td><?php echo odbc_result($tb_area,"qty");?></td>	
            <td><?php echo $ceknoctrl; ?></td>	
            <td><?php echo $cek_Qty;?></td>		
            <td><?php echo $cek_Amount;?></td>	
            <td><?php echo $psn; ?></td>	
        </tr>
		<?php } ?>      
    </tbody>
</table>
</form>
</div></div></div>
<script>
function dipilihALL(frm){
	var jmck=<?php echo $row; ?>;
	var Bases=<?php echo $Bases; ?>;
	var dtldata="-:-";
	var sec="";
	//alert(jmck);
	if(jmck==1){
		dtldata=frm.check1[0].value;
		sec=dtldata.split(":");
		if(sec[0]!="admin"){frm.check1[0].checked=true;}
	}else{
	 for (i = 0; i < jmck; i++){
		dtldata=frm.check1[i].value;
		sec=dtldata.split(":");
		if(sec[0]!="admin"){frm.check1[i].checked=true;}
		// alert(sec[0]);
	 }
	}
}
    function pilih(row){
      	var kd_pel=row.cells[0].innerHTML;
		var kd_pel1=row.cells[1].innerHTML;
	//	window.opener.parent.document.getElementById("part_no").value = kd_pel;
	//	window.opener.parent.document.getElementById("part_desc").value =kd_pel1;
     //   window.close();
    }
</script>