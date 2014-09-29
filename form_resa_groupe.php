<?php
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
Auteur : Vanessa Kovalsky : vanessa.kovalsky@free.fr
 */
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/fonction.php");
include_once("include/finhead.php");
include_once("include/configav.php");
include_once("include/head.php");

// On vérifie si des infos sont passés dans le formulaires

if(!empty($_GET['num_resa_groupe'])){
    $num_resa_groupe = $_GET['num_resa_groupe'];
    // On récupère les valeurs de la BDD pour l'id sélectionner
    // Récupération des informations de la réservation du groupe
    $sql_select_resa_groupe = "SELECT bcg.num_groupe,nom_structure, article, date_spectacle, horaire, nom_referent, telephone_referent, classe_groupe, nb_enfants, nb_accompagnateurs, nb_gratuit, id_article, coment, id_tarif FROM " . $tblpref ."bon_comm_groupe AS bcg, " . $tblpref ."groupe AS g, " . $tblpref ."article AS a WHERE num_bon_groupe='".$num_resa_groupe."' AND bcg.id_article=a.num AND bcg.num_groupe=g.num_groupe";
    $requete_select_resa_groupe = mysql_query($sql_select_resa_groupe) or die('Erreur SQL sélection groupe !<br>'.$sql_select_resa_groupe.'<br>'.mysql_error());
    while($data_resa_groupe = mysql_fetch_array($requete_select_resa_groupe)){
        $nom_structure = $data_resa_groupe['nom_structure'];
        $article = $data_resa_groupe['article'];
        $nom_referent = $data_resa_groupe['nom_referent'];
        $telephone_referent = $data_resa_groupe['telephone_referent'];
        $classe_groupe = $data_resa_groupe['classe_groupe'];
        $nb_enfants = $data_resa_groupe['nb_enfants'];
        $nb_accompagnateurs = $data_resa_groupe['nb_accompagnateurs'];
        $nb_gratuit = $data_resa_groupe['nb_gratuit'];
        $num_article_resa = $data_resa_groupe['id_article'];
        $comment_resa_groupe = $data_resa_groupe['coment'];
        $num_groupe_resa = $data_resa_groupe['num_groupe'];
        $tarif_groupe_resa = $data_resa_groupe['id_tarif'];
        }
}
elseif(!empty($_GET['num_groupe'])){
    $num_groupe_resa = $_GET['num_groupe'];
}

// On récupère la liste de groupe
    $select_groupe = "SELECT num_groupe, nom_structure FROM " . $tblpref ."groupe";
    $req_groupes = mysql_query($select_groupe) or die ('Erreur SQL selection groupe');
    while ($groupes = mysql_fetch_array($req_groupes)){
        $num_groupes[] = $groupes['num_groupe'];
        $nom_structures[] = $groupes['nom_structure'];
    }
    
// On récupère la liste des articles
    $select_articles = "SELECT num, article, date_spectacle, horaire FROM " . $tblpref ."article
                        WHERE date_spectacle >= NOW()  - INTERVAL 1 DAY
                        AND type_article = 'Spectacle_JP'
                        ORDER BY date_spectacle ASC";
    $req_articles = mysql_query($select_articles) or die ('Erreur SQL selection articles');
    while ($articles = mysql_fetch_array($req_articles)){
        $num_articles[] = $articles['num'];
        $nom_articles[] = $articles['article'];
        $timestamp[] = strtotime($articles['date_spectacle']);
        $horaire[] = $articles['horaire'];
    }
    // On met les dates dans le bon format
 
    foreach ($timestamp AS $date)
    {
        $date_spectacle[] = date_fr("l d-m-Y", $date);
    }
    
    //On récupère la liste des tarifs de groupes
    $select_tarif_groupe = "SELECT nom_tarif, prix_tarif, id_tarif FROM tarif WHERE tarif_groupe=1";
    $req_tarif_groupe = mysql_query($select_tarif_groupe) or die ('Erreur SQL selection tarif de groupe');    
    
// On affiche le formulaire
    ?>

<div id="form-resa-groupe">
    <h3><?php 
    if(empty($num_resa_groupe))
    {
        echo "Formulaire de création d'une réservation de groupe";
    }
    else {
        echo "Formulaire de modification d'une réservation du groupe ".$nom_structure;
    }
    ?>    
    </h3>
        <form action="resa_groupe.php" method="post" name="form-resa-groupe" id="form-resa-groupe">
            <label for="nom-groupe">Choix de la structure</label> : <select name="nom-groupe" id="nom-groupe" required>
                <?php
                foreach($num_groupes as $key => $num_groupe)
                    {
                    ?>
                    <option value="<?php echo $num_groupe; ?>"<?php if($num_groupe_resa == $num_groupe){ echo "selected"; }; ?>><?php echo $nom_structures[$key]; ?></option>
                    <?php
                    }
                ?>
            </select><br />
            <label for="nom-referent-groupe">Nom du référent</label> : <input type="text" name="nom-referent-groupe" id="nom-referent-groupe" required <?php if(isset($nom_referent)){ echo "value='".$nom_referent."'";}; ?>><?php if(isset($nom_referent)){ echo $nom_referent;}; ?></input><br />
            <label for="telephone-referent-groupe">Téléphone du référent</label> : <input type="tel" name="telephone-referent-groupe" id="telephone-referent-groupe" required <?php if(isset($telephone_referent)){ echo "value=".$telephone_referent.""; }; ?>><?php if(isset($telephone_referent)){ echo $telephone_referent;}; ?></input><br />
            <label for="classe-groupe">Classe / Age</label> : <input type="text" name="classe-groupe" id="classe-groupe" <?php if(isset($classe_groupe)){ echo "value=".$classe_groupe.""; }; ?>><?php if(isset($classe_groupe)){ echo $classe_groupe;}; ?></input><br />
            <label for="nb-enfants">Nombre d'enfants</label> : <input type="number" name="nb-enfants" id="nb-enfants" <?php if(isset($nb_enfants)){ echo "value=".$nb_enfants.""; }; ?>><?php if(isset($nb_enfants)){ echo $nb_enfants;}; ?></input><br />
            <label for="nb-accompagnateurs">Nombre d'accompagnateurs</label> : <input type="number" name="nb-accompagnateurs" id="nb-accompagnateurs" <?php if(isset($nb_accompagnateurs)){ echo "value=".$nb_accompagnateurs.""; }; ?>><?php if(isset($nb_accompagnateurs)){ echo $nb_accompagnateurs;}; ?></input>
            <label for="nb-accompagnateurs-gratuit">dont gratuit</label> : <input type="number" name="nb-accompagnateurs-gratuit" id="nb-accompagnateurs-gratuit" <?php if(isset($nb_gratuit)){ echo "value=".$nb_gratuit.""; }; ?>><?php if(isset($nb_gratuit)){ echo $nb_gratuit;}; ?></input><br />
            <label for="id-article">Choix du spectacle</label> : <select name="id-article" id="id-article" required>
                <?php
                foreach($num_articles as $key2 => $num_article)
                    {
                    ?>
                    <option value="<?php echo $num_article; ?>"<?php if($num_article_resa == $num_article){ echo "selected"; }; ?>><?php echo $nom_articles[$key2].' - '.$date_spectacle[$key2].' - '.$horaire[$key2]; ?></option>
                    <?php
                    }
                ?>
            </select><br />
            <label for="tarif-groupe">Tarif</label>
            <select id="tarif-groupe" name="tarf-groupe">
                <?php while($data_tarif_groupe = mysql_fetch_array($req_tarif_groupe)){
                    ?>
                <option value="<?php echo $data_tarif_groupe['id_tarif'];?>" <?php if($tarif_groupe_resa == $data_tarif_groupe['id_tarif']){echo 'selected';}?>><?php echo $data_tarif_groupe['nom_tarif'].' - '.$data_tarif_groupe['prix_tarif']; ?></option>
                <?php
                } ?>
            </select><br />
            <label for="coment">Commentaire pour la réservation</label>
            <textarea name="coment" id="coment" cols="45" rows="3" <?php if(isset($comment_resa_groupe)){ echo "value=".$comment_resa_groupe.""; }; ?>><?php if(isset($comment_resa_groupe)){ echo $comment_resa_groupe;}; ?></textarea>
            <?php 
            if(isset($num_resa_groupe)){
              ?>
            <br />
            <input type="hidden" name="num-resa-groupe" id="num-resa-groupe" value="<?php echo $num_resa_groupe; ?>"></input>
            <input type="hidden" name="ancien_nb_enfant" id="ancien_nb_enfant" value="<?php echo $nb_enfants; ?>"></input>
            <input type="hidden" name="ancien_nb_accompagnateur" id="ancien_nb_accompagnateur" value="<?php echo $nb_accompagnateurs; ?>"></input>
            <input type="hidden" name="ancien_article" id="ancien_article" value="<?php echo $num_article_resa; ?>"></input>
            <?php
            }
            ?>
            <input type="submit" name="valider-groupe" id="valider-groupe" value="<?php
                   if(empty($num_resa_groupe)){
                        echo "Créer la réservation de groupe";
                   }
                   else {
                       echo "Enregistrer la réservation de groupe";
                   }
                    ?>"></input>
        </form>
</div>
<?php
include_once("include/bas.php");
?>