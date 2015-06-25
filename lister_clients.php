<?php 
/* Net Billetterie Copyright(C)2012 Jose Das Neves
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jose Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
?>

<script type="text/javascript" src="javascripts/confdel.js"></script>
<?php
include_once("include/finhead.php");
include_once("include/fonction.php");
?>

<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
			<h3>Liste des spectateurs</h3>
		</td>
	</tr>
	<tr>
		<td  class="page" align="center">
		<?php 
		if ($user_cli == n) { 
		echo"<h1>$lang_client_droit";
		exit;  
		}

		$initial=isset($_GET['initial'])?$_GET['initial']:"";
                                
                
                // requete sql avec les abonnement // 
                $sql = " SELECT DISTINCT C.num_client, C.nom, C.nom2, C.rue, C.ville, C.cp, C.mail, C.prenom, C.tel, C.fax
                                FROM client C
                WHERE C.nom LIKE '$initial%' 
		AND actif='y' 
                AND C.num_client !='1'";
                
		 if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
		{
		$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
		} 
		else {
		//$sql = " SELECT * FROM ".$tblpref ."client WHERE nom LIKE '$initial%' AND actif='y' AND `num_client`!='1' ORDER BY nom ASC";
                  $sql = " SELECT C.num_client, C.nom, C.nom2, C.rue, C.ville, C.cp, C.mail, C.prenom, C.tel, C.fax
                FROM client C
                WHERE C.nom LIKE '$initial%' 
		AND actif='y' 
                AND C.num_client!='1'
                ORDER BY C.nom ASC";                
		  }
		$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                
                
//On recupere la date d aujourd hui (pour tester si abonne oui ou non /Oui si date_ajd est compris entre date_debut et date_fin dans abonnement_comm sinon /Non
$date_ajd = date('Y-m-d');  



		?>
			<center>
				<table id="datatables-liste-clients" class="boiteaction">
					<caption><?php echo $lang_clients_existants; ?></caption>
					<thead>
						<tr>
                                                    <th>Num Client</th>
							<th>Nom</th>
                                                        <th>Prenom</th>
							<th><?php echo $lang_rue; ?></th>
							<th><?php echo $lang_code_postal; ?></th>
							<th><?php echo $lang_ville; ?></th>
							<th><?php  echo $lang_tele;?></th>
                                                        <th><?php echo $lang_abonne_chanson; ?></th>
                                                        <th><?php echo $lang_abonne_jp; ?></th> 
							<th><?php echo $lang_email; ?></th>                                                        
    							<th>Action</th>
                                                        
						</tr>
					</thead>
                                        <tfoot>
						<tr>
                                                    <th>Num Client</th>
							<th>Nom</th>
                                                        <th>Prenom</th>
							<th><?php echo $lang_rue; ?></th>
							<th><?php echo $lang_code_postal; ?></th>
							<th><?php echo $lang_ville; ?></th>
							<th><?php  echo $lang_tele;?></th>
                                                        <th><?php echo $lang_abonne_chanson; ?></th>
                                                        <th><?php echo $lang_abonne_jp; ?></th> 
							<th><?php echo $lang_email; ?></th>                                                        
    							<th>Action</th>
                                                        
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
    var table = jQuery('#datatables-liste-clients').dataTable( {
        "sPaginationType":"full_numbers",
	"bJQueryUI":true,
	"bStateSave": true,
        "bProcessing": true,
        "aaSorting": [[0,"asc"]],
        "sAjaxSource": 'lister_clients_sql.php',
        "aoColumns": [
                        { mDataProp: 'num_client' },
                        { mDataProp: 'nom' },
                        { mDataProp: 'prenom' },
                        { mDataProp: 'rue' },
                        { mDataProp: 'cp' },
                        { mDataProp: 'ville' },
                        { mDataProp: 'telephone' },
                        { mDataProp: 'concert' },
                        { mDataProp: 'jp' },
                        { mDataProp: 'email' },
                        { mDataProp: 'actions' }
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

    jQuery('#datatables-liste-clients tbody').on('click', 'a.confirm', function (e) {
        e.preventDefault();
        theHREF = jQuery(this).attr("href");
        jQuery("#dialogue").dialog("open")
    });
        jQuery('#datatables-liste-clients').stickyTableHeaders();
} );

</script>