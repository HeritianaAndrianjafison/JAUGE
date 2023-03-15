<div class="col-lg-9 col-md-9 col-sm-12 col-xm-12">
 
 <h3>Station en rupture</h3><br>
<table class="table-striped table-bordered">
			<thead>
					<tr>
						<th colspan="2"></th>
						<th colspan="5" class="go"><center>GAS OIL</center></th>
						<th colspan="5" class="sp"><center>SANS PLANS 95</center></th>
						<th colspan="5" class="pl"><center>PL</center></th>
						
						
						<th colspan="2">&nbsp;Situation compte</th>
					</tr>
			</thead>
			<tbody>
			<tr>
					<th >&nbsp;CODE</th>
					<th>&nbsp;NOM</th>
					<th class="sort go init" alt="0" orientation="1">&nbsp;Quantité<span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort go" alt="1" orientation="1">&nbsp;Capacité<br><span class="indice glyphicon glyphicon-triangle-bottom"></span> </th>
					<th class="sort go" alt="2" orientation="1">&nbsp;Seuil(%)<br><span class="indice glyphicon glyphicon-triangle-bottom"></span> </th>
					<th class="sort go" alt="3" orientation="1">&nbsp;Seuil(L)<br><span class="indice glyphicon glyphicon-triangle-bottom"></span> </th>
					<th class="sort go" alt="4" orientation="1">&nbsp;Qté(%)<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort sp" alt="5" orientation="1">&nbsp;Quantité<span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort sp" alt="6" orientation="1">&nbsp;Capacité<br><span class="indice glyphicon glyphicon-triangle-bottom"></span> </th>
					<th class="sort sp" alt="7" orientation="1">&nbsp;Seuil(%)<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort sp" alt="8" orientation="1">&nbsp;Seuil(L)<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort sp" alt="9" orientation="1">&nbsp;Qté(%)<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort pl" alt="10" orientation="1">&nbsp;Quantité<span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort pl" alt="11" orientation="1">
						Capacité<span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort pl" alt="12" orientation="1">&nbsp;Seuil(%)<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort pl" alt="13" orientation="1">&nbsp;Seuil(L)<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort pl" alt="14" orientation="1">&nbsp;Qté(%)<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					
					
					<th>&nbsp;DATE</th>
					<th></th>
					
				</tr>

<?php
$i = 0;
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

		$style = "style='color:red;font-weight:bold'";
 		foreach ($station_site as $ss) {
 			# code...
 		
 		?>
 		
 		<?php
 		

 		$tanks = DB::select("tank",array("*")," site_id=".$ss["site_id"]." AND collect='".$ss['collect']."'");

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
		
				<tr class="l<?php echo $i;?>">
					<td>&nbsp;<?php echo $sta["code"];?>&nbsp;</td>
					<td>&nbsp;<?php echo $sta["intitule_court"];?></td>
					<td class="text-right lgo s0"  value="<?php echo $go;?>"><?php echo number_format (round( $go,2),2,",",".");?>&nbsp;</td>
					<td class="text-right lgo s1" value="<?php echo $cgo;?>"><?php echo $cgo;?>&nbsp;</td>
					<td class="text-right lgo s2" value="<?php echo $sta['seuil_min_go'];?>"><?php echo number_format (round( $sta["seuil_min_go"],2),2,",",".");?>&nbsp;</td>
					<td class="text-right lgo s3" value="<?php echo  $sta['seuil_min_go']*$cgo/100;?>"><?php echo number_format (round( $sta["seuil_min_go"]*$cgo/100,2),2,",",".");?>&nbsp;</td>
					<!--<td class="text-right"><?php echo number_format (round( $smago,2),2,",",".");?></td>-->
					
					<?php 
						$qpgo = 0;
						if($cgo!=0){
						$qpgo = ($go*100)/$cgo;
						}
					?>

					<td class="text-right lgo s4" value="<?php echo $qpgo;?>" <?php if($sta["seuil_min_go"]>$qpgo){echo $style;}?> >
						<?php echo number_format (round( $qpgo,2),2,",",".");?>&nbsp;
					</td>
					<td class="text-right lsp s5" value="<?php echo $sp;?>"><?php echo number_format (round( $sp,2),2,",",".");?>&nbsp;</td>
					<td class="text-right lsp s6" value="<?php echo $csp;?>"><?php echo $csp;?>&nbsp;</td>
					<td class="text-right lsp s7" value="<?php echo $sta["seuil_min_sp"];?>"><?php echo number_format (round( $sta["seuil_min_sp"],2),2,",",".");?>&nbsp;</td>
					<td class="text-right lsp s8" value="<?php echo $sta["seuil_min_sp"]*$csp/100;?>"><?php echo number_format (round( $sta["seuil_min_sp"]*$csp/100,2),2,",",".");?>&nbsp;</td>
					<!--<td class="text-right"><?php echo number_format (round( $smasp,2),2,",",".");?></td>-->
					<?php 
						$qpsp = 0;
						if($csp!=0){
						$qpsp = ($sp*100)/$csp;}
					?>
					<td class="text-right lsp s9" value="<?php echo $qpsp;?>" <?php if($sta["seuil_min_sp"]>$qpsp){echo $style;}?> >
						<?php echo number_format (round( $qpsp,2),2,",",".");?>&nbsp;
					</td>
					<td class="text-right lpl s10" value="<?php echo $pl;?>"><?php echo number_format (round( $pl,2),2,",",".");?>&nbsp;</td>
					<td class="text-right lpl s11" value="<?php echo $cpl;?>"><?php echo $cpl;?>&nbsp;</td>
					<td class="text-right lpl s12" value="<?php echo $sta["seuil_min_pl"];?>"><?php echo number_format (round( $sta["seuil_min_pl"],2),2,",",".") ;?>&nbsp;</td>
					<td class="text-right lpl s13">&nbsp;<?php echo number_format (round( $sta["seuil_min_pl"]*$cpl/100,2),2,",",".") ;?>&nbsp;</td>
					<!--<td class="text-right"><?php echo number_format (round( $smapl,2),2,",",".") ;?></td>-->
					<?php 
					$i++;
						$qppl = 0;
						if($cpl!=0){
						$qppl = ($pl*100)/$cpl;}
					?>
					<td class="text-right lpl s14" value="<?php echo $qppl;?>" <?php if($sta["seuil_min_pl"]>$qppl){echo $style;} ?>>
						<?php echo number_format (round( $qppl,2),2,",",".");?>
						&nbsp;
					</td>
					
					
					
					
					<td>&nbsp;<?php echo date("d/m/Y-H:i:s");?>&nbsp;</td>
					<td><a href="detail_station.php?code=<?php echo $sta['code'];?>" class="btn btn-info btn-sm">Voir détail</a></td>
				</tr>
				
		
		<?php
 	}
 	?>
 	</tbody>
</table>
<input type="hidden" id="ligne_number" value="<?php echo $i;?>"/>		
</div>