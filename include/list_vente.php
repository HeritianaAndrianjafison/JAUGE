
<div class="col-lg-10 col-md-10 col-sm-10 col-xm-12">
<?php if($_SESSION["SESSION_type"]==1||$_SESSION["SESSION_type"]==3){?>
<?php echo $nav;?>
<br>
 <form class="form-inline" action="vente.php" method="POST">
 	
		  <div class="form-group">
		    <label for="email">Filtre:</label>
		    	<input type="hidden" name="action" value="vente_journaliere">
		    	<input type="text" class="form-control date" name="date" value="<?php echo valueof("date");?>" id="filtre">
		  </div>
		  <div class="form-group">
		    		<label for="pwd">Région :</label>
		    		<select class="form-control"  name="region">
			 				<?php echo "<option value='".valueof('region')."' >".label_region(valueof('region'))."</option>".$region;?>
					</select>
		  </div>
		  <div class="form-group">
		  		<button type="submit" class="btn btn-default">Chercher</button>
		  </div>
		  
	
</form> 
<hr>
<?php }?>

<h3>Liste des Stations</h3>
	<!--<div class="panel panel-default">
		  <div class="panel-heading">Liste des Stations</div>
		  <div class="panel-body">-->
		  	 <table class="table table-responsive table-striped">
				    <thead>
				      <tr>
				        <th>CODE</th>
				        <th>NOM</th>
				        <th>Gérant</th>
				        <th>Vente GO</th>
				        <th>Livraison Go</th>
				        <th>Vente SP</th>
				        <th>Livraison SP</th>
				        <th>Vente PL</th>
				        <th>Livraison PL</th>
				      </tr>
				    </thead>
				    <tbody>
				    	<?php foreach($list as $l){
				    		extract($l);
				    		$user = getUser($utilisateur_id);
				    		$sites = DB::select("station_site",array("*"),"station_code='$code'");
				    		?>
				      <tr>
				      	<td><?php echo $code;?></td>
				        <td><?php echo $nom;?></td>
				        <td><?php echo $user['prenom']." ".$user['nom'];?></td>
				        
				        <td><?php echo $l["v_go"]; ?></td>
				        <td><?php echo $l["dlv_go"]; ?></td>
				        <td><?php echo $l["v_sp"]; ?></td>
				        <td><?php echo $l["dlv_sp"]; ?></td>
				        <td><?php echo $l["v_pl"]; ?></td>
				        <td><?php echo $l["dlv_pl"]; ?></td>
				      </tr>
				     	<?php }?>
				    </tbody>
				  </table>
				  <!--
		  </div>	  
	</div>
</div>-->