<?php
include "config/config.php";
need_connexion();
$css = array("etat");
$js = array("etat");
include "include/header.php";
include "include/left.php";
//include "include/login.php";


$action = valueof("action");
if($action == null){
 	//echo time() - $_SESSION['LAST_ACTIVITY'];
	//$list = DB::select("utilisateur",array("*"));
						$condition = " 1 ";
			$filtre = valueof("filtre");
			if($filtre!=null){
				$condition = " station.nom like '%$filtre%' ";
			}
			//$station_site = DB::select("station_site",array("*")," 1 ORDER BY station_code");
			$station_site = DB::qs("SELECT station_site.*, station.nom as station_nom FROM station_site INNER JOIN station ON station_site.station_code = station.code WHERE $condition ORDER BY station_nom");
			?>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xm-12">
					<br><br>
				<form action="site_probleme.php" class="form-inline" method="POST">
		  		<div class="form-group">
		    			<label for="email">Filtre:</label>
		    			<input type="text" class="form-control" name="filtre" value="<?php echo valueof("filtre");?>">
		  		</div>
		  		<div class="form-group">
		  			<button type="submit" class="btn btn-default">Chercher</button>
		 		 </div>
				</form> 
				<br><br>
					<h3>Site à problème ce jour</h3>
				<table class="table table-responsive table-striped">
					<tr>
						<thead>
				      <tr>
				        <th>CODE</th>
				        <th>NOM</th>
				        <th>Site déscription</th>
				        <th>Operateur</th>
				        <th>Problème</th> 
				      </tr>
					</tr>
					<?php 
						foreach ($station_site as $site) {
							# code...
							$station = DB::select("station",array("*")," code='".$site["station_code"]."'")[0];
							//print_r(count($station)."  => ".$site["station_code"]."/");
							if($station['statut']==0||$station['maintenance']==2){continue;};
							$tank = DB::select("tank",array("*")," site_id='".$site['site_id']."' && collect='".$site['collect']."'");
							if(count($tank)==0){
					?>
					<tr>
				        <td><?php echo $site["station_code"];?></td>
				        <td><?php echo $station["nom"];?></td>
				        <td><?php  echo $site['description'];?></td>
				        <td><?php if($site['collect']==1){echo "Telma";}else{echo "Orange";}?></td>
				        <td>Aucune tank détécter</td> 
				      
					</tr>
					<?php
							}else{
								foreach ($tank as $t) {
									# code...
									$inventory = DB::select("inventory",array("*")," tank_id='".$t['tank_id']."' && collect='".$site['collect']."'");
									if(count($inventory)==0){

											

										?>
					<tr>
				        <td><?php echo $site["station_code"];?></td>
				        <td><?php echo $station["nom"];?></td>
				        <td><?php  echo $site['description'];?></td>
				        <td><?php if($site['collect']==1){echo "Telma";}else{echo "Orange";}?></td>
				        <td>Aucune donnée réçu pour la tank numéro : <?php echo $t['tank_id'];?></td>   
					</tr>
										<?php
									}else{

									foreach ($inventory as $inv) {
										# code...
										$today = date("d/m/y");
										$date_collect = date("d/m/y",strtotime($inv['date']));
										if($today!=$date_collect){
					?>
					<tr>
				        <td><?php echo $site["station_code"];?></td>
				        <td><?php echo $station["nom"];?></td>
				        <td><?php  echo $site['description'];?></td>
				        <td><?php if($site['collect']==1){echo "Telma";}else{echo "Orange";}?></td>
				        <td>Date incorrècte pour la tank numero : <?php echo $t['tank_id'];?> date : <?php echo $date_collect;?></td>   
					</tr>
					<?php
											}
										}
									}
								}
							}
						}
					?>
				</table>
				</div>
			<?php

	}
include "include/footer.php";
?>