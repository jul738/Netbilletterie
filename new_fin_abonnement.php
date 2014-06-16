<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
include_once("include/configav.php");

// on récupère les info envoye par new_suite_abonnement.php
$quanti=isset($_POST['quanti'])?$_POST['quanti']:"";
$num_abonnement=isset($_POST['num_abonnement'])?$_POST['num_abonnement']:"";
$num_client=isset($_POST['nom'])?$_POST['nom']:"";
$tarif_abonnement=isset($_POST['tarif_abonnement'])?$_POST['tarif_abonnement']:"";


if($num_bon==''){
$num_abonnement=isset($_POST['num_abonnement'])?$_POST['num_abonnement']:"";
$num_client=isset($_POST['nom'])?$_POST['nom']:"";
$tarif_abonnement=isset($_POST['tarif_abonnement'])?$_POST['tarif_abonnement']:"";
}
?>




<form name='formu3' method='post' action='new_suite_abonnement.php'>
          <table class="boiteaction">
          <caption>Ajouter un abonnement </caption>          
          <input type="submit" name="Submit" value='Ajouter un abonnement'>
          </form>
          </table>
    
Choisir quantité : 

Choisir le type d'abonnement : 

Choisir les spectacles : 

Page : new_fin_abonnement.php
Cette page liste les abonnement vendu et permet l'édition 




<?php
include_once("include/bas.php");
?>