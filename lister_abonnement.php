<?php
// Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
// Lister abonnement.php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
include_once("include/configav.php");
include_once("include/fonction.php");
?>

<?php
//=============================================
//pour que les articles soit classes par saison
$mois=date("n");
if ($mois=="10"||$mois=="11"||$mois=="12") {
 $mois=date("n");
}
else{
  $mois =date("0n");
}
$jour =date("d");
$date_ref="$mois-$jour";
$annee = date("Y");
//pour le formulaire
$annee_1=isset($_POST['annee_1'])?$_POST['annee_1']:"";
if ($annee_1=='') 
{
  $annee_1= $annee ;
  if ($mois.'-'.$jour <= $fin_saison)
  {
  $annee_1=$annee_1;
  }
  if ($mois.'-'.$jour >= $fin_saison)
  {
  $annee_1=$annee_1+1;
  }  
}
$annee_2= $annee_1 -1;
?>

<table border="0" class="page" align="center">
<?php echo $horaire_spectacle_1_vendu ;?>
    <tr>
        <td class="page" align="center">
            <h3>Liste des Abonnements </h3>
    </tr>
        <td>


<table id="datatables-liste-abo" class="display">
    
<caption> Les Abonnements de la saison :  <?php echo "$annee_2 - $annee_1"; ?> </caption>
    <thead>
            <tr>
                <th><small>Num Abo            </small></th>
                <th><small> Nom du Spectateur </small></th>
                <th><small> Prénom du Spectateur </small></th>
                <th><small>Date de creation   </small></th>
                <th><small>Abo                </small></th>
                <th><small>Spectacle 1        </small></th>
                <th><small>Spectacle 2        </small></th>
                <th><small>Spectacle 3        </small></th>
                <th><small>Spectacle 4        </small></th>
                <th><small>Spectacle 5        </small></th>
                <th><small>Spectacle 6        </small></th>
                <th><small>Spectacle 7        </small></th>
                <th><small>Commentaire        </small></th>
                <th><small>Voir               </small></th>
                <th><small>Edit               </small></th>
                <th><small>Supr               </small></th>
                <th><small>Impr               </small></th>
                <th><small>Dupli              </small></th>
                <th><small>Mail               </small></th>
            </tr>
    </thead>
    <tfoot>
            <tr>
                <th><small>Num Abo            </small></th>
                <th><small> Nom du Spectateur </small></th>
                <th><small> Prénom du Spectateur </small></th>
                <th><small>Date de creation   </small></th>
                <th><small>Abo                </small></th>
                <th><small>Spectacle 1        </small></th>
                <th><small>Spectacle 2        </small></th>
                <th><small>Spectacle 3        </small></th>
                <th><small>Spectacle 4        </small></th>
                <th><small>Spectacle 5        </small></th>
                <th><small>Spectacle 6        </small></th>
                <th><small>Spectacle 7        </small></th>
                <th><small>Commentaire        </small></th>
                <th><small>Voir               </small></th>
                <th><small>Edit               </small></th>
                <th><small>Supr               </small></th>
                <th><small>Impr               </small></th>
                <th><small>Dupli              </small></th>
                <th><small>Mail               </small></th>
            </tr>
    </tfoot>

</table>
</table>
    <div id="dialogue" style="display : none">Voulez vous supprimer l'abonnement?</div>

    <?php
include_once("include/bas.php");
?>
    
<script>

    jQuery(document).ready(function() {
    var table = jQuery('#datatables-liste-abo').dataTable( {
        "sPaginationType":"full_numbers",
	"bJQueryUI":true,
	"bStateSave": true,
        "bProcessing": true,
        "aaSorting": [[0,"asc"]],
        "sAjaxSource": 'lister_abonnement_sql.php',
        "aoColumns": [
                        { mDataProp: 'num_bon' },
                        { mDataProp: 'nom' },
                        { mDataProp: 'prenom' },
                        { mDataProp: 'date' },
                        { mDataProp: 'abo' },
                        { mDataProp: 'spectacle_1' },
                        { mDataProp: 'spectacle_2' },
                        { mDataProp: 'spectacle_3' },
                        { mDataProp: 'spectacle_4' },
                        { mDataProp: 'spectacle_5' },
                        { mDataProp: 'spectacle_6' },
                        { mDataProp: 'spectacle_7' },
                        { mDataProp: 'commentaire' },
                        { mDataProp: 'voir' },
                        { mDataProp: 'modifier' },
                        { mDataProp: 'effacer' },
                        { mDataProp: 'print' },
                        { mDataProp: 'dupliquer' },
                        { mDataProp: 'mail' }
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

    jQuery('#datatables-liste-abo tbody').on('click', 'a.confirm', function (e) {
        e.preventDefault();
        theHREF = jQuery(this).attr("href");
        jQuery("#dialogue").dialog("open")
    });
        jQuery('#datatables-liste-abo').stickyTableHeaders();
    });
</script>