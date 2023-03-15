<?php
include "config/config_update.php";

$sql_telma = "select distinct site_id from station_site where collect =1";


//$sql_orange = "select distinct site_id from station_site where collect =2";



$site_telma = DB::qs($sql_telma);

print_r($site_telma);
$site = "";
//print_r($site_telma);
foreach ($site_telma as $s) {
	# code...
	$site.=$s["site_id"]."/";
}

$lien = $adress_telma."?action=update_tank&&site_list=".$site;

//echo $lien;
$return = jcurl($lien);

print_r($return);

//$site_orange = DB::qs($sql_orange);

DB::delete("tank"," collect =1");
foreach($return as $r){
		DB::insert("tank",array("collect","site_id","capacite","seuil_max","seuil_min","tank_id","label"),
			array(1,$r["Site ID"],$r["Capacity"],$r["Max Product"],$r["Low Product"],$r["Tank ID"],$r["Label"])
	);
}
?>