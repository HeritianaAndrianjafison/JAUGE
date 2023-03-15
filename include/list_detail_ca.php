<?php

$date_debut = valueof("date_debut");
$date_fin = valueof("date_fin");
$filtre="";
if($date_debut!=null){
	$filtre.="&date_debut=$date_debut";
}
if($date_fin!=null){
	$filtre.="&date_fin=$date_fin";
}


$station_id = valueof("id_station_inspection");

		$count = getCurl("localhost/PORTAIL/ca.php?action=count&station_id=$station_id&date_debut=$date_debut&date_fin=$date_fin");
		print_r($count);

		$n= $count;

		$offset = 0;
		$c = 15;
		$r = $n%$c;
		$q = ($n-$r)/$c;
		if($r!=0){
			$q = $q+1;
		}

		$page=valueof("page");
		if(isset($page)){
			$offset = $page;
		}
		$f = $offset*$c;



		$res = getCurl("localhost/PORTAIL/ca.php?action=list_ca&station_id=$station_id&offset=$f&limit=$c&date_debut=$date_debut&date_fin=$date_fin");
		//print_r($res);

		$nav="<ul class='pagination'><li><a href='ca.php?action=detail&id_station_inspection=$station_id' >Tous</a></li>";
			
				if($page-1>=0){
					$nav.="<li><a href='ca.php?action=detail&id_station_inspection=$station_id&page=".($page-1)."' ><</a></li>";
				}
				
				for($i=$page-3;$i<$page+3;$i++){
					$p=$i+1;
					$class = "";
					if($i==$page){
					$class ="class='active'";
					}
					if($i<$q && $i>=0){
						$nav.="<li $class><a href='ca.php?action=detail&id_station_inspection=$station_id&page=$i$filtre' >$p</a></li>";
					}
					
				}
				if($page+1<$q){
					$nav.="<li><a href='ca.php?action=detail&id_station_inspection=$station_id&page=".($page+1)."$filtre' >></a></li>";
				}
				
			
			$nav.="</ul>";
			echo $nav;
		$res = json_decode($res,1);
		?>
		 <form class="form-inline" method="POST" action="ca.php?<?php echo 'action=detail&id_station_inspection='.$station_id;?>">
		  <div class="form-group">
		    <label for="email">Date début:</label>
		    <input type="text" class="form-control date" name="date_debut" value="<?php echo $date_debut;?>">
		  </div>
		  <div class="form-group">
		    <label for="pwd">Date fin:</label>
		    <input type="text" class="form-control date" name="date_fin" value="<?php echo $date_fin;?>">
		  </div>
		  <div class="form-group">
		    <label for="pwd">Enregistrer :</label>
		    <select class="form-control" >
			 <option value="export.php?id_station_inspection=<?php echo "$station_id";?>" onclick ="location = this.value;">Enregistrer tous</option>
			 <option value="export.php?id_station_inspection=<?php echo "$station_id&date_debut=$date_debut&date_fin=$date_fin";?>" onclick ="location = this.value;">Enregistrer recherche</option>
			 <option value="export.php?id_station_inspection=<?php echo "$station_id&offset=$f&limit=$c&date_debut=$date_debut&date_fin=$date_fin";?>" onclick ="location = this.value;">Enregistrer page</option>
			</select>
		  </div>
		  
		  <button type="submit" class="btn btn-default">Chercher</button>
		  
		</form> 

		 <table class="table table-responsive table-striped">
				    <thead>
				      <tr>
				        <th>Date</th>
				        <th>Modification</th>
				        <th>Station</th>
				        <th>Détail</th>
				      </tr>
				    </thead>
				    <tbody>
		<?php


		foreach ($res as $r) {
			# code...
			//print_r(json_decode($r,1));
			//echo stripslashes($r["data_json"])."<br>";
			//echo $r["data_json"];
			
			$ca = json_decode($r["data_json"], true);
			$ca = json_decode($ca,1);
			$key = array_keys($ca);
			//print_r($key);
			
			//echo "<hr>";
			?>
				<tr>
					<td><?php echo $r["created"];?></td>
					<td><?php echo $r["updated"];?></td>
					<td><?php echo $r["station_name"];?></td>
					<td><a class="btn btn-info btn-sm" data-toggle="modal" 
				        data-target="#myModal<?php echo $r["id"];?>">Détails</a></td>
				        <div id="myModal<?php echo $r["id"];?>" class="modal fade" role="dialog">
						  <div class="modal-dialog">

						    <!-- Modal content-->
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Détails</h4>
						      </div>
						      <div class="modal-body">
						        	
		  								<?php 
		  								$c_activity = "";
		  									foreach ($key as $k) {
		  										# code...
		  										//$rubrique = DB::select("field",array("*")," id=".$k)[0];
		  										//echo $rubrique["activity_id"]."<br>";
		  										$rubrique = getCurl("localhost/PORTAIL/ca.php?action=line_rubrique&id=$k");
		  										$rubrique =json_decode($rubrique ,1);

		  										$activity = getCurl("localhost/PORTAIL/ca.php?action=line_activity&id=".$rubrique["activity_id"]);
		  										$activity =json_decode($activity ,1);
		  										if($c_activity != $activity["name"]){
		  											echo "<em><strong>".$activity["name"]."</strong></em><br>";
		  											$c_activity = $activity["name"];
		  										}
		  										
		  										echo $rubrique["name"]." :".$ca[$k]."<br>";
		  									}

		  								?>

						    		

						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
						      </div>
						    </div>

  						</div>




				</tr>
			<?php
		}


?>
		</tbody>
</table>