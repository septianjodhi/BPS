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
 function cekctrl(url,title,w,h){
	  var pno=document.form1.term.value;
	  var pnd=document.form1.periode.value;
	  var sec=document.form1.sect.value;
	  var jns_bud=document.form1.jns_bud.value;
	  var pernow = new Date();
	 var nperi=pernow.getFullYear()+''+("0"+(pernow.getMonth()+1)).slice(-2);
	 var balp=parseInt(pnd)-parseInt(nperi);
	 // alert(balp);
	  if(pno=="" ||sec=="" || balp<0){alert("Term-Section Belum dipilih Atau Periode Kurang dari Bulan Sekarang");}else{
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        w = window.open(url+'&t='+pno+'&p='+pnd+'&s='+sec+'&k='+jns_bud, title, 'toolbar=no, location=no, directories=no, \n\
        status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
        width='+w+',height='+h+',top='+top+',left='+left);		
	  };
	/*function chgpart(){
		 alert("The text has been changed.");
	
  };
  */};

</script>

	 <script src="./plugins/jquery/jquery.min.js"></script>
	<script src="./plugins/bootstrap-select/js/bootstrap-select.js"></script>
	<script src="./plugins/jquery-validation/jquery.validate.js"></script>
	<!-- Step -->
	<script src="./plugins/jquery-steps/jquery.steps.js"></script>
	<script src="./plugins/jquery-steps/form-steps.js"></script>
 <?php
 $trm=$_GET["t"];//term
 $peri=$_GET["p"];//periode
 $noctrl=$_GET["n"];//no control
 $cx=$_GET["c"];//change
 $s=$_GET["s"]; //section
$c=explode("-",$cx);
include "../koneksi.php";
 ?>	
<div class="row clearfix">
<?php if($c[0] !="5"){ ?>
    <div class="card">
		<div class="header">
		<h2>ADDITIONAL <?php echo $c[1]; ?></h2>
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
		<div class="col-md-1">			
			<div class="form-group">
				<label>Term</label>
				 <div class="input-group">
					<input type="number" readonly class="bg-grey form-control" id="term" name="term" value="<?php echo $trm; ?>" placeholder="Periode Plan" required>
			</div></div>
		</div>
		<div class="col-md-2">
                <div class="form-group">
				<label>Periode Plan</label>
                <div class="input-group">
					<input type="number" readonly class="bg-grey form-control" id="periode_plan" name="periode_plan" value="<?php echo $peri; ?>" placeholder="Periode Plan" required>
					
			</div></div></div>
			<div class="col-md-3">
			<div class="form-group">
				<label>No Control Add</label>
			<div class="input-group">
					<input type="text" readonly class="form-control bg-grey" id="no_ctrl_add" name="no_ctrl_add" value="<?php echo $noctrl; ?>" placeholder="No Contro" required>
            </div></div></div>
			
			<div class="col-md-2">
			<div class="form-group">
				<label>Perubahan</label>
			<div class="input-group">
					<input type="text" readonly class="form-control bg-grey" id="add" name="add" value="<?php echo $cx; ?>" placeholder="No Contro" required>
            </div></div> </div>
			
			<div class="col-md-4">		
			<div class="form-group">
				<label>No Control Plan</label>
				 <div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="bg-grey form-control" id="no_ctrl_plan" name="no_ctrl_plan" placeholder="No Contro" required>
				</div>
				
				 <span class="input-group-addon">
                      <button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl4('template.php?plh=select/budtoadd.php&s=<?php echo $s; ?>','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
				</span>								
            </div></div>			
		</div>	
		</div>
		<div class="col-lg-12">	
			
		 <div class="col-md-2">	
                <div class="form-group">
				<label>QTY Plan</label>
				<div class="form-line">
					<input type="number" readonly class="bg-grey form-control" id="qty_plan" name="qty_plan" placeholder="QTY Plan" required>
				</div>
                </div>	
			</div>
		<div class="col-md-2">
                <div class="form-group">
				<label>Price Plan</label>
				<div class="form-line">
					<input type="number" readonly class="bg-grey form-control" id="price_plan" name="price_plan" placeholder="Price plan" required>
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
			<div class="col-md-2">
                <div class="form-group">
				<label>Periode Add</label>
				<div class="form-line">
					<input type="number" readonly class="periodemn form-control" id="periode_add" name="periode_add" value="<?php echo $peri; ?>" placeholder="Periode Add" required>
				</div></div></div>
				
        </div>
		<div class="row clearfix">	
          <button type="submit" id="smpn_add" name="smpn_add" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
          <button type="reset" id="reset" name="reset" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Clear</button>
            
		</div> 
		  </div>
		</form>	                   
	</div>
	 
<?php
if(isset($_POST['smpn_add']) ){
$term_plan=$_POST['term_plan'];
$addx=explode("-",$_POST['add']);
$add=$addx[0];
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

if($add=="1"){$qry_add="insert into bps_budget_add (no_ctrl,no_ctrl_add,periode,qty,price,kode_chg,ket_chg,status,pic_updt,tgl_updt) values('$no_ctrl_plan','$no_ctrl_add','$periode_pln','$qty_add','$price_plan','$add','QTY ONLY','OPEN','$pic_updt','getdate())'";}
elseif($add=="2"){$qry_add="insert into bps_budget_add(no_ctrl,no_ctrl_add,periode,qty,price,kode_chg,ket_chg,status,pic_updt,tgl_updt) values('$no_ctrl_plan','$no_ctrl_add','$periode_pln','$qty_plan','$price_add','$add','PRICE ONLY','OPEN','$pic_updt',getdate())";}
elseif($add=="3"){$qry_add="insert into bps_budget_add(no_ctrl,no_ctrl_add,periode,qty,price,kode_chg,ket_chg,status,pic_updt,tgl_updt) values('$no_ctrl_plan','$no_ctrl_add','$periode_pln','$qty_add','$price_add','$add','QTY AND PRICE','OPEN','$pic_updt',getdate())";}
elseif($add=="4"){$qry_add="insert into bps_budget_add (no_ctrl,no_ctrl_add,periode,qty,price,kode_chg,ket_chg,status,pic_updt,tgl_updt) values('$no_ctrl_plan','$no_ctrl_add','$periode_add','$qty_plan','$price_plan','$add','PERIODE','OPEN','$pic_updt',getdate())";}

//$qry_add="insert into bps_budget_add (no_ctrl,no_ctrl_add,periode,qty,price,kode_chg,ket_chg,status,pic_updt,tgl_updt) values('$no_ctrl_plan','$no_ctrl_add','$periode_pln','$qty_add','$price_plan','$add','$c','OPEN','$pic_updt','date(now()))'";

$tb_deladd = odbc_exec($koneksi_lp, "delete from bps_budget_add where no_ctrl_add='$no_ctrl_add'");	
$tb_add = odbc_exec($koneksi_lp,$qry_add);
//echo "<br>lht ".$i.$qry_add

$sq_acc="select bps_budget.term,bps_budget.no_ctrl,bps_budget.part_no,bps_budget.part_nm,bps_budget.part_desc,bps_budget.part_dtl,bps_budget.uom,bps_budget.QTY,bps_budget.price,bps_budget_add.periode,bps_budget_add.no_ctrl_add,bps_budget_add.qty as qty_add,bps_budget_add.price as price_add,bps_budget_add.ket_chg,bps_budget_add.status from bps_budget inner join bps_budget_add on bps_budget.no_ctrl=bps_budget_add.no_ctrl where bps_budget.sect='$sect' and bps_budget_add.no_ctrl_add='$no_ctrl_add'";
	
}
}else{
?>	

    <div class="card">
		<div class="header">
             <h2>ADDITIONAL ITEM<small>Penambahan Budget Untuk Item Baru</small></h2>
        </div>
		<div class="body">
		 <form role="form"  name="form1" id="form1" class="step_with_validation" method="post" action="">
		<h3>STEP 1</h3>
        <fieldset>
		<div class="col-md-3">
		 <div class="form-group">
				<label>Term</label>
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="term" name="term" value="<?php echo $trm; ?>" required>
				</div></div>
		<div class="form-group">
				<label>Periode</label>
				<div class="form-line">
					<input type="number" readonly class="form-control bg-grey" id="periode" name="periode" value="<?php echo $peri; ?>" placeholder="Periode" required>
				</div></div>
        <div class="form-group">
				<label>Section</label>
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="sect" name="sect" value="<?php echo $s; ?>" required>
				</div></div>
		</div>
		<div class="col-md-3">
		<div class="form-group">
				<label>Account</label>
				 <div class="input-group">
                    <div class="form-line">
                     <input type="text" class="form-control bg-grey" id="account" name="account" placeholder="Account" required>
                     </div>
                    <span class="input-group-addon">
                     <button type="button" class="btn bg-purple waves-effect"  onclick="cr_nm('template.php?plh=select/plh_acc.php&acc=account','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
                                        
                  </div></div>
		<div class="form-group">
				<label>Sub Account</label>
				<div class="input-group">
                    <div class="form-line">
                     <input type="text" readonly class="form-control bg-grey" id="sub_acc" name="sub_acc" placeholder="Sub Account" required>
                     </div>
                    <span class="input-group-addon">
                     <button type="button" class="btn bg-purple waves-effect"  onclick="cr_nm('template.php?plh=select/plh_acc.php&acc=sub_acc','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
                                        
                  </div>
                </div>
		<div class="form-group">
				<label>Cost Center</label>
				  <div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="cccode" name="cccode" placeholder="Cost Center" required>
				</div>
                    <span class="input-group-addon">
                     <button type="button" class="btn bg-purple waves-effect"  onclick="open_child('template.php?plh=select/plh_cccode.php&o=cccode&k=1','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
                </div></div>
		</div>
		<div class="col-md-3">
		<div class="form-group">
				<label>Phase</label>
				<div class="input-group">
					<select class="selectpicker_temp" data-live-search="true" style="width: 100%;"  name="phase" id="phase"  required>
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
		<div class="form-group">
				<label>Purchasing</label>
				<div class="input-group">
				<select class="selectpicker_temp" data-live-search="true" style="width: 100%;"  name="lp" id="lp"  required>
				<?php
				$qlp="select * from bps_lp order by kd_lp";
				$tb_lp=odbc_exec($koneksi_lp,$qlp);
				while($bar_qlp=odbc_fetch_array($tb_lp)){
				$dt_lp=odbc_result($tb_lp,"kd_lp");
				echo '<option value="'.$dt_lp.'">'.$dt_lp.'</option>';
				}				
				?>
				</select>
			</div></div>
		<div class="form-group">
				<label>Process Code</label>
				<div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="id_proses" name="id_proses" placeholder="Kode Proses" required>
				</div> <span class="input-group-addon">
                     <button type="button" class="btn bg-purple waves-effect"  onclick="open_child('template.php?plh=select/plh_pros.php','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
                </div></div>
		</div>
		<div class="col-md-3">
		<div class="form-group">
				<label>Type</label>
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="jns_bud" name="jns_bud" value="ADDITIONAL" required>
				</div></div>
		<div class="form-group">
				<label>Control No</label>
				  <div class="input-group">
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="no_ctrl" name="no_ctrl" placeholder="No Contro" required>
				</div>
                    <span class="input-group-addon">
                     <button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl('template.php?plh=select/cek_noctrl.php&o=no_ctrl','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
					 </span>
                </div></div>                
		</div>
		</fieldset>
		<h3>STEP 2</h3>
        <fieldset> 
		<div class="col-md-3">
		 <div class="form-group">
				<label>Part Name</label>
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
					<input type="text" readonly class="form-control bg-grey" id="part_no" name="part_no" placeholder="Part No" required>
				</div></div>
        </div>
		<div class="col-md-6">
        <div class="form-group">
				<label>Detail Part</label>
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey" id="part_dtl" name="part_dtl" placeholder="Detail Part" required>
				</div></div>
        <div class="form-group">
				<label>Remark Part</label>
				<div class="form-line">
					<input type="text" class="form-control" id="part_desc" name="part_desc" placeholder="Remark Part">
				</div> </div>
        </div>
		<div class="col-md-3">
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
					<input type="text" readonly class="form-control bg-grey"  id="uom" name="uom" placeholder="Uom" required>
				</div>
                </div></div>
		<div class="col-md-6">
                <div class="form-group">
				<label>Currency</label>
				<div class="form-line">
					<input type="text" readonly class="form-control bg-grey"  id="curr" name="curr" placeholder="Currency" required>
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
		</fieldset>
		<h3>STEP 3</h3>
        <fieldset> 
		 <div class="col-md-2">
		 <div class="form-group">
				<label>LT Quotation</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_Quo" name="lt_Quo" min="0"  placeholder="LT Penawaran" required>
				</div></div>
        </div>
		<div class="col-md-2">
		 <div class="form-group">
				<label>LT PR</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_pr" name="lt_pr" min="0"  placeholder="LT PR" required>
				</div></div>                
        </div>
		<div class="col-md-2">
		<div class="form-group">
				<label>LT PO</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_po" name="lt_po" min="0" placeholder="LT PO" required>
				</div></div>                
        </div>
		<div class="col-md-2">
		<div class="form-group">
				<label>LT Arrival</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_datang" name="lt_datang"  min="0"  placeholder="LT Arrival" required>
				</div></div>                
        </div>
		<div class="col-md-2">
		<div class="form-group">
				<label>LT VP</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_vp" name="lt_vp" min="0"  placeholder="LT VP" required>
				</div></div>
                
        </div>
		<div class="col-md-2">
		<button type="submit" id="smpn_item" name="smpn_item" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
          <button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>
        </div>
		</fieldset>    
		  
		</form>	                   
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
$qry_add="insert into bps_budget(sect,term,jns_budget,pic_updt,tgl_updt,expaired,no_ctrl,lp,id_proses,account,sub_acc,part_no,part_nm,part_desc,part_dtl,periode,qty,uom,price,curr,cccode,phase,lt_Quo,lt_pr,lt_po,lt_datang,lt_vp) values('$sect','$term','$jns_budget','$pic_updt',getdate(),'$expaired','$no_ctrl','$lp','$id_proses','$account','$sub_acc','$part_no','$part_nm','$part_desc','$part_dtl','$periode','$qty','$uom','$price','$curr','$cccode','$phase','$lt_Quo','$lt_pr','$lt_po','$lt_datang','$lt_vp');";

$qry_add_add="insert into bps_budget_add(no_ctrl,no_ctrl_add,periode,qty,price,kode_chg,ket_chg,status,pic_updt,tgl_updt) values('$no_ctrl','$no_ctrl','$periode','$qty','$price','5','NEW ITEM','OPEN','$pic_updt',getdate());";
$tb_del=odbc_exec($koneksi_lp,"delete from bps_budget where no_ctrl='$no_ctrl'");
$tb_delFA=odbc_exec($koneksi_lp,"delete from bps_budget_add where no_ctrl_add='$no_ctrl'");

$tb_add=odbc_exec($koneksi_lp,$qry_add);
$tb_addFA=odbc_exec($koneksi_lp,$qry_add_add);
$sq_acc="select bps_budget.term,bps_budget.no_ctrl,bps_budget.part_no,bps_budget.part_nm,bps_budget.part_desc,bps_budget.part_dtl,bps_budget.uom,bps_budget.QTY,bps_budget.price,bps_budget_add.periode,bps_budget_add.no_ctrl_add,bps_budget_add.qty as qty_add,bps_budget_add.price as price_add,bps_budget_add.ket_chg,bps_budget_add.status from bps_budget inner join bps_budget_add on bps_budget.no_ctrl=bps_budget_add.no_ctrl where bps_budget.sect='$sect' and bps_budget_add.no_ctrl_add='$no_ctrl'";
}
}
?>	 	 
</div>

 <script type="text/javascript">
		$(document).ready(function()
		{
			$('.selectpicker_temp').selectpicker();
});

</script>
