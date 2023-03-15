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

	$condition = "1";
	$filtre = valueof("filtre");
	if($filtre!=null){
		$condition=" station.nom like '%$filtre%' OR station.code like '%$filtre%' ";
		
	}
$date_deb = valueof("date_deb");
if($date_deb!=null){
	$date_deb=DateTime::createFromFormat('d/m/Y', $date_deb);
	$date_deb = $date_deb->format('Y-m-d');
	$condition.=" AND date>='$date_deb 00:00:00'";
}
$date_fin = valueof("date_fin");
if($date_fin!=null){
	$date_fin=DateTime::createFromFormat('d/m/Y', $date_fin);
	$date_fin=$date_fin->format('Y-m-d');
	$condition.=" AND date<='$date_fin 23:59:59'";
}



	$sql = "SELECT data.*,station.nom from data INNER JOIN station on data.code = station.code WHERE $condition ORDER BY data.id DESC";
//echo $sql;
	$list=DB::qs($sql);
	$n = count($list);
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
			//$list = DB::select("data",array("*"),"$condition Order by id DESC LIMIT $c OFFSET $f");


			

$nav="<ul class='pagination'><li><a href='data.php' >Début</a></li>";
			
				if($page-1>=0){
					$nav.="<li><a href='data.php?page=".($page-1)."&&filtre=$filtre&&date_deb=$date_deb&&date_fin=$date_fin' ><</a></li>";
				}
				
				for($i=$page-3;$i<$page+3;$i++){
					$p=$i+1;
					$class = "";
					if($i==$page){
					$class ="class='active'";
					}
					if($i<$q && $i>=0){
						$nav.="<li $class><a href='data.php?page=$i&&filtre=$filtre&&date_deb=$date_deb&&date_fin=$date_fin' >$p</a></li>";
					}
					
				}
				if($page+1<$q){
					$nav.="<li><a href='data.php?page=".($page+1)."&&filtre=$filtre&&date_deb=$date_deb&&date_fin=$date_fin' >></a></li>";
				}
				
			
			$nav.="</ul>";


	include "include/list_data.php";
}


include "include/footer.php";
?>