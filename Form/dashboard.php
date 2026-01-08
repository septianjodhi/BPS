<script type="text/javascript">
  function open_child(url,title,w,h){
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
      status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
      width='+w+',height='+h+',top='+top+',left='+left);

  };	
</script>
<section class="content">
  <div class="container-fluid">
    <div class="row clearfix">
      <div class="card">
        <div class="row clearfix">				
          <div class="header">
            <h2>DASHBOARD<small>Control Budget Periode <?php $peri=date("Ym"); echo $peri; ?></small></h2>
          </div>

        </div>	   
        <div class="row clearfix">
          <div class="body">
            <div class="table-responsive">
              <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable tabel2">
                <thead>
                  <tr>	
                    <th>No</th>
                    <th>Section</th>
                    <th>periode</th>
                    <th>Budget</th>
                    <th>EXP PR</th>
                    <th>PR</th>
                    <th>Sisa Item</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $today=date("Y-m-d");
                  
                  $cr_term=odbc_exec($koneksi_lp,"select top 1 term from bps_setTerm where '$today' between start_term and finish_term ");
                  $term=odbc_result($cr_term, "term");

                  if(isset($_SESSION["area"])){
                    $section=$_SESSION["area"];
                    $whrsec="sect='".$_SESSION["area"]."'";
                  }else{$whrsec="periode='$peri'";}

                  $btw_tgl="getdate() and dateadd(month,1,getdate())";
//$sq_dash="SELECT distinct periode,sect,count(*) as jm,(select count(distinct no_ctrl) from bps_pr where periode=bps_budget.periode and sect=bps_budget.sect and (pr_date between $btw_tgl)) as qty_act from bps_budget where dbo.cr_waktulp('pr',no_ctrl) between $btw_tgl $whrsec group by periode,sect";
                  $sq_dash="SELECT distinct periode,sect,min(dbo.cr_waktulp('PR',no_ctrl)) as exp_pr,count(*) as jm,(select count(*) as cc from bps_pr where periode=bps_budget.periode and sect=bps_budget.sect) as qty_act from bps_budget where term=$term and $whrsec group by periode,sect order by sect,periode";
                  $tb_acc=odbc_exec($koneksi_lp,$sq_dash);
// echo $sq_dash ."<br>".$term;
                  $row=0;
                  while($baris1=odbc_fetch_array($tb_acc)){ $row++;
                    $c_bud=odbc_result($tb_acc,"jm");
                    $c_pr=odbc_result($tb_acc,"qty_act");
                    $c_bal=number_format($c_bud) - number_format($c_pr);
                    ?>	
                    <tr  onclick="javascript:pilih(this);">
                      <td><?php echo $row; ?></td>
                      <td><?php echo odbc_result($tb_acc,"sect"); ?></td>
                      <td><?php echo odbc_result($tb_acc,"periode"); ?></td>
                      <td><?php echo $c_bud; ?></td>
                      <td><?php echo odbc_result($tb_acc,"exp_pr"); ?></td>
                      <td><?php echo $c_pr; ?></td>
                      <td><?php echo $c_bal; ?></td>
                    </tr>	
                    <?php 
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

 <div class="container-fluid">
  <div class="row clearfix">
    <div class="card">
      <div class="row clearfix">        
        <div class="header">
          <h2>SUMMARY PROGRESS PR<small>Control PR Periode <?php $peri=date("Ym"); echo $peri; ?></small></h2>
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
                  <th>PR_NO</th>
                  <th>PR_DATE</th>
                  <th>STATUS_APRV</th>
                  <th>PO_NO</th>
                  <th>TGL_PO</th>
                  <th>STATUS_DTG</th>
                  <th>INV_NO</th>
                  <th>INV_TGL</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(isset($_SESSION["area"])){
                  $section=$_SESSION["area"];
                  $whrsec=" and a.sect='".$_SESSION["area"]."'";
                }else{
                  $whrsec=" and a.sect='' ";
                }

                $sq_proses="select distinct a.term,a.periode,a.pr_no,a.pr_date, 
                b.status as status_aprv,
                ( case when d.penawaran='YES' then isnull(c.po_no,'BELUM PO') 
                else 'TANPA PO' end) as po_no,isnull(min(c.tgl_updt),0) as tgl_po,
                (case when sum(qty_dtg)>0 then 'SUDAH DATANG' else 'BELUM DATANG' end ) 
                as status_dtg,e.inv_no, min(inv_tgl) as inv_tgl,min(b.tgl_updt) as tgl_aprv
                from bps_PR a
                full join bps_approve b on a.sect=b.sect and a.pr_no=b.no_doc 
                full join bps_podtl c on a.pr_no=c.pr_no and a.no_ctrl=c.no_ctrl
                full join bps_tmpPR d on a.pr_no=d.pr_no and a.no_ctrl=c.no_ctrl
                left join bps_kedatangan e on c.po_no=e.po_no and a.no_ctrl=c.no_ctrl
                full join bps_vp f on e.inv_no=f.inv_no
                where a.term='$term' $whrsec  and f.inv_no is null
                group by a.term,a.periode,a.pr_no,b.status,d.penawaran,c.po_no,e.inv_no,
                a.pr_date,f.inv_no order by pr_no asc";
                $tb_proses=odbc_exec($koneksi_lp,$sq_proses);                

                $row=0;
                while($baris1=odbc_fetch_array($tb_proses)){ 
                 $row++;
                 $pono=$baris1["po_no"];
                 $tgl_po=date("Y-m-d", strtotime($baris1["tgl_po"])) ;
                ?>  
                <tr  onclick="javascript:pilih(this);">
                  <td><?= $baris1["term"];?> </td>
                  <td><?= $baris1["periode"];?> </td>
                  <td><?= $baris1["pr_no"];?> </td>
                  <td><?= $baris1["pr_date"];?> </td>
                  <td><?= $baris1["status_aprv"];?> </td>
                  <td><?= $pono; ?></td>
                  <td><?= $tgl_po ; ?> </td>
                  <td><?= $baris1["status_dtg"];?> </td>
                  <td><?= $baris1["inv_no"];?> </td>
                  <td><?= $baris1["inv_tgl"];?> </td>
                </tr> 
                <?php 
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

<div class="container-fluid">
    <div class="row clearfix">
      <div class="card">
        <div class="row clearfix">				
          <div class="header">
           
			<?php
								$peri=date("Ym");
								$today=date("Y-m-d");
                  
								  $cr_term=odbc_exec($koneksi_lp,"select top 1 term from bps_setTerm where '$today' between start_term and finish_term ");
								  $term=odbc_result($cr_term, "term");
									 if(isset($_SESSION["area"])){
										  $whrsec="a.periode='$peri' and a.sect like '".substr($_SESSION['area'],0,3)."%'";
										  $deptbud=str_replace("-","",substr($_SESSION['area'],0,3));
									 }else{
											$whrsec="a.periode='$peri'";
											 $deptbud="SAMI-TF";
									 }
									 
									 if(isset($_POST['cari_item'])){	
										$sec=$_POST['sec'];
										$peri=$_POST['periode'];
										
										if($sec=="all"){
											 $whrsec="a.periode='$peri'";
											 $deptbud="SAMI-$lokweb";
										}else{
											 $whrsec="a.periode='$peri' and a.sect like '".substr($sec,0,3)."%'";
											$deptbud=str_replace("-","",substr($sec,0,3));
											
										}
									 }
									 
									

								  $btw_tgl="getdate() and dateadd(month,1,getdate())";
								   
								   
								  /*
								  $sq_dash="select distinct sect from bps_budget a where term=$term and $whrsec group by sect order by a.sect asc";
								  $tb_acc=odbc_exec($koneksi_lp,$sq_dash);
								  
								 $cat_sect="";
								  while($baris1=odbc_fetch_array($tb_acc)){
									  if($cat_sect==""){
										  $cat_sect="'".odbc_result($tb_acc,"sect")."'";
									  }else{
										  $cat_sect=$cat_sect.",'".odbc_result($tb_acc,"sect")."'";
										  
									  }
								  
								  }
								  */
								  
								 
								  
							
							
								
									$sq_dash5="select distinct sect,sum(dbo.lp_konprc(term,'USD',curr,price*qty)) as amtplan from bps_budget a where term=$term and $whrsec group by sect";
								  $tb_acc5=odbc_exec($koneksi_lp,$sq_dash5);
								 
								 
								 $budplan="";
								 $budact="";
								 $budadd="";
								 $var_tamp="";
								  while($baris5=odbc_fetch_array($tb_acc5)){
									$sect2=odbc_result($tb_acc5,"sect");
									$amt2=number_format(odbc_result($tb_acc5,"amtplan"), 0, '.', '');
									
									/*
										if($budplan==""){
										  $budplan="".$amt2."";
									  }else{
										  $budplan=$budplan.",".$amt2."";
										  
									  }
									  */
									  
									 
									  
									  
										 $sq_dash2="select sum(dbo.lp_konprc(a.term,'USD',a.curr,b.price_tot*b.qty_act)) as amt_act from bps_pr a full join bps_tmpPR b on a.PR_NO=b.pr_no and a.no_ctrl=b.no_ctrl where $whrsec and a.sect='$sect2' and price_plan>0";
										  $tb_acc2=odbc_exec($koneksi_lp,$sq_dash2);
										 
										//echo  $sq_dash2;
										  while($baris2=odbc_fetch_array($tb_acc2)){
										  $amt_act=number_format(odbc_result($tb_acc2,"amt_act"), 0, '.', '');
										  
										 
										  /*
										  if($budact==""){
										  $budact="".$amt_act."";
										  }else{
											  $budact=$budact.",".$amt_act."";
											  
										  }
										  */
										  
										  }
										  
										   $sq_dash3="select sum(dbo.lp_konprc(a.term,'USD',a.curr,b.price_tot*b.qty_act)) as amt_add from bps_pr a full join bps_tmpPR b on a.PR_NO=b.pr_no  and a.no_ctrl=b.no_ctrl where $whrsec and a.sect='$sect2' and price_add>0";
										  $tb_acc3=odbc_exec($koneksi_lp,$sq_dash3);
										 
										 // echo $sq_dash2;
										  while($baris3=odbc_fetch_array($tb_acc3)){
										  $amt_add=number_format(odbc_result($tb_acc3,"amt_add"), 0, '.', '');
										   //echo $sect2.";".$amt_add."<br>"; 
										  /*
										  if($budadd==""){
										  $budadd="".$amt_add."";
										  }else{
											  $budadd=$budadd.",".$amt_add."";
											  
										  }
										  */
										  
										  }
										  
										 $var_tamp=$var_tamp."{
													  name: '$sect2',
													  data: [$amt2],
													  stack: 'male'
										},   
										{
													  name: '$sect2 ADD',
													  data: [$amt_add],
													  stack: 'female'
										},   
										{
													  name: '$sect2 NORMAL',
													  data: [$amt_act],
													  stack: 'female'
										},"; 
									  
										
									 
									
								  }
								
								
								
							//echo $budplan.";".$budact.";".$budadd;
							?>
			 <h2>SUMMARY BUDGET EXPENSE<small>Control Budget Periode <?php echo $peri; ?></small></h2>
			
          </div>
					<div class="body">
						<div class="row clearfix">
							<form role="form"  name="form1" id="form1" method="post" action="">
											<div class="col-sm-3">	
												<div class="form-group">
													<label>Section</label>
													<div class="group-line">
														<select class="selectpicker"  style="width: 100%;"  name="sec" id="sec" required>
															<option selected="selected" value="">-Pilih Sect-</option>
															<option value="all">ALL Sect</option>
															<?php 
															$tb_sect=odbc_exec($koneksi_lp,"select distinct sect from bps_pr order by sect asc");
															while($bar_sect=odbc_fetch_array($tb_sect))
															{
																$tsect=odbc_result($tb_sect,"sect");
																echo'<option value="'.$tsect.'">'.$tsect.'</option>';
															}
															?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-sm-3">	
												<div class="form-group">
													<label>Periode</label>
													<div class="group-line">
												<select class="selectpicker"  style="width: 100%;"  name="periode" id="periode" required>
													<option selected="selected" value="">-Pilih Periode-</option>
													<?php
													if($adm1!='admin'){
														$sql_peri="select distinct periode from bps_pr where sect='$sect' order by periode asc";
													}
													else{
														$sql_peri="select distinct periode from bps_pr 
														order by periode asc";
													}

													$tb_peri=odbc_exec($koneksi_lp,$sql_peri);
													while($baris1=odbc_fetch_array($tb_peri))
													{ 
														$peri=odbc_result($tb_peri,"periode");
														echo '<option value="'.$peri.'">'.$peri.'</option>';
													}
													?>
												</select>
												</div>
												</div>
											</div>
											<div class="col-sm-3">	
											
											<button type="submit" id="cari_item" name="cari_item" class="btn bg-blue waves-effect">CARI</button>
											</div>
							</form>
					</div>
					</div>

        </div>	   
        <div class="row clearfix">
          <div class="body">
			<div id='container7'></div>	
			<script type="text/javascript">
			var chart1; // globally available
			$(document).ready(function() {
				  chart1 = new Highcharts.Chart({
					 chart: {
						renderTo: 'container7',
						type: 'column'
					 },   
					 title: {
						text: ''
					 },
					 xAxis: {
						
						categories: ['<?php echo $deptbud;?>']
					 },
					 yAxis: {
						title: {
						   text: 'Budget Amount (USD)'
						},
						stackLabels: {
							enabled: true
						}
					 },
					tooltip: {
							headerFormat: '<b>{series.name}</b><br/>',
							pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
						},
						plotOptions: {
							column: {
								stacking: 'normal',
								dataLabels: {
									enabled: true
								}
							}
						},
						plotOptions: {
							column: {
								stacking: 'normal'
							}
						},
						  series:             
						[
								
						
										<?php
										
											echo $var_tamp;
										?>
									
							
								  
							
							
						]
				  });
			   });
			   
			   
				
			</script>
			
         </div>
       </div>
     </div>
   </div>
 </div>
</section>
<?php ; ?>


<script>
 function pilih(row){
   var kd_pel1=row.cells[1].innerHTML;
   var kd_pel2=row.cells[2].innerHTML;
   document.form1.kd_lp.value=kd_pel1;
   document.form1.sect.value=kd_pel2;
 }
</script>