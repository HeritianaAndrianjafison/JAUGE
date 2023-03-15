<?php
include "config/config.php";
need_connexion();
include "PHP/Classes/PHPExcel/IOFactory.php";
$css = array("etat");
$js = array("etat");
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
         $condition = "id_station_inspection IS NOT NULL AND statut=1";
         if($flt!=null){
         	$condition = "id_station_inspection IS NOT NULL AND statut=1 AND ($flt)";
         }
	}
	else{
		$condition = "id_station_inspection IS NOT NULL AND (statut=1 && utilisateur_id='".$_SESSION["SESSION_id"]."')";
		if($flt!=null){
         	$condition = "id_station_inspection IS NOT  NULL AND (statut=1 && utilisateur_id='".$_SESSION["SESSION_id"]."') AND ($flt)";
         }
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


			$nav="<ul class='pagination'><li><a href='ca.php' >Tous</a></li>";
			for($i=0;$i<$q;$i++){
				$p=$i+1;
				$class = "";
				if($i==$page){
				$class ="class='active'";
				}
				if($filtre==null){
					$nav.="<li $class><a href='ca.php?page=$i' >$p</a></li>";
				}else{
					$nav.="<li $class><a href='ca.php?page=$i&&filtre=".$filtre."' >$p</a></li>";
				}
				
			}
			$nav.="</ul>";
	include "include/list_ca.php";
}

if($action == "detail"){
	include "include/list_detail_ca.php";
		
			
}
include "include/footer.php";
?>