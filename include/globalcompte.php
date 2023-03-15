<div class="col-lg-9 col-md-9 col-sm-12 col-xm-12">
 



<h3>Situation compte</h3>
<table class="table table-striped table-responsive">
	<tr>	
		<td>
			<form class="form-inline" action="globalcompte.php" method="POST">
 			
		  		<div class="form-group">
		    		<label for="email">Station:</label>
		    			<input type="text" class="form-control" name="filtre" value="<?php echo valueof("filtre");?>" id="filtre">
		  		</div>
		  		<div class="form-group">
		    		<label for="pwd">Région :</label>
		    		<select class="form-control"  name="region">
			 				<?php echo $region;?>
					</select>
		  		</div>
		  		<div class="form-group">
		  				<button type="submit" class="btn btn-default">Chercher</button>
		  		</div>
		  		<div class="form-group">
		  				<a href="globalcompte.php" class="btn btn-default">Tous</a>
		  		</div>
			</form> 
		</td>
		<td>
		</td>
	</tr>
</table>


<table class="table-striped table-bordered">
			<thead>
					<tr>
						<th colspan="2"></th>
						
						<th colspan="3">&nbsp;Situation compte&nbsp;</th>
					</tr>
				
			</thead>
			<tbody>
				<tr>
					<th >&nbsp;CODE&nbsp;</th>
					<th>&nbsp;NOM&nbsp;</th>
					<th class="sort" alt="12">&nbsp;PLAFOND&nbsp;</th>
					<th class="sort" alt="13">&nbsp;ENCOURS&nbsp;</th>
					<th class="sort" alt="14">&nbsp;ECART&nbsp;</th>
					<th  alt="15">&nbsp;JTRAC&nbsp;</th>
					<th>&nbsp;DATE&nbsp;&nbsp;</th>
					<th></th>
					
				</tr>
<?php

	$i=0;
 	foreach ($list as $sta) {
 		# code...

 		$station_site = DB::select("station_site",array("*")," station_code='".$sta["code"]."'");
//print_r($rowx3);

$sqlx3 ="SELECT BPCUSTOMER.BPCNUM_0, BPCUSTOMER.BPCNAM_0, BPCUSTOMER.OSTAUZ_0, BPCUSTOMER.OSTCTL_0,BPCUSTMVT.ORDBPIATIC_0,
BPCUSTMVT.DLVOSTC_0, BPCUSTMVT.NIVDLVC_0, BPCUSTMVT.NPTINVC_0, BPCUSTMVT.BLCC_0
FROM BPCUSTOMER INNER JOIN BPCUSTMVT ON BPCUSTOMER.BPCNUM_0 = BPCUSTMVT.BPCNUM_0
WHERE BPCUSTOMER.BPCNUM_0='".$sta["code"]."';";

$resultx3 = odbc_exec($connectionodbcx3,$sqlx3);

$rowx3 = odbc_fetch_array($resultx3);
$er = $rowx3["ORDBPIATIC_0"]+$rowx3["DLVOSTC_0"]+$rowx3["BLCC_0"]+$rowx3["NPTINVC_0"];
$ecart = $rowx3['OSTAUZ_0'] - $er;



		?>
		
		
		<tr class="sorter_ligne  l<?php echo $i;?>">
			<td  ><strong>&nbsp;<?php echo $sta["code"];?>&nbsp;</strong></td>
 			<td  >&nbsp;<?php echo $sta["nom"];?>&nbsp;</td>
 		
 		<?php
				
				if(isset($_GET["date"])){

					$date = $_GET["date"];
					
				}else{
					$date = date("d/m/Y H:i:s");
				}
				$date_encode = urlencode ($date);
				

					
					?>
					<td class="text-right s12" value="<?php echo $rowx3['OSTAUZ_0'];?>">&nbsp;<?php echo number_format (round( $rowx3['OSTAUZ_0'],2),2,",",".");?>&nbsp;</td>
					<td class="text-right s13" value="<?php echo $er;?>">&nbsp;<?php echo number_format (round( $er,2),2,",",".");?>&nbsp;&nbsp;</td>
					<td class="text-right s14" value="<?php echo $ecart;?>">&nbsp;<?php echo number_format (round( $ecart,2),2,",",".");?>&nbsp;</td>
					<td class="text-center" >
						
	<?php print_r(getCurl("http://192.168.130.9/jovenna/api/portail.php?action=jtrac_en_ouvert&&code=".$sta["code"]));?>
					</td>
					<td><?php echo date("d/m/Y H:i:s");?></td>
					<td><a href="detail_station.php?code=<?php echo $sta['code'];?>" class="btn btn-info btn-xs">Voir détail</a></td>
				</tr>
				
		
		<?php
 	}
 	?>
 			</tbody>
		</table>
<input type="hidden" id="ligne_number" value="<?php echo $i;?>"/>		
</div>