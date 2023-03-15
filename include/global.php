<div class="col-lg-9 col-md-9 col-sm-12 col-xm-12">


<h3>Situation globale</h3>
<table class="table table-striped table-responsive">
	<tr>	
		<td>
			<form class="form-inline" action="global.php" method="POST">
 			
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
		  				<a href="global.php" class="btn btn-default">Tous</a>
		  		</div>
		  		
			</form> 
		</td>
		<td>
		</td>
	</tr>
</table>


<table class="table-striped table-bordered">
			<thead>
					<tr>
						<th colspan="2"></th>
						<th colspan="5" class="go"><center>&nbsp;Gas Oil</center></th>
						<th colspan="5" class="sp"><center>&nbsp;Sans plomb 95</center></th>
						<th colspan="5" class="pl"><center>&nbsp;Petrol</center></th>
						
						
						<th colspan="6">&nbsp;Situation compte</th>
					</tr>
				
			</thead>
			<tbody>
				<tr>
					<th >&nbsp;CODE</th>
					<th>&nbsp;NOM</th>
					<th class="sort go init" alt="8" orientation="1">&nbsp;Quantité&nbsp;<span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort go" alt="9" orientation="1">&nbsp;Capacité&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span> </th>
					<th class="sort go" alt="10" orientation="1">&nbsp;Seuil(%)&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span> </th>
					<th class="sort go" alt="11" orientation="1">&nbsp;Qté(%)&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort go" alt="15" orientation="1">&nbsp;Autonomie(J)&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort sp" alt="4" orientation="1">&nbsp;Quantité&nbsp;&nbsp;<span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort sp" alt="5" orientation="1">&nbsp;Capacité&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span> </th>
					<th class="sort sp" alt="6" orientation="1">&nbsp;Seuil(%)&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort sp" alt="7" orientation="1">&nbsp;Qté(%)&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort sp" alt="16" orientation="1">&nbsp;Autonomie(J)&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort pl"  alt="0" orientation="1">&nbsp;Quantité<span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort pl" alt="1" orientation="1">
						&nbsp;Capacité<span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort pl" alt="2" orientation="1">&nbsp;Seuil(%)&nbsp;&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort pl" alt="3" orientation="1">&nbsp;Qté(%)&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort pl" alt="17" orientation="1">&nbsp;Autonomie(J)&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					
					
					<th class="sort" alt="12" orientation="1">&nbsp;PLAFOND</th>
					<th class="sort" alt="13" orientation="1">&nbsp;ENCOURS</th>
					<th class="sort" alt="14" orientation="1">&nbsp;ECART<br>
						<span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th  alt="15">&nbsp;JTRAC</th>
					
					<th>&nbsp;DATE COLLECTE</th>
					<th></th>
					
				</tr>
<?php

	$i=0;
 	foreach ($list as $sta) {
 		# code...

 		$station_site = DB::select("station_site",array("*")," station_code='".$sta["code"]."'");
//print_r($rowx3);

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


		$sqlx3 ="SELECT BPCUSTOMER.BPCNUM_0, BPCUSTOMER.BPCNAM_0, BPCUSTOMER.OSTAUZ_0, BPCUSTOMER.OSTCTL_0,BPCUSTMVT.ORDBPIATIC_0,
BPCUSTMVT.DLVOSTC_0, BPCUSTMVT.NIVDLVC_0, BPCUSTMVT.NPTINVC_0, BPCUSTMVT.BLCC_0
FROM BPCUSTOMER INNER JOIN BPCUSTMVT ON BPCUSTOMER.BPCNUM_0 = BPCUSTMVT.BPCNUM_0
WHERE BPCUSTOMER.BPCNUM_0='".$sta["code"]."';";

$resultx3 = odbc_exec($connectionodbcx3,$sqlx3);

$rowx3 = odbc_fetch_array($resultx3);


$er = $rowx3["ORDBPIATIC_0"]+$rowx3["DLVOSTC_0"]+$rowx3["BLCC_0"]+$rowx3["NPTINVC_0"];
$ecart = $rowx3['OSTAUZ_0'] - $er;

		?>
		
		
		<tr class="sorter_ligne  l<?php echo $i;?>">
			<td  ><strong>&nbsp;<?php echo $sta["code"];?>&nbsp;</strong></td>
 			<td  >&nbsp;<?php echo $sta["intitule_court"];//explode(" ",$sta["nom"])[0];?></td>
 		
		<?php
		$i++;
		$style = "style='color:red;font-weight:bold'";
 		foreach ($station_site as $ss) {
 			# code...
 		

$sqlX32 ="SELECT SORDER.SOHNUM_0, SDELIVERY.SDHNUM_0,SDELIVERY.DLVDAT_0, SDELIVERYD.ITMREF_0,SORDER.DLVSTA_0,SDELIVERYD.QTY_0,SDELIVERYD.NETPRIATI_0 FROM SORDER INNER JOIN SDELIVERY ON SORDER.SOHNUM_0 = SDELIVERY.SOHNUM_0
			INNER JOIN SDELIVERYD ON SDELIVERY.SDHNUM_0 = SDELIVERYD.SDHNUM_0
			 WHERE  SORDER.INVSTA_0 <> 3 
			 AND SORDER.DLVSTA_0 <> 1 
			 AND SDELIVERY.CFMFLG_0 = 1  
			 AND NOT SDELIVERYD.ITMREF_0 LIKE 'ADDIT%' 
			 AND SORDER.BPCORD_0 ='".$sta["code"]."'";
$totallve = 0;
$resultx32 = odbc_exec($connectionodbcx3,$sqlX32);
$dlv_go = 0;
$dlv_pl = 0;
$dlv_sp = 0;
while($rowx32 = odbc_fetch_array($resultx32)){
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
 		$tanks = DB::select("tank",array("*")," site_id=".$ss["site_id"]." AND collect='".$ss["collect"]."'");

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



		?>
		
					<td class="text-right s8 lgo" value="<?php echo $go;?>">&nbsp;<?php echo number_format (round( $go,2),2,",",".");?>&nbsp;</td>
					<td class="text-right s9 lgo" value="<?php echo $cgo;?>">&nbsp;<?php echo $cgo;?>&nbsp;</td>
					<td class="text-right s10 lgo" value="<?php echo $sta["seuil_min_go"];?>">&nbsp;<?php echo number_format (round( $sta["seuil_min_go"],2),2,",",".");?>&nbsp;</td>
					<!--<td class="text-right"><?php echo number_format (round( $smago,2),2,",",".");?></td>-->
					
					<?php 
						$qpgo = 0;
						if($cgo!=0){
						$qpgo = ($go*100)/$cgo;
						}
					?>

					<td class="text-right s11 lgo" value="<?php echo $qpgo;?>" <?php if($sta["seuil_min_go"]>$qpgo){echo $style;}?> >
						&nbsp;<?php echo number_format (round( $qpgo,2),2,",",".");?>&nbsp;
					</td>

					<?php 
					if($sta["vente_go"]!=0){
								$ago = round( (($dlv_go+$go)/$sta["vente_go"]),2);
								$ago =  number_format ($ago,2,",",".");
							}else{
								$ago = 0;	
							}
							?>
					<td class="text-right s15 lgo" value="<?php echo $ago;?>" <?php if($ago<2){echo $style;}?> >
						&nbsp;<?php echo number_format (round( $ago,2),2,",",".");?>&nbsp;
					</td>
					<td class="text-right s4 lsp" value="<?php echo $sp;?>"><?php echo number_format (round( $sp,2),2,",",".");?>&nbsp;</td>
					<td class="text-right s5 lsp" value="<?php echo $csp;?>"><?php echo $csp;?>&nbsp;</td>
					<td class="text-right s6 lsp" value="<?php echo $sta["seuil_min_sp"];?>"><?php echo number_format (round( $sta["seuil_min_sp"],2),2,",",".");?>&nbsp;</td>
					<!--<td class="text-right"><?php echo number_format (round( $smasp,2),2,",",".");?></td>-->
					<?php 
						$qpsp = 0;
						if($csp!=0){
						$qpsp = ($sp*100)/$csp;}
					?>
					<td class="text-right s7 lsp" value="<?php echo $qpsp;?>" <?php if($sta["seuil_min_sp"]>$qpsp){echo $style;}?> >
						<?php echo number_format (round( $qpsp,2),2,",",".");?>
						&nbsp;</td>


					<?php 
					
					if($sta["vente_sp"]!=0){
								$asp = round( (($dlv_sp+$sp)/$sta["vente_sp"]),2);
								$asp =  number_format ($asp,2,",",".");
							}else{
								$asp = 0;
							}
							?>
					<td class="text-right s16 lsp" value="<?php echo $asp;?>" <?php if($asp<2){echo $style;}?> >
						<?php echo number_format (round( $asp,2),2,",",".");?>
						&nbsp;</td>
					<td class="text-right s0 lpl" value="<?php echo $pl;?>">&nbsp;<?php echo number_format (round( $pl,2),2,",",".");?>&nbsp;</td>
					<td class="text-right s1 lpl" value="<?php echo $cpl;?>">&nbsp;<?php echo $cpl;?>&nbsp;</td>
					<td class="text-right s2 lpl" value="<?php echo $sta["seuil_min_pl"];?>"><?php echo number_format (round( $sta["seuil_min_pl"],2),2,",",".") ;?>&nbsp;</td>
					<!--<td class="text-right"><?php echo number_format (round( $smapl,2),2,",",".") ;?></td>-->
					<?php 
						$qppl = 0;
						if($cpl!=0){
						$qppl = ($pl*100)/$cpl;}
					?>
					<td class="text-right s3 lpl" value="<?php echo $qppl;?>" <?php if($sta["seuil_min_pl"]>$qppl){echo $style;} ?>>
						<?php echo number_format (round( $qppl,2),2,",",".");?>
						&nbsp;
					</td>
					<?php 
					
					if($sta["vente_pl"]!=0){
								$apl = round( (($dlv_pl+$pl)/$sta["vente_pl"]),2);

								$apl =  number_format ($apl,2,",",".");
								
							}else{
								$apl = 0;
							}
							?>

					<td class="text-right s17 lpl" value="<?php echo $apl;?>" <?php if($apl<2){echo $style;} ?>>
						<?php echo number_format (round( $apl,2),2,",",".");?>
						&nbsp;
					</td>
					<td class="text-right s12" value="<?php echo $rowx3['OSTAUZ_0'];?>">&nbsp;<?php echo number_format (round( $rowx3['OSTAUZ_0'],2),2,",",".");?>&nbsp;</td>
					<td class="text-right s13" value="<?php echo $er;?>">&nbsp;<?php echo number_format (round( $er,2),2,",",".");?>&nbsp;</td>
					<td class="text-right s14" value="<?php echo $ecart;?>">&nbsp;<?php echo number_format (round( $ecart,2),2,",",".");?>&nbsp;</td>
					<td class="text-center" >
						
	<?php print_r(getCurl("http://192.168.130.9/jovenna/api/portail.php?action=jtrac_en_ouvert&&code=".$sta["code"]));?>
					</td>
					<td><?php echo date("d/m/Y-H:i:s");?>&nbsp;</td>
					<td><a href="detail_station.php?code=<?php echo $sta['code'];?>" class="btn btn-info btn-xs">Voir détail</a></td>
				</tr>
				
		
		<?php
 	}
 	?>
 			</tbody>
		</table>
<input type="hidden" id="ligne_number" value="<?php echo $i;?>"/>		
</div>