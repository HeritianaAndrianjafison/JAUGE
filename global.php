<?php
include "config/config.php";
need_connexion();
need_admin();
$js = array("tableau_de_bord");
include "include/header.php";
include "include/left.php";

$condition = 1;
$region = valueof("region");
if($region!=null){
	$condition .= " AND region =$region";
}
$filtre = valueof("filtre");
if($filtre!=null){
		$condition .=" AND (nom like '%$filtre%' OR code like '%$filtre%')";
}

$condition .="  AND statut='1'";



$list = DB::select("station",array("*")," $condition AND maintenance='1' Order by nom");
//print_r($list);

$region =  "<option value='".$region."' >".label_region($region)."</option>".liste_region();


include "include/global.php";
include "include/footer.php";
?>