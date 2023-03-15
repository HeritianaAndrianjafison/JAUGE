<div class="col-lg-9 col-md-9 col-sm-12 col-xm-12">
 
<table class="table table-striped">
				    <thead>
				      <tr>
				        <th>CODE</th>
				        <th>NOM</th>
				        <th>Gérant</th>
				      </tr>
				     </thead>
				     <tbody>

<?php

 	foreach ($list as $sta) {
 		# code...
 		$user = getUser($sta["utilisateur_id"]);
 		?>
 					<tr>
 						<td><?php echo $sta["code"];?></td>
 						<td><?php echo $sta["nom"];?></td>
 						<td><?php echo $user['prenom']." ".$user['nom'];?></td>
 					</tr>
 		<?php
 		}?>
 	</tbody>
 </table>			
</div>