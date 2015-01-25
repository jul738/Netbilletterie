<?php
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php"); 
include_once("include/headers.php");
include_once("include/fonction.php");
include_once("include/head.php");
include_once("include/finhead.php");
?>


<center>
        <table id="datatables-liste-resa" class="display" width="100%">
            <caption> Les commandes de la saison culturelle <?php echo "$annee_2 - $annee_1"; ?> </caption>
                
      <thead>
               
                <tr>
                    <th>Numéro</th>
                    <th>Nom</th>
                    <th> Prénom du spectateur</th>
                    <th>Spectacle</th>
                    <th>Total</th>
                    <th>Regle?</th>
                    <th>Commentaires</th>
                    <th><small>Voir</small></th>
                    <th><small>Changer</small></th>
                    <th><small>Dupliquer</small></th>
                    <th><small>Effacer</small></th>
                    <th><small>Print</small></th>
          </tr>
      </thead>
            <tfoot>
               
                <tr>
                    <th>Numéro</th>
                    <th>Nom</th>
                    <th> Prénom du spectateur</th>
                    <th>Spectacle</th>
                    <th>Payé</th>
                    <th>Regle?</th>
                    <th>Commentaires</th>
                    <th><small>Voir</small></th>
                    <th><small>Changer</small></th>
                    <th><small>Dupliquer</small></th>
                    <th><small>Effacer</small></th>
                    <th><small>Print</small></th>
          </tr>
      </tfoot>
        </table>
    <div id="dialogue" style="display : none">Voulez vous supprimer la réservation?</div>
</center>
<script>

    jQuery(document).ready(function() {
    var table = jQuery('#datatables-liste-resa').dataTable( {
        "sPaginationType":"full_numbers",
	"bJQueryUI":true,
	"bStateSave": true,
        "bProcessing": true,
        "aaSorting": [[0,"asc"]],
        "sAjaxSource": 'test_list_commande_sql.php',
        "aoColumns": [
                        { mDataProp: 'num_bon' },
                        { mDataProp: 'nom' },
                        { mDataProp: 'prenom' },
                        { mDataProp: 'article' },
                        { mDataProp: 'ttc' },
                        { mDataProp: 'paiement' },
                        { mDataProp: 'coment' },
                        { mDataProp: 'voir' },
                        { mDataProp: 'changer' },
                        { mDataProp: 'dupliquer' },
                        { mDataProp: 'effacer' },
                        { mDataProp: 'print' }
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

    jQuery('#datatables-liste-resa tbody').on('click', 'a.confirm', function () {
        theHREF = jQuery(this).attr("href");
        jQuery("#dialogue").dialog("open")
    });
        jQuery('#datatables-liste-resa').stickyTableHeaders();
} );

</script>