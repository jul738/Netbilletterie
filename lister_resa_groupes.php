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

// On récupère la liste des réservations de groupes

$select_resa_groupes = "SELECT num_bon_groupe, nom_structure, article, nom_referent, telephone_referent, classe_groupe, nb_enfants, nb_accompagnateurs, nb_gratuit, id_article FROM " . $tblpref ."bon_comm_groupe AS bcg, " . $tblpref ."groupe AS g, " . $tblpref ."article AS a WHERE bcg.id_article=a.num AND bcg.num_groupe=g.num_groupe";
$req_resa_groupes = mysql_query($select_resa_groupes) or die('Erreur sql groupes'.$select_resa_groupes.'<br>'.mysql_error());

// ON affiche les groupes dans un tableau
?>
<center><table class="boiteaction page">
        <caption>Liste des réservations de groupes</caption>
        <tr>
            <th>Nom de la structure</th>
            <th>Nom du spectacle</th>
            <th>Nom du référent</th>
            <th>Téléphone</th>
            <th>Classe / Age</th>
            <th>Nombre d'enfants</th>
            <th>Nombre d'accompagnateurs (dont gratuit)</th>
            <th>Voir</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        
        <?php
        while($data_resa_groupes = mysql_fetch_array($req_resa_groupes)){
          $num_resa_groupe = $data_resa_groupes['num_bon_groupe'];
          $nom_structure = $data_resa_groupes['nom_structure'];
          $article = $data_resa_groupes['article'];
          $nom_referent = $data_resa_groupes['nom_referent'];
          $telephone_referent = $data_resa_groupes['telephone_referent'];
          $classe_groupe = $data_resa_groupes['classe_groupe'];
          $nb_enfants = $data_resa_groupes['nb_enfants'];
          $nb_accompagnateurs = $data_resa_groupes['nb_accompagnateurs'];
          $nb_gratuit = $data_resa_groupes['nb_gratuit'];
          ?>
        <tr onmouseover="this.className='highlight'" onmouseout="this.className='texte <?php echo "$line" ?>'">
            <td class="highlight"><?php echo $nom_structure;?></td>
            <td class="highlight"><?php echo $article;?></td>
            <td class="highlight"><?php echo $nom_referent;?></td>
            <td class="highlight"><?php echo $telephone_referent;?></td>
            <td class="highlight"><?php echo $classe_groupe;?></td>
            <td class="highlight"><?php echo $nb_enfants;?></td>
            <td class="highlight"><?php echo $nb_accompagnateurs;?> (<?php echo $nb_gratuit; ?>)</td>
            <td class="highlight"><a href='resa_groupe.php?num_resa_groupe=<?php echo $num_resa_groupe;?>'><img border="0" title="Voir la réservation du groupe" src="image/voir.gif" alt="voir"></a></td>
            <td class="highlight"><a href='form_resa_groupe.php?num_resa_groupe=<?php echo $num_resa_groupe;?>'><img border="0" alt="Modifier"  title="Modifier la réservation du groupe"src="image/edit.png"></a></td>
            <td class="highlight"><a href='delete_resa_groupe.php?num_resa_groupe=<?php echo $num_resa_groupe;?>'><img border="0" title="Supprimer la réservation du groupe" alt="delete" src="image/delete.png"></a></td>
        </tr>
        <?php
        } // fin du while data_groupes
        ?>
    </table></center>
<?php
include_once("include/bas.php");
?>