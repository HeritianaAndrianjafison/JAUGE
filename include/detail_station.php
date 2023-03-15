<div class="col-lg-10 col-md-10 col-sm-10 col-xm-12">

<div><center><h3>CODE :<?php echo $_GET['code']."/Station :".$sta['nom'];?></h3><br>
		</center></div>
<?php 
if($msg==1){
	?>
	<div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  		<strong>Données enregistrés!</strong>
	</div>
	<?php
		}
	?>
<!-- BLOCK SP -->
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">

<div class="panel panel-default">
      <div class="panel-heading" style="background-color: #93ff78"><h3>SP</h3></div>
      <div class="panel-body"> 
        <style>
          .center-block {
            display: block;
            margin-right: auto;
            margin-left: auto;
          }
        </style>
        <div class="center-block" width="155">
          
        <div class="grid">
          
              <section class="center-block">
              <!--<h2><?php echo $res['Label']?></h2>--->
              <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="150" height="150" xmlns="http://www.w3.org/2000/svg">
                <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <circle class="circle-chart__circle" stroke="<?php if($sp<$smisp){echo "#8B0000";}else{echo "#6f9ecf";}//#8B0000;?>" stroke-width="2" stroke-dasharray="<?php echo $quantitysp;?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <g class="circle-chart__info">
                  <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="8" ><?php echo round($quantitysp);?>%</text>
                  <text class="circle-chart__subline" x="16.91549431" y="20.5" alignment-baseline="central" text-anchor="middle" font-size="4"><?php echo round($sp);?> L</text>
                </g>
              </svg>
            </section>
            
            </div>
          </div>
      </div>
     
      <div class="panel-footer">  
      	  Vente : <?php echo $sta["vente_sp"];?><br>
      	  Stock : <?php echo $sp;?><br>
      	  Livraison : <?php echo $dlv_sp;?><br>
          Capacité : <?php echo $csp;?><br>
          Autonomie :<?php echo round($Autonomie_sp,2);?><br>
          Commande :<?php echo $cmd_sp;?>
      </div>
	</div>


</div>
<!-- BLOCK GO -->
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">

<div class="panel panel-default">
      <div class="panel-heading" style="background-color: #fbff78"><h3>GO</h3></div>
      <div class="panel-body"> 
        <style>
          .center-block {
            display: block;
            margin-right: auto;
            margin-left: auto;
          }
        </style>
        <div class="center-block" width="155">
          
        <div class="grid">
          
              <section class="center-block">
              <!--<h2><?php echo $res['Label']?></h2>--->
              <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="150" height="150" xmlns="http://www.w3.org/2000/svg">
                <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <circle class="circle-chart__circle" stroke="<?php if($go<$smigo){echo "#8B0000";}else{echo "#6f9ecf";}//#8B0000;?>" stroke-width="2" stroke-dasharray="<?php echo $quantitygo;?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <g class="circle-chart__info">
                  <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="8" ><?php echo round($quantitygo);?>%</text>
                  <text class="circle-chart__subline" x="16.91549431" y="20.5" alignment-baseline="central" text-anchor="middle" font-size="4"><?php echo round($go);?> L</text>
                </g>
              </svg>
            </section>
            
            </div>
          </div>
      </div>
     
      <div class="panel-footer">  
      	Vente : <?php echo $sta["vente_go"];?><br>
      	Stock : <?php echo $go;?><br>
      	  Livraison : <?php echo $dlv_go;?><br>
          Capacité : <?php echo $cgo;?><br>
          Autonomie :<?php echo round($Autonomie_go,2);?><br>
          Commande :<?php echo $cmd_go;?>
      </div>
	</div>


</div>

<!-- BLOCK PL -->
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">

<div class="panel panel-default">
      <div class="panel-heading" style="background-color: #ff7878"><h3>PL</h3></div>
      <div class="panel-body"> 
        <style>
          .center-block {
            display: block;
            margin-right: auto;
            margin-left: auto;
          }
        </style>
        <div class="center-block" width="155">
          
        <div class="grid">
          
              <section class="center-block">
              <!--<h2><?php echo $res['Label']?></h2>--->
              <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="150" height="150" xmlns="http://www.w3.org/2000/svg">
                <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <circle class="circle-chart__circle" stroke="<?php if($pl<$smipl){echo "#8B0000";}else{echo "#6f9ecf";}//#8B0000;?>" stroke-width="2" stroke-dasharray="<?php echo $quantitypl;?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <g class="circle-chart__info">
                  <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="8" ><?php echo round($quantitypl);?>%</text>
                  <text class="circle-chart__subline" x="16.91549431" y="20.5" alignment-baseline="central" text-anchor="middle" font-size="4"><?php echo round($pl);?> L</text>
                </g>
              </svg>
            </section>
            
            </div>
          </div>
      </div>
     
      <div class="panel-footer">
      Vente : <?php echo $sta["vente_pl"];?> <br> 
        Stock : <?php echo $pl;?><br>
      	  Livraison : <?php echo $dlv_pl;?><br>
          Capacité : <?php echo $cpl;?><br>
          Autonomie :<?php echo round($Autonomie_pl,2);?><br>
          Commande :<?php echo $cmd_pl;?>
      </div>
	</div>


</div>

<!-- BLOCK X3 -->
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">

<div class="panel panel-default">
      <div class="panel-heading"><h3>X3</h3></div>
      <div class="panel-body"> 
       Encour autorisé : <?php echo round($rowx3['OSTAUZ_0']);?><br>
       Encour réel : <?php echo $er;?><br>
        Ecart : <?php echo $ecart;?> <br>
        PAYEMENT : <?php echo $pay["PTE_0"];?>

      </div>
     
      <div class="panel-footer">  
        NOTE : <?php echo utf8_encode($note["NOTE_0"]);?> <br>
      </div>
	</div>


</div>

<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
<form action="log.php">
	<input type="hidden" name="action" value="enregistrer_data">
	<input type="hidden" name="code" value="<?php echo $sta['code'];?>">
	<div class="form-group">
    <label for="email">Commentaire:</label>
    <textarea class="form-control" name="commentaire"></textarea>  
  </div>

	<input class="btn btn-info" type="submit" value="Enregistrer"/><br><br>
</form>

</div>

<!-- JTRAC -->
<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">

<div class="panel panel-default">
      <div class="panel-heading"><h3>JTRAC</h3></div>
      <div class="panel-body"> 
      	
      		<?php 

      			$res = getCurl("http://192.168.130.9/jovenna/api/portail.php?action=jtrac_ouvert_list&&code=".$sta["code"]);
      			$res = json_decode($res,true);
      			//print_r($res);
      		?>
      		<table class="table table-responsive table-striped">
      			<tr>	
      				<th>N° Ticket</th><th>Désignation</th><th>Echeance</th><th>Catégorie</th><th>dernière commentaire </th>
      			</tr>
      			<?php 

      				foreach ($res as $r) {
      					# code...?>
      			<tr>
      				<td><?php echo $r["id_ticket"];?></td>
      				<td><?php echo $r["description"];?></td>
      				<td><?php echo $r["Echéance"];?></td>
      				<td><?php echo $r["Catégorie Réclamation"];?></td>
      				
      				<td><?php echo $r["summary"];?></td>
      			</tr>
      					<?php
      				}
      			?>
      		</table>
      </div>
     
      <div class="panel-footer">  
       --
      </div>
	


</div>






</div>
<!--
<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
  
<?php
global $dbname;
global $servername;
global $username;
global $password;
global $connection;
$dbname = "inspection";
$servername = "192.168.130.139:3306";
$username = "jovena2";
$password = "AXeptit#1245";

$connection = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
//echo "Connected successfully";
$connection->set_charset("utf8");
//echo $sta['id_station_inspection'];
//$station_inspection = DB::select("station", array("*")," id='".$sta['id_station_inspection']."'");
//print_r($station_inspection);
$sql ="SELECT inspection.date,recommandation.fields from inspection INNER JOIN recommandation ON inspection.id=recommandation.inspection_id WHERE inspection.station_id='".$sta['id_station_inspection']."' ORDER by inspection.id DESC LIMIT 1 ";

$recommandations = DB::qs($sql);
if(count($recommandations)!=0){
  $recommandations = $recommandations[0];  
  $recommandations = $recommandations["fields"];
  $recommandations = explode(",", $recommandations);

  ?>
    <div class="panel panel-default">
      <div class="panel-heading"><h3>Recommandation inspection</h3></div>
      <div class="panel-body">
  <?php
  foreach ($recommandations as $rec) {
    # code...
    //echo $rec;
    $field = DB::select("field",array("*")," id='".$rec."'")[0];
    //print_r($field);
    echo $field["name"]."<br>";
  }
  ?>
    </div>
  </div>
  <?php
}
 
?>

  
</div>-->

</div>
