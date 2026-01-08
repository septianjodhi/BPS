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
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url+'&ac='+nik, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);		
	};
	function cr_part(url,title,w,h){
		var pno=document.form1.part_no.value;
		var pnd=document.form1.part_desc.value;
		var lp=document.frm_additem.lp.value;
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url+'&pno='+pno+'&pnd='+pnd+'&lp='+lp, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);		
	};
	function cek_bud(url,title,w,h){
		var term=document.form3.term_cek.value;
		var sect=document.form3.sect_cek.value;
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url+'&sect='+sect+'&term='+term, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);		
	};
  //var secdep=document.form1.sect.value;
  //var periode=document.form1.periode.value;
  $("#term" ).change(function() {document.form1.part_desc.value = no_ctrl.value+"-"+secdep+"-"+periode+"-"; })
  $("#periode" ).change(function() {document.form1.part_desc.value = no_ctrl.value+"-"+secdep+"-"+periode+"-"; })
  $("#sect" ).change(function() { document.form1.part_desc.value = no_ctrl.value+"-"+secdep+"-"+periode+"-"; })
</script>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>BUDGET</h2>
		</div>
		<div class="row clearfix">
			<div class="card">
				<div class="header">
					<h2>INPUT<small>Manual Input Budget</small></h2>
				</div>
				<div class="body">
					<form role="form"  name="form1" id="form1" method="post" action="">
						<div class="col-lg-12">
							<div class="col-md-3">
								<div class="form-group">
									<label>Term</label>
									<div class="input-group">
										<select class="selectpicker" style="width: 100%;"  name="term" id="term"  required>
											<option selected="selected" value="">---Pilih Term---</option>
											<?php
											$qterm="select distinct term from bps_setterm order by term desc";
											$tb_qterm=odbc_exec($koneksi_lp,$qterm);
											$opt_term="";
											while($bar_qterm=odbc_fetch_array($tb_qterm)){
												$term=odbc_result($tb_qterm,"term");
												$opt_term=$opt_term.'<option value="'.$term.'">'.$term.'</option>';
											}
											echo $opt_term;
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label>Purchasing</label>
									<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="lp" id="lp"  required>
										<?php
										$qlp="select * from bps_lp order by kd_lp";
										$tb_lp=odbc_exec($koneksi_lp,$qlp);
										while($bar_qlp=odbc_fetch_array($tb_lp)){
											$dt_lp=odbc_result($tb_lp,"kd_lp");
											echo '<option value="'.$dt_lp.'">'.$dt_lp.'</option>';
										}				
										?>
									</select>
								</div>
								<div class="form-group">
									<label>Section</label>
									<div class="form-line">
										<input type="text" readonly class="form-control" id="sect" name="sect" value="<?php echo $_SESSION["Area"] ?>" placeholder="Section" required>
									</div>
				<!--select class="selectpicker" data-live-search="true" style="width: 100%;"  name="sect" id="sect"  required>
				<option selected="selected" value="">---Pilih Section---</option>
				<?php
			/*	$qsect="select distinct sect from LP_SECT";
				$tb_qsect=odbc_exec($koneksi_lp,$qsect);
				$opt_sect="";
				while($bar_qsect=odbc_fetch_array($tb_qsect)){
				$sec=odbc_result($tb_qsect,"sect");
				$opt_sect=$opt_sect.'<option value="'.$sec.'">'.$sec.'</option>';
				}
				echo $opt_sect;
			*/	?>

		</select-->
	</div>	
	<div class="form-group">
		<label>Account</label>
		<div class="input-group">
			<div class="form-line">
				<input type="text" class="form-control" id="account" name="account" placeholder="Account" required>
			</div>
			<span class="input-group-addon">
				<button type="button" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float"  onclick="cr_nm('template.php?plh=select/plh_acc.php&acc=account','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
			</span>

		</div>
	</div>
	<div class="form-group">
		<label>Sub Account</label>
		<div class="input-group">
			<div class="form-line">
				<input type="text" readonly class="form-control" id="sub_acc" name="sub_acc" placeholder="Sub Account" required>
			</div>
			<span class="input-group-addon">
				<button type="button" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float"  onclick="cr_nm('template.php?plh=select/plh_acc.php&acc=sub_acc','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
			</span>
		</div>
	</div>	
</div>

<div class="col-md-3">	
	<div class="form-group">
		<label>Periode</label>
		<div class="form-line">
			<input type="number" class="form-control" id="periode" name="periode" placeholder="Periode" required>
		</div>
	</div>
	<div class="form-group">
		<label>Kode Proses</label>
		<div class="form-line">
			<input type="text" class="form-control" id="id_proses" name="id_proses" placeholder="Kode Proses" required>
		</div>
	</div>
	<div class="form-group">
		<label>Nama Part</label>
		<div class="input-group">
			<div class="form-line">
				<input type="text" class="form-control" id="part_desc" name="part_desc" placeholder="Nama Part" required>
			</div>
			<span class="input-group-addon">
				<button type="button" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float"  onclick="cr_part('template.php?plh=select/plh_partbud.php','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
			</span>
		</div>
	</div>
	<div class="form-group">
		<label>Part No</label>
		<div class="form-line">
			<input type="text" class="form-control" id="part_no" name="part_no" placeholder="Part No" required>
		</div>
	</div>
	<div class="form-group">
		<label>Detail Part</label>
		<div class="form-line">
			<input type="text" class="form-control" id="part_dtl" name="part_dtl" placeholder="Detail Part" required>
		</div>
	</div>
</div>
<div class="col-md-3">
	<div class="form-group">
		<label>No Control</label>
		<div class="form-line">
			<input type="text" class="form-control" id="no_ctrl" name="no_ctrl" placeholder="No Contro" required>
		</div>
	</div>	
	<div class="col-md-6">
		<div class="form-group">
			<label>Qty</label>
			<div class="form-line">
				<input type="number" class="form-control" id="qty" name="qty" placeholder="Qty" required>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>UOM</label>
			<div class="form-line">
				<input type="text" class="form-control" id="uom" name="uom" placeholder="Uom" required>
			</div>
		</div>
	</div>
	<div class="col-md-6">
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
					<input type="number" class="form-control" id="price" name="price" placeholder="Price" required>
				</div>
			</div></div>
			<div class="form-group">
				<label>Cost Center</label>
				<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cccode" id="cccode"  required>
					<option selected="selected" value="">---Cost Center--</option>
					<?php
					$qcccode="select distinct cost_center_code,cv_code,cv_desc from lp_cv order by cost_center_code";
					$tb_cccode=odbc_exec($koneksi_lp,$qcccode);
					while($bar_qcccode=odbc_fetch_array($tb_cccode)){
						$dt_cv_code=odbc_result($tb_cccode,"cv_code");
						$dt_cv_desc=odbc_result($tb_cccode,"cv_desc");
						$dt_cccode=odbc_result($tb_cccode,"cost_center_code");
						echo '<option value="'.$dt_cccode.'">'.$dt_cccode.'('.$dt_cv_code.'='.$dt_cv_desc.')</option>';
					}				
					?>
				</select>
			</div>
			<div class="form-group">
				<label>Phase</label>
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
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>LT VP</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_vp" name="lt_vp" placeholder="LT VP" required>
				</div>
			</div>	
			<div class="form-group">
				<label>LT Kedatangan</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_datang" name="lt_datang" placeholder="LT Kedatangan" required>
				</div>
			</div>	
			<div class="form-group">
				<label>LT PO</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_po" name="lt_po" placeholder="LT PO" required>
				</div>
			</div>	
			<div class="form-group">
				<label>LT PR</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_pr" name="lt_pr" placeholder="LT PR" required>
				</div>
			</div>		
			<div class="form-group">
				<label>LT Penawaran</label>
				<div class="form-line">
					<input type="number" class="form-control" id="lt_Quo" name="lt_Quo" placeholder="LT Penawaran" required>
				</div>
			</div>
		</div>

	</div>
	<span class="input-group-addon">	 	 
		<button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
		<button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>

	</span>  
</form>
</div>
</div>	                   
</div>
<?php
if(isset($_POST['smpn']) or isset($_POST['del'])){	
	$sect=$_POST['sect'];
	$term=$_POST['term'];
	$jns_budget="NORMAL";
	$pic_updt=$_SESSION['nama'];
//$tgl_updt=$_POST['tgl_updt']
	$no_ctrl=$_POST['no_ctrl'];
	$lp=$_POST['lp'];
	$id_proses=$_POST['id_proses'];
	$account=$_POST['account'];
	$sub_acc=$_POST['sub_acc'];
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

	$qry_del="delete from bps_budget_temp where no_ctrl='$no_ctrl'";
	$qry_add="insert into bps_budget_temp(sect,term,jns_budget,pic_updt,tgl_updt,expaired,no_ctrl,lp,id_proses,account,sub_acc,part_no,part_desc,part_dtl,periode,qty,uom,price,curr,cccode,phase,lt_Quo,lt_pr,lt_po,lt_datang,lt_vp) values('$sect','$term','$jns_budget','$pic_updt',getdate(),'$expaired','$no_ctrl','$lp','$id_proses','$account','$sub_acc','$part_no','$part_desc','$part_dtl','$periode','$qty','$uom','$price','$curr','$cccode','$phase','$lt_Quo','$lt_pr','$lt_po','$lt_datang','$lt_vp')";
	$tb_del=odbc_exec($koneksi_lp,$qry_del);

	if(isset($_POST['smpn']) ){	

		$tb_add=odbc_exec($koneksi_lp,$qry_add);
		$sq_acc="select * from bps_budget_temp where no_ctrl='$no_ctrl'";
	}}
	?>	 
	<div class="row clearfix">
		<div class="col-lg-6">
			<div class="card">
				<div class="header">
					<h2>INPUT<small>Upload Data Budget</small></h2>
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
								<div class="col-md-4">	
									<div class="form-group">
										<label>Term</label>
										<div class="input-group">
											<select class="selectpicker" data-live-search="true" style="width: 50%;"  name="term_u" id="term_u"  required>
												<option selected="selected" value="">---Pilih Term---</option>
												<?php echo $opt_term; ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4">	
									<div class="form-group">
										<label>Section</label>
										<div class="form-line">
											<input type="text" readonly class="form-control" id="sect_u" name="sect_u" value="<?php echo $_SESSION["Areaa"] ?>" placeholder="Section" required>
										</div>
									</div></div>
									<div class="col-md-4">	
										<div class="form-group">
											<label>Open File</label>
											<div class="form-line">
												<input type="file" class="form-control" id="file" name="file" placeholder="Cari File" required>
											</div>
										</div>
									</div>
								</div>
							</div>
							<span class="input-group-addon">	 
								<button type="submit" id="upld" name="upld" class="btn bg-orange waves-effect">
									<i class="material-icons">saves</i>UPLOAD </button>		 
									<button type="reset" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Reset</button>
								</span>
							</form>
						</div>	      
					</div>	
					<div class="col-lg-6">
						<div class="card">
							<div class="header">
								<h2>Cek<small>Cek Temporary</small></h2>
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
								<form role="form" enctype="multipart/form-data" name="form3" id="form3" method="post" action="">
									<div class="body">
										<div class="col-lg-12">
											<div class="col-md-6">	
												<div class="form-group">
													<label>Term</label>
													<div class="input-group">
														<select class="selectpicker" data-live-search="true"   name="term_cek" id="term_cek"  required>
															<option selected="selected" value="">---Pilih Term---</option>
															<?php echo $opt_term; ?>

														</select>
													</div></div></div>
													<div class="col-md-6">	
														<div class="form-group">
															<label>Section</label>
															<div class="form-line">
																<input type="text" readonly class="form-control" id="sect_cek" name="sect_cek" value="<?php echo $_SESSION["Areaa"] ;?>" placeholder="Section" required>
															</div>
														</div></div>
													</div>
												</div>
												<span class="input-group-addon">
													<button type="button" class="btn bg-orange waves-effect" onclick="cek_bud('template.php?plh=select/cek_bud.php','Data Conveyor','800','500');return false;" >
														<i class="material-icons">playlist_add_check</i>Check Budget</button>	
														<!--button type="button" class="btn bg-purplewaves-effect"  onclick="cek_bud('template.php?plh=select/cek_bud.php','Data Conveyor','800','500'); return false;"><i class="material-icons">playlist_add_check</i>Check Budget</button-->
													</span>

												</form></div>	      
											</div>		
										</div>
										<?php
										if(isset($_POST['upld']) ){
											require_once "excel_reader2.php";
	//	echo "<script>alert('upload data');</script>"; 
		$file_name = $_FILES['file']['name']; //nama file (tanpa path)
		$tmp_name  = $_FILES['file']['tmp_name']; //nama local temp file di server
		$file_size = $_FILES['file']['size']; //ukuran file (dalam bytes)
		$file_type = $_FILES['file']['type']; //tipe filenya (langsung detect MIMEnya)
		$fp1 = fopen($tmp_name, 'r'); // open file (read-only, binary)
		$fp = fopen($tmp_name, 'r');		
		$pecah=explode(".",$file_name);
		$ekstensi=$pecah[1];
		$extensionList=array("xls","XLS");
		if(in_array($ekstensi,$extensionList)){		
			$target = basename($_FILES['file']['name']) ;
			move_uploaded_file($_FILES['file']['tmp_name'], $target);			 
			$data = new Spreadsheet_Excel_Reader($_FILES['file']['name'],false);  
			$baris = $data->rowcount($sheet_index=0);
			$fixedbaris = $baris;	 
			$term_u=$_POST['term_u'];
			$sect_u=$_POST['sect_u'];
			$pic=$_SESSION['nama'];
			$jmrow=0;
			$sql_del="Delete from bps_budget_temp where term='$term_u' and sect='$sect_u'";
			//echo $sql_del;
			$hilang=odbc_exec($koneksi_lp,$sql_del);
			for ($i=8; $i<=$fixedbaris; $i++){		
//$kolA=$data->val($i,1);//no
$kolB=$data->val($i,2);//CONTROL NO	
$kolC=$data->val($i,3);//PURCHASING
$kolD=$data->val($i,4);//KODE PROSES
$kolE=$data->val($i,5);//ACCOUNT
$kolF=$data->val($i,6);//SUB ACCOUNT
//$kolG=$data->val($i,7);//COUNTER
$kolH=$data->val($i,8);//PART NO
$kolI=$data->val($i,9);//PART NAME
$kolJ=$data->val($i,10);//DETAIL PART
$kolK=$data->val($i,11);//PERIODE
$kolL=$data->val($i,12);//QTY
$kolM=$data->val($i,13);//UOM
$kolN=$data->val($i,14);//Currency
$kolO=$data->val($i,15);//PRICE
//$kolP=$data->val($i,16);//AMOUNT
$kolQ=$data->val($i,17);//PHASE
$kolR=$data->val($i,18);//COST CENTER
$kolS=$data->val($i,19);//PENAWARAN
$kolT=$data->val($i,20);//PR
$kolU=$data->val($i,21);//PO
$kolV=$data->val($i,22);//KEDATANGAN
$kolW=$data->val($i,23);//VP
$experied=date("Y-m-d",strtotime($kolK."28"));

if($kolB!=""){
	$sql_updt="insert into bps_budget_temp(sect,term,jns_budget,pic_updt,tgl_updt,expaired,no_ctrl,lp,id_proses,account,sub_acc,part_no,part_desc,part_dtl,periode,qty,uom,curr,price,phase,cccode,lt_Quo,lt_pr,lt_po,lt_datang,lt_vp)
	values('$sect_u','$term_u','NORMAL','$pic',getdate(),'$experied','$kolB','$kolC','$kolD','$kolE','$kolF','$kolH','$kolI','$kolJ','$kolK','$kolL','$kolM','$kolN','$kolO','$kolQ','$kolR','$kolS','$kolT','$kolU','$kolV','$kolW')";
	$hasil = odbc_exec($koneksi_lp, $sql_updt);
//echo "<br>lht ".$i.$sql_updt;
	if(!$hasil){
		echo "<br>Error ".$i.$sql_updt;
		print(odbc_error());
	}else{ $jmrow++; }
}
}
unlink($_FILES['file']['name']);	
echo "<script>alert('$jmrow DATA SELESAI DI UPLOAD ');</script>";
$sq_acc="select * from bps_budget_temp where tgl_updt=getdate() and pic_updt='$pic'";
}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_bud.php'</script>"; }

}
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
							<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_tbl" id="cmd_tbl" required>
								<option selected="selected" value="">---Pilih---</option>
								<option value="tmp">Temporary</option>
								<option value="real">Realisasi</option>
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
								<option value="cccode">COST CENTER</option>
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
									<th>JENIS BUDGET</th>
									<th>CONTROL NO</th>
									<th>PURCHASING</th>
									<th>KODE PROSES</th>
									<th>ACCOUNT</th>
									<th>SUB ACC</th>
									<th>PART NO</th>
									<th>PART NAME</th>
									<th>DETAIL PART</th>
									<th>PERIODE</th>
									<th>QTY</th>
									<th>UOM</th>
									<th>CURR</th>
									<th>PRICE</th>
									<th>PHASE</th>
									<th>COST CENTER</th>
									<th>EXPAIRED DATE</th>
									<th>VP</th>
									<th>KEDATANGAN</th>
									<th>PO</th>
									<th>PR</th>
									<th>PENAWARAN</th>
								</tr>
							</thead>

							<tbody>
								<?php
								if(isset($_POST['cr_b']) ){	
									$cmd_tbl=$_POST['cmd_tbl'];
									if($cmd_tbl=="real"){$tbl="";}else{$tbl="_temp";}
									$cmd_cari=$_POST['cmd_cari'];
									$txt_cari=str_replace(" ","",$_POST['txt_cari']);
									if($txt_cari==""){$whr="no_ctrl is not null"; }else{
										$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
										$sq_acc="select * from bps_budget$tbl where $whr";
									}
									if(isset($_POST['smpn']) or isset($_POST['upld']) or isset($_POST['cr_b'])){
										$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
										$row=0;
										while($baris1=odbc_fetch_array($tb_acc)){ $row++;
											$expaired=odbc_result($tb_acc,"expaired");
											$lt_vp=Odbc_result($tb_acc,"lt_vp");
											$lt_datang=odbc_result($tb_acc,"lt_datang");
											$lt_po=odbc_result($tb_acc,"lt_po");
											$lt_pr=odbc_result($tb_acc,"lt_pr");
											$lt_Quo=odbc_result($tb_acc,"lt_Quo");
											$lt_datang_cumm=$lt_datang+$lt_vp;
											$lt_po_cumm=$lt_po+$lt_datang_cumm;
											$lt_pr_cumm=$lt_pr+$lt_po_cumm;
											$lt_Quo_cumm=$lt_Quo+$lt_pr_cumm;
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
												<td><?php echo "($lt_vp) ".date('Y-m-d', strtotime($expaired. " - $lt_vp days")); ?></td>
												<td><?php echo "($lt_datang) ".date('Y-m-d', strtotime($expaired. " - $lt_datang_cumm days")); ?></td>
												<td><?php echo "($lt_po) ".date('Y-m-d', strtotime($expaired. " - $lt_po_cumm days")); ?></td>
												<td><?php echo "($lt_pr) ".date('Y-m-d', strtotime($expaired. " - $lt_pr_cumm days")); ?></td>
												<td><?php echo "($lt_Quo)) ".date('Y-m-d', strtotime($expaired. " - $lt_Quo_cumm days")); ?></td>

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
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script>
		function pilih(row){
			var kd_pel1=row.cells[1].innerHTML;
			var kd_pel2=row.cells[2].innerHTML;
			document.form1.kd_car.value=kd_pel1;
			document.form1.nm_car.value=kd_pel2;

		}
	</script>