<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
echo '<link rel="stylesheet" type="text/css" href="include/style.css">';
echo'<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >';

$num_bon=isset($_GET['num_bon'])?$_GET['num_bon']:"";
$nom=isset($_GET['nom'])?$_GET['nom']:"";
$billetterie=isset($_GET['billetterie'])?$_GET['billetterie']:"";

//On commence par mettre à jour le stock
// On récupère l'id de l'article 
$select_article = "SELECT bc.id_article, a.stock FROM " . $tblpref ."bon_comm AS bc, " . $tblpref ."article AS a WHERE num_bon='".$num_bon."' AND bc.id_article = a.num";
$req_article = mysql_query($select_article) or die ('Erreur SQL séléction article');
While($data_article = mysql_fetch_array($req_article)){
    $article = $data_article['id_article'];
    $stock_ancien = $data_article['stock'];
}
// On met à jour le stock
$update_stock = "UPDATE " . $tblpref ."article SET stock = '$stock_ancien'+1 WHERE num = '$article'";
$req_stock = mysql_query($update_stock) or die('Erreur SQL maj stock');

//On supprime la réservation
	mysql_select_db($db) or die ("Could not select $db database");
	$sql1 = "DELETE FROM " . $tblpref ."bon_comm WHERE num_bon = '".$num_bon."'";
	mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
	$message= "<center><h1>$lang_bon_effa";
	if ($billetterie !=""){
		include("lister_billetterie.php");
	}
	else {
		include("lister_commandes.php");
		echo "$billetterie";
	}

        
        
include('delete_message.php');
exit;
 ?> 
