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


$res = getCurl("localhost/PORTAIL/ca.php?action=list_ca&station_id=$station_id&offset=$f&limit=$c&date_debut=$date_debut&date_fin=$date_fin");
$res = json_decode($res,1);

$dataArray = array();
$c_activity = "";
foreach ($res as $r) {
	# code...
	$dataArray[] = array($r["created"],$r["updated"],$r["station_name"]);
	$ca = json_decode($r["data_json"], true);
	$ca = json_decode($ca,1);
	$key = array_keys($ca);
		$c_activity = "";
	  									foreach ($key as $k) {
	  										# code...
	  										//$rubrique = DB::select("field",array("*")," id=".$k)[0];
	  										//echo $rubrique["activity_id"]."<br>";
	  										$rubrique = getCurl("localhost/PORTAIL/ca.php?action=line_rubrique&id=$k");
	  										$rubrique =json_decode($rubrique ,1);

	  										$activity = getCurl("localhost/PORTAIL/ca.php?action=line_activity&id=".$rubrique["activity_id"]);
	  										$activity =json_decode($activity ,1);
	  										if($c_activity != $activity["name"]){
	  											//echo "<em><strong>".$activity["name"]."</strong></em><br>";
	  													$c_activity = $activity["name"];
	  													$dataArray[] = array($activity["name"]);
	  										}
	  												$dataArray[] = array($rubrique["name"],$ca[$k]);
	  												//echo $rubrique["name"]." :".$ca[$k]."<br>";
	  									}


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