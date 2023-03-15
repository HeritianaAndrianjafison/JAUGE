<?php
set_time_limit(0);
global $dbname;
global $servername;
global $username;
global $password;
global $connection;
global $key;
global $adress_orange;
global $adress_telma;

ini_set('session.cookie_lifetime', 1800*4);
ini_set('session.gc-maxlifetime', 1800*4);
session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time();





$dbname = "JAUGE";
$servername = "localhost";
$username = "root";
$password = "";
$key ="lnvvlkqhgoiruhtàhjksbdkmqbv;s<,vbkm";
//http://192.168.130.196:8080/jaugeinform/jaugeapi/
$adress_orange = "http://192.168.130.196:8080/jaugeinform/jaugeapi/";
$adress_orange = "http://192.168.130.195:8080/jauges_inform/jaugeapi/";
$adress_telma = "http://192.168.130.194:8080/jauges_inform/JAUGEAPI/";
// Create connection
$connection = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
//echo "Connected successfully";
$connection->set_charset("utf8");

define('IMG_DIR', 'public/img/');

include "class/db.php";
include "include/function.php";

//need_connexion();
$current_page = basename($_SERVER['SCRIPT_FILENAME']);
if($current_page!="login.php" and $current_page!="process.php" and $current_page!="update_inventory_orange.php" and $current_page!="update_inventory_telma.php" and $current_page!="update_tanks_orange.php" and $current_page!="update_tanks_orange.php"){

	need_connexion();
	//$current_user = getCurrentUser();

}
if($current_page!="login.php"){
$sql ="update history set activity= NOW() where key_='".$_SESSION["key"]."'";
DB::q($sql);	
}


/*$serverx3='192.168.130.170\SAGE';
$databasex3="basex3";
$userx3="JOVPROD";
$passwordx3="tiger";

global $connectionodbcx3;
$connectionodbcx3 = odbc_connect("Driver={SQL Server};Server=$serverx3;Database=$databasex3;", $userx3, $passwordx3);*/

//print_r($_POST);

//$sql = "SELECT SDHNUM_0,LICPLATE_0, STOFCY_0 FROM JOVPROD.SDELIVERY WHERE DLVDAT_0='$deb' AND ($filtrenums) ORDER BY LICPLATE_0";

//$result = odbc_exec($connectionodbc,$sql);



?>
