<?php
include "config/config.php";
need_connexion();
$css = array("etat");
$js = array("etat");
//include "include/header.php";
//include "include/left.php";
//include "include/login.php";


$action = valueof("action");
if($action == "enregistrer_data"){
 	$list = DB::select("station",array("*")," statut = 1 AND code='".valueof('code')."'");
 	foreach ($list as $sta) {
 		# code...
 		$station_site = DB::select("station_site",array("*")," station_code='".$sta["code"]."'");

$sqlX32 ="SELECT SORDER.SOHNUM_0, SDELIVERY.SDHNUM_0,SDELIVERY.DLVDAT_0, SDELIVERYD.ITMREF_0,SORDER.DLVSTA_0,SDELIVERYD.QTY_0,SDELIVERYD.NETPRIATI_0 FROM SORDER INNER JOIN SDELIVERY ON SORDER.SOHNUM_0 = SDELIVERY.SOHNUM_0
			INNER JOIN SDELIVERYD ON SDELIVERY.SDHNUM_0 = SDELIVERYD.SDHNUM_0
			 WHERE  SORDER.INVSTA_0 <> 3 
			 AND SORDER.DLVSTA_0 <> 1 
			 AND SDELIVERY.CFMFLG_0 = 1  
			 AND NOT SDELIVERYD.ITMREF_0 LIKE 'ADDIT%' 
			 AND SORDER.BPCORD_0 ='".$sta["code"]."'";


$item ="";
$totallve = 0;
$resultx32 = odbc_exec($connectionodbcx3,$sqlX32);
$zdlv= array();

$dlv_go = 0;
$dlv_pl = 0;
$dlv_sp = 0;
while($rowx32 = odbc_fetch_array($resultx32)){
 $zdlv[] = $rowx32;
 //$item .=$rowx32["ITMREF_0"]." ";
 $totallve +=$rowx32["QTY_0"]*$rowx32["NETPRIATI_0"];

 	if (preg_match("#GAO#i", $rowx32["ITMREF_0"])||preg_match("#gao#i", $rowx32["ITMREF_0"])){
 		$dlv_go += $rowx32["QTY_0"];
 	}
 	if (preg_match("#PEL#i", $rowx32["ITMREF_0"])||preg_match("#pel#i", $rowx32["ITMREF_0"])){
 		$dlv_pl += $rowx32["QTY_0"];
 	}
 	if (preg_match("#SUC#i", $rowx32["ITMREF_0"])||preg_match("#suc#i", $rowx32["ITMREF_0"])){
 		$dlv_sp += $rowx32["QTY_0"];
 	}
}

$s3840="SELECT GACCENTRYD.SNS_0,GACCENTRYD.AMTLED_0,GACCENTRYD.SAC_0 FROM GACCENTRYD WHERE (GACCENTRYD.SAC_0 = 'C40' OR GACCENTRYD.SAC_0 = 'C38') AND GACCENTRYD.BPR_0='".$sta["code"]."'";

$result3840 = odbc_exec($connectionodbcx3,$s3840);
$c3840 = 0;
while($row3840 = odbc_fetch_array($result3840)){
	$c3840 +=$row3840["SNS_0"]*$row3840["AMTLED_0"];
}

 		$sqlx3 ="SELECT BPCUSTOMER.BPCNUM_0, BPCUSTOMER.BPCNAM_0, BPCUSTOMER.OSTAUZ_0, BPCUSTOMER.OSTCTL_0,BPCUSTMVT.ORDBPIATIC_0,
BPCUSTMVT.DLVOSTC_0, BPCUSTMVT.NIVDLVC_0, BPCUSTMVT.NPTINVC_0, BPCUSTMVT.BLCC_0
FROM BPCUSTOMER INNER JOIN BPCUSTMVT ON BPCUSTOMER.BPCNUM_0 = BPCUSTMVT.BPCNUM_0
WHERE BPCUSTOMER.BPCNUM_0='".$sta["code"]."';";

/*$sqlx3 ="SELECT BPCUSTOMER.BPCNUM_0, BPCUSTOMER.BPCNAM_0, BPCUSTOMER.OSTAUZ_0, BPCUSTOMER.OSTCTL_0,BPCUSTMVT.ORDBPIATIC_0,
BPCUSTMVT.DLVOSTC_0, BPCUSTMVT.NIVDLVC_0, BPCUSTMVT.NPTINVC_0, BPCUSTMVT.BLCC_0
FROM BPCUSTOMER INNER JOIN BPCUSTMVT ON BPCUSTOMER.BPCNUM_0 = BPCUSTMVT.BPCNUM_0
WHERE BPCUSTOMER.BPCNUM_0='4999004';";*/

$resultx3 = odbc_exec($connectionodbcx3,$sqlx3);

$rowx3 = odbc_fetch_array($resultx3);



$sqlX33 ="SELECT SORDER.SOHNUM_0, SDELIVERY.SDHNUM_0, SDELIVERYD.ITMREF_0,SDELIVERYD.DSPVOU_0,SORDER.DLVSTA_0,SDELIVERYD.QTY_0,SORDER.ORDINVATI_0,SDELIVERY.DLVDAT_0 FROM SORDER INNER JOIN SDELIVERY ON SORDER.SOHNUM_0 = SDELIVERY.SOHNUM_0
			INNER JOIN SDELIVERYD ON SDELIVERY.SDHNUM_0 = SDELIVERYD.SDHNUM_0
			 WHERE  SORDER.INVSTA_0 <> 3 
			 AND SDELIVERY.INVFLG_0 =1
			 AND SORDER.DLVSTA_0 <> 1 
			 AND SDELIVERY.CFMFLG_0 = 2
			 AND (SDELIVERYD.QTY_0-SDELIVERYD.RTNQTY_0)>0  
			 AND NOT SDELIVERYD.ITMREF_0 LIKE 'ADDIT%'
			 AND NOT SDELIVERYD.ITMREF_0 LIKE 'TP%' 
			 AND SORDER.BPCORD_0 ='".$sta["code"]."'";

$resultx33 = odbc_exec($connectionodbcx3,$sqlX33);
$zdlvv= array();
$current="";
$totaldlvv =0;

while($rowx33 = odbc_fetch_array($resultx33)){
 $zdlvv[] = $rowx33;
 if($current!=$rowx33["SOHNUM_0"]){
 						
		  				$current = $rowx33["SOHNUM_0"];
		  				$totaldlvv+=$rowx33["ORDINVATI_0"];
		  				
		  			}
}





//print_r($rowx3);
$er = $rowx3["ORDBPIATIC_0"]+$rowx3["DLVOSTC_0"]+$rowx3["BLCC_0"]+$rowx3["NPTINVC_0"]+$c3840+floatval($totaldlvv);
$ecart = $rowx3['OSTAUZ_0'] - $er;


		$sp = 0;
		$pl = 0;
		$go = 0;

		$smisp = 0;
		$smipl = 0;
		$smigo = 0;
		$smasp = 0;
		$smapl = 0;
		$smago = 0;

		$csp = 0;
		$cpl = 0;
		$cgo = 0;
		
 		foreach ($station_site as $ss) {
 			# code...
 		$tanks = DB::select("tank",array("*")," site_id=".$ss["site_id"]);

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
		            $cpl += $t["capacite"];
		        }
		        if (preg_match("#go#i", $t['label']))
		        {
		            $go+=$inventory['volume'];
		            $smigo += $t['seuil_min'];
		            $smago += $t["seuil_max"];
		            $cgo += $t["capacite"];
		        }
		        if (preg_match("#sp#i", $t['label']))
		        {
		            $sp+=$inventory['volume'];
		            $smisp += $t['seuil_min'];
		            $smasp += $t["seuil_max"];
		            $csp += $t["capacite"];
		        }
				//include "include/detail_etat.php";

		       //echo "<tr><td>".$t['collect']."</td></tr>";
				
				if(isset($_GET["date"])){

					$date = $_GET["date"];
					
				}else{
					$date = date("d/m/Y H:i:s");
				}
				$date_encode = urlencode ($date);
				};
		}			
 						}
}

if($sta["vente_pl"]!=0){
	$Autonomie_pl = (($dlv_pl+$pl)/$sta["vente_pl"]);
}else{

	$Autonomie_pl = "NA";
}

if($sta["vente_sp"]!=0){
							//echo number_format (round( (($dlv_sp+$sp)/$sta["vente_sp"]),2),2,",",".");
	$Autonomie_sp = (($dlv_sp+$sp)/$sta["vente_sp"]);
			}else{
	$Autonomie_sp = "NA";
			
			}
if($sta["vente_go"]!=0){
							//echo number_format (round( (($dlv_go+$go)/$sta["vente_go"]),2),2,",",".");

	$Autonomie_go = (($dlv_go+$go)/$sta["vente_go"]);
							}else{
	$Autonomie_go = "NA";
							}

$quantitysp = ($sp/$csp)*100;
$quantitygo = ($go/$cgo)*100;
$quantitypl = ($pl/$cpl)*100;



$sqlX31 ="SELECT * FROM SORDER INNER JOIN SORDERQ ON SORDER.SOHNUM_0 = SORDERQ.SOHNUM_0 
INNER JOIN ITMMASTER ON SORDERQ.ITMREF_0 = ITMMASTER.ITMREF_0 WHERE SORDER.ORDSTA_0 = 1 
																AND NOT ITMMASTER.ITMREF_0 LIKE 'TPX%'
																AND NOT ITMMASTER.ITMREF_0 LIKE 'ADDIT%'
																AND SORDER.BPCORD_0 ='".$sta["code"]."' 
																";
$zcmd= array();
$resultx31 = odbc_exec($connectionodbcx3,$sqlX31);


$cmd_go =0;
$cmd_pl =0;
$cmd_sp =0;
while($rowx31 = odbc_fetch_array($resultx31)){
 $zcmd[] = $rowx31;

	if (preg_match("#GAO#i", $rowx31["ITMREF_0"])||preg_match("#gao#i", $rowx31["ITMREF_0"])){
 		$cmd_go += $rowx31["QTY_0"];
 	}
 	if (preg_match("#PEL#i", $rowx31["ITMREF_0"])||preg_match("#pel#i", $rowx31["ITMREF_0"])){
 		$cmd_pl += $rowx31["QTY_0"];
 	}
 	if (preg_match("#SUC#i", $rowx31["ITMREF_0"])||preg_match("#suc#i", $rowx31["ITMREF_0"])){
 		$cmd_sp += $rowx31["QTY_0"];
 	}


}

$sqlnote  = "SELECT NOTE_0 FROM NOTE WHERE CODE_0='".$sta["code"]."'";
$resultnote = odbc_exec($connectionodbcx3,$sqlnote);
$note = odbc_fetch_array($resultnote);

$sqlpay = "SELECT PTE_0 FROM BPCUSTOMER WHERE BPCNUM_0='".$sta["code"]."'";
$resultpay = odbc_exec($connectionodbcx3,$sqlpay);
$pay = odbc_fetch_array($resultpay);



DB::insert("data",
	array("vente_sp","vente_go","vente_pl","stock_sp","stock_go","stock_pl","livraison_sp","livraison_go","livraison_pl","seuil_sp","seuil_go","seuil_pl","commande_sp","commande_go","commande_pl","encours","ecart","payement","note","commentaire","utilisateur_id","code"),
	array($sta["vente_sp"],$sta["vente_go"],$sta["vente_pl"],$sp,$go,$pl,$dlv_sp,$dlv_go,$dlv_pl,$smisp,$smigo,$smipl,$cmd_sp,$cmd_go,$cmd_pl,$er,$ecart,$pay["PTE_0"],utf8_encode($note["NOTE_0"]),valueof("commentaire"),$_SESSION["SESSION_id"],$sta["code"])		

	);
header("location:detail_station.php?code=".$sta["code"]."&&msg=1");
//include "include/detail_station.php";

//include "include/footer.php";
?>