<?php
include "config/config.php";

$js=array("site");
//echo $adress_orange." -----------------------";
$orange_site = getoption($adress_orange."?action=action_station");
$telma_site = getoption($adress_telma."?action=action_station");


$telma_site_array=getoptionarray($adress_telma."?action=action_station_array");

$orange_site_array=getoptionarray($adress_orange."?action=action_station_array");

$telma_site_array = json_decode($telma_site_array,"true");
$orange_site_array = json_decode($orange_site_array,"true");
$station = DB::select("station",array("*"),"code='".valueof('code')."'")[0];
$liste_site = DB::select("station_site",array("*"),"station_code='".valueof('code')."'");
include "include/header.php";
include "include/station_site.php";
include "include/footer.php";

?>