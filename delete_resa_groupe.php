<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
include_once("include/configav.php");

// On récupère le numero de résa du groupe
$num_resa_groupe = isset($_GET['num_resa_groupe'])?$_GET['num_resa_groupe']:"";

// On séléctionne l'article concerné et son stock
$select_article = "SELECT stock, id_article, nb_enfants, nb_accompagnateurs FROM bon_comm_groupe AS bc, article AS a WHERE num_bon_groupe='$num_resa_groupe' AND bc.id_article = a.num";
$sql_article = mysql_query($select_article) or die ('Erreur séléction article à supprimer');
while ($data_article = mysql_fetch_array($sql_article)){
    $id_article = $data_article['id_article'];
    $stock_article = $data_article['stock'];
    $nb_enfant = $data_article['nb_enfants'];
    $nb_accompagnateurs = $data_article['nb_accompagnateurs'];
}
$quanti = $nb_accompagnateurs + $nb_enfant;
// On met à jour le stock
$update_stock = "UPDATE article SET stock = ('$stock_article' + '$quanti') WHERE num='$id_article'";
mysql_query($update_stock) or die ('Erreur MAJ du stock lors de la suppression d\'une réservation de groupe');

// On supprime la réservation du groupe
$delete_resa_groupe = "DELETE FROM bon_comm_groupe WHERE num_bon_groupe='$num_resa_groupe'";
mysql_query($delete_resa_groupe) or die ('Erreur delete résa de groupe');

?>
 <table border="0" class="page" align="center">
        <tr>          
                <caption> Suppression de la réservation de groupe </caption>
        </tr>
        <tr>
            <th> La réservation de groupe a été supprimée avec succès ! </th>
        </tr>

        <tr>   
          
<form method='post'>
        <table border="0" class="page" align="center">

                    <tr>
                    <!-- Bouton :ajouter resa_groupe -->
                        <td> 
                            <a href='form_resa_groupe.php'><img border =0 src="image/new_mini_abonnement.png" alt=""> <br> Ajouter une nouvelle réservation de groupe </a>
                        </td>

                    <!-- Bouton : lister les résas de groupes  -->
                        <td>
                            <a href='lister_resa_groupes.php'><img border =0 src="image/lister_abonnement_gris.png" alt=""> <br> Lister les réservations de groupes </a>
                        </td>
                    </tr>

        </table>
</form>

    </table>



<?php
include_once("include/bas.php");
?>
