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

// On récupère le numero de vente de l'abonnement
$num_abo_com=isset($_GET['num_abo_com'])?$_GET['num_abo_com']:"";

// On sélectionne les réservations liées à l'abonnement pour les supprimer 
$sql_resa = "SELECT num_resa_1, num_resa_2, num_resa_3, num_resa_4, num_resa_5, num_resa_6, num_resa_7 FROM abonnement_comm WHERE num_abo_com='$num_abo_com'";
$result_resa = mysql_query($sql_resa) OR DIE ("Erreur selection réservations");
while($data_resa = mysql_fetch_array($result_resa)){
    $resa1 = $data_resa['num_resa_1'];
    $resa2 = $data_resa['num_resa_2'];
    $resa3 = $data_resa['num_resa_3'];
    $resa4 = $data_resa['num_resa_4'];
    $resa5 = $data_resa['num_resa_5'];
    $resa6 = $data_resa['num_resa_6'];
    $resa7 = $data_resa['num_resa_7'];
}
// On met à jour le stock des articles concernés
// Résa 1
if (!empty($resa1)){
    // Sélection de l'article et de son stock
    $select_article_1 = "SELECT stock, id_article FROM bon_comm AS bc, article AS a WHERE bc.num_bon = '$resa1' AND bc.id_article = a.num";
    $req_article_1 = mysql_query($select_article_1) or die ('Erreur sélection stock article');
    while ($data_article_1 = mysql_fetch_array($req_article_1)){
        $article_1 = $data_article_1['id_article'];
        $stock_article_1 = $data_article_1['stock'];
    }
    // on met à jour le stock
    $update_stock_article_1 = "UPDATE article SET stock = '$stock_article_1' +1 WHERE num='$article_1'";
    mysql_query($update_stock_article_1) or die ('Erreur SQL maj stock');
}
// Résa 2
if (!empty($resa2)){
    // Sélection de l'article et de son stock
    $select_article_2 = "SELECT stock, id_article FROM bon_comm AS bc, article AS a WHERE bc.num_bon = '$resa2' AND bc.id_article = a.num";
    $req_article_2 = mysql_query($select_article_2) or die ('Erreur sélection stock article');
    while ($data_article_2 = mysql_fetch_array($req_article_2)){
        $article_2 = $data_article_2['id_article'];
        $stock_article_2 = $data_article_2['stock'];
    }
    // on met à jour le stock
    $update_stock_article_2 = "UPDATE article SET stock = '$stock_article_2' +1 WHERE num='$article_2'";
    mysql_query($update_stock_article_2) or die ('Erreur SQL maj stock');
}
// Résa 3
if (!empty($resa3)){
    // Sélection de l'article et de son stock
    $select_article_3 = "SELECT stock, id_article FROM bon_comm AS bc, article AS a WHERE bc.num_bon = '$resa3' AND bc.id_article = a.num";
    $req_article_3 = mysql_query($select_article_3) or die ('Erreur sélection stock article');
    while ($data_article_3 = mysql_fetch_array($req_article_3)){
        $article_3 = $data_article_3['id_article'];
        $stock_article_3 = $data_article_3['stock'];
    }
    // on met à jour le stock
    $update_stock_article_3 = "UPDATE article SET stock = '$stock_article_3' +1 WHERE num='$article_3'";
    mysql_query($update_stock_article_3) or die ('Erreur SQL maj stock');
}
// Résa 4
if (!empty($resa4)){
    // Sélection de l'article et de son stock
    $select_article_4 = "SELECT stock, id_article FROM bon_comm AS bc, article AS a WHERE bc.num_bon = '$resa4' AND bc.id_article = a.num";
    $req_article_4 = mysql_query($select_article_4) or die ('Erreur sélection stock article');
    while ($data_article_4 = mysql_fetch_array($req_article_4)){
        $article_4 = $data_article_4['id_article'];
        $stock_article_4 = $data_article_4['stock'];
    }
    // on met à jour le stock
    $update_stock_article_4 = "UPDATE article SET stock = '$stock_article_4' +1 WHERE num='$article_4'";
    mysql_query($update_stock_article_4) or die ('Erreur SQL maj stock');
}
// Résa 5
if (!empty($resa5)){
    // Sélection de l'article et de son stock
    $select_article_5 = "SELECT stock, id_article FROM bon_comm AS bc, article AS a WHERE bc.num_bon = '$resa5' AND bc.id_article = a.num";
    $req_article_5 = mysql_query($select_article_5) or die ('Erreur sélection stock article');
    while ($data_article_5 = mysql_fetch_array($req_article_5)){
        $article_5 = $data_article_5['id_article'];
        $stock_article_5 = $data_article_5['stock'];
    }
    // on met à jour le stock
    $update_stock_article_5 = "UPDATE article SET stock = '$stock_article_5' +1 WHERE num='$article_5'";
    mysql_query($update_stock_article_5) or die ('Erreur SQL maj stock');
}
// Résa 6
if (!empty($resa6)){
    // Sélection de l'article et de son stock
    $select_article_6 = "SELECT stock, id_article FROM bon_comm AS bc, article AS a WHERE bc.num_bon = '$resa6' AND bc.id_article = a.num";
    $req_article_6 = mysql_query($select_article_6) or die ('Erreur sélection stock article');
    while ($data_article_6 = mysql_fetch_array($req_article_6)){
        $article_6 = $data_article_6['id_article'];
        $stock_article_6 = $data_article_6['stock'];
    }
    // on met à jour le stock
    $update_stock_article_6 = "UPDATE article SET stock = '$stock_article_6' +1 WHERE num='$article_6'";
    mysql_query($update_stock_article_6) or die ('Erreur SQL maj stock');
}
// Résa 7
if (!empty($resa7)){
    // Sélection de l'article et de son stock
    $select_article_7 = "SELECT stock, id_article FROM bon_comm AS bc, article AS a WHERE bc.num_bon = '$resa7' AND bc.id_article = a.num";
    $req_article_7 = mysql_query($select_article_7) or die ('Erreur sélection stock article');
    while ($data_article_7 = mysql_fetch_array($req_article_7)){
        $article_7 = $data_article_7['id_article'];
        $stock_article_7 = $data_article_7['stock'];
    }
    // on met à jour le stock
    $update_stock_article_7 = "UPDATE article SET stock = '$stock_article_7' +1 WHERE num='$article_7'";
    mysql_query($update_stock_article_7) or die ('Erreur SQL maj stock');
}

// On supprime les réservations
$sql_delete_resa1 = "DELETE 
                    FROM bon_comm
                    WHERE num_bon = '$resa1'";
$delete_resa1 = mysql_query($sql_delete_resa1) OR DIE ("Erreur suppression resa 1");
$sql_delete_resa2 = "DELETE 
                    FROM bon_comm
                    WHERE num_bon = '$resa2'";
$delete_resa2 = mysql_query($sql_delete_resa2) OR DIE ("Erreur suppression resa 2");
$sql_delete_resa3 = "DELETE 
                    FROM bon_comm
                    WHERE num_bon = '$resa3'";
$delete_resa3 = mysql_query($sql_delete_resa3) OR DIE ("Erreur suppression resa 3");
$sql_delete_resa4 = "DELETE 
                    FROM bon_comm
                    WHERE num_bon = '$resa4'";
$delete_resa4 = mysql_query($sql_delete_resa4) OR DIE ("Erreur suppression resa 4");
$sql_delete_resa5 = "DELETE 
                    FROM bon_comm
                    WHERE num_bon = '$resa5'";
$delete_resa5 = mysql_query($sql_delete_resa5) OR DIE ("Erreur suppression resa 5");
$sql_delete_resa6 = "DELETE 
                    FROM bon_comm
                    WHERE num_bon = '$resa6'";
$delete_resa6 = mysql_query($sql_delete_resa6) OR DIE ("Erreur suppression resa 6");
$sql_delete_resa7 = "DELETE 
                    FROM bon_comm
                    WHERE num_bon = '$resa7'";
$delete_resa7 = mysql_query($sql_delete_resa7) OR DIE ("Erreur suppression resa 7");

//On supprime l'abonnement
$req_delete_abo = "DELETE 
                   FROM abonnement_comm
                   WHERE num_abo_com = '$num_abo_com'";
$delete_abo = mysql_query( $req_delete_abo )or die( "Il y à eu une erreur lors de la supression de l'abonnement");
?>
<br/>
<br/>
<br/>



    <table border="0" class="page" align="center">
        <tr>          
                <caption> Suppression d'Abonnement </caption>
        </tr>
        <tr>
            <th> L'abonnement a ete supprime avec succes ! </th>
        </tr>

        <tr>   
          
<form method='post'>
        <table border="0" class="page" align="center">

                    <tr>
                    <!-- Bouton :ajouter abonnement -->
                        <td> 
                            <a href='new_abonnement.php'><img border =0 src="image/new_mini_abonnement.png" alt=""> <br> Ajouter une nouvelle formule d'abonnement </a>
                        </td>

                    <!-- Bouton : lister les abonnement  -->
                        <td>
                            <a href='lister_abonnement.php'><img border =0 src="image/lister_abonnement_gris.png" alt=""> <br> Lister les differentes formules d'abonnements </a>
                        </td>
                    </tr>

        </table>
</form>

    </table>



<?php
include_once("include/bas.php");
?>
