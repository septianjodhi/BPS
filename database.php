<?php
/*defined('BASEPATH') OR exit('No direct script access allowed');
*/
function koneksi($kon){
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '10.62.124.15',
	 //'hostname' => '10.62.124.4',
	'username' => 'itsami',
	'password' => 'Spx123go?&',
	'database' => 'dbpinjam',
	/*'dbdriver' => 'mysqli',*/
	'dbdriver' => 'mysql',
	'dbprefix' => '',
	'pconnect' => FALSE,
/*	'db_debug' => (ENVIRONMENT !== 'production'),*/
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

//$query_builder = TRUE;
$db['hrd'] = array(
	'dsn'	=> 'hrd',
	'hostname' 	=> '10.62.125.13',
	'port' 		=> '1433',
	'username' 	=> 'sa',
	'password' 	=> 'Myidea5',
	'database' 	=> 'hrd',
	'dbdriver' 	=> 'sqlsrv',
	'dbprefix' 	=> '',
	'pconnect' 	=> FALSE,
	/*'db_debug' 	=> (ENVIRONMENT !== 'production'),*/
	'cache_on' 	=> FALSE,
	'cachedir' 	=> '',
	'char_set' 	=> 'utf8',
	'dbcollat' 	=> 'utf8_general_ci',
	'swap_pre' 	=> '',
	'encrypt' 	=> FALSE,
	'compress' 	=> FALSE,
	'stricton' 	=> FALSE,
	'failover' 	=> array(),
	'save_queries' => TRUE
);

//$active_group = 'lp';
$query_builder = TRUE;
$db['lp'] = array(
	'dsn'	=> 'lp',
	'hostname' 	=> '10.62.125.13',
	'port' 		=> '1433',
	'username' 	=> 'sa',
	'password' 	=> 'Myidea5',
	'database' 	=> 'lp',
	'dbdriver' 	=> 'sqlsrv',
	'dbprefix' 	=> '',
	'pconnect' 	=> FALSE,
	/*'db_debug' 	=> (ENVIRONMENT !== 'production'),*/
	'cache_on' 	=> FALSE,
	'cachedir' 	=> '',
	'char_set' 	=> 'utf8',
	'dbcollat' 	=> 'utf8_general_ci',
	'swap_pre' 	=> '',
	'encrypt' 	=> FALSE,
	'compress' 	=> FALSE,
	'stricton' 	=> FALSE,
	'failover' 	=> array(),
	'save_queries' => TRUE
);

//$active_group = 'sis';
$query_builder = TRUE;
$db['sis'] = array(
	'dsn'	=> 'sis',
	'hostname' 	=> '10.62.125.3',
	'port' 		=> '1433',
	'username' 	=> 'sa',
	'password' 	=> 'Myidea5',
	'database' 	=> 'wss',
	'dbdriver' 	=> 'sqlsrv',
	'dbprefix' 	=> '',
	'pconnect' 	=> FALSE,
	/*'db_debug' 	=> (ENVIRONMENT !== 'production'),*/
	'cache_on' 	=> FALSE,
	'cachedir' 	=> '',
	'char_set' 	=> 'utf8',
	'dbcollat' 	=> 'utf8_general_ci',
	'swap_pre' 	=> '',
	'encrypt' 	=> FALSE,
	'compress' 	=> FALSE,
	'stricton' 	=> FALSE,
	'failover' 	=> array(),
	'save_queries' => TRUE
);

//$active_group = 'bs';
$query_builder = TRUE;
$db['bs'] = array(
	'dsn'	=> 'bs',
	'hostname' 	=> '10.62.125.1',
	'port' 		=> '1433',
	'username' 	=> 'sa',
	'password' 	=> 'Myidea5',
	'database' 	=> 'bs',
	'dbdriver' 	=> 'sqlsrv',
	'dbprefix' 	=> '',
	'pconnect' 	=> FALSE,
	/*'db_debug' 	=> (ENVIRONMENT !== 'production'),*/
	'cache_on' 	=> FALSE,
	'cachedir' 	=> '',
	'char_set' 	=> 'utf8',
	'dbcollat' 	=> 'utf8_general_ci',
	'swap_pre' 	=> '',
	'encrypt' 	=> FALSE,
	'compress' 	=> FALSE,
	'stricton' 	=> FALSE,
	'failover' 	=> array(),
	'save_queries' => TRUE
);

// DATABASE SAMI-JF
//$query_builder = TRUE;
$db['hrd_jf'] = array(
	'dsn'	=> 'hrd',
	'hostname' 	=> '10.62.191.13',
	'port' 		=> '1433',
	'username' 	=> 'sa',
	'password' 	=> 'Jepara21',
	'database' 	=> 'hrd',
	'dbdriver' 	=> 'sqlsrv',
	'dbprefix' 	=> '',
	'pconnect' 	=> FALSE,
	/*'db_debug' 	=> (ENVIRONMENT !== 'production'),*/
	'cache_on' 	=> FALSE,
	'cachedir' 	=> '',
	'char_set' 	=> 'utf8',
	'dbcollat' 	=> 'utf8_general_ci',
	'swap_pre' 	=> '',
	'encrypt' 	=> FALSE,
	'compress' 	=> FALSE,
	'stricton' 	=> FALSE,
	'failover' 	=> array(),
	'save_queries' => TRUE
);
$tnsname='(DESCRIPTION = 
    (ADDRESS_LIST = 
        (ADDRESS = 
          (COMMUNITY = tcp.world)
          (PROTOCOL = TCP)
          (Host = 10.62.124.1)
          (Port = 1521)
        )
    )
    (CONNECT_DATA = (SID = sami)
    )
  )';
$query_builder = TRUE;
$db['oft'] = array(
	//'dsn'	=> 'sami',
	'hostname' 	=> $tnsname,
	//'port' 		=> '1521',
	'username' 	=> 'FGINVSAMI',
	'password' 	=> 'FGINVSAMI',
	'database' 	=> '',
	'dbdriver' 	=> 'oci8',
	'dbprefix' 	=> '',
	'pconnect' 	=> FALSE,
	//'db_debug' 	=> (ENVIRONMENT !== 'production'),
	'cache_on' 	=> FALSE,
	'cachedir' 	=> '',
	'char_set' 	=> 'utf8',
	'dbcollat' 	=> 'utf8_general_ci',
	'swap_pre' 	=> '',
	'encrypt' 	=> FALSE,
	'compress' 	=> FALSE,
	'stricton' 	=> FALSE,
	'failover' 	=> array(),
	'save_queries' => TRUE
);



//echo $db['sis']['hostname'];

	//$kon='sis';
	$host= $db[$kon]['hostname'];
	$driver=$db[$kon]['dbdriver'];
	$dbase=$db[$kon]['database'];
	$usr=$db[$kon]['username'];
	$kunci=$db[$kon]['password'];
try
		{	if($driver=="mysql" || $driver=="mysqli"){
				$has = new PDO($driver.":host=".$host.";dbname=".$dbase, $usr, $kunci);
			}else{
				$has= new PDO($driver.":Server=".$host."; Database=".$dbase,$usr, $kunci);
			}
				$has->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
				echo $e->getMessage();
		}
		return $has;
}

?>
<!-- CONTOH PEMAKAIAN
 <tbody>
                                
                                    <?php
                                        $mykon= koneksi('default');
                                       $sql = $mykon->prepare("select distinct grop_area,area FROM it_area");
                                       $sql->execute(); 
                                       while ($data = $sql->fetch()) { 
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td><?= $data['grop_area']; ?></td>
                                            <td><?= $data['area']; ?></td>
                                        </tr>
                                            
                                    <?php  
                                     }


                                     $mykon=null;
                                    ?>
                                    
                                
                            </tbody>



 -->