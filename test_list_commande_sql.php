<?php
include_once("include/config/common.php");
include_once("include/config/var.php");

//=============================================
//pour que les articles soit classes par saison
$mois=date("n");
$fin_saison = "09-01";
$debut_saison = "09-01";
$user_com = "y";
if ($mois=="10"||$mois=="11"||$mois=="12") {
$mois=date("n");
}
else{
$mois =date("0n");
}
$jour =date("d");
$date_ref="$mois-$jour";
$annee = date("Y");
//pour le formulaire
$annee_1=isset($_POST['annee_1'])?$_POST['annee_1']:"";
if ($annee_1=='')
{
$annee_1= $annee ;
if ($mois.'-'.$jour <= $fin_saison)
{
$annee_1=$annee_1;
}
if ($mois.'-'.$jour >= $fin_saison)
{
$annee_1=$annee_1+1;
}
}
$annee_2= $annee_1 -1;
//=============================================
$json_array = array(
//'draw' => 1,
'iTotalRecords' => 0,
'iTotalDisplayRecords' => 0,
'aaData' => array(),
);

$sql_request_nolimit ="
SELECT COUNT(*)
FROM ".$tblpref."bon_comm AS bc, ".$tblpref."tarif AS t, client AS c, ".$tblpref."article AS a
WHERE date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
AND bc.id_tarif = t.id_tarif
AND bc.client_num = c.num_client
AND bc.id_article = a.num
AND attente='0'
;";
$count = mysql_query($sql_request_nolimit) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
if (!$count) { echo("No result!".PHP_EOL);}
else { $json_array['iTotalRecords'] = intval(mysql_result($count, 0)); }
$sql = "
SELECT mail, num_client, num_bon, tot_tva, nom, prenom, bc.id_tarif,
prix_tarif AS ttc, paiement, article, date_spectacle, horaire
FROM ".$tblpref."bon_comm AS bc, ".$tblpref."tarif AS t, client AS c, ".$tblpref."article AS a
WHERE date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
AND bc.id_tarif = t.id_tarif
AND bc.client_num = c.num_client
AND bc.id_article = a.num
AND attente='0'
LIMIT 100
OFFSET 0
;";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$json_array['iTotalDisplayRecords'] = intval(mysql_numrows($req));
while ($data = mysql_fetch_assoc($req)) {
    //$data['DT_RowId'] = 'row_'.$data['num_bon'];
    //$data['DT_RowData'] = array("pkey" => intval($data['num_bon']));
$json_array['aaData'][] = $data;
}
header('Content-Type: application/json');
echo json_encode($json_array);