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


$list = DB::select("station",array("*")," $condition Order by nom");

$region =  "<option value='".$region."' >".label_region($region)."</option>".liste_region();

//print_r($list);
include "include/globalcompte.php";
include "include/footer.php";
?>