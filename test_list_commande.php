<?php
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php"); 
include_once("include/headers.php");
include_once("include/fonction.php");?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<?php
include_once("include/head.php");
include_once("include/finhead.php");
//include_once("test_list_commande_sql.php");
?>


<center>
        <table id="datatables" class="display">
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
</center>
<script>

    jQuery(document).ready(function() {
    jQuery('#datatables').dataTable( {
        "sPaginationType":"full_numbers",
	"aaSorting":[[0, "desc"]],
	"bJQueryUI":true,
	"bStateSave": true,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": 'test_list_commande_sql.php',
        "aoColumns": [
                        { mDataProp: 'num_bon' },
                        { mDataProp: 'nom' },
                        { mDataProp: 'prenom' },
                        { mDataProp: 'article' },
                        { mDataProp: 'ttc' },
                        { mDataProp: 'paiement' },
                        { mDataProp: 'coment' },
                        { mDataProp: '' },
                        { mDataProp: '' },
                        { mDataProp: '' },
                        { mDataProp: '' },
                        { mDataProp: '' }
                ]
    } );
} );
</script>