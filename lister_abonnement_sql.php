<?php
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/fonction.php");

//Affiche les abonnement vendu 
$req_liste_abo_vendu = "SELECT ac.num_abo_com, c.nom, c.prenom, ac.date, a.nom_abonnement, ac.num_resa_1, ac.num_resa_2, ac.num_resa_3, ac.num_resa_4, ac.num_resa_5, ac.num_resa_6, ac.num_resa_7, commentaire
                        FROM abonnement_comm ac, abonnement a, client c
                        WHERE ac.num_abonnement = a.num_abonnement
                        AND c.num_client = ac.client_num
                        ORDER BY ac.num_abo_com ASC";
$liste_abo_vendu = mysql_query($req_liste_abo_vendu) or die('Erreur Req_liste_abo !<br>'.$req_liste_abo_vendu.'<br>'.mysql_error());

$json_array = array(
//'draw' => 1,
'iTotalRecords' => 0,
'iTotalDisplayRecords' => 0,
'aaData' => array(),
);

 $nombre="1";
while($data = mysql_fetch_array($liste_abo_vendu)) {
    //On initalise les variables
    $choix_spectacle_1 = "";
    $choix_spectacle_2 = "";
    $choix_spectacle_3 = "";
    $choix_spectacle_4 = "";
    $choix_spectacle_5 = "";
    $choix_spectacle_6 = "";
    $choix_spectacle_7 = "";
    $date_spectacle_1 = "";
    $date_spectacle_2 = "";
    $date_spectacle_3 = "";
    $date_spectacle_4 = "";
    $date_spectacle_5 = "";
    $date_spectacle_6 = "";
    $date_spectacle_7 = "";
    $horaire_spectacle_1 = "";
    $horaire_spectacle_2 = "";
    $horaire_spectacle_3 = "";
    $horaire_spectacle_4 = "";
    $horaire_spectacle_5 = "";
    $horaire_spectacle_6 = "";
    $horaire_spectacle_7 = "";

    $num_abo_com = $data['num_abo_com'];
    $nom = $data['nom'];
    $prenom = $data['prenom'];
    $date_timestamp = strtotime($data['date']);
    $date = date_fr('l d-m-Y', $date_timestamp);
    $nom_abonnement = $data['nom_abonnement'];
    $num_resa_1 = $data['num_resa_1'];
    $num_resa_2 = $data['num_resa_2'];
    $num_resa_3 = $data['num_resa_3'];
    $num_resa_4 = $data['num_resa_4'];
    $num_resa_5 = $data['num_resa_5'];
    $num_resa_6 = $data['num_resa_6'];
    $num_resa_7 = $data['num_resa_7'];
    $commentaire = $data['commentaire'];

    // ON récupère les nom des spectacles correspondant au numéro
    if(!empty($num_resa_1)){
        $req_spectacle_1 = 'SELECT article, date_spectacle, horaire FROM article, bon_comm AS bc WHERE bc.num_bon='.$num_resa_1.' AND bc.id_article = article.num';
        $sql_spectacle_1 = mysql_query($req_spectacle_1);
        while ( $data_spec_1 = mysql_fetch_array($sql_spectacle_1)){
            $choix_spectacle_1 = $data_spec_1['article'];
            $date_timestamp_1 = strtotime($data_spec_1['date_spectacle']);
            $horaire_spectacle_1 = $data_spec_1['horaire'];
        }
        $date_spectacle_1 = date_fr("l d-m-Y", $date_timestamp_1);
    }
                            
    // ON récupère les nom des spectacles correspondant au numéro
    if(!empty($num_resa_2)){
        $req_spectacle_2 = 'SELECT article, date_spectacle, horaire FROM article, bon_comm AS bc WHERE bc.num_bon='.$num_resa_2.' AND bc.id_article = article.num';
        $sql_spectacle_2 = mysql_query($req_spectacle_2);
        while ( $data_spec_2 = mysql_fetch_array($sql_spectacle_2)){
            $choix_spectacle_2 = $data_spec_2['article'];
            $date_timestamp_2 = strtotime($data_spec_2['date_spectacle']);
            $horaire_spectacle_2 = $data_spec_2['horaire'];
        }
        $date_spectacle_2 = date_fr("l d-m-Y", $date_timestamp_2);
    }
                            
    // ON récupère les nom des spectacles correspondant au numéro
    if(!empty($num_resa_3)){
        $req_spectacle_3 = 'SELECT article, date_spectacle, horaire FROM article, bon_comm AS bc WHERE bc.num_bon='.$num_resa_3.' AND bc.id_article = article.num';
        $sql_spectacle_3 = mysql_query($req_spectacle_3);
        while ( $data_spec_3 = mysql_fetch_array($sql_spectacle_3)){
            $choix_spectacle_3 = $data_spec_3['article'];
            $date_timestamp_3 = strtotime($data_spec_3['date_spectacle']);
            $horaire_spectacle_3 = $data_spec_3['horaire'];
        }
        $date_spectacle_3 = date_fr("l d-m-Y", $date_timestamp_3);
    }
                            
    // ON récupère les nom des spectacles correspondant au numéro
    if (!empty($num_resa_4)){
        $req_spectacle_4 = 'SELECT article, date_spectacle, horaire FROM article, bon_comm AS bc WHERE bc.num_bon='.$num_resa_4.' AND bc.id_article = article.num';
        $sql_spectacle_4 = mysql_query($req_spectacle_4);
        while ( $data_spec_4 = mysql_fetch_array($sql_spectacle_4)){
            $choix_spectacle_4 = $data_spec_4['article'];
            $date_timestamp_4 = strtotime($data_spec_4['date_spectacle']);
            $horaire_spectacle_4 = $data_spec_4['horaire'];
        }
        $date_spectacle_4 = date_fr("l d-m-Y", $date_timestamp_4);
    }
    // ON récupère les nom des spectacles correspondant au numéro
    if (!empty($num_resa_5)){
        $req_spectacle_5 = 'SELECT article, date_spectacle, horaire FROM article, bon_comm AS bc WHERE bc.num_bon='.$num_resa_5.' AND bc.id_article = article.num';
        $sql_spectacle_5 = mysql_query($req_spectacle_5);
        while ( $data_spec_5 = mysql_fetch_array($sql_spectacle_5)){
            $choix_spectacle_5 = $data_spec_5['article'];
            $date_timestamp_5 = strtotime($data_spec_5['date_spectacle']);
            $horaire_spectacle_5 = $data_spec_5['horaire'];
        }
        $date_spectacle_5 = date_fr("l d-m-Y", $date_timestamp_5);
    }
                            
    // ON récupère les nom des spectacles correspondant au numéro
    if(!empty($num_resa_6)){
        $req_spectacle_6 = 'SELECT article, date_spectacle, horaire FROM article, bon_comm AS bc WHERE bc.num_bon='.$num_resa_6.' AND bc.id_article = article.num';
        $sql_spectacle_6 = mysql_query($req_spectacle_6);
        while ( $data_spec_6 = mysql_fetch_array($sql_spectacle_6)){
            $choix_spectacle_6 = $data_spec_6['article'];
            $date_timestamp_6 = strtotime($data_spec_6['date_spectacle']);
            $horaire_spectacle_6 = $data_spec_6['horaire'];
        }
        $date_spectacle_6 = date_fr("l d-m-Y", $date_timestamp_6);
    }
                            
    // ON récupère les nom des spectacles correspondant au numéro
    if(!empty($num_resa_7)){
        $req_spectacle_7 = 'SELECT article, date_spectacle, horaire FROM article, bon_comm AS bc WHERE bc.num_bon='.$num_resa_7.' AND bc.id_article = article.num';
        $sql_spectacle_7 = mysql_query($req_spectacle_7);
        while ( $data_spec_7 = mysql_fetch_array($sql_spectacle_7)){
            $choix_spectacle_7 = $data_spec_7['article'];
            $date_timestamp_7 = strtotime($data_spec_7['date_spectacle']);
            $horaire_spectacle_7 = $data_spec_7['horaire'];
        }
        $date_spectacle_7 = date_fr("l d-m-Y", $date_timestamp_7);
    }
    $json_data = array(
        'num_bon' => $num_abo_com,
        'nom' => $nom,
        'prenom' => $prenom,
        'date' => $date,
        'abo' => $nom_abonnement,
        'spectacle_1' => $choix_spectacle_1.'<br />'.$date_spectacle_1.'<br />'.$horaire_spectacle_1,
        'spectacle_2' => $choix_spectacle_2.'<br />'.$date_spectacle_2.'<br />'.$horaire_spectacle_2,
        'spectacle_3' => $choix_spectacle_3.'<br />'.$date_spectacle_3.'<br />'.$horaire_spectacle_3,
        'spectacle_4' => $choix_spectacle_4.'<br />'.$date_spectacle_4.'<br />'.$horaire_spectacle_4,
        'spectacle_5' => $choix_spectacle_5.'<br />'.$date_spectacle_5.'<br />'.$horaire_spectacle_5,
        'spectacle_6' => $choix_spectacle_5.'<br />'.$date_spectacle_6.'<br />'.$horaire_spectacle_6,
        'spectacle_7' => $choix_spectacle_7.'<br />'.$date_spectacle_7.'<br />'.$horaire_spectacle_7,
        'commentaire' => $commentaire,
        'voir' => '<a href="voir_abonnement.php?num_abo_com='.$num_abo_com.'" >
                                <img border="0" alt="voir" src="image/voir.png" Title="Voir les details"></a>',
        'modifier' => '<a href="edit_abonnement.php?num_abo_com='.$num_abo_com.'" >
                                <img border="0" alt="modifier" src="image/edit.png" Title="Modifier l\'abonnement"></a>',
        'effacer' => '<a href="delete_abonnement.php?num_abo_com='.$num_abo_com.'" class="confirm" >
                                <img border="0" alt="supprimer" src="image/delete.png" Title="Supprimer l\'abonnement"></a>',
        'print' => '<form action="fpdf/abonnement_pdf.php" method="post" target="_blank" >
                                <input type="hidden" name="num_abo_com" value="'.$num_abo_com.'" />
                                <input type="hidden" name="user" value="adm" />
                                <input type="image" src="image/print.png" style=" border: none; margin: 0;" alt="'.$lang_imprimer.'" Title="Imprimer"/>
                            </form>',
        'dupliquer' => '<a href="dupliquer_abonnement.php?num_abo_com='.$num_abo_com.'" >
                                                                <img border="0" alt="voir" src="image/duplicat.png" Title="Dupliquer le spectateur"></a>',
        'mail' => '<a href="/fpdf/bon_pdf.php?num_abo_com='.$num_abo_com.'">
                                <img border="0" alt="mail" src="image/mail.png" Title="Envoyer un mail au spectateur"></a>',
    );
 $json_array['aaData'][] = $json_data;
}
header('Content-Type: application/json');
echo json_encode($json_array);     
?>