
<div class="col-lg-10 col-md-10 col-sm-10 col-xm-12">


<input type="hidden" class="orange_option" value="<?php echo $orange_site;?>" />
<input type="hidden" class="telma_option" value="<?php echo $telma_site;?>" />



<div class="panel panel-default">
		<div class="panel-heading"><h3>Site associé à <?php echo $station["nom"];?></h3></div>
		<div class="panel-body">
		<form action="process.php" method="POST">
			<input type="hidden" name="action" value="insert_site"/>
			<input type="hidden" name="station_code" value="<?php echo $_GET['code'];?>"/>
		<table class="table table-striped">
		    <thead>
		      <tr>
		      	<th >Operateur</th>
			        <th>Site</th>
			        <th>Description</th>
			        <th>Supprimer</th>    
		      	</tr>  
		    </thead>
		    <tbody class="site_list">
		    	<?php foreach($liste_site as $l){
		    		extract($l);
		    		?>
		      <tr>
		        <td><?php if($collect==1){echo "Telma";}else{echo "Orange";}?></td>
		        <td class="text-right"><?php if($collect==1){ echo getsitelabeloperateur($site_id,$telma_site_array)["Header1"];}else{
		        	echo getsitelabeloperateur($site_id,$orange_site_array)["Header1"];
		        }?></td>
		        <td><?php echo $description;?></td> 
		        <td>
		        	<a href="process.php?action=delete_site&id=<?php echo $id;?>&station_code=<?php echo $station_code;?>" class="btn btn-warning">Supprimer</a>
		        </td> 
		      </tr>
		      	<?php }?>
		    </tbody>
		    <tfooter>
		    	
		    	<tr>
			    	<td><select class="form-control collect" name="collect">
		                    <option value="1">Telma</option>
		                    <option value="2">Orange</option>
	                  	</select></td>
			        <td class="text-right">
			        	<select class="form-control site_selected" name="site_id">
		                    <?php echo $telma_site;?>
	                  	</select>
	                </td>
			        <td><input type="test" class="form-control description" name="description"></td> 
			        <td><input type="submit" class="btn btn-success save_new_site" value="Enregistrer"></td>
		    	</tr>
		    	
		    </tfooter>
		  </table>
		  </form>
		</div>
		</div>

		
</div>