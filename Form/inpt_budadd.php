<?php 
$sect= $_SESSION["area"]; 
$akses=$_SESSION["akses"];

$admin_FA=strpos($akses,'_FA');
$kd_akses=explode(",",$akses);
if(in_array('ADM_FA',$kd_akses)){
	$adm1="admin";
}else{
	$adm1="user";
}
?>	 
<script>
	function pil_add(){
		var chgadd=document.form0.add_cr.value;
		var chgno=chgadd.split("-");
		var term_cr=document.form0.term_cr.value;
		var periode_cr=document.form0.periode_cr.value;
		var no_ctrl_cr=document.form0.no_ctrl_cr.value;
		var sec=document.form0.sect.value;
		if(chgadd=="" || term_cr=="" || periode_cr=="" || no_ctrl_cr==""){
			alert("DATA BELUM LENGKAP");
		}else
		{
			document.frm_additem.term_item.value=term_cr;
			document.frm_additem.periode_item.value=periode_cr;
			document.frm_additem.sect_item.value=sec;

			var gabung=term_cr+','+periode_cr+','+no_ctrl_cr+','+chgadd+','+sec;

			switch(chgno[0]) {
				case "1":
				document.frm_addqty.plan_addqty.value=gabung;
				$('#mdaddbudqty').modal('show');
				break;
				case "2":
				document.frm_addprc.plan_addprc.value=gabung;
				$('#mdaddbudprc').modal('show');
				break;
				case "3":
				document.frm_addprcqty.plan_addprcqty.value=gabung;
				$('#mdaddbudprcqty').modal('show');
				break;
				case "4":
				document.frm_addper.plan_addper.value=gabung;
				$('#mdaddbudper').modal('show');
				break;
				case "5":
				$('#mdadditem').modal('show');
				break;
				default:
				alert('DATA TIDAK TERSEDIA');
			}
		}
	};
</script>
<script type="text/javascript">
	function open_child(url,title,w,h){
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	};	

	function cekctrl3(url,title,w,h){
		var pno=document.form0.term_cr.value;
		var pnd=document.form0.periode_cr.value;
		var pernow = new Date();
		var nperi=pernow.getFullYear()+''+("0"+(pernow.getMonth()+1)).slice(-2);
		//var balp=parseInt(pnd)-parseInt(nperi);
		//var balp=parseInt(pnd)-parseInt(nperi);
	var balp=0;
	//  alert(balp);
	if(pno=="" || balp<0){alert("Term-Section Belum dipilih Atau Periode Kurang dari Bulan Sekarang");}else{
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url+'&t='+pno+'&p='+pnd, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);		
	}

	};
	function cekctrl4(url,title,w,h){
		var pno=document.frm_add.term.value;
		var pnd=document.frm_add.periode_plan.value;
		var pernow = new Date();
		var nperi=pernow.getFullYear()+''+("0"+(pernow.getMonth()+1)).slice(-2);
		//var balp=parseInt(pnd)-parseInt(nperi);
		//var balp=parseInt(pnd)-parseInt(nperi);
	var balp=0;
	//  alert(balp);
	if(pno=="" || balp<0){alert("Term-Section Belum dipilih Atau Periode Kurang dari Bulan Sekarang");}else{
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url+'&t='+pno+'&p='+pnd, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);
	} 
};	
function cekctrl123(url){
	var chgadd=document.form0.add_cr.value;
	var term_cr=document.form0.term_cr.value;
	var periode_cr=document.form0.periode_cr.value;
	var no_ctrl_cr=document.form0.no_ctrl_cr.value;
	var sec=document.form0.sect.value;
	var pernow = new Date();
	var nperi=pernow.getFullYear()+''+("0"+(pernow.getMonth()+1)).slice(-2);

	//var balp=parseInt(periode_cr)-parseInt(nperi);
	//var balp=parseInt(pnd)-parseInt(nperi);
	var balp=0;
	//  alert(balp);
	if(term_cr=="" || balp<0){alert("Term-Section Belum dipilih Atau Periode Kurang dari Bulan Sekarang");}else{
		var left = (screen.width/2)-400;
		var top = (screen.height/2)-200;
		window.open(url+'&t='+term_cr+'&p='+periode_cr+'&s='+sec, 'Budget', 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width=800,height=500,top='+top+',left='+left);		
	} 
};
function cekctrl1234(url){
	var chgadd=document.form0.add_cr.value;
	var term_cr=document.form0.term_cr.value;
	var periode_cr=document.frm_addper.periode_add.value;
	var no_ctrl_cr=document.form0.no_ctrl_cr.value;
	var sec=document.form0.sect.value;
	var pernow = new Date();
	var nperi=pernow.getFullYear()+''+("0"+(pernow.getMonth()+1)).slice(-2);

	var balp=parseInt(periode_cr)-parseInt(nperi);
	balp=0;
	//  alert(balp);
if(term_cr==""){alert("Term-Section Belum dipilih Atau Periode Kurang dari Bulan Sekarang");}else{
		var left = (screen.width/2)-400;
		var top = (screen.height/2)-200;
		window.open(url+'&t='+term_cr+'&p='+periode_cr+'&s='+sec, 'Budget', 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width=800,height=500,top='+top+',left='+left);		
	} 
};	
function cr_nm(url,title,w,h){
	var nik=document.frm_additem.account.value;
	var pno=document.frm_additem.term_item.value;
	var pnd=document.frm_additem.periode_item.value;
	var pernow = new Date();
	var nperi=pernow.getFullYear()+''+("0"+(pernow.getMonth()+1)).slice(-2);
	//var balp=parseInt(pnd)-parseInt(nperi);
	var balp=0;
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
		var pno=document.frm_additem.part_no.value;
		var pnd=document.frm_additem.part_nm.value;
		var pri=document.frm_additem.periode_item.value;
		var lp=document.frm_additem.lp.value;
		if(pri==""){alert("Periode Belum Diisi");}else{
			var left = (screen.width/2)-(w/2);
			var top = (screen.height/2)-(h/2);
			w = window.open(url+'&pno='+pno+'&pnd='+pnd+'&p='+pri+'&lp='+lp, title, 'toolbar=no, location=no, directories=no, \n\
				status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
				width='+w+',height='+h+',top='+top+',left='+left);	
		}		
	};
	function cekctrl(url,title,w,h){
		var pno=document.frm_additem.term_item.value;
		var pnd=document.frm_additem.periode_item.value;
		var sec=document.frm_additem.sect_item.value;
		var jns_bud=document.frm_additem.jns_bud.value;
		var pernow = new Date();
		var nperi=pernow.getFullYear()+''+("0"+(pernow.getMonth()+1)).slice(-2);
		var balp=parseInt(pnd)-parseInt(nperi);
		balp=0;
	 // alert(balp);
	if(pno=="" ||sec=="" || balp<0){alert("Term-Section Belum dipilih Atau Periode Kurang dari Bulan Sekarang");}else{
	 	var left = (screen.width/2)-(w/2);
	 	var top = (screen.height/2)-(h/2);
	 	w = window.open(url+'&t='+pno+'&p='+pnd+'&s='+sec+'&k='+jns_bud, title, 'toolbar=no, location=no, directories=no, \n\
	 		status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
	 		width='+w+',height='+h+',top='+top+',left='+left);		
	};
	};
</script>	  
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>ADDITIONAL BUDGET</h2>
		</div>
		<div class="row clearfix">
			<div class="card">
				<div class="row clearfix">	
					<div class="header">
						<h2>ADDITIONAL<small>
						Menambahkan Budget Karena Quantity,Price dan Periode</small></h2>
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

					<form role="form" enctype="multipart/form-data" name="form0" id="form0" method="post" action="">
						<div class="body">
							<div class="col-sm-2"><div class="form-group">
								<label>Section</label>
								<div class="input-group">
									<input type="text" readonly class="bg-grey form-control" id="sect" name="sect" value="<?php echo $sect; ?>" placeholder="sect" required>
								</div>
							</div>
						</div>
						<div class="col-sm-2">		
							<div class="form-group">
								<label>Term</label>
								<div class="input-group">
									<select class="selectpicker" style="width: 100%;"  name="term_cr" id="term_cr" required>
										<option selected="selected" value="">-Pilih Term-</option>
										<?php 
										// $tb_term=odbc_exec($koneksi_lp,"select distinct term from bps_setterm where start_prepaire<=getdate() and finish_term >=getdate() order by term desc");
										
									
			
										$tb_term=odbc_exec($koneksi_lp,"select distinct term from bps_setterm order by term desc");
										$row=0;
										while($bar_term=odbc_fetch_array($tb_term)){
											$row++;
											$opt_trm=odbc_result($tb_term,"term");
											$opt_term='<option value="'.$opt_trm.'">TERM '.$opt_trm.'</option>';
											echo $opt_term;
										}				 
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label>Periode</label>
								<div class="input-group">
									<?php if ($adm1=='admin') { ?>
									<input type="number" class="perioded bg-grey form-control" id="periode_cr" name="periode_cr" 
									value="<?php echo date("Ym"); ?>" placeholder="Periode Plan" required>
								<?php }else { ?>
									<input type="number" class="periodemn bg-grey form-control" id="periode_cr" name="periode_cr" 
									value="<?php echo date("Ym"); ?>" readonly placeholder="Periode Plan" required>
								<?php } ?>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label>No Control Add</label>
								<div class="input-group">
									<div class="form-line">
										<input type="text" readonly class="form-control" id="no_ctrl_cr" name="no_ctrl_cr" placeholder="No Control" required>
									</div>
									<span class="input-group-addon">
										<button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl3('template.php?plh=select/cek_noctrl.php&o=no_ctrl_cr&k=Additional&s=<?php echo $sect; ?>','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
									</span>				
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label>Perubahan</label>
								<div class="input-group">
									<select class="selectpicker" style="width: 100%;"  name="add_cr" id="add_cr" required>
										<option selected="selected" value="">-Pilih Perubahan-</option>
										<option value="1-QTY_ONLY">QTY ONLY</option>
										<option value="2-PRICE_ONLY">PRICE ONLY</option>
										<option value="3-QTY_AND_PRICE">QTY AND PRICE</option>
										<option value="4-PERIODE">PERIODE</option>
										<option value="5-ITEM">ITEM</option>
									</select>
									<span class="input-group-addon">
										<button type="button" class="btn bg-purple waves-effect"  onclick="pil_add(); return false;"><i class="material-icons">search</i> </button>
									</span>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	$sq_acc="";
	if(isset($_POST['smpn_addqty']) ){

		$plan_addqty=$_POST['plan_addqty'];
		$pprice=$_POST['price_planq'];
		$pchplanqty=explode(",",$plan_addqty);
		$pchket=explode("-",$pchplanqty[3]);
		$noctrlplanq=$_POST['noctrlplanq'];
		$qty_addq=$_POST['qty_addq'];
		$pic_updt=$_SESSION['nama'];
		$rmk_ad=$_POST['rmk_ad'];

		$crperi="select top 1 periode,expaired from bps_budget_add where no_ctrl='$noctrlplanq' and kode_chg=4";
		$tb_crperq = odbc_exec($koneksi_lp,$crperi);
		$per_adqt=odbc_result($tb_crperq,"periode");
		if($per_adqt==''){$crperq="periode";}else{$crperq="'$per_adqt'";}

		$exp_adqt=odbc_result($tb_crperq,"expaired");
		if($exp_adqt==''){$crexpq="expaired";}else{$crexpq="'$exp_adqt'";}
//cari price quo
		$crprcquo1="select top 1 price from bps_Quotation where part_no=(select part_no from bps_budget where no_ctrl='$noctrlplanq') and lp_rekom='YES' and Exp_Quo>getdate() order by tgl_updt desc";
		$tb_prcquo1=odbc_exec($koneksi_lp,$crprcquo1);
		$prc_quo=odbc_result($tb_prcquo1,"price");

//$cradprc="select price from bps_budget_add where no_ctrl='$noctrlplanq'";
//$tb_cradprc=odbc_exec($koneksi_lp,$cradprc);
//$prc_a=odbc_result($tb_cradprc,"price");

		if($prc_quo==''){$price=$pprice;}else{$price=$prc_quo;}

		$qryaddqty="insert into bps_budget_add(kode_chg,ket_chg,status,no_ctrl_add,no_ctrl,periode,qty,price,pic_updt,tgl_updt,sect,part_no,part_desc,part_dtl,uom,term,account,expaired,id_proses,lt_vp,lt_datang,lt_po,lt_pr,lt_Quo,jns_budget,lp,sub_acc,curr,phase,cccode,cv_code,part_nm,remark)
		select top 1 '1' as kode_chg,'QTY ONLY' as ket_chg,'OPEN' as status,'$pchplanqty[2]' as no_ctrl_add,no_ctrl,$crperq as periode,'$qty_addq' as qty,$price as price,'$pic_updt' as pic_updt,getdate() as tgl_updt,sect,part_no,part_desc,part_dtl,uom,term,account,$crexpq as expaired,id_proses,lt_vp,lt_datang,lt_po,lt_pr,lt_Quo,'ADDITIONAL' as jns_budget,lp,sub_acc,curr,phase,cccode,cv_code,part_nm,'$rmk_ad' as remark from mstr_budadd where no_ctrl='$noctrlplanq'";
		$tb_del = odbc_exec($koneksi_lp,"delete from bps_budget_add where no_ctrl_add='$pchplanqty[2]'");
		$tb_add = odbc_exec($koneksi_lp,$qryaddqty);
		echo "<script>alert('DATA SUDAH DI UPDATE');</script>";
		$sq_acc="select * from bps_budget_add where no_ctrl_add='$pchplanqty[2]'";
// echo $qryaddqty;
	}
	if(isset($_POST['smpn_addprc']) ){

		$plan_addprc=$_POST['plan_addprc'];
		$pchplanprc=explode(",",$plan_addprc);
		$qty_planp=$_POST['qty_planp'];
		$pchket=explode("-",$pchplanprc[3]);
		$noctrlplanp=$_POST['noctrlplanp'];
		$price_addp=$_POST['price_addp'];
		$revqty_addp=$_POST['revqty_addp'];
		$rmk_ad=$_POST['rmk_ad'];
		if($revqty_addp==''){$revqty=$qty_planp;}else{$revqty=min($revqty_addp,$qty_planp);}
		$pic_updt=$_SESSION['nama'];
		$crper="select top 1 qty,periode,expaired from bps_budget_add where no_ctrl='$noctrlplanp' and kode_chg=4";
		$tb_crper = odbc_exec($koneksi_lp,$crper);
		$per=odbc_result($tb_crper,"periode");
		if($per==''){$crper="periode";}else{$crper="'$per'";}

		$qty_adprc=odbc_result($tb_crper,"qty");
		$exp_adprc=odbc_result($tb_crper,"expaired");
		if($exp_adprc==''){$crexp="expaired";}else{$crexp="'$exp_adprc'";}

		$qryaddprc="insert into bps_budget_add(kode_chg,ket_chg,status,no_ctrl_add,no_ctrl,periode,qty,price,pic_updt,tgl_updt,sect,part_no,part_desc,part_dtl,uom,term,account,expaired,id_proses,lt_vp,lt_datang,lt_po,lt_pr,lt_Quo,jns_budget,lp,sub_acc,curr,phase,cccode,cv_code,part_nm,remark)
		select top 1 '2' as kode_chg,'PRICE ONLY' as ket_chg,'OPEN' as status,'$pchplanprc[2]' as no_ctrl_add,no_ctrl,$crper as periode,$revqty as qty,'$price_addp' as price,'$pic_updt' as pic_updt,getdate() as tgl_updt,sect,part_no,part_desc,part_dtl,uom,term,account,$crexp as expaired, id_proses, lt_vp,lt_datang,lt_po,lt_pr,lt_Quo,'ADDITIONAL' as jns_budget,lp,sub_acc,curr,phase,cccode,cv_code,part_nm,'$rmk_ad' as remark  from mstr_budadd where no_ctrl='$noctrlplanp'";
		$tb_del = odbc_exec($koneksi_lp,"delete from bps_budget_add where no_ctrl_add='$pchplanprc[2]'");
		$tb_add = odbc_exec($koneksi_lp,$qryaddprc);
		echo "<script>alert('DATA SUDAH DI UPDATE');</script>";
		$sq_acc="select * from bps_budget_add where no_ctrl_add='$pchplanprc[2]'";
		// echo $qryaddprc;
	}
	if(isset($_POST['smpn_addpq']) ){
		$plan_addprcqty=$_POST['plan_addprcqty'];
		$pchplanprcqty=explode(",",$plan_addprcqty);
		$pchket=explode("-",$pchplanprcqty[3]);
		$noctrlplanpq=$_POST['noctrlplanpq'];
		$qty_addpq=number_format($_POST['qty_addpq'], '2', '.', '.');
		$price_addpq=$_POST['price_addpq'];
		$rmk_ad=$_POST['rmk_ad'];
		$pic_updt=$_SESSION['nama'];
		$qryaddprc="insert into bps_budget_add(kode_chg,ket_chg,status,no_ctrl_add,no_ctrl,periode,qty,price,pic_updt,tgl_updt,sect,part_no,part_desc,part_dtl,uom,term,account,expaired,id_proses,lt_vp,lt_datang,lt_po,lt_pr,lt_Quo,jns_budget,lp,kurs,sub_acc,curr,phase,cccode,cv_code,part_nm,remark) select '3' as kode_chg,'QTY AND PRICE' as ket_chg,'OPEN' as status,'$pchplanprcqty[2]' as no_ctrl_add,no_ctrl,periode,'$qty_addpq' as qty,'$price_addpq' as price,'$pic_updt' as pic_updt,getdate() as tgl_updt,sect,part_no,part_desc,part_dtl,uom,term,account,expaired,id_proses,lt_vp,lt_datang,lt_po,lt_pr,lt_Quo,'ADDITIONAL' as jns_budget,lp,kurs,sub_acc,curr,phase,cccode,cv_code,part_nm,'$rmk_ad' as remark  from bps_budget where no_ctrl='$noctrlplanpq'";
		$tb_del = odbc_exec($koneksi_lp,"delete from bps_budget_add where no_ctrl_add='$pchplanprcqty[2]'");
		$tb_add = odbc_exec($koneksi_lp,$qryaddprc);
		echo "<script>alert('DATA SUDAH DI UPDATE');</script>";
		$sq_acc="select * from bps_budget_add where no_ctrl_add='$pchplanprcqty[2]'";
echo $qryaddprc;
	}
	if(isset($_POST['smpn_addper']) ){
		$plan_addper=$_POST['plan_addper'];
		$pchplanper=explode(",",$plan_addper);
		$pchket=explode("-",$pchplanper[3]);
		$noctrlplanper=$_POST['noctrlplanper'];
		$qplan=$_POST['qplan'];
		$rev_qty=$_POST['rev_qty'];
		$rmk_ad=$_POST['rmk_ad'];
		$cr_qty=odbc_exec($koneksi_lp,"select isnull(sum(qty),0) as qty from bps_PR where no_ctrl='$noctrlplanper' 
			and periode='$pchplanper[1]'");
		$qty_act=odbc_result($cr_qty,"qty");

		if($rev_qty==''){$qty_used=$qplan-$qty_act;}else{$qty_used=min(($qplan-$qty_act),$rev_qty);}

		$padd=$_POST['padd'];
		$pplan=$_POST['pplan'];

		$periode_add=$_POST['periode_add'];
		$pic_updt=$_SESSION['nama'];
		$crprcquo="select top 1 isnull(price,0) as price from bps_Quotation where part_no=(select part_no from bps_budget where no_ctrl='$noctrlplanper') and lp_rekom='YES' and Exp_Quo>left('$pchplanper[1]',4)+'-'+(right('$pchplanper[1]',2))+'-28' order by tgl_updt desc";
		$tb_prcquo = odbc_exec($koneksi_lp,$crprcquo);
		$price_quo=odbc_result($tb_prcquo,"price");

		if($price_quo==''){
			$price_p=$pplan;
		}else{
			$price_p=$price_quo;
		}

		if($padd==''){
			$price=min($pplan,$price_p);
		}else{
			$price=min($price_p,$padd);
		}

//if($price_quo==''){$price=$pplan;}else{$price=min($pplan,$price_quo);}
		$cek_noctrl="select count (*) as jml from bps_budget_add where no_ctrl='$noctrlplanper' and kode_chg=4";
		$tb_ceknoctrl=odbc_exec($koneksi_lp, $cek_noctrl);
		$jml_noctrl=odbc_result($tb_ceknoctrl, "jml");

		if($jml_noctrl!=1){

			$qryaddprc="insert into bps_budget_add(kode_chg,ket_chg,status,no_ctrl_add,no_ctrl,periode,qty,price,pic_updt,tgl_updt,sect,part_no,part_desc,part_dtl,uom,term,account,expaired,id_proses,lt_vp,lt_datang,lt_po,lt_pr,lt_Quo,jns_budget,lp,kurs,sub_acc,curr,phase,cccode,cv_code,part_nm,remark)
			select '4' as kode_chg,'PERIODE' as ket_chg,'OPEN' as status,'$pchplanper[2]' as no_ctrl_add,no_ctrl,'$pchplanper[1]' as periode,'$qty_used' as qty,'$price' as price,'$pic_updt' as pic_updt,getdate() as tgl_updt,sect,part_no,part_desc,part_dtl,uom,term,account,left('$pchplanper[1]',4)+'-'+(right('$pchplanper[1]',2))+'-28' as expaired,id_proses,lt_vp,lt_datang,lt_po,lt_pr,lt_Quo,'ADDITIONAL' as jns_budget,lp,kurs,sub_acc,curr,phase,cccode,cv_code,part_nm,'$rmk_ad' as remark  from bps_budget where no_ctrl='$noctrlplanper'";
			$tb_del = odbc_exec($koneksi_lp,"delete from bps_budget_add where no_ctrl_add='$pchplanper[2]'");
			$tb_add = odbc_exec($koneksi_lp,$qryaddprc);
			echo "<script>alert('DATA SUDAH DI UPDATE');</script>";
			$sq_acc="select * from bps_budget_add where no_ctrl_add='$pchplanper[2]'";}
			else{
				echo "<script>alert('ADD PERIODE MAKSIMAL 1X UNTUK NO KONTROL YANG SAMA. DATA TIDAK BISA DI PROSES');</script>";
			}
//echo $qryaddprc;
		}

		if(isset($_POST['smpn_item'])){	
//$sect=$_POST['sect'];
			$term=$_POST['term_item'];
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
$periode=$_POST['periode_item'];
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
$rmk_ad=$_POST['rmk_ad'];
$expaired=date("Y-m-d",strtotime($periode."28"));
$cr_idproses=odbc_exec($koneksi_lp,"select dbo.cr_proseslp('quo','$id_proses') as penawaran");
$penawaran=odbc_result($cr_idproses,"penawaran");
if($penawaran=='NO'){
	$prcquoitm="select top 1 price from bps_Quotation where part_no='$part_no' and lp_rekom='YES' and Exp_Quo>='$expaired' and sect='$sect' order by tgl_updt desc";}
	else{$prcquoitm="select top 1 price from bps_Quotation where part_no='$part_no' and lp_rekom='YES' and Exp_Quo>='$expaired' order by tgl_updt desc";}
	
	$tb_prcquoitm = odbc_exec($koneksi_lp,$prcquoitm);
	$prc_quo2=odbc_result($tb_prcquoitm,"price");
	if($prc_quo2==''){$priceA=$price;}else{$priceA=$prc_quo2;}

	$qry_add="insert into bps_budget_add(kode_chg,ket_chg,status,no_ctrl_add,no_ctrl,periode,qty,price,pic_updt,tgl_updt,sect,part_no,part_desc,part_dtl,uom,term,account,expaired,id_proses,lt_vp,lt_datang,lt_po,lt_pr,lt_Quo,jns_budget,lp,sub_acc,curr,phase,cccode,part_nm,remark) values
	('5','NEW ITEM','OPEN','$no_ctrl','$no_ctrl','$periode','$qty','$priceA','$pic_updt',getdate(),'$sect','$part_no','$part_desc','$part_dtl','$uom','$term','$account','$expaired','$id_proses','$lt_vp','$lt_datang','$lt_po','$lt_pr','$lt_Quo','ADDITIONAL','$lp','$sub_acc','$curr','$phase','$cccode','$part_nm','$rmk_ad')";
	$tb_add = odbc_exec($koneksi_lp,$qry_add);
	$sq_acc="select * from bps_budget_add where no_ctrl_add='$no_ctrl'";
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
							<select class="selectpicker" style="width: 100%;"  name="cmd_cari" id="cmd_cari" >
								<option selected="selected" value="">---Pilih Kolom---</option>
								<option value="term">TERM</option>
								<option value="no_ctrl">CONTROL NO</option>
								<option value="lp">PURCHASING</option>
								<option value="id_proses">KODE PROSES</option>
								<option value="account">ACCOUNT</option>
								<option value="sub_acc">SUB ACCOUNT</option>
								<option value="part_no">PART NO</option>
								<option value="part_nm">PART NAME</option>
								<option value="part_dtl">DETAIL PART</option>
								<option value="periode">PERIODE</option>
								<option value="phase">PHASE</option>
								<option value="no_ctrl_add">CONTROL NO ADD</option>
								<option value="ket_chg">KETERANGAN ADD</option>
							</select>
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
								<th>TERM</th>
								<th>PERIODE</th>
								<th>CONTROL NO PLAN</th>
								<th>CONTROL NO ADD</th>
								<th>PART NO</th>
								<th>PART NAME</th>
								<th>DETAIL PART</th>
								<th>DESCRIPTION PART</th>
								<th>QTY ADD</th>
								<th>UOM</th>
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
								if($txt_cari==""){$whr="no_ctrl is not null"; }else{
									$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
									$sq_acc="select * from bps_budget_add where sect='$sect' and $whr and doc_no is null";
								}
								if($sq_acc!=""){
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
											<td><?php echo odbc_result($tb_acc,"uom"); ?></td>
											<td><?php echo odbc_result($tb_acc,"price"); ?></td>
											<td><?php echo odbc_result($tb_acc,"ket_chg"); ?></td>
											<td><?php echo $add_stts; ?></td>
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

	<?php if(isset($_POST['cr_b'])){ 
		if($row>0 and $opsi_del!=""){	?>
			<div class="row clearfix">				
				<div class="header">
					<h2>Delete <small>Hapus Additional Budget Status OPEN</small></h2>
				</div>
				<div class="body">
					<form action="" id="frmdel" name="frmdel" method="post"  enctype="multipart/form-data">
						<div class="col-sm-6">	
							<div class="form-group">
								<!--label>Kolom</label-->
								<select class="selectpicker" style="width: 100%;"  name="no_ctrl_dell" id="no_ctrl_dell" required>
									<option selected="selected" value="">---Pilih No Control---</option>
									<?php echo $opsi_del; ?>
								</select>
							</div>
						</div>

						<div class="col-sm-2">
							<!--a href="##"><i onclick="open_child('select/rev_pr.php?pic=<?php echo $pic;?>&sec=<?php echo $sect;?>&nopr=<?php echo $prno;?>','Edit Add Budget <?php echo $prno;?>','800','500'); return false;" class="material-icons">edit</i></a-->
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
</section>

<div class="modal fade" id="mdaddbudqty" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">ADDITIONAL QTY ONLY</h4></div>
			<form action="" id="frm_addqty" name="frm_addqty" method="post"  enctype="multipart/form-data">
				<div class="modal-body">
					<div class="body">
						<input type="hidden" readonly class="bg-grey form-control" id="plan_addqty" name="plan_addqty" value="" required>
						<div class="col-lg-12">	
							<div class="col-md-6">	
								<div class="form-group">
									<label>No Control Plan</label>
									<div class="input-group">
										<div class="form-line">
											<input type="text" readonly class="bg-grey form-control" id="noctrlplanq" name="noctrlplanq" placeholder="No Contro" required>
										</div>

										<span class="input-group-addon">
											<button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl123('template.php?plh=select/budtoadd.php&og=noctrlplanq,qty_planq,price_planq,,')"><i class="material-icons">search</i> </button>
										</span>								
									</div></div>	
								</div>
								<div class="col-md-2">	
									<div class="form-group">
										<label>QTY Plan</label>
										<div class="form-line">
											<input type="number" readonly class="bg-grey form-control" id="qty_planq" name="qty_planq" placeholder="QTY Plan" required>
										</div>
									</div>	
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Price Plan</label>
										<div class="form-line">
											<input type="number" readonly class="bg-grey form-control" id="price_planq" name="price_planq" placeholder="Price plan" required>
										</div>
									</div></div>
									<div class="col-md-2">
										<div class="form-group">
											<label>QTY Add</label>
											<div class="form-line">
												<input type="number" min="0" step="any" class="form-control" id="qty_addq" name="qty_addq" placeholder="QTY Add" required>
											</div>
										</div></div>

										<div class="form-group">
											<label>Remark Additional</label>
											<div class="form-line">
												<textarea type="text" name="rmk_ad" id="rmk_ad" class="form-control"  required> </textarea>
											</div></div>

										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" id="smpn_addqty" name="smpn_addqty" class="btn bg-green waves-effect"><i class="material-icons">saves</i>Save</button>		
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal fade" id="mdaddbudprc" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">ADDITIONAL PRICE ONLY</h4></div>
							<form action="" id="frm_addprc" name="frm_addprc" method="post"  enctype="multipart/form-data">
								<div class="modal-body">
									<div class="body">
										<input type="hidden" readonly class="bg-grey form-control" id="plan_addprc" name="plan_addprc" value="" required>
										<div class="col-lg-12">	
											<div class="form-group">
												<label>No Control Plan</label>
												<div class="input-group">
													<div class="form-line">
														<input type="text" readonly class="bg-grey form-control" id="noctrlplanp" name="noctrlplanp" placeholder="No Contro" required>
													</div>

													<span class="input-group-addon">
														<button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl123('template.php?plh=select/budtoadd.php&og=noctrlplanp,qty_planp,price_planp,,')"><i class="material-icons">search</i> </button>
													</span>								
												</div>
											</div>
											<div class="col-md-6">	
												<div class="form-group">
													<label>QTY Plan</label>
													<div class="form-line">
														<input type="number" readonly class="bg-grey form-control" id="qty_planp" name="qty_planp" placeholder="QTY Plan" required>
													</div>
												</div>	
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Price Plan</label>
													<div class="form-line">
														<input type="number" readonly class="bg-grey form-control" id="price_planp" name="price_planp" placeholder="Price plan" required>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Rev Qty</label>
													<div class="form-line">
														<input type="number" min="0" max="qty_planp" step='0.000000000001' class="form-control" id="revqty_addp" name="revqty_addp" placeholder="Rev Qty">
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Price Add</label>
													<div class="form-line">
														<input type="number" step="any" class="form-control" id="price_addp" name="price_addp" placeholder="Price Add" required>
													</div>
												</div>
											</div>

											<div class="form-group">
												<label>Remark Additional</label>
												<div class="form-line">
													<textarea type="text" name="rmk_ad" id="rmk_ad" class="form-control"  required> </textarea>
												</div>
											</div>

										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" id="smpn_addprc" name="smpn_addprc" class="btn bg-green waves-effect"><i class="material-icons">saves</i>Save</button>		
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal fade" id="mdaddbudprcqty" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">ADDITIONAL QTY AND PRICE</h4></div>
							<form action="" id="frm_addprcqty" name="frm_addprcqty" method="post"  enctype="multipart/form-data">
								<div class="modal-body">
									<div class="body">
										<input type="hidden" readonly class="bg-grey form-control" id="plan_addprcqty" name="plan_addprcqty" value="" required>
										<div class="col-lg-12">	
											<div class="form-group">
												<label>No Control Plan</label>
												<div class="input-group">
													<div class="form-line">
														<input type="text" readonly class="bg-grey form-control" id="noctrlplanpq" name="noctrlplanpq" placeholder="No Contro" required>
													</div>

													<span class="input-group-addon">
														<button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl123('template.php?plh=select/budtoadd.php&og=noctrlplanpq,qty_planpq,price_planpq,,')"><i class="material-icons">search</i> 
														</button>
													</span>								
												</div>
											</div>
											<div class="col-md-6">	
												<div class="form-group">
													<label>QTY Plan</label>
													<div class="form-line">
														<input type="number" readonly class="bg-grey form-control" id="qty_planpq" name="qty_planpq" placeholder="QTY Plan" required>
													</div>
												</div>	
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Price Plan</label>
													<div class="form-line">
														<input type="number" readonly class="bg-grey form-control" id="price_planpq" name="price_planpq" placeholder="Price plan" required>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Qty Add</label>
													<div class="form-line">
														<input type="number" min="0" class="form-control" id="qty_addpq" name="qty_addpq" placeholder="Qty Add" required>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Price Add</label>
													<div class="form-line">
														<input type="number" step="any" class="form-control" id="price_addpq" name="price_addpq" placeholder="Price Add" required>
													</div>
												</div>
											</div>

											<div class="form-group">
												<label>Remark Additional</label>
												<div class="form-line">
													<textarea type="text" name="rmk_ad" id="rmk_ad" class="form-control"  required> </textarea>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" id="smpn_addpq" name="smpn_addpq" class="btn bg-green waves-effect"><i class="material-icons">saves</i>Save</button>		
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal fade" id="mdaddbudper" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">ADDITIONAL CHANGE PERIODE</h4></div>
							<form action="" id="frm_addper" name="frm_addper" method="post"  enctype="multipart/form-data">
								<div class="modal-body">
									<div class="body">
										<input type="hidden" readonly class="bg-grey form-control" id="plan_addper" name="plan_addper" value="" required>
										<div class="col-md-3">	
											<div class="form-group">
												<label>Periode Add</label>
												<div class="form-line">
													<input type="text" class="periodeflex form-control" id="periode_add" name="periode_add" placeholder="periode" required>
												</div>
											</div>	
										</div>
										<div class="col-lg-12">	
											<div class="form-group">
												<label>No Control Plan</label>
												<div class="input-group">
													<div class="form-line">
														<input type="text" readonly class="bg-grey form-control" id="noctrlplanper" name="noctrlplanper" placeholder="No Contro" required>
													</div>

													<span class="input-group-addon">
														<button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl1234('template.php?plh=select/budtoadd.php&og=noctrlplanper,qplan,pplan,,')"><i class="material-icons">search</i> </button>
													</span>								
												</div>
											</div>

											<div class="col-md-6">	
												<div class="form-group">
													<label>QTY Plan</label>
													<div class="form-line">
														<input type="number" readonly class="bg-grey form-control" id="qplan" name="qplan" placeholder="QTY Plan" required>
													</div>
												</div>	
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Price Plan</label>
													<div class="form-line">
														<input type="number" readonly class="bg-grey form-control" id="pplan" name="pplan" placeholder="Price plan" required>
													</div>
												</div>
											</div>

											<div class="form-group">
												<label>Remark Additional</label>
												<div class="form-line">
													<textarea type="text" name="rmk_ad" id="rmk_ad" class="form-control"  required> </textarea>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Rev Qty</label>
													<div class="form-line">
														<input type="number" min="0" max="qplan" class="form-control" id="rev_qty" name="rev_qty" placeholder="qplan">
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Price plan use</label>
													<div class="form-line">
														<input type="number" step="any" class="form-control" id="padd" name="padd" placeholder="Price Add">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" id="smpn_addper" name="smpn_addper" class="btn bg-green waves-effect"><i class="material-icons">saves</i>Save</button>		
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="modal fade" id="mdadditem" tabindex="-1" role="dialog">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">ADDITIONAL BUDGET ADD ITEM
								<button type="button" class="btn btn-link waves-effect  pull-right" data-dismiss="modal">CLOSE</button></h4>
							</div>
							<div class="card">
								<div class="body">
									<form role="form"  name="frm_additem" id="frm_additem" class="step_with_validation" method="post" action="">
										<h3>STEP 1</h3>
										<fieldset>
											<div class="col-md-3">
												<div class="form-group">
													<label>Term</label>
													<div class="form-line">
														<input type="text" readonly class="form-control bg-grey" id="term_item" name="term_item" value="" required>
													</div>
												</div>
												<div class="form-group">
													<label>Periode</label>
													<div class="form-line">
														<input type="number" readonly class="form-control bg-grey" id="periode_item" name="periode_item" value="" placeholder="Periode" required>
													</div></div>
													<div class="form-group">
														<label>Section</label>
														<div class="form-line">
															<input type="text" readonly class="form-control bg-grey" id="sect_item" name="sect_item" value="" required>
														</div>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Account</label>
														<div class="input-group">
															<div class="form-line">
																<input type="text" readonly class="form-control bg-grey" id="account" name="account" placeholder="Account" required>
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
																<button type="button" class="btn bg-purple waves-effect"  onclick="open_child('template.php?plh=select/plh_cccode.php&o=cccode&k=1&nomor=-1','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
															</span>
														</div>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Phase</label>
														<div class="input-group">
															<select class="selectpicker_temp" style="width: 100%;"  name="phase" id="phase"  required>
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
														<label>Purchasing</label>
														<div class="input-group">
															<select class="selectpicker_temp" style="width: 100%;"  name="lp" id="lp"  required>
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
													<div class="form-group">
														<label>Process Code</label>
														<div class="input-group">
															<div class="form-line">
																<input type="text" readonly class="form-control bg-grey" id="id_proses" name="id_proses" placeholder="Kode Proses" required>
															</div> 
															<span class="input-group-addon">
																<button type="button" class="btn bg-purple waves-effect"  onclick="open_child('template.php?plh=select/plh_pros.php','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> </button>
															</span>
														</div>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Type</label>
														<div class="form-line">
															<input type="text" readonly class="form-control bg-grey" id="jns_bud" name="jns_bud" value="ADDITIONAL" required>
														</div>
													</div>
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
														</div>
													</div>
													<div class="form-group">
														<label>Part No</label>
														<div class="form-line">
															<input type="text" readonly class="form-control bg-grey" id="part_no" name="part_no" placeholder="Part No" required>
														</div>
													</div>
												</div>
												<div class="col-md-5">
													<div class="form-group">
														<label>Detail Part</label>
														<div class="form-line">
															<input type="text" readonly class="form-control bg-grey" id="part_dtl" name="part_dtl" placeholder="Detail Part" required>
														</div></div>
														<div class="form-group">
															<label>Remark Part</label>
															<div class="form-line">
																<input type="text" class="form-control" id="part_desc" name="part_desc" placeholder="Remark Part">
															</div> 
														</div>
													</div>
													<div class="col-md-4">
														<div class="col-md-6">
															<div class="form-group">
																<label>Qty</label>
																<div class="form-line">
																	<input type="number" min="0" class="form-control" id="qty" name="qty" placeholder="Qty" required>
																</div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>UOM</label>
																<div class="form-line">
																	<input type="text" readonly class="form-control bg-grey"  id="uom" name="uom" placeholder="Uom" required>
																</div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>Currency</label>
																<div class="form-line">
																	<input type="text" readonly class="form-control bg-grey"  id="curr" name="curr" placeholder="Currency" required>
																</div>
															</div>
														</div>	
														<div class="col-md-6">
															<div class="form-group">
																<label>Price</label>
																<div class="form-line">
																	<input type="number" min="0.00" step="any" class="form-control" id="price" name="price" placeholder="Price" required>
																</div>
															</div>
														</div>
													</div>
													<div class="col-sm-6">	
														<div class="form-group">
															<label>Remark Additional</label>
															<div class="form-line">
																<textarea type="text" name="rmk_ad" id="rmk_ad" class="form-control"  required> </textarea>
															</div>
														</div>
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
																</div>
															</div>                
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label>LT PO</label>
																<div class="form-line">
																	<input type="number" class="form-control" id="lt_po" name="lt_po" min="0" placeholder="LT PO" required>
																</div>
															</div>                
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label>LT Arrival</label>
																<div class="form-line">
																	<input type="number" class="form-control" id="lt_datang" name="lt_datang"  min="0"  placeholder="LT Arrival" required>
																</div>
															</div>                
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label>LT VP</label>
																<div class="form-line">
																	<input type="number" class="form-control" id="lt_vp" name="lt_vp" min="0"  placeholder="LT VP" required>
																</div>
															</div>

														</div>
														<div class="col-md-2">
															<button type="submit" id="smpn_item" name="smpn_item" class="btn bg-green waves-effect"><i class="material-icons">saves</i>SIMPAN</button>	
														</div>
													</fieldset>    

												</form>	                   
											</div>
										</div>
									</div>
								</div>
							</div>
							<script type="text/javascript">
								$(document).ready(function()
								{

									$('.periodemn').bootstrapMaterialDatePicker({
										format: 'YYYYMM', Date : new Date(),
										clearButton: true,
										weekStart: 0,
										time: false
									});		
									$('.perioded').bootstrapMaterialDatePicker({
										format: 'YYYYMM', Date : new Date(),
										clearButton: true,
										weekStart: 0,
										time: false
									});		
									$('.periodeflex').bootstrapMaterialDatePicker({
										format: 'YYYYMM',
										clearButton: true,
										weekStart: 0,
										time: false
									});	
								});
							</script>
							<script type="text/javascript">
								var no_ctrl_plan=document.getElementById("no_ctrl_plan").innerHTML;
								$(document).ready(function()
								{
									$('.selectpicker_temp').selectpicker();
								});
							</script>