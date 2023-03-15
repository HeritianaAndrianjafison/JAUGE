
<div class="col-lg-10 col-md-10 col-sm-10 col-xm-12">
<?php echo $nav;?>

<br>
 <form class="form-inline" action="stations.php" method="POST">
 	
		  <div class="form-group">
		    <label for="email">Filtre:</label>
		    	<input type="text" class="form-control" name="filtre" value="<?php if(isset($filtre)){echo $filtre;}?>" id="filtre">
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
		  
	
</form> 
<hr>

	<div class="panel panel-default">
		  <div class="panel-heading">Liste des Stations</div>
		  <div class="panel-body">
		  	 <table class="table table-striped">
				    <thead>
				      <tr>
				        <th>CODE</th>
				        <th>NOM</th>
				        <th>Gérant</th>
				        <th>Site</th>
				        
				        <th>Statut</th>
				      </tr>
				    </thead>
				    <tbody>
				    	<?php foreach($list as $l){
				    		extract($l);
				    		$user = getUser($utilisateur_id);
				    		$sites = DB::select("station_site",array("*")," station_code='".$code."'");
				    		?>
				    	
				      <tr>
				      	<td><a href="stations.php?action=update&&id=<?php echo $code;?>"><?php echo $code;?></a></td>
				        <td><?php echo $nom;?></td>
				        <td><?php echo $user['prenom']." ".$user['nom'];?></td>
				        <td><a href="station_site.php?code=<?php echo $code;?>">Configuration <strong> <?php if(count($sites)==0){echo "K.O";}else {echo "O.K";};?></strong></a></td>

				        <td><?php if($statut==1){echo "Activé";}else{echo "Désactivé";}?></td>
				      </tr>
				     	<?php }?>
				    </tbody>
				  </table>

		  </div>
		  <div class="panel-footer"><a class="btn btn-default" href="stations.php?action=new"> Nouveau</a></div>
	</div>

</div>