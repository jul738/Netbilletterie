<?php 
/* Net Billetterie Copyright(C)2012 Jose Das Neves
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Jose Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
include_once("include/fonction.php");?>
<script type="text/javascript" src="javascripts/confdel.js"></script>

<table class="page" >
<tr>
<td  class="page" align="center">
 <?php
if ($user_cli == n) { 
echo"<h1>$lang_client_droit";
exit;  
}

//On enregistre le paiement de la réservation

if(!empty($_POST['id_tarif'])){
    $id_tarif = $_POST['id_tarif'];
    $paiement_resa = $_POST['paiement'];
    $num_bon = $_POST['num_bon'];
    //On met à jour la réservation de groupe
    $sql_update_resa = "UPDATE ".$tblpref ."bon_comm
                        SET id_tarif = ".$id_tarif.",
                            paiement = '".$paiement_resa."'
                        WHERE num_bon=".$num_bon."";
    mysql_query($sql_update_resa) or die('Erreur SQL !<br>'.$sql_update_resa.'<br>'.mysql_error());
    
    echo "Le paiement de la réservation ".$num_bon." a été enregistré.";
}

elseif(!empty($_POST['num-bon-groupe'])){
    $num_bon_groupe = $_POST['num-bon-groupe'];
    $nb_enfant_reel = $_POST['nb-enfant-reel'];
    $nb_accompagnateurs_reel = $_POST['nb-accompagnateur-reel'];
    $nb_gratuits_reel = $_POST['nb-gratuit-reel'];
    
    $sql_update_resa_groupe = "UPDATE ".$tblpref ."bon_comm_groupe
                                SET nb_enfants_reel = ".$nb_enfant_reel.",
                                    nb_accompagnateurs_reel = ".$nb_accompagnateurs_reel.",
                                    nb_gratuit_reel = ".$nb_gratuits_reel."
                                WHERE num_bon_groupe = ".$num_bon_groupe."";
    mysql_query($sql_update_resa_groupe) or die('Erreur Update resa groupe'.mysql_error());
    
    //On met à jour le stock de l'article
    $select_resa_groupe = "SELECT nb_enfants, nb_enfants_reel, nb_accompagnateurs, nb_accompagnateurs_reel, nb_gratuit, nb_gratuit_reel, stock, id_article FROM bon_comm_groupe AS bcg, article AS a WHERE num_bon_groupe=".$num_bon_groupe." AND bcg.id_article = a.num";
    $req_resa_groupe = mysql_query($select_resa_groupe) or die ('Erreur Selection résa groupe');
    while ($data_resa_groupe = mysql_fetch_array($req_resa_groupe)){
        $nb_enfants_prevus = $data_resa_groupe['nb_enfants'];
        $nb_accompagnateurs_prevus = $data_resa_groupe['nb_accompagnateurs'];
        $nb_gratuit_prevus = $data_resa_groupe['nb_gratuit'];
        $nb_enfants_reel = $data_resa_groupe['nb_enfants_reel'];
        $nb_accompagnateurs_reel = $data_resa_groupe['nb_accompagnateurs_reel'];
        $nb_gratuit_reel = $data_resa_groupe['nb_gratuit_reel'];
        $id_article = $data_resa_groupe['id_article'];
        $stock = $data_resa_groupe['stock'];
    }
    $nb_enfant = $nb_enfants_prevus - $nb_enfant_reel;
    $nb_accompagnateur = $nb_accompagnateurs_prevus - $nb_accompagnateurs_reel;
    $nb_gratuit = $nb_gratuit_prevus - $nb_gratuit_reel;
    $difference = $nb_enfant + $nb_accompagnateur + $nb_gratuit;
    $update_stock = "UPDATE article SET stock = ".$stock." - ".$difference." WHERE num = ".$id_article."";
    mysql_query($update_stock) or die ('Erreur Maj stock');
    echo "Les nombres réels pour le groupe ont été enregistrés";
}


$article_numero=isset($_GET['article'])?$_GET['article']:"";

$sql2="SELECT DATE_FORMAT(date_spectacle,'%d-%m-%Y') AS date, horaire, article, stock, num FROM " . $tblpref ."article WHERE num=$article_numero";
$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req2))
    {
    $article = $data['article'];
    $article_numero= $data['num'];
    $date_timestamp = strtotime($data['date']);
    $date = date_fr('l d-m-Y', $date_timestamp);
    $horaire = $data['horaire'];
    $stock = $data['stock'];

?>
<center><table class="boiteaction" id="datatables-liste-spectateur-particulier">
  <caption>Liste des spectateurs pour: <br><?php
  if ($stock>0){
  echo "$article le $date - $horaire - Il reste $stock places";
  
  }
 else {
   echo "$article le $date - $horaire - La liste d'attente est a $stock places";
    }
    ?> <br>
    <!-- On ajoute le nombre de personne avec une résa et le nombre de personnes arrivées-->
    <?php
    $sql_count_resa = "SELECT COUNT(num_bon) FROM " . $tblpref ."bon_comm WHERE paiement='non' AND id_article=".$article_numero."";
    $req_count_resa = mysql_query($sql_count_resa) or die('Erreur SQL !<br>'.$sql_count_resa.'<br>'.mysql_error());
    While($data_count_resa = mysql_fetch_array($req_count_resa)) {
        $count_resa = $data_count_resa['COUNT(num_bon)'];
    }
    
    $sql_count_arrive = "SELECT COUNT(num_bon) FROM " . $tblpref ."bon_comm WHERE paiement<>'non' AND id_article=".$article_numero."";
    $req_count_arrive = mysql_query($sql_count_arrive) or die('Erreur SQL !<br>'.$sql_count_arrive.'<br>'.mysql_error());
    While($data_count_arrive = mysql_fetch_array($req_count_arrive)) {
        $count_arrive = $data_count_arrive['COUNT(num_bon)'];
    }
    echo 'Nombre de particuliers arrivées / Nombre de particulier à venir <br />'.$count_arrive.' / '.$count_resa;
    ?>
    <br>
  <?php if ($user_admin != n) { ?>
  <a href="form_mailing.php?article=<?php echo $article_numero;?>">Envoyer un mail a tous ces spectateurs</a><br> <?php } ?>
    <a href="fpdf/liste_spectateurs.php?article=<?php echo $article_numero;?>" target="_blank">Imprimer la liste de tous ces spectateurs</a>

        
      <?php } ?>
    <br /> Réservations : </caption>
        <thead>
                <tr>        
                    <th>Nom</a></th>
                    <th>Prenom</th>
                    <th>Telephone</th>
                    <th>Commentaire</th>
                    <th>Modifier la réservation</th>
                    <th>Dupliquer la réservation</th>
                    <th>Tarif</th>
                    <th>Paiement</th>
                    <th>Valider</th>
                    <th>Supprimer la réservation</th>
                </tr>
        </thead>
        <tfoot>
                <tr>        
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Telephone</th>
                    <th>Commentaire</th>
                    <th>Modifier la réservation</th>
                    <th>Dupliquer la réservation</th>
                    <th>Tarif</th>
                    <th>Paiement</th>
                    <th>Valider</th>
                    <th>Supprimer la réservation</th>
                </tr>
        </tfoot>

</table></center>

<?php
include("help.php");	
echo"</td></tr>";
?>

<!-- On ajoute les réservations de groupes -->
<tr><td>
     <?php
     /* Récupèration des informations sur les réservations de groupes */
     $sql_resa_groupe = "SELECT * FROM bon_comm_groupe AS bcg, groupe AS g, accompte AS a WHERE bcg.id_article='$article_numero' AND bcg.num_groupe = g.num_groupe AND a.num_bon_groupe = bcg.num_bon_groupe";
     $req_resa_groupes = mysql_query($sql_resa_groupe) or die ('Erreur SQL séléction des réservations de groupes'.mysql_error());
     
    $sql_count_resa_groupe = "SELECT COUNT(num_bon_groupe) FROM bon_comm_groupe AS bcg WHERE bcg.id_article='$article_numero'";
    $req_count_resa_groupe = mysql_query($sql_count_resa_groupe) or die ('Erreur SQL compte résas groupes'.mysql_error());
            while($data_count_groupe = mysql_fetch_array($req_count_resa_groupe)){
                $count_nb_groupes = $data_count_groupe['COUNT(num_bon_groupe)'];
                }
    $sql_count_resa_groupe2 = "SELECT nb_accompagnateurs, nb_enfants FROM bon_comm_groupe AS bcg WHERE bcg.id_article='$article_numero'";
    $req_count_resa_groupe2 = mysql_query($sql_count_resa_groupe2) or die ('Erreur SQL compte résas groupes'.mysql_error());
            while($data_count_groupe2 = mysql_fetch_array($req_count_resa_groupe2)){
                $count_nb_enfants = $count_nb_enfants + $data_count_groupe2['nb_enfants'];
                $count_nb_adultes = $count_nb_adultes + $data_count_groupe2['nb_accompagnateurs'];
                }
    ?>
<center><table class="boiteaction">
        <caption>Réservations de groupe<br />
            Nombres de groupe : <?php echo $count_nb_groupes;?><br />
            Nombre de personnes dans les groupes : <?php echo $count_nb_enfants + $count_nb_adultes;?></th>
        <tr>
            <th>Nom de la structure</th>
            <th>Nom du référent du groupe</th>
            <th>Téléphone du référent</th>
            <th>Classe / Âge</th>
            <th>Nombre d'enfants prévus</th>
            <th>Nombre d'enfants réels</th>
            <th>Nombres d'accompagnateurs prévus</th>
            <th>Nombres d'accompagnateurs réels</th>
            <th>Nombre d'accompgnateurs gratuit prévus</th>
            <th>Nombre d'accompgnateurs gratuit réels</th>
            <th>Commentaire sur la réservation</th>
            <th>Montant de l'accompte</th>
            <th>Valider le groupe</th>
            <th>Modifier la résa de groupe</th>
            <th>Dupliquer la résa de groupe</th>
            <th>Supprimer la résa de groupe</th>
        </tr>
        <?php
        /* ON boucle sur les réservation de groupes pour les afficher */
        while($data_resa_groupe = mysql_fetch_array($req_resa_groupes)){
            $num_bon_groupe = $data_resa_groupe['num_bon_groupe'];
            $num_groupe = $data_resa_groupe['num_groupe'];
            $nom_structure = $data_resa_groupe['nom_structure'];
            $nom_referent = $data_resa_groupe['nom_referent'];
            $tel_referent = $data_resa_groupe['telephone_referent'];
            $classe = $data_resa_groupe['classe_groupe'];
            $nb_enfant = $data_resa_groupe['nb_enfants'];
            $nb_accompagnateur = $data_resa_groupe['nb_accompagnateurs'];
            $nb_gratuit = $data_resa_groupe['nb_gratuit'];
            $commentaire_groupe = $data_resa_groupe['coment'];
            $nb_enfants_reel = $data_resa_groupe['nb_enfants_reel'];
            $nb_accompagnateurs_reel = $data_resa_groupe['nb_accompagnateurs_reel'];
            $nb_gratuits_reel = $data_resa_groupe['nb_gratuit_reel'];
            $montant = $data_resa_groupe['montant'];
            ?>
        <form action="lister_spectateurs.php?article=<?php echo $article_numero;?>" id="spectacle-resa-groupe" method="POST">
        <tr>
            <td><?php echo $nom_structure; ?></td>
            <td><?php echo $nom_referent; ?></td>
            <td><?php echo $tel_referent; ?></td>
            <td><?php echo $classe; ?></td>
            <td><?php echo $nb_enfant; ?></td>
            <td><?php if(empty($nb_enfants_reel)){?><input type="text" id="nb-enfant-reel" name="nb-enfant-reel" size="3" value="0" /><?php } else { echo $nb_enfants_reel;}?></td>
            <td><?php echo $nb_accompagnateur; ?></td>
            <td><?php if(empty($nb_accompagnateurs_reel)){?><input type="text" id="nb-accompagnateur-reel" name="nb-accompagnateur-reel" size="3" value="0" /><?php } else {echo $nb_accompagnateurs_reel;}?></td>
            <td><?php echo $nb_gratuit; ?></td>
            <td><?php if(empty($nb_gratuits_reel)) { ?><input type="text" id="nb-gratuit-reel" name="nb-gratuit-reel" size="3" value="0" /><?php } else { echo $nb_gratuits_reel;}?></td>
            <td><?php echo $commentaire_groupe; ?></td>
            <td><?php echo $montant;?></td>
            <td>
                <input type="hidden" id="num-bon-groupe" name="num-bon-groupe" value="<?php echo $num_bon_groupe;?>" />
                <input type="submit" id="Enregistrer le groupe" value="Enregistrer le groupe" />
            </td>
            </form>
            <td class="highlight"><a href='form_resa_groupe.php?num_resa_groupe=<?php echo $num_bon_groupe;?>'><img border="0" alt="Modifier"  title="Modifier la réservation du groupe"src="image/edit.png"></a></td>
            <td>
                <form action="form_resa_groupe.php" name="dupliquer-resa-groupe" id="dupliquer-resa-groupe" method="POST">
                    <input type="hidden" name="num-groupe" value="<?php echo $num_groupe;?>"></input>
                    <input type="hidden" name="nom-referent" value="<?php echo $nom_referent;?>"></input>
                    <input type="hidden" name="telephone-referent" value="<?php echo $tel_referent;?>"></input>
                    <input type="hidden" name="classe-groupe" value="<?php echo $classe;?>"></input>
                    <input type="hidden" name="nb-enfants" value="<?php echo $nb_enfant;?>"></input>
                    <input type="hidden" name="nb-accompagnateurs" value="<?php echo $nb_accompagnateur;?>"></input>
                    <input type="hidden" name="nb-gratuit" value="<?php echo $nb_gratuit;?>"></input>
                    <input type="hidden" name="id-tarif" value="<?php echo $id_tarif;?>"></input>                    
                    <input type="submit" value="" class="duplication"</input>
                </form>
            </td>
            <td class="highlight"><a href='delete_resa_groupe.php?num_resa_groupe=<?php echo $num_bon_groupe;?>'><img border="0" title="Supprimer la réservation du groupe" alt="delete" src="image/delete.png"></a></td>
        </tr>
            <?php
        }
        ?>
    </table></center>
    </td>
</tr>
<tr><td>
        <!-- On ajoute une table avec la liste des invités -->
        <?php
        $sql_invites = "SELECT *
        FROM client C, bon_comm BC
        WHERE BC.client_num=C.num_client
        AND BC.id_article = $article_numero
        AND BC.attente=0
        AND BC.paiement = 'Gratuit'";
        $data_invites = mysql_query($sql_invites) or die('Erreur Sql invites!'.$sql_invites.'<br>'.mysql_error());
        ?>
<center><table class="boiteaction">
        <caption>Invités / Éxonérés : </caption>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Téléphone</th>
            <th>Mail</th>
        </tr>
        
        <?php
        
        // ON récupère les données de la requête et on les affiches
        while($invites = mysql_fetch_array($data_invites)) {
            $nom_invite = $invites['nom'];
            $prenom_invite = $invites['prenom'];
            $tel_invite = $invites['tel'];
            $mail_invite = $invites['mail'];
            ?>
        <tr>
            <td><?php echo $nom_invite;?></td>
            <td><?php echo $prenom_invite;?></td>
            <td><?php echo $tel_invite;?></td>
            <td><?php echo $mail_invite;?></td>
        </tr>
        <?php
        }
        
        ?>
        
</table></center>
    </td></tr>
<tr>
    <td>
        <!-- On ajoute une table avec la liste des personnes étant arrivées -->
        <?php
        $sql_arrives = "SELECT *
        FROM client C, bon_comm BC
        WHERE BC.client_num=C.num_client
        AND BC.id_article = $article_numero
        AND BC.attente=0
        AND BC.paiement NOT IN ('Gratuit', 'non')";
        $data_arrives = mysql_query($sql_arrives) or die('Erreur Sql invites!'.$sql_arrives.'<br>'.mysql_error());
        ?>
        <center><table class="boiteaction">
            <caption> Personnes arrivées : </caption>
            <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Téléphone</th>
            <th>Mail</th>
        </tr>
        
        <?php
        
        // ON récupère les données de la requête et on les affiches
        while($arrives = mysql_fetch_array($data_arrives)) {
            $nom_arrive = $arrives['nom'];
            $prenom_arrive = $arrives['prenom'];
            $tel_arrive = $arrives['tel'];
            $mail_arrive = $arrives['mail'];
            ?>
        <tr>
            <td><?php echo $nom_arrive;?></td>
            <td><?php echo $prenom_arrive;?></td>
            <td><?php echo $tel_arrive;?></td>
            <td><?php echo $mail_arrive;?></td>
        </tr>
        <?php
        }
        
        ?>
        </table></center>
    </td>
</tr>
<?php
echo "<tr><td>";
include_once("include/bas.php");
?> 
</td></tr>

<?php
$url = $_SERVER['PHP_SELF'];
$file = basename ($url);
if ($file=="form_client.php") { 
echo"</table>"; 
} ?>
</table>
            <div id="dialogue" style="display : none">Voulez vous supprimer la réservation?</div>
<script>

    jQuery(document).ready(function() {
    var table = jQuery('#datatables-liste-spectateur-particulier').dataTable( {
        "sPaginationType":"full_numbers",
	"bJQueryUI":true,
	"bStateSave": true,
        "bProcessing": true,
        "aaSorting": [[0,"asc"]],
        "sAjaxSource": 'lister_spectateurs_particulier_sql.php?article_numero=<?php echo $article_numero;?>',
        "aoColumns": [
                        { mDataProp: 'nom' },
                        { mDataProp: 'prenom' },
                        { mDataProp: 'telephone' },
                        { mDataProp: 'coment' },
                        { mDataProp: 'modifier' },
                        { mDataProp: 'dupliquer' },
                        { mDataProp: 'tarif' },
                        { mDataProp: 'paiement' },
                        { mDataProp: 'valider' },
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

    jQuery('#datatables-lister-spectateur-particulier tbody').on('click', 'a.confirm', function (e) {
        e.preventDefault();
        theHREF = jQuery(this).attr("href");
        jQuery("#dialogue").dialog("open")
    });
        jQuery('#datatables-liste-spectateur-particulier').stickyTableHeaders();
} );

</script>
</body>
</html>
