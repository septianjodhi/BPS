<script type="text/javascript">
  function open_child(url,title,w,h){
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
      status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
      width='+w+',height='+h+',top='+top+',left='+left);

  };	
</script>

<div class="container-fluid">
    <div class="row clearfix">
      <div class="card">
          <div class="header">
           
			<?php
								$peri=date("Ym");
								$today=date("Y-m-d");
                  /*
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
								   */
								   
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
								  
								 
								  
							
							
								
									$sq_dash5="  select distinct sect,sum(nariyuki) as nariyukisum,sum(cost_push) as sumcost_push,sum(cost_reduction) as sumreduction,sum(cost_other) as sumother from bps_budget_stp group by sect";
									//$sq_dash5="select distinct sect,phase,count(nariyuki),cost_push,cost_reduction,cost_other from bps_budget_stp group by sect,phase,nariyuki,cost_push,cost_reduction,cost_other";
								  $tb_acc5=odbc_exec($koneksi_lp,$sq_dash5);
								 
								 
								// $budplan="";
								// $budact="";
								// $budadd="";
								 $var_tamp="";
								  while($baris5=odbc_fetch_array($tb_acc5)){
									$sect2=odbc_result($tb_acc5,"sect");
								//	$phase=odbc_result($tb_acc5,"phase");
								//	$amt2=number_format(odbc_result($tb_acc5,"amtplan"), 0, '.', '');
									$nariyuki=odbc_result($tb_acc5,"nariyukisum");
									$cost_push=odbc_result($tb_acc5,"sumcost_push");
									$cost_reduction=odbc_result($tb_acc5,"sumreduction");
									$cost_other=odbc_result($tb_acc5,"sumother");
								

										  $var_tamp=$var_tamp."{
													  name: '$sect2 nariyuki' ,
													  data: [$nariyuki],
													  stack: 'male'
										},   
										{
													  name: '$sect2 cost_push' ,
													  data: [$cost_push],
													  stack: 'female'
										},
										{
													  name: '$sect2 cost_reduction' ,
													  data: [$cost_reduction],
													  stack: 'normal'
										},
										{
													  name: '$sect2 cost_other' ,
													  data: [$cost_other],
													  stack: 'add'
										},										
										"; 
									  
										
									 
									
								  }
								
								
								
							//echo $budplan.";".$budact.";".$budadd;
							?>
			 <h2>SUMMARY BUDGET EXPENSE STP<small>Control Budget Periode <?php echo $peri; ?></small></h2>
			
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
		  <section class="wide">
			<div id='chart'></div>	
			<script type="text/javascript">
			var chart1; // globally available
			$(document).ready(function() {
				  chart1 = new Highcharts.Chart({
					 chart: {
						renderTo: 'chart',
						type: 'column'
					 },   
					 title: {
						text: 'TAKI Graph Expense Term 84'
					 },
					 xAxis: {
						
						categories: ['<?php echo $sect2;?>']
					 },
					 yAxis: {
						title: {
						   text: ''
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
		 </section>
         </div>
		
       </div> <!-- end row grafik -->
	   
  
   </div>
	


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
 
 </div> <!-- end container-fluid -->