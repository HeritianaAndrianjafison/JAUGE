
<div class="col-lg-10 col-md-10 col-sm-10 col-xm-12">
<?php echo $nav;?>
<br>
<form action="history.php" class="form-inline" method="POST">
 	
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
		  		<button type="submit" class="btn btn-default">Chercher</button>
		  </div>
	
</form> 
<hr>
<h3>Historique login</h3>
	<!--<div class="panel panel-default">
		  <div class="panel-heading">Liste des Stations</div>
		  <div class="panel-body">-->
		  	 <table class="table table-responsive table-striped">
				    <thead>
				      <tr>
				        <th>User</th>
				        <th>Identifiant</th>
				        <th>Login</th>
				       <!-- <th>Activité</th>-->
				       
				        <th>Logout</th>
				      </tr>
				    </thead>
				    <tbody>
				    	<?php foreach($list as $l){
				    		//print_r($l);
				    		extract($l);
				    		$user = getUser($id_user);
				    		
				    		?>
				      <tr>
				      	<td><?php echo $user["prenom"]." ".$user["nom"];?></td>
				      	<td><?php echo $user["login"];?></td>
				        <td><?php echo $login;?></td>
				        <!--<td><?php echo $activity;?></td>-->
				        <td><?php echo $logout;?></td>
				      </tr>
				     	<?php }?>
				     <tr><td colspan="4"><a href="phistory.php" class="btn btn-default">Télécharger</a></td></tr>
				    </tbody>
				  </table>
				  <!--
		  </div>	  
	</div>
</div>-->