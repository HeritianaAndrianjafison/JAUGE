
<div class="col-lg-10 col-md-10 col-sm-10 col-xm-12">
<?php if($_SESSION["SESSION_type"]==1||$_SESSION["SESSION_type"]==3){?>
<?php echo $nav;?>
<br>
 <form class="form-inline" action="jauges.php" method="POST">
 	
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
				        <th>Jauge</th>
				        
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
				        <td><!--<a class="loading" href="etats.php?action=detail&&id=<?php echo $code;?>">Jauge</a><?php?>-->

				        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" 
				        data-target="#myModal<?php echo $code;?>">JAUGE
				        </button>
				        <div id="myModal<?php echo $code;?>" class="modal fade" role="dialog">
						  <div class="modal-dialog">

						    <!-- Modal content-->
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Choix site</h4>
						      </div>
						      <div class="modal-body">
						        	<ul class="list-group">
		  								
								        <?php
								        	if(count($sites)>0){
								        	foreach($sites as $s){
								        	?>
								        	<li class="list-group-item">
								    		<a href="etats.php?action=detail&site_id=<?php echo $s['site_id']?>&id=<?php echo $code;?>&collect=<?php echo $s['collect']?>"><?php echo $s["description"];?>
								    		</a>
								    		</li>
								        	<?php
								        	}
								        }else{
								        	echo "Il parait que la station n'a pas était configurée, veuiller contacté l'équipe de la DSI jovena pour resoudre le problème!";
								        }
								        ;?>
						    		</ul>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
						      </div>
						    </div>

  						</div>
						         
				    	</td>
				        
				      </tr>
				     	<?php }?>
				    </tbody>
				  </table>
				  <!--
		  </div>	  
	</div>
</div>-->