
<?php
/*
include "../koneksi.php";
*/
$skrg=date("Y-m-d H:i:s");
$periode=date("Ym");
?>

<script type="text/javascript">
	function open_child(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
		
	}; 
	
		function cr_data(url){
			var dep=document.form.dept.value;
			var shf=document.form.shf.value;
			var id_cv=document.form.id_cv.value;
			var cln=document.form.hdr_cln.value;
			var cv=document.form.hdr_CV.value;
			var jbtn=document.form.jbtn.value;
	//if(dep=='' || shf==''){
	//alert("DATA TIDAK LENGKAP., Departement harus diisi");}
	//else{
		//document.form.nik.value='';
		var alamat=url+"?dept="+dep+"&shf="+shf+"&area="+id_cv+"-"+cln+"-"+cv+"-"+jbtn;
		alamat=alamat.replace(" ","%20");
	//alert(alamat);
	$("#data_kk").empty();
	$("#data_kk").load(alamat);
	//}
};
</script>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Purchase Requisition Budget Invest</h2>
		</div>
		<div class="row clearfix">	
			<div class="card">
				<div class="row clearfix">		
					<div class="header">
						<h2>Record<small>Cari Budget untuk Pembbuatan PR</small></h2>
					</div>
					<div class="body">
						<form role="form"  name="form" id="form" method="post" action="">
							<div class="box-body">
								<!--start col-md-6 -->
								<div class="col-md-6">

									<div class="col-md-12">
										<div class="form-group">
											<label>NAMA TRAINING</label>
											<div class="input-group input-group-sm">
												<input type="text" readonly class="form-control" name="nm_trn" id="nm_trn" value=""  placeholder="Nama Training">
												<span class="input-group-btn">
													<button type="button" class="btn btn-info btn-flat" onclick="open_child('template.php?page=select/cr_jdwltrn.php','Data Conveyor','800','500'); return false;" >
														<i class="fa fa-search"></i>
													</button>
												</span>
							<?php /*
							<select class="form-control" style="width: 100%;"  name="nm_trn" id="nm_trn" required>
								<option selected="selected" value="">--Pilih Nama Training--</option>
								<?php
								$sql_stkz="select distinct item_trn,kd_itm FROM TR_msLVL";
								$tb_stkz=odbc_exec($koneksi,$sql_stkz);
								while(odbc_fetch_array($tb_stkz))
								{	
								$item_trn=odbc_result($tb_stkz,"item_trn");
								$kd_itm=odbc_result($tb_stkz,"kd_itm");
								echo "<option value='$kd_itm'>$item_trn</option>";
								}
								?>
								</select> */ ?>
							</div>
						</div>
					</div>
					
					
					<div class="col-md-4">
						<div class="form-group">
							<label>ID TRAINING</label>
							<input type="text" readonly class="form-control" id="id_trn" name="id_trn" required>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label>TANGGAL TRAINING</label>
							<input type="text" class="form-control pull-right datetimerange" id="tgl_trn" name="tgl_trn" required>
						</div>
					</div>		

					
					<div class="col-md-2">	
						<div class="form-group">
							<label>SHIFT</label>
							<select name="shf" id="shf" class="form-control"  required>
								<option value="ALL">ALL</option>
								<option value="A">A</option>	
								<option value="B">B</option>
								<option value="NS">NS</option>		
							</select>	
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label>DEPARTEMEN</label>
							<select name="dept" id="dept" class="form-control form-control-chosen" data-placeholder="Please select..."> 
								<option value="">-- Pilih Dept-Sect --</option>
								<?php $tb_mtr=odbc_exec($koneksi,"select distinct DEPT,SECT from KARYAWAN where (periode='$periode'
									or periode=convert (nvarchar(6),DATEADD(d,-1,DATEADD(m, DATEDIFF(m,0,GETDATE()),0)),112)) order by dept asc, SECT asc");
								while($tb_code=odbc_fetch_array($tb_mtr)){ 
									$DEPT=odbc_result($tb_mtr,"DEPT");
									$SECT=odbc_result($tb_mtr,"SECT");
									echo '<option value="'.$DEPT."-".$SECT.'">'.$DEPT."-".$SECT.'</option>';
								}
								?>
							</select>
						</div>
						<input type="hidden" name="invzy" id="invzy" value="" class="input-xxlarge">
						
						<div class="form-group">
							<label>JABATAN</label>
							<select name="jbtn" id="jbtn" class="form-control form-control-chosen" data-placeholder="Please select..."> 
								<option value="">-- Pilih Jabatan --</option>
								<?php $tb_jbtn=odbc_exec($koneksi,"select distinct jbtn from v_dtlkaryawan where periode='$periode' and jbtn not in ('SPV','CSPV','SM','FM','AM','MGR') order by jbtn asc");
								while(odbc_fetch_array($tb_jbtn)){ 
									$jbtn=odbc_result($tb_jbtn,"jbtn");
									echo '<option value="'.$jbtn.'">'.$jbtn.'</option>';
								}
								?>
							</select>
						</div>
						
						<div class="form-group">
							<label>ATASAN</label>
							<div class="input-group input-group-sm">
								<input type="text" class="form-control" name="hdr_atsn" id="hdr_atsn" value=""  placeholder="atasan">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-flat" onclick="open_child('template.php?page=select/plh_atasan.php&area=hdr_atsn','Data Conveyor','800','500'); return false;" >
										<i class="fa fa-search"></i>
									</button>
								</span>
							</div>
						</div>

					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label>CONVEYOR</label>
							<div class="input-group input-group-sm">
								<input type="text" class="form-control" name="id_cv" id="id_cv" value=""  placeholder="ID CONVEYOR">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-flat" onclick="open_child('template.php?page=select/plh_cln.php&area=dashboard','Data Conveyor','800','500'); return false;" >
										<i class="fa fa-search"></i>
									</button>
								</span>
							</div>
						</div>
						
						<div class="form-group">
							<label>CARLINE</label>                  
							<input type="text" class="form-control" id="hdr_cln" name="hdr_cln" placeholder="CARLINE">
							<span class="input-group-btn">
							</span>
						</div>
						
						<div class="form-group">
							<label>AREA</label>
							<input type="text" class="form-control" name="hdr_CV" id="hdr_CV" value="" placeholder="CONVEYOR">
						</div>
						
						<div class="form-group">
							<hr>
							<button type="button" id="cr_data" name="cr_data" class="btn btn-info btn-flat" onclick="cr_data('select/plh_partinvest.php'); return false;" >
								Cari NIK  <i class="fa fa-search"></i>
							</button>
						</div>
					</div>
					<!--end of col-md-6 -->
				</div>
				<div class="col-md-6">               
					<div id="data_kk"></div>
					<div class="form-group">
						<label>No Control</label>
						<textarea type="text" readonly class="form-control" id="nik" name="nik" placeholder="NIK" style="width: 100%; height: 150px; font-size: 200%; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required>
						</textarea>
					</div>
					<button type="submit" name="smp_b" id="smp_b" class="btn btn-primary">SIMPAN</button>
				</div>
				
			</div>
		</form>
	</div>
</div>
</div>
</div>
</div>
</section>
<?php
$pic_update=$_SESSION['nama'];

$qry_crasset="select nik,nm_karyawan,shf,jbtn,dept,sect,judul_trn,nm_trn,trainer,lokasi_trn 
from trn_undangan a inner join TR_Training b on a.id_trn=b.id_trn where
'$s_tgl'>=a.s_trn and '$s_tgl'<=a.f_trn ";

if(isset($_POST['smp_b']) ){

	$id_trn=$_POST['id_trn'];
	$nm_trn=$_POST['nm_trn'];
	$nik=str_replace(" ","",$_POST['nik']);
	$shf=$_POST['shf'];
	$dept=$_POST['dept'];
	$id_cv=$_POST['id_cv'];
	$hdr_cln=$_POST['hdr_cln'];
	$hdr_CV=$_POST['hdr_CV'];
	$jbtn=$_POST['jbtn'];
	$pchnik=explode(",",$nik);
	$jmnik=count($pchnik)-1;

	$tgltrn=$_POST['tgl_trn'];
	$pchtgl=explode("-",$tgltrn);
	$s_tgl=date("Y-m-d",strtotime($pchtgl[0]));
	$f_tgl=date("Y-m-d",strtotime($pchtgl[1]));

	$tb_rgtgl=odbc_exec($koneksi,"select top 1 s_tgl,f_tgl from TR_Training where id_trn='$id_trn'");
	$start_trn=odbc_result($tb_rgtgl,"s_tgl");
	$end_trn=odbc_result($tb_rgtgl,"f_tgl");
	//if($s_tgl=> $start_trn and $s_tgl=< $end_trn){$tgl_strn=$s_tgl;}else{$tgl_strn=;}
	$strtrn=date("Y-m-d H:i:s",strtotime($pchtgl[0]." ".$_POST['strtrn']));
	$fnshtrn=date("Y-m-d H:i:s",strtotime($pchtgl[1]." ".$_POST['fnshtrn']));

	$hdr_atsn=$_POST['hdr_atsn'];
	$pch_atsn=explode("-",$hdr_atsn);
	$nik_atsn=$pch_atsn[0];
	$nm_atsn=$pch_atsn[1];

	for($i=0;$i<$jmnik;$i++){

		//$nik1="";
		$pjgnik=strlen($pchnik[$i]);
		for($c=0;$c<$pjgnik;$c++){
			if(substr($pchnik[$i],$c,1)!='0'){
				break;}
			}		
			$nik1=substr($pchnik[$i],$c,$pjgnik-$c);

			$tb_nik=odbc_exec($koneksi,"select distinct NAMA,nik,dept,sect,area,jbtn,shift from v_dtlkaryawan where 
				nik=right('000000'+'$nik1',6) and (periode='$periode' or periode=convert (nvarchar(6),DATEADD(d,-1,DATEADD(m, DATEDIFF(m,0,GETDATE()),0)),112))");

			while(odbc_fetch_array($tb_nik)){
				$nm=odbc_result($tb_nik,"NAMA");
				$depart=odbc_result($tb_nik,"dept");
				$section=odbc_result($tb_nik,"sect");
				$jbtn=odbc_result($tb_nik,"jbtn");
				$shift=odbc_result($tb_nik,"shift");
				$nid=odbc_result($tb_nik,"nik");
			}

			$tb_email=odbc_exec($koneksi,"select top 1 email from esys_email where nik=right('000000'+'$nik1',6)");
			$email=odbc_result($tb_email,"email");

			$tb_email2=odbc_exec($koneksi,"select top 1 email from esys_email where nik='$nik_atsn'");
			$email_atsn=odbc_result($tb_email2,"email");

			$in_reg="insert into trn_undangan (id_trn,s_trn,f_trn,s_jam,f_jam,nik,nm_karyawan,shf,jbtn,dept,sect,nm_atasan,email_atasan
			,email,pic_updt,tgl_updt) values 
			('$id_trn','$s_tgl','$f_tgl','$strtrn','$fnshtrn',right('000000'+'$nik1',6),'$nm','$shift','$jbtn','$depart','$section',
			'$nm_atsn','$email_atsn','$email','$pic_update',getdate())";
			$tb_partX=odbc_exec($koneksi,$in_reg);
		}

		$tb_part=odbc_exec($koneksi,$qry_crasset);
	}
	?>	


