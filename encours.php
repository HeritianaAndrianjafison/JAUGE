<?php
include "config/config.php";
include "include/header.php";
include "include/left.php";

$id = $_GET['id'];
$station = DB::select("station",array("*"),"code='".$_GET['id']."'")[0];

$s3840="SELECT GACCENTRYD.SNS_0,GACCENTRYD.AMTLED_0,GACCENTRYD.SAC_0 FROM GACCENTRYD WHERE (GACCENTRYD.SAC_0 = 'C40' OR GACCENTRYD.SAC_0 = 'C38') AND GACCENTRYD.BPR_0='".$_GET['id']."'";



$result3840 = odbc_exec($connectionodbcx3,$s3840);



$c3840 = 0;
while($row3840 = odbc_fetch_array($result3840)){
	$c3840 +=$row3840["SNS_0"]*$row3840["AMTLED_0"];
}
//echo $c3840;
//die();

$ssc="SELECT GACCENTRYD.DES_0,GACCENTRYD.AMTCUR_0*GACCENTRYD.SNS_0 AS ORDERBY ,GACCENTRYD.SNS_0,GACCENTRYD.OFFACC_0,GACCENTRYD.ACCDAT_0,GACCENTRYD.SAC_0,GACCDUDATE.DUDDAT_0,GACCENTRYD.MTC_0, GACCENTRYD.NUM_0,GACCENTRYD.AMTCUR_0, GACCENTRY.TYP_0 FROM GACCENTRYD INNER JOIN GACCDUDATE ON GACCENTRYD.NUM_0 = GACCDUDATE.NUM_0 INNER JOIN GACCENTRY ON GACCENTRYD.NUM_0 = GACCENTRY.NUM_0  WHERE (UNICODE(SUBSTRING(GACCENTRYD.MTC_0,1,1)) <> UNICODE(UPPER(SUBSTRING(GACCENTRYD.MTC_0,1,1))) OR GACCENTRYD.MTC_0=NULL OR GACCENTRYD.MTC_0='') AND GACCENTRYD.SAC_0 <> 'C22' AND  GACCENTRYD.SAC_0 NOT LIKE 'F%'  AND GACCENTRY.TYP_0 <> 'ODI' AND GACCENTRYD.BPR_0='".$_GET['id']."' ORDER BY ORDERBY DESC";



$resultssc = odbc_exec($connectionodbcx3,$ssc);

$lssc = array();
while($rowx3ssc = odbc_fetch_array($resultssc)){
	$lssc[] = $rowx3ssc;
}


$sqlfact ="SELECT SINVOICE.BPR_0, SINVOICE.NUM_0, GACCDUDATE.AMTCUR_0, GACCDUDATE.PAYCUR_0, GACCDUDATE.DUDDAT_0
FROM SINVOICE INNER JOIN GACCDUDATE ON SINVOICE.NUM_0 = GACCDUDATE.NUM_0
WHERE SINVOICE.STA_0=3 AND (SINVOICE.SIVTYP_0 <> 'PRF' AND SINVOICE.SIVTYP_0 <> 'AVO') AND (GACCDUDATE.AMTCUR_0-GACCDUDATE.PAYCUR_0)>100 AND SINVOICE.BPR_0='".$_GET['id']."' ORDER BY DUDDAT_0";

$factnp = array();
$resultfact = odbc_exec($connectionodbcx3,$sqlfact);
while($rowx3fact = odbc_fetch_array($resultfact)){
	$factnp[] = $rowx3fact;
}

$sqlfactav ="SELECT SINVOICE.BPR_0, SINVOICE.NUM_0, GACCDUDATE.AMTCUR_0, GACCDUDATE.PAYCUR_0, GACCDUDATE.DUDDAT_0
FROM SINVOICE INNER JOIN GACCDUDATE ON SINVOICE.NUM_0 = GACCDUDATE.NUM_0
WHERE  (SINVOICE.SIVTYP_0 = 'AVO') AND (GACCDUDATE.AMTCUR_0-GACCDUDATE.PAYCUR_0)>100 AND SINVOICE.BPR_0='".$_GET['id']."' ORDER BY DUDDAT_0";

$factav = array();
$resultfactav = odbc_exec($connectionodbcx3,$sqlfactav);
while($rowx3factav = odbc_fetch_array($resultfactav)){
	$factav[] = $rowx3factav;
}






$sqlX32 ="SELECT SORDER.SOHNUM_0, SDELIVERY.SDHNUM_0,SDELIVERY.DLVDAT_0, SDELIVERYD.ITMREF_0,SORDER.DLVSTA_0,SDELIVERYD.QTY_0,SDELIVERYD.NETPRIATI_0 FROM SORDER INNER JOIN SDELIVERY ON SORDER.SOHNUM_0 = SDELIVERY.SOHNUM_0
			INNER JOIN SDELIVERYD ON SDELIVERY.SDHNUM_0 = SDELIVERYD.SDHNUM_0
			 WHERE  SORDER.INVSTA_0 <> 3 
			 AND SORDER.DLVSTA_0 <> 1 
			 AND SDELIVERY.CFMFLG_0 = 1  
			 AND NOT SDELIVERYD.ITMREF_0 LIKE 'ADDIT%' 
			 AND SORDER.BPCORD_0 ='".$id."'";



$resultx32 = odbc_exec($connectionodbcx3,$sqlX32);
$zdlv= array();
while($rowx32 = odbc_fetch_array($resultx32)){
 $zdlv[] = $rowx32;
}

$sqlX33 ="SELECT SORDER.SOHNUM_0, SDELIVERY.SDHNUM_0,SDELIVERY.DLVATI_0, SDELIVERYD.ITMREF_0,SORDER.DLVSTA_0,SDELIVERYD.QTY_0,SORDER.ORDINVATI_0,SDELIVERY.DLVDAT_0 FROM SORDER INNER JOIN SDELIVERY ON SORDER.SOHNUM_0 = SDELIVERY.SOHNUM_0
			INNER JOIN SDELIVERYD ON SDELIVERY.SDHNUM_0 = SDELIVERYD.SDHNUM_0
			 WHERE  SORDER.INVSTA_0 <> 3 
			 AND SDELIVERY.INVFLG_0 =1
			 AND SORDER.DLVSTA_0 <> 1 
			 AND SDELIVERY.CFMFLG_0 = 2
			 AND (SDELIVERYD.QTY_0-SDELIVERYD.RTNQTY_0)>0  
			 AND NOT SDELIVERYD.ITMREF_0 LIKE 'ADDIT%'
			 AND NOT SDELIVERYD.ITMREF_0 LIKE 'TP%' 
			 AND SORDER.BPCORD_0 ='".$id."'";

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
//print_r($totaldlvv);
$sqlX34 ="SELECT SINVOICE.ACCDAT_0,SINVOICE.STA_0, SINVOICE.NUM_0, SINVOICED.ITMREF_0,SINVOICED.QTY_0,SINVOICE.AMTATI_0 FROM SINVOICE 
INNER JOIN SINVOICED ON SINVOICE.NUM_0 = SINVOICED.NUM_0 WHERE 
NOT SINVOICED.ITMREF_0 LIKE 'TP%'
AND SINVOICE.STA_0 <> 3
AND SINVOICE.SIVTYP_0 <> 'PRF'
AND SINVOICE.BPR_0='".$id."'";

$resultx34 = odbc_exec($connectionodbcx3,$sqlX34);
$zfact = array();
while($rowx34 = odbc_fetch_array($resultx34)){
 $zfact[] = $rowx34;
}
//print_r($zfact);

$sqlx3 ="SELECT BPCUSTOMER.BPCNUM_0, BPCUSTOMER.BPCNAM_0, BPCUSTOMER.OSTAUZ_0, BPCUSTOMER.OSTCTL_0,BPCUSTMVT.ORDBPIATIC_0,
BPCUSTMVT.DLVOSTC_0, BPCUSTMVT.NIVDLVC_0, BPCUSTMVT.NPTINVC_0, BPCUSTMVT.BLCC_0
FROM BPCUSTOMER INNER JOIN BPCUSTMVT ON BPCUSTOMER.BPCNUM_0 = BPCUSTMVT.BPCNUM_0
WHERE BPCUSTOMER.BPCNUM_0='".$_GET['id']."';";

/*$sqlx3 ="SELECT BPCUSTOMER.BPCNUM_0, BPCUSTOMER.BPCNAM_0, BPCUSTOMER.OSTAUZ_0, BPCUSTOMER.OSTCTL_0,BPCUSTMVT.ORDBPIATIC_0,
BPCUSTMVT.DLVOSTC_0, BPCUSTMVT.NIVDLVC_0, BPCUSTMVT.NPTINVC_0, BPCUSTMVT.BLCC_0
FROM BPCUSTOMER INNER JOIN BPCUSTMVT ON BPCUSTOMER.BPCNUM_0 = BPCUSTMVT.BPCNUM_0
WHERE BPCUSTOMER.BPCNUM_0='4999004';";*/

$resultx3 = odbc_exec($connectionodbcx3,$sqlx3);

$rowx3 = odbc_fetch_array($resultx3);

//print_r($rowx3);
$er = $rowx3["ORDBPIATIC_0"]+$rowx3["DLVOSTC_0"]+$rowx3["BLCC_0"]+$rowx3["NPTINVC_0"]+$c3840+floatval($totaldlvv);
$ecart = $rowx3['OSTAUZ_0'] - $er;

$sqlX31 ="SELECT * FROM SORDER INNER JOIN SORDERQ ON SORDER.SOHNUM_0 = SORDERQ.SOHNUM_0 
INNER JOIN ITMMASTER ON SORDERQ.ITMREF_0 = ITMMASTER.ITMREF_0 WHERE SORDER.ORDSTA_0 = 1 
																AND NOT ITMMASTER.ITMREF_0 LIKE 'TPX%'
																AND NOT ITMMASTER.ITMREF_0 LIKE 'ADDIT%'
																AND SORDER.BPCORD_0 ='".$id."' 
																";
$zcmd= array();
$resultx31 = odbc_exec($connectionodbcx3,$sqlX31);

while($rowx31 = odbc_fetch_array($resultx31)){
 $zcmd[] = $rowx31;
}



include "include/encour.php";
include "include/footer.php";
?>