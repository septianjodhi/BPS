<?php $sect= $_SESSION["area"]; ?>	 
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
			document.frm_additem.del_plan.value=periode_cr;
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
				document.frm_additem.plan_additem.value=gabung;
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
		var balp=parseInt(pnd)-parseInt(nperi);
	//  alert(balp);
	if(pno=="" || balp<0){alert("Term-Section Belum dipilih Atau Periode Kurang dari Bulan Sekarang");}else{
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		w = window.open(url+'&t='+pno+'&p='+pnd, title, 'toolbar=no, location=no, directories=no, \n\
			status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
			width='+w+',height='+h+',top='+top+',left='+left);		
	} };
	function cekctrl4(url,title,w,h){
		var pno=document.frm_add.term.value;
		var pnd=document.frm_add.periode_plan.value;
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

	var balp=parseInt(periode_cr)-parseInt(nperi);
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
		// var jns_bud=document.frm_additem.jns_bud.value;
		var pernow = new Date();
		var nperi=pernow.getFullYear()+''+("0"+(pernow.getMonth()+1)).slice(-2);
		var balp=parseInt(pnd)-parseInt(nperi);
	 // alert(balp);
	 if(pno=="" ||sec=="" || balp<0){alert("Term-Section Belum dipilih Atau Periode Kurang dari Bulan Sekarang");}else{
	 	var left = (screen.width/2)-(w/2);
	 	var top = (screen.height/2)-(h/2);
	 	// w = window.open(url+'&t='+pno+'&p='+pnd+'&s='+sec+'&k='+jns_bud, title, 'toolbar=no, 
	 	w = window.open(url+'&t='+pno+'&p='+pnd+'&s='+sec, title, 'toolbar=no, location=no, directories=no, \n\
	 		status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
	 		width='+w+',height='+h+',top='+top+',left='+left);		
	 };
	};
</script>	  
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>ADDITIONAL BUDGET </h2>
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
									<input type="number" readonly class="periodemn bg-grey form-control" id="periode_cr" name="periode_cr" value="<?php echo date("Ym"); ?>" placeholder="Periode Plan" required>
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
										<button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl3('template.php?plh=select/cek_noctrl_invest.php&o=no_ctrl_cr&k=Additional&s=<?php echo $sect; ?>','Data','800','500'); return false;"><i class="material-icons">search</i> </button>
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
										<!-- <option value="3-QTY_AND_PRICE">QTY AND PRICE</option> -->
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
	$pic_updt=$_SESSION['nama'];
	if(isset($_POST['smpn_addqty']) ){

		$plan_addqty=$_POST['plan_addqty'];
		$pprice=$_POST['price_planq'];
		$pchplanqty=explode(",",$plan_addqty);
		$pchket=explode("-",$pchplanqty[3]);
		$noctrlplanq=$_POST['noctrlplanq'];
		$qty_addq=$_POST['qty_addq'];
		$rmk_ad=$_POST['rmk_ad'];
		$price_addq=$_POST['price_addq'];
		$per_add=$pchplanqty[1];
		
		$crperi="select top 1 periode,expired from bps_budget_invest_add where no_ctrl='$noctrlplanq' and kode_chg=4";
		
		$tb_crperq = odbc_exec($koneksi_lp,$crperi);
		$per_adqt=odbc_result($tb_crperq,"periode");
		if($per_adqt==''){$crperq="periode";}else{$crperq="'$per_adqt'";}

		$exp_adqt=odbc_result($tb_crperq,"expired");
		if($exp_adqt==''){$crexpq="expired";}else{$crexpq="'$exp_adqt'";}

		$q_insert="insert into bps_budget_invest_add (no_ctrl,no_ctrl_add,sect,periode,sub_term,cip_no,bud_group,qty,price,
		order_plan,del_plan,carline,term,expired,start_order,lt_quo,lt_pr,lt_po,lt_dtg,lt_vp,jns_budget,remark,
		kode_chg,ket_chg,status,pic_updt,tgl_updt,doc_no)";

		$q_query="select top 1 no_ctrl,'$pchplanqty[2]' as no_ctrl_add,sect,
		'$per_add' as periode,sub_term,cip_no,bud_group,$qty_addq as qty,$price_addq as price,
		(case when order_plan > '$per_add' then '$per_add' else order_plan end ) as order_plan,
		'$per_add' as del_plan,carline,	term,expired,start_order,14 as t_quo,0 as lt_pr,
		0 as lt_po,5 as lt_dtg,5 as lt_vp,'ADDITIONAL' jns_budget,'$rmk_ad' as remark,1 as kode_chg,'QTY ONLY' as ket_chg,'OPEN','$pic_updt' as pic_updt,
		getdate() as tgl_updt,0 as doc_no  from bps_budget_invest where no_ctrl='$noctrlplanq'";

		$tb_del = odbc_exec($koneksi_lp,"delete from bps_budget_invest_add where no_ctrl_add='$pchplanqty[2]'");
		$tb_add = odbc_exec($koneksi_lp,$q_insert." ".$q_query);
		echo "<script>alert('DATA SUDAH DI UPDATE');</script>";
		$sq_acc="select * from bps_budget_invest_add where no_ctrl_add='$pchplanqty[2]'";
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
		$per_add=$pchplanprc[1];
		if($revqty_addp==""){$revqty=$qty_planp;}else{$revqty=min($revqty_addp,$qty_planp);}
		
		// $crper="select top 1 qty,periode,expired from bps_budget_invest_add where no_ctrl='$noctrlplanp' and kode_chg=4";
		// $tb_crper = odbc_exec($koneksi_lp,$crper);
		// $per=odbc_result($tb_crper,"periode");
		// if($per==''){$crper="periode";}else{$crper="'$per'";}

		// $qty_adprc=odbc_result($tb_crper,"qty");
		// $exp_adprc=odbc_result($tb_crper,"expired");
		// if($exp_adprc==''){$crexp="expaired";}else{$crexp="'$exp_adprc'";}

		$q_insert="insert into bps_budget_invest_add (no_ctrl,no_ctrl_add,sect,periode,sub_term,cip_no,bud_group,qty,price,
		order_plan,del_plan,carline,term,expired,start_order,lt_quo,lt_pr,lt_po,lt_dtg,lt_vp,jns_budget,remark,
		kode_chg,ket_chg,status,pic_updt,tgl_updt,doc_no)";

		$q_query="select top 1 no_ctrl,'$pchplanprc[2]' as no_ctrl_add,sect,'$per_add' as periode,sub_term,cip_no,bud_group,$revqty as qty,
		$price_addp as price,(case when order_plan > '$per_add' then '$per_add' else order_plan end ) as order_plan,
		'$per_add' as del_plan,carline,	term,expired,start_order,14 as lt_quo,0 as lt_pr,0 as lt_po,5 as lt_dtg,
		5 as lt_vp,'ADDITIONAL' jns_budget,'$rmk_ad' as remark,2 as kode_chg,'PRICE ONLY' as ket_chg,'OPEN','$pic_updt' as pic_updt,
		getdate() as tgl_updt,0 as doc_no  from bps_budget_invest where no_ctrl='$noctrlplanp'";

		$tb_del = odbc_exec($koneksi_lp,"delete from bps_budget_invest_add where no_ctrl_add='$pchplanprc[2]'");
		$tb_add = odbc_exec($koneksi_lp,$q_insert." ".$q_query);
		echo "<script>alert('DATA SUDAH DI UPDATE');</script>";
		$sq_acc="select * from bps_budget_invest_add where no_ctrl_add='$pchplanprc[2]'";
		// echo $q_insert." ".$q_query;
	}


/*
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
		echo $qryaddqty;
	}
*/


	if(isset($_POST['smpn_addper']) )
	{
		$plan_addper=$_POST['plan_addper'];
		$pchplanper=explode(",",$plan_addper);
		$pchket=explode("-",$pchplanper[3]);
		$noctrlplanper=$_POST['noctrlplanper'];
		$qplan=$_POST['qplan'];
		$rev_qty=$_POST['rev_qty'];
		$rmk_ad=$_POST['rmk_ad'];

		$padd=$_POST['padd'];
		$pplan=$_POST['pplan'];
		$periode_add=$_POST['periode_add'];

		if($rev_qty==''){$qty_per=$qplan;}else{$qty_per=$rev_qty;}
		if($padd==''){$price_per=$pplan;}else{$price_per=$padd;}

		$q_amnact="select isnull(sum(dbo.lp_konprc(term,'USD',curr,price_tot*qty_act)),0) 
		as amn_usd from bps_tmpPR 
		where pr_no like '%invest%' and equipment='$noctrlplanper'";

		$dt_amnact = odbc_exec($koneksi_lp,$q_amnact);
		$amnact_usd=odbc_result($dt_amnact,"amn_usd");

		$amn_plan=$pplan*$qplan;
		$amn_revper=$price_per*$qty_per;
		$amn_sisa=$amn_plan-$amnact_usd;	

		// if($amn_sisa>=$amn_revper){
			$price=min($pplan,$price_per);
			$qty_used=min($qplan,$qty_per);
			
			$q_insert="insert into bps_budget_invest_add (no_ctrl,no_ctrl_add,sect,periode,sub_term,cip_no,bud_group,qty,price,
			order_plan,del_plan,carline,term,expired,start_order,lt_quo,lt_pr,lt_po,lt_dtg,lt_vp,
			jns_budget,remark,kode_chg,ket_chg,status,pic_updt,tgl_updt,doc_no)";

			$q_query="select top 1 no_ctrl,'$pchplanper[2]' as no_ctrl_add,sect,
			'$pchplanper[1]' as periode,sub_term,cip_no,bud_group,$qty_per as qty,
			$price as price,order_plan,del_plan,carline,term,
			left('$pchplanper[1]',4)+'-'+(right('$pchplanper[1]',2))+'-28' expired,
			start_order,14 as t_quo,0 as lt_pr,0 as lt_po,5 as lt_dtg,5 as lt_vp,
			'ADDITIONAL' as jns_budget,'$rmk_ad' as remark,4 as kode_chg,
			'PERIODE' as ket_chg,'OPEN','$pic_updt' as pic_updt,
			getdate() as tgl_updt,0 as doc_no from bps_budget_invest where no_ctrl='$noctrlplanper'";

			$tb_del = odbc_exec($koneksi_lp,"delete from bps_budget_invest_add where no_ctrl_add='$noctrlplanper'");
			$tb_add = odbc_exec($koneksi_lp,$q_insert." ".$q_query);
			echo $q_insert." ".$q_query;
			echo "<script>alert('DATA SUDAH DI UPDATE');</script>";
			$sq_acc="select * from bps_budget_invest_add where no_ctrl_add='$pchplanper[2]'";
		// echo $qryaddprc;
		// }
		// else{
		// 	echo "<script>alert('SISA BUDGET INVEST TIDAK MENCUKUPI $amn_sisa - $amn_revper');</script>";
		// }
	}

	if(isset($_POST['smpn_item'])){	
		$plan_additem=$_POST['plan_additem'];
		$term_item=$_POST['term_item'];
		$order_plan=$_POST['order_plan'];
		$sect_item=$_POST['sect_item'];
		$del_plan=$_POST['del_plan'];
		$periode=$_POST['periode_item'];
		$carline=$_POST['carline'];
		$cip_no=$_POST['cip_no'];
		$qty=$_POST['qty'];
		$price=$_POST['price'];
		$bud_group=$_POST['bud_group'];
		$rmk_ad=$_POST['rmk_ad'];
		$lt_Quo=$_POST['lt_Quo'];
		$lt_pr=$_POST['lt_pr'];
		$lt_po=$_POST['lt_po'];
		$lt_datang=$_POST['lt_datang'];
		$lt_vp=$_POST['lt_vp'];

		$pchitem=explode(",",$plan_additem);
		$no_ctrl_item=$pchitem[2];

		$expaired=date("Y-m-d",strtotime($periode."28"));
		$nilai_per=substr($periode,-2);
		if($nilai_per>=7){$sub_term="'7-12'";}else{$sub_term="'1-6'";}
		// $prcquoitm="select top 1 price from bps_Quotation where part_no='$part_no' and
		// lp_rekom='YES' and Exp_Quo>='$expaired' order by tgl_updt desc";

		// $tb_prcquoitm = odbc_exec($koneksi_lp,$prcquoitm);
		// $prc_quo2=odbc_result($tb_prcquoitm,"price");
		// if($prc_quo2==''){$priceA=$price;}else{$priceA=$prc_quo2;}

		$q_insert="insert into bps_budget_invest_add (no_ctrl,no_ctrl_add,sect,periode,sub_term,
		cip_no,bud_group,qty,price,order_plan,del_plan,carline,term,expired,lt_quo,lt_pr,
		lt_po,lt_dtg,lt_vp,jns_budget,remark,kode_chg,ket_chg,status,pic_updt,tgl_updt,doc_no) ";

		$qry_add="values ('$no_ctrl_item','$no_ctrl_item','$sect','$periode',$sub_term,'$cip_no',
		'$bud_group',$qty,$price,'$order_plan','$del_plan','$carline','$term_item','$expaired',
		$lt_Quo,$lt_pr,$lt_po,$lt_datang,$lt_vp,'ADDITIONAL','$rmk_ad',5,'NEW ITEM','OPEN',
		'$pic_updt',getdate(),0)";

		$tb_add = odbc_exec($koneksi_lp,$q_insert." ".$qry_add);

		echo "<script>alert('DATA SUDAH DI UPDATE');</script>";
		$sq_acc="select * from bps_budget_invest_add where no_ctrl_add='$no_ctrl_item'";
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
									<th>CIP NO</th>
									<th>GROUP EQUIPMENT</th>
									<th>QTY ADD</th>
									<th>PRICE ADD</th>
									<th>KET ADD</th>
									<th>STATUS ADD</th>
								</tr>
							</thead>

							<tbody>
								<?php
								$sq_acc="";
								if(isset($_POST['cr_b']) ){	
//$cmd_tbl=$_POST['cmd_tbl'];
//if($cmd_tbl=="real"){$tbl="";}else{$tbl="_temp";}
									$cmd_cari=$_POST['cmd_cari'];
									$txt_cari=str_replace(" ","",$_POST['txt_cari']);
									if($txt_cari==""){$whr="no_ctrl is not null"; }else{
										$whr="replace($cmd_cari,' ','') like '%$txt_cari%'";}
										$sq_acc="select * from bps_budget_invest_add where sect='$sect' and $whr and doc_date is null";
									}
									if($sq_acc!=""){
										$tb_acc=odbc_exec($koneksi_lp,$sq_acc);
										$row=0;
										$opsi_del="";
										// echo $sq_acc;
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
												<td><?php echo odbc_result($tb_acc,"cip_no"); ?></td>
												<td><?php echo odbc_result($tb_acc,"bud_group"); ?></td>
												<td><?php echo odbc_result($tb_acc,"qty"); ?></td>
												<td><?php echo odbc_result($tb_acc,"price"); ?></td>
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
					$tb_del1=odbc_exec($koneksi_lp,"delete from bps_budget_invest_add where no_ctrl_add='$no_ctrl_dell'");
				// $tb_del2=odbc_exec($koneksi_lp,"delete from bps_budget where no_ctrl='$no_ctrl_dell'");
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
												<button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl123('template.php?plh=select/budtoadd_invest.php&og=noctrlplanq,qty_planq,price_planq,,price_addq')"><i class="material-icons">search</i> </button>
											</span>								
										</div>
									</div>

									<div class="form-group">
										<label>Remark Additional</label>
										<div class="form-line">
											<textarea type="text" name="rmk_ad" id="rmk_ad" class="form-control"  required> </textarea>
										</div>
									</div>
								</div>
								<div class="col-md-3">	
									<div class="form-group">
										<label>QTY Plan</label>
										<div class="form-line">
											<input type="number" readonly class="bg-grey form-control" id="qty_planq" name="qty_planq" placeholder="QTY Plan" required>
										</div>
									</div>
									<div class="form-group">
										<label>QTY Add</label>
										<div class="form-line">
											<input type="number" min="0" step="any" class="form-control" id="qty_addq" name="qty_addq" placeholder="QTY Add" required>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Price Plan</label>
										<div class="form-line">
											<input type="number" readonly class="bg-grey form-control" id="price_planq" name="price_planq" placeholder="Price plan" required>
										</div>
									</div>
									<div class="form-group">
										<label>Price Add</label>
										<div class="form-line">
											<input type="number" min="0" readonly step="any" class="bg-grey  form-control" id="price_addq" name="price_addq" placeholder="Price Add" required>
										</div>
									</div>
								</div>
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
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">ADDITIONAL PRICE ONLY</h4></div>
				<form action="" id="frm_addprc" name="frm_addprc" method="post"  enctype="multipart/form-data">
					<div class="modal-body">
						<div class="body">
							<input type="hidden" readonly class="bg-grey form-control" id="plan_addprc" name="plan_addprc" value="" required>
							<div class="col-lg-12">
								<div class="col-lg-6">	
									<div class="form-group">
										<label>No Control Plan</label>
										<div class="input-group">
											<div class="form-line">
												<input type="text" readonly class="bg-grey form-control" id="noctrlplanp" name="noctrlplanp" placeholder="No Control" required>
											</div>
											<span class="input-group-addon">
												<button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl123('template.php?plh=select/budtoadd_invest.php&og=noctrlplanp,qty_planp,price_planp,,')"><i class="material-icons">search</i> </button>
											</span>								
										</div>
									</div>

									<div class="form-group">
										<label>Remark Additional</label>
										<div class="form-line">
											<textarea type="text" name="rmk_ad" id="rmk_ad" class="form-control"  required></textarea>
										</div>
									</div>

								</div>
								<div class="col-md-3">	
									<div class="form-group">
										<label>QTY Plan</label>
										<div class="form-line">
											<input type="number" readonly class="bg-grey form-control" id="qty_planp" name="qty_planp" placeholder="QTY Plan" required>
										</div>
									</div>
									<div class="form-group">
										<label>Rev Qty</label>
										<div class="form-line">
											<input type="number" min="0" max="qty_planp" class="form-control" id="revqty_addp" name="revqty_addp" placeholder="Rev Qty">
										</div>
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label>Price Plan</label>
										<div class="form-line">
											<input type="number" readonly class="bg-grey form-control" id="price_planp" name="price_planp" placeholder="Price plan" required>
										</div>
									</div>
									<div class="form-group">
										<label>Price Add</label>
										<div class="form-line">
											<input type="number" step="any" class="form-control" id="price_addp" name="price_addp" placeholder="Price Add" required>
										</div>
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
		<div class="modal-dialog modal-lg" role="document">
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
											<button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl123('template.php?plh=select/budtoadd_invest.php&og=noctrlplanpq,qty_planpq,price_planpq,,')"><i class="material-icons">search</i> 
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
										<textarea type="text" name="rmk_ad" id="rmk_ad" class="form-control" required>
										</textarea>
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
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">
				ADDITIONAL CHANGE PERIODE</h4>
			</div>
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
										<button type="button" class="btn bg-purple waves-effect"  onclick="cekctrl1234('template.php?plh=select/budtoadd_invest.php&og=noctrlplanper,qplan,pplan,,')"><i class="material-icons">search</i> </button>
									</span>								
								</div>
							</div>

							<div class="col-md-6">	
								<div class="form-group">
									<label>QTY Plan</label>
									<div class="form-line">
										<input type="number" class="bg-grey form-control" id="qplan" name="qplan" placeholder="QTY Plan" required>
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
			<div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">
				ADDITIONAL BUDGET ADD ITEM
				<button type="button" class="btn btn-link waves-effect pull-right" data-dismiss="modal">CLOSE
				</button></h4>
			</div>
			<div class="card">
				<div class="body">
					<form role="form"  name="frm_additem" id="frm_additem" class="step_with_validation" method="post" action="">
						<input type="hidden" readonly class="bg-grey form-control" id="plan_additem" name="plan_additem" value="" required>
						<h3>STEP 1</h3>
						<fieldset>
							<div class="col-md-4">
								<div class="form-group">
									<label>Term</label>
									<div class="form-line">
										<input type="text" readonly class="form-control bg-grey" id="term_item" name="term_item" value="" required>
									</div>
								</div>
								<div class="form-group">
									<label>Order Plan</label>
									<div class="form-line">
										<input type="number" class="periodemn form-control" id="order_plan" name="order_plan" value="" placeholder="Order Plan" required>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Section</label>
									<div class="form-line">
										<input type="text" readonly class="form-control bg-grey" id="sect_item" name="sect_item" value="" required>
									</div>
								</div>
								<div class="form-group">
									<label>Delivery Plan</label>
									<div class="form-line">
										<input type="number" readonly class="bg-grey form-control" id="del_plan" name="del_plan" value="" placeholder="Delivery Plan" required>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Periode</label>
									<div class="form-line">
										<input type="number" readonly class="form-control bg-grey" id="periode_item" name="periode_item" value="" placeholder="Periode" required>
									</div>
								</div>								
								<div class="form-group">
									<label>Carline</label>
									<div class="input-group">
										<div class="form-line">
											<input type="text" readonly class="form-control bg-grey" id="carline" name="carline" placeholder="Cost Center" required>
											<input type="hidden" class="form-control" id="cccode" name="cccode" >
										</div>
										<span class="input-group-addon">
											<button type="button" class="btn bg-purple waves-effect"  onclick="open_child('template.php?plh=select/plh_carline.php&o=cccode&k=1','Data Conveyor','800','500'); return false;"><i class="material-icons">search</i> 
											</button>
										</span>
									</div>
								</div>
							</div>
						</fieldset>
						<h3>STEP 2</h3>
						<fieldset>
							<div class="col-md-4">
								<div class="form-group">
									<label>CIP No</label>
									<div class="form-line">
										<input type="text" class="form-control" id="cip_no" name="cip_no" placeholder="Cip No" required>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Qty</label>
									<div class="form-line">
										<input type="number" min="0" class="form-control" id="qty" name="qty" placeholder="Qty" required>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Price</label>
									<div class="form-line">
										<input type="number" min="0.00" step="any" class="form-control" id="price" name="price" placeholder="Price" required>
									</div>
								</div>
							</div>
							<div class="col-sm-12">	
								<div class="form-group">
									<label>Equipment Group</label>
									<div class="form-line">
										<input type="text" class="form-control" id="bud_group" name="bud_group" placeholder="Equipment Group" required>
									</div>
								</div>
								<div class="form-group">
									<label>Remark Additional</label>
									<div class="form-line">
										<input type="text" class="form-control" id="rmk_ad" name="rmk_ad" placeholder="Equipment Group" required>
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
									</div>
								</div>
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
	function pilih(row){
		var kd_pel1=row.cells[3].innerHTML;
		document.frmdel.prdel.value=kd_pel1;
	};
	function deletepr(){
		$('#mddel').modal('show');
     // window.location.assign('urlkedua')
   };

   $(document).ready(function()
   {
   	$('.periodemn').bootstrapMaterialDatePicker({
   		format: 'YYYYMM', minDate : new Date(),
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

   var no_ctrl_plan=document.getElementById("no_ctrl_plan").innerHTML;
   $(document).ready(function()
   {
   	$('.selectpicker_temp').selectpicker();
   });
 </script>