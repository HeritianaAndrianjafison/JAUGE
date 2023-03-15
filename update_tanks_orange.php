<?php
include "config/config_update.php";

$sql_orange = "select distinct site_id from station_site where collect =2";


//$sql_orange = "select distinct site_id from station_site where collect =2";



$site_orange = DB::qs($sql_orange);

$site = "";
//print_r($site_telma);
foreach ($site_orange as $s) {
	# code...
	$site.=$s["site_id"]."/";
}
$lien = $adress_orange."?action=update_tank&&site_list=".$site;
$return = jcurl($lien);

print_r($return);

//$site_orange = DB::qs($sql_orange);

DB::delete("tank"," collect = 2");
foreach($return as $r){
		DB::insert("tank",array("collect","site_id","capacite","seuil_max","seuil_min","tank_id","label"),
			array(2,$r["Site ID"],$r["Capacity"],$r["Max Product"],$r["Low Product"],$r["Tank ID"],$r["Label"])
	);
}
?>