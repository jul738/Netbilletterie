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
<?php
include_once("include/head.php");
include_once("include/finhead.php");

?> 


<table class="page" align="center">

  <tr>
    <td class="page" align="center">
       <h3>Liste de la billeterie 
         <?php if ($user_admin == 'y'||$user_dev=='y'){?>
        <SCRIPT LANGUAGE="JavaScript">
        if(window.print)
          {
          document.write('<A HREF="javascript:window.print()"><img border=0 src= image/printer.gif ></A>');
          }
        </SCRIPT>
        <?php } ?>
      </h3>
        </td>
    </tr>
    
    <tr>
        <td  class="page" align="center">
            <?php

            if ($message!='') {
             echo"<table><tr><td>$message</td></tr></table>";
            }
            if ($user_com == n) {
            echo"<h1>$lang_commande_droit";
            exit;
            }


$sql = "SELECT mail, login, num_client, num_bon, fact, ctrl, attente, coment, tot_tva, nom, soir, id_tarif,
            DATE_FORMAT(date,'%d-%m-%Y') AS date, tot_tva as ttc, paiement
            FROM ".$tblpref."bon_comm
            RIGHT JOIN " . $tblpref ."client on " . $tblpref ."bon_comm.client_num = num_client
            WHERE date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
            AND soir<>'0.00'
            AND soir<>''
            AND attente='0'";

        if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
        {
        $sql .= " ORDER BY " . $_GET[ordre] . " ASC";
        }
        else
        {
        $sql .= "ORDER BY " . $tblpref ."bon_comm.`num_bon` DESC ";
        }
            $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
    <center>
        <table id="datatables-liste-billeterie" class="display">
            <caption> Les commandes de la saison culturelle <?php echo "$annee_2 - $annee_1"; ?> </caption>
                
      <thead>
               
                <tr>
                    <th><?php echo $lang_numero; ?></th>
                    <th><?php echo $lang_client; ?></th>
                    <th><?php echo $lang_date; ?></th>
                    <th><?php echo $lang_total_ttc; ?></th>
                    <th>Regle?</th>               
                    <th>Encaisse</th>
                    <th>Controle</th>
                    <th>Commentaires</th>
                    <th><small>Voir</small></th>
                    <th><small>Changer</small></th>
                    <th><small>Effacer</small></th>
                    <th><small>Imprimer</small></th>
                    <th><small>Envoyer</small></th>
                    
          </tr>
                </thead>
      <tfoot>
               
                <tr>
                    <th><?php echo $lang_numero; ?></th>
                    <th><?php echo $lang_client; ?></th>
                    <th><?php echo $lang_date; ?></th>
                    <th><?php echo $lang_total_ttc; ?></th>
                    <th>Regle?</th>               
                    <th>Encaisse</th>
                    <th>Controle</th>
                    <th>Commentaires</th>
                    <th><small>Voir</small></th>
                    <th><small>Changer</small></th>
                    <th><small>Effacer</small></th>
                    <th><small>Imprimer</small></th>
                    <th><small>Envoyer</small></th>
                    
          </tr>
                </tfoot>

        </table>
            <div id="dialogue" style="display : none">Voulez vous supprimer le billet?</div>

    </center>
        </td>
    </tr>
    
  </td>
</tr>

</table>

<script>

    jQuery(document).ready(function() {
    var table = jQuery('#datatables-liste-billeterie').dataTable( {
        "sPaginationType":"full_numbers",
	"bJQueryUI":true,
	"bStateSave": true,
        "bProcessing": true,
        "aaSorting": [[0,"asc"]],
        "sAjaxSource": 'lister_billetterie_sql.php',
        "aoColumns": [
                        { mDataProp: 'num_bon' },
                        { mDataProp: 'nom' },
                        { mDataProp: 'date' },
                        { mDataProp: 'total' },
                        { mDataProp: 'regle' },
                        { mDataProp: 'encaisse' },
                        { mDataProp: 'controle' },
                        { mDataProp: 'coment' },
                        { mDataProp: 'voir' },
                        { mDataProp: 'changer' },
                        { mDataProp: 'effacer' },
                        { mDataProp: 'print' },
                        { mDataProp: 'envoyer' }
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

    jQuery('#datatables-liste-billeterie tbody').on('click', 'a.confirm', function (e) {
        e.preventDefault();
        theHREF = jQuery(this).attr("href");
        jQuery("#dialogue").dialog("open")
    });
        jQuery('#datatables-liste-billeterie').stickyTableHeaders();
} );

</script>

<?php

include_once("include/bas.php");
 
?>



