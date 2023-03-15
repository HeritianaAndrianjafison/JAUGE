<div class="col-lg-9 col-md-9 col-sm-10 col-xm-12">

	<div><center><h3>CODE :<?php echo $_GET['id']."/Station :".$station['nom'];?></h3><br>
		</center></div>
	<div class="panel panel-default">
		<div class="panel-heading"><h3>Encours</h3></div>
		<div class="panel-body">
		<table class="table table-striped">
		    <thead>
		    	<tr>
		        <td>Solde comptable</td>
		        <td class="text-right"><?php echo number_format (round($rowx3['BLCC_0'],2),2,",",".");?></td>    
		      </tr>
		      
		    </thead>
		    <tbody>
		      <tr>
		        <td><a href="#commande_en_cours">Commandes en cours</a></td>
		        <td class="text-right"><?php echo number_format (round($rowx3['ORDBPIATIC_0'],2),2,",",".");?></td>  
		      </tr>
		      <tr>
		        <td>Autre</td>
		        <td class="text-right"><?php echo number_format (round($c3840,2),2,",",".");?></td>  
		      </tr>
		      <tr>
		        <td><a href="#livraison_validee">Livraison validée</a></td>
		        <td class="text-right"><?php echo number_format (round($totaldlvv,2),2,",",".");?></td>  
		      </tr>
		      <tr>
		        <td><a href="#livraison_en_cours">Livraison en cours</a></td>
		        <td class="text-right"><?php echo number_format (round($rowx3['DLVOSTC_0'],2),2,",",".");?></td> 
		      </tr>
		      <tr>
		        <td><a href="#factures_non_validees">Factures non validées</a></td>
		        <td class="text-right"><?php echo number_format (round($rowx3['NPTINVC_0'],2),2,",",".");?></td> 
		      </tr>
		      <tr>
		        <td>Encours réel</td>
		        <td class="text-right"><?php echo number_format (round($er,2),2,",",".");?></td> 
		      </tr>
		      <tr>
		        <th>Plafond encours :</th>
		        <th class="text-right"><?php echo number_format (round($rowx3['OSTAUZ_0'],2),2,",",".");?></th> 
		      </tr>
		      <tr>
		        <td>Ecart</td>
		        <td class="text-right"><?php echo number_format (round($ecart,2),2,",",".");?></td> 
		      </tr>
		    </tbody>
		  </table>
		</div>

		</div>
			<hr>
			<h3>Solde comptable</h3>
			
					<table class="table table-striped table-responsive">
					<thead>
					    	<tr>
					    		<th>Date</th>
						        <th>Pièce</th>
						        <th>Echéance</th>
						        <th class="text-right">Libelles</th>
						        <th class="text-right">Montant</th>
						        <th></th>
						        
						            
					      	</tr>   
					</thead>
					    <tbody>

			<?php 
			$total=0;

			$cp = null;
				foreach ($lssc as $l) {
					# code...
					if($cp!=$l['NUM_0']){
					$cp = $l['NUM_0'];
					$total += $l['SNS_0']*$l['AMTCUR_0'];

					$d=strtotime($l['ACCDAT_0']);
								$d= date("d-m-Y", $d);
								$du=strtotime($l['DUDDAT_0']);
								$du= date("d-m-Y", $du);
					?>
							<tr>
								<td><?php echo $d;?></td>
								<td><?php echo $l['NUM_0'];?></td>
								<td><?php echo $du;?></td>
								<td><?php echo utf8_encode($l['DES_0']);?></td>
								<td class="text-right"><?php echo number_format (round($l['SNS_0']*$l['AMTCUR_0'],2),2,",",".");?></td>
								<td><?php echo $l['MTC_0'];?></td>
								
							</tr>
					<?php

					}
				}
			?>				<tr>
								<td></td><td></td><td></td><td></td>
								<td><?php echo number_format (round($total,2),2,",",".");?></td><td></td>
							</tr>
						</tbody>
					</table>
					
				
			<hr>
			<h3>Facture non réglée</h3>
			
					<table class="table table-striped table-responsive">
					    <thead>
					    	<tr>
						        <th>Facture</th>
						        <th class="text-right">Motant</th>
						        <th class="text-right">Motant Payer</th>
						        <th class="text-right">Reste à payer</th>
						        <th class="text-right">Echéance</th>
						        <th class="text-right">Status</th>    
					      </tr>
					      
					    </thead>
					    <tbody>
					    	<?php 
					    	$rap = 0;
					    	foreach($factnp as $f){

					    		$d=strtotime($f["DUDDAT_0"]);
								$d= date("d-m-Y", $d);
								$cd=date("Y-m-d") ;
								$rap += $f["AMTCUR_0"]-$f["PAYCUR_0"];
					    		?>
					      	<tr>
						      	<td class="text-right"><?php echo $f["NUM_0"]; ?></td>
						      	<td class="text-right"><?php echo number_format (round($f["AMTCUR_0"],2),2,",","."); ?></td>
						      	<td class="text-right"><?php echo number_format (round($f["PAYCUR_0"],2),2,",","."); ?></td>
						      	<td class="text-right"><?php echo number_format (round(($f["AMTCUR_0"]-$f["PAYCUR_0"]),2),2,",",".");; ?></td>
						      	<td class="text-right"><?php echo $d; ?></td>
						      	<td class="text-right"><?php if(strtotime($f["DUDDAT_0"])<time()){ echo "Echu";}else{echo "Non Echu";}; 

						      	?></td>
					      	</tr>
					      	<?php
					      		};?>
					    </tbody>
					    <tfoot>
					    	<tr>
					    		<td></td>
					    		<td></td>
					    		<td></td>
					    		<td><?php echo number_format (round($rap,2),2,",","."); ?></td>
					    		<td></td>
					    		<td></td>
					    	</tr>
					    </tfoot>
					</table>

			<h3>Avoir</h3>
			
					<table class="table table-striped table-responsive">
					    <thead>
					    	<tr>
						        <th>Facture</th>
						        <th class="text-right">Motant</th>
						        <th class="text-right">Motant Payer</th>
						        <th class="text-right">Reste à payer</th>
						        <th class="text-right">Echéance</th>
						        <th class="text-right">Status</th>    
					      </tr>
					      
					    </thead>
					    <tbody>
					    	<?php 
					    	$rap = 0;
					    	foreach($factav as $f){

					    		$d=strtotime($f["DUDDAT_0"]);
								$d= date("d-m-Y", $d);
								$cd=date("Y-m-d") ;
								$rap += $f["AMTCUR_0"]-$f["PAYCUR_0"];
					    		?>
					      	<tr>
						      	<td class="text-right"><?php echo $f["NUM_0"]; ?></td>
						      	<td class="text-right"><?php echo number_format (round($f["AMTCUR_0"],2),2,",","."); ?></td>
						      	<td class="text-right"><?php echo number_format (round($f["PAYCUR_0"],2),2,",","."); ?></td>
						      	<td class="text-right"><?php echo number_format (round(($f["AMTCUR_0"]-$f["PAYCUR_0"]),2),2,",",".");; ?></td>
						      	<td class="text-right"><?php echo $d; ?></td>
						      	<td class="text-right"><?php if(strtotime($f["DUDDAT_0"])<time()){ echo "Echu";}else{echo "Non Echu";}; 

						      	?></td>
					      	</tr>
					      	<?php
					      		};?>
					    </tbody>
					    <tfoot>
					    	<tr>
					    		<td></td>
					    		<td></td>
					    		<td></td>
					    		<td><?php echo number_format (round($rap,2),2,",","."); ?></td>
					    		<td></td>
					    		<td></td>
					    	</tr>
					    </tfoot>
					</table>


				
		  <hr>
		  <h3 id="commande_en_cours">Commande en cours</h3>
		
		  
		  <table class="table table-striped table-responsive">
		  <thead>
		      <tr>
		      	<th>DATE</th>
		      	<th>COMMANDE</th>
		      	<th>ARTICLE</th>
		      	<th>QTY</th>
		      	<th>MONTANT</th>
		      </tr>
		  </thead>	
		  <tbody>
		  <?php
		  $total =0;
		  $current="";
		  $new= false;
		  foreach($zcmd as $cmd){
		  	if($current!=$cmd['SOHNUM_0']){
		  		$current=$cmd['SOHNUM_0'];
		  		$total +=$cmd['ORDINVATI_0'];
		  		$new = true;
		  	}
		  	//$total +=$cmd["QTY_0"]*$cmd["NETPRIATI_0"];

		  	$d=strtotime($cmd['ORDDAT_0']);
			$d= date("d-m-Y", $d);
		  	?>
		  	
		  	  <tr><td><?php if($new){echo $d;}?></td>
		  	  	  <td><?php if($new){echo $cmd['SOHNUM_0'];}?></td>
		  	  	  <td><?php echo $cmd['ITMREF_0']?></td>
		  	  	  <td class="text-right"><?php echo  number_format (round($cmd['QTY_0'],2),2,",",".");?></td>
		  	  	  <td class="text-right"><?php if($new){echo  number_format (round($cmd['ORDINVATI_0'],2),2,",",".");$new = false;}?></td>
		  	  	</tr>
		  	<?php
		  }
		  ?>
		 	<tr>	  
		  		<td>Total</td>
		  	  	  <td></td>
		  	  	  <td></td>
		  	  	  <td class="text-right"></td>
		  	  	  <td class="text-right"><?php echo  number_format (round($total,2),2,",",".")?></td>
		  	 </tr>
		  </tbody>
		</table>
			
		<hr>
		<h3 id="livraison_en_cours">Livraison en cours</h3>
		
		
		  <table class="table table-striped table-responsive">
		  <thead>
		      <tr>
		      	<th>DATE</th>
		      	<th>NUMERO</th>
		      	<th>ARTICLE</th>
		      	<th>STATUT</th>
		      	<th>VOLUME</th>
		      	<th>MONTANT</th>
		      </tr>
		  </thead>	
		  <tbody>
		  	<?php 
		  	$total = 0;
		  		foreach($zdlv as $dlv){
		  			$m = $dlv["QTY_0"]*$dlv["NETPRIATI_0"];
		  			$total+=$m;
		  			$d=strtotime($dlv["DLVDAT_0"]);
					$d= date("d-m-Y", $d);
		  			?>
		  			<tr>
		  				<td><?php echo $d; ?></td>
		  				<td><?php echo $dlv["SDHNUM_0"]; ?></td>
		  				<td><?php echo $dlv["ITMREF_0"]; ?></td>
		  				<td><?php if($dlv["DLVSTA_0"] ==2){echo "Partiel livré";}else{echo "Total livré";}?></td>
		  				<td class="text-right"><?php echo number_format (round($dlv["QTY_0"],2),2,",",".") ; ?></td>
		  				<td class="text-right"><?php echo number_format (round($m,2),2,",",".") ; ?></td>
		  			</tr>
		  		<?php

		  		}
		  	?>
		  	<tr>	  
		  		<td>Total</td>
		  	  	  <td></td>
		  	  	  <td></td>
		  	  	  <td></td>
		  	  	  <td class="text-right"></td>
		  	  	  <td class="text-right"><?php echo  number_format (round($total,2),2,",",".")?></td>
		  	 </tr>
		  </tbody>
		</table>
			
		<hr>
		<h3 id="livraison_validee">Livraison validée</h3>
		
		
		  <table class="table table-striped table-responsive">
		  <thead>
		      <tr>
		      	<th>DATE</th>
		      	<th>NUMERO</th>
		      	<th>ARTICLE</th>
		      	<th>STATUT</th>
		      	<th>VOLUME</th>
		      	<th>MONTANT</th>
		      </tr>
		  </thead>	
		  <tbody>
		  	<?php 
		  		$total = 0;
		  		$current="";
		  		$new= false;
		  		foreach($zdlvv as $dlv){
		  			//$m = $dlv["NETPRIATI_0"];
		  			if($current!=$dlv["SOHNUM_0"]){
		  				$current = $dlv["SOHNUM_0"];
		  				$total+=$dlv["DLVATI_0"];
		  				$new = true;
		  			}

		  			?>
		  			<tr>	
		  				<td><?php if($new){ echo $dlv["DLVDAT_0"]; }?></td>
		  				<td><?php if($new){ echo $dlv["SDHNUM_0"]; }?></td>
		  				<td><?php echo $dlv["ITMREF_0"]; ?></td>
		  				<td><?php if($dlv["DLVSTA_0"] ==2){echo "Partiel livré";}else{echo "Total livré";}?></td>
		  				<td class="text-right"><?php echo number_format (round($dlv["QTY_0"],2),2,",",".") ; ?></td>
		  <td class="text-right"><?php  if($new){echo number_format (round($dlv["DLVATI_0"],2),2,",","."); $new=false;} ?></td>
		  			</tr>
		  		<?php
		  		}
		  	?>
		  	<tr>	  
		  		<td>Total</td>
		  	  	  <td></td>
		  	  	  <td></td>
		  	  	  <td></td>
		  	  	  <td class="text-right"></td>
		  	  	  <td class="text-right"><?php echo  number_format (round($total,2),2,",",".")?></td>
		  	 </tr>
		  </tbody>
		</table>
			
		<hr>
		<h3 id="factures_non_validees">Facture non validée</h3>
		
		
		  <table class="table table-striped table-responsive">
		  <thead>
		      <tr>
		      	<th>DATE</th>
		      	<th>NUMERO</th>
		      	<th>ARTICLE</th>
		      	<th>STATUT</th>
		      	<th>VOLUME</th>
		      	<th>MONTANT</th>
		      </tr>
		  </thead>	
		  <tbody>
		  	<?php 
		  	$total = 0;
		  	$current = "";
		  		foreach($zfact as $fact){
		  			
		  			if($current != $fact["NUM_0"]) { $total += $fact["AMTATI_0"]; }
		  			?>
		  			<tr>	
		  				<td><?php if($current != $fact["NUM_0"]) {
		  					$d=strtotime($fact["ACCDAT_0"]);
							$d= date("d-m-Y", $d);
		  					echo $d; }?></td>
		  				<td><?php if($current != $fact["NUM_0"]) {echo $fact["NUM_0"]; }?></td>
		  				<td><?php echo $fact["ITMREF_0"]; ?></td>
		  				<td><?php if($fact["STA_0"] ==1){echo "Non imprimé";}else{echo "Imprimé";}?></td>
		  				<td class="text-right"><?php echo number_format (round($fact["QTY_0"],2),2,",",".") ; ?></td>
		  				<td class="text-right"><?php if($current != $fact["NUM_0"]) {echo number_format (round($fact["AMTATI_0"],2),2,",",".") ; }?></td>
		  			</tr>
		  		<?php
		  		$current = $fact["NUM_0"];
		  		}
		  	?>
		  	<tr>	  
		  		  <td>Total</td>
		  	  	  <td></td>
		  	  	  <td></td>
		  	  	  <td></td>
		  	  	  <td class="text-right"></td>
		  	  	  <td class="text-right"><?php echo  number_format (round($total,2),2,",",".")?></td>
		  	 </tr>
		  </tbody>
		</table>
	
<div class="alert alert-warning">
<h4 class="alert-link"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><em>Cet état n'est donné qu'à titre indicatif, provisoire et ne saurait en aucun cas engager la responsabité de Jovena.</em></h4>
</div>
</div>