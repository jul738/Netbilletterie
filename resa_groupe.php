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
include_once("include/finhead.php");
include_once("include/configav.php");
include_once("include/head.php");
include_once("include/fonction.php");

if (!empty($_POST)){
    //On enregistre les valeurs dans bon_comm_groupe

    if(isset($_POST['num-resa-groupe'])){
        $num_resa_groupe = $_POST['num-resa-groupe'];
        $num_groupe = $_POST['num-resa-groupe'];
        $ancien_nb_enfants = $_POST['ancien_nb_enfant'];
        $ancien_nb_accompagnateurs = $_POST['ancien_nb_accompagnateur'];
        $ancien_nb_accompagnateurs;
        $quanti_ancien = $ancien_nb_accompagnateurs + $ancien_nb_enfants;
        $ancien_article = $_POST['ancien_article'];
    }
    $num_groupe = mysql_escape_string($_POST['nom-groupe']);
    $nom_referent = mysql_escape_string($_POST['nom-referent-groupe']);
    $telephone_referent = $_POST['telephone-referent-groupe'];
    $classe_groupe = $_POST['classe-groupe'];
    $nb_enfants = $_POST['nb-enfants'];
    $nb_accompagnateurs = $_POST['nb-accompagnateurs'];
    $nb_gratuit = $_POST['nb-accompagnateurs-gratuit']; 
    $id_article = $_POST['id-article'];
    $coment = mysql_escape_string($_POST['coment']);
    
    // Insert dans la base
    // Si nouveau alors création de la réservation du groupe
    if(empty($num_resa_groupe)){
        $sql_insert_resa_groupe = "INSERT INTO " . $tblpref ."bon_comm_groupe(num_groupe, nom_referent, telephone_referent, classe_groupe, nb_enfants, nb_accompagnateurs, nb_gratuit, id_article, coment) VALUES('$num_groupe', '$nom_referent', '$telephone_referent', '$classe_groupe', '$nb_enfants', '$nb_accompagnateurs', '$nb_gratuit', '$id_article', '$coment')";
        $requete_insert_resa_groupe = mysql_query($sql_insert_resa_groupe) or die('Erreur SQL création réservation groupe !<br>'.$requete_insert_resa_groupe.'<br>'.mysql_error());
        $num_resa_groupe = mysql_insert_id();
    }
    // Si existant alors MAJ de la ligne
    else{
        $sql_update_resa_groupe = "UPDATE " . $tblpref ."bon_comm_groupe SET num_groupe='".$num_groupe."', nom_referent='".$nom_referent."', telephone_referent='".$telephone_referent."', classe_groupe='".$classe_groupe."', nb_enfants='".$nb_enfants."', nb_accompagnateurs='".$nb_accompagnateurs."', nb_gratuit='".$nb_gratuit."', id_article='".$id_article."', coment='".$coment."' WHERE num_bon_groupe='".$num_resa_groupe."' ";
        $requete_update_resa_groupe = mysql_query($sql_update_resa_groupe) or die('Erreur SQL modification réservation groupe !<br>'.$sql_update_resa_groupe.'<br>'.mysql_error());
    }
    
     // On décrémente le stock du nombre de places
    //On calcule la quantité de réservation
    $quanti_nouveau = $nb_enfants + $nb_accompagnateurs;
    
    // Si MAJ de l'existant alors on calcule la différence dans le nombre de place
    
    if(!empty($quanti_ancien)){
        $quanti = $quanti_nouveau - $quanti_ancien;
    }
    else{
        $quanti = $quanti_nouveau;
    }
    
    // On met à jour le stock
    
    $sql_update_stock = "UPDATE `".$tblpref."article` SET `stock` = (stock - ".$quanti.") WHERE `num` = '".$id_article."'";
    mysql_query($sql_update_stock) or die('Erreur SQL MAJ du stock !<br>'.$sql_update_stock.'<br>'.mysql_error());

    //On change le statut du spectacle par complet si le stock est en <=0
    $select_article= "SELECT stock, article FROM ".$tblpref."article WHERE num=$id_article ";
    $result_article = mysql_query( $select_article ) or die( "Execution requete sélection article impossible.");
        while ( $row = mysql_fetch_array( $result_article)) {
            $stock = $row["stock"];
            
        }
        if ( $stock <=0){
            $sql_update_article = "UPDATE `".$tblpref."article` SET `actif` = 'COMPLET' WHERE `num` =$id_article";
            mysql_query($sql_update_article) or die('Erreur SQL update article !<br>'.$sql_update_article.'<br>'.mysql_error());
        }
    // On met à jour le stock en cas de modification de l'article
        if(!empty($ancien_article)){
        if($id_article != $ancien_article){
            // MAJ du stock de l'ancien article
                $select_stock_ancien_article= "SELECT stock, article FROM ".$tblpref."article WHERE num=$ancien_article ";
                $result_stock_ancien_article = mysql_query( $select_stock_ancien_article ) or die( "Execution requete sélection article impossible.");
            while ( $row_stock_ancien = mysql_fetch_array( $result_stock_ancien_article)) {
                $stock_ancien = $row_stock_ancien["stock"];
            }
            if ($stock_ancien >=1){
                $quanti_ancien = '+'.$quanti_ancien;
            }
            else {
                $quanti_ancien = '-'.$quanti_ancien;
            }
            $update_stock_ancien = "UPDATE ".$tblpref."article SET stock= ($stock_ancien $quanti_ancien) WHERE num=$ancien_article";
            mysql_query($update_stock_ancien) or die ('Erreur MAJ Stock de l\'ancien article');
            
            // MAJ du stock du nouvel article
                $select_stock_article= "SELECT stock, article FROM ".$tblpref."article WHERE num=$id_article ";
                $result_stock_article = mysql_query( $select_stock_article ) or die( "Execution requete sélection article impossible.");
            while ( $row_stock = mysql_fetch_array( $result_stock_article)) {
                $stock_nouveau = $row_stock["stock"];
            }
            $update_stock = "UPDATE ".$tblpref."article SET stock= ('$stock_nouveau' - '$quanti_nouveau') WHERE num=$id_article";
            mysql_query($update_stock) or die ('Erreur MAJ Stock du nouvel article');
        }
        }
}
//Si affichage, on récupère le numéro du groupe
elseif(isset($_GET['num_resa_groupe'])){
    $num_resa_groupe = $_GET['num_resa_groupe'];
}

// On affiche un groupe

// Récupération des informations de la réservation du groupe
$sql_select_resa_groupe = "SELECT nom_structure, article, date_spectacle, horaire, nom_referent, telephone_referent, classe_groupe, nb_enfants, nb_accompagnateurs, nb_gratuit, id_article, coment FROM " . $tblpref ."bon_comm_groupe AS bcg, " . $tblpref ."groupe AS g, " . $tblpref ."article AS a WHERE num_bon_groupe='".$num_resa_groupe."' AND bcg.id_article=a.num AND bcg.num_groupe=g.num_groupe";
$requete_select_resa_groupe = mysql_query($sql_select_resa_groupe) or die('Erreur SQL sélection groupe !<br>'.$sql_select_resa_groupe.'<br>'.mysql_error());
while($data_resa_groupe = mysql_fetch_array($requete_select_resa_groupe)){
    $nom_structure = $data_resa_groupe['nom_structure'];
    $article = $data_resa_groupe['article'];
    $date = strtotime($data_resa_groupe['date_spectacle']);
    $horaire = $data_resa_groupe['horaire'];
    $nom_referent = $data_resa_groupe['nom_referent'];
    $tel_referent = $data_resa_groupe['telephone_referent'];
    $classe_groupe = $data_resa_groupe['classe_groupe'];
    $nb_enfants = $data_resa_groupe['nb_enfants'];
    $nb_accompagnateurs = $data_resa_groupe['nb_accompagnateurs'];
    $nb_gratuit = $data_resa_groupe['nb_gratuit'];
    $coment = $data_resa_groupe['coment'];
}

$date_article = date_fr("l d-m-Y", $date);
?>
<div id="resa-groupe">
    <h3>Réservation du groupe <?php echo $nom_structure; ?></h3>
    <div id="nom-groupe">Nom spectacle : <?php echo $article; ?></div>
    <div id="date-spectacle">Date spectacle : <?php echo $date_article; ?></div>
    <div id="horaire-spectacle">Horaire du spectacle : <?php echo $horaire; ?></div>    
    <div id="adresse-groupe">Nom référent : <?php echo $nom_referent; ?></div>
    <div id="telephone-groupe">Téléphone référent : <?php echo $tel_referent; ?></div>
    <div id="classe-groupe">Classe / Age du groupe : <?php echo $classe_groupe; ?></div>
    <div id="nb_enfants">Nombre d'enfants : <?php echo $nb_enfants; ?></div>
    <div id="nb-accompagnateurs">Nombres d'accompagnateurs : <?php echo $nb_accompagnateurs; ?> dont gratuit : <?php echo $nb_gratuit; ?></div>
    <div id="comentaire-resa-groupe">Commentaire de la réservation : <?php echo $coment; ?></div>
</div>
<?php
include("include/bas.php");
?>