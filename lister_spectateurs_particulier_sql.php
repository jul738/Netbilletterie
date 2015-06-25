<?php
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/liste_utiles.php");

$article_numero = $_GET['article_numero'];

$json_array = array(
//'draw' => 1,
'iTotalRecords' => 0,
'iTotalDisplayRecords' => 0,
'aaData' => array(),
);

$sql_request_nolimit ="SELECT COUNT(*)
        FROM client C, bon_comm BC , tarif T
        WHERE BC.client_num=C.num_client
        AND BC.id_article = $article_numero
        AND BC.attente=0
        AND BC.id_tarif = T.id_tarif
        AND BC.paiement = 'non' ORDER BY nom, BC.id_tarif ASC ";
$count = mysql_query($sql_request_nolimit) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
if (!$count) { echo("No result!".PHP_EOL);}
else { $json_array['iTotalRecords'] = intval(mysql_result($count, 0)); }

//Lister reservation non payées
$sql = "SELECT *
        FROM client C, bon_comm BC , tarif T
        WHERE BC.client_num=C.num_client
        AND BC.id_article = $article_numero
        AND BC.attente=0
        AND BC.id_tarif = T.id_tarif
        AND BC.paiement = 'non' ORDER BY nom, BC.id_tarif ASC ";

$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

$rqSql3= 'SELECT id_tarif, nom_tarif, prix_tarif, saison FROM '.$tblpref.'tarif
    WHERE nom_tarif<>"gratuit"
    AND selection="1"
    ORDER BY nom_tarif ASC';
$result3 = mysql_query( $rqSql3 )or die( mysql_error()."Execution requete impossible.");
$tarif_select = "<SELECT NAME='id_tarif'>
<OPTION VALUE=''>Choisir le ".$lang_tarif."</OPTION>";
while ( $row = mysql_fetch_array( $result3)) {
    $id_tarif2 = $row["id_tarif"];
    $nom_tarif2 = $row["nom_tarif"];
    $prix_tarif2 = $row["prix_tarif"];
    $tarif_select .= "<OPTION VALUE=".$id_tarif2;
    if($id_tarif==$id_tarif2)
        {$tarif_select .=  'selected';}
    $tarif_select .= ">".$nom_tarif2." ".$prix_tarif2." ".$devise."</OPTION>";
}
//tarif gratuit pour admin 
    $sqltarifgratuit = 'SELECT nom_tarif, prix_tarif, id_tarif FROM '.$tblpref.'tarif
			WHERE nom_tarif="gratuit"';
$reqtarifgratuit = mysql_query($sqltarifgratuit) or die('Erreur SQL tarif gratuit !<br>'.$sqltarifgratuit.'<br>'.mysql_error());
while($data2 = mysql_fetch_array($reqtarifgratuit))
    {
	$nom_tarif = $data2['nom_tarif'];
	$prix_tarif = $data2['prix_tarif'];
	$id_tarif =$data2['id_tarif'];			
        $tarif_select .= "<OPTION VALUE='".$id_tarif."'>".$nom_tarif." ".$prix_tarif." ".$devise."</OPTION>";
    }
$tarif_select .= "</SELECT>";
$paiement = liste_paiement();
while($data = mysql_fetch_array($req))
    {
        $article_num = $data['id_article'];
	$bon_num = $data['num_bon'];
	$num_client = $data['client_num'];
        $prix_tarif = $data['prix_tarif'];
        $id_tarif = $data['id_tarif'];
        $json_data = array(
		'nom' => $data['nom'],
                'prenom' => $data['prenom'],
		'telephone' => $data['tel'],
		'coment' => $data['coment'],
                'modifier' =>"<a href='form_editer_bon.php?num_bon=".$bon_num."&id_tarif=".$id_tarif."'><img src='image/edit.png' title='Modifier le spectateur' alt='Bouton pour modifier le spectateur' /></a>",
                'dupliquer'=> "<form action='form_commande.php' method='post'>
                            <input type='hidden' name='id-client' value='".$num_client."'></input>
                            <input type='hidden' name='commentaire' value='".$data['coment']."'></input>
                            <input type='hidden' name='id-article' value='".$article_num."'></input>
                            <input type='hidden' name='id-tarif' value='".$id_tarif."'></input>                    
                            <input type='submit' value='' class='duplication'</input>
                        </form>",
                'tarif' => "<form action='lister_spectateurs.php?article=".$article_numero."' method='POST' id='resa-billet' name='resa-billet'>
                                ".$tarif_select."
                            </form>",                 
            'paiement' => ''.$paiement.'',
            'valider' => "<input type='hidden' name='num_bon' value='".$bon_num."'>
                        <input type='submit' name='Submit' value='Enregistrer le billet'><form>",
            'supprimer' => "<a href='delete_bon_suite.php?num_bon=".$bon_num."&amp;nom=".$data['nom']." class='confirm'>
                            <img border='0' src='image/delete.png' alt='delete' Title='Supprimer' ></a>"
             );
$json_array['aaData'][] = $json_data;
    }
header('Content-Type: application/json');
echo json_encode($json_array);