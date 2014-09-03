<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors: Vanessa Kovalsky vanessa.kovalsky@free.fr
 */
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
include_once("include/configav.php");

// on récupère le numero de la réservation"
$num_bon = isset($_GET['num_bon'])?$_GET['num_bon']:"";

// On récupère les informations liées à cette réservation 
$select_resa = "SELECT nom_tarif, prix_tarif, nom, prenom, article, horaire, date_spectacle, coment FROM " . $tblpref ."bon_comm AS bc, " . $tblpref ."article AS a, " . $tblpref ."tarif AS t, " . $tblpref ."client AS c WHERE bc.num_bon = '$num_bon' AND bc.id_tarif = t.id_tarif AND bc.id_article = a.num AND bc.client_num = c.num_client ";
$result_resa = mysql_query($select_resa) or die('Erreur SQL séléction de la réservation <br />'.$select_resa.'<br />');
while($resa = mysql_fetch_array($result_resa)){
    $nom_spectacle = $resa['article'];
    $date_spectacle = $resa['date_spectacle'];
    $heure_spectacle = $resa['horaire'];
    $nom_client = $resa['nom'];
    $prenom_client = $resa['prenom'];
    $type_tarif = $resa['nom_tarif'];
    $prix_tarif = $resa['prix_tarif'];
    $commentaire = $resa['coment'];
} 
?>
<div id="reservation">
    <h3>Réservation  de <?php echo $nom_client.' '.$prenom_client; ?> pour le spectacle <?php echo $nom_spectacle; ?></h3>
    <div id="nom-client">Nom du client : <?php echo $nom_client; ?></div>
    <div id="prenom-client">Prénom du client : <?php echo $prenom_client; ?></div>
    <div id="nom-spectacle">Nom du spectacle : <?php echo $nom_spectacle; ?></div>
    <div id="date-spectacle">Date : <?php echo $date_spectacle; ?></div>
    <div id="heure-spectacle">Heure : <?php echo $heure_spectacle; ?></div>
    <div id="type-tarif">Type de tarif : <?php echo $type_tarif; ?></div>
    <div id="prix-tarif">Prix : <?php echo $prix_tarif; ?></div>
    <div id="commentaire">Commentaire : <?php echo $commentaire; ?></div>
</div>
<?php
include("include/bas.php");
?>