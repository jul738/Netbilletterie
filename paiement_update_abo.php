<?php 
/* Net Billetterie Copyright(C)2012 Jose Das Neves
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Jose Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");

$paiement=isset($_POST['paiement'])?$_POST['paiement']:"";
$paiement= AddSlashes($paiement);
$banque=isset($_POST['banque'])?$_POST['banque']:"";
$banque= AddSlashes($banque);
$coment=isset($_POST['coment'])?$_POST['coment']:"";
$coment= AddSlashes($coment);
$ctrl=isset($_POST['ctrl'])?$_POST['ctrl']:"";
$date_fact=isset($_POST['date_fact'])?$_POST['date_fact']:"";
$dateScind = explode("-", $date_fact);
$jour = $dateScind[0];
$mois = $dateScind[1];
$annee = $dateScind[2];
$date_fact=$annee."-".$mois."-".$jour; 
$titulaire_cheque=isset($_POST['titulaire_cheque'])?$_POST['titulaire_cheque']:"";
$pointage=isset($_POST['pointage'])?$_POST['pointage']:"";
$num_abo_com=isset($_POST['num_abo_com'])?$_POST['num_abo_com']:"";


$sql22 = "UPDATE `".$tblpref."abonnement_comm` SET `paiement`='$paiement', `banque`='$banque', `date_fact`='$date_fact', `coment`='$coment', `ctrl`='$ctrl', `titulaire_cheque` = '$titulaire_cheque', `fact`='$pointage'
WHERE `num_abo_com` ='".$num_abo_com."' ";
mysql_query($sql22) OR die("<p>Erreur Mysql<br/>$sql22<br/>".mysql_error()."</p>");

if($pointage=="ok"){
$message= "<h1>La reservation <font color=red> Numero $num_abo_com </font>est enregistree comme encaissee. <br/> Elle ne peux plus etre modifiee. C'est pour cette raison qu'elle n'est plus presentee dans la liste ci-dessous</h1>";
}
else{
	$message= "<center><h1>La reservation <font color='#009EDF'> Numero $num_abo_com </font> a bien ete modifiee</h1></center>";
	}
require("lister_commandes_non_fact_abo.php");
 ?> 



