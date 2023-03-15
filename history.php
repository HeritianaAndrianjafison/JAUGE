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
		$users = DB::select("utilisateur",array("*")," nom like '%$filtre%' || prenom like '%$filtre%' || login like '%$filtre%'");
		//$condition ="";
		$condition = "(0";
		foreach ($users as $u) {
			# code...
			$condition .=" OR id_user =".$u['id'];
		}
		$condition.=")";
	}
	//$condition.=")";


	$date_deb = valueof("date_deb");
if($date_deb!=null){
	$date_deb=DateTime::createFromFormat('d/m/Y', $date_deb);
	$date_deb = $date_deb->format('Y-m-d');
	$condition.=" AND login>='$date_deb 00:00:00'";
}
$date_fin = valueof("date_fin");
if($date_fin!=null){
	$date_fin=DateTime::createFromFormat('d/m/Y', $date_fin);
	$date_fin=$date_fin->format('Y-m-d');
	$condition.=" AND login<='$date_fin 23:59:59'";
}
	$n = DB::select("history",array("COUNT(*)"), $condition)[0]["COUNT(*)"];
			//$list = DB::select("offre",array("*"));
	//print_r($n);
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
			$list = DB::select("history",array("*"),"$condition Order by login DESC LIMIT $c OFFSET $f");


			

$nav="<ul class='pagination'><li><a href='history.php' >Début</a></li>";
			
				if($page-1>=0){
					$nav.="<li><a href='history.php?page=".($page-1)."&&filtre=$filtre&&date_deb=".valueof('date_deb')."&&date_fin=".valueof('date_fin')."' ><</a></li>";
				}
				
				for($i=$page-3;$i<$page+3;$i++){
					$p=$i+1;
					$class = "";
					if($i==$page){
					$class ="class='active'";
					}
					if($i<$q && $i>=0){
						$nav.="<li $class><a href='history.php?page=$i&&filtre=$filtre&&date_deb=".valueof('date_deb')."&&date_fin=".valueof('date_fin')."' >$p</a></li>";
					}
					
				}
				
				if($page+1<$q){
					$nav.="<li><a href='history.php?page=".($page+1)."&&filtre=$filtre&&date_deb=".valueof('date_deb')."&&date_fin=".valueof('date_fin')."' >></a></li>";
				}
				
			
			$nav.="</ul>";

	include "include/list_history.php";
}


include "include/footer.php";
?>