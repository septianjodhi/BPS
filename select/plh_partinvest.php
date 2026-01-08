<?php
include "../koneksi.php";
?>
<div class="col-md-12">
	<div class="box box-primary">
		<section class="content-header">
			<h1>PILIH NIK PESERTA TRAINING</h1>
			
		</section> 
		<body class="hold-transition skin-blue sidebar-mini">
			<section class="content">
<!--button id="btnAddRow" type="button">  Add Row </button>
<button id="btnDelLastRow" type="button">  Delete Last Row </button>
<button id="btnDelCheckRow" type="button">  Delete Checked Row </button-->
	<div class="row">
		<div style="overflow-x:auto;">
			<table id="tblAddRow" class="table table-bordered table-striped ">
				<thead>
					<tr>
						<th>No Control</th>
						<th>Part No</th>
						<th>Desc</th>
						<th>Price</th>
						<th>Qty Plan</th>
						<th>Qty Order</th>						
						<th class='with-checkbox'><input class="flat-red" type="checkbox" name="check_all" id="check_all" onclick="dipilihALL(this.form)"></th>
					</tr>	
				</thead>
				<tbody>
					<?php
					
					$dep=$_GET['dept'];
					$pch_dep=explode("-",$dep);
					$dept=$pch_dep[0];
					$sect=$pch_dep[1];
					
					if($dept!='' ){$cr_dept=" dept='$dept' and sect='$sect' and";}else{$cr_dept="";}
					$shfX=$_GET['shf'];
					if($shfX=='ALL'){$cr_shf="";} else {$cr_shf=" shift='$shfX' and";}
					$periode=date("Ym");
					$area=$_GET['area'];
					$pch_area=explode("-",$area);
					$id_cv=$pch_area[0];
					$cln=$pch_area[1];
					$cv=$pch_area[2];
					$jbtn=$pch_area[3];
					
					if($jbtn==''){
						$cr_jbtn="";
					}else{
						$cr_jbtn=" jbtn='$jbtn' and";
					}
					
					if($cv!=''){		
						$cr_cln=" CAR_LINE='$id_cv' and FAMILY='$cln' and AREA='$cv' and";
					}else{$cr_cln="";}
	//if($pm=='I'){$shf="SH1";}else{$shf="SH2";}
	//$tgl=$_GET['tgltrn'];


					$qry="SELECT distinct NAMA,nik,dept,sect,area from v_dtlkaryawan where $cr_shf $cr_dept $cr_cln $cr_jbtn
					(periode='$periode' or periode=convert (nvarchar(6),DATEADD(d,-1,DATEADD(m, DATEDIFF(m,0,GETDATE()),0)),112)) order by nik asc";
	//echo $qry;
					$tb_part=odbc_exec($koneksi,$qry);

					$nomer=0;
					while($baris1=odbc_fetch_array($tb_part)){
						$nomer++;
						$nnk=odbc_result($tb_part,"nik");
						?>		
						<tr>
							<td><?php echo $nomer; ?></td>
							<td><?php echo $nnk; ?></td>
							<td><?php echo odbc_result($tb_part,"NAMA"); ?></td>
							<td><?php echo odbc_result($tb_part,"dept"); ?></td>
							<td><?php echo odbc_result($tb_part,"sect"); ?></td>
							<td><input class="minimal-red" type="checkbox" id="check1" name="check1" onclick="dipilih(this.form);" value="<?php echo $nnk;?>" ></td>
						</tr>	
						<?php 
					}
					
					?>	
				</tbody>
			</table>
		</div>
	</div>
</section>
</body>  
</div></div> 
<script>
	$(function () {
		$(".tabel2").DataTable();
	})
	function pilih(row){
		var kd_pel=row.cells[0].innerHTML;
		var kd_pel1=row.cells[2].innerHTML;
		document.form.nik.value += kd_pel1 + ",";
	//	row.cells[4].innerHTML="-";
		//window.opener.parent.document.getElementById("home_reg").value=kd_pel;		
		//window.opener.parent.document.getElementById("dept_reg").value=kd_pel1;
		
	}
	function dipilihALL(frm){
		var PlhData="";
		var PlhDataX="";
		for (i = 0; i < frm.check1.length; i++){
			if (frm.check_all.checked){	
				PlhData += frm.check1[i].value +",";
				
				frm.check1[i].checked = true;
			}else{
				var PlhData="";	
				frm.check1[i].checked = false;
			}				
		}
		document.form.nik.value=PlhData.replace(' ','');
	}
	function dipilih(frm){
		var PlhData="";
		for (i = 0; i < frm.check1.length; i++){
			if (frm.check1[i].checked){
				PlhData += frm.check1[i].value +",";
			}	
		}	
		document.form.nik.value=PlhData.replace(' ','');
	}	
	// Add row the table
	$('#btnAddRow').on('click', function() {
   // var lastRow = $('#tblAddRow tbody tr:last').html();
   var lenRow = $('#tblAddRow tbody tr').length;
   var nikadd=document.form.add_nik.value ;
   var lastRow='<td>' + (parseInt(lenRow)+1) + '</td><td>add</td><td>' + nikadd + '</td><td><input type="text" value=' + document.form.add_nik.value + ' ></td><td></td><td><input class="minimal-red" type="checkbox" id="check1" name="check1" onclick="dipilih(this.form);" value="' +  nikadd + '" ></td>' ;
    //alert(lastRow);
    $('#tblAddRow tbody').append('<tr>' + lastRow + '</tr>');
    $('#tblAddRow tbody tr:last input').val('');
});
	$('#btnDelLastRow').on('click', function() {
		var lenRow = $('#tblAddRow tbody tr').length;
    //alert(lenRow);
    if (lenRow == 1 || lenRow <= 1) {
    	alert("Can't remove all row!");
    } else {
    	$('#tblAddRow tbody tr:last').remove();
    }
});
// Delete selected checkbox in the table
$('#btnDelCheckRow').click(function() {
	var lenRow		= $('#tblAddRow tbody tr').length;
	var lenChecked	= $("#tblAddRow input[type='checkbox']:checked").length;
	var row	= $("#tblAddRow tbody input[type='checkbox']:checked").parent().parent();
    //alert(lenRow + ' - ' + lenChecked);
    if (lenRow == 1 || lenRow <= 1 || lenChecked >= lenRow) {
    	alert("Can't remove all row!");
    } else {
    	row.remove();
    }
});
</script>