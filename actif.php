<?php
include "config/config.php";
need_connexion();
need_admin();

include "include/header.php";
include "include/left.php";
$list_station_connecter = valueof("list_station_connecter");
$list_station_connecter = explode("/", $list_station_connecter);
//print_r($list_station_connecter);
$condition ="0";
foreach ($list_station_connecter as $key) {
	# code...
	$condition .= " OR code='$key'";
}

$list = DB::select("station",array("*")," statut = 1 AND $condition Order by nom");
//print_r($list);
include "include/actif.php";
include "include/footer.php";
?>