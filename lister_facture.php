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

$select_facture = "SELECT f.id, type_facture, nom_structure, article, date_spectacle, horaire, f.commentaire, total, numero_facture, date_paiement, p.nom FROM " . $tblpref ."bon_comm_groupe AS bcg, " . $tblpref ."groupe AS g, " . $tblpref ."article AS a, " . $tblpref ."facture AS f, " . $tblpref ."type_paiement AS p WHERE f.id_resa = bcg.num_bon_groupe AND bcg.id_article=a.num AND bcg.num_groupe = g.num_groupe AND f.id_paiement = p.id_type_paiement";
$req_facture = mysql_query($select_facture) or die('Erreur sql groupes'.$select_facture.'<br>'.mysql_error());

// ON affiche les groupes dans un tableau
?>
<center><table class="boiteaction page display" id="datatables">
        <caption>Liste des factures</caption>
        <thead>
        <tr>
            <th>Numéro de facture</th>
            <th>Nom de la structure</th>
            <th>Nom du spectacle</th>
            <th>Date du spectacle</th>
            <th>Horaire du spectacle</th>
            <th>Type de facture</th>
            <th>Montant</th>
            <th>Payée ?</th>
            <th>Date du paiement</th>
            <th>Commentaire</th>
            <th>Voir</th>
            <th>Modifier</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while($data_facture = mysql_fetch_array($req_facture)){
            $num_facture = $data_facture['id'];
          $numero_facture = $data_facture['numero_facture'];
          $nom_structure = $data_facture['nom_structure'];
          $article = $data_facture['article'];
          $date = strtotime($data_facture['date_spectacle']);
          $date_article = date_fr("l d-m-Y", $date);
          $horaire = $data_facture['horaire'];
          $type_facture = $data_facture['type_facture'];
          $total = $data_facture['total'];
          $paye = $data_facture['nom'];
          $date_paiement = $data_facture['date_paiement'];
          $commentaire = $data_resa_groupes['commentaire'];
          
          ?>
        <tr onmouseover="this.className='highlight'" onmouseout="this.className='texte <?php echo "$line" ?>'">
            <td class="highlight"><?php echo $numero_facture;?></td>
            <td class="highlight"><?php echo $nom_structure;?></td>
            <td class="highlight"><?php echo $article;?></td>
            <td class="highlight"><?php echo $date_article;?></td>
            <td class="highlight"><?php echo $horaire;?></td>
            <td class="highlight"><?php echo $type_facture;?></td>
            <td class="highlight"><?php echo $total;?></td>
            <td class="highlight"><?php echo $paye;?></td>
            <td class="highlight"><?php echo $date_paiement;?></td>
            <td class="highlight"><?php echo $commentaire; ?></td>
            <td class="highlight"><a href='facture.php?num_facture=<?php echo $num_facture;?>'><img border="0" title="Voir la réservation du groupe" src="image/voir.gif" alt="voir"></a></td>
            <td class="highlight"><a href='form_facture.php?num_facture=<?php echo $num_facture;?>'><img border="0" alt="Modifier"  title="Modifier la réservation du groupe"src="image/edit.png"></a></td>
        </tr>
        <?php
        } // fin du while data_groupes
        ?></tbody>
    </table></center>
<?php
include_once("include/bas.php");
?>