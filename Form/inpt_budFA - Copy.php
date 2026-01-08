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
		var lp=document.form1.lp.value;
		var pernow = new Date();
		var nperi=pernow.getFullYear()+''+("0"+(pernow.getMonth()+1)).slice(-2);
		var balp=parseInt(pnd)-parseInt(nperi);
	 // alert(balp);
	 if(pno=="" ||sec=="" || balp<0){alert("Term-Section Belum dipilih Atau Periode Kurang dari Bulan Sekarang");}else{
	 	var left = (screen.width/2)-(w/2);
	 	var top = (screen.height/2)-(h/2);
	 	w = window.open(url+'&t='+pno+'&p='+pnd+'&s='+sec+'&k='+jns_bud+'&lp='+lp, title, 'toolbar=no, location=no, directories=no, \n\
	 		status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
	 		width='+w+',height='+h+',top='+top+',left='+left);		
	 };
	 
	/*function chgpart(){
		 alert("The text has been changed.");
	
  };
  */
};
</script>

<section class="content">
	<div class="container-fluid">
		<div class="block-header"><h2>BUDGET</h2></div>

		<div class="row clearfix">
			<div class="card">
				<div class="header">
					<ul class="nav nav-tabs tab-nav-right" role="tablist">
						<li role="presentation" class="active"><a href="#manual" data-toggle="tab">Manual Input</a></li>
						<li role="presentation"><a href="#by_upload" data-toggle="tab">Upload</a></li>
						<li role="presentation"><a href="#upload" data-toggle="tab">Upload Baru</a></li>
						<li role="presentation"><a href="#uploadstp" data-toggle="tab">Upload STP</a></li>
					</ul>	
				</div>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="manual">
						<div class="header"><h2>INPUT PLAN BUDGET</h2></div>
						<div class="body">
							<form name="form1" id="form1"  class="step_with_validation" method="POST">
								<h3>STEP 1</h3>
								<fieldset>
									<div class="col-sm-3">	 
										<div class="form-group">
											<label>Term</label>
											<div class="input-group form-float">
												<select class="selectpicker" style="width: 100%;"  name="term" id="term" required>
													<option selected="selected" value="">-Pilih Term-</option>
													<?php 
													//$tb_term=odbc_exec($koneksi_lp,"select distinct term from bps_setterm where start_prepaire<=getdate() and finish_term >=getdate() order by term desc");
													$tb_term=odbc_exec($koneksi_lp,"select distinct term from bps_setterm order by term desc");
													$opt_term="";
													while($bar_term=odbc_fetch_array($tb_term)){
														$opt_trm=odbc_result($tb_term,"term");
														$opt_term= $opt_term.'<option value="'.$opt_trm.'">TERM '.$opt_trm.'</option>';
													}
													echo $opt_term;
													?>
												</select>
											</div>
										</div>
										<div class="form-group form-float">
											<label>Periode</label>
											<div class="form-line">
												<input type="number" class="periode form-control" id="periode" name="periode" value="<?php echo date("Ym"); ?>" placeholder="Periode" required>
											</div> 
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group form-float">
											<label>Section</label>
											<div class="input-group form-float">
												<select class="selectpicker" data-live-search="true" style="width: 70%;"  name="sect" id="sect"  required>
													<option selected="selected" value="">---Pilih Section---</option>
													<?php

													$qsect="select distinct dept_code,sect_code from tbl_sect";
													$tb_acc=mysql_query($qsect);
													while($baris1=mysql_fetch_array($tb_acc)){
														$grpdept=$baris1["dept_code"]."-".$baris1["sect_code"];	
														$opt_sect=$opt_sect.'<option value="'.$grpdept.'">'.$grpdept.'</option>';
													}
													echo $opt_sect;
													?>

												</select>
											</div>
										</div>
										<div class="form-group">
											<label>Cost Center</label>
											<div class="input-group form-float">
												<div class="form-line">
													<input type="text" readonly class="form-control bg-grey" id="cccode" name="cccode" placeholder="Cost Center" required>
												</div>
												<span class="input-group-addon">
													<button type="button" class="btn bg-purple waves-effect"  onclick="open_child('template.php?plh=select/plh_cccode.php&o=cccode&k=1','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
												</span>
											</div></div>
										</div>
										<div class="col-sm-3"> 
											<div class="form-group form-float">
												<label>Account</label>
												<div class="input-group">
													<div class="form-line">
														<input type="text"  readonly class="form-control bg-grey" id="account" name="account" placeholder="Account" required>
													</div>
													<span class="input-group-addon">
														<button type="button" class="btn bg-purple waves-effect"  onclick="cr_nm('template.php?plh=select/plh_acc.php&acc=account','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
													</span>

												</div>
											</div>
											<div class="form-group form-float">
												<label>Sub Account</label>
												<div class="input-group">
													<div class="form-line">
														<input type="text"  readonly class="form-control bg-grey" id="sub_acc" name="sub_acc" placeholder="Sub Account" required>
													</div>
													<span class="input-group-addon">
														<button type="button" class="btn bg-purple waves-effect"  onclick="cr_nm('template.php?plh=select/plh_acc.php&acc=sub_acc','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
													</span>

												</div>
											</div> 
										</div>
										<div class="col-sm-3"> 
											<div class="form-group form-float">
												<div class="form-group">
													<label>Purchasing</label>
													<div class="input-group">
														<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="lp" id="lp"  required>
															<option selected="selected" value="">-Pilih Purchasing-</option>
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
												</div>
											</div>
										</div>

									</fieldset>

									<h3>STEP 2</h3>
									<fieldset>
										<div class="col-sm-3">
											<div class="form-group form-float">
												<label>Part No</label>
												<div class="form-line">
													<input type="text"  class="form-control bg-grey" id="part_no" name="part_no" placeholder="Part No" required>
												</div>
											</div>
											<div class="form-group form-float">
												<label>Part Name</label>
												<div class="input-group">
													<div class="form-line">
														<input type="text" class="form-control" id="part_nm" name="part_nm"  placeholder="Nama Part" required>
													</div>
													<span class="input-group-addon">
														<button type="button" class="btn bg-purple waves-effect"  onclick="cr_part('template.php?plh=select/plh_partbud.php','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
													</span>
												</div>
											</div>
										</div>
										<div class="col-sm-9"> 
											<div class="form-group form-float">
												<label>Detail Part</label>
												<div class="form-line">
													<input type="text"  class="form-control bg-grey" id="part_dtl" name="part_dtl" placeholder="Detail Part" required>
												</div>
											</div>
											<div class="form-group form-float">
												<label>Remark Part</label>
												<div class="form-line">
													<input type="text" class="form-control" id="part_desc" name="part_desc" placeholder="Remark Part">
												</div>
											</div>
										</div>
									</fieldset>

									<h3>STEP 3</h3>
									<fieldset>
										<div class="col-sm-3"> 
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
												</div>
											</div>
											<div class="form-group">
												<label>Type</label>
												<div class="input-group">
													<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="jns_bud" id="jns_bud"  required>
														<option selected="selected" value="NORMAL">Normal</option>
														<option value="ADDITIONAL">ADD</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-sm-3"> 
											<div class="form-group">
												<label>Process Code</label>
												<div class="input-group">
													<div class="form-line">
														<input type="text" readonly class="form-control bg-grey" id="id_proses" name="id_proses" placeholder="Kode Proses" required>
													</div> <span class="input-group-addon">
														<button type="button" class="btn bg-purple waves-effect"  onclick="open_child('template.php?plh=select/plh_pros.php','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
													</span>
												</div>
											</div>
										</div>
										<div class="col-sm-6"> 
											<div class="form-group">
												<label>Control No</label>
												<div class="input-group">
													<div class="form-line">
														<input type="text" readonly class="form-control bg-grey" id="no_ctrl" name="no_ctrl" placeholder="No Contro" required>
													</div>
													<span class="input-group-addon">
														<button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl('template.php?plh=select/cek_noctrl.php&o=no_ctrl','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
													</span>
												</div>
											</div>
											<div class="col-sm-3">	 
												<div class="form-group">
													<label>Qty</label>
													<div class="form-line">
														<input type="number" class="form-control" id="qty" name="qty" placeholder="Qty" required>
													</div>
												</div>
											</div>
											<div class="col-sm-3">  
												<div class="form-group">
													<label>UOM</label>
													<div class="form-line">
														<input type="text" readonly class="form-control bg-grey"  id="uom" name="uom" placeholder="Uom" required>
													</div>
												</div>
											</div>
											<div class="col-sm-3"><div class="form-group">
												<label>Currency</label>
												<div class="form-line">
													<input type="text" readonly class="form-control bg-grey"  id="curr" name="curr" placeholder="Currency" required>
												</div>
											</div>
										</div>
										<div class="col-sm-3"><div class="form-group">
											<label>Price</label>
											<div class="form-line">
												<input type="number" class="form-control" id="price" name="price" placeholder="Price" required>
											</div>
										</div>
									</div>
								</div>
							</fieldset>
							<h3>STEP 4</h3>
							<fieldset>
								<div class="row clearfix">	
									<div class="col-sm-2"> 
										<div class="form-group">
											<label>LT Quotation</label>
											<div class="form-line">
												<input type="number" class="form-control" id="lt_Quo" name="lt_Quo" min="0"  placeholder="LT Penawaran" required>
											</div>
										</div>
									</div>
									<div class="col-sm-2"> 
										<div class="form-group">
											<label>LT PR</label>
											<div class="form-line">
												<input type="number" class="form-control" id="lt_pr" name="lt_pr" min="0"  placeholder="LT PR" required>
											</div>
										</div>
									</div> 
									<div class="col-sm-2">
										<div class="form-group">
											<label>LT PO</label>
											<div class="form-line">
												<input type="number" class="form-control" id="lt_po" name="lt_po" min="0" placeholder="LT PO" required>
											</div>
										</div>
									</div>
									<div class="col-sm-2"> 
										<div class="form-group">
											<label>LT Arrival</label>
											<div class="form-line">
												<input type="number" class="form-control" id="lt_datang" name="lt_datang"  min="0"  placeholder="LT Arrival" required>
											</div>
										</div>
									</div>
									<div class="col-sm-2">    
										<div class="form-group">
											<label>LT VP</label>
											<div class="form-line">
												<input type="number" class="form-control" id="lt_vp" name="lt_vp" min="0"  placeholder="LT VP" required>
											</div>
										</div>
									</div>
								</div>    
								<div class="row clearfix">		 
									<button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SAVE</button>		 
									<button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>

								</div>
							</fieldset>
						</form>
					</div>
				</div>

				<div role="tabpanel" class="tab-pane fade" id="by_upload">

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
							</li>
						</ul>
					</div>
					<form role="form" enctype="multipart/form-data" name="form2" id="form2" method="post" action="">
						<div class="body">
							<div class="col-lg-12">
								<div class="col-md-3">	
									<div class="form-group">
										<label>Term</label>
										<div class="input-group">
											<select class="selectpicker"  style="width: 50%;"  name="term_u" id="term_u"  required>
												<option selected="selected" value="">---Pilih Term---</option>
												<?php echo $opt_term; ?>

											</select>
										</div>
									</div>
								</div>
								<div class="col-md-3">	
									<div class="form-group">
										<label>Section</label>
										<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="sect_u" id="sect_u"  required>
											<option selected="selected" value="">---Pilih Section---</option>
											<?php 
											echo $opt_sect;
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Type</label>
										<div class="input-group">
											<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="jns_bud_u" id="jns_bud_u"  required>
												<option selected="selected" value="NORMAL">Normal</option>
												<option value="ADDITIONAL">ADD</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-3">	
									<div class="form-group">
										<label>Open File</label>
										<div class="form-line">
											<input type="file" class="form-control" id="file" name="file" placeholder="Cari File" required>
										</div>
									</div>
								</div>
							</div>
							<div class="row clearfix">	
								<button type="submit" id="upld" name="upld" class="btn bg-orange waves-effect">
									<i class="material-icons">saves</i>Send Format 1</button>
									<button type="submit" id="upld2" name="upld2" class="btn bg-orange waves-effect">
										<i class="material-icons">saves</i>Send Format 2</button> 
									</div>
								</div>
							</form>	
						</div>
						<!-- Start Upload Format Baru -->
						<div role="tabpanel" class="tab-pane fade" id="upload">

							<div class="header">
								<h2>INPUT<small>Upload Data Budget by Section</small></h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);">Action</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<form role="form" enctype="multipart/form-data" name="form3" id="form3" method="post" action="">
								<div class="body">
									<div class="col-lg-12">
										<div class="col-md-3">	
											<div class="form-group">
												<label>Term</label>
												<div class="input-group">
													<select class="selectpicker"  style="width: 50%;"  name="term_u" id="term_u" required>
														<option selected="selected" value="">---Pilih Term---</option>
														<?php 
													//$tb_term=odbc_exec($koneksi_lp,"select distinct term from bps_setterm where start_prepaire<=getdate() and finish_term >=getdate() order by term desc");
													$tb_term=odbc_exec($koneksi_lp,"select distinct term from bps_setterm order by term desc");
													$opt_term="";
													while($bar_term=odbc_fetch_array($tb_term)){
														$opt_trm=odbc_result($tb_term,"term");
														$opt_term= $opt_term.'<option value="'.$opt_trm.'">TERM '.$opt_trm.'</option>';
													}
													echo $opt_term;
													?>
													</select>
												</div>
											</div>
										</div>									
										<div class="col-md-3">	
											<div class="form-group">
												<label>Open File</label>
												<div class="form-line">
													<input type="file" class="form-control" id="file" name="file" placeholder="Cari File" required>
												</div>
											</div>
										</div>
									</div>
									<div class="row clearfix">	
										<button type="submit" id="upld3" name="upld3" class="btn bg-orange waves-effect">
											<i class="material-icons">saves</i>Upload
										</button>
									</div>
								</div>
							</form>	
						</div>
						<!-- End Upload Format Baru -->

					</div>
				</div>
			</div>

			<?php
			if(isset($_POST['smpn']) or isset($_POST['del'])){	
				$sect=$_POST['sect'];
				$term=$_POST['term'];
				$jns_budget=$_POST['jns_bud'];
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
				$qry_add="insert into bps_budget(sect,term,jns_budget,pic_updt,tgl_updt,expaired,
				no_ctrl,lp,id_proses,account,sub_acc,part_no,part_nm,part_desc,part_dtl,periode,qty,uom,price,curr,cccode,phase,lt_Quo,lt_pr,lt_po,lt_datang,lt_vp) values('$sect','$term','$jns_budget','$pic_updt',getdate(),'$expaired','$no_ctrl','$lp','$id_proses','$account','$sub_acc','$part_no','$part_nm','$part_desc','$part_dtl','$periode','$qty','$uom','$price','$curr','$cccode','$phase','$lt_Quo','$lt_pr','$lt_po','$lt_datang','$lt_vp')";
				$qry_addFA="insert into bps_budget_FA(sect,term,jns_budget,pic_updt,tgl_updt,expaired,no_ctrl,lp,id_proses,account,sub_acc,part_no,part_nm,part_desc,part_dtl,periode,qty,uom,price,curr,cccode,phase) values('$sect','$term','$jns_budget','$pic_updt',getdate(),'$expaired','$no_ctrl','$lp','$id_proses','$account','$sub_acc','$part_no','$part_nm','$part_desc','$part_dtl','$periode','$qty','$uom','$price','$curr','$cccode','$phase')";
				$tb_del=odbc_exec($koneksi_lp,"delete from bps_budget ".$qry_del);
				$tb_delFA=odbc_exec($koneksi_lp,"delete from bps_budget_FA ".$qry_del);
				if(isset($_POST['smpn']) ){	
					$tb_add=odbc_exec($koneksi_lp,$qry_add);
					$tb_addFA=odbc_exec($koneksi_lp,$qry_addFA);
					$sq_acc="select *,(qty * price) as amount from bps_budget_FA where no_ctrl='$no_ctrl'";
				}}

				if(isset($_POST['upld']) ){
					require_once "excel_reader2.php";
	echo "<script>alert('upload data');</script>"; 
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
			$sect_u=$data->val(5,2)."-".$data->val(5,4); //$sect_u=$_POST['sect_u'];
			$jns_bud_u=$_POST['jns_bud_u'];
			$pic=$_SESSION['nama'];
			$jmrow=0;
			if($sect_u = $_POST['sect_u']){
				$sql_del=" where term='$term_u' and sect='$sect_u'";
			//echo $sql_del;
				$hilang=odbc_exec($koneksi_lp,"Delete from bps_budget".$sql_del);
				$hilangFA=odbc_exec($koneksi_lp,"Delete from bps_budget_FA".$sql_del);
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
$kolL=str_replace(",","",$data->val($i,12));//QTY
$kolM=$data->val($i,13);//UOM
$kolN=$data->val($i,14);//Currency
$kolO=number_format(str_replace(",","",$data->val($i,15)),10,".","");//PRICE

//$kolP=$data->val($i,16);//AMOUNT
$kolQ=$data->val($i,17);//PHASE
$kolR=$data->val($i,18);//Cv code/cccode
$kolS=$data->val($i,19);//PENAWARAN
$kolT=$data->val($i,20);//PR
$kolU=$data->val($i,21);//PO
$kolV=$data->val($i,22);//KEDATANGAN
$kolW=$data->val($i,23);//VP
$experied=date("Y-m-d",strtotime($kolK."28"));

if($kolB!=""){
	$sql_updt="insert into bps_budget(sect,term,jns_budget,pic_updt,tgl_updt,expaired,no_ctrl,lp,id_proses,account,sub_acc,part_no,part_nm,part_dtl,periode,qty,uom,curr,price,phase,cccode,lt_Quo,lt_pr,lt_po,lt_datang,lt_vp) values('$sect_u','$term_u','$jns_bud_u','$pic',getdate(),'$experied','$kolB','$kolC','$kolD','$kolE','$kolF','$kolH','$kolI','$kolJ','$kolK','$kolL','$kolM','$kolN','$kolO','$kolQ','$kolR','$kolS','$kolT','$kolU','$kolV','$kolW')";	
	$sql_updtFA="insert into bps_budget_FA(sect,term,jns_budget,pic_updt,tgl_updt,expaired,no_ctrl,lp,id_proses,account,sub_acc,part_no,part_nm,part_dtl,periode,qty,uom,curr,price,phase,cccode) values('$sect_u','$term_u','$jns_bud_u','$pic',getdate(),'$experied','$kolB','$kolC','$kolD','$kolE','$kolF','$kolH','$kolI','$kolJ','$kolK','$kolL','$kolM','$kolN','$kolO','$kolQ','$kolR')";
	$hasil = odbc_exec($koneksi_lp,$sql_updt);	
	$hasilFA = odbc_exec($koneksi_lp,$sql_updtFA);
	echo "<br>lht ".$i.$sql_updt;
	if(!$hasilFA){
		echo "<br>Error ".$i.$sql_updt."<br>".$sql_updtFA;
		print(odbc_error());
	}else{ $jmrow++; }
}	}		
unlink($_FILES['file']['name']);	
echo "<script>alert('$jmrow DATA SELESAI DI UPLOAD ');</script>";
$sq_acc="select *,(qty * price) as amount from bps_budget_FA where tgl_updt=getdate() and pic_updt='$pic'";
}else{		
	unlink($_FILES['file']['name']);	
	echo "<script>alert('GAGAL Upload, Dept - Sect Tidak sesuai');</script>";}
}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_budFA.php'</script>"; }

}

if(isset($_POST['upld2']) ){
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
			$sect_u=$data->val(1,8)."-".$data->val(2,8); //$sect_u=$_POST['sect_u'];
			$jns_bud_u=$_POST['jns_bud_u'];
			$pic=$_SESSION['nama'];
			$jmrow=0;
			if($sect_u = $_POST['sect_u']){
				$sql_del=" where term='$term_u' and sect='$sect_u'";
			//echo $sql_del;
				$hilang=odbc_exec($koneksi_lp,"Delete from bps_budget".$sql_del);
				$hilangFA=odbc_exec($koneksi_lp,"Delete from bps_budget_FA".$sql_del);
				for ($i=12; $i<=$fixedbaris; $i++){		
$kolC=$data->val($i,3);//PART NO
$kolD=$data->val($i,4);//PART NAME
$kolE=$data->val($i,5);//DETAIL PART
$kolG=$data->val($i,7);//ACCOUNT
$kolI=$data->val($i,9);//PHASE
$kolJ=$data->val($i,10);//Cv code/cccode
$kolM=$data->val($i,13);//UOM
$kolN=$data->val($i,14);//Currency

$kolBQ=$data->val($i,69);//SUB ACCOUNT
$kolBR=$data->val($i,70);//KODE PROSES
$kolBS=$data->val($i,71);//PURCHASING
$kolBT=$data->val($i,72);//PENAWARAN
$kolBU=$data->val($i,73);//PR
$kolBV=$data->val($i,74);//PO
$kolBW=$data->val($i,75);//KEDATANGAN
$kolBX=$data->val($i,76);//VP

$KP=14;$KQ=38;$KC=77;

for ($n=1; $n<=12; $n++){
	$KQ++;$KC++;$KP++;		
/*if($n<7){	
$prcx=str_replace(",","",$data->val($i,15));//PRICE JUL-DEC
}else{
$prcx=str_replace(",","",$data->val($i,16));//PRICE JAN-JUN
}
*/
//$prcx=number_format($prcy,10,".","");
$prcx=str_replace(",","",$data->val($i,$KP));//PRICE ORI
$qty=str_replace(",","",$data->val($i,$KQ));//QTY
$peri=$data->val(11,$KQ);//PERIODE
$experied=date("Y-m-d",strtotime($peri."28"));
$ctrln=$data->val($i,$KC);//CONTROL NO	

if($kolC!="" and ($qty!="" and $qty>0))
{
	$prc=number_format(str_replace("*","",$prcx),10,".","");
	$sql_updt="insert into bps_budget(sect,term,jns_budget,pic_updt,tgl_updt,expaired,no_ctrl,lp,id_proses,account,sub_acc,part_no,part_nm,part_dtl,periode,qty,uom,curr,price,phase,cccode,lt_Quo,lt_pr,lt_po,lt_datang,lt_vp)
	values('$sect_u','$term_u','$jns_bud_u','$pic',getdate(),'$experied','$ctrln','$kolBS','$kolBR','$kolG','$kolBQ','$kolC','$kolD','$kolE','$peri','$qty','$kolM','$kolN','$prc','$kolI','$kolJ','$kolBT','$kolBU','$kolBV','$kolBW','$kolBX')";

	$sql_updtFA="insert into bps_budget_FA(sect,term,jns_budget,pic_updt,tgl_updt,expaired,no_ctrl,lp,id_proses,account,sub_acc,part_no,part_nm,part_dtl,periode,qty,uom,curr,price,phase,cccode)
	values('$sect_u','$term_u','$jns_bud_u','$pic',getdate(),'$experied','$ctrln','$kolBS','$kolBR','$kolG','$kolBQ','$kolC','$kolD','$kolE','$peri','$qty','$kolM','$kolN','$prc','$kolI','$kolJ')";
	$hasil = odbc_exec($koneksi_lp,$sql_updt);	
	$hasilFA = odbc_exec($koneksi_lp,$sql_updtFA);
//echo "<br>lht ".$i.$sql_updt;
	if(!$hasilFA){
		echo "<br>Error ".$i.$sql_updt."<br>".$sql_updtFA;
		print(odbc_error());
	}else{ $jmrow++; }
}

}


}		
unlink($_FILES['file']['name']);	
echo "<script>alert('$jmrow DATA SELESAI DI UPLOAD ');</script>";
$sq_acc="select *,(qty * price) as amount from bps_budget_FA where tgl_updt=getdate() and pic_updt='$pic'";

}
else{		
	unlink($_FILES['file']['name']);	
	echo "<script>alert('GAGAL Upload, Dept - Sect Tidak sesuai');</script>";}

}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_budFA.php'</script>"; }

}
?>

<?php 
if(isset($_POST['upld3']) ){
	require_once "excel_reader2.php";				
									$file_name = $_FILES['file']['name'];// nama file (tanpa path)								
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
		// $sect_u=$data->val(1,8)."-".$data->val(2,8);
										$sect_u= $_SESSION["area"];
		// $jns_bud_u=$_POST['jns_bud_u'];
										$pic=$_SESSION['nama'];
										$jmrow=0;
		// if($sect_u = $_POST['sect_u'])
		// {
										$sql_del=" where term='$term_u' and sect='$sect_u'";
			//echo $sql_del;
			// $hilang=odbc_exec($koneksi_lp,"Delete from bps_budget".$sql_del);	
			// $hilangFA=odbc_exec($koneksi_lp,"Delete from bps_budget_FA".$sql_del);
										for ($i=12; $i<=$fixedbaris; $i++){
			$kolA=$data->val($i,1); //PART_NO
			$kolB=$data->val($i,2); //PART  NAME
			$kolC=$data->val($i,3); //DETAIL PART
			$kolD=$data->val($i,4); //SECTION CATEGORY
			$kolE=$data->val($i,5); //ACC NO.
			$kolF=$data->val($i,6); //ACCOUNT DESCRIPTION
			$kolG=$data->val($i,7); //CATEGORY
			$kolH=$data->val($i,8); //COST CENTER
			$kolI=$data->val($i,9); //CARLINE
			$kolJ=$data->val($i,10); //CARMAKER
			$kolZ=$data->val($i,26); //SUB ACCOUNT
			$kolAA=$data->val($i,27); //KODE PROSES
			$kolAB=$data->val($i,28); //PURCHASING
			$kolAC=$data->val($i,29); //KODE LEAD TIME
			$no_doc=$term_u."-".$sect_u;

			$KP=14;$K=10;$KC=77;
			for ($n=1; $n<=12; $n++)
			{
				$KP++;$K++;$KC++;
				// $prcx=str_replace(",","",$data->val($i,$KP));//PRICE ORI
				$qty=str_replace(",","",$data->val($i,$K));//QTY
				$peri=$data->val(11,$K);//PERIODE
				$experied=date("Y-m-d",strtotime($peri."28"));
				// $ctrln=$data->val($i,$KC);//CONTROL NO
				$cr_dt=odbc_exec($koneksi_lp, "SELECT count(*) as jm FROM bps_budget_temp $sql_del ");
				$jm=odbc_result($cr_dt, "jm")+1;
				$ctrln=$term_u."-".$jm;//CONTROL NO
				if($kolA!="" and ($qty!="" and $qty>0))
				{
					$periode_price='price'.$n;
					$cr_prc=odbc_exec($koneksi_lp,"select isnull(price,0) as price,uom,curr,lp from mstr_part_ver where part_no='$kolA' and prc='$periode_price' ") ;
					$prcx=odbc_result($cr_prc,'price') ;
					$uom=odbc_result($cr_prc,'uom') ;
					$curr=odbc_result($cr_prc,'curr') ;
					$lp=odbc_result($cr_prc,'lp') ;

					$prc=number_format(str_replace("*","",$prcx),10,".","");
					$sql_updtFA="insert into bps_budget_temp(sect,term,jns_budget,pic_updt,tgl_updt,expaired,no_ctrl,lp,id_proses,account,sub_acc,part_no,part_nm,part_dtl,periode,qty,uom,curr,price,phase,cccode)
					values('$sect_u','$term_u','NORMAL','$pic',getdate(),'$experied','$ctrln','$kolAB','$kolAA','$kolE','$kolZ','$kolA','$kolB','$kolC','$peri','$qty','$uom','$curr',$prc,'$kolI','$kolJ')";

					// $hasil = odbc_exec($koneksi_lp,$sql_updt);	
					$hasilFA = odbc_exec($koneksi_lp,$sql_updtFA);
//$amoun_USD

//echo "<script>window.close();</script>";
					//echo "<script>alert('DATA BERHASIL DISIMPAN DENGAN NO PR $pr_no');</script>";

//echo "<br>lht ".$i.$sql_updt;
					if(!$hasilFA){
						echo "<br>Error ".$i.$sql_updt."<br>".$sql_updtFA;
						print(odbc_error());
					}else{ 
						$jmrow++; 
					}
				}
			}
		}
		unlink($_FILES['file']['name']);	
		echo "<script>alert('$jmrow DATA SELESAI DI UPLOAD ');</script>";
		$sq_acc="select *,(qty * price) as amount from bps_budget_temp where tgl_updt=getdate() and pic_updt='$pic'";
	}
	else{ 
		echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_budFA.php'</script>";
	}
}
?> 
<div class="row clearfix">
	<div class="card">
		<div class="row clearfix">				
			<div class="header">
				<h2>Record<small>Plan Budget</small></h2>
			</div>
			<div class="body">
				<form action="" id="frmcari" method="post"  enctype="multipart/form-data">
					<div class="col-md-2">	
						<div class="form-group">
							<div class="input-group">
								<select class="selectpicker" style="width: 50%;"  name="term_cr" id="term_cr"  required>
									<option selected="selected" value="">---Pilih Term---</option>
									<?php echo $opt_term; ?>

								</select>
							</div>
						</div>
					</div>

					<div class="col-md-2">	
						<div class="form-group">
							<div class="input-group">
								<select class="selectpicker" style="width: 100%;"  name="sect_cr" id="sect_cr"  required>
									<option selected="selected" value="">---Pilih Section---</option>
									<option value="all">Semua Section</option>
									<?php 
									echo $opt_sect;
									?>

								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-2">	
						<div class="form-group">
							<div class="input-group">
								<select class="selectpicker" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
									<option selected="selected" value="">---Pilih Kolom---</option>
									<option value="no_ctrl">CONTROL NO</option>
									<option value="lp">PURCHASING</option>
									<option value="id_proses">PROCESS CODE</option>
									<option value="account">ACCOUNT</option>
									<option value="sub_acc">SUB ACCOUNT</option>
									<option value="part_no">PART NO</option>
									<option value="part_nm">PART NAME</option>
									<option value="part_dtl">DETAIL PART</option>
									<option value="periode">PERIODE</option>
									<option value="phase">PHASE</option>
									<option value="cccode">CC CODE</option>
									<option value="qty">QTY</option>
									<option value="uom">UOM</option>
									<option value="price">PRICE</option>
									<option value="curr">CURRENCY</option>
									<option value="expaired">EXPAIRED DATE</option>
								</select>
							</div>
						</div>
					</div>

					<div class="col-sm-4">	
						<div class="form-group">
							<div class="form-line">
								<input type="text"  class="form-control" data-role="tagsinput" id="txt_cari" name="txt_cari" placeholder="Detail Pencarian">
							</div> 
						</div>
					</div>

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
								<th>PART DESCRIPTION</th>
								<th>PERIODE</th>
								<th>QTY</th>
								<th>UOM</th>
								<th>CURR</th>
								<th>PRICE</th>
								<th>AMOUNT</th>
								<th>PHASE</th>
								<th>CC CODE</th>
								<th>EXPAIRED DATE</th>
								<!--th>VP</th>
								<th>KEDATANGAN</th>
								<th>PO</th>
								<th>PR</th>
								<th>PENAWARAN</th-->

							</tr>
						</thead>

						<tbody>
							<?php
							if(isset($_POST['cr_b']) ){	
								$term_cr=$_POST['term_cr'];
								$sect_cr=$_POST['sect_cr'];
								if($sect_cr=="all"){$whr0="";}else{$whr0=" and sect='$sect_cr'";}
								//$cmd_tbl=$_POST['cmd_tbl'];
								//if($cmd_tbl=="real"){$tbl="";}else{$tbl="_temp";}
								$cmd_cari=$_POST['cmd_cari'];
								$txt_cari=str_replace(" ","",$_POST['txt_cari']);
								if($txt_cari==""){$whr=""; }else{
									$whr=" and replace($cmd_cari,' ','') like '%$txt_cari%'";}
									$sq_acc="select *,(qty * price) as amount from bps_budget_FA where term='$term_cr' $whr0 $whr";
								}
								if(isset($_POST['smpn']) or isset($_POST['upld']) or isset($_POST['cr_b'])){
									$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
									$row=0;
									while($baris1=odbc_fetch_array($tb_acc)){ $row++;
										$expaired=odbc_result($tb_acc,"expaired");
										$curr=odbc_result($tb_acc,"curr");
										$price=odbc_result($tb_acc,"price");
										if($curr=="USD"){$harga=number_format($price,18);}else{$harga=$price;}
										
										$qty=odbc_result($tb_acc,"qty");
										/*$lt_vp=Odbc_result($tb_acc,"lt_vp");
										$lt_datang=odbc_result($tb_acc,"lt_datang");
										$lt_po=odbc_result($tb_acc,"lt_po");
										$lt_pr=odbc_result($tb_acc,"lt_pr");
										$lt_Quo=odbc_result($tb_acc,"lt_Quo");
										$lt_datang_cumm=$lt_datang+$lt_vp;
										$lt_po_cumm=$lt_po+$lt_datang_cumm;
										$lt_pr_cumm=$lt_pr+$lt_po_cumm;
										$lt_Quo_cumm=$lt_Quo+$lt_pr_cumm;
										*/				?>	
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
											<td><?php echo odbc_result($tb_acc,"part_nm"); ?></td>
											<td><?php echo odbc_result($tb_acc,"part_dtl"); ?></td>
											<td><?php echo odbc_result($tb_acc,"part_desc"); ?></td>
											<td><?php echo odbc_result($tb_acc,"periode"); ?></td>
											<td><?php echo $qty;?></td>
											<td><?php echo odbc_result($tb_acc,"uom"); ?></td>
											<td><?php echo odbc_result($tb_acc,"curr"); ?></td>
											<td><?php echo $harga; ?></td>
											<td><?php echo $qty*$price; ?></td>
											<td><?php echo odbc_result($tb_acc,"phase"); ?></td>
											<td><?php echo odbc_result($tb_acc,"cccode"); ?></td>
											<td><?php echo date("Y-m-d",strtotime($expaired)); ?></td>
										<!--td><?php// echo "($lt_vp) ".date('Y-m-d', strtotime($expaired. " - $lt_vp days")); ?></td>
										<td><?php// echo "($lt_datang) ".date('Y-m-d', strtotime($expaired. " - $lt_datang_cumm days")); ?></td>
										<td><?php// echo "($lt_po) ".date('Y-m-d', strtotime($expaired. " - $lt_po_cumm days")); ?></td>
										<td><?php// echo "($lt_pr) ".date('Y-m-d', strtotime($expaired. " - $lt_pr_cumm days")); ?></td>
										<td><?php// echo "($lt_Quo)) ".date('Y-m-d', strtotime($expaired. " - $lt_Quo_cumm days")); ?></td-->
									</tr>	
									<?php 
								}
							}
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
		var kd_pel0=row.cells[0].innerHTML;
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
		var kd_pel11=row.cells[11].innerHTML;
		var kd_pel12=row.cells[12].innerHTML;
		var kd_pel13=row.cells[13].innerHTML;
		var kd_pel14=row.cells[14].innerHTML;
		var kd_pel15=row.cells[15].innerHTML;
		var kd_pel16=row.cells[16].innerHTML;
		var kd_pel17=row.cells[17].innerHTML;
		var kd_pel18=row.cells[18].innerHTML;
		var kd_pel19=row.cells[19].innerHTML;
		var kd_pel20=row.cells[20].innerHTML;
//document.form1.sect.value=kd_pel0;
//document.form1.term.value=kd_pel1;
//document.form1.jns_bud.value=kd_pel2;
document.form1.no_ctrl.value=kd_pel3;
//document.form1.lp.value=kd_pel4;
document.form1.id_proses.value=kd_pel5;
document.form1.account.value=kd_pel6;
document.form1.sub_acc.value=kd_pel7;
document.form1.part_no.value=kd_pel8;
document.form1.part_nm.value=kd_pel9;
document.form1.part_dtl.value=kd_pel10;
document.form1.part_desc.value=kd_pel11;
document.form1.periode.value=kd_pel12;
document.form1.qty.value=kd_pel13;
document.form1.uom.value=kd_pel14;
document.form1.curr.value=kd_pel15;
document.form1.price.value=kd_pel16;

//document.form1.phase.value=kd_pel18;
document.form1.cccode.value=kd_pel19;
}
</script>			