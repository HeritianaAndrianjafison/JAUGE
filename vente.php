<?php



include "config/config.php";
need_connexion();
$css = array("etat");
$js = array("etat");
$action = valueof("action");
if($action==null){
include "include/header.php";
include "include/left.php";
$region =  liste_region();

include "include/vente.php";

}elseif($action=="vente_journaliere"){
  $station = DB::select("station",array("*")," region='".valueof('region')."'");
  $list = array();
  $region =  liste_region();
  $date = valueof("date");
  $date = DateTime::createFromFormat('d/m/Y', $date);
    $date = $date->format('Y-m-d');
    $date_yesterday = date('Y-m-d', strtotime('-1 day', strtotime($date)));
  foreach ($station as $st) {
    # code...
    
    if($date==null){
      continue;
    }

    $sc = DB::select("data",array("*")," date like '$date%' && code ='".$st['code']."' ORDER BY date DESC");
    if(count($sc)==0){
      continue;
    }
    $scy = DB::select("data",array("*")," date like '$date_yesterday%' && code ='".$st['code']."' ORDER BY date DESC");
    if(count($scy)==0){
      continue;
    }
    $sc = $sc[0];
    $scy= $scy[0];

    $v_go = $scy["stock_go"]-$sc["stock_go"];
    $v_sp = $scy["stock_sp"]-$sc["stock_sp"];
    $v_pl = $scy["stock_pl"]-$sc["stock_pl"];
    $sql = "SELECT station_site.site_id,station_site.collect,tank.tank_id,tank.label FROM station_site INNER JOIN tank ON station_site.site_id = tank.site_id AND station_site.collect = tank.collect WHERE station_site.station_code='".$st['code']."'";

    //echo $sql."<br>";
   // die();
    $sites = DB::qs($sql);
    $pl = 0;
    $go = 0;
    $sp = 0;
    foreach($sites as $s){
        if($s["collect"]==1){
            $adress = $adress_telma;
        }else{
            $adress = $adress_orange;
        }
        $date_deb = date('d/m/Y', strtotime('-1 day', strtotime($date)));
        $date_fin = valueof("date");
        $url = $adress."delivery.php?action=get_delivery&&tank=".$s['tank_id']."&&date_deb=$date_deb&&date_fin=$date_fin";
        
        $deliveries = getCurl($url);
        $deliveries = json_decode($deliveries,true);
        
        foreach ($deliveries as $dlv) {
          # code...

          if(!is_numeric($dlv['Ending Volume'])||!is_numeric($dlv['Starting Volume'])){

                  continue;
          }
          if($dlv['Ending Volume']<$dlv['Starting Volume']){
            continue;
          }
          if($dlv['Ending Volume']<0||$dlv['Starting Volume']<0){
            continue;
          }
          if(($dlv['Ending Volume']-$dlv['Starting Volume'])>50000){
            continue;
          }
          if($dlv['Ending Volume']<0||$dlv['Starting Volume']<0){
            continue;
          }
          if(($dlv['Ending Volume']-$dlv['Starting Volume'])<100){
            continue;
          }
        //echo $st['code']." ".$dlv['Ending Volume']." ".$dlv['Starting Volume']."  ".$dlv['Starting Date & time']." <br>";

          if (preg_match("#pl#i", $s['label']))
            { 
                $pl+=$dlv['Ending Volume']-$dlv['Starting Volume'];
            }
            if (preg_match("#go#i", $s['label']))
            {
                $go+=$dlv['Ending Volume']-$dlv['Starting Volume'];
            }
            if (preg_match("#sp#i", $s['label']))
            {
                $sp+=$dlv['Ending Volume']-$dlv['Starting Volume'];
            }
        }

    }

    $st["v_go"] = $v_go+$go;
    $st["v_sp"] = $v_sp+$sp;
    $st["v_pl"] = $v_pl+$pl;
    $st["dlv_go"] = $go;
    $st["dlv_sp"] = $sp;
    $st["dlv_pl"] = $pl;
    $list[] = $st;
  }
  $nav="";
  //die();
  include "include/header.php";
  include "include/left.php";
  include "include/list_vente.php";
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