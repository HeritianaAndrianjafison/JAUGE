
<div class="col-lg-10 col-md-10 col-sm-10 col-xm-12">
<?php echo $nav;?>
<br>
 <form action="ca.php" method="POST">
 	<div class="col-xs-3">
		  <div class="form-group">
		    <label for="email">Filtre:</label>
		    	<input type="text" class="form-control" name="filtre" value="<?php if(isset($filtre)){echo $filtre;}?>" id="filtre">
		  </div>
		  <div class="form-group">
		  		<button type="submit" class="btn btn-default">Chercher</button>
		  </div>
	</div>
</form> 
<br><br><br><br>
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
				        <th>C.A</th>
				        
				      </tr>
				    </thead>
				    <tbody>
				    	<?php foreach($list as $l){
				    		extract($l);
				    		$user = getUser($utilisateur_id);
				    		$sites = DB::select("station_site",array("*"),"station_code='$code'");
				    		//if($id_station_inspection!=''){
				    		?>
				      <tr>
				      	<td><?php echo $code;?></td>
				        <td><?php echo $nom;?></td>
				        <td><?php echo $user['prenom']." ".$user['nom'];?></td>
				        <td>
						    <a href="ca.php?action=detail&id_station_inspection=<?php echo $id_station_inspection;?>">Détail</a>     
				    	</td>
				        
				      </tr>
				     	<?php 
				     	//}

				     }?>
				    </tbody>
				  </table>
				  <!--
		  </div>	  
	</div>
</div>-->