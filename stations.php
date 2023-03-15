<?php
include "config/config.php";
need_connexion();
need_admin();
include "include/header.php";
include "include/left.php";
//include "include/login.php";


$action = valueof("action");
if($action == null){
 	
	//$list = DB::select("utilisateur",array("*"));

	$condition = 1;
	$filtre = valueof("filtre");
	if($filtre!=null){
			$gerants = DB::select("utilisateur",array("*")," login like '%".$filtre."%' OR nom like '%".$filtre."%' OR prenom like '%".$filtre."%'");
			$flt ="";
			foreach ($gerants as $g) {
				# code...
				$flt.=" utilisateur_id ='".$g['id']."' OR ";
			}
			$flt.="code like '%$filtre%' OR nom like '%$filtre%'";
	}else {
	    		$flt =null;	
	}
	if($_SESSION["SESSION_type"]==1){
         $condition = "statut=1";
         if($flt!=null){
         	$condition = "statut=1 AND ($flt)";
         }
	}
	else{
		$condition = "(statut=1 && utilisateur_id='".$_SESSION["SESSION_id"]."')";
		if($flt!=null){
         	$condition = "(statut=1 && utilisateur_id='".$_SESSION["SESSION_id"]."') AND ($flt)";
         }
	}
	$region = valueof("region");
	if($region!=null){
		$condition .= " AND region =$region";
	}
	//echo $condition;
	$n = DB::select("station",array("COUNT(*)"),"$condition")[0]["COUNT(*)"];
			//$list = DB::select("offre",array("*"));

			$offset = 0;
			$c = 15;
			$r = $n%$c;
			$q = ($n-$r)/$c;
			if($r!=0){
				$q = $q+1;
			}

			$page=valueof("page");
			if(isset($page)){
				$offset = $page;
			}
			$f = $offset*$c;
			$list = DB::select("station",array("*"),"$condition Order by code DESC LIMIT $c OFFSET $f");


			$nav="<ul class='pagination'><li><a href='stations.php' >Tous</a></li>";
			for($i=0;$i<$q;$i++){
				$p=$i+1;
				$class = "";
				if($i==$page){
				$class ="class='active'";
				}
				
				$nav.="<li $class><a href='stations.php?page=$i&&filtre=".$filtre."&&region=$region' >$p</a></li>";
			}
			$nav.="</ul>";
	$region =  "<option value='".$region."' >".label_region($region)."</option>".liste_region();
	include "include/list_station.php";
}

$region =  liste_region();

$option_inspection_station = getCurl("http://localhost/PORTAIL/inspection.php?action=list_station");
	$option_inspection_station = json_decode($option_inspection_station,1);
	//print_r($option_inspection_station);
	$op_ins_ss ="";
	foreach ($option_inspection_station as $op) {
		# code...
		$op_ins_ss .="<option value='".$op['id']."'>".$op['name']."</option>";
	}
	
if($action == "new"){

	include "config/station.php";
	
	include "include/new_station.php";
}


if($action == "update"){
	$id = valueof("id");
	$utilisateur = DB::select("utilisateur",array("*"));

	$station = DB::select("station",array("*"),"code='$id'")[0];

	$option="";
	include "config/station.php";
	
	include "include/update_station.php"; 
}
include "include/footer.php";
?>