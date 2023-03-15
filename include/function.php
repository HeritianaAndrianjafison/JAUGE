<?php
function need_connexion(){
if(!isset($_SESSION["SESSION_id"])){
header("location:login.php");
	}
}
function valueof($val){

	if(isset($_POST[$val])){
	return $_POST[$val];
	}
	if(isset($_GET[$val])){
	return $_GET[$val];
	}
}
function upload_image($photo,$path){

$r=move_uploaded_file($_FILES[$photo]['tmp_name'],$path);
}
function jovcrypt($string){
	global $key;
	return md5($key.$string);
}
function getUser($id){
	$res =DB::select("utilisateur",array("*"),"id ='$id'");
	return $res[0];
}
function getoption($adress=false){
	//$lien = "http://192.168.130.197:8080/jauges_inform_v6/JAUGEAPI/?action=action_station";
		$lien = "http://192.168.130.197:8080/jauges_inform_v6/JAUGEAPI/?action=action_station";
		if($adress){
			$lien = $adress;
		}
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $lien);
		curl_setopt($curl, CURLOPT_COOKIESESSION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$site_option = curl_exec($curl);
		//print_r($return);
		curl_close($curl);
		return $site_option;
}
function getCurl($adress){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $adress);
		curl_setopt($curl, CURLOPT_COOKIESESSION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$content = curl_exec($curl);
		//print_r($return);
		curl_close($curl);
		return $content;
}

function getoptionarray($adress=false){
	//$lien = "http://192.168.130.197:8080/jauges_inform_v6/JAUGEAPI/?action=action_station";
		$lien = "http://192.168.130.197:8080/jauges_inform_v6/JAUGEAPI/?action=action_station";
		if($adress){
			$lien = $adress;
		}
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $lien);
		curl_setopt($curl, CURLOPT_COOKIESESSION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$site_option = curl_exec($curl);
		//print_r($return);
		curl_close($curl);
		return $site_option;
}
//action_station_array

function getsitelabeloperateur($id,$t){
		foreach($t as $v){
			if($v["Site ID"]==$id){return $v;}
		}
}
function jcurl($lien){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $lien);
		curl_setopt($curl, CURLOPT_COOKIESESSION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$return = curl_exec($curl);
		$return = json_decode($return,true);
		//print_r($return);
		curl_close($curl);
		return $return;
}
function need_admin(){
	if($_SESSION["SESSION_type"]!=1){
		echo "Connexion non autorisé";
		die();
	}
}
function label_region($id){
	if($id==1){
		return "ANTANANARIVO";
	}
	if($id==2){
		return "ANTSIRABE";
	}
	if($id==3){
		return "DIEGO";
	}
	if($id==4){
		return "SAMBAVA";
	}
	if($id==5){
		return "FIANARANTSOA";
	}
	if($id==6){
		return "MANAKARA";
	}
	if($id==7){
		return "MAJUNGA";
	}
	if($id==8){
		return "TAMATAVE";
	}
	if($id==9){
		return "AMBATONDRAZAKA";
	}
	if($id==10){
		return "TULEAR";
	}
	if($id==11){
		return "FORT DAUPHIN";
	}
	if($id==12){
		return "MORONDAVA";
	}
	if($id==13){
		return "Nosy Be";
	}
	return "--";
}

function liste_region(){
	return "<option value=9>AMBATONDRAZAKA</option>
			<option value=1>ANTANANARIVO</option>
			<option value=2>ANTSIRABE</option>
			<option value=3>DIEGO</option>
			<option value=4>SAMBAVA</option>
			<option value=5>FIANARANTSOA</option>
			<option value=11>FORT DAUPHIN</option>
			<option value=6>MANAKARA</option>
			<option value=7>MAJUNGA</option>
			<option value=12>MORONDAVA</option>
			<option value=13>Nosy Be</option>
			<option value=8>TAMATAVE</option>
			<option value=10>TULEAR</option>
			";
}
?>