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

//On enregistre les modifications sur l'accompte
if($_POST){
    $montant_modif = $_POST['montant'];
    $paye_modif = $_POST['accompte-paye'];
    $num_bon_groupe = $_POST['num-bon-groupe'];
    
    $sql_update_accompte = "UPDATE  ". $tblpref ."accompte SET montant='".$montant_modif."', paye='".$paye_modif."' WHERE num_bon_groupe='".$num_bon_groupe."' ";
    mysql_query($sql_update_accompte) or die('Erreur MAJ accompte' . mysql_error());
}

// On récupère la liste des réservations de groupes

$select_resa_groupes = "SELECT bcg.num_bon_groupe, bcg.num_groupe, nom_structure, article, date_spectacle, horaire, nom_referent, telephone_referent, classe_groupe, nb_enfants, nb_accompagnateurs, nb_gratuit, id_article, coment, montant, paye FROM " . $tblpref ."bon_comm_groupe AS bcg, " . $tblpref ."groupe AS g, " . $tblpref ."article  AS a , " . $tblpref ."accompte AS ac WHERE bcg.id_article=a.num AND bcg.num_groupe=g.num_groupe AND bcg.num_bon_groupe = ac.num_bon_groupe";
$req_resa_groupes = mysql_query($select_resa_groupes) or die('Erreur sql groupes'.$select_resa_groupes.'<br>'.mysql_error());

// ON affiche les groupes dans un tableau
?>
<center><table class="boiteaction page display" id="datatables">
        <caption>Liste des accomptes de groupes</caption>
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
            <th>Montant de l'Acompte</th>
            <th>Payé ?</th>
            <th>Enregistrer l'accompte</th>
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
          $montant = $data_resa_groupes['montant'];
          $paye = $data_resa_groupes['paye']

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
            <form action="lister_accompte.php" method="POST" name="forma-accompte" id="forma-accompte">
                <td class="highlight"><input type="text" name="montant" id="montant" value="<?php if(!empty($montant)){echo $montant;}?>"></input></td>
                <td class="highlight">
                    <select id="accompte-paye" name="accompte-paye">
                        <option value="0" <?php if($paye == '0'){echo 'selected';}?>>Non</option>
                        <option value="1" <?php if($paye == '1'){echo 'selected';}?>>Oui</option>
                    </select>
                </td>
                <input type="hidden" value="<?php echo $num_resa_groupe;?>" name="num-bon-groupe" id="num-bon-groupe" />
            <td class="highlight"><input type="submit" id="valider-accompte" value="Enregistrer"/> </input></td>
            </form>
        </tr>
        <?php
        } // fin du while data_groupes
        ?></tbody>
    </table></center>
<?php
include_once("include/bas.php");
?>