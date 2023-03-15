<?php
include "config/config.php";
need_connexion();
need_admin();
$css = array("etat");
$js = array("etat");
include "include/header.php";
include "include/left.php";
//include "include/login.php";

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
$n = DB::select("station",array("COUNT(*)")," statut = 1 AND $condition")[0]["COUNT(*)"];
$action = valueof("action");
if($action == null){
			
			$offset = 0;
			$c = 5;
			$r = $n%$c;
			$q = ($n-$r)/$c;
			if($r!=0){
				$q = $q+1;
			}

			$page=valueof("page");
			if(isset($page)){
				$offset = $page;
			}
			$f = $offset*$c;


 	$list = DB::select("station",array("*")," statut = 1 AND $condition Order by nom LIMIT $c OFFSET $f");


 	//$filtre = null;
 	

$nav="<ul class='pagination'><li><a href='cumul.php' >Début</a></li>";
			
				if($page-1>=0){
					$nav.="<li><a href='cumul.php?page=".($page-1)."&&filtre=$filtre&&region=$region' ><</a></li>";
				}
				
				for($i=$page-3;$i<$page+3;$i++){
					$p=$i+1;
					$class = "";
					if($i==$page){
					$class ="class='active'";
					}
					if($i<$q && $i>=0){
						$nav.="<li $class><a href='cumul.php?page=$i&&filtre=$filtre&&region=$region' >$p</a></li>";
					}
					
				}
				if($page+1<$q){
					$nav.="<li><a href='cumul.php?page=".($page+1)."&&filtre=$filtre&&region=$region' >></a></li>";
				}
				
			
			$nav.="</ul>";


			//onclick ='location = this.value;
			$region =  "<option value='".$region."' >".label_region($region)."</option>".liste_region();


?>
<div class="col-lg-10 col-md-10 col-sm-10 col-xm-12">

	<?php echo $nav;?>
<br>
<table class="table table-striped table-responsive">
	

	<tr>
		
		<td>
			<form class="form-inline" action="cumul.php" method="POST">
 			
		  		<div class="form-group">
		    		<label for="email">Station:</label>
		    			<input type="text" class="form-control" name="filtre" value="<?php echo valueof("filtre");?>" id="filtre">
		  		</div>
		  		<div class="form-group">
		    		<label for="pwd">Région :</label>
		    		<select class="form-control"  name="region">
			 				<?php echo $region;?>
					</select>
		  		</div>
		  		<div class="form-group">
		  				<button type="submit" class="btn btn-default">Chercher</button>
		  		</div>
		  		<div class="form-group">
		  				<a href="cumul.php" class="btn btn-default">Tous</a>
		  		</div>
			
			</form> 


		</td>
		<td>
			

		</td>
	</tr>
</table>



<table class="table table-striped table-responsive">
	<thead>
		
		<tr><th colspan=6>Station</th></tr>
	</thead>
	<tbody>

<?php

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

		?>

		<tr>
 			<td colspan=2 style="background-color: #3d0f2b;color: white"><strong><?php echo $sta["nom"];?></strong></td>
 			<th colspan=2 style="background-color: #3d0f2b;color: white">CODE :<?php echo $sta["code"];?></th>
 			<td style="background-color: #3d0f2b;color: white"></td>
 			<td style="background-color: #3d0f2b;color: white"></td>
 			
 		</tr>
		<?php
 		foreach ($station_site as $ss) {
 			# code...
 		
 		?>
 		
 		<?php
 		

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
		            $smasp += $t["seuil_max"];
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



		?>
<tr>
					<th>Produit</th>
					<th>Quantité</th>
					<th>Seuil min</th>
					<!--<th>Seuil max</th>-->
					<th>Autonomie</th>
					<th>Ecart sur encours</th>
					<th>Nb Jtrac</th>
				</tr>
				<tr>
					<td class="pl">PL</td>
					<td class="text-right lpl" <?php if($pl<=$smipl){ echo "style=color:red";}?>><?php echo number_format (round( $pl,2),2,",",".");?></td>
					<td class="text-right lpl"><?php echo number_format (round( $smipl,2),2,",",".") ;?></td>
					<!--<td class="text-right"><?php echo number_format (round( $smapl,2),2,",",".") ;?></td>-->
					<?php 
					$style = "";
					if($sta["vente_pl"]!=0){
								$apl = round( (($dlv_pl+$pl)/$sta["vente_pl"]),2);
								if($apl<2){
									$style ="style='color:red;'";
								}
								$apl =  number_format ($apl,2,",",".");
								
							}else{
								$apl = "NA";
								$style ="style='color:red;'";
							}
							?>
					<td class="text-right lpl" <?php echo $style;?> >
						
						<?php echo $apl;?>
					</td>
					<td class="text-center" rowspan="3" ><br><br><p ><?php echo number_format (round( $ecart,2),2,",",".");?></p></td>
					<td class="text-center" rowspan="3">
						<br><br>
	<?php print_r(getCurl("http://192.168.130.9/jovenna/api/portail.php?action=jtrac_en_ouvert&&code=".$sta["code"]));?>
					</td>
					
				</tr>
				<tr>
					<td class="sp">SP</td>
					<td class="text-right lsp" <?php if($sp<=$smisp){ echo "style=color:red";}?>><?php echo number_format (round( $sp,2),2,",",".");?></td>
					<td class="text-right lsp"><?php echo number_format (round( $smisp,2),2,",",".");?></td>
					<!--<td class="text-right"><?php echo number_format (round( $smasp,2),2,",",".");?></td>-->

					<?php 
					$style = "";
					if($sta["vente_sp"]!=0){
								$asp = round( (($dlv_sp+$sp)/$sta["vente_sp"]),2);
								if($asp<2){
									$style ="style='color:red;'";
								}
								$asp =  number_format ($asp,2,",",".");
								
							}else{
								$asp = "NA";
								$style ="style='color:red;'";
							}
							?>

					<td class="text-right lsp" <?php echo $style;?> >
						<?php 
								echo $asp;
					//echo ($dlv_sp+$sp);?></td>
					
					
				</tr>
				<tr>
					<td class="go">Go</td>
					<td class="text-right lgo" <?php if($go<=$smigo){ echo "style=color:red";}?> ><?php echo number_format (round( $go,2),2,",",".");?></td>
					<td class="text-right lgo"><?php echo number_format (round( $smigo,2),2,",",".");?></td>
					<!--<td class="text-right"><?php echo number_format (round( $smago,2),2,",",".");?></td>-->
					<?php 
					$style = "";
					if($sta["vente_go"]!=0){
								$ago = round( (($dlv_go+$go)/$sta["vente_go"]),2);
								if($ago<2){
									$style ="style='color:red;'";
								}
								$ago =  number_format ($ago,2,",",".");
								
							}else{
								$ago = "NA";
								$style ="style='color:red;'";
							}
							?>


					<td class="text-right lgo" <?php echo $style;?> >
					<?php 
								echo $ago;
					?></td>
					
					
				</tr>
				<tr><td></td>
					<td></td>
					<td></td>
					<!--<td></td>-->
					<td>Date</td>
					<td><?php echo date("d/m/Y H:i:s");?></td>
					<td><a href="detail_station.php?code=<?php echo $sta['code'];?>" class="btn btn-info btn-sm">Voir détail</a></td>
				</tr>

		<?php
 	}
 	?>
 			</tbody>
		</table>
	</div>
 	<?php


 	


	//$list = DB::select("utilisateur",array("*"));
/*
	$condition = 1;
	$filtre = valueof("filtre");
	if($filtre!=null){
		$users = DB::select("utilisateur",array("*")," nom like '%$filtre%' || prenom like '%$filtre%' || login like '%$filtre%'");
		//$condition ="";
		$condition = 0;
		foreach ($users as $u) {
			# code...
			$condition .=" OR id_user =".$u['id'];
		}
	}
	//echo $condition;
	$n = DB::select("history",array("COUNT(*)"), $condition)[0]["COUNT(*)"];
			//$list = DB::select("offre",array("*"));
	//print_r($n);
			$offset = 0;
			$c = 15;
			$r = $n%$c;
			$q = ($n-$r)/$c;
			if($r!=0){
				$q = $q+1;
			}

			$page=valueof("page");
			if(isset($page)){
				$offset = $page;
			}
			$f = $offset*$c;
			$list = DB::select("history",array("*"),"$condition Order by login DESC LIMIT $c OFFSET $f");


			$nav="<ul class='pagination'><li><a href='history.php' >Tous</a></li>";
			for($i=0;$i<$q;$i++){
				$p=$i+1;
				$class = "";
				if($i==$page){
				$class ="class='active'";
				}
				if($filtre==null){
					$nav.="<li $class><a href='history.php?page=$i' >$p</a></li>";
				}else{
					$nav.="<li $class><a href='history.php?page=$i&&filtre=".$filtre."' >$p</a></li>";
				}
				
			}
			$nav.="</ul>";

			*/
	//include "include/list_history.php";
}


include "include/footer.php";
?>