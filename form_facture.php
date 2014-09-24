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
//Sinon on récupère les infos pour créer la facture
else {
    $num_groupe = $_GET['num_groupe'];
    $num_resa = $_GET['num_resa'];
    $type_facture = $_GET['type'];
    $type_resa = $_GET['type_resa'];
}

//on récupère le nombre de billet

//On récupère le tarif

//On récupère les infos pour le calcul du total

?>
<!-- On affiche le formulaire -->
<div id="form-facture">
        <h3><?php if(!isset($_GET['num_facture'])){echo "Formulaire de création d'une facture pour le spectacle et pour le client";} else { echo "Formulaire de modification d'une facture pour le spectacle et pour le client";}?></h3>
    <form action="facture.php" method="post" id="form-facture">
        <label for="numero-facture">Numéro de facture</label><input type="text" name="numero-facture" id="numero-facture"></input><br />
        <label for="type-facture">Type de facture</label><select id="type-facture" name="type-facture">
            <option value="acompte">Acompte</option>
            <option value="finale">Finale</option>
        </select><br />
        <label for="type-résa">Type de réservation</label><select id="type-resa" name="type-resa" readonly>
            <option value="Groupe">Groupe</option>
            <option value="Billet particulier">Billet Particulier</option>
            <option value="abonnement">Abonnement</option>
        </select><br />
        <label for="total">Total (calculé automatiquement en fonction du type de facture)</label><input type="text" name="total" id="total" readonly></input><br />
        <label for="type-paiement">Moyen de paiement</label><select id="type-paiement" name="type-paiement">
            <!-- On boucle sur les moyen de paiement -->
        </select><br />
        <label for="date-paiement">Date du paiement</label><input type="date" id="date-paiement" name="date-paiement"></input><br />
        <label for="commentaire-facture">Commentaire sur la facture</label>x<textarea id="commentaire-facture" name="commentaire-facture"></textarea><br />
    </form>
</div>