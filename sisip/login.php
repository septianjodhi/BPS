<?php
session_start();
include ("../koneksi.php");


$user_agent     =   $_SERVER['HTTP_USER_AGENT'];

function get_client_ip_env() {
 $ipaddress = '';
 if (getenv('HTTP_CLIENT_IP'))
  $ipaddress = getenv('HTTP_CLIENT_IP');
 else if(getenv('HTTP_X_FORWARDED_FOR'))
  $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
 else if(getenv('HTTP_X_FORWARDED'))
  $ipaddress = getenv('HTTP_X_FORWARDED');
 else if(getenv('HTTP_FORWARDED_FOR'))
  $ipaddress = getenv('HTTP_FORWARDED_FOR');
 else if(getenv('HTTP_FORWARDED'))
  $ipaddress = getenv('HTTP_FORWARDED');
 else if(getenv('REMOTE_ADDR'))
  $ipaddress = getenv('REMOTE_ADDR');
 else
  $ipaddress = 'UNKNOWN IP Address';

 return $ipaddress;
}

function get_os(){ 
    global $user_agent;
    $os_platform    =   "Unknown OS Platform";
    $daftar_os      =   array(
       '/windows nt 6.2/i'     =>  'Windows 8',
       '/windows nt 6.1/i'     =>  'Windows 7',
       '/windows nt 6.0/i'     =>  'Windows Vista',
       '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
       '/windows nt 5.1/i'     =>  'Windows XP',
       '/windows xp/i'         =>  'Windows XP',
       '/windows nt 5.0/i'     =>  'Windows 2000',
       '/windows me/i'         =>  'Windows ME',
       '/win98/i'              =>  'Windows 98',
       '/win95/i'              =>  'Windows 95',
       '/win16/i'              =>  'Windows 3.11',
       '/macintosh|mac os x/i' =>  'Mac OS X',
       '/mac_powerpc/i'        =>  'Mac OS 9',
       '/linux/i'              =>  'Linux',
       '/ubuntu/i'             =>  'Ubuntu',
       '/iphone/i'             =>  'iPhone',
       '/ipod/i'               =>  'iPod',
       '/ipad/i'               =>  'iPad',
       '/android/i'            =>  'Android',
       '/blackberry/i'         =>  'BlackBerry',
       '/webos/i'              =>  'Mobile'
                        );

    foreach ($daftar_os as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }
    }   
    return $os_platform;
}

function getting_browser(){
    global $user_agent;
 $browser        =   "Unknown Browser";
    $daftar_browser  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );

    foreach ($daftar_browser as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }
    }
    return $browser;
}
$user_os        =   get_os();
$user_browser   =   getting_browser();
$ip_user  = get_client_ip_env();


function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'IP tidak dikenali';
    return $ipaddress;
}

$alamat_ip = $_SERVER['REMOTE_ADDR'];
$lok=$_POST['lok'];	
if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Jakarta');
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

$username = $_POST['username'];
$password = $_POST['password'];

$sql2 = "select * from tbl_user where User='".$username."' and Pass='".$password."'  and lokasi='".$lok."' and app_nm='BPS'";
$query=mysql_query($sql2);

if($query){	$row=0;
	
	//session_register("nama");
	//session_register("status");
	while($baris=mysql_fetch_array($query)){
		$nik		=$baris['nik'];
		$nama		=$baris['nama'];
		$status		=$baris['status'];
		$akses		=$baris['akses'];
		$area		=$baris['area'];
		$users		=$baris['user'];
		$website	="BPS";
		$lokasi		=$lok;
		$row++;
	}
	if($row > 0){
		$_SESSION['isLoggedIn']=1;
		$_SESSION['nik']=$nik;
		$_SESSION['nama']=$nama;
		$_SESSION['akses']=$akses;
		$_SESSION['area']=$area;
		$_SESSION['user']=$users;
		$_SESSION['status']=$status;
		$_SESSION['website']=$website;		
		$_SESSION['lok']=$lokasi;	
		$_SESSION['lokasi']=$lokasi;
		$tgal=date("Y-m-d H:i:s",strtotime("now"));
		
		//	$sql_us = "insert into Log_USER_ACT(NAMA,LOGIN,STATUS) values ('$users','$tgal','$status')";
		//	$query_us=mysql_query($sql_us);
		$updt_log="update tbl_user set last_login=now(),ip='$alamat_ip' 
		where app_nm='BPS' and user='$username' ";
		$query_updt=mysql_query($updt_log);

		$log="insert into bps_log (ip,browser,os,id_user,tgl_updt) 
		values ('$alamat_ip','$user_browser','$user_os','$users',getdate() )";
		// echo $log;
		$insert_log=odbc_exec($koneksi_lp,$log);

		echo "<script>window.location = '../index.php'</script>";
	}
	else{	
		echo "<script>alert('Username & Password tidak cocok'); window.location = '../index.php?inxd=login.php'</script>";
	}
}	
else{
	echo "<script>alert('Username sedang digunakan, login dengan username lain!!!'); window.location = '../index.php?indx=login.php'</script>";
}
?>
