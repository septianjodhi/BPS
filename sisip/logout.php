<?php
// *** Logout the current user.
session_start();
include ("../koneksi.php");
$us=$_SESSION['user'];
$updt_log="update tbl_user set last_login=now() where app_nm='BPS' and user='$us' ";
$query_updt=mysql_query($updt_log);

session_destroy();

 echo "<script>window.location = '../index.php'</script>";

?>