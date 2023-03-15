<?php
include "config/config.php";
need_connexion();
need_admin();
$js = array("tableau_de_bord");
include "include/header.php";
include "include/left.php";

$liste_station_en_rupture_de_stock = valueof("liste_station_en_rupture_de_stock");
$liste_station_en_rupture_de_stock = explode("/", $liste_station_en_rupture_de_stock);

$condition ="0";
foreach ($liste_station_en_rupture_de_stock as $key) {
	# code...
	$condition .= " OR code='$key'";
}

$list = DB::select("station",array("*")," statut = 1 AND $condition Order by nom");
//$list = DB::select("station",array("*")," statut = 1 AND code='1101046' Order by nom");
//print_r($list);
include "include/rupture.php";
include "include/footer.php";
?>