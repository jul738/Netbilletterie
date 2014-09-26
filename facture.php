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

//On récupère la facture si elle existe
if(isset($_GET['num_facture'])){
    //On fait une requête pour récupérer les infos
}
//Sinon on récupère les informations passées dans le formulaire pour enregistrer la facture
else{
    $num_facture = $_POST['num-facture'];
    $num_resa = $_POST['num-resa'];
    $type_resa = $_POST['type-resa'];
    $type_facture = $_POST['type-facture'];
    $numero_facture = mysql_escape_string($_POST['numero-facture']);
    $moyen_paiement = $_POST['paiement'];
    $date_paiement = $_POST['date-paiement'];
    $commentaire_facture = mysql_escape_string($_POST['commentaire-facture']);
    //On récupère les tarifs de la résa et le nombre en cas de groupe
    switch($type_resa) {
        case 'groupe':
            $select_nb_resa_groupe = "SELECT nb_enfants, nb_accompagnateurs, nb_gratuit, nb_enfants_reel, nb_accompagnateurs_reel, nb_gratuit_reel, prix_tarif FROM bon_comm_groupe AS bcg, tarif AS t WHERE bcg.num_bon_groupe = '$num_resa'";
            $req_nb_resa_groupe = mysql_query($select_nb_resa_groupe) or die ('Erreur séléction réservation du groupe');
            while($data_nb_resa_groupe = mysql_fetch_array($req_nb_resa_groupe)){
                $nb_enfants_prevus = $data_nb_resa_groupe['nb_enfants'];
                $nb_enfants_reel = $data_nb_resa_groupe['nb_enfants_reel'];
                $nb_accompagnateurs_prevu = $data_nb_resa_groupe['nb_accompagnateurs'];
                $nb_accompagnateurs_reel = $data_nb_resa_groupe['nb_accompagnateurs_reel'];
                $nb_gratuits_prevu = $data_nb_resa_groupe['nb_gratuit'];
                $nb_gratuits_reel = $data_nb_resa_groupe['nb_gratuit_reel'];
                $tarif = $data_nb_resa_groupe['prix_tarif'];
            }
            break;
        case 'abonnement' :
            break;
        case 'particulier' : 
            break;
    };
    //On calcul le total
    if($type_facture =="acompte"){
        if($type_resa =='groupe'){
            $nb_resa = $nb_enfants_prevus + ($nb_accompagnateurs_prevu - $nb_gratuits_prevu);
        }
        else {
            $nb_resa = 1;
        }
        $total = ($nb_resa * $tarif) /2;
    }
    else {
        if($type_resa =='groupe'){
            $nb_resa = $nb_enfants_reel + ($nb_accompagnateurs_reel - $nb_gratuits_reel);
        }
        else {
            $nb_resa = 1;
        }
        $total = $nb_resa * $tarif;
    }
    //Si num_facture est vide alors on créé la facture
   if(empty($num_facture)){
        $sql_insert_facture = "INSERT INTO " . $tblpref ."facture(type_facture, type_resa, id_resa, id_paiement, total, date_paiement, numero_facture, commentaire) VALUES('$type_facture', '$type_resa', '$num_resa', '$moyen_paiement', '$total', '$date_paiement', '$numero_facture', '$commentaire')";
        $requete_insert_facture = mysql_query($sql_insert_facture) or die('Erreur SQL création facture!<br>'.$requete_insert_facture.'<br>'.mysql_error());
        $num_facture = mysql_insert_id();   
   }
   else{
       $sql_update_facture = "UPDATE facture WHERE num_facture='$num_facture'";
   }
}

?>