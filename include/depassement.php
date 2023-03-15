<div class="col-lg-9 col-md-9 col-sm-12 col-xm-12">

	<h3>Station en dépassement</h3><br>
<table class="table table-striped table-responsive">
			<thead>
		
				<tr><th>Code</th><th>Nom</th><th>Encours autorisé</th><th>Encours</th><th>Ecart</th><th>Détail</th></tr>
			</thead>
			<tbody>		
<?php
foreach ($list as $sta) {
	# code...

$sqlx3 ="SELECT BPCUSTOMER.BPCNUM_0, BPCUSTOMER.BPCNAM_0, BPCUSTOMER.OSTAUZ_0, BPCUSTOMER.OSTCTL_0,BPCUSTMVT.ORDBPIATIC_0,
BPCUSTMVT.DLVOSTC_0, BPCUSTMVT.NIVDLVC_0, BPCUSTMVT.NPTINVC_0, BPCUSTMVT.BLCC_0
FROM BPCUSTOMER INNER JOIN BPCUSTMVT ON BPCUSTOMER.BPCNUM_0 = BPCUSTMVT.BPCNUM_0
WHERE BPCUSTOMER.BPCNUM_0='".$sta["code"]."';";

$resultx3 = odbc_exec($connectionodbcx3,$sqlx3);


$sqlX33 ="SELECT SORDER.SOHNUM_0, SDELIVERY.SDHNUM_0,SDELIVERY.DLVATI_0, SDELIVERYD.ITMREF_0,SORDER.DLVSTA_0,SDELIVERYD.QTY_0,SORDER.ORDINVATI_0,SDELIVERY.DLVDAT_0 FROM SORDER INNER JOIN SDELIVERY ON SORDER.SOHNUM_0 = SDELIVERY.SOHNUM_0
			INNER JOIN SDELIVERYD ON SDELIVERY.SDHNUM_0 = SDELIVERYD.SDHNUM_0
			 WHERE  SORDER.INVSTA_0 <> 3 
			 AND SDELIVERY.INVFLG_0 =1
			 AND SORDER.DLVSTA_0 <> 1 
			 AND SDELIVERY.CFMFLG_0 = 2
			 AND (SDELIVERYD.QTY_0-SDELIVERYD.RTNQTY_0)>0  
			 AND NOT SDELIVERYD.ITMREF_0 LIKE 'ADDIT%'
			 AND NOT SDELIVERYD.ITMREF_0 LIKE 'TP%' 
			 AND SORDER.BPCORD_0 ='".$sta["code"]."'";

$resultx33 = odbc_exec($connectionodbcx3,$sqlX33);
$zdlvv= array();
$current="";
$totaldlvv =0;
while($rowx33 = odbc_fetch_array($resultx33)){
 $zdlvv[] = $rowx33;
 if($current!=$rowx33["SOHNUM_0"]){
 	
		  				$current = $rowx33["SOHNUM_0"];
		  				$totaldlvv+=$rowx33["DLVATI_0"];
		  				
		  			}
}

$s3840="SELECT GACCENTRYD.SNS_0,GACCENTRYD.AMTLED_0,GACCENTRYD.SAC_0 FROM GACCENTRYD WHERE (GACCENTRYD.SAC_0 = 'C40' OR GACCENTRYD.SAC_0 = 'C38') AND GACCENTRYD.BPR_0='".$sta["code"]."'";



$result3840 = odbc_exec($connectionodbcx3,$s3840);



$c3840 = 0;
while($row3840 = odbc_fetch_array($result3840)){
	$c3840 +=$row3840["SNS_0"]*$row3840["AMTLED_0"];
}



$rowx3 = odbc_fetch_array($resultx3);
$er = $rowx3["ORDBPIATIC_0"]+$rowx3["DLVOSTC_0"]+$rowx3["BLCC_0"]+$rowx3["NPTINVC_0"]+$totaldlvv+$c3840;
$ecart = $rowx3['OSTAUZ_0'] - $er;


	?>
	<tr><td><?php echo $sta["code"];?></td><td><?php echo $sta["nom"];?></td><td class="text-right"><?php echo number_format (round($rowx3['OSTAUZ_0'],2),2,",",".");?></td><td class="text-right"><?php echo number_format (round($er,2),2,",",".");?></td><td class="text-right"><?php echo number_format (round($ecart,2),2,",",".");?></td>
			<td><a class="btn btn-info btn-sm" href="encours.php?id=<?php echo $sta["code"];?>">Détail</a></td>
	</tr>
	<?php
}

?>
</tbody>
</table>
</div>