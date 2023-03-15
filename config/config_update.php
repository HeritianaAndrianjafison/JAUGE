<?php

global $dbname;
global $servername;
global $username;
global $password;
global $connection;
global $key;
global $adress_orange;
global $adress_telma;
session_start();
set_time_limit(0);

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



?>
