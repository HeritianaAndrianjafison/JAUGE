<?php
include "config/config.php";
need_connexion();
need_admin();
$css = array("etat");
$js = array("etat","tableau_de_bord","pie");
include "include/header.php";
include "include/left.php";


$date = date("Y-m-d",time() - 60 * 60 * 24);

$data_deb =$date." 00:00:00";
$date_fin =$date." 23:59:59";
//echo $date;
//$utilisateur_connecter = DB::select("history",array("*")," activity>'$date' AND login IS NOT NULL");

//print_r(count($utilisateur_connecter));

$station = DB::select("station",array("*")," statut='1'");
$station_en_rupture_de_stock = 0;
$station_en_depassement = 0;
$station_connecter = 0;
$liste_station_en_rupture_de_stock = "";
$liste_station_en_depassement = "";
$list_station_connecter = "";
$station_a_probleme = 0;
foreach ($station as $sta) {
	# code...

if($sta['maintenance']==2){
$station_a_probleme++;
}
$history=DB::select("history",array("*")," activity>'$data_deb' AND activity<'$date_fin' AND id_user='".$sta['utilisateur_id']."'");
if(count($history)>0){
	$station_connecter += 1;
	$list_station_connecter .= "/".$sta["code"];
}


 		$sqlx3 ="SELECT BPCUSTOMER.BPCNUM_0, BPCUSTOMER.BPCNAM_0, BPCUSTOMER.OSTAUZ_0, BPCUSTOMER.OSTCTL_0,BPCUSTMVT.ORDBPIATIC_0,
BPCUSTMVT.DLVOSTC_0, BPCUSTMVT.NIVDLVC_0, BPCUSTMVT.NPTINVC_0, BPCUSTMVT.BLCC_0
FROM BPCUSTOMER INNER JOIN BPCUSTMVT ON BPCUSTOMER.BPCNUM_0 = BPCUSTMVT.BPCNUM_0
WHERE BPCUSTOMER.BPCNUM_0='".$sta["code"]."';";

$resultx3 = odbc_exec($connectionodbcx3,$sqlx3);

$rowx3 = odbc_fetch_array($resultx3);

$er = $rowx3["ORDBPIATIC_0"]+$rowx3["DLVOSTC_0"]+$rowx3["BLCC_0"]+$rowx3["NPTINVC_0"];
$ecart = $rowx3['OSTAUZ_0'] - $er;
if($ecart<0){
	$liste_station_en_depassement .= "/".$sta['code'];
	$station_en_depassement +=1;
}

$sp = 0;
$pl = 0;
$go = 0;

$smisp = $sta["seuil_min_sp"];
$smipl = $sta["seuil_min_pl"];
$smigo = $sta["seuil_min_go"];

$csp = 0;
$cpl = 0;
$cgo = 0;

	$site = DB::select("station_site",array("*")," station_code='".$sta['code']."'");

	foreach($site as $s){

			$tanks  = DB::select("tank",array("*"), "  site_id='".$s['site_id']."' AND collect='".$s['collect']."'");
			
			foreach($tanks as $t){
				$inventory = DB::select("inventory",array("*"), " tank_id='".$t['tank_id']."' AND collect='".$t['collect']."'");
				if(count($inventory)==0){
						continue;
					}
				$inventory = $inventory[0];
				if (preg_match("#pl#i", $t['label']))
		        {
		            $pl+=$inventory['volume'];
		            $cpl +=$t["capacite"];
		            
		        }
		        if (preg_match("#go#i", $t['label']))
		        {
		            $go+=$inventory['volume'];
		            $cgo +=$t["capacite"];
		            
		        }
		        if (preg_match("#sp#i", $t['label']))
		        {
		            $sp+=$inventory['volume'];
		            $csp +=$t["capacite"];
		            
		        }
			}
	}
	if($csp!=0&&$cpl!=0&&$cgo!=0){

		$pl_=$pl*100/$cpl;
		$go_=$go*100/$cgo;
		$sp_=$sp*100/$csp;
		if($pl_<$smipl||$go_<$smigo||$sp_<$smisp){
			$station_en_rupture_de_stock +=1;
			$liste_station_en_rupture_de_stock .="/".$sta['code'];
		}

	}
	
	
}
include "include/tableau_de_bord.php";
include "include/footer.php";
?>