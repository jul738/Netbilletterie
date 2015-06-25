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

// ON affiche les groupes dans un tableau
?>
<center><table class="boiteaction" id="datatables-liste-groupes">
        <caption>Liste des groupes</caption>
        <thead>
        <tr>
            <th>Nom de la structure</th>
            <th>Rue</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Voir</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Nom de la structure</th>
            <th>Rue</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Voir</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        </tfoot>
    </table></center>
<?php
include_once("include/bas.php");
?>
<script>
    jQuery(document).ready(function() {
    var table = jQuery('#datatables-liste-groupes').dataTable( {
        "sPaginationType":"full_numbers",
	"bJQueryUI":true,
	"bStateSave": true,
        "bProcessing": true,
        "aaSorting": [[0,"asc"]],
        "sAjaxSource": 'lister_groupes_sql.php',
        "aoColumns": [
                        { mDataProp: 'nom' },
                        { mDataProp: 'rue' },
                        { mDataProp: 'cp' },
                        { mDataProp: 'ville' },
                        { mDataProp: 'telephone' },
                        { mDataProp: 'email' },
                        { mDataProp: 'voir' },
                        { mDataProp: 'modifier' },
                        { mDataProp: 'supprimer' }
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

    jQuery('#datatables-liste-groupes tbody').on('click', 'a.confirm', function (e) {
        e.preventDefault();
        theHREF = jQuery(this).attr("href");
        jQuery("#dialogue").dialog("open")
    });
        jQuery('#datatables-liste-groupes').stickyTableHeaders();
} );

</script>