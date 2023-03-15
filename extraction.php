<?php



include "config/config.php";
need_connexion();
$css = array("etat");
$js = array("etat");
$action = valueof("action");
if($action==null){
include "include/header.php";
include "include/left.php";
include "include/extraction.php";

}else{
include "PHP/Classes/PHPExcel/IOFactory.php";

$stations = DB::select("station",array("*")," maintenance =1 AND statut = 1");
$dataArray = array();
$dataArray[] = array("SUIVI DES STOCKS ET DES LIVRAISONS");
$dataArray[] = array("14/05/2020","AM");
$dataArray[] = array("");
$dataArray[] = array("STATIONS",
					"Produits",
					"Capacité de stockage",
					"stock du 14/05",
					"valeur stock",
					"Creux potentiels",
					"Pourcentage de la capacité de stockage en cuve",
					"Ventes journalieres estimatif (depuis confinement) Ventes journalieres","liv 13/05",
					"commande recu 14/05/20 liv 15/05",
					"stock après Livraison j+1",
					"stock après Livraison 06/04",
					"Creux potentiels après livraison",
					"Pourcentage de la capacité de stockage en cuve J+1",
					"autonomie","observations");

$title = array(
  'borders' => array(
  	'outline' => array(
  		'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
  		'color' => array('argb' => '00000000'),
  	),
  ),
  'font'  => array(
  	'bold'  => true,
  	'name'  => 'Calibri',
  	'size'  => 10,
  	'color' => array('rgb' => 'FFFFFF'),
  ),
  'fill' => array(
  	'type' => PHPExcel_Style_Fill::FILL_SOLID, 
  	'color' => array('rgb' => '16365C')
  ),
  'alignment' => array( 
  	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
  	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
  	'wrap' => true // retour à la ligne automatique
  )
);

$title1 = array(
  'borders' => array(
  	'outline' => array(
  		'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
  		'color' => array('argb' => '00000000'),
  	),
  ),
  'font'  => array(
  	'bold'  => true,
  	'name'  => 'Calibri',
  	'size'  => 10,
  	'color' => array('rgb' => 'FFFFFF'),
  ),
  'fill' => array(
  	'type' => PHPExcel_Style_Fill::FILL_SOLID, 
  	'color' => array('rgb' => 'C00000')
  ),
  'alignment' => array( 
  	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
  	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
  	'wrap' => true // retour à la ligne automatique
  )
);

$ligne = array(
  'borders' => array(
  	'outline' => array(
  		'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
  		'color' => array('argb' => '00000000'),
  	),
  ),
  'font'  => array(
  	'bold'  => true,
  	'name'  => 'Calibri',
  	'size'  => 10,
  	'color' => array('rgb' => '000000'),
  ),
  'fill' => array(
  	'type' => PHPExcel_Style_Fill::FILL_SOLID, 
  	'color' => array('rgb' => 'FFFFFF')
  ),
  'alignment' => array( 
  	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
  	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
  	'wrap' => true // retour à la ligne automatique
  )
);
foreach ($stations as $st) {
	# code...
	$dataArray[] = array($st["nom"]);
}

$n = count($stations);
$doc = new PHPExcel();
// set active sheet 
$doc->setActiveSheetIndex(0);
$doc->getActiveSheet()->fromArray($dataArray);
$doc->getActiveSheet()->getStyle('A4')->applyFromArray($title);
$doc->getActiveSheet()->getStyle('B4')->applyFromArray($title);
$doc->getActiveSheet()->getStyle('C4')->applyFromArray($title);
$doc->getActiveSheet()->getStyle('D4')->applyFromArray($title);
$doc->getActiveSheet()->getStyle('E4')->applyFromArray($title);
$doc->getActiveSheet()->getStyle('F4')->applyFromArray($title);
$doc->getActiveSheet()->getStyle('G4')->applyFromArray($title);
$doc->getActiveSheet()->getStyle('H4')->applyFromArray($title);
$doc->getActiveSheet()->getStyle('I4')->applyFromArray($title1);
$doc->getActiveSheet()->getStyle('J4')->applyFromArray($title1);
$doc->getActiveSheet()->getStyle('K4')->applyFromArray($title1);
$doc->getActiveSheet()->getStyle('L4')->applyFromArray($title1);
$doc->getActiveSheet()->getStyle('M4')->applyFromArray($title1);
$doc->getActiveSheet()->getStyle('N4')->applyFromArray($title1);
$doc->getActiveSheet()->getStyle('O4')->applyFromArray($title1);
$doc->getActiveSheet()->getStyle('P4')->applyFromArray($title);

for($i = 5 ;$i<$n+5;$i++){
$doc->getActiveSheet()->getStyle('A'.$i)->applyFromArray($ligne);
$doc->getActiveSheet()->getStyle('B'.$i)->applyFromArray($ligne);
}
//save our workbook as this file name
$filename = 'extraction.xls';
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
}

?>