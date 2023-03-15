<?php
include "config/config_update.php";

$sql_telma = "select distinct tank_id from tank where collect =1";

$tank_telma = DB::qs($sql_telma);


foreach ($tank_telma as $s) {
	# code...
	$lien = $adress_telma."?action=update_inventory&&tank_id=".$s["tank_id"];
	$return = jcurl($lien);
	print_r($return);
	echo "------ TELMA -------";
	DB::delete("inventory"," tank_id=".$s['tank_id']." and collect=1");
	DB::insert("inventory",array("collect","tank_id","volume","date","densite ","water_volume","water_height","temperature"),
		array(1,$return["Tank ID"],$return["Volume"],$return["Date & time"],$return["Density"],$return["Water Volume"],$return["Water Height"],$return["Temperature"]));

}



?>