<?php

$utilisateur = DB::select("utilisateur",array("*"));
	$option="";
	foreach($utilisateur as $u){
		extract($u);
		$option.="<option value='$id'>$prenom $nom</option>";
	}
	
$sqlx3 = "SELECT BPCNUM_0, BPCNAM_0 FROM BPCUSTOMER WHERE BPCNUM_0 like '1%'";
$resultx3 = odbc_exec($connectionodbcx3,$sqlx3);
$optionx3 ="";
while( $rowx3 = odbc_fetch_array($resultx3) ) {

	$optionx3.="<option value='".$rowx3["BPCNUM_0"]."'>".$rowx3["BPCNUM_0"]." ".$rowx3["BPCNAM_0"]."</option>";
}

$lien = "http://192.168.130.197:8080/jauges_inform_v6/JAUGEAPI/?action=action_station";
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $lien);
		curl_setopt($curl, CURLOPT_COOKIESESSION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$site_option = curl_exec($curl);
		
		//print_r($return);
		curl_close($curl);
		$option_x3="";

?>