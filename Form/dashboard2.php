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
	<!--Chart -->
	<div class="container-fluid">
    <div class="row clearfix">
      <div class="card">
        <div class="row clearfix">				
          <div class="header">
            <h2>DASHBOARD<small>Control Budget</small></h2>
          </div>

        </div>	   
        <div class="row clearfix">
          <div class="body">
             <canvas id="bar_chart" height="150"></canvas>
                        
         </div>
       </div>
     </div>
   </div>
 </div>
	<!--End Chart-->
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