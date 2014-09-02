<?php

/* Net Billetterie Copyright(C)2014 Vanessa Kovalsky David
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Vanessa Kovalsky vanessa.kovalsky@free.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");

// Si post du formulaire, on récupère les variable et on les enregistre 
if(isset($_POST)){
    // Récupère les variables
    if(isset($_POST['num_groupe'])){
        $num_groupe = $_POST['num_groupe'];
    }
    $nom_structure = $_POST['nom-groupe'];
    $adresse_structure = $_POST['adresse-groupe'];
    $telephone_structure = $_POST['telephone-groupe'];

    // Insert dans la base
    // Si nouveau alors création du groupe
    if(!isset($num_groupe)){
        $sql_insert_groupe = "INSERT INTO " . $tblpref ."groupe(nom_structure, adresse, telephone) VALUES('$nom_structure', '$adresse_structure', '$telephone_structure')";
        $requete_insert_groupe = mysql_query($sql_insert_groupe) or die('Erreur SQL création groupe !<br>'.$requete_insert_groupe.'<br>'.mysql_error());
        $num_groupe = mysql_insert_id();
    }
    // Si existant alors MAJ de la ligne
    else{
        $sql_update_groupe = "UPDATE " . $tblpref ."groupe SET nom_structure='".$nom_structure."', adresse='".$adresse_structure."', telephone='".$telephone_structure."' WHERE num_groupe=".$num_groupe." ";
        $requete_update_groupe = mysql_query($sql_update_groupe) or die('Erreur SQL création groupe !<br>'.$requete_update_groupe.'<br>'.mysql_error());
    }
}
//Si affichage, on récupère le numéro du groupe
elseif(isset($_GET['num_groupe'])){
    $num_groupe = $_GET['num_groupe'];
}

// On affiche un groupe

// Récupération des informations du groupe
$sql_select_groupe = "SELECT nom_structure, adresse, telephone FROM " . $tblpref ."groupe WHERE num_groupe=".$num_groupe."";
$requete_select_groupe = mysql_query($sql_select_groupe) or die('Erreur SQL sélection groupe !<br>'.$requete_select_groupe.'<br>'.mysql_error());
while($data_un_groupe = mysql_fetch_array($requete_select_groupe)){
    $nom_structure = $data_un_groupe['nom_structure'];
    $adresse_structure = $data_un_groupe['adresse'];
    $telephone_structure = $data_un_groupe['telephone'];
}
?>
<div id="groupe">
    <h3>Groupe <?php echo $nom_structure; ?></h3>
    <div id="nom-groupe">Nom structure : <?php echo $nom_structure; ?></div>
    <div id="adresse-groupe">Adresse structure : <?php echo $adresse_structure; ?></div>
    <div id="telephone-groupe">Téléphone structure : <?php echo $telephone_structure; ?></div>
</div>
<?php
include("include/bas.php");
?>