<?php
include "config/config.php";
need_connexion();
include "PHP/Classes/PHPExcel/IOFactory.php";
$n = DB::select("station",array("COUNT(*)"),"1")[0]["COUNT(*)"];
$action = valueof("action");
if($action == null){

 	$list = DB::select("station",array("*"),"1 Order by code DESC");
 	
$dataArray = array();
 	foreach ($list as $sta) {
 		# code...
 		$dataArray[] = array($sta["nom"]);
 		
 		$sp = 0;
		$pl = 0;
		$go = 0;

		$smisp = 0;
		$smipl = 0;
		$smigo = 0;
		$smasp = 0;
		$smapl = 0;
		$smago = 0;

 		$tanks = DB::select("tank",array("*")," site_id=".$sta["site_id"]);

					foreach($tanks as $t){
				//extract($r);
					$inventory = DB::select("inventory",array("*")," tank_id='".$t['tank_id']."' AND collect='".$t['collect']."'");
					//print_r($tanks);
					if(count($inventory)==0){
						continue;
					}
				$inventory = $inventory[0];
				$quantity = $inventory['volume']/$t['capacite']*100;
				if (preg_match("#pl#i", $t['label']))
		        {
		            $pl+=$inventory['volume'];
		            $smipl += $t['seuil_min'];
		            $smapl += $t["seuil_max"];
		        }
		        if (preg_match("#go#i", $t['label']))
		        {
		            $go+=$inventory['volume'];
		            $smigo += $t['seuil_min'];
		            $smago += $t["seuil_max"];
		        }
		        if (preg_match("#sp#i", $t['label']))
		        {
		            $sp+=$inventory['volume'];
		            $smisp += $t['seuil_min'];
		            $smago += $t["seuil_max"];
		        }
				//include "include/detail_etat.php";
				if(isset($_GET["date"])){

					$date = $_GET["date"];
					
				}else{
					$date = date("d/m/Y H:i:s");
				}
				$date_encode = urlencode ($date);
				};


				$dataArray[] = array("PL",$pl,$smipl,$smapl);
				$dataArray[] = array("SP",$sp,$smisp,$smasp);
				$dataArray[] = array("SP",$sp,$smigo,$smago);
				$dataArray[] = array("DATE",date("d/m/Y H:i:s"));

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