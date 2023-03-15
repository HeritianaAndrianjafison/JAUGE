<div class="col-lg-9 col-md-9 col-sm-12 col-xm-12">
 
<h3>Situation global stock</h3>
<table class="table table-striped table-responsive">
	<tr>	
		<td>
			<form class="form-inline" action="globalstock.php" method="POST">
 			
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
		  				<a href="globalstock.php" class="btn btn-default">Tous</a>
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
						<th colspan="4" class="go"><center>&nbsp;Gas Oil</center></th>
						<th colspan="4" class="sp"><center>&nbsp;Sans plomb</center></th>
						<th colspan="4" class="pl"><center>&nbsp;Pétrol</center></th>
						<th colspan="3">&nbsp;Situation compte</th>
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
					<th class="sort sp" alt="4" orientation="1">&nbsp;Quantité&nbsp;<span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort sp" alt="5" orientation="1">&nbsp;Capacité&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span> </th>
					<th class="sort sp" alt="6" orientation="1">&nbsp;Seuil(%)&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort sp" alt="7" orientation="1">&nbsp;Qté(%)&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort pl"  alt="0" orientation="1">&nbsp;Quantité<span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort pl" alt="1" orientation="1">
						&nbsp;Capacité<span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort pl" alt="2" orientation="1">&nbsp;Seuil(%)&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					<th class="sort pl" alt="3" orientation="1">&nbsp;Qté(%)&nbsp;<br><span class="indice glyphicon glyphicon-triangle-bottom"></span></th>
					
					
					
					<th>&nbsp;DATE&nbsp;</th>
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

		?>
		
		
		<tr class="sorter_ligne  l<?php echo $i;?>">
			<td  ><strong>&nbsp;<?php echo $sta["code"];?>&nbsp;</strong></td>
 			<td  >&nbsp;<?php echo explode(" ",$sta["nom"])[0];?>&nbsp;</td>
 		
		<?php
		$i++;
		$style = "style='color:red;font-weight:bold'";
 		foreach ($station_site as $ss) {
 			# code...
 		
 		?>
 		
 		<?php
 		

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
		
					<td class="text-right s8 lgo" value="<?php echo $go;?>"><?php echo number_format (round( $go,2),2,",",".");?>&nbsp;</td>
					<td class="text-right s9 lgo" value="<?php echo $cgo;?>"><?php echo $cgo;?>&nbsp;</td>
					<td class="text-right s10 lgo" value="<?php echo $sta["seuil_min_go"];?>"><?php echo number_format (round( $sta["seuil_min_go"],2),2,",",".");?>&nbsp;</td>
					<!--<td class="text-right"><?php echo number_format (round( $smago,2),2,",",".");?></td>-->
					
					<?php 
						$qpgo = 0;
						if($cgo!=0){
						$qpgo = ($go*100)/$cgo;
						}
					?>

					<td class="text-right s11 lgo" value="<?php echo $qpgo;?>" <?php if($sta["seuil_min_go"]>$qpgo){echo $style;}?> >
						<?php echo number_format (round( $qpgo,2),2,",",".");?>&nbsp;
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

					<td class="text-right s0 lpl" value="<?php echo $pl;?>"><?php echo number_format (round( $pl,2),2,",",".");?>&nbsp;</td>
					<td class="text-right s1 lpl" value="<?php echo $cpl;?>"><?php echo $cpl;?>&nbsp;</td>
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
					
					
					
				
					
					
					
					
					<td><?php echo date("d/m/Y-H:i:s");?></td>
					<td><a href="detail_station.php?code=<?php echo $sta['code'];?>" class="btn btn-info btn-xs">Voir détail</a></td>
				</tr>
				
		
		<?php
 	}
 	?>
 			</tbody>
		</table>
<input type="hidden" id="ligne_number" value="<?php echo $i;?>"/>		
</div>