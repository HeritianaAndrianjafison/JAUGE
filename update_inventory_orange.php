<?php
include "config/config_update.php";

$sql_orange = "select distinct tank_id from tank where collect =2";

$tank_orange = DB::qs($sql_orange);

print_r($tank_orange);
foreach ($tank_orange as $s) {
	# code...
	$lien = $adress_orange."?action=update_inventory&&tank_id=".$s["tank_id"];
	$return = jcurl($lien);
	print_r($return);
	echo "------ ORANGE -------";
	DB::delete("inventory"," tank_id=".$s['tank_id']." and collect=2");
	DB::insert("inventory",array("collect","tank_id","volume","date","densite ","water_volume","water_height","temperature"),
		array(2,$return["Tank ID"],$return["Volume"],$return["Date & time"],$return["Density"],$return["Water Volume"],$return["Water Height"],$return["Temperature"]));

}



?>