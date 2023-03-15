<?php
include "config/config.php";


$history = DB::select("history",array("*")," logout IS NULL");

foreach ($history as $key) {
	# code...
	extract($key);
	$now = strtotime("now");

	$activity = strtotime($activity);
	if($activity !=null&&($now-$activity)>1800){
		echo date("Y-m-d H:i:s",($activity+1800))."<br>";
	}
	
}
?>