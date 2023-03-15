<?php

include "config/config.php";
$dbname = "inspection_v2";
$servername = "192.168.130.139";
$username = "jovena2";
$password = "AXeptit#1245";
$key ="lnvvlkqhgoiruhtàhjksbdkmqbv;s<,vbkm";

// Create connection
$connection = new mysqli($servername, $username, $password,$dbname);
require("fpdf/fpdf.php");


$id_inspection = $_GET["id"];
$inspection = DB::select("inspection",array("*")," id=$id_inspection")[0];
$station = DB::select("station",array("*")," id=".$inspection["station_id"])[0];
$date = date("d/m/Y",strtotime($inspection["date"]));
$sql = "SELECT station_rubric.rubric_id, rubric.name AS rubric_name FROM station_rubric INNER JOIN rubric ON station_rubric.rubric_id = rubric.id WHERE  station_rubric.station_id=".$station["id"]." ORDER BY rubric.position ASC";
//echo $sql;

$sql_rub = "SELECT distinct(rubric1.name),rubric1.id FROM field_value INNER JOIN inspection ON field_value.inspection_id = inspection.id INNER JOIN user on inspection.inspector_id = user.id INNER JOIN station ON inspection.station_id = station.id INNER JOIN region ON station.sous_region_id = region.id INNER JOIN field ON field_value.field_id = field.id INNER JOIN rubric ON field.rubric_id = rubric.id INNER JOIN rubric AS rubric1 ON rubric.parent_id = rubric1.id WHERE inspection.id=$id_inspection ORDER by inspection.id  DESC, rubric1.plug_id ASC, rubric1.id ASC, rubric1.position ASC";
	$rub=DB::qs($sql_rub);
	//print_r($rub);
	$n = count($rub);
	$left = intval($n/2);
	$right = $n - $left;
	$left_list = array();
	$right_list = array();
	$sql = "SELECT field_value.id AS ID_FIELD_VALUE,field_value.note AS NOTE,field.value AS MAX, inspection.id AS INSPECTION_ID,inspection.date AS DATE_INSPECTION,station.name AS STATION_NAME,region.name AS SOUS_REGION, user.firstname AS PRENOM,user.lastname AS NOM,field.name AS LABEL_CHAMPS,rubric.id AS SOUS_RUBRIC_ID,rubric.name AS LABEL_SOUS_RUBRIC,rubric1.name AS LABEL_RUBRIC, rubric1.plug_id AS plug_id, rubric1.id AS RUBRIC_ID, rubric1.position AS position FROM field_value INNER JOIN inspection ON field_value.inspection_id = inspection.id INNER JOIN user on inspection.inspector_id = user.id INNER JOIN station ON inspection.station_id = station.id INNER JOIN region ON station.sous_region_id = region.id INNER JOIN field ON field_value.field_id = field.id INNER JOIN rubric ON field.rubric_id = rubric.id INNER JOIN rubric AS rubric1 ON rubric.parent_id = rubric1.id WHERE inspection.id=$id_inspection ORDER by rubric1.plug_id ASC, rubric1.position ASC, rubric1.id ASC, rubric.id ASC";
	$lignes = DB::qs($sql);
	$rubric_id =-1;
	$sous_rubric_id = -1;
	$note = 0;
	$max = 0;
	$ranc=-1;
	$left =2;
	foreach ($lignes as $l) {
		# code...
		
		if($rubric_id!=$l["RUBRIC_ID"]){
			$ranc++;
			if($rubric_id!=-1){

			$$position[] = array("val_1"=>"Pourcentage Rubrique","val_2"=>$note,"val_3"=>$max,"type"=>4);
			$note =0;
			$max=0;
			}
			if($ranc<$left-1){
			$position = "left_list";
			}else{
			$position = "right_list";
			}
			
			$rubric_id = $l["RUBRIC_ID"];
			$$position[] = array("val_1"=>$l["LABEL_RUBRIC"],"type"=>1);
			
		}
		if($sous_rubric_id!=$l["SOUS_RUBRIC_ID"]){
			$sous_rubric_id=$l["SOUS_RUBRIC_ID"];
			$$position[] = array("val_1"=>$l["LABEL_SOUS_RUBRIC"],"type"=>2);
		}
			$$position[] = array("val_1"=>$l["LABEL_CHAMPS"],"val_2"=>$l["NOTE"],"val_3"=>$l["MAX"],"type"=>3);
			if($l["NOTE"]!="NA" && $l["NOTE"]!="SB"){
						$note =$note+$l["NOTE"];
						$max +=$l["MAX"];
					}
	}

$max_ev = max(count($right_list),count($left_list));

$sql_conf="SELECT distinct rubric.name AS name FROM field_value INNER JOIN inspection ON field_value.inspection_id = inspection.id INNER JOIN user on inspection.inspector_id = user.id INNER JOIN station ON inspection.station_id = station.id INNER JOIN region ON station.sous_region_id = region.id INNER JOIN field ON field_value.field_id = field.id INNER JOIN rubric ON field.rubric_id = rubric.id WHERE rubric.plug_id=4 AND inspection.id=$id_inspection ORDER by inspection.id  DESC, rubric.position ASC";
	$rub_conf = DB::qs($sql_conf);
	$n_conf = count($rub_conf);
	$left_conf = intval($n_conf/2);
	$right_conf = $n_conf - $left_conf;
	$left_list_conf = array();
	$right_list_conf = array();


$sql_conf="SELECT field_value.id AS ID_FIELD_VALUE,rubric.id AS RUBRIC_ID,field_value.note AS NOTE,field.value AS MAX, inspection.id AS INSPECTION_ID,inspection.date AS DATE_INSPECTION,station.name AS STATION_NAME,region.name AS SOUS_REGION, user.firstname AS PRENOM,user.lastname AS NOM,field.name AS LABEL_CHAMPS,rubric.name AS LABEL_RUBRIC ,rubric.plug_id AS plug_id, rubric.id AS rubric_id, rubric.position AS position FROM field_value INNER JOIN inspection ON field_value.inspection_id = inspection.id INNER JOIN user on inspection.inspector_id = user.id INNER JOIN station ON inspection.station_id = station.id INNER JOIN region ON station.sous_region_id = region.id INNER JOIN field ON field_value.field_id = field.id INNER JOIN rubric ON field.rubric_id = rubric.id WHERE rubric.plug_id=4 AND inspection.id=$id_inspection ORDER by inspection.id  DESC, rubric.position ASC";
$lignes_conf=DB::qs($sql_conf);
$rubric_id =-1;
	$sous_rubric_id = -1;
	$note = 0;
	$max = 0;
	$ranc=-1;
	$left =2;
	foreach ($lignes_conf as $l) {
		# code...
		
		if($rubric_id!=$l["RUBRIC_ID"]){
			$ranc++;
			if($rubric_id!=-1){

			$$position[] = array("val_1"=>"Pourcentage Rubrique","val_2"=>$note,"val_3"=>$max,"type"=>4);
			$note =0;
			$max=0;
			}
			if($ranc<$left){
			$position = "left_list_conf";
			}else{
			$position = "right_list_conf";
			}
			
			$rubric_id = $l["RUBRIC_ID"];
			$$position[] = array("val_1"=>$l["LABEL_RUBRIC"],"type"=>1);
			
		}
			$$position[] = array("val_1"=>$l["LABEL_CHAMPS"],"val_2"=>$l["NOTE"],"val_3"=>$l["MAX"],"type"=>3);
			if($l["NOTE"]=="C"){
						$note =$note+1;
						//$max +=$r["MAX"];
						//echo $note;
					}
					if($l["NOTE"]!="NA"){
						$max ++;
					}
	}
$max_conf = max(count($right_list_conf),count($left_list_conf));
/*
?>
<table border="1">
	<?php 
		for($i=0;$i<$max_conf;$i++){
			?>
		<tr>
			<td><?php if(isset($left_list_conf[$i]["val_1"])){echo $left_list_conf[$i]["val_1"];}?></td>
			<td><?php if(isset($left_list_conf[$i]["val_3"])){echo $left_list_conf[$i]["val_3"];};?></td>
			<td><?php if(isset($left_list_conf[$i]["val_2"])){echo $left_list_conf[$i]["val_2"];};?></td>
			<td><?php if(isset($right_list_conf[$i]["val_1"])){echo $right_list_conf[$i]["val_1"];}?></td>
			<td><?php if(isset($right_list_conf[$i]["val_3"])){echo $right_list_conf[$i]["val_3"];};?></td>
			<td><?php if(isset($right_list_conf[$i]["val_2"])){echo $right_list_conf[$i]["val_2"];};?></td>
		</tr>
			<?php
		}
	?>
</table><?php*/


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetLineWidth(0.4);
$pdf->SetFont('Helvetica','B',10);
$pdf->Cell(62,5,'','LTR',0);$pdf->Cell(63,5,'ECS / FICEVS / V4.00','RT',0,'C');
$pdf->Cell(62,5,$date,'LTR',0,'C');
$pdf->Ln();
//$npages = $pdf->AliasNbPages('{totalPages}');
$pdf->Cell(62,5,'','LBR',0);
$pdf->Cell(63,5,'FICHE D\'EVALUATION STATION				
',1,0,'C');
$pdf->Cell(62,5,'Page 1',1,0,'C');
$pdf->Image('fpdf/logo.jpg',23,10.5,30);

$pdf->SetFont('Helvetica',null,8);
$pdf->Cell(50,10,'',0,0);
$pdf->Ln();
$pdf->SetFont('Helvetica','B',10);
$pdf->Cell(187,5,'FICHE D\'EVALUATION STATION',1,0,'C');
$pdf->Ln();
$pdf->SetFont('Helvetica','B',6);
$pdf->Cell(93,5,'STATION :'.$station['name'],'L',0,'L');
$pdf->Cell(47,5,'NOM ET SIGNATURE INSPECTEUR','L',0,'L');
$pdf->Cell(47,5,'NOM ET SIGNATURE GERANT','LR',0,'L');
$pdf->Ln();
$pdf->Cell(93,2,'','L',0,'L');
$pdf->Cell(47,2,'','L',0,'L');
$pdf->Cell(47,2,'','LR',0,'L');
$pdf->Ln();
$pdf->Cell(93,5,'DATE :','LB',0,'L');
$pdf->Cell(47,5,'','LB',0,'L');
$pdf->Cell(47,5,'','LBR',0,'L');
for($i=0;$i<$max_ev;$i++){
$pdf->Ln();
	$c1="";
	$c2="";
	$c3="";
	$c4="";
	$c5="";
	$c6="";
 $two_line = false;
 if(isset($left_list[$i]["val_1"])){
 	$c1 = iconv('UTF-8','windows-1252', $left_list[$i]["val_1"]);
 	$length_l = strlen($c1);
 	$limit = 75;
 	if($left_list[$i]["type"]==1||$left_list[$i]["type"]==2){
 	$limit = 70;
 	}
 	if($length_l>$limit){
 		$c11 = substr($c1,0,$limit);
 		$c12 = substr($c1,$limit+1,$length_l+1);
 		$two_line = true;
 	}
 	$c41 = "";
 	$c42 = "";
 	if(isset($right_list[$i]["val_1"])){
 		$c41 = $right_list[$i]["val_1"];
 	}
 	};
 	
 	if(isset($right_list[$i]["val_1"])){
 	$c4 = iconv('UTF-8','windows-1252', $right_list[$i]["val_1"]);
 	$length_r = strlen($c4);
 	$limit = 75;
 	if($right_list[$i]["type"]==1||$right_list[$i]["type"]==2){
 	$limit = 70;
 	}
 	if($length_r>$limit){
 		$c41 = substr($c4,0,$limit);
 		$c42 = substr($c4,$limit+1,$length_l+1);
 		$two_line = true;
 	}
 	//$c41 = "";
 	//$c42 = "";
 	if(!isset($c11)){
 		$c11="";
 		$c12="";
 		if(isset($left_list[$i]["val_1"])){
 		$c11 = $left_list[$i]["val_1"];

 		}
 	}
 	};


 	if(isset($left_list[$i]["val_3"])){$c2 = $left_list[$i]["val_3"];};
 	if(isset($left_list[$i]["val_2"])){$c3 = $left_list[$i]["val_2"];};
 	if(isset($right_list[$i]["val_1"])){$c4 = iconv('UTF-8','windows-1252', $right_list[$i]["val_1"]);}
 	if(isset($right_list[$i]["val_3"])){$c5 = $right_list[$i]["val_3"];}
 	if(isset($right_list[$i]["val_2"])){$c6 = $right_list[$i]["val_2"];}
 	if($two_line){//OR (isset($c41) AND $c41!="")
		if(isset($left_list[$i])&&($left_list[$i]["type"]==1||$left_list[$i]["type"]==2)){
			$pdf->SetFont('Helvetica','B',8);
		}
		$pdf->Cell(73,5,$c11,'L',0,'L');
		$pdf->Cell(10,5,$c2,'L',0,'R');
		$pdf->Cell(10,5,$c3,'L',0,'R');
		$pdf->SetFont('Helvetica',null,6);

		if(isset($right_list[$i])&&($right_list[$i]["type"]==1||$right_list[$i]["type"]==2)){
			$pdf->SetFont('Helvetica','B',8);
		}
		$pdf->Cell(74,5,$c41,'L',0,'L');
		$pdf->Cell(10,5,$c5,'L',0,'R');
		$pdf->Cell(10,5,$c6,'LR',0,'R');
		$pdf->SetFont('Helvetica',null,6);
		$pdf->Ln();
		if(isset($left_list[$i])&&($left_list[$i]["type"]==1||$left_list[$i]["type"]==2)){
			$pdf->SetFont('Helvetica','B',8);
		}
		$pdf->Cell(73,5,$c12,'LB',0,'L');
		$pdf->Cell(10,5,'','LB',0,'R');
		$pdf->Cell(10,5,'','LB',0,'R');
		$pdf->SetFont('Helvetica',null,6);

		if(isset($right_list[$i])&&($right_list[$i]["type"]==1||$right_list[$i]["type"]==2)){
			$pdf->SetFont('Helvetica','B',8);
		}
		$pdf->Cell(74,5,$c42,'LB',0,'L');
		$pdf->Cell(10,5,'','LB',0,'R');
		$pdf->Cell(10,5,'','LBR',0,'R');
		$pdf->SetFont('Helvetica',null,6);

}else{
		if(isset($left_list[$i])&&($left_list[$i]["type"]==1||$left_list[$i]["type"]==2)){
			$pdf->SetFont('Helvetica','B',8);
		}
		$pdf->Cell(73,5,$c1,'LB',0,'L');
		$pdf->Cell(10,5,$c2,'LB',0,'R');
		$pdf->Cell(10,5,$c3,'LB',0,'R');
		$pdf->SetFont('Helvetica',null,6);

		if(isset($right_list[$i])&&($right_list[$i]["type"]==1||$right_list[$i]["type"]==2)){
			$pdf->SetFont('Helvetica','B',8);
		}
		$pdf->Cell(74,5,$c4,'LB',0,'L');
		$pdf->Cell(10,5,$c5,'LB',0,'R');
		$pdf->Cell(10,5,$c6,'LBR',0,'R');
		$pdf->SetFont('Helvetica',null,6);
}
unset($c11);
}
$pdf->Ln();
$pdf->Cell(100,4,'',0,0,'L');
$pdf->Ln();
$pdf->Cell(100,4,'I)PRIME DE LA RUBRIQUE EST GAGNEE SI  TOTAL DE LA RUBRIQUE > ou = 90% DU POTENTIEL',0,0,'L');
$pdf->Ln();
$pdf->Cell(150,4,iconv('UTF-8','windows-1252', 'II)ACTIONS DE LA DERNIERE INSPECTION NON MISES EN ŒUVRE PAR LE GERANT = Prime de la rubrique Zéro'),0,0,'L');
$pdf->Ln();
$pdf->Cell(74,4,'III)UN ITEM NOTE 0 TROIS FOIS DE SUITE ANNULE LA TOTALITE DE LA COMMISSION',0,0,'L');
$pdf->Ln();
$pdf->Cell(100,4,'',0,0,'L');
$pdf->Ln();
$pdf->Cell(74,5,iconv('UTF-8','windows-1252', "Actions non mises en œuvres"),'LTRB',0,'L');
$pdf->Cell(10,5,"OUI",'LTRB',0,'R');
$pdf->Cell(10,5,"NON",'LTRB',0,'R');
$pdf->Cell(10,5,"PRIME",'LTRB',0,'R');

//print_r($rub);
$sql = "SELECT * from inspection WHERE station_id=".$inspection["station_id"]." ORDER BY id DESC LIMIT 2";
//echo $sql;
$pinspection = DB::qs($sql);
$check_item = false;
if(count($pinspection)==2){
	$pinspection = $pinspection[1];
	$check_item = true;
}
foreach ($rub as $r) {
	# code...
	
	$prime = true;
	if($check_item){
		$sql_r1 = "SELECT field_value.* FROM field_value INNER JOIN field ON field_value.field_id INNER JOIN rubric ON field.rubric_id=rubric.id INNER JOIN rubric AS rubric1 ON rubric.parent_id = rubric1.id
		 WHERE field_value.inspection_id =".$inspection["id"]."  AND rubric1.id=".$r['id'];
		$sql_r2 = "SELECT field_value.* FROM field_value INNER JOIN field ON field_value.field_id INNER JOIN rubric ON field.rubric_id=rubric.id INNER JOIN rubric AS rubric1 ON rubric.parent_id = rubric1.id
		 WHERE field_value.inspection_id =".$pinspection["id"]."  AND rubric1.id=".$r['id'];
		 
		 $rub1 = DB::qs($sql_r1);
		 $rub2 = DB::qs($sql_r1);
		 $break = false;
		 foreach ($rub1 as $r1) {
		 	# code...
		 	foreach ($rub2 as $r2) {
		 		# code...
		 		if($r1["field_id"]==$r2["field_id"]){
		 			if($r1["note"] == 0 AND $r2["note"] == 0){
		 				$prime = false;
		 			}
		 		$break = true;
		 		break;
		 		}
		 	}
		 	if($break){
		 		break;
		 	}
		 }
	}
	$non = "";
	$oui = "";
	if($prime){
		$oui = "OUI";
	}else{
		$non = "NON";
	}
	$pdf->Ln();
	$pdf->Cell(74,5,iconv('UTF-8','windows-1252', $r["name"]),'LRB',0,'L');
	$pdf->Cell(10,5,$oui,'LRB',0,'R');
	$pdf->Cell(10,5,$non,'LRB',0,'R');
	$pdf->Cell(10,5,"",'LRB',0,'R');
}
$pdf->Ln();
$pdf->Cell(100,4,'',0,0,'L');
$pdf->Ln();
$pdf->Cell(187,5,iconv('UTF-8','windows-1252', "O B S E R V A T I O N S / A C T I O N S   A  P R E N D R E"),'LTRB',0,'L');
$pdf->Ln();
$pdf->Cell(94,5,iconv('UTF-8','windows-1252', "GERANT"),'LTRB',0,'L');
$pdf->Cell(93,5,iconv('UTF-8','windows-1252', "JOVENA"),'TRB',0,'L');
$pdf->Ln();
$pdf->Cell(94,5,"",'LRB',0,'L');
$pdf->Cell(93,5,"",'RB',0,'L');
$pdf->Ln();
$pdf->Cell(94,5,"",'LRB',0,'L');
$pdf->Cell(93,5,"",'RB',0,'L');
$pdf->Ln();
$pdf->Cell(94,5,"",'LRB',0,'L');
$pdf->Cell(93,5,"",'RB',0,'L');
$pdf->Ln();
$pdf->Cell(94,5,"",'LRB',0,'L');
$pdf->Cell(93,5,"",'RB',0,'L');
$pdf->AddPage();
$pdf->SetLineWidth(0.4);
$pdf->SetFont('Helvetica','B',10);
$pdf->Cell(62,5,'','LTR',0);$pdf->Cell(63,5,'ECS / FICCFS / V3.00','RT',0,'C');
$pdf->Cell(62,5,$date,'LTR',0,'C');
$pdf->Ln();
//$npages = $pdf->AliasNbPages('{totalPages}');
$pdf->Cell(62,5,'','LBR',0);
$pdf->Cell(63,5,'FICHE DE CONFORMITE STATION',1,0,'C');
$pdf->Cell(62,5,'Page 1',1,0,'C');
$pdf->Image('fpdf/logo.jpg',23,10.5,30);

$pdf->SetFont('Helvetica',null,8);
$pdf->Cell(50,10,'',0,0);
$pdf->Ln();
$pdf->SetFont('Helvetica','B',10);
$pdf->Cell(187,5,'FICHE DE CONFORMITE STATION',1,0,'C');
$pdf->Ln();
$pdf->SetFont('Helvetica','B',6);
$pdf->Cell(93,5,'STATION :'.$station['name'],'L',0,'L');
$pdf->Cell(47,5,'NOM ET SIGNATURE INSPECTEUR','L',0,'L');
$pdf->Cell(47,5,'NOM ET SIGNATURE GERANT','LR',0,'L');
$pdf->Ln();
$pdf->Cell(93,2,'','L',0,'L');
$pdf->Cell(47,2,'','L',0,'L');
$pdf->Cell(47,2,'','LR',0,'L');
$pdf->Ln();
$pdf->Cell(93,5,'DATE :','LB',0,'L');
$pdf->Cell(47,5,'','LB',0,'L');
$pdf->Cell(47,5,'','LBR',0,'L');


for($i=0;$i<$max_conf;$i++){
$pdf->Ln();
	$c1="";
	$c2="";
	$c3="";
	$c4="";
	$c5="";
	$c6="";
 $two_line = false;
 if(isset($left_list_conf[$i]["val_1"])){
 	$c1 = iconv('UTF-8','windows-1252', $left_list_conf[$i]["val_1"]);
 	$length_l = strlen($c1);
 	$limit = 75;
 	if($left_list_conf[$i]["type"]==1||$left_list_conf[$i]["type"]==2){
 	$limit = 70;
 	}
 	if($length_l>$limit){
 		$c11 = substr($c1,0,$limit);
 		$c12 = substr($c1,$limit+1,$length_l+1);
 		$two_line = true;
 	}
 	$c41 = "";
 	$c42 = "";
 	if(isset($right_list_conf[$i]["val_1"])){
 		$c41 = $right_list_conf[$i]["val_1"];
 	}
 	};
 	
 	if(isset($right_list_conf[$i]["val_1"])){
 	$c4 = iconv('UTF-8','windows-1252', $right_list_conf[$i]["val_1"]);
 	$length_r = strlen($c4);
 	$limit = 75;
 	if($right_list_conf[$i]["type"]==1||$right_list_conf[$i]["type"]==2){
 	$limit = 70;
 	}
 	if($length_r>$limit){
 		$c41 = substr($c4,0,$limit);
 		$c42 = substr($c4,$limit+1,$length_l+1);
 		$two_line = true;
 	}
 	//$c41 = "";
 	//$c42 = "";
 	if(!isset($c11)){
 		$c11="";
 		$c12="";
 		if(isset($left_list_conf[$i]["val_1"])){
 		$c11 = $left_list_conf[$i]["val_1"];

 		}
 	}
 	};


 	if(isset($left_list_conf[$i]["val_3"])){$c2 = $left_list_conf[$i]["val_3"];};
 	if(isset($left_list_conf[$i]["val_2"])){$c3 = $left_list_conf[$i]["val_2"];};
 	if(isset($right_list_conf[$i]["val_1"])){$c4 = iconv('UTF-8','windows-1252', $right_list_conf[$i]["val_1"]);}
 	if(isset($right_list_conf[$i]["val_3"])){$c5 = $right_list_conf[$i]["val_3"];}
 	if(isset($right_list_conf[$i]["val_2"])){$c6 = $right_list_conf[$i]["val_2"];}
 	if($two_line){//OR (isset($c41) AND $c41!="")
		if(isset($left_list_conf[$i])&&($left_list_conf[$i]["type"]==1||$left_list_conf[$i]["type"]==2)){
			$pdf->SetFont('Helvetica','B',8);
		}
		$pdf->Cell(73,5,$c11,'L',0,'L');
		$pdf->Cell(10,5,$c2,'L',0,'R');
		$pdf->Cell(10,5,$c3,'L',0,'R');
		$pdf->SetFont('Helvetica',null,6);

		if(isset($right_list_conf[$i])&&($right_list_conf[$i]["type"]==1||$right_list_conf[$i]["type"]==2)){
			$pdf->SetFont('Helvetica','B',8);
		}
		$pdf->Cell(74,5,$c41,'L',0,'L');
		$pdf->Cell(10,5,$c5,'L',0,'R');
		$pdf->Cell(10,5,$c6,'LR',0,'R');
		$pdf->SetFont('Helvetica',null,6);
		$pdf->Ln();
		if(isset($left_list[$i])&&($left_list_conf[$i]["type"]==1||$left_list_conf[$i]["type"]==2)){
			$pdf->SetFont('Helvetica','B',8);
		}
		$pdf->Cell(73,5,$c12,'LB',0,'L');
		$pdf->Cell(10,5,'','LB',0,'R');
		$pdf->Cell(10,5,'','LB',0,'R');
		$pdf->SetFont('Helvetica',null,6);

		if(isset($right_list_conf[$i])&&($right_list_conf[$i]["type"]==1||$right_list_conf[$i]["type"]==2)){
			$pdf->SetFont('Helvetica','B',8);
		}
		$pdf->Cell(74,5,$c42,'LB',0,'L');
		$pdf->Cell(10,5,'','LB',0,'R');
		$pdf->Cell(10,5,'','LBR',0,'R');
		$pdf->SetFont('Helvetica',null,6);

}else{
		if(isset($left_list_conf[$i])&&($left_list_conf[$i]["type"]==1||$left_list_conf[$i]["type"]==2)){
			$pdf->SetFont('Helvetica','B',8);
		}
		$pdf->Cell(73,5,$c1,'LB',0,'L');
		$pdf->Cell(10,5,$c2,'LB',0,'R');
		$pdf->Cell(10,5,$c3,'LB',0,'R');
		$pdf->SetFont('Helvetica',null,6);

		if(isset($right_list_conf[$i])&&($right_list_conf[$i]["type"]==1||$right_list_conf[$i]["type"]==2)){
			$pdf->SetFont('Helvetica','B',8);
		}
		$pdf->Cell(74,5,$c4,'LB',0,'L');
		$pdf->Cell(10,5,$c5,'LB',0,'R');
		$pdf->Cell(10,5,$c6,'LBR',0,'R');
		$pdf->SetFont('Helvetica',null,6);
}

}
$pdf->Ln();
$pdf->Cell(100,4,'',0,0,'L');
$pdf->Ln();
$pdf->Cell(74,5,iconv('UTF-8','windows-1252', "Actions non mises en œuvres"),'LTRB',0,'L');
$pdf->Cell(10,5,"OUI",'LTRB',0,'R');
$pdf->Cell(10,5,"NON",'LTRB',0,'R');

foreach ($rub_conf as $r) {
	# code...
	$pdf->Ln();
	$pdf->Cell(74,5,iconv('UTF-8','windows-1252', $r["name"]),'LRB',0,'L');
	$pdf->Cell(10,5,"",'LRB',0,'R');
	$pdf->Cell(10,5,"",'LRB',0,'R');
	
}
$pdf->Ln();
$pdf->Cell(100,4,'',0,0,'L');
$pdf->Ln();
$pdf->Cell(187,5,iconv('UTF-8','windows-1252', "O B S E R V A T I O N S / A C T I O N S   A  P R E N D R E"),'LTRB',0,'L');
$pdf->Ln();
$pdf->Cell(94,5,iconv('UTF-8','windows-1252', "GERANT"),'LTRB',0,'L');
$pdf->Cell(93,5,iconv('UTF-8','windows-1252', "JOVENA"),'TRB',0,'L');
$pdf->Ln();
$pdf->Cell(94,5,"",'LRB',0,'L');
$pdf->Cell(93,5,"",'RB',0,'L');
$pdf->Ln();
$pdf->Cell(94,5,"",'LRB',0,'L');
$pdf->Cell(93,5,"",'RB',0,'L');
$pdf->Ln();
$pdf->Cell(94,5,"",'LRB',0,'L');
$pdf->Cell(93,5,"",'RB',0,'L');
$pdf->Ln();
$pdf->Cell(94,5,"",'LRB',0,'L');
$pdf->Cell(93,5,"",'RB',0,'L');


$pdf->Output("file/test.pdf","I");

?>