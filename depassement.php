<?php
include "config/config.php";
need_connexion();
need_admin();

include "include/header.php";
include "include/left.php";
$liste_station_en_depassement =valueof("liste_station_en_depassement");
$liste_station_en_depassement = explode("/",$liste_station_en_depassement);
$condition ="0 ";
foreach ($liste_station_en_depassement as $key) {
	# code...
	$condition .= " OR code='$key'";
}
$list = DB::select("station",array("*")," statut = 1 AND $condition Order by nom");
include "include/depassement.php";
include "include/footer.php";


?>