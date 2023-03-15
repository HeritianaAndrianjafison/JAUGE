
<div class="col-lg-10 col-md-10 col-sm-10 col-xm-12">
<?php echo $nav;?>
<br>
	<form action="users.php" method="POST">
 	<div class="col-xs-3">
		  <div class="form-group">
		    <label for="email">Filtre:</label>
		    	<input type="text" class="form-control" name="filtre" value="<?php if(isset($filtre)){echo $filtre;}?>" id="filtre">
		  </div>
		  <div class="form-group">
		  		<button type="submit" class="btn btn-default">Submit</button>
		  </div>
	</div>
</form> 
<br><br><br><br><br><br><br>
	<div class="panel panel-default">
		  <div class="panel-heading">Liste des utilisateurs</div>
		  <div class="panel-body">
		  	 <table class="table table-striped">
				    <thead>
				      <tr>
				        <th>Login</th>
				        <th>Prenom</th>
				        <th>Nom</th>
				        <th>Role</th>
				      </tr>
				    </thead>
				    <tbody>
				    	<?php foreach($list as $l){
				    		extract($l);
				    		?>
				    	
				      <tr>
				      	<td><a href="users.php?action=update&&id=<?php echo $id;?>"><?php echo $login;?></a></td>
				        <td><?php echo $prenom;?></td>
				        <td><?php echo $nom;?></td>
				        <td><?php if($type==1){ echo "Admin";} if($type==2){ echo "Gérant";}if($type==3){ echo "Consultation";}?></td>
				        
				      </tr>
				     	<?php }?>
				    </tbody>
				  </table>

		  </div>
		  <div class="panel-footer"><a class="btn btn-default" href="users.php?action=new"> Nouveau</a></div>
	</div>

</div>