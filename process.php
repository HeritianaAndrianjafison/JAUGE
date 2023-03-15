<?php

include "config/config.php";

$action = valueof("action");

if(!isset($_SESSION["SESSION_id"]) && ((isset($action) && $action!="login")||!isset($action))){
header("location:login.php");
	}
if($action == "insert_new_user"){
	$pwd = jovcrypt(valueof("pwd"));
	DB::insert("utilisateur",array("login","password","type","nom","prenom"),
		array(valueof("mail"),$pwd,valueof("type"),valueof("nom"),valueof("prenom")));
	//echo valueof("mail")." ".$pwd;
	header("location:users.php");
}  


if($action=="login"){
	$u = DB::select("utilisateur",array("*"),"login='".valueof('login')."'")[0];
	$pwd = valueof('pwd'); // mila averina
	if($pwd==$u['password']){
		$_SESSION["SESSION_id"] = $u['id'];
		$_SESSION["SESSION_type"]=$u['type'];
		$_SESSION["SESSION_login"] = $u['login'];
		$_SESSION["key"] = jovcrypt($u['id'].time());
		//print_r($_SESSION);
		DB::insert("history",array("id_user","key_"),array($_SESSION["SESSION_id"],$_SESSION["key"]));
		header("location:home.php");
	}else{
		header("location:login.php");
	}
}
if($action=="logout"){
	$_SESSION["SESSION_id"] = null;
	$_SESSION["SESSION_type"]== null;
	//DB::update("history",array("logout"),array(date("Y-m-d H:i:s"))," key_='".$_SESSION["key"]."'");
	$sql ="update history set logout= NOW() where key_='".$_SESSION["key"]."'";
	DB::q($sql);
	$_SESSION["key"] = null;
	header("location:login.php");
	
}

if($action=="update_user"){
$pwd=valueof("pwd");
	if($_POST["pwd"]){
		$pwd = jovcrypt(valueof('pwd'));
		
		DB::update("utilisateur",array("login","prenom","nom","password","type"),array(valueof("mail"),valueof("prenom"),valueof("nom"),$pwd,valueof("type")),
			"id='".valueof("id")."'");
		header("location:users.php");
	}else{
		DB::update("utilisateur",array("login","prenom","nom","type"),array(valueof("mail"),valueof("prenom"),valueof("nom"),valueof("type")),
			"id='".valueof("id")."'");
		header("location:users.php");
	}
}

if($action == "insert_new_station"){
	DB::insert("station",array("code","nom","utilisateur_id","statut","id_station_inspection","region"),
		array(valueof("code"),valueof("nom"),valueof("utilisateur"),valueof("statut"),valueof("id_station_inspection"),valueof("region")));
	//echo valueof("mail")." ".$pwd;
	header("location:stations.php");

}

if($action=="update_station"){
	DB::update("station",
		array("nom","utilisateur_id","statut","id_station_inspection","region","vente_sp","vente_go","vente_pl","seuil_min_sp","seuil_min_go","seuil_min_pl","intitule_court"),
		array(valueof("nom"),valueof("utilisateur"),valueof("statut"),valueof("id_station_inspection"),valueof("region"),
			   valueof("vente_sp"),valueof("vente_go"),valueof("vente_pl"),valueof("seuil_min_sp"),valueof("seuil_min_go"),valueof("seuil_min_pl"),valueof("intitule_court")
			),"code='".valueof("code")."'");
	//echo valueof("intitule_court");
	header("location:stations.php?action=update&&id=".valueof("code"));
	
}
if($action == "update_password"){

	$old = jovcrypt($_POST["old_password"]);
	$new = jovcrypt($_POST["new_password"]);
	$u = DB::select("utilisateur",array("*"),"id ='".$_SESSION["SESSION_id"]."'")[0];
	if($old==$u["password"]){

		$np = valueof("new_password");
		$cnp = valueof("confirmation_new_password");
		if($np!=$cnp){
			header("location:setting.php?msg_err=2");
			die();
		}
		DB::update("utilisateur",array("password"),array($new),"id ='".$_SESSION["SESSION_id"]."'");
		//echo $new;
		
		header("location:setting.php?msg_s=1");
	}else{
		header("location:setting.php?msg_err=1");
	}
}

if($action=="insert_site"){

	
	DB::insert("station_site",array("station_code","site_id","collect","description"),

		array(valueof("station_code"),valueof("site_id"),valueof("collect"),valueof("description")));
	header("location:station_site.php?code=".valueof("station_code"));
   //echo getoption($adress_orange);
}
if($action=="delete_site"){
	DB::delete("station_site","id='".valueof('id')."'");
	header("location:station_site.php?code=".valueof("station_code"));
}
if($action=="maintenance_station"){
	
	DB::update("station",array("maintenance","observation_maintenance"),array(2,valueof('maintenance'))," code='".valueof("code")."'");
	header("location:stations.php?action=update&&id=".valueof("code"));
}

if($action=="fin_de_maintenance"){
	
	DB::update("station",array("maintenance"),array(1)," code='".valueof("code")."'");
	header("location:stations.php?action=update&&id=".valueof("code"));
}
?>