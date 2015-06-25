<?php 
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr*/
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
?> 

<table  class="page" align="center">

  <tr>
    <td class="page" align="center">
       <h3>Liste des reservations 

      </h3>
        </td>
        <?php
        if (!empty($message)){
            echo $message;
        }?>
    </tr>
    
    <tr>
        <td  class="page" align="center">
            <?php
            if ($user_com == n) {
            echo"<h1>$lang_commande_droit";
            exit;
            }
?>
    <center>
        <table id="datatables-liste-commande" class="display">
            <caption> Les commandes de la saison culturelle <?php echo "$annee_2 - $annee_1"; ?> </caption>
                
      <thead>
               
                <tr>
                    <th><?php echo $lang_numero; ?></th>
                    <th><?php echo $lang_client; ?></th>
                    <th> Prénom du spectateur</th>
                    <th>Spectacle</th>
                    <th><?php echo $lang_total_ttc; ?></th>
                    <th>Regle?</th>
          <?php if ($user_admin == 'y'||$user_dev=='y') 
            { ?>                  
                    <th>Encaisse</th>
                    <th>Controle</th>
          <?php }?>
                    <th>Commentaires</th>
                    <th><small>Voir</small></th>
                    <th><small>Changer</small></th>
                    <th><small>Dupliquer</small></th>
                    <th><small>Effacer</small></th>
                    <th><small>Print</small></th>
          <?php if ($user_admin == 'y'||$user_dev=='y') 
            { ?>
                    <th><small>Envoyer</small></th>
            <?php } ?>
          </tr>
                </thead>
      <tfoot>
               
                <tr>
                    <th><?php echo $lang_numero; ?></th>
                    <th><?php echo $lang_client; ?></th>
                    <th> Prénom du spectateur</th>
                    <th>Spectacle</th>
                    <th><?php echo $lang_total_ttc; ?></th>
                    <th>Regle?</th>
          <?php if ($user_admin == 'y'||$user_dev=='y') 
            { ?>                  
                    <th>Encaisse</th>
                    <th>Controle</th>
          <?php }?>
                    <th>Commentaires</th>
                    <th><small>Voir</small></th>
                    <th><small>Changer</small></th>
                    <th><small>Dupliquer</small></th>
                    <th><small>Effacer</small></th>
                    <th><small>Print</small></th>
          <?php if ($user_admin == 'y'||$user_dev=='y') 
            { ?>
                    <th><small>Envoyer</small></th>
            <?php } ?>
          </tr>
                </tfoot>
        </table>
    </center>
        </td>
    </tr>

</table>
<?php
include_once("include/bas.php"); 
?>
<script>

    jQuery(document).ready(function() {
    var table = jQuery('#datatables-liste-commande').dataTable( {
        "sPaginationType":"full_numbers",
	"bJQueryUI":true,
	"bStateSave": true,
        "bProcessing": true,
        "aaSorting": [[0,"asc"]],
        "sAjaxSource": 'lister_commandes_sql.php',
        "aoColumns": [
                        { mDataProp: 'numero' },
                        { mDataProp: 'nom' },
                        { mDataProp: 'prenom' },
                        { mDataProp: 'spectacle' },
                        { mDataProp: 'total' },
                        { mDataProp: 'regle' },
                        { mDataProp: 'encaisse' },
                        { mDataProp: 'controle' },
                        { mDataProp: 'commentaire' },
                        { mDataProp: 'voir' },
                        { mDataProp: 'changer' },
                        { mDataProp: 'dupliquer' },
                        { mDataProp: 'effacer' },
                        { mDataProp: 'imprimer' },
                        { mDataProp: 'envoyer' },
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

    jQuery('#datatables-liste-commande tbody').on('click', 'a.confirm', function (e) {
        e.preventDefault();
        theHREF = jQuery(this).attr("href");
        jQuery("#dialogue").dialog("open");
    });
        jQuery('#datatables-liste-commande').stickyTableHeaders();
    });
</script>