<!DOCTYPE html>
<html>
<?php
session_start();
//error_reporting(0);
if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Jakarta');
include "koneksi.php";
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>BPS</title>
    <link rel="stylesheet" href="plugins/font/Roboto/roboto.css">
  <link rel="stylesheet" href="plugins/ionicons/material-icon.css">	
    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />
	
	<link rel="stylesheet" href="plugins/datetimepicker/css/bootstrap-material-datetimepicker.css" />
	<!-- Bootstrap Select Css -->
    <link href="plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />	<!-- JQuery DataTable Css -->
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
	
	<!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
	
	
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
	<!-- Ckeditor -->
    <script src="plugins/ckeditor/ckeditor.js"></script>
</head>

<body class="theme-deep-purple">
  <?php 
  $alamat="";
			if(isset($_GET['plh'])) {$alamat = $_GET['plh'];}		
			if($alamat!='') {
					include_once ($alamat);
			} else {//echo "<script>window.location ='index.php?indx=index1.php'</script>";
			//	include('index1.php');
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
*/
			$('.datetime-min').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:mm', minDate : new Date() });
			
			$.material.init()
			$('.selectpicker').selectpicker();
			$(".tabel2").DataTable();
		});
		</script>
</body>

</html>