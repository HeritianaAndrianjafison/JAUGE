<?php

include "config/config.php";
include "PHP/Classes/PHPExcel/IOFactory.php";
need_connexion();
$css = array("etat");
$js = array("etat");

//include "include/login.php";


$action = valueof("action");

 	
	//$list = DB::select("utilisateur",array("*"));

	$condition = "1";
	$filtre = valueof("filtre");
	if($filtre!=null){
		$condition=" station.nom like '%$filtre%' OR station.code like '%$filtre%' ";
		
	}
$date_deb = valueof("date_deb");
if($date_deb!=null){
	$date_deb=DateTime::createFromFormat('d/m/Y', $date_deb);
	$date_deb = $date_deb->format('Y-m-d');
	$condition.=" AND date>='$date_deb 00:00:00'";
}
$date_fin = valueof("date_fin");
if($date_fin!=null){
	$date_fin=DateTime::createFromFormat('d/m/Y', $date_fin);
	$date_fin=$date_fin->format('Y-m-d');
	$condition.=" AND date<='$date_fin 23:59:59'";
}

$c = valueof("c");
$f = valueof("f");
$limit = "";
if($c!=null &&  $f !=null){
	$limit = " LIMIT $c OFFSET $f";
}

	$sql = "SELECT data.*,station.nom from data INNER JOIN station on data.code = station.code WHERE $condition ORDER BY data.id DESC $limit";
//echo $sql;
	$list=DB::qs($sql);
			//$list = DB::select("data",array("*"),"$condition Order by id DESC LIMIT $c OFFSET $f");
$dataArray = array();

$dataArray[] = array("Date",
					"Utilisateur",
					"Code station",
					"Nom station",
					"Vente GO",
					"Stock GO",
					"Seuil GO",
					"Livraison GO",
					"Commande GO",
					"Autonomie GO",
					"Vente SP",
					"Stock SP",
					"Seuil SP",
					"Livraison SP",
					"Commande SP",
					"Autonomie SP",
					"Vente PL",
					"Stock PL",
					"Seuil PL",
					"Livraison PL",
					"Commande PL",
					"Autonomie PL",
					"Encours",
					"Ecart",
					"Commentaire");
foreach($list as $l){
				    		//print_r($l);
				    		extract($l);
				    		$user = getUser($utilisateur_id);
							if($vente_go!=0){
								$ago = round( (($livraison_go+$stock_go)/$vente_go),2);
							}else{
								$ago = "NA";
								
							}
							if($vente_sp!=0){
								$asp = round( (($livraison_sp+$stock_sp)/$vente_sp),2);
								
								
							}else{
								$asp = "NA";
								
							}
							if($vente_pl!=0){
								$apl = round( (($livraison_pl+$stock_pl)/$vente_pl),2);
								
							}else{
								$apl = "NA";
							}

$dataArray[] = array(
					date("d-m-Y", strtotime($date)),
					$user["prenom"]." ".$user["nom"],
					$code,
					$nom,
					$vente_go,
					$stock_go,
					$livraison_go,
					$seuil_go,
					$commande_go,
					$ago,
					$vente_sp,
					$stock_sp,
					$livraison_sp,
					$seuil_sp,
					$commande_sp,
					$asp,
					$vente_pl,
					$stock_pl,
					$livraison_pl,
					$seuil_pl,
					$commande_pl,
					$apl,
					$encours,
					$ecart,
					$commentaire
					);

				    	}

$doc = new PHPExcel();

// set active sheet 
$doc->setActiveSheetIndex(0);
$doc->getActiveSheet()->fromArray($dataArray);


//save our workbook as this file name
$filename = 'modele_exportation.xls';
//mime type

header('Content-Type: application/vnd.ms-excel');
//tell browser what's the file name
header('Content-Disposition: attachment;filename="' . $filename . '"');

header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');

//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output');





?>