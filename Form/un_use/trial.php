<?php 
error_reporting(0);
session_start();

include "../../koneksi.php";
$lht_dt=odbc_fetch_row(odbc_exec($koneksi_lp,"SELECT * FROM bps_budget_invest where no_ctrl='80-LD-11-0070' "));
echo $lht_dt;
?>