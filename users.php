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
		$condition = " login like '%".$filtre."%' OR nom like '%".$filtre."%' OR prenom like '%".$filtre."%'";
	}

	$n = DB::select("utilisateur",array("COUNT(*)"),"$condition")[0]["COUNT(*)"];
			//$list = DB::select("offre",array("*"));

			$offset = 0;
			$c = 10;
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
			$list = DB::select("utilisateur",array("*"),"$condition Order by id DESC LIMIT $c OFFSET $f");


			$nav="<ul class='pagination'><li><a href='etats.php' >Tous</a></li>";
			for($i=0;$i<$q;$i++){
				$p=$i+1;
				$class = "";
				if($i==$page){
				$class ="class='active'";
				}
				if($filtre==null){
					$nav.="<li $class><a href='users.php?page=$i' >$p</a></li>";
				}else{
					$nav.="<li $class><a href='users.php?page=$i&&filtre=".$filtre."' >$p</a></li>";
				}
				
			}
			$nav.="</ul>";
	include "include/list_user.php";
}
if($action == "new"){

	/*$utilisateur_type=getUser_type();
	$option="";
	foreach($utilisateur_type as $type){
		extract($type);
		$option.="<option value='$id'>$label</option>";
	}
	$region = getRegion();
	$region_option = "";
	foreach($region as $r){
		extract($r);
		$region_option .= "<option value='$id'>$code</option>";
	}*/

	$option ="<option value='1'>Admin</option><option value='2'>Gérant</option><option value='3'>Consultation</option>";
	include "include/new_user.php";
}
if($action == "update"){
	$id = valueof("id");
	$list = DB::select("utilisateur",array("*")," id = '$id'");
	//print_r($list);
	extract($list[0]);
	$option ="<option value='1'>Admin</option><option value='2'>Gérant</option><option value='3'>Consultation</option>";
	include "include/update_user.php";
}
include "include/footer.php";
?>