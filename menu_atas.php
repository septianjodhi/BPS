<?php 
function time_ago($timestamp){  
  $time_ago = strtotime($timestamp);  
  $current_time = time();  
  $time_difference = $current_time - $time_ago;  
  $seconds = $time_difference;  
      $minutes      = round($seconds / 60 );        // value 60 is seconds  
      $hours        = round($seconds / 3600);       //value 3600 is 60 minutes * 60 sec  
      $days         = round($seconds / 86400);      //86400 = 24 * 60 * 60;  
      $weeks        = round($seconds / 604800);     // 7*24*60*60;  
      $months       = round($seconds / 2629440);    //((365+365+365+365+366)/5/12)*24*60*60  
      $years        = round($seconds / 31553280);   //(365+365+365+365+366)/5 * 24 * 60 * 60  
      if($seconds <= 60) {  
       return "Just Now";  
     } else if($minutes <=60) {  
       if($minutes==1){  
         return "one minute ago";  
       }else {  
         return "$minutes minutes ago";  
       }  
     } else if($hours <=24) {  
       if($hours==1) {  
         return "an hour ago";  
       } else {  
         return "$hours hrs ago";  
       }  
     }else if($days <= 7) {  
       if($days==1) {  
         return "yesterday";  
       }else {  
         return "$days days ago";  
       }  
      }else if($weeks <= 4.3) {  //4.3 == 52/12
       if($weeks==1){  
         return "a week ago";  
       }else {  
         return "$weeks weeks ago";  
       }  
     } else if($months <=12){  
       if($months==1){  
         return "a month ago";  
       }else{  
         return "$months months ago";  
       }  
     }else {  
       if($years==1){
         return "one year ago";  
       }else {
         return "$years years ago";  
       }
     }
   }

   $tahun_ini=date("Y");
   $tahun_depan=date("Y")+1;
   $end_termini=date("Y-m-d",strtotime($tahun_ini."-06-30"));
   $end_termdpn=date("Y-m-d",strtotime($tahun_depan."-06-30"));

   $query="SELECT TOP 1 * FROM bps_setTerm where finish_term=(case when '$end_termini'<=getdate() then '$end_termdpn' else '$end_termini' end ) ORDER BY term desc";
   $cari_term=odbc_exec($koneksi_lp, $query );
   $term=odbc_result($cari_term,'term');
  // echo $query;
   ?>

   <ul class="nav navbar-nav navbar-right">


    <!-- lonceng -->
  <!-- <?php 
  $adm1=0;
  if($adm1=="admin"){ ?>
  <li class="dropdown">
    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
      <i class="material-icons">notifications</i>
      <span class="label-count">7</span>
    </a>
    <ul class="dropdown-menu">
      <li class="header">NOTIFICATIONS</li>
      <li class="body">
        <ul class="menu">
          <li>
            <a href="javascript:void(0);">
              <div class="icon-circle bg-light-green">
                <i class="material-icons">person_add</i>
              </div>
              <div class="menu-info">
                <h4>12 new members joined</h4>
                <p>
                  <i class="material-icons">access_time</i> 14 mins ago
                </p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <div class="icon-circle bg-cyan">
                <i class="material-icons">add_shopping_cart</i>
              </div>
              <div class="menu-info">
                <h4>4 sales made</h4>
                <p>
                  <i class="material-icons">access_time</i> 22 mins ago
                </p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <div class="icon-circle bg-red">
                <i class="material-icons">delete_forever</i>
              </div>
              <div class="menu-info">
                <h4><b>Nancy Doe</b> deleted account</h4>
                <p>
                  <i class="material-icons">access_time</i> 3 hours ago
                </p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <div class="icon-circle bg-orange">
                <i class="material-icons">mode_edit</i>
              </div>
              <div class="menu-info">
                <h4><b>Nancy</b> changed name</h4>
                <p>
                  <i class="material-icons">access_time</i> 2 hours ago
                </p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <div class="icon-circle bg-blue-grey">
                <i class="material-icons">comment</i>
              </div>
              <div class="menu-info">
                <h4><b>John</b> commented your post</h4>
                <p>
                  <i class="material-icons">access_time</i> 4 hours ago
                </p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <div class="icon-circle bg-light-green">
                <i class="material-icons">cached</i>
              </div>
              <div class="menu-info">
                <h4><b>John</b> updated status</h4>
                <p>
                  <i class="material-icons">access_time</i> 3 hours ago
                </p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <div class="icon-circle bg-purple">
                <i class="material-icons">settings</i>
              </div>
              <div class="menu-info">
                <h4>Settings updated</h4>
                <p>
                  <i class="material-icons">access_time</i> Yesterday
                </p>
              </div>
            </a>
          </li>
        </ul>
      </li>
      <li class="footer">
        <a href="javascript:void(0);">View All Notifications</a>
      </li>
    </ul>
  </li>
  <?php } ?> -->
  
  <li class="dropdown">
    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
      <i class="material-icons">notifications</i>
      <span class="label-count">
        <?php 
        $jml_dt=0;
        // $lok="";
        $akses="";
        $kd_akses="";
        if(isset($_SESSION['website'])){
          $sect= $_SESSION["area"]; 
          // $lok= $_SESSION['lok'];
          $akses=$_SESSION["akses"];
          // $aprv_dok=strpos($akses,'APR_PR');
          $kd_akses=explode(",",$akses);
          // if(in_array('APR_PR',$kd_akses)){
          $count_apr="Select count (sect) as jml from bps_approve where sect='$sect' and jns_doc in ('Kontrak') and tgl_updt is null and no_aprv in (2,3) ";
        /*  $eks_countapr=odbc_exec($koneksi_lp,$count_apr);
            // echo $count_apr;
          while($data=odbc_fetch_array($eks_countapr)){
            $jml_dt=$data['jml'];
          }
        */    // echo $jml_dt;
          // }
          // echo $jml_dt;

          $last_date=odbc_exec($koneksi_lp,"select top 1 tgl_prepaire from bps_approve where jns_doc in ('Kontrak') and sect='$sect' AND tgl_updt is null and no_aprv in (2,3) order by tgl_prepaire desc");
          $last=odbc_result($last_date,"tgl_prepaire");
        }
        ?>
        <!-- 7 -->
      </span>
    </a>
    <ul class="dropdown-menu">
      <li class="header">NOTIFICATION</li>
      <li class="body">
        <ul class="menu">
          <li>
            <a href="index.php?page=60001&prv=section">
              <div class="icon-circle bg-light-green">
                <i class="material-icons">assignment</i>
              </div>
              <div class="menu-info">
                <h4><?=  $jml_dt; ?> kontrak baru</h4>
                <p>
                  <i class="material-icons">access_time</i> 
                  <?php 
                  if(isset($_SESSION['website'])){
                    echo time_ago($last);
                  }
                  ?>
                  <!-- 14 mins ago -->
                </p>
              </div>
            </a>
          </li>

          <?php
          if(isset($_SESSION['website'])){
			$jml_pr=0;
            $sect=$_SESSION["area"];
            $pic=$_SESSION["nama"];
            $pch_sect=explode("-",$sect);
            $dept=$pch_sect[0];
            $sec=$pch_sect[1];
            $data_pr="SELECT distinct a.periode,b.sect,a.pr_no,a.pr_date,lp,b.remark from bps_tmpPR a left join bps_pr b on a.pr_no=b.pr_no left join bps_approve c on b.sect=c.sect and b.PR_NO=c.no_doc
            where penawaran='YES' and not exists (select * from bps_podtl where term=a.term and periode=a.periode and pr_no=a.pr_no ) and a.term='$term' and lp='$sec' and c.status='FINISH' order by a.periode,a.pr_date ASC";

            $base_encode=base64_encode($data_pr);
          /*  $tbl_pr=odbc_exec($koneksi_lp,$data_pr);
           $jml_pr=odbc_num_rows($tbl_pr);
            */     //$pr_date=odbc_result('pr_date');
            ?>
            <li>
              <a href="index.php?page=42001&q=<?= $base_encode ; ?>">
                <div class="icon-circle bg-light-green">
                  <i class="material-icons">shopping_cart</i>
                </div>
                <div class="menu-info">

                  <h4><?= $jml_pr; ?> PR Outstanding</h4>
                <!-- <p>
                  <i class="material-icons">access_time</i>  -->
                  <?php 
                  // echo $query;
                  //if(isset($_SESSION['website'])){
                    //echo time_ago($pr_date);
                  //}
                  ?>
                  <!-- 14 mins ago -->
                  <!-- </p> -->
                </div>
              </a>
            </li>
            <?php
			$jml_po=0;
            $qrypo="select distinct p.po_no,p.kode_supp,a.status,p.status_po from bps_podtl p inner join bps_approve a on p.po_no=a.no_doc where p.lp='$sec' and p.term='$term' and not exists(select distinct po_no from bps_kedatangan where  term=p.term and  periode=p.periode and po_no=p.po_no)";
          /*  $tbl_po=odbc_exec($koneksi_lp,$qrypo);
            $jml_po=odbc_num_rows($tbl_po);
          */  $hrefpo="?indx=Form/rpt_pooutstanding.php&trm=".$term;
            ?>
            <li>
              <a href="<?=$hrefpo; ?>">
                <div class="icon-circle bg-light-green">
                  <i class="material-icons">cached</i>
                </div>
                <div class="menu-info">
                  <h4><?= $jml_po; ?> PO Outstanding</h4>                
                </div>
              </a>
            </li>
            <?php
          } 
          ?>

          <!-- <li>
            <a href="javascript:void(0);">
              <div class="icon-circle bg-cyan">
                <i class="material-icons">add_shopping_cart</i>
              </div>
              <div class="menu-info">
                <h4>4 sales made</h4>
                <p>
                  <i class="material-icons">access_time</i> 22 mins ago
                </p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <div class="icon-circle bg-red">
                <i class="material-icons">delete_forever</i>
              </div>
              <div class="menu-info">
                <h4><b>Nancy Doe</b> deleted account</h4>
                <p>
                  <i class="material-icons">access_time</i> 3 hours ago
                </p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <div class="icon-circle bg-orange">
                <i class="material-icons">mode_edit</i>
              </div>
              <div class="menu-info">
                <h4><b>Nancy</b> changed name</h4>
                <p>
                  <i class="material-icons">access_time</i> 2 hours ago
                </p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <div class="icon-circle bg-blue-grey">
                <i class="material-icons">comment</i>
              </div>
              <div class="menu-info">
                <h4><b>John</b> commented your post</h4>
                <p>
                  <i class="material-icons">access_time</i> 4 hours ago
                </p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <div class="icon-circle bg-light-green">
                <i class="material-icons">cached</i>
              </div>
              <div class="menu-info">
                <h4><b>John</b> updated status</h4>
                <p>
                  <i class="material-icons">access_time</i> 3 hours ago
                </p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0);">
              <div class="icon-circle bg-purple">
                <i class="material-icons">settings</i>
              </div>
              <div class="menu-info">
                <h4>Settings updated</h4>
                <p>
                  <i class="material-icons">access_time</i> Yesterday
                </p>
              </div>
            </a>
          </li> -->

        </ul>
      </li>
      <!-- <li class="footer">
        <a href="javascript:void(0);">View All Notifications</a>
      </li> -->
    </ul>
  </li>

  <li class="dropdown">
    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
      <i class="material-icons">cloud_upload</i>
    </a>
    <ul class="dropdown-menu">
      <li class="header">TEMPLATE</li>
      <li class="body">
       <ul class="menu">
         <li>
          <a href="template/BUDGET.xls">
            <div class="icon-circle bg-light-green"> <i class="material-icons">shopping_cart</i></div>
            <div class="menu-info"><h4>Budget</h4><p>Template Upload Budget</p></div>
          </a>
        </li>
        <li>
          <a href="template/BUDGET_ver2.xls">
            <div class="icon-circle bg-light-green"> <i class="material-icons">shopping_cart</i></div>
            <div class="menu-info"><h4>Budget Format 2</h4><p>Template Upload Budget</p></div>
          </a>
        </li>
        <li>
          <a href="template/ACCOUNT.xls">
            <div class="icon-circle bg-light-green"> <i class="material-icons">account_balance_wallet</i></div>
            <div class="menu-info"><h4>Account</h4><p>Template Account</p></div>
          </a>
        </li>
        <li>
          <a href="template/SUB-ACCOUNT.xls">
            <div class="icon-circle bg-light-green"> <i class="material-icons">account_balance_wallet</i></div>
            <div class="menu-info"><h4>Sub Account</h4><p>Template Sub Account</p></div>
          </a>
        </li>
        <li>
          <a href="template/CARLINE.xls">
            <div class="icon-circle bg-light-green"> <i class="material-icons">directions_car</i></div>
            <div class="menu-info"><h4>Carline</h4><p>Template Carline</p></div>
          </a>
        </li>
        <li>
          <a href="template/AREA.xls">
            <div class="icon-circle bg-light-green"> <i class="material-icons">location_on</i></div>
            <div class="menu-info"><h4>Cost Center</h4><p>Template Cost Center, Area  atau Conveyor</p></div>
          </a>
        </li>
        <li>
          <a href="template/MS_PART_rev2.xls">
            <div class="icon-circle bg-light-green"> <i class="material-icons">local_parking</i></div>
            <div class="menu-info"><h4>Part</h4><p>Template Master Part</p></div>
          </a>
        </li>
		<li>
          <a href="template/LEADTIME.xls">
            <div class="icon-circle bg-light-green"> <i class="material-icons">local_parking</i></div>
            <div class="menu-info"><h4>Lead Time</h4><p>Template Kode Lead Time</p></div>
          </a>
        </li>
        <li>
          <a href="template/HANDOVER.xls">
            <div class="icon-circle bg-light-green"> <i class="material-icons">location_on</i></div>
            <div class="menu-info"><h4>Handover</h4><p>Template Upload Serah terima LP ke User</p></div>
          </a>
        </li>
        <li>
          <a href="template/MS_PART_SUPP.xls">
            <div class="icon-circle bg-light-green"> <i class="material-icons">location_on</i></div>
            <div class="menu-info"><h4>Part Supplier</h4><p>Template Upload Master part Supplier</p></div>
          </a>
        </li>
        <li>
          <a href="template/SUPPLIER.xls">
            <div class="icon-circle bg-light-green"> <i class="material-icons">location_on</i></div>
            <div class="menu-info"><h4>Supplier</h4><p>Template Upload Supplier</p></div>
          </a>
        </li>
        <li>
          <a href="template/SUPPLIER_CAPACITY.xls">
            <div class="icon-circle bg-light-green"> <i class="material-icons">location_on</i></div>
            <div class="menu-info"><h4>Supplier Capacity</h4><p>Template Upload Supplier Capacity</p></div>
          </a>
        </li>
        <li>
          <a href="template/QUOTATION.xls">
            <div class="icon-circle bg-light-green"> <i class="material-icons">location_on</i></div>
            <div class="menu-info"><h4>Quotation</h4><p>Template Upload Penawaran Harga</p></div>
          </a>
        </li>
        <li>
          <a href="template/BUDGET INVEST.xls">
            <div class="icon-circle bg-light-green"> <i class="material-icons">shopping_cart</i></div>
            <div class="menu-info"><h4>Budget Invest</h4><p>Template Upload Budget Invest</p></div>
          </a>
        </li>
        <li>
          <a href="template/KODE FAKTUR.xls">
            <div class="icon-circle bg-light-green">
              <i class="material-icons">shopping_cart</i>
            </div>
            <div class="menu-info"><h4>Kode Faktur</h4>
              <p>Template Upload Kode Faktur</p></div>
            </a>
          </li>

          <li>
            <a href="template/FORM USER.xls">
              <div class="icon-circle bg-light-green"> <i class="material-icons">location_on</i></div>
              <div class="menu-info"><h4>Form User</h4><p>Template Upload New User</p></div>
            </a>
          </li>

        </ul>
      </li>
      <li class="footer">
        <a href="javascript:void(0);">TEMPLATE</a>
      </li>
    </ul>
  </li>

  <li class="dropdown">
    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
      <!--i class="material-icons">print</i--><b>FORM</b>
    </a>
    <ul class="dropdown-menu">
      <li class="header">FORM</li>
      <li class="body">
        <ul class="menu">
         <li>
          <a href="http://10.62.124.6/itsms/index.php?indx=form/form_soft.php">
            <!-- <div class="icon-circle bg-light-green">
              <i class="material-icons">scanner</i>SI
            </div> -->
            <div class="menu-info">
              <h4>PENGADAAN SOFTWARE (SI)</h4>
              <p>Form Permintaan Penambahan Tools Aplikasi</p>
            </div>
          </a>
        </li>


      </ul>
    </li>
    <li class="footer">
      <a href="javascript:void(0);">FORM</a>
    </li>
  </ul>
</li>
<li class="dropdown">
  <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
    <!--i class="material-icons">print</i--><b>TUTOR</b>
  </a>
  <ul class="dropdown-menu">
    <li class="header">TUTORIAL</li>
    <li class="body">
                                <!--ul class="menu">
                                     <li>
                                        <a href="Tutor/TUTOR_SCAN_L6900.pdf">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">scanner</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>Scanner</h4>
                                                <p>Tutorial Cara Penggunaan Scanner Dokumen</p>
                                            </div>
                                        </a>
                                    </li>
                                    
                                   
                                  </ul-->
                                </li>
                                <li class="footer">
                                  <a href="javascript:void(0);">TUTORIAL</a>
                                </li>
                              </ul>
                            </li>

                            <li class="dropdown">
                              <?php if($website == "BPS"){
                                $nmsesi=$_SESSION["nama"];}
                                else{$nmsesi="";}

                                if($nmsesi==""){
                                 echo '<a href="index.php?indx=login.php"><i class="material-icons">assignment_ind</i></a>';
                               }else{

                                echo '<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><b>'.$nmsesi.'</b></a>';	
                                echo '<ul class="dropdown-menu"><li class="body">';
                                echo '
                                <li><a href="?page=form/edit_user.php">
                                <i class="material-icons">person</i>Profile</a></li>
                                <li role="seperator" class="divider"></li>
                                <li><a href="javascript:void(0);">
                                <i class="material-icons">group</i>Followers</a></li>
                                <li><a href="javascript:void(0);">
                                <i class="material-icons">shopping_cart</i>Sales</a></li>
                                <li><a href="javascript:void(0);">
                                <i class="material-icons">playlist_add_check</i>Approved</a></li>
                                <li role="seperator" class="divider"></li>
                                <li><a href="sisip/logout.php">
                                <i class="material-icons">input</i>Sign Out</a></li>';
                                echo ' </li></ul>';
                              }
                              ?>
                            </li>
                            <!-- #END# Tasks -->
                            <li class="pull-right">
                              <a href="javascript:void(0);" class="js-right-sidebar" data-close="true">
                                <i class="material-icons">more_vert</i>
                              </a>
                            </li>
                          </ul>

                          <?php /*
                          <div class="modal fade" id="mddelpo" tabindex="1" role="dialog">
                           <div class="modal-dialog" role="document">
                            <div class="modal-content">
                             <div class="modal-header"><h4 class="modal-title" id="defaultModalLabel">Record Purchase Order (PO) Outstanding </h4></div>
                             <form action="" id="frmdel" name="frmdel" method="post"  enctype="multipart/form-data">
                              <div class="modal-body">
                               APAKAH ANDA YAKIN INGIN MENGHAPUS PR INI ? <input type="text" readonly class="form-control" data-role="tagsinput" id="podel" name="podel" placeholder="PR NO" required>
                               <div class="modal-footer">
                                <button type="submit" id="delpo" name="delpo" class="btn btn-link waves-effect">HAPUS</button>
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                              </div>
                            </form></div></div>
                          </div></div>

                          <script>
                            function poout(){
                             $('#mddelpo').modal('show');
                           };
                         </script>
                         */ ?>