<?php

/* Net Billetterie Copyright(C)2014 Vanessa Kovalsky David
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Vanessa Kovalsky vanessa.kovalsky@free.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/fonction.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");

//Si affichage, on récupère le numéro du groupe
if(isset($_GET['num_groupe'])){
    $num_groupe = $_GET['num_groupe'];
}


// Si post du formulaire, on récupère les variable et on les enregistre 
elseif(isset($_POST)){
    // Récupère les variables
    if(isset($_POST['num-groupe'])){
        $num_groupe = $_POST['num-groupe'];
    }
    $nom_structure = mysql_escape_string($_POST['nom-groupe']);
    $rue_structure = mysql_escape_string($_POST['rue-groupe']);
    $cp_structure = mysql_escape_string($_POST['cp-groupe']);
    $ville_structure = mysql_escape_string($_POST['ville-groupe']);
    $telephone_structure = $_POST['telephone-groupe'];
    $email_structure = $_POST['email-groupe'];

    // Insert dans la base
    // Si nouveau alors création du groupe
    if(empty($num_groupe)){
        $sql_insert_groupe = "INSERT INTO " . $tblpref ."groupe(nom_structure, rue, cp, ville, telephone, email) VALUES('$nom_structure', '$rue_structure', '$cp_structure', '$ville_structure', '$telephone_structure', '$email_structure')";
        $requete_insert_groupe = mysql_query($sql_insert_groupe) or die('Erreur SQL création groupe !<br>'.$requete_insert_groupe.'<br>'.mysql_error());
        $num_groupe = mysql_insert_id();
        
        //Affichage du bouton de réservation
        ?>
        <div class='page'>
        <div class='submit bouton-seul'>
        <a href='form_resa_groupe.php?num_groupe=<?php echo $num_groupe; ?>'>Créer une réservation pour <?php echo $nom_structure; ?> </a>
            </div>
        </div>
<?php
    }
    // Si existant alors MAJ de la ligne
    else{
        $sql_update_groupe = "UPDATE " . $tblpref ."groupe SET nom_structure='".$nom_structure."', rue='".$rue_structure."', cp='".$cp_structure."', ville='".$ville_structure."', telephone='".$telephone_structure."', email='".$email_structure."' WHERE num_groupe=".$num_groupe." ";
        $requete_update_groupe = mysql_query($sql_update_groupe) or die('Erreur SQL maj groupe !<br>'.$requete_update_groupe.'<br>'.mysql_error());
    }
}
// On affiche un groupe

// Récupération des informations du groupe
$sql_select_groupe = "SELECT nom_structure, rue, cp, ville, telephone, email FROM " . $tblpref ."groupe WHERE num_groupe=".$num_groupe."";
$requete_select_groupe = mysql_query($sql_select_groupe) or die('Erreur SQL sélection groupe !<br>'.$requete_select_groupe.'<br>'.mysql_error());
while($data_un_groupe = mysql_fetch_array($requete_select_groupe)){
    $nom_structure = $data_un_groupe['nom_structure'];
    $rue_structure = $data_un_groupe['rue'];
    $cp_structure = $data_un_groupe['cp'];
    $ville_structure = $data_un_groupe['ville'];
    $telephone_structure = $data_un_groupe['telephone'];
    $email_structure = $data_un_groupe['email'];
}
?>
<div id="groupe">
    <h3>Groupe <?php echo $nom_structure; ?></h3>
    <div id="nom-groupe">Nom structure : <?php echo $nom_structure; ?></div>
    <div id="rue-groupe">Rue structure : <?php echo $rue_structure; ?></div>
    <div id="cp-groupe">Code postal structure : <?php echo $cp_structure; ?></div>
    <div id="ville-groupe">Ville structure : <?php echo $ville_structure; ?></div>
    <div id="telephone-groupe">Téléphone structure : <?php echo $telephone_structure; ?></div>
    <div id="email-groupe">Email structure : <?php echo $email_structure; ?></div>
</div>
<?php
// On récupère la liste des réservations du groupe

$select_resa_groupes = "SELECT num_bon_groupe, bcg.num_groupe, nom_structure, article, date_spectacle, horaire, nom_referent, telephone_referent, classe_groupe, nb_enfants, nb_accompagnateurs, nb_gratuit, id_article, coment FROM " . $tblpref ."bon_comm_groupe AS bcg, " . $tblpref ."groupe AS g, " . $tblpref ."article AS a WHERE bcg.id_article=a.num AND bcg.num_groupe=g.num_groupe AND bcg.num_groupe=".$num_groupe."";
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
            <td class="highlight"><a href='delete_resa_groupe.php?num_resa_groupe=<?php echo $num_resa_groupe;?>'><img border="0" title="Supprimer la réservation du groupe" alt="delete" src="image/delete.png"></a></td>
        </tr>
        <?php
        } // fin du while data_groupes
        ?></tbody>
    </table></center>

<?php
include("include/bas.php");
?>