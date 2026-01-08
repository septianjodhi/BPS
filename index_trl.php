<!DOCTYPE html>
<html>
<?php
// header('Location: http://10.62.126.12/bps'); 
session_start();
//error_reporting(0);
$lokweb="";
$website="";
$kontrak_supp="OFF";

//if(isset($_SESSION['nama'])){}else{}
if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Jakarta');
if(isset($_SESSION['website'])){
    $website=$_SESSION['website'];
    $lokweb=$_SESSION['lok'];
    $user=$_SESSION['nama'];
}else{
    $website="";$lokweb="";
    $user="";
}
if($website != "BPS"){
    if(isset($_GET['page'])) {
     $hal=$_GET['page'];
     if($hal!='login.php'){
         echo "<script>window.location = 'index.php?page=login.php'</script>";
    //header('location:../index.php');
     }
 }else{$hal="";
}
}else{
    if(isset($_GET['page'])) {
        $akses=$_SESSION["akses"];
        $adm=strpos($akses,'_FA');
        $kd_akses=explode(",",$akses);
        
        if(in_array('ADM_FA',$kd_akses)){
            $adm1="admin";
        }else{
            $adm1="user";
        }

        $sect= $_SESSION["area"]; 
        // $akses=$_SESSION["akses"];
        $aprv_dok=strpos($akses,'APR_PR');
        $kd_akses=explode(",",$akses);
        
        if(in_array('APR_PR',$kd_akses)){
            // $count_apr="Select count (*) as jml from bps_approve where sect='$sect' and jns_doc in ('PR','PO','Kontrak') and tgl_updt is null and no_aprv in (2,3)";
            // $eks_countapr=odbc_exec($koneksi_lp,$count_apr);
            // $jml_dt=odbc_result($eks_countapr,'jml');
            $aprv_dok="admin";
            // echo $jml_dt;
        }
        $hal=$_GET['page'];
    }else{
        $hal="";
    }
    }

  //   $admin_FA=strpos($akses,'_FA');
  //   $kd_akses=explode(",",$akses);
  //   if(in_array('ADM_FA',$kd_akses)){
  //     $admin1="admin";
  // }else{
  //     $admin1="user";
  // }
    include "koneksi.php";


    set_time_limit(0);
//echo $_SESSION['website'];
    ?>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>BPS<?php echo "-".$lokweb; ?></title>
       <?php
       $lokassets="Assets/";
       include $lokassets.'plug_head.php';

       ?>
        <!-- <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
        <script type="text/javascript" src="plugins/datetimepicker/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="plugins/datetimepicker/js/moment-with-locales.min.js"></script>
        <script src="plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
        <script src="plugins/jquery-validation/jquery.validate.js"></script>
        <script src="plugins/jquery-steps/jquery.steps.js"></script>
        <script src="plugins/jquery-steps/form-steps.js"></script>
        <script src="plugins/ckeditor/ckeditor.js"></script>
        <script src="plugins/tinymce/tinymce.js"></script>
        <script type="text/javascript" src="plugins/daterangepicker/daterangepicker.min.js"></script>
        <script src="js/highcharts.js" type="text/javascript"></script>  -->
    </head>
    <body class="theme-purple" OnLoad="getLocation()">

    <!-- Page Loader
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Silahkan Tunggu...</p>
        </div>
    </div> -->
    <div class="overlay">
        
    </div>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.php">BPS<?php echo "(".$lokweb.")"; ?></a>
            </div>
            <div class="navbar-header navbar-center">
                <h4>Budget & Purchasing System</h4>
                <p id="latitude"></p>
                <p id="longitude"></p>
            </div>
            <?php include "menu_atas.php"; ?>
        </div>
    </nav>
    <section>
        <aside id="leftsidebar" class="sidebar">
            <div class="user-info" style='background: url("images/user-img-background.jpg") no-repeat no-repeat;'>
                <div class="image">
                    <img src="images/user.png" width="48" height="48" alt="User" />
                </div>
            </div>
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li>
                        <a href="index.php"><i class="material-icons">home</i><span>Home</span></a>
                    </li>

                    <?php
                    $k_menu="";
                    $alamat="";$almtpg="";
                    if(isset($_GET['page'])) {$alamat = $_GET['page'];$almtpg="?page=".$alamat;}
                    if(isset($_GET['indx'])) {$alamat = $_GET['indx'];$almtpg="?indx=".$alamat;}

                    if($website=="BPS"){
$Mnu=strtoupper($_SESSION['akses']);
                        $Mnu='ALL';
                        if($Mnu=='ALL'){
                         $Mnu1=" ";
                         $Sql_menu="select * from tbl_menu where app_nm='$website' order by grop,no_urut asc";
                     }else{
                        $Mnu1=str_replace(",","','",$Mnu);
                        $Sql_menu="select * from tbl_menu where app_nm='$website' and (exists (select code_menu from grp_akses where code_menu=tbl_menu.code_menu and ID_AKSES in('$Mnu1'))) order by grop,no_urut asc";
                    }

    //echo $Sql_menu."<>".$Mnu;
                    $Ex_Mnu=mysql_query($Sql_menu); 
//odbc_exec($koneksi,$Sql_menu);
                    while($cr_menu=mysql_fetch_array($Ex_Mnu)){ 
    //while(odbc_fetch_array($Ex_Mnu)){
        $lnk=strtolower($cr_menu["ling"]);//odbc_result($Ex_Mnu,"ling"));
        $lnk_add=strtolower($cr_menu["ling_get"]);
        $lnk_get=str_replace("@","&",$lnk_add);
        $jdl=$cr_menu["nama"];//odbc_result($Ex_Mnu,"nama");
        $CD_jdl=$cr_menu["code_menu"];//odbc_result($Ex_Mnu,"code_menu");
        $urut=$cr_menu["no_urut"];
        //echo "<script>alert('HAL= ?page=$hal ,LINK = $lnk , kdmenu = $CD_jdl');</script>";
        if($lnk=="?page=".$hal and $hal!=''){$k_menu=$CD_jdl;// echo "<script>alert('kd menu = $k_menu');</script>"; 
  }
  $dticon=$cr_menu["icon"];
  if($dticon==""){$Ticon="";}else{$Ticon='<i class="material-icons">'.$dticon.'</i>';}
switch ($lnk) {
    case 'main':
        if(substr($urut,0,1)==substr($alamat,0,1)){$cls_actv='class="active"';}else{$cls_actv="";}
        ?>
        <li <?=$cls_actv;?> >
        <a href="javascript:void(0);" class="menu-toggle">
            <?=$Ticon; ?><span><?=$jdl;?></span>
        </a>
        <ul class="ml-menu">  
        <?php
        break;
    case 'sub':
        if(substr($urut,0,2)==substr($alamat,0,2) || (substr($urut,0,3)==substr($alamat,0,3))){$cls_actv='class="active"';}else{$cls_actv="";}
        ?>
        <li <?=$cls_actv;?> >
        <a href="javascript:void(0);" class="menu-toggle">
            <?=$Ticon; ?><span><?=$jdl;?></span>
        </a>
        <ul class="ml-menu">  
        <?php
        break;
    case 'end':
        ?>
        </ul>
        </li>
        <?php
        break;
    
    default:
        if($lnk==$almtpg || $alamat==$urut){$cls_actv='class="active"';}else{$cls_actv="";}
        ?>
        <li <?=$cls_actv;?>>
        <a href="index.php?page=<?= $urut.$lnk_get;//echo $lnk; ?>"><?= $Ticon; ?><span><?php echo $jdl; ?></span></a>
        </li>
        <?php
        break;
}

if($alamat==$urut){
    if(isset($_GET['page'])) {$alamat = str_replace("?page=","",$lnk);}
    if(isset($_GET['indx'])) {$alamat = str_replace("?indx=","",$lnk);}

}
//echo $alamat." = ".$urut."<br>";
}}
//if($urut>'41000'){echo "<script>alert('$lnk'+'-'+'$alamat');</script>";}  
//echo $Sql_menu;
?>                  


</ul>
</div>
<div class="legal">
    <div class="copyright">
        &copy; 2018 <a href="javascript:void(0);">Semarang Autocomp Manufacturing Indonesia</a>.
    <br><?=$alamat;?>
    </div>
    <div class="version">
        <b>Version: </b> 3.0.1
    </div>
</div>
<!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->
<!-- Right Sidebar -->
<aside id="rightsidebar" class="right-sidebar">
   <?php //include "rightsilidebar.php"; ?>
</aside>
<!-- #END# Right Sidebar -->
</section>
<!--=====halaman    -->
<?php 

if($alamat!='') {
                //$alamat=str_replace("@","&",$alamat);
                //echo "<script>alert('$alamat');</script>";
 include_once ($alamat);
            } else {//echo "<script>window.location ='index.php?indx=index1.php'</script>";
            include('form/dashboard.php');
                //include('index_dash.php');
        }
       // include $lokassets.'plug_foot.php';
        ?> 

        <script src="js/admin.js"></script>

        <script type="text/javascript">
          $(document).ready(function()
          {

$('.datetime-min').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:mm', minDate : new Date() });
$('.date-min').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', minDate : new Date(),time: false });
$('.datetime').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', Date : Date(),time: false });
$('.datetime-rg').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:mm:ss', Date : Date(),time: false });
$.material.init()
$('.selectpicker').selectpicker();
$(".tabel2").DataTable();
$('.periode').bootstrapMaterialDatePicker({format: 'YYYYMM', minDate : new Date(),clearButton: true,weekStart: 1,time: false });    
$('.date-pick').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD',time: false });
$('.setperiode').bootstrapMaterialDatePicker({format: 'YYYYMM', Date : new Date(),clearButton: true,weekStart: 0,time: false});
});

          function open_child(url,title,w,h){
            var left = (screen.width/2)-(w/2);
            var top = (screen.height/2)-(h/2);
            w = window.open(url, title, 'toolbar=no, location=no, directories=no, \n\
                status=no, menubar=no, scrollbar=no, resizabel=no, copyhistory=no,\n\
                width='+w+',height='+h+',top='+top+',left='+left);

        };

    </script>
    <script src="plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="plugins/js/pages/forms/form-wizard.js"></script>
 
</body>


</html>