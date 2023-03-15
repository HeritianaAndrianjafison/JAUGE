
<div class="col-lg-10 col-md-10 col-sm-10 col-xm-12">
<?php echo $nav;?>
<br>
 <form action="data.php" class="form-inline" method="POST">
 	
		  <div class="form-group">
		    <label for="email">Filtre:</label>
		    	<input type="text" class="form-control" name="filtre" value="<?php echo valueof("filtre");?>">
		  </div>
		  <div class="form-group">
		    <label for="email">Date début:</label>
		    	<input type="text" class="form-control date" name="date_deb" value="<?php echo valueof("date_deb");?>">
		  </div>
		  <div class="form-group">
		    <label for="email">Date fin:</label>
		    	<input type="text" class="form-control date" name="date_fin" value="<?php echo valueof("date_fin");?>">
		  </div>

		  <div class="form-group">
		    <label for="pwd">Enregistrer :</label>
		    <select class="form-control" >
			 <option value="export_data.php" onclick ="location = this.value;">Enregistrer tous</option>
			 <option value="export_data.php?date_debut=<?php echo $date_deb;?>&&date_fin=<?php echo $date_fin;?>&&filtre=<?php echo $filtre;?>" onclick ="location = this.value;">Enregistrer recherche</option>
			 <option value="export_data.php?c=<?php echo $c;?>&&f=<?php echo $f;?>" onclick ="location = this.value;">Enregistrer page</option>
			</select>
</div>
		  <div class="form-group">
		  		<button type="submit" class="btn btn-default">Chercher</button>
		  </div>
	
</form> 

  
<hr>
<br>
<h3>Données enregistrées</h3><br>
	<!--<div class="panel panel-default">
		  <div class="panel-heading">Liste des Stations</div>
		  <div class="panel-body">-->
		  	 <table class="table table-responsive table-striped">
				    <thead>
				      <tr>
				      	<th style="background-color: #3d0f2b;color:white;">Date</th>
				        <th style="background-color: #3d0f2b;color:white;">Utilisateur</th>
				        <th style="background-color: #3d0f2b;color:white;">Code station</th>
				        <th style="background-color: #3d0f2b;color:white;">Nom station</th>
				        <th style="background-color: yellow">Vente GO</th>
				        <th style="background-color: yellow">Stock GO</th>
				        <th style="background-color: yellow">Seuil GO</th>
				        <th style="background-color: yellow">Livraison GO</th>
				        <th style="background-color: yellow">Commande GO</th>
				        <th style="background-color: yellow">Autonomie GO</th>

				        <th style="background-color: green;color:white;">Vente SP</th>
				        <th style="background-color: green;color:white;">Stock SP</th>
				        <th style="background-color: green;color:white;">Seuil SP</th>
				        <th style="background-color: green;color:white;">Livraison SP</th>
				        <th style="background-color: green;color:white;">Commande SP</th>
				        <th style="background-color: green;color:white;">Autonomie SP</th>

				        <th style="background-color: red;color:white;">Vente PL</th>
				        <th style="background-color: red;color:white;">Stock PL</th>
				        <th style="background-color: red;color:white;">Seuil PL</th>
				        <th style="background-color: red;color:white;">Livraison PL</th> 
				        <th style="background-color: red;color:white;">Commande PL</th>
				        <th style="background-color: red;color:white;">Autonomie PL</th>

				        <th style="background-color: #3d0f2b;color:white;">Encours</th>
				        <th style="background-color: #3d0f2b;color:white;">Ecart</th>
				        <th style="background-color: #3d0f2b;color:white;">Commentaire</th>
				      </tr>
				    </thead>
				    <tbody>
				    	<?php foreach($list as $l){
				    		//print_r($l);
				    		extract($l);
				    		$user = getUser($utilisateur_id);
				    		
				    		?>
				      <tr>
				      	<td><?php echo $date;?></td>
				      	<td><?php echo $user["prenom"]." ".$user["nom"];?></td>
				      	<td><?php echo $code;?></td>
				      	<td><?php echo $nom;?></td>

				      	<td><?php echo $vente_go;?></td>
				      	<td><?php echo $stock_go;?></td>
				      	<td><?php echo $livraison_go;?></td>
				      	<td><?php echo $seuil_go;?></td>
				      	<td><?php echo $commande_go;?></td>
				      	<?php 
							$style = "";
							if($vente_go!=0){
								$ago = round( (($livraison_go+$stock_go)/$vente_go),2);
								if($ago<2){
									$style ="style='color:red;'";
								}
								$ago =  number_format ($ago,2,",",".");
								
							}else{
								$ago = "NA";
								$style ="style='color:red;'";
							}
							?>
				      	<td><?php echo $ago;?></td>

				        <td><?php echo $vente_sp;?></td>
				        <td><?php echo $stock_sp;?></td>
				        <td><?php echo $livraison_sp;?></td>
				        <td><?php echo $seuil_sp;?></td>
				        <td><?php echo $commande_sp;?></td>
				        <?php 
					$style = "";
					if($vente_sp!=0){
								$asp = round( (($livraison_sp+$stock_sp)/$vente_sp),2);
								if($asp<2){
									$style ="style='color:red;'";
								}
								$asp =  number_format ($asp,2,",",".");
								
							}else{
								$asp = "NA";
								$style ="style='color:red;'";
							}
							?>
						<td><?php echo $asp;?></td>
				        <td><?php echo $vente_pl;?></td>
				        <td><?php echo $stock_pl;?></td>
				        <td><?php echo $livraison_pl;?></td>
				        <td><?php echo $seuil_pl;?></td>
				        <td><?php echo $commande_pl;?></td>
				        <?php 
							$style = "";
							if($vente_pl!=0){
								$apl = round( (($livraison_pl+$stock_pl)/$vente_pl),2);
								if($apl<2){
									$style ="style='color:red;'";
								}
								$apl =  number_format ($apl,2,",",".");
								
							}else{
								$apl = "NA";
								$style ="style='color:red;'";
							}
							?>
						<td><?php echo $apl;?></td>

				        <td><?php echo $encours;?></td>
				        <td><?php echo $ecart;?></td>
				        <!--<td><?php echo $note;?></td>-->
				        <td><?php echo $commentaire;?></td>
				      </tr>
				     	<?php }?>
				    </tbody>
				  </table>
				  <!--
		  </div>	  
	</div>
</div>-->