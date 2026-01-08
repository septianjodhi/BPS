<script type="text/javascript">
	function open_child(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
		
	};	
	function cr_nm(url,title,w,h){
		var lp=document.form1.lp.value;
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url+'&lp='+lp, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
		
	};
</script>

<?php
$pic=$_SESSION['nama'];
$area=$_SESSION['area'];
$akses_user=$_SESSION['akses'];
$cek_adm=strpos($akses_user,"ADM_FA");
$cek_lp=strpos($akses_user,"LP");
$pc_area=explode("-", $area);
$sect=$pc_area[1];
?>

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>PERUBAHAN PART NO</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-9">
				<div class="card">
					<div class="header">
						<h2>INPUT<small>Manual Input Perubahan Part No</small></h2>
					</div>
					<div class="body">
						<form role="form"  name="form1" id="form1" method="post" action="">
							<div class="row clearfix">
								<input type="hidden" name="lp" id="lp" value="<?= $sect ; ?>">
								<input type="hidden" name="id_no" id="id_no">
          			<!-- <div class="col-md-3">	
          				<div class="form-group">
          					<label>Purchasing</label>
          					<div class="form-line">
          						<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="lp" id="lp"  required>
          							<option value="">--Pilih lp--</option>
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
          			</div> -->
          			<div class="col-md-4">
          				<div class="form-group">
          					<label>Part No</label>
          					<div class="input-group">
          						<div class="form-line">
          							<input type="text" class="form-control" id="old_part" name="old_part" placeholder="Old Part No" required>
          						</div>
          						<span class="input-group-addon">
          							<button type="button" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float"  onclick="cr_nm('template.php?plh=select/plh_part.php','Data Part Np','800','500'); return false;"><i class="material-icons">search</i> </button>
          						</span>

          					</div>
          				</div>
          			</div>
          			<div class="col-md-4">				
          				<div class="form-group">
          					<label>New Part No</label>
          					<div class="form-line">
          						<input type="text" class="form-control" id="new_part" name="new_part" placeholder="New Part No" required>
          					</div>
          				</div>				
          			</div>

          			<div class="col-md-4">
          				<div class="form-group">
          					<label>Keterangan</label>
          					<div class="form-line">
          						<input type="text" class="form-control" id="ket" name="ket" placeholder="Keterangan" required>
          					</div>
          				</div>
          			</div>

          		</div>
          		<div class="row clearfix">		 
          			<button type="submit" id="smpn_acc" name="smpn" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>		 
          			<button type="submit" id="del_acc" name="del" class="btn bg-red waves-effect"><i class="material-icons">delete</i>Delete</button>
          		</div>  
          	</form>
          </div></div>	                   
        </div>
        <?php
        if(isset($_POST['smpn']) or isset($_POST['del'])){	
        	$old_part=$_POST['old_part'];
        	$id_no=$_POST['id_no'];
        	$new_part=$_POST['new_part'];
        	$ket=$_POST['ket'];
        	$pic=$_SESSION['nama'];
        }
        if(isset($_POST['smpn']) ){
        	if($id_no!=""){
        		$qry_del="update bps_part set status_part='non aktif',tgl_ubah=getdate() where part_no='$id_no' and lp='$sect' ";
        		$qry_updt="update bps_chgpart set new_part='$new_part',tgl_updt=getdate() where new_part='$id_no' and old_part='$old_part' ";
        		$tb_updt=odbc_exec($koneksi_lp,$qry_updt);
        	}else{
        		$qry_del="update bps_part set status_part='non aktif',tgl_ubah=getdate() where part_no='$old_part' and lp='$sect' ";
        		$qry_add2="insert into bps_chgpart ( old_part,new_part,ket,pic_updt,tgl_c,tgl_updt) values( '$old_part','$new_part','$ket','$pic',getdate(),getdate())";
        		$tb_add2=odbc_exec($koneksi_lp,$qry_add2);
        	}
        	$tb_del=odbc_exec($koneksi_lp,$qry_del);
        	$cek_part="select count (*) as cc from bps_part where part_no='$new_part' ";
        	$cc=odbc_result(odbc_exec($koneksi_lp, $cek_part), "cc");

        	if($cc==0)
        	{
        		$qry_add1="insert into bps_part ( part_no,part_nm,part_grp,part_kat,part_dtl,uom,curr,price1,price2,price3,price4,price5,price6,price7,price8,price9,price10,price11,price12,lp,kat_tax,kd_proses,kd_lt,status_part,pic_updt,tgl_updt,tgl_ubah ) select top 1 '$new_part' as part_no,part_nm,part_grp,part_kat,part_dtl,uom,curr,price1,price2,price3,price4,price5,price6,price7,price8,price9,price10,price11,price12,'$sect' as lp, kat_tax, kd_proses, kd_lt,'aktif' as status_part,'$pic' as pic_updt,getdate() as tgl_updt,getdate() as tgl_ubah from bps_part where part_no='$old_part' and lp='$sect' order by tgl_updt desc ";
        		$tb_add1=odbc_exec($koneksi_lp,$qry_add1);
        	}
        	else{
        		$updt_part=odbc_exec($koneksi_lp," update bps_part set tgl_ubah=getdate() where part_no='$new_part' and lp='$sect' ");
        	}
      	// echo $qry_add1;
        	
        }
        if(isset($_POST['del'])){
        	$del=odbc_exec($koneksi_lp,"Delete from bps_chgpart where new_part='$id_no' and old_part='$old_part'");
        	$qry_updt=odbc_exec($koneksi_lp,"update bps_part set status_part='non aktif' where part_no='$id_no' and lp='$sect' ");
        	$qry_updt2=odbc_exec($koneksi_lp,"update bps_part set status_part='aktif' where part_no='$old_part' and lp='$sect' ");
        	echo "<script>alert('Part No $id_no berhasil dihapus');</script>"; 
        }
        ?>	 
        <div class="col-lg-3">
        	<div class="card">
        		<div class="header">
        			<h2>INPUT<small>Upload Perubahan Part No</small></h2>
        			<ul class="header-dropdown m-r--5">
        				<li class="dropdown">
        					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        						<i class="material-icons">more_vert</i>
        					</a>
        					<ul class="dropdown-menu pull-right">
        						<li><a href="template/Master_Perubahan_Part_No.xls">Download Form</a></li>
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
			$dataok=0;$datan=0;			
			$pic=$_SESSION['nama'];
			for ($i=6; $i<=$fixedbaris; $i++){		
			$kolA=$data->val($i,1);//No	
			$kolB=$data->val($i,2);//Old Part
			$kolC=$data->val($i,3);//New Part
			$kolD=$data->val($i,4);//New Part

			if($kolB!=""){
				$updt_part="update bps_part set status_part='non aktif',tgl_ubah=getdate() where part_no='$kolB' and lp='$sect' ";
				$tb_updtpart=odbc_exec($koneksi_lp,$updt_part);

				$cr_part=odbc_exec($koneksi_lp, "Select isnull(count(*),0) as jml from bps_chgpart where old_part='$kolB' ");
				$jml_part=odbc_result($cr_part, "jml") ;

				if($jml_part==0){
					$qry_add="insert into bps_chgpart ( old_part,new_part,ket,pic_updt,tgl_c,tgl_updt) values( '$kolB','$kolC','$kolD','$pic',getdate(),getdate())";
				}else{
					$qry_add="update bps_chgpart set new_part='$kolC',tgl_updt=getdate() where new_part='$kolC' and old_part='$kolB' ";
				}

				$hasil=odbc_exec($koneksi_lp,$qry_add);

				$cr_part2=odbc_exec($koneksi_lp, "Select isnull(count(*),0) as jml2 from bps_part where part_no='$kolC' ");
				$jml_part2=odbc_result($cr_part2, "jml2") ;
				if($jml_part2==0)
				{
					$qry_add1="insert into bps_part ( part_no,part_nm,part_grp,part_kat,part_dtl,uom,curr,price1,price2,price3,price4,price5,price6,price7,price8,price9,price10,price11,price12,lp,kat_tax,kd_proses,kd_lt,status_part,pic_updt,tgl_updt,tgl_ubah ) select top 1 '$kolC' as part_no,part_nm,part_grp,part_kat,part_dtl,uom,curr,price1,price2,price3,price4,price5,price6,price7,price8,price9,price10,price11,price12,'$sect' as lp, kat_tax, kd_proses, kd_lt,'aktif' as status_part,'$pic' as pic_updt,getdate() as tgl_updt,getdate() as tgl_ubah from bps_part where part_no='$kolB' and lp='$sect' order by tgl_updt desc ";
				}
				else{
					$qry_add1=" update bps_part set tgl_ubah=getdate() where part_no='$kolC' and lp='$sect' ";
				}
				
				$tb_add1=odbc_exec($koneksi_lp,$qry_add1);

//echo "<br>lht ".$i.$query1;
				if(!$hasil){
					echo "<br>Error ".$i.$sql_updt;
					print(odbc_error());
					$datan++;
				}else{
					$dataok++;
				}
			}
		}
		unlink($_FILES['file']['name']);	
		echo "<script>alert('Selesai $dataok data OK, $datan Data Gagal');</script>"; 
	}else{ echo "<script>alert('Format file harus XLS'); window.location = '?page=form/inpt_car.php'</script>"; }

}
?>	 
<div class="row clearfix">
	<div class="card">
		<div class="row clearfix">				
			<div class="header">
				<h2>Record<small>Cari Sub Account</small></h2>
			</div>
			<div class="body">
				<form action="" id="frmcari" method="post"  enctype="multipart/form-data">

					<div class="col-sm-3">	
						<div class="form-group">
							<!--label>Kolom</label-->
							<select class="selectpicker" data-live-search="true" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
								<option selected="selected" value="">---Pilih Kolom---</option>
								<option value="acc_no">Old Part No</option>
								<option value="acc_sub">New Part No</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6">	
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
									<th>No</th>
									<th>Old Part No</th>
									<th>New Part No</th>
									<th>Keterangan</th>
									<th>Pic Update</th>
								</tr>
							</thead>

							<tbody>
								<?php
								if(isset($_POST['cr_b']) ){	
									$cmd_cari=$_POST['cmd_cari'];
									$txt_cari=str_replace(" ","",$_POST['txt_cari']);
									if($txt_cari==""){$whr="old_part is not null"; }else{
										$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
										$sq_acc="select * from bps_chgpart where $whr";
										$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
										$row=0;
										while($baris1=odbc_fetch_array($tb_acc)){ $row++;
											?>	
											<tr  onclick="javascript:pilih(this);">
												<td><?php echo $row; ?></td>
												<td><?php echo odbc_result($tb_acc,"old_part"); ?></td>
												<td><?php echo odbc_result($tb_acc,"new_part"); ?></td>
												<td><?php echo odbc_result($tb_acc,"ket"); ?></td>
												<td><?php echo odbc_result($tb_acc,"pic_updt"); ?></td>
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
		document.form1.old_part.value=kd_pel1;
		document.form1.new_part.value=kd_pel2;
		document.form1.ket.value=kd_pel3;
		document.form1.id_no.value=kd_pel2;

	}
</script>