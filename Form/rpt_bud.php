<?php 
$sect= $_SESSION["area"]; 
$user=$_SESSION["user"];
$akses=$_SESSION["akses"];
$lok=$_SESSION['lok'];
$admin_FA=strpos($akses,'_FA');
$kd_akses=explode(",",$akses);
if(in_array('ADM_FA',$kd_akses)){
  $admin1="admin";
}else{
  $admin1="user";
}

// $kd_akses=explode(",",$akses);

// $_SESSION['lok']=$_GET['sesi']; 
?>	
<script type="text/javascript">
//var sect="<?php echo $sect; ?>";
function open_child(url,title,w,h){
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
		status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
		width='+w+',height='+h+',top='+top+',left='+left);
};

function dwndtl_pr(url,title,w,h){
	var term=document.form1.term.value;
//var ur="Exp_xls/exp_dtl_PR1.php?s="+sect;
if("<?php echo $admin1 ; ?>"=='admin'){
	var sect=document.form1.sec.value;
}else{
	var sect="<?php echo $sect; ?>";
}
if(url=="D"){
  ur="Exp_xls/exp_dtl_PR.php?s="+sect+"&t="+term;
}else if(url=="S"){
		// ur="Exp_xls/exp_sum_PR.php?s="+sect+"&t="+term;
    ur="Exp_xls/exp_act_bud.php?s="+sect+"&t="+term;
  }else {
    ur="Exp_xls/exp_planbud_old.php?s="+sect+"&t="+term;
  }
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  w = window.open(ur, title, 'toolbar=no, location=no, directories=no, \n\
    status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
    width='+w+',height='+h+',top='+top+',left='+left);

};

function dwndtl_pr2(url,title,w,h){
	var term=document.form2.term.value;
	var periode=document.form2.periode.value;
	if(term=="" ||periode==""){
    alert("Term dan Periode Harus diisi");
  }else{
	if("<?php echo $admin1 ; ?>"=='admin'){
		var sect=document.form2.sec.value;
	}else{
		var sect="<?php echo $sect; ?>";}
//var ur="Exp_xls/exp_dtl_PR1.php?s="+sect;
if(url=="A"){
	ur="Exp_xls/exp_budAdd.php?s="+sect+"&t="+term+"&p="+periode;
}else if(url=="P"){
	ur="Exp_xls/exp_bud.php?s="+sect+"&t="+term+"&p="+periode;
}else if(url=="F"){
	ur="Exp_pdf/rpt_stp.php?s="+sect+"&t="+term+"&p="+periode;
}else{
	ur="Exp_xls/rpt_budBB.php?s="+sect+"&t="+term+"&p="+periode;
}
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
w = window.open(ur, title, 'toolbar=no, location=no, directories=no, \n\
	status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
	width='+w+',height='+h+',top='+top+',left='+left);
  }
};
</script>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>DOWNLOAD REPORT PR</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12">
				<div class="card">
					<div class="header">
						<h2>DETAIL PR <?php echo $sect; ?><small>Download Detail PR Per Term</small></h2>
          </div>
          <div class="body">
           <div class="row clearfix">
            <div class="col-md-12">	
             <form role="form"  name="form1" id="form1" method="post" action="">

              <div class="col-sm-3">	
               <div class="form-group">
                <label>Term</label>
                <div class="group-line">
                 <select class="selectpicker"  style="width: 100%;"  name="term" id="term" required>
                  <option selected="selected" value="">-Pilih Term-</option>
                  <?php 
                  $tb_term=odbc_exec($koneksi_lp,"select distinct term from bps_setterm order by term desc");
                  $row=0;
                  while($bar_term=odbc_fetch_array($tb_term))
                  {
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

         <?php if( $kd_akses[1]=='ADM_FA'){ ?>
           <div class="col-sm-3">	
            <div class="form-group">
             <label>Sect</label>
             <div class="group-line">
              <select class="selectpicker"  style="width: 100%;"  name="sec" id="sec">
               <option selected="selected" value="">-Pilih Sect-</option>
               <?php 
               $tb_sect=odbc_exec($koneksi_lp,"select distinct sect from bps_pr order by sect asc");
               while($bar_sect=odbc_fetch_array($tb_sect)){
                $tsect=odbc_result($tb_sect,"sect");
                echo'<option value="'.$tsect.'">'.$tsect.'</option>';
              }
              ?>
            </select>
          </div>
        </div>
      </div>
    <?php } ?>
    <div class="col-sm-12">
      <button type="button" onclick="dwndtl_pr('D','Detail PR','800','500'); return false;">Detail PR</button>
      <button type="button" onclick="dwndtl_pr('S','Detail PR','800','500'); return false;">Actual Budget</button>
      <button type="button" onclick="dwndtl_pr('PB','Detail PR','800','500'); return false;">Plan Budget</button>
    </div>
  </form>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row clearfix">
 <div class="col-lg-12">
  <div class="card">
   <div class="header">

    <h2>REPORT BUDGET PER PERIODE<small>Download Report <?= $admin1 ; ?></small></h2>
  </div>
  <div class="body">
   <div class="row clearfix">
    <div class="col-md-12">	
     <form role="form"  name="form2" id="form2" method="post" action="">

      <div class="col-sm-3">	
       <div class="form-group">
        <label>Term</label>
        <div class="group-line">
         <select class="selectpicker"  style="width: 100%;"  name="term" id="term" required>
          <option selected="selected" value="">-Pilih Term-</option>          
          <?php 
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
   <button type="button" onclick="dwndtl_pr2('V','Detail PR','800','500'); return false;">Act Budget Exp + Add ( excel)</button>
   <button type="button" onclick="dwndtl_pr2('F','Detail PR','800','500'); return false;">Act Budget Exp + Add ( pdf )</button>
 </div>

 <div class="col-sm-3">
   <div class="form-group">
    <label>Periode</label>
    <div class="group-line">
     <select class="selectpicker"  style="width: 100%;"  name="periode" id="periode">
      <option selected="selected" value="">-Pilih Periode-</option>
      <option value="ALL">-ALL-</option>
      <?php
      if($admin1!== 'admin'){
       $sql_peri="select distinct periode from bps_pr where sect='$sect' order by periode desc";}
       else
       {
        $sql_peri="select distinct periode from bps_pr order by periode desc";
      }
      $tb_peri=odbc_exec($koneksi_lp,$sql_peri);
      while($baris1=odbc_fetch_array($tb_peri)){ 
       $peri=odbc_result($tb_peri,"periode");
       echo '<option value="'.$peri.'">'.$peri.'</option>';}
       ?>
     </select>
   </div>
 </div>
 <button type="button" onclick="dwndtl_pr2('P','Detail PR','800','500'); return false;">Actual Budget Exp</button>
 <button type="button" onclick="dwndtl_pr2('A','Detail PR','800','500'); return false;">Actual Budget Add</button>
</div>

<?php if($kd_akses[1]=='ADM_FA'){?>
  <div class="col-sm-3">	
   <div class="form-group">
    <label>Sect</label>
    <div class="group-line">
     <select class="selectpicker"  style="width: 100%;"  name="sec" id="sec">
      <option selected="selected" value="">-Pilih Sect-</option>
      <option value="all">-All Section-</option>
      <?php 
      $tb_sect=odbc_exec($koneksi_lp,"select distinct sect from bps_pr order by sect asc");
      while($bar_sect=odbc_fetch_array($tb_sect)){
       $tsect=odbc_result($tb_sect,"sect");
       echo'<option value="'.$tsect.'">'.$tsect.'</option>';
     }
     ?>
   </select>
 </div>
</div>
</div>
<?php } ?>
</form>
</div>
</div>
</div>
</div>
</div>
</div>

</div>
</section>