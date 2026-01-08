<script type="text/javascript">
	function open_child(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};

	function cr_sign(url,title,w,h){
		var jns_dok=document.form1.jns_dok.value;
		if(jns_dok=="")
		{
			alert("Jenis Dokumen Belum dipilih");
		}
		else{
			var left = (screen.width/2)-(w/2);
			var top = (screen.height/2)-(h/2);
			w = window.open(url+'&j='+jns_dok, title, 'toolbar=no, location=no, directories=no, \n\
				status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
				width='+w+',height='+h+',top='+top+',left='+left);		
		}
	};
</script>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>MASTER APPROVE</h2>
		</div>
		<div class="row clearfix">
			<!-- <div class="col-md-12"> -->
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Manual Input Master Approval</small></h2>
					</div>
					<div class="body">
						<form role="form"  name="form1" id="form1" method="post" action="">
							<div class="row clearfix">
								<div class="col-md-4">
									<div class="form-group">
										<label>NIK</label>
										<div class="input-group">
											<div class="form-line">
												<input type="text" class="form-control" id="nik" name="nik" placeholder="NIK" required>
											</div>
											<span class="input-group-addon">
												<button type="button" class="btn bg-purple waves-effect"  onclick="open_child('template.php?plh=select/plh_nik.php','800','300'); return false;"><i class="material-icons">search</i> </button>
											</span>
										</div>
									</div>
									<div class="form-group">
										<label>ID APPROVAL</label>
										<div class="input-group">
											<div class="form-line">
												<input type="text" class="form-control" id="sign" name="sign" placeholder="ID APPROVAL" readonly required>												
											</div>
											<span class="input-group-addon">
												<button type="button" class="btn bg-purple waves-effect"  onclick="cr_sign('template.php?plh=select/plh_appr.php','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
											</span>
										</div>
									</div>
									<div class="form-group">
										<label>EMAIL</label>
										<div class="form-line">
											<input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
										</div>
									</div>								
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>NAMA</label>
										<div class="form-line">
											<input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>AREA</label>
										<div class="form-line">
											<input type="text" class="form-control" id="area" name="area" placeholder="AREA" required>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Initial</label>
										<div class="form-line">
											<input type="text" class="form-control" id="initial" name="initial" placeholder="initial" required>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>JENIS DOKUMEN</label>			
										<div class="input-group">
											<select class="selectpicker" style="width: 100%;"  name="jns_dok" id="jns_dok"  required>
												<option selected="selected" value="">---Pilih Dokumen---</option>
												<option>PR</option>
												<option>PO</option>
												<option>ADD</option>
												<option>VP</option>
												<option>KONTRAK</option>
												<option>INV</option>
												<?php
												/*
												$cr_set="select distinct jns_dok from bps_setApprove union select distinct jns_dok from (select 'PO'[PO],'PR'[PR],'VP'[VP],'ss'[ADD]) tbl unpivot(x for jns_dok in(PO,PR,VP,[ADD])) PVT";
												$qry_cr=odbc_exec($koneksi_lp,$cr_set);
												$row=0;
												while (odbc_fetch_array($qry_cr)) 
												{
													$row++;
													$jns_dok=odbc_result($qry_cr, "jns_dok");
													echo "<option value='$jns_dok'>$jns_dok</option>";
												}
												*/
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>STATUS</label>			
										<div class="input-group">
											<select class="selectpicker" style="width: 100%;"  name="status" id="status"  required>
												<option selected="selected" value="">---Pilih Status---</option>
												<option value="aktif">AKTIF</option>
												<option value="tidak aktif">TIDAK AKTIF</option>
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-2">
									<div class="form-group">
										<label>JABATAN</label>
										<div class="form-line">
											<input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="JABATAN" required>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>MIN AMOUNT</label>
										<div class="form-line">
											<input type="number" class="form-control" id="min_amn" name="min_amn" placeholder="Min Amount">
										</div>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>MAX AMOUNT</label>
										<div class="form-line">
											<input type="number" class="form-control" id="max_amn" name="max_amn" placeholder="Max Amount">
										</div>
									</div>
								</div>
								<div class="col-md-4">
									
								</div>
							</div>
							<button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>
							<button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>HAPUS</button>
						</form>
					</div>
				</div>	                   
				<!-- </div> -->
				<?php
				$pic=$_SESSION['nama'];
				$sect=$_SESSION['area'];
				$pc_sect=explode("-", $sect);
				$dept=$pc_sect[0];

				if(isset($_POST['smpn']) or isset($_POST['del'])){	
					$nik=$_POST['nik'];	
					$email=$_POST['email'];
					$nama=$_POST['nama'];
					$initial=$_POST['initial'];
					$jabatan=$_POST['jabatan'];
					$jns_dok=$_POST['jns_dok'];
					$status=$_POST['status'];
					$min_amn=$_POST['min_amn'];
					$max_amn=$_POST['max_amn'];
					$area=$_POST['area'];
					$sign=$_POST['sign'];
					$pch_sign=explode('-', $sign);
					$no_aprv=$pch_sign[0];
					$approve=$pch_sign[1];


					$qry_del="delete from bps_setApprove where jns_dok='$jns_dok' and jabatan='$jabatan' 
					and (nik='$nik' or nama='$nama' or initial='$initial' ) and sect='$area' ";
					$qry_add="insert into bps_setApprove( nik,initial,nama,email,sect,approve,pic_updt,tgl_updt,jabatan,no_aprv,jns_dok,min_amount,max_amount,status_akun ) values
					('$nik','$initial','$nama','$email','$area','$pch_sign[1]','$pic',getdate(),'$jabatan',
					'$no_aprv','$jns_dok','$min_amn','$max_amn','$status')";
					$tb_del=odbc_exec($koneksi_lp,$qry_del);

				}
				if(isset($_POST['smpn']) ){	
					$tb_add=odbc_exec($koneksi_lp,$qry_add);
					echo "<script>alert('Data Berhasil disimpan'); 
					window.location = '?page=90003'</script>";
					$sq_crpart="select * from bps_setApprove where initial='$initial' and jns_dok='$jns_dok' ";
				}
				?>

			<?php /*
			<div class="col-md-3">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Upload Master Part</small></h2>
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
					<div class="body">
						<form role="form" enctype="multipart/form-data" name="form2" id="form2" method="post" action="">
							<div class="form-group">
								<label>Open File</label>
								<div class="form-line">
									<input type="file" class="form-control" id="file" name="file" placeholder="Cari File" required>
								</div>
							</div>
							<button type="submit" id="upld" name="upld" class="btn bg-orange waves-effect">
								<i class="material-icons">saves</i>UPLOAD
							</button>
						</form>
					</div>
				</div>	                   
			</div>
			*/ ?>

		</div>
		<?php
		if(isset($_POST['upld']) )
		{
			require_once "excel_reader2.php";
	//	echo "<script>alert('upload data');</script>"; 
			//nama file (tanpa path)
			$file_name = $_FILES['file']['name']; 
		//nama local temp file di server
			$tmp_name  = $_FILES['file']['tmp_name']; 
		//ukuran file (dalam bytes)
			$file_size = $_FILES['file']['size']; 
		//tipe filenya (langsung detect MIMEnya)
			$file_type = $_FILES['file']['type']; 
		// open file (read-only, binary)
			$fp1 = fopen($tmp_name, 'r'); 
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
				$dataok=0;$datan=0;			
				$pic=$_SESSION['nama'];
				for ($i=5; $i<=$fixedbaris; $i++)
				{
					//NO
					$kolA=$data->val($i,1);
					//PURCHASING
					$kolB=$data->val($i,2);
					//KATEGORI
					$kolC=$data->val($i,3);
					//PART NAME
					$kolD=$data->val($i,4);
					//PART NO
					$kolE=$data->val($i,5);
					//PART DETAIL
					$kolF=$data->val($i,6);
					//UOM
					$kolG=$data->val($i,7);
					//CURRENCY
					$kolH=$data->val($i,8);
					//PRICE1
					$kolI=$data->val($i,9);
					//PRICE2
					$kolJ=$data->val($i,10);
					// $kolI=str_replace(",","",$kolI);
					// $kolJ=str_replace(",","",$kolJ);

					if($kolE!=""){
						// $qry_del="delete from bps_setApprove where jns_dok='$jns_dok' and jabatan='$jabatan' and (nik='$nik' or nama='$nama' or initial='$initial' ) ";
						// $qry_add="insert into bps_setApprove( nik,initial,nama,email,sect,approve,pic_updt,tgl_updt,jabatan,no_aprv,jns_dok,min_amount,max_amount,status_akun ) values
						// ('$nik','$initial','$nama','$email','$area','$sign','$pic',getdate(),'$jabatan',
						// '$no_aprv','$jns_dok','$min_amn','$max_amn','$status')";

						$sql_del="delete from bps_part where part_no='$kolE'";
						$hilang=odbc_exec($koneksi_lp,$sql_del);	
						$sql_updt="insert into  bps_part(part_grp,part_kat,part_nm,part_no,part_dtl,uom,curr,price1,price2,pic_updt,tgl_updt) values('$kolB','$kolC','$kolD','$kolE','$kolF','$kolG','$kolH','$kolI','$kolJ','$pic',getdate())";
						$hasil = odbc_exec($koneksi_lp, $sql_updt);
//echo "<br>lht ".$i.$sql_updt;
						if(!$hasil){
							echo "<br>Error ".$i.$sql_updt;
							$datan++;
							print(odbc_error());
						}else{$dataok++;}
					}
				}
				unlink($_FILES['file']['name']);	
				$sq_crpart="select * from bps_part where tgl_updt=getdate()";
				echo "<script>alert('Selesai $dataok data OK, $datan Data Gagal');'</script>";
			}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_part.php'</script>"; }
		}
		?>
		<div class="row clearfix">
			<div class="card">
				<div class="row clearfix">				
					<div class="header">
						<h2>Record<small>Lihat Data Approval</small></h2>
					</div>
					<div class="body">
						<form action="" id="frmcari" method="post"  enctype="multipart/form-data">

							<div class="col-sm-3">	
								<div class="form-group">
									<!--label>Kolom</label-->
									<select class="selectpicker" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
										<option selected="selected" value="">---Pilih Kolom---</option>
										<option value="nik">NIK</option>
										<option value="initial">INITIAL</option>
										<option value="nama">NAMA</option>
										<option value="sect">SECT</option>
										<option value="jabatan">JABATAN</option>
										<option value="no_aprv">NO_APRV</option>
										<option value="jns_dok">JNS_DOK</option>
										<option value="status_akun">STATUS_AKUN</option>
									</select>
								</div>
							</div>
							
							<div class="col-sm-6">	
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
										<th>No</th>
										<th>NIK</th>
										<th>Initial</th>
										<th>Nama</th>
										<th>Email</th>
										<th>Sect</th>
										<th>Approve</th>
										<th>Jabatan</th>
										<th>Jenis Dokumen</th>
										<th>Min Amount</th>
										<th>Max Amount</th>
										<th>Status_Akun</th>
										<!-- <th>Pic Updt</th> -->
										<th>Tgl Updt</th>
									</tr>
								</thead>

								<tbody>
									<?php
									if(isset($_POST['cr_b']) ){	
										$cmd_cari=$_POST['cmd_cari'];
										if ($sect=='FA-FIN' or $sect=='PGA-IT')
										{
											$wh_sect=" where sect is not null ";
										}else
										{
											$wh_sect=" where sect like '$dept%' ";
										}
										$txt_cari=str_replace(" ","",$_POST['txt_cari']);
										if($txt_cari==""){$whr=""; }else{
											$whr=" and replace($cmd_cari,' ','') like '%$txt_cari%'";}
											$sq_crpart="select * from bps_setApprove $wh_sect $whr";
										}

										// echo $sq_crpart;
										if(isset($_POST['smpn']) or isset($_POST['cr_b']))
										{	
											$tb_acc=odbc_exec($koneksi_lp,$sq_crpart);
											$row=0;
											while($baris1=odbc_fetch_array($tb_acc))
											{
												$row++;
												$aprv=odbc_result($tb_acc,"approve");
												$n_aprv=odbc_result($tb_acc,"no_aprv");
												?>	
												<tr  onclick="javascript:pilih(this);">
													<td><?php echo $row; ?></td>
													<td><?php echo odbc_result($tb_acc,"nik"); ?></td>
													<td><?php echo odbc_result($tb_acc,"initial"); ?></td>
													<td><?php echo odbc_result($tb_acc,"nama"); ?></td>
													<td><?php echo odbc_result($tb_acc,"email"); ?></td>
													<td><?php echo odbc_result($tb_acc,"sect"); ?></td>
													<td><?php echo $n_aprv.'-'.$aprv; ?></td>
													<td><?php echo odbc_result($tb_acc,"jabatan"); ?></td>
													<td><?php echo odbc_result($tb_acc,"jns_dok"); ?></td>
													<td><?php echo number_format(odbc_result($tb_acc,"min_amount")); ?></td>
													<td><?php echo number_format(odbc_result($tb_acc,"max_amount")); ?></td>
													<td><?php echo odbc_result($tb_acc,"status_akun"); ?></td>
													<!-- <td><?php //echo odbc_result($tb_acc,"pic_updt"); ?></td> -->
													<td><?php echo odbc_result($tb_acc,"tgl_updt"); ?></td>
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

	<script>
		function pilih(row){
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
			document.form1.nik.value=kd_pel1;
			document.form1.initial.value=kd_pel2;
			document.form1.nama.value=kd_pel3;
			document.form1.email.value=kd_pel4;
			document.form1.area.value=kd_pel5;
			document.form1.sign.value=kd_pel6;
			document.form1.jabatan.value=kd_pel7;
			// document.form1.jns_dok.value=kd_pel8;
			document.form1.min_amount.value=kd_pel9;
			document.form1.max_amount.value=kd_pel10;
			document.form1.status_akun.value=kd_pel11;
		}
	</script>