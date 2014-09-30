<?php 
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr*/
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
require_once("include/configav.php");

$article=isset($_POST['article'])?$_POST['article']:"";
$num_bon=isset($_POST['num_bon'])?$_POST['num_bon']:"";
$id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";
$ancien_article = isset($_POST['ancien_article'])?$_POST['ancien_article']:"";
$commentaire = isset($_POST['coment'])?mysql_escape_string($_POST['coment']):"";
$date = date('Y-m-d');

// On met à jour la réservation
$update_resa = "UPDATE bon_comm SET date = '$date' , user = '$user', coment = '$commentaire', id_tarif = '$id_tarif',id_article = '$article' WHERE num_bon = '$num_bon'";
mysql_query($update_resa) or die ('Erreur SQL MAJ réservation');

// Si l'article à changer on met à jour le stock
if ($article != $ancien_article){
    // On récupère le stock de l'ancien article
    $select_ancien_stock = "SELECT stock FROM article WHERE num = '$ancien_article'";
    $result_ancien_stock = mysql_query($select_ancien_stock) or die ('Erreur SQL select ancien stock de l\'ancienne article');
    while($ancien_stock = mysql_fetch_array($result_ancien_stock)){
        $stock_ancien_article = $ancien_stock['stock'];
    }
    // On ajoute 1 à l'ancien article
    $update_stock_ancien = "UPDATE article SET stock =  $stock_ancien_article +1 WHERE num = '$ancien_article'";
    mysql_query($update_stock_ancien) or die ('Erreur SQL MAJ stock de l\'ancien article');
    // On récupère le stock du nouvel article
    $select_stock = "SELECT stock FROM article WHERE num = '$article'";
    $result_stock = mysql_query($select_stock) or die ('Erreur SQL select ancien stock de l\'ancienne article');
    while($stock = mysql_fetch_array($result_stock)){
        $stock_article = $stock['stock'];
    }
    // On décrémente le stock pour le nouvel article
    $update_stock = "UPDATE article SET stock = $stock_article -1 WHERE num = '$article'";
    mysql_query($update_stock) or die ('Erreur SQL MAJ stock nouvel article');
}
$message = "La réservation n°$num_bon a bien été modifiée";
include('lister_commandes.php');
?>