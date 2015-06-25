<?php

/* Net Billetterie Copyright(C)2014 Vanessa Kovalsky David
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors: Vanessa Kovalsky vanessa.kovalsky@free.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
include_once("include/fonction.php");


// ON affiche les groupes dans un tableau
?>
<center><table class="boiteaction page display" id="datatables-liste-facture">
        <caption>Liste des factures</caption>
        <thead>
        <tr>
            <th>Numéro de facture</th>
            <th>Nom de la structure</th>
            <th>Nom du spectacle</th>
            <th>Date du spectacle</th>
            <th>Horaire du spectacle</th>
            <th>Type de facture</th>
            <th>Montant</th>
            <th>Payée ?</th>
            <th>Date du paiement</th>
            <th>Commentaire</th>
            <th>Voir</th>
            <th>Modifier</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Numéro de facture</th>
            <th>Nom de la structure</th>
            <th>Nom du spectacle</th>
            <th>Date du spectacle</th>
            <th>Horaire du spectacle</th>
            <th>Type de facture</th>
            <th>Montant</th>
            <th>Payée ?</th>
            <th>Date du paiement</th>
            <th>Commentaire</th>
            <th>Voir</th>
            <th>Modifier</th>
        </tr>
        </tfoot>

    </table></center>
<?php
include_once("include/bas.php");
?>
<script>

    jQuery(document).ready(function() {
    var table = jQuery('#datatables-liste-facture').dataTable( {
        "sPaginationType":"full_numbers",
	"bJQueryUI":true,
	"bStateSave": true,
        "bProcessing": true,
        "aaSorting": [[0,"asc"]],
        "sAjaxSource": 'lister_facture_sql.php',
        "aoColumns": [
                        { mDataProp: 'num_facture' },
                        { mDataProp: 'nom_structure' },
                        { mDataProp: 'nom_spectacle' },
                        { mDataProp: 'date' },
                        { mDataProp: 'horaire' },
                        { mDataProp: 'type' },
                        { mDataProp: 'montant' },
                        { mDataProp: 'payee' },
                        { mDataProp: 'date_paiement' },
                        { mDataProp: 'commentaire' },
                        { mDataProp: 'voir' },
                        { mDataProp: 'modifier' },
                ]
    } );
    jQuery("#dialogue").dialog({
        resizable: false,
        height:160,
        width:500,
        modal: true,
        autoOpen:false,
        buttons: {
            "Oui": function() {
                jQuery( this ).dialog( "close" );
                window.location.href = theHREF;
            },
            "Annuler": function() {
                jQuery( this ).dialog( "close" );
            }
        }
    });

    jQuery('#datatables-liste-facture tbody').on('click', 'a.confirm', function (e) {
        e.preventDefault();
        theHREF = jQuery(this).attr("href");
        jQuery("#dialogue").dialog("open")
    });
        jQuery('#datatables-liste-facture').stickyTableHeaders();
    });
</script>