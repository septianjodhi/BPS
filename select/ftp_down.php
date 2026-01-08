<?php
// connect and login to FTP server
$lokasi=$_GET["lok"];
$nmfile=$_GET["file"];
include "../koneksi.php";
/*
if($lokasi=="TF"){	   
  $almt="JL. RAYA WALISONGO KM 9.8 TUGUREJO KEC TUGU SEMARANG 50151";   
  $home="PT SEMARANG  AUTOCOMP MANUFACTURING INDONESIA"; 
  $nmpt="SAMI";
   $ftp_ip="10.62.124.18";
  $ftp_f="BPS/Penawaran/";
  $ftp_u="FTP-BPS";
  $ftp_p="S3marang";
}else{


  $almt="Sengonbugel,Mayong,Jepara, Jawa Tengah 59465";   
  $home="PT SEMARANG AUTOCOMP MANUFACTURING INDONESIA-JF"; 
  $nmpt="SAMI-JF";
  $ftp_ip="10.62.191.20";
  $ftp_f="";
  $ftp_u="BPS";
  $ftp_p="bpsjepara";
}
*/

$ftp_conn = ftp_connect($ftp_ip) or die("Could not connect to $ftp_ip");
$login = ftp_login($ftp_conn, $ftp_u, $ftp_p);
$local_file = "../tmp_ftp/".$nmfile;
$server_file = $ftp_f.$nmfile;
ftp_pasv($ftp_conn, true);
// download server file
if (ftp_get($ftp_conn, $local_file, $server_file, FTP_BINARY))
  {
	  echo "<script>window.location = '$local_file';
	fs.unlink('$local_file',(err) => {
    if(err) throw err;
    console.log('$local_file was deleted');
});
	  </script>";
	//  	
/* header("Content-Type: octet/stream");
 header('Content-Disposition: attachment;filename='.$nmfile);
header('Cache-Control: max-age=0');
*/
  echo "Successfully written to $local_file.";
  }
else
  {
  echo "Error downloading $server_file.";
  }

// close connection
ftp_close($ftp_conn);
//unlink($local_file);
?>