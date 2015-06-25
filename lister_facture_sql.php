<?php
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/fonction.php");

// On récupère la liste des réservations de groupes

$select_facture = "SELECT f.id, type_facture, nom_structure, article, date_spectacle, horaire, f.commentaire, total, numero_facture, date_paiement, p.nom FROM " . $tblpref ."bon_comm_groupe AS bcg, " . $tblpref ."groupe AS g, " . $tblpref ."article AS a, " . $tblpref ."facture AS f, " . $tblpref ."type_paiement AS p WHERE f.id_resa = bcg.num_bon_groupe AND bcg.id_article=a.num AND bcg.num_groupe = g.num_groupe AND f.id_paiement = p.id_type_paiement";
$req_facture = mysql_query($select_facture) or die('Erreur sql groupes'.$select_facture.'<br>'.mysql_error());

$json_array = array(
//'draw' => 1,
'iTotalRecords' => 0,
'iTotalDisplayRecords' => 0,
'aaData' => array(),
);

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
    $json_data = array(
        'num_facture' => $numero_facture,
        'nom_structure' => $nom_structure,
        'nom_spectacle' => $article,
        'date' => $date_article,
        'horaire' => $horaire,
        'type' => $type_facture,
        'montant' => $total,
        'payee' => $paye,
        'date_paiement' => $date_paiement,
        'commentaire' => $commentaire,
        'voir' => '<a href="facture.php?num_facture='.$num_facture.'"><img border="0" title="Voir la réservation du groupe" src="image/voir.gif" alt="voir"></a>',
        'modifier' => '<a href="form_facture.php?num_facture='.$num_facture.'"><img border="0" alt="Modifier"  title="Modifier la réservation du groupe"src="image/edit.png"></a>',
    );
    $json_array['aaData'][] = $json_data;
}
header('Content-Type: application/json');
echo json_encode($json_array);  
?>