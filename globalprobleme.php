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



$list = DB::select("station",array("*")," $condition AND maintenance='2' Order by nom");
//print_r($list);

$region =  "<option value='".$region."' >".label_region($region)."</option>
			<option value='1' >ANTANANARIVO</option>
			<option value='2' >ANTSIRABE</option>
			<option value='3' >DIEGO</option>
			<option value='4' >SAMBAVA</option>
			<option value='5' >FIANARANTSOA</option>
			<option value='6' >MANAKARA</option>
			<option value='7' >MAJUNGA</option>
			<option value='8' >TAMATAVE</option>
			<option value='9' >AMBATONDRAZAKA</option>
			<option value='10' >TULEAR</option>
			<option value='11' >FORT DAUPHIN</option>
			<option value='12' >MORONDAVA</option>
			";


include "include/global.php";
include "include/footer.php";
?>