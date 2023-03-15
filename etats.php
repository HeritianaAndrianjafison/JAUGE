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
 	
	//$list = DB::select("utilisateur",array("*"));

	$condition = 1;
	$filtre = valueof("filtre");
	if($filtre!=null){
			$gerants = DB::select("utilisateur",array("*")," login like '%".$filtre."%' OR nom like '%".$filtre."%' OR prenom like '%".$filtre."%'");
			$flt ="";
			foreach ($gerants as $g) {
				# code...
				$flt.=" utilisateur_id ='".$g['id']."' OR ";
			}
			$flt.="code like '%$filtre%' OR nom like '%$filtre%'";
	}else {
	    		$flt =null;	
	}
	if($_SESSION["SESSION_type"]==1||$_SESSION["SESSION_type"]==3){
         $condition = "statut=1";
         if($flt!=null){
         	$condition = "statut=1 AND ($flt)";
         }
	}
	else{
		$condition = "(statut=1 && utilisateur_id='".$_SESSION["SESSION_id"]."')";
		if($flt!=null){
         	$condition = "(statut=1 && utilisateur_id='".$_SESSION["SESSION_id"]."') AND ($flt)";
         }
	}
	$region = valueof("region");
	if($region!=null){
		$condition .= " AND region =$region";
	}
	//echo $condition;
	$n = DB::select("station",array("COUNT(*)"),"$condition")[0]["COUNT(*)"];
			//$list = DB::select("offre",array("*"));

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
			$list = DB::select("station",array("*"),"$condition Order by code DESC LIMIT $c OFFSET $f");


			$nav="<ul class='pagination'><li><a href='etats.php' >Tous</a></li>";
			for($i=0;$i<$q;$i++){
				$p=$i+1;
				$class = "";
				if($i==$page){
				$class ="class='active'";
				}
				$nav.="<li $class><a href='etats.php?page=$i&&filtre=".$filtre."&&region=$region' >$p</a></li>";
			}
			$nav.="</ul>";
	$region =  "<option value='".$region."' >".label_region($region)."</option>".liste_region();
	include "include/list_etat.php";
}
if($action == "new"){

	$utilisateur = DB::select("utilisateur",array("*"));
	$option="";
	foreach($utilisateur as $u){
		extract($u);
		$option.="<option value='$id'>$prenom $nom</option>";
	}
	/*
	$region = getRegion();
	$region_option = "";
	foreach($region as $r){
		extract($r);
		$region_option .= "<option value='$id'>$code</option>";
	}*/

	
	include "include/new_station.php";
}
if($action == "detail"){
	
	$station_id = valueof("id");

	//$station = DB::select("station",array("*"),"code='$station_id'")[0];
		$station = DB::select("station",array("*"),"code='".$_GET['id']."'")[0];
	if($_GET['collect']==1){
		$lien = $adress_telma."?site_id=".valueof('site_id')."&action=detail";
	}else{
		$lien = $adress_orange."?site_id=".valueof('site_id')."&action=detail";
	}
		$tanks = DB::select("tank",array("*")," site_id=".valueof('site_id')." AND collect='".valueof('collect')."'");
		//$lien = "http://192.168.130.197:8080/jauges_inform_v6/JAUGEAPI/?site_id=".valueof('site_id')."&action=detail";
		/*$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $lien);
		curl_setopt($curl, CURLOPT_COOKIESESSION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$return = curl_exec($curl);
		$return = json_decode($return,true);
		//print_r($return);
		curl_close($curl);*/
		?>
		
		<div class="col-lg-10 col-md-12 col-sm-12 col-xm-12">
			<div><center><h3>CODE :<?php echo $_GET['id']."/Station :".$station['nom'];?></h3></center></div>
			<hr>
				<?php
				$sp = 0;
				$pl = 0;
				$go = 0;

				foreach($tanks as $t){
				//extract($r);
					$inventory = DB::select("inventory",array("*")," tank_id='".$t['tank_id']."' AND collect='".valueof('collect')."'");
					if(count($inventory)==0){
						continue;
					}
				$inventory= $inventory[0];
				$quantity = $inventory['volume']/$t['capacite']*100;
				if (preg_match("#pl#i", $t['label']))
		        {
		            $pl+=$inventory['volume'];
		        }
		        if (preg_match("#go#i", $t['label']))
		        {
		            $go+=$inventory['volume'];
		        }
		        if (preg_match("#sp#i", $t['label']))
		        {
		            $sp+=$inventory['volume'];
		        }
				include "include/detail_etat.php";
				if(isset($_GET["date"])){

					$date = $_GET["date"];
					
				}else{
					$date = date("d/m/Y H:i:s");
				}
				$date_encode = urlencode ($date);
				};

				?>
				
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
						<div class="panel panel-default">
						      <div class="panel-heading"><h3>Total</h3></div>
						      <div class="panel-body"> 
						      				<div><label>PL:</label> <?php echo $pl;?></div>
											<div><label>GO:</label> <?php echo $go;?></div>
											<div><label>SP:</label> <?php echo $sp;?></div>
											<hr>
											<?php if(isset($date)){echo $date;}?>
										
						      </div>
						      <div class="panel-footer">
						      	<a class="btn btn-default" href="etats.php?action=detail&&id=<?php echo valueof('id')?>&&date=<?php if(isset($date_encode)){echo $date_encode;};?>&&site_id=<?php echo valueof("site_id");?>&&collect=<?php echo valueof("collect");?>">Actualisé</a>
						      </div>
						</div>	
 				</div>
				

		</div>
		<?php
		//print_r($res);
		
	
}
include "include/footer.php";
?>