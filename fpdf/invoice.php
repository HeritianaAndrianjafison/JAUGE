<?php
require('fpdf.php');


createFact("PRF121802100004");

function createFact($numfact){
$serverx3='192.168.130.170\SAGE';
$databasex3="basex3";
$userx3="JOVPROD";
$passwordx3="tiger";

global $connectionodbcx3;
$connectionodbcx3 = odbc_connect("Driver={SQL Server};Server=$serverx3;Database=$databasex3;", $userx3, $passwordx3);

//$numfact = "CCNSVOH08000007";
$sql ="SELECT SINVOICE.BPRNAM_0,
			  SINVOICE.BPR_0,
			  SINVOICE.NUM_0,
			  SINVOICE.BPAADDLIG_0,
			  SINVOICE.BPAADDLIG_1,
			  SINVOICE.BPAADDLIG_2,

			  SINVOICEV.SIHORIDAT_0,
			  SINVOICEV.INVREF_0,
			  SINVOICEV.SIHORI_0,
			  SINVOICEV.SIHORINUM_0,
			  SINVOICEV.INVDAT_0,

			  BPARTNER.BPRNAM_0,
			  BPARTNER.ZNIF_0,
			  BPARTNER.ZSTAT_0,
			  BPARTNER.ZQUITTANCE_0,
			  BPARTNER.ZQUITTANCE_0,
			  BPARTNER.ZCARTE_0,
			  BPARTNER.ZRC_0,
			  FACILITY.FCYNAM_0,
			  FACILITY1.FCYNAM_0 AS FCYNAM_1,
			  SDELIVERY.SOHNUM_0,
			  BPADDRESS.*,BPARTNER.* FROM SINVOICE 

			  INNER JOIN SINVOICED ON SINVOICE.NUM_0 =SINVOICED.NUM_0
			  LEFT JOIN SDELIVERY ON SINVOICED.SDHNUM_0 = SDELIVERY.SDHNUM_0
			  INNER JOIN SINVOICEV ON SINVOICE.NUM_0 = SINVOICEV.NUM_0
			  LEFT JOIN FACILITY ON SINVOICEV.STOFCY_0 = FACILITY.FCY_0
			  LEFT JOIN FACILITY AS FACILITY1 ON SINVOICEV.SALFCY_0 = FACILITY1.FCY_0
			  INNER JOIN BPADDRESS ON SINVOICE.BPRPAY_0 = BPADDRESS.BPANUM_0  
			  INNER JOIN BPARTNER ON SINVOICE.BPRPAY_0 = BPARTNER.BPRNUM_0 

			  WHERE SINVOICE.NUM_0='$numfact'";


$result = odbc_exec($connectionodbcx3,$sql);
$row = odbc_fetch_array($result);

$pdf = new FPDF();
$pdf->AddPage();


/******** Entête */
$pdf->Image('logo.jpg',10,10,30);

$pdf->SetFont('Helvetica',null,8);
$pdf->Cell(50,10,'',0,0);

$pdf->Ln();

$pdf->SetLineWidth(0.4);
$pdf->Cell(70,4,'S.A. au capital de Ar 32 866 338 000',0,0);

$pdf->Ln();

$pdf->Cell(50,4,'KUBE A - Zone GALAXY Andraharo',0,0);


$pdf->Ln();

$pdf->Cell(80,5,'Tel: 23 694 70 - Mobile : 032 07 202 20',0,0);
//$pdf->Cell(5,4,'',0,0);

$pdf->SetFont('Helvetica','B',10);
$pdf->Cell(35,5,'FACTURE CLIENT',0,0);
//$pdf->Cell(5,4,' ',0,0);
$pdf->Cell(45,5,iconv('UTF-8','windows-1252', 'N° '.$row["NUM_0"]),1,0);
$pdf->SetFont('Helvetica',null,8);
$pdf->Ln();

$pdf->Cell(70,5,'Andraharo BP 12 085 - Antananarivo 10',0,0);


$pdf->Ln();

$pdf->Cell(80,5,'Stat : 19201111999000183 - NIF : 2000002263',0,0);
$pdf->Cell(25,5,$row["FCYNAM_1"].' le '.f_date($row["INVDAT_0"]),0,0);
$pdf->Cell(5,5,' ',0,0);
//$pdf->Cell(32,5,iconv('UTF-8','windows-1252', '--------'),0,0);


$pdf->Ln();

$pdf->Cell(70,4,'C.P. : 0048489/DGI-G du 22/05/2019',0,0);


$pdf->Ln();

$pdf->Cell(70,4,'Quit. : 371869 du 13/05/2019',0,0);


$pdf->Ln();

$pdf->Cell(90,4,'Sce Client : 020 30 807 77 - 032 32 037 77 - 033 65 807 77',0,0);
$pdf->SetFont('Helvetica',null,8);
$pdf->Cell(25,4,'CODE CLIENT',0,0);
$pdf->Cell(5,4,' ',0,0);
$pdf->Cell(32,4,iconv('UTF-8','windows-1252', $row["BPR_0"]),0,0);

$pdf->Ln();

$pdf->Cell(50,10,'',0,0);

$pdf->Ln();

$pdf->Cell(40,4,'DEPOT LIVREUR',0,0);
$pdf->Cell(40,4,$row['FCYNAM_0'],1,0);
$pdf->Cell(30,4,'CLIENT:',0,0);
$pdf->Cell(32,4,iconv('UTF-8','windows-1252', $row["BPRNAM_0"]),0,0);

$pdf->Ln();

$pdf->Cell(40,4,'DATE LIVRAISON :',0,0);
$pdf->Cell(40,4,f_date($row['SIHORIDAT_0']),1,0);


$pdf->Ln();

$sohnum = $row["SOHNUM_0"];
$sihori = $row["SIHORI_0"];
$sihorinum = $row["SIHORINUM_0"];
$pdf->Cell(40,4,'PRISE DE COMMANDE :',0,0);
$pdf->Cell(40,4,commande($sihori,$sohnum,$sihorinum),1,0);

$pdf->Ln();
$pdf->Cell(50,4,'',0,0);
$pdf->Ln();
$pdf->Cell(40,4,'REF. COMMANDE CLIENT :',0,0);
$pdf->Cell(40,4,$row["INVREF_0"],1,0);
$pdf->Cell(30,4,'PAYEUR:',0,0);
$pdf->Cell(52,4,$row["BPRNAM_0"],1,0);

$pdf->Ln();
$pdf->Cell(40,4,'NIF :',0,0);
$pdf->Cell(40,4,$row["ZNIF_0"],1,0);
$pdf->Cell(30,4,'ADRESSE:',0,0);
$pdf->Cell(52,4,$row["BPAADDLIG_0"],'LTR',0);

$pdf->Ln();
$pdf->Cell(40,4,'STAT :',0,0);
$pdf->Cell(40,4,$row["ZSTAT_0"],1,0);
$pdf->Cell(30,4,$row["BPAADDLIG_1"],0,0);
$pdf->Cell(52,4,'','LR',0);

$pdf->Ln();

$pdf->Cell(40,4,'TP :',0,0);
$pdf->Cell(40,4,$row["ZQUITTANCE_0"],1,0);
$pdf->Cell(30,4,$row["BPAADDLIG_2"],0,0);
$pdf->Cell(52,4,'','LBR',0);

$pdf->Ln();

$pdf->Cell(40,4,'C.I.F. :',0,0);
$pdf->Cell(40,4,$row["ZCARTE_0"],1,0);

$pdf->Ln();

$pdf->Cell(40,4,'R.C. :',0,0);
$pdf->Cell(40,4,rc_elec($row["ZRC_0"]).$row["ZRC_0"],1,0);
/******** Fin entête */

/******** corp */
//{SINVOICE.AMTTAX_0}+{SINVOICE.AMTTAX_1}+{SINVOICE.AMTTAX_2}+{SINVOICE.AMTTAX_3}+{SINVOICE.AMTTAX_4}+{SINVOICE.AMTTAX_5}+{SINVOICE.AMTTAX_6}+{SINVOICE.AMTTAX_7}+{SINVOICE.AMTTAX_8}+{SINVOICE.AMTTAX_9}

$sql1 = "SELECT SINVOICED.ITMREF_0,
				SINVOICED.QTY_0,
				SINVOICED.NETPRI_0,
				SINVOICED.DISCRGVAL3_0,
				SINVOICED.DISCRGVAL4_0,
				SINVOICED.DISCRGVAL5_0,
				SINVOICED.DISCRGVAL6_0,
				SINVOICED.VAT_0,
				SINVOICED.AMTNOTLIN_0,
				
				SINVOICE.AMTTAX_0,
				SINVOICE.AMTTAX_1,
				SINVOICE.AMTTAX_2,
				SINVOICE.AMTTAX_3,
				SINVOICE.AMTTAX_4,
				SINVOICE.AMTTAX_5,
				SINVOICE.AMTTAX_6,
				SINVOICE.AMTTAX_7,
				SINVOICE.AMTTAX_8,
				SINVOICE.AMTTAX_9,

				SORDER.VACBPR_0,
				SINVOICED.ITMDES1_0,
				TABUNIT.UOM_0,
				ATEXTRA.TEXTE_0
 FROM SINVOICED 
 INNER JOIN SINVOICE ON SINVOICED.NUM_0 =SINVOICE.NUM_0
 INNER JOIN SORDER ON SINVOICED.SOHNUM_0 = SORDER.SOHNUM_0

LEFT JOIN TABUNIT ON SINVOICED.SAU_0 = TABUNIT.UOM_0
LEFT JOIN ATEXTRA ON TABUNIT.UOM_0 = ATEXTRA.IDENT1_0
  WHERE SINVOICED.NUM_0='$numfact' AND ATEXTRA.LANGUE_0 = 'FRA' AND ATEXTRA.ZONE_0='DES'";


//{SINVOICEV.INSATI_0} + {SINVOICEV.INSATI_1} + {SINVOICEV.INSATI_2} + {SINVOICEV.INSATI_3}
$sql1 = "SELECT SINVOICED.ITMREF_0,
				SINVOICED.QTY_0,
				SINVOICED.NETPRI_0,
				SINVOICED.DISCRGVAL3_0,
				SINVOICED.DISCRGVAL4_0,
				SINVOICED.DISCRGVAL5_0,
				SINVOICED.DISCRGVAL6_0,
				SINVOICED.VAT_0,
				SINVOICED.AMTNOTLIN_0,

				SINVOICEV.INSATI_0,
				SINVOICEV.INSATI_1,
				SINVOICEV.INSATI_2,
				SINVOICEV.INSATI_3,
				SINVOICEV.SIHORI_0,
				SINVOICEV.SIHORINUM_0,


				SINVOICE.AMTATI_0,
				SINVOICE.AMTTAX_0,
				SINVOICE.AMTTAX_1,
				SINVOICE.AMTTAX_2,
				SINVOICE.AMTTAX_3,
				SINVOICE.AMTTAX_4,
				SINVOICE.AMTTAX_5,
				SINVOICE.AMTTAX_6,
				SINVOICE.AMTTAX_7,
				SINVOICE.AMTTAX_8,
				SINVOICE.AMTTAX_9,
				SINVOICE.BPR_0,

				SORDER.VACBPR_0,
				SINVOICED.ITMDES1_0,
				TABUNIT.UOM_0,
				ATEXTRA.TEXTE_0,
				SDELIVERY.ZBEMAN_0,
				SDELIVERY.SDHNUM_0,
				SDELIVERY.SOHNUM_0,

				GACCDUDATE.PAM_0,
				GACCDUDATE.TMPCUR_0,
				GACCDUDATE.PAYCUR_0,
				GACCDUDATE.AMTCUR_0,
				GACCDUDATE.DUDDAT_0
 FROM SINVOICE 
 INNER JOIN SINVOICEV ON SINVOICE.NUM_0 =SINVOICEV.NUM_0
 INNER JOIN SINVOICED ON SINVOICE.NUM_0 =SINVOICED.NUM_0
 INNER JOIN SORDER ON SINVOICED.SOHNUM_0 = SORDER.SOHNUM_0
LEFT JOIN GACCDUDATE ON SINVOICE.NUM_0 = GACCDUDATE.NUM_0
LEFT JOIN SDELIVERY ON SINVOICED.SDHNUM_0 = SDELIVERY.SDHNUM_0
LEFT JOIN TABUNIT ON SINVOICED.SAU_0 = TABUNIT.UOM_0
LEFT JOIN ATEXTRA ON TABUNIT.UOM_0 = ATEXTRA.IDENT1_0
  WHERE SINVOICED.NUM_0='$numfact' AND ATEXTRA.LANGUE_0 = 'FRA' AND ATEXTRA.ZONE_0='DES'";
// 
//INNER JOIN SINVOICEV ON SINVOICE.NUM_0 = SINVOICEV.NUM_0
//echo $sql1;

$result1 = odbc_exec($connectionodbcx3,$sql1);


$pdf->Ln();
/***Entête tableau***/
$pdf->Cell(50,10,'',0,0);
$pdf->Ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,6,iconv('UTF-8','windows-1252', 'Référence'),1,0);
$pdf->Cell(40,6,iconv('UTF-8','windows-1252', 'Désignation'),1,0);
$pdf->Cell(30,6,iconv('UTF-8','windows-1252', 'Conditionnement'),1,0);
$pdf->Cell(30,6,iconv('UTF-8','windows-1252', 'Qté'),1,0);
$pdf->Cell(30,6,iconv('UTF-8','windows-1252', 'PU H.T.'),1,0);
$pdf->Cell(30,6,iconv('UTF-8','windows-1252', 'Montant HT'),1,0);
/***Fin entête du tableau***/
$nontaxlin = 0;
$taxlin = 0;


while($row1=odbc_fetch_array($result1)){
print_r($row1);
$mode = $row1["PAM_0"];
$bpr = $row1["BPR_0"];
$tmpcur = $row1["TMPCUR_0"];
$paycur = $row1["PAYCUR_0"];
$amtcur = $row1["AMTCUR_0"];
$duddat = $row1["DUDDAT_0"];
$sohnum = $row1["SOHNUM_0"];
$sihori = $row1["SIHORI_0"];
$sihorinum = $row1["SIHORINUM_0"];
$mtacompte = $row1["INSATI_0"]+$row1["INSATI_1"]+$row1["INSATI_2"]+$row1["INSATI_3"];
$montant = $row1["AMTATI_0"];
$pdf->Ln();
$pdf->SetFont('Arial',null,8);
$pdf->Cell(20,5,iconv('UTF-8','UTF-8', $row1["ITMREF_0"]),1,0);
$designation = $row1["ITMDES1_0"];
$fdesignation = designation($row1["ITMDES1_0"],$row1["VACBPR_0"]);
if($fdesignation!=null){
	$designation = $fdesignation;
}

$zbeman = $row1["ZBEMAN_0"];
$bl = $row1["SDHNUM_0"];
//x3_encode($designation)
$pdf->Cell(40,5,$designation,1,0);
$pdf->Cell(30,5,iconv('UTF-8','windows-1252', $row1["TEXTE_0"]),1,0);
$pdf->Cell(30,5,iconv('UTF-8','windows-1252', nb_f($row1["QTY_0"])),1,0,'R');
// PU_HT {SINVOICED.NETPRI_0}+{SINVOICED.DISCRGVAL3_0}+{SINVOICED.DISCRGVAL4_0}+{SINVOICED.DISCRGVAL5_0}+{SINVOICED.DISCRGVAL6_0}
$pu_ht = $row1["NETPRI_0"]+$row1["DISCRGVAL3_0"]+$row1["DISCRGVAL4_0"]+$row1["DISCRGVAL5_0"]+$row1["DISCRGVAL6_0"];
//{@PU_HT}*{SINVOICED.QTY_0}
$montant_ht = $pu_ht*$row1["QTY_0"];
//{SINVOICED.VAT_0}="600" or {SINVOICED.VAT_0}="700" or {SINVOICED.VAT_0}="701" or {SINVOICED.VAT_0}="799"
	if ($row1["VAT_0"]=="700" OR $row1["VAT_0"]=="600" OR $row1["VAT_0"]=="701" OR $row1["VAT_0"]=="799") 
    {
    		$nontaxlin += $row1["AMTNOTLIN_0"];
    }else{
    		$taxlin += $montant_ht;
    }
$total_taxe = $row1["AMTTAX_0"]+$row1["AMTTAX_1"]+$row1["AMTTAX_2"]+$row1["AMTTAX_3"]+$row1["AMTTAX_4"]+$row1["AMTTAX_5"]+$row1["AMTTAX_6"]+$row1["AMTTAX_7"]+$row1["AMTTAX_8"]+$row1["AMTTAX_9"];

$pdf->Cell(30,5,nb_f($pu_ht),1,0,'R');
$pdf->Cell(30,5,nb_f($montant_ht),1,0,'R');
}

$pdf->Ln();

$pdf->Cell(120,5,"BNI-CA Ankorondrano : 00005 00007 11451290100 96",0,0);
$pdf->Cell(30,5,"Base non taxable",1,0);
$pdf->Cell(30,5,nb_f($nontaxlin),1,0,'R');

$pdf->Ln();

$pdf->Cell(120,5,"BTM/BOA Ankazomanga : 00009 05055 16612040119 36",0,0);
$pdf->Cell(30,5,iconv('UTF-8','windows-1252', 'Base taxable'),1,0);
$pdf->Cell(30,5,nb_f($taxlin),1,0,'R');

$pdf->Ln();
//{SINVOICE.AMTTAX_0}+{SINVOICE.AMTTAX_1}+{SINVOICE.AMTTAX_2}+{SINVOICE.AMTTAX_3}+{SINVOICE.AMTTAX_4}+{SINVOICE.AMTTAX_5}+{SINVOICE.AMTTAX_6}+{SINVOICE.AMTTAX_7}+{SINVOICE.AMTTAX_8}+{SINVOICE.AMTTAX_9}

$pdf->Cell(120,5,"",0,0);
$pdf->Cell(30,5,l_tva($bpr)." ",1,0);
$pdf->Cell(30,5,nb_f($total_taxe),1,0,'R');

$pdf->Ln();

$pdf->Cell(30,5,"BE Correspondant :",0,0);
$pdf->Cell(90,5,be($bpr,$bl,$zbeman),0,0);
$pdf->Cell(30,5,'MONTANT TOTAL',1,0);
$pdf->Cell(30,5,nb_f($montant),1,0,'R');

$pdf->Ln();

$pdf->Cell(30,5,"BL Correspondant :",0,0);
$pdf->Cell(90,5,$bl,0,0);
$pdf->Cell(30,5,'Acompte',1,0);
$pdf->Cell(30,5,nb_f($mtacompte),1,0,'R');

$pdf->Ln();

$pdf->Cell(30,5,"BL Manuel :",0,0);
$pdf->Cell(90,5,$zbeman,0,0);
$pdf->Cell(30,5,iconv('UTF-8','windows-1252', 'Timbre'),1,0);
$pdf->Cell(30,5,iconv('UTF-8','windows-1252', 'A vérifer'),1,0,'R');

$pdf->Ln();

$pdf->Cell(120,5,iconv('UTF-8','windows-1252', "Arrêtée la présente facture à la somme de:"),0,0);

$pdf->Cell(30,5,iconv('UTF-8','windows-1252', 'NET A PAYER (1)'),1,0);
$pdf->Cell(30,5,iconv('UTF-8','windows-1252', nb_f($montant-$mtacompte)),1,0,'R');

$pdf->Ln();

$fmt = new NumberFormatter('fr', NumberFormatter::SPELLOUT);
$montantl = $fmt->format($montant-$mtacompte);

$pdf->Cell(100,5,$montantl,'LTR',0);
$pdf->Cell(20,5,'',0,0);
$pdf->Cell(30,5,'',0,0);
$pdf->Cell(30,5,'',0,0,'R');

$pdf->Ln();

$pdf->Cell(100,5,iconv('UTF-8','windows-1252', "Ariary"),'LBR',0);
$pdf->Cell(20,5,'',0,0);

$pdf->Ln();

$pdf->Cell(100,5,iconv('UTF-8','windows-1252', "Mode de règlement:"),0,0);

$pdf->Ln();

$pdf->Cell(30,5,iconv('UTF-8','windows-1252', 'Mode'),'LT',0);
$pdf->Cell(30,5,iconv('UTF-8','windows-1252', 'Acompte'),'T',0);
$pdf->Cell(30,5,iconv('UTF-8','windows-1252', 'A crédit'),'T',0);
$pdf->Cell(30,5,iconv('UTF-8','windows-1252', 'Echéances'),'T',0,'R');
$pdf->Cell(30,5,iconv('UTF-8','windows-1252', ''),'T',0,'R');
$pdf->Cell(30,5,iconv('UTF-8','windows-1252', ''),'RT',0,'R');

$pdf->Ln();

$pdf->Cell(30,5,iconv('UTF-8','windows-1252', mode($mode)),'LB',0);
$pdf->Cell(30,5,nb_f($paycur+$tmpcur),'B',0);
$pdf->Cell(30,5,nb_f($amtcur-$paycur-$tmpcur),'B',0);
$pdf->Cell(30,5,f_date($duddat),'B',0,'R');
$pdf->Cell(30,5,'','B',0,'B');
$pdf->Cell(30,5,'','RB',0,'R');

$pdf->Ln();
$pdf->Cell(30,5,'',0,0);
$pdf->Ln();
$pdf->Cell(30,5,'',0,0);
$pdf->Ln();
$pdf->Cell(30,5,'',0,0);
$pdf->Ln();
$pdf->Cell(70,5,iconv('UTF-8','windows-1252', 'Signature Client'),0,0);
$pdf->Cell(70,5,iconv('UTF-8','windows-1252', 'Signature Transporteur'),0,0);
$pdf->Cell(30,5,iconv('UTF-8','windows-1252', 'Signature Jovena'),0,0);
$pdf->Ln();
$pdf->Cell(30,5,'',0,0);
$pdf->Ln();
$pdf->Cell(70,5,iconv('UTF-8','windows-1252', 'Nom'),0,0);
$pdf->Cell(70,5,iconv('UTF-8','windows-1252', 'Nom'),0,0);
$pdf->Cell(30,5,'',0,0);
$pdf->Output("img/$numfact.pdf","I");



}











function x3_encode($string){
	return iconv('UTF-8', 'ASCII//TRANSLIT', utf8_encode($string));
}
function rc_elec($BPR){

if ($BPR == "3101040"){return "6374/";}
if ($BPR == "3105432"){return "7283/";}
if ($BPR == "3101120"){return "4182/";} 
if ($BPR == "3105434"){return "6376/";}
if ($BPR == "3105430"){return "8440/";}

return "";
}
function designation($itmref,$vacbpr){
 
	if($vacbpr == "CZF" AND preg_match("^GAO", $itmref)) {return "Gasoil détaxé Z.F.";}
	if(($vacbpr == "SL2" OR $vacbpr == "SOU") AND preg_match("^GAO", $itmref)) {return "Gasoil Soute HTT Locale";}
	if(($vacbpr == "SL2" OR $vacbpr == "SOU") AND preg_match("^FUO", $itmref)) {return "Fueloil Soute HTT Locale";}
	if(($vacbpr == "SA2" OR $vacbpr == "STA" OR $vacbpr == "ST0" ) AND preg_match("^GAO", $itmref)) {return "Gasoil Soute Acquitté";}
	if(($vacbpr == "SA2" OR $vacbpr == "STA" OR $vacbpr == "ST0" ) AND preg_match("^FUO", $itmref)) {return "Fueloil Soute Acquitté";}
	if($vacbpr == "STI" AND preg_match("^GAO", $itmref)) {return "Gasoil Soute HTT Internationale";}
	if($vacbpr == "STI" AND preg_match("^FUO", $itmref)) {return "Fueloil Soute HTT Internationale";}
	return null;
	
}
function nb_f($num){
	return number_format($num,2,',',' ');
}
function commande($sihori,$sohnum,$sihorinum){
	if ($sihori == 2){return $sihorinum;}
 
   if ($sihori==3){return $sohnum;} 
}

function l_tva($bpr){

	if($bpr!="3606042" AND $bpr!="3601194" AND $bpr!="3606049" AND $bpr!="3606051"){
		return "TVA 0%";
	}
	return "TVA";
}
function be($bpr,$sdhnum,$zbeman){
$zbeman =trim($zbeman);
	if($bpr=='3103081'AND ($zbeman!='' or $zbeman!=null)){
		return trim($sdhnum." & ".$zbeman);
	}
	if($bpr=='3101600'AND ($zbeman!='' or $zbeman!=null)){
		return $zbeman;
	}
	return trim($sdhnum);

}
function f_date($date){
	$date = date("d/m/Y", strtotime($date)); 
    return $date;
}
function mode($mode){
		if ($mode=="CHQ"){
			return "CHEQUE";
		}
		if ($mode=="TK"){
			return "TICKET";
		}
		if ($mode=="TRT" OR $mode=="TAC"){
			return "TRAITE";
		}
		if ($mode=="CCAL"){
			return "CCAL";
		}
		if ($mode=="COM"){
			return "";
		}
		if ($mode=="VIR"){
			return "VIREMENT";
		} 
		if ($mode=="ESP"){
			return "ESPECE";
		}
		if ($mode=="RECEPFACT"){
			return "A LA RECEPTION";
		}   
}
	
?>