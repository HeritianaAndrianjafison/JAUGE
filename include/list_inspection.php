<div class="col-lg-10 col-md-10 col-sm-10 col-xm-12">
<?php echo $nav;?>
 <table class="table table-responsive table-striped">
				    <thead>
				      <tr>
				        <th>Numéro</th>
				        <th>Inspecteur</th>
				        <th>Date</th> 
				      </tr>
				    </thead>
				    <tbody>
				    	<?php foreach($list as $l){
				    		extract($l);
				    		?>
				      <tr>
				      	<td><a href="print.php?id=<?php echo $id;?>"><?php echo $id;?></a></td>
				        <td><?php echo $insptector_firstname." ".$inspectector_lastname;?></td>
				        <td><?php echo date("d/m/Y",strtotime($date));?></td>
				      </tr>
				     	<?php }?>
				    </tbody>
				  </table>

</div>