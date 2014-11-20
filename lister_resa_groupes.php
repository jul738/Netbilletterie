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
include_once("include/fonction.php");

// On récupère la liste des réservations de groupes

$select_resa_groupes = "SELECT num_bon_groupe, bcg.num_groupe, nom_structure, article, date_spectacle, horaire, nom_referent, telephone_referent, classe_groupe, nb_enfants, nb_accompagnateurs, nb_gratuit, id_article, coment, id_tarif FROM " . $tblpref ."bon_comm_groupe AS bcg, " . $tblpref ."groupe AS g, " . $tblpref ."article AS a WHERE bcg.id_article=a.num AND bcg.num_groupe=g.num_groupe";
$req_resa_groupes = mysql_query($select_resa_groupes) or die('Erreur sql groupes'.$select_resa_groupes.'<br>'.mysql_error());

// ON affiche les groupes dans un tableau
?>
<center><table class="boiteaction page display" id="datatables">
        <caption>Liste des réservations de groupes</caption>
        <thead>
        <tr>
            <th>Nom de la structure</th>
            <th>Nom du spectacle</th>
            <th>Date du spectacle</th>
            <th>Horaire du spectacle</th>
            <th>Nom du référent</th>
            <th>Téléphone</th>
            <th>Classe / Age</th>
            <th>Nombre d'enfants</th>
            <th>Nombre d'accompagnateurs (dont gratuit)</th>
            <th>Commentaire</th>
            <th>Voir</th>
            <th>Modifier</th>
            <th>Supprimer</th>
            <th>Acompte</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while($data_resa_groupes = mysql_fetch_array($req_resa_groupes)){
          $num_groupe = $data_resa_groupes['num_groupe'];
          $num_resa_groupe = $data_resa_groupes['num_bon_groupe'];
          $nom_structure = $data_resa_groupes['nom_structure'];
          $article = $data_resa_groupes['article'];
          $date = strtotime($data_resa_groupes['date_spectacle']);
          $date_article = date_fr("l d-m-Y", $date);
          $horaire = $data_resa_groupes['horaire'];
          $nom_referent = $data_resa_groupes['nom_referent'];
          $telephone_referent = $data_resa_groupes['telephone_referent'];
          $classe_groupe = $data_resa_groupes['classe_groupe'];
          $nb_enfants = $data_resa_groupes['nb_enfants'];
          $nb_accompagnateurs = $data_resa_groupes['nb_accompagnateurs'];
          $nb_gratuit = $data_resa_groupes['nb_gratuit'];
          $commentaire = $data_resa_groupes['coment'];
          $id_tarif = $data_resa_groupes['id_tarif'];
          
          $date_paiement = "0000-00-00";
		  $id_facture = "";
          //On regarde si une facture d'accompte existe et si oui si elle a été réglée
        $select_facture_acompte = "SELECT id, date_paiement FROM facture AS f WHERE id_resa = ".$num_resa_groupe." AND type_facture = 'acompte'";
        $req_select_facture =  mysql_query($select_facture_acompte) or die ('erreur selection facture');
        while($data_facture = mysql_fetch_array($req_select_facture)){
            $id_facture = $data_facture['id'];
            $date_paiement = $data_facture['date_paiement'];
        }
          ?>
        <tr onmouseover="this.className='highlight'" onmouseout="this.className='texte <?php echo "$line" ?>'">
            <td class="highlight"><?php echo $nom_structure;?></td>
            <td class="highlight"><?php echo $article;?></td>
            <td class="highlight"><?php echo $date_article;?></td>
            <td class="highlight"><?php echo $horaire;?></td>
            <td class="highlight"><?php echo $nom_referent;?></td>
            <td class="highlight"><?php echo $telephone_referent;?></td>
            <td class="highlight"><?php echo $classe_groupe;?></td>
            <td class="highlight"><?php echo $nb_enfants;?></td>
            <td class="highlight"><?php echo $nb_accompagnateurs;?> (<?php echo $nb_gratuit; ?>)</td>
            <td class="highlight"><?php echo $commentaire; ?></td>
            <td class="highlight"><a href='resa_groupe.php?num_resa_groupe=<?php echo $num_resa_groupe;?>'><img border="0" title="Voir la réservation du groupe" src="image/voir.gif" alt="voir"></a></td>
            <td class="highlight"><a href='form_resa_groupe.php?num_resa_groupe=<?php echo $num_resa_groupe;?>'><img border="0" alt="Modifier"  title="Modifier la réservation du groupe"src="image/edit.png"></a></td>
            <td>
                <form action="form_resa_groupe.php" name="dupliquer-resa-groupe" id="dupliquer-resa-groupe" method="POST">
                    <input type="hidden" name="num-groupe" value="<?php echo $num_groupe;?>"></input>
                    <input type="hidden" name="nom-referent" value="<?php echo $nom_referent;?>"></input>
                    <input type="hidden" name="telephone-referent" value="<?php echo $telephone_referent;?>"></input>
                    <input type="hidden" name="classe-groupe" value="<?php echo $classe_groupe;?>"></input>
                    <input type="hidden" name="nb-enfants" value="<?php echo $nb_enfants;?>"></input>
                    <input type="hidden" name="nb-accompagnateurs" value="<?php echo $nb_accompagnateurs;?>"></input>
                    <input type="hidden" name="nb-gratuit" value="<?php echo $nb_gratuit;?>"></input>
                    <input type="hidden" name="id-tarif" value="<?php echo $id_tarif;?>"></input>                    
                    <input type="submit" value="" class="duplication"</input>
                </form>
            </td>
            <td class="highlight"><a href='delete_resa_groupe.php?num_resa_groupe=<?php echo $num_resa_groupe;?>'><img border="0" title="Supprimer la réservation du groupe" alt="delete" src="image/delete.png"></a></td>
            <td class="highlight"><?php if(empty($id_facture)){?><a href="form_facture.php?num_groupe=<?php echo $num_groupe; ?>&num_resa=<?php echo $num_resa_groupe;?>&type=acompte&type_resa=groupe"><img src="image/facture.png" title="Créer la facture d'accompte" alt="Création de la facture d'acompte"></a><?php } else { if ($date_paiement == "0000-00-00") { echo 'Non payé';} else { echo 'Payé';}}?></td>        
        </tr>
        <?php
        } // fin du while data_groupes
        ?></tbody>
    </table></center>
<?php
include_once("include/bas.php");
?>