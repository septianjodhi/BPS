<script>
   $(document).ready(function() {
$("#tombol").hide();
$("#adqty").hide();
$("#adprice").hide();
$("#adperiod").hide();
$("#aditem").hide();
   });
function pil_add(){
var chgadd=document.form2.add_cr.value;
var term_cr=document.form2.term_cr.value;
var periode_cr=document.form2.periode_cr.value;
var no_ctrl_cr=document.form2.no_ctrl_cr.value;
if(chgadd=="" || term_cr=="" || periode_cr=="" || no_ctrl_cr==""){
	alert("DATA BELUM LENGKAP");
	else{
$("#inpt").empty();
$("#inpt").load('form/inpt_budadd_item.php');
	}
	
};
function perubahan(){
		var chgadd=document.form2.add.value;
		var qty_plan=document.form2.qty_plan.value;
		var qty_add=document.form2.qty_add.value;
		var price_plan=document.form2.price_plan.value;
		var price_add=document.form2.price_add.value;
		var periode_plan=document.form2.periode_plan.value;
		var periode_add=document.form2.periode_add.value;
		var no_ctrl_add=document.form2.no_ctrl_add.value;
		var pernow = new Date();
	 var nperi=pernow.getFullYear()+''+("0"+(pernow.getMonth()+1)).slice(-2);
	 var balp=parseInt( periode_add)-parseInt(nperi);
	 
		var text;
if(no_ctrl_add==""){alert("NO CONTROL BELUM DI PILIH");
	document.form2.add.value="";
	text = "GAGAL DI RUBAH";}else{	
	text = "BERHASIL DI RUBAH";
	$("#tombol").show();
switch(chgadd) {
  case "1":
  if(qty_plan=="" || qty_add=="" || qry_add<=0){
    text = "QTY ADDITIONAL HARUS DIISI LEBIH DARI 0";
	//document.form2.add.value="";
$("#adqty").show();
$("#tombol").show();
$("#adprice").hide();
$("#adperiod").hide();
$("#aditem").hide();
  };
    break;
  case "2":   
  if(price_plan=="" || price_add=="" || price_add<=0){
    text = "PRICE ADDITIONAL HARUS DIISI LEBIH DARI 0";
	document.form2.add.value="";
  };
    break;
  case "3":
   if(price_plan=="" || price_add=="" || price_add<=0 || qty_plan=="" || qty_add=="" || qry_add<=0){
    text = "PRICE DAN QTY ADDITIONAL MASING-MASING HARUS DIISI LEBIH DARI 0";
	document.form2.add.value="";
  };
    break;
  case "4":       
  if(balp<0){
    text = "PERIODE TIDAK BOLEH LEBIH KECIL DARI BULAN INI";
	document.form2.add.value="";
  };
    break;
  default:
    text = "blank";
	document.form2.add.value="";
}
alert(text);
}

	}  ;
	
 </script>
<script type="text/javascript">

function open_child(url,title,w,h){
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
        status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
        width='+w+',height='+h+',top='+top+',left='+left);
		
  };	
  	
	function cr_nm(url,title,w,h){
	  var nik=document.form1.account.value;
	  var pno=document.form1.term.value;
	  var pnd=document.form1.periode.value;
	  var pernow = new Date();
	 var nperi=pernow.getFullYear()+''+("0"+(pernow.getMonth()+1)).slice(-2);
	 var balp=parseInt(pnd)-parseInt(nperi);
	 // alert(balp);
	  if(pno=="" || balp<0){alert("Term Belum dipilih Atau Periode Kurang dari Bulan Sekarang");}else{
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        w = window.open(url+'&ac='+nik, title, 'toolbar=no, location=no, directories=no, \n\
        status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
        width='+w+',height='+h+',top='+top+',left='+left);		
	  }
  };
	function cr_part(url,title,w,h){
	  var pno=document.form1.part_no.value;
	  var pnd=document.form1.part_desc.value;
	  var pri=document.form1.periode.value;
	  if(pri==""){alert("Periode Belum Diisi");}else{
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        w = window.open(url+'&pno='+pno+'&pnd='+pnd+'&p='+pri, title, 'toolbar=no, location=no, directories=no, \n\
        status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
        width='+w+',height='+h+',top='+top+',left='+left);	
	  }		
  };
  
  
 function cekctrl2(url,title,w,h){
	  var pno=document.form1.term.value;
	  var pnd=document.form1.periode.value;
	  var pernow = new Date();
	 var nperi=pernow.getFullYear()+''+("0"+(pernow.getMonth()+1)).slice(-2);
	 var balp=parseInt(pnd)-parseInt(nperi);
	//  alert(balp);
	  if(pno=="" || balp<0){alert("Term-Section Belum dipilih Atau Periode Kurang dari Bulan Sekarang");}else{
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        w = window.open(url+'&t='+pno+'&p='+pnd, title, 'toolbar=no, location=no, directories=no, \n\
        status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
        width='+w+',height='+h+',top='+top+',left='+left);		
	  };}; 
 function cekctrl3(url,title,w,h){
	  var pno=document.form2.term.value;
	  var pnd=document.form2.periode_plan.value;
	  var pernow = new Date();
	 var nperi=pernow.getFullYear()+''+("0"+(pernow.getMonth()+1)).slice(-2);
	 var balp=parseInt(pnd)-parseInt(nperi);
	//  alert(balp);
	  if(pno=="" || balp<0){alert("Term-Section Belum dipilih Atau Periode Kurang dari Bulan Sekarang");}else{
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        w = window.open(url+'&t='+pno+'&p='+pnd, title, 'toolbar=no, location=no, directories=no, \n\
        status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
        width='+w+',height='+h+',top='+top+',left='+left);		
	  }; };
	
	  
</script>	  
 <section class="content">
 <div class="container-fluid">
	<div class="block-header">
                <h2>ADDITIONAL BUDGET</h2>
    </div>
		<?php $sect= $_SESSION["Areaa"]; ?>	 
<div class="row clearfix">
    <div class="card">
		<div class="header">
             <h2>ADDITIONAL<small>Menambahkan Budget Karena Quantity,Price dan Periode</small></h2>
                <ul class="header-dropdown m-r--5">
                 <li class="dropdown">
                 <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                 <i class="material-icons">more_vert</i>
                 </a>
                 <ul class="dropdown-menu pull-right">
                  <li><a href="javascript:void(0);">Action</a></li>
                  </ul>
                  </li> </ul>
        </div>

		<form role="form" enctype="multipart/form-data" name="form2" id="form2" method="post" action="">
		<div class="body">
		<div class="col-lg-12">
		<div class="col-md-2">			
			<div class="form-group">
				<label>Term</label>
				 <div class="input-group">
				 <select class="selectpicker" data-live-search="true" style="width: 100%;"  name="term_cr" id="term_cr" required>
				<option selected="selected" value="">-Pilih Term-</option>
				 <?php 
				 $tb_term=odbc_exec($koneksi_lp,"select distinct term from bps_setterm where start_prepaire<=getdate() and finish_term >=getdate() order by term desc");
				 while($bar_term=odbc_fetch_array($tb_term)){
					 $opt_trm=odbc_result($tb_term,"term");
					 $opt_term='<option value="'.$opt_trm.'">TERM '.$opt_trm.'</option>';
				 }
				 echo $opt_term;
				 ?>
				</select>
			</div></div>
		</div>
		<div class="col-md-2">
                <div class="form-group">
				<label>Periode Plan</label>
                <div class="input-group">
					<input type="number" readonly class="periodemn bg-yellow form-control" id="periode_cr" name="periode_cr" value="<?php echo date("Ym"); ?>" placeholder="Periode Plan" required>
					
			</div></div></div>
			<div class="col-md-4">
			<div class="form-group">
				<label>No Control Add</label>
				 <div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="form-control" id="no_ctrl_cr" name="no_ctrl_cr" placeholder="No Contro" required>
				</div>
				 <span class="input-group-addon">
                      <button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl3('template.php?plh=select/cek_noctrl.php&o=no_ctrl_add&k=Additional&s=<?php echo $sect; ?>','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>				
            </div></div></div>
			
			<div class="col-md-2">
			<div class="form-group">
				<label>Perubahan</label>
				<div class="input-group">
				<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="add_cr" id="add_cr" onchange="pil_add()" required>
				<option selected="selected" value="">-Pilih Perubahan-</option>
				<option value="1">QTY ONLY</option>
				<option value="2">PRICE ONLY</option>
				<option value="3">QTY AND PRICE</option>
				<option value="4">PERIODE</option>
				</select>
			</div></div> </div>
		</div>
		<div class="col-lg-12">	
			<div class="col-md-2">		
			<div class="form-group">
				<label>No Control Plan</label>
				 <div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="bg-yellow form-control" id="no_ctrl_plan" name="no_ctrl_plan" placeholder="No Contro" required>
				</div>
				
				 <span class="input-group-addon">
                      <button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl3('template.php?plh=select/budtoadd.php&s=<?php echo $sect; ?>','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
				</span>								
            </div></div>			
		</div>	
			
		 <div class="col-md-2">	
                <div class="form-group">
				<label>QTY Plan</label>
				<div class="form-line">
					<input type="number" readonly class="bg-yellow form-control" id="qty_plan" name="qty_plan" placeholder="QTY Plan" required>
				</div>
                </div>	
			</div>
		<div class="col-md-2">
                <div class="form-group">
				<label>Price Plan</label>
				<div class="form-line">
					<input type="number" readonly class="bg-yellow form-control" id="price_plan" name="price_plan" placeholder="Price plan" required>
				</div>
                </div></div>
			<div class="col-md-2">
                <div class="form-group">
				<label>QTY Add</label>
				<div class="form-line">
				<div id="adqty">	<input type="number" class="form-control" id="qty_add" name="qty_add" placeholder="QTY Add" required>
				</div></div>
                </div></div>
			<div id="adprice"><div class="col-md-2"> 
                <div class="form-group">
				<label>Price Add</label>
				<div class="form-line">
					<input type="number" class="form-control" id="price_add" name="price_add" placeholder="Price Add" required>
				</div></div>
                </div>	</div>
			<div id="adperiod"><div class="col-md-2">
                <div class="form-group">
				<label>Periode Add</label>
				<div class="form-line">
					<input type="number" readonly class="periode form-control" id="periode_add" name="periode_add" value="<?php echo date("Ym"); ?>" placeholder="Periode Add" required>
				</div></div></div></div>
				
        </div>
		<div class="row clearfix">		
		<div id="tombol"> 
          <button type="submit" id="smpn_add" name="smpn_add" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
          <button type="reset" id="reset" name="reset" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Clear</button>
            
		</div> </div> 
		  </div></div>
		</form>	                   
	</div>
	 <div id="inpt"><div>
<?php
if(isset($_POST['smpn_add']) ){
$term_plan=$_POST['term_plan'];
$add=$_POST['add'];
$periode_pln=$_POST['periode_plan'];
$periode_add=$_POST['periode_add'];
$no_ctrl_plan=$_POST['no_ctrl_plan'];
$no_ctrl_add=$_POST['no_ctrl_add'];
$qty_plan=$_POST['qty_plan'];
$qty_add=$_POST['qty_add'];
$price_plan=$_POST['price_plan'];
$price_add=$_POST['price_add'];
$experied=date("Y-m-d",strtotime($periode_add."28"));
$pic_updt=$_SESSION['nama'];
if($add=="1"){$qry_add="insert into bps_budget_add(no_ctrl,no_ctrl_add,periode,qty,price,kode_chg,ket_chg,status,pic_updt,tgl_updt) values('$no_ctrl_plan','$no_ctrl_add','$periode_pln','$qty_add','$price_plan','$add','QTY ONLY','OPEN','$pic_updt',getdate())";}
elseif($add=="2"){$qry_add="insert into bps_budget_add(no_ctrl,no_ctrl_add,periode,qty,price,kode_chg,ket_chg,status,pic_updt,tgl_updt) values('$no_ctrl_plan','$no_ctrl_add','$periode_pln','$qty_plan','$price_add','$add','PICE ONLY','OPEN','$pic_updt',getdate())";}
elseif($add=="3"){$qry_add="insert into bps_budget_add(no_ctrl,no_ctrl_add,periode,qty,price,kode_chg,ket_chg,status,pic_updt,tgl_updt) values('$no_ctrl_plan','$no_ctrl_add','$periode_pln','$qty_add','$price_add','$add','QTY AND PRICE','OPEN','$pic_updt',getdate())";}
elseif($add=="4"){$qry_add="insert into bps_budget_add(no_ctrl,no_ctrl_add,periode,qty,price,kode_chg,ket_chg,status,pic_updt,tgl_updt) values('$no_ctrl_plan','$no_ctrl_add','$periode_add','$qty_plan','$price_plan','$add','PERIODE','OPEN','$pic_updt',getdate())";}

$tb_deladd = odbc_exec($koneksi_lp, "delete from bps_budget_add where no_ctrl_add='$no_ctrl_add'");	
$tb_add = odbc_exec($koneksi_lp,$qry_add);
//echo "<br>lht ".$i.$sql_updt;
$sq_acc="select bps_budget.term,bps_budget.no_ctrl,bps_budget.part_no,bps_budget.part_nm,bps_budget.part_desc,bps_budget.part_dtl,bps_budget.uom,bps_budget.QTY,bps_budget.price,bps_budget_add.periode,bps_budget_add.no_ctrl_add,bps_budget_add.qty as qty_add,bps_budget_add.price as price_add,bps_budget_add.ket_chg,bps_budget_add.status from bps_budget inner join bps_budget_add on bps_budget.no_ctrl=bps_budget_add.no_ctrl where bps_budget.sect='$sect' and bps_budget_add.no_ctrl_add='$no_ctrl_add'";
	
}
?>	
<div id="aditem">
	<div class="row clearfix">
    <div class="card">
		<div class="header">
             <h2>ADDITIONAL ITEM<small>Penambahan Budget Untuk Item Baru</small></h2>
        </div>
		<div class="body">
		 <form role="form"  name="form1" id="form1" method="post" action="">
        <div class="col-lg-12">
		<div class="col-md-3">	
			<div class="col-md-6">
            <div class="form-group">
				<label>Term</label>
				<div class="input-group">
				<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="term" id="term"  required>
				<option selected="selected" value="">---Term---</option>
				<?php
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
				</div>
                </div>
			</div>
			
			<div class="form-group">
				<label>Account</label>
				 <div class="input-group">
                    <div class="form-line">
                     <input type="text" class="form-control" id="account" name="account" placeholder="Account" required>
                     </div>
                    <span class="input-group-addon">
                     <button type="button" class="btn bg-purple waves-effect"  onclick="cr_nm('template.php?plh=select/plh_acc.php&acc=account','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
                                        
                  </div>
			</div>
                <div class="form-group">
				<label>Sub Account</label>
				<div class="input-group">
                    <div class="form-line">
                     <input type="text" readonly class="form-control" style="background: yellow;" id="sub_acc" name="sub_acc" placeholder="Sub Account" required>
                     </div>
                    <span class="input-group-addon">
                     <button type="button" class="btn bg-purple waves-effect"  onclick="cr_nm('template.php?plh=select/plh_acc.php&acc=sub_acc','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
                                        
                  </div>
                </div>	 
				<div class="form-group">
				<label>Kode Proses</label>
				<div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="form-control" id="id_proses" name="id_proses" placeholder="Kode Proses" required>
				</div> <span class="input-group-addon">
                     <button type="button" class="btn bg-purple waves-effect"  onclick="open_child('template.php?plh=select/plh_pros.php','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
                </div></div>
		</div>
        
        <div class="col-md-3">	
                <div class="form-group">
				<label>Nama Part</label>
				 <div class="input-group">
				<div class="form-line">
					<input type="text" class="form-control" id="part_nm" name="part_nm"  placeholder="Nama Part" required>
				</div>
                    <span class="input-group-addon">
                     <button type="button" class="btn bg-purple waves-effect"  onclick="cr_part('template.php?plh=select/plh_partbud.php','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
                </div></div>
                <div class="form-group">
				<label>Part No</label>
				<div class="form-line">
					<input type="text" readonly class="form-control" style="background: yellow;" id="part_no" name="part_no" placeholder="Part No" required>
				</div>
                </div>
                <div class="form-group">
				<label>Detail Part</label>
				<div class="form-line">
					<input type="text" readonly class="form-control" style="background: yellow;" id="part_dtl" name="part_dtl" placeholder="Detail Part" required>
				</div>
                </div>
                <div class="form-group">
				<label>Remark Part</label>
				<div class="form-line">
					<input type="text" class="form-control" id="part_desc" name="part_desc" placeholder="Remark Part">
				</div>
                </div>
		</div>
		 <div class="col-md-3">
            <div class="form-group">
				<label>Purchasing</label>
				<div class="input-group">
				<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="lp" id="lp"  required>
				<option selected="selected" value="">-Pilih Purchasing-</option>
				<option value="GA">GA</option>
				<option value="MTP">MTP</option>
				<option value="LD">LD</option>
				<option value="MPC">MPC</option>
				</select>
			</div>
			</div>
                <div class="form-group">
				<label>No Control</label>
				  <div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="form-control" style="background: yellow;" id="no_ctrl" name="no_ctrl" placeholder="No Contro" required>
				</div>
                   <span class="input-group-addon">
                      <button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl2('template.php?plh=select/cek_noctrl.php&o=no_ctrl&k=Additional&s=<?php echo $sect; ?>','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>	
                </div>
                </div>	
				<div class="col-md-6">
                <div class="form-group">
				<label>Qty</label>
				<div class="form-line">
					<input type="number" class="form-control" id="qty" name="qty" placeholder="Qty" required>
				</div>
                </div></div>
				<div class="col-md-6">
                <div class="form-group">
				<label>UOM</label>
				<div class="form-line">
					<input type="text" readonly class="form-control" style="background: yellow;"  id="uom" name="uom" placeholder="Uom" required>
				</div>
                </div></div>
				<div class="col-md-6">
                <div class="form-group">
				<label>Currency</label>
				<div class="form-line">
					<input type="text" readonly class="form-control" style="background: yellow;"  id="curr" name="curr" placeholder="Currency" required>
				</div>
                </div></div>	
				<div class="col-md-6">
                <div class="form-group">
				<label>Price</label>
				<div class="form-line">
					<input type="number" class="form-control" id="price" name="price" placeholder="Price" required>
				</div>
                </div></div>
               
		 </div>
		 <div class="col-md-3">
                <div class="form-group">
				<label>Cost Center</label>
				  <div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="form-control" style="background: yellow;" id="cccode" name="cccode" placeholder="Cost Center" required>
				</div>
                    <span class="input-group-addon">
                     <button type="button" class="btn bg-purple waves-effect"  onclick="open_child('template.php?plh=select/plh_cccode.php&o=cccode&k=1','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
                </div>
                </div>
                <!--div class="form-group">
				<label>Cv Code</label>
					<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cvcode" id="cvcode"  required>
				<option selected="selected" value="">---CV Code--</option>
				<?php
			/*	$qcccode="select distinct cost_center_code,cv_code,cv_desc from lp_cv order by cost_center_code";
				$tb_cccode=odbc_exec($koneksi_lp,$qcccode);
				while($bar_qcccode=odbc_fetch_array($tb_cccode)){
				$dt_cv_code=odbc_result($tb_cccode,"cv_code");
				$dt_cv_desc=odbc_result($tb_cccode,"cv_desc");
				$dt_cccode=odbc_result($tb_cccode,"cost_center_code");
				echo '<option value="'.$dt_cv_code.'">'.$dt_cv_code.'='.$dt_cv_desc.'</option>';
				}				
			*/	?>
				</select>
                </div-->
				<div class="col-md-6">	
                <div class="form-group">
				<label>Phase</label>
				<div class="input-group">
					<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="phase" id="phase"  required>
				<option selected="selected" value="">---Pilih Phase---</option>
				<?php
				$qphase="select distinct phase from bps_phase";
				$tb_phase=odbc_exec($koneksi_lp,$qphase);
				while($bar_qphase=odbc_fetch_array($tb_phase)){
				$dt_phase=odbc_result($tb_phase,"phase");
				echo '<option value="'.$dt_phase.'">'.$dt_phase.'</option>';
				}				
				?>
				</select>
                </div></div>
				</div>
				<div class="col-md-6">	
                <div class="form-group">
				<label>LT Penawaran</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_Quo" name="lt_Quo" min="0" value="0" placeholder="LT Penawaran" required>
				</div></div>
                </div>
				<div class="col-md-6">	
                <div class="form-group">
				<label>LT PR</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_pr" name="lt_pr" min="0" value="0" placeholder="LT PR" required>
				</div>
                </div>	</div>
				<div class="col-md-6">
                <div class="form-group">
				<label>LT PO</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_po" name="lt_po" min="0" value="0" placeholder="LT PO" required>
				</div>
                </div>	</div>
				<div class="col-md-6">	
                <div class="form-group">
				<label>Kedatangan</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_datang" name="lt_datang"  min="0" value="0" placeholder="LT Kedatangan" required>
				</div>
                </div>	</div>
				<div class="col-md-6">
                <div class="form-group">
				<label>LT VP</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_vp" name="lt_vp" min="0" value="0" placeholder="LT VP" required>
				</div>
                </div></div>
		 
		 </div>
				
		</div>
		<div class="row clearfix">		 
          <button type="submit" id="smpn_item" name="smpn_item" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
          <button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>
            
		</div>  
		</form>
        </div></div>	                   
     </div></div>
<?php
if(isset($_POST['smpn_item'])){	
//$sect=$_POST['sect'];
$term=$_POST['term'];
$jns_budget="ADDITIONAL";//$_POST['jns_bud'];
$pic_updt=$_SESSION['nama'];
//$tgl_updt=$_POST['tgl_updt']
$no_ctrl=$_POST['no_ctrl'];
$lp=$_POST['lp'];
$id_proses=$_POST['id_proses'];
$account=$_POST['account'];
$sub_acc=$_POST['sub_acc'];
$part_no=$_POST['part_no'];
$part_nm=$_POST['part_nm'];
$part_dtl=$_POST['part_dtl'];
$part_desc=$_POST['part_desc'];
$periode=$_POST['periode'];
//$cvcode=$_POST['cvcode'];
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

$qry_del=" where no_ctrl='$no_ctrl'";
$qry_add="insert into bps_budget(sect,term,jns_budget,pic_updt,tgl_updt,expaired,no_ctrl,lp,id_proses,account,sub_acc,part_no,part_nm,part_desc,part_dtl,periode,qty,uom,price,curr,cccode,phase,lt_Quo,lt_pr,lt_po,lt_datang,lt_vp) values('$sect','$term','$jns_budget','$pic_updt',getdate(),'$expaired','$no_ctrl','$lp','$id_proses','$account','$sub_acc','$part_no','$part_nm','$part_desc','$part_dtl','$periode','$qty','$uom','$price','$curr','$cccode','$phase','$lt_Quo','$lt_pr','$lt_po','$lt_datang','$lt_vp')";
$qry_add_add="insert into bps_budget_add(no_ctrl,no_ctrl_add,periode,qty,price,kode_chg,ket_chg,status,pic_updt,tgl_updt) values('$no_ctrl','$no_ctrl','$periode','$qty','$price','5','NEW ITEM','OPEN','$pic_updt',getdate())";
$tb_del=odbc_exec($koneksi_lp,"delete from bps_budget where no_ctrl='$no_ctrl'");
$tb_delFA=odbc_exec($koneksi_lp,"delete from bps_budget_add where no_ctrl_add='$no_ctrl'");

$tb_add=odbc_exec($koneksi_lp,$qry_add);
$tb_addFA=odbc_exec($koneksi_lp,$qry_add_add);
$sq_acc="select bps_budget.term,bps_budget.no_ctrl,bps_budget.part_no,bps_budget.part_nm,bps_budget.part_desc,bps_budget.part_dtl,bps_budget.uom,bps_budget.QTY,bps_budget.price,bps_budget_add.periode,bps_budget_add.no_ctrl_add,bps_budget_add.qty as qty_add,bps_budget_add.price as price_add,bps_budget_add.ket_chg,bps_budget_add.status from bps_budget inner join bps_budget_add on bps_budget.no_ctrl=bps_budget_add.no_ctrl where bps_budget.sect='$sect' and bps_budget_add.no_ctrl_add='$no_ctrl'";
}
?>	 	 
	   <div class="row clearfix">
      <div class="card">
	<div class="row clearfix">				
	<div class="header">
	 <h2>Record<small>Cari Additional Budget</small></h2>
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
       </div>	
</div>	   
						<div class="row clearfix">
                        <div class="body">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
                                    <thead>
                                     <tr>	
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
$sq_acc="select bps_budget.term,bps_budget.no_ctrl,bps_budget.part_no,bps_budget.part_nm,bps_budget.part_desc,bps_budget.part_dtl,bps_budget.uom,bps_budget.QTY,bps_budget.price,bps_budget_add.periode,bps_budget_add.no_ctrl_add,bps_budget_add.qty as qty_add,bps_budget_add.price as price_add,bps_budget_add.ket_chg,bps_budget_add.status from bps_budget inner join bps_budget_add on bps_budget.no_ctrl=bps_budget_add.no_ctrl where bps_budget.sect='$sect' and $whr";
}
if(isset($_POST['smpn_add']) or isset($_POST['smpn_item']) or isset($_POST['cr_b'])){
$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
$row=0;
$opsi_del="";
//echo $sq_acc;
while($baris1=odbc_fetch_array($tb_acc)){ $row++;
$add_ctrl= odbc_result($tb_acc,"no_ctrl_add");
$add_stts=odbc_result($tb_acc,"status");
if($add_stts="OPEN"){$opsi_del=$opsi_del.'<option value="'.$add_ctrl.'">'.$add_ctrl.'</option>';}
?>	
				<tr  onclick="javascript:pilih(this);">
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
<?php if(isset($_POST['cr_b'])){ 
 if($row>0 and $opsi_del!=""){	?>
	<div class="row clearfix">				
	<div class="header">
	 <h2>Delete<small>Hapus Additional Budget Status OPEN</small></h2>
	</div>
	<div class="body">
    <form action="" id="frmdel" name="frmdel" method="post"  enctype="multipart/form-data">
	<div class="col-sm-6">	
	 <div class="form-group">
    <!--label>Kolom</label-->
       <select class="selectpicker" data-live-search="true" style="width: 100%;"  name="no_ctrl_dell" id="no_ctrl_dell" required>
			<option selected="selected" value="">---Pilih No Control---</option>
			<?php echo $opsi_del; ?>
       </select>
    </div>
	</div>
	
	<div class="col-sm-2">
	<button type="submit" name="del_ctrl" id="del_ctrl" class="btn bg-red waves-effect"><i class="material-icons">delete</i>HAPUS</button>
	<button type="reset" name="reset" id="reset" class="btn bg-red waves-effect"><i class="material-icons">clear</i> </button>
    </div>
                            </form>
       </div>	
</div>	
<?php }} 
if(isset($_POST['del_ctrl'])){ 
$no_ctrl_dell=$_POST['no_ctrl_dell'];
$tb_del1=odbc_exec($koneksi_lp,"delete from bps_budget_add where no_ctrl_add='$no_ctrl_dell'");
$tb_del2=odbc_exec($koneksi_lp,"delete from bps_budget where no_ctrl='$no_ctrl_dell'");
echo "<script>alert('DATA $no_ctrl_dell SUDAH DI DELETE')</script>";
}
?>						
                    </div>
                </div>
 </div>
 </section>

 <script type="text/javascript">
		$(document).ready(function()
		{
		$('.periodemn').bootstrapMaterialDatePicker({
        format: 'YYYYMM', minDate : new Date(),
        clearButton: true,
        weekStart: 0,
        time: false
    });	
			});
</script>			