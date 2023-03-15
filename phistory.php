<?php 

set_time_limit(0);
include "config/config.php";
include "PHP/Classes/PHPExcel/IOFactory.php";


$simple = array(
  'borders' => array(
  	'outline' => array(
  		'style' => PHPExcel_Style_Border::BORDER_THIN,
  		'color' => array('argb' => '00000000'),
  	),
  ),
  'font'  => array(
  	'bold'  => false,
  	'name'  => 'Tahoma',
  	'size'  => 10,
  	'color' => array('rgb' => '000000'),
  ),
  'fill' => array(
  	'type' => PHPExcel_Style_Fill::FILL_SOLID, 
  	'color' => array('rgb' => 'FFFFFF')
  ),
  'alignment' => array( 
  	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
  	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
  	'wrap' => true // retour à la ligne automatique
  )
);


$f = valueof("offset");
$c = valueof("limit");
$date_debut = valueof("date_debut");
$date_fin = valueof("date_fin");
$filtre="";
if($date_debut!=null){
	$filtre.="&date_debut=$date_debut";
}
if($date_fin!=null){
	$filtre.="&date_fin=$date_fin";
}

$station_id = valueof("id_station_inspection");



$dataArray = array();

$sql ="SELECT history.login, history.activity,history.logout, utilisateur.nom, utilisateur.prenom,station.nom AS station_nom FROM history INNER JOIN utilisateur ON history.id_user = utilisateur.id INNER JOIN station ON utilisateur.id = station.utilisateur_id "


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