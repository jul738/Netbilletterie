<?php
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");


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
prix_tarif AS ttc, paiement, article, date_spectacle, horaire, num
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
    $json_data = array(
        'num_bon' => $data['num_bon'],
        'nom' => $data['nom'],
        'prenom' => $data['prenom'],
        'article'=> $data['article'],
        'ttc' => $data['ttc'],
        'paiement' => $data['paiement'],
        'coment' => $data['coment'],
        'voir' => "<a href='voir_reservation.php?num_bon=".$data['num_bon']."'>
                            <img border='0' alt='voir' src='image/voir.png' Title='Voir la commande'></a>",
        'changer' => "<a href='form_editer_bon.php?num_bon=".$data['num_bon']."&amp;id_tarif=".$data['id_tarif']."' >
                            <img border='0' alt='editer' src='image/edit.png' Title='Modifier la commande'></a>",
        'dupliquer' => "<form action='form_commande.php' method='post'>
                            <input type='hidden' name='id-client' value=".$data['num_client']."></input>
                            <input type='hidden' name='commentaire' value=".$data['coment']."></input>
                            <input type='hidden' name='id-paiement' value=".$data['paiement']."></input>
                            <input type='hidden' name='id-article' value=".$data['a.num']."></input>
                            <input type='hidden' name='id-tarif' value=".$data['id_tarif']."></input>                    
                            <input type='submit' value='' class='duplication'</input>
                        </form>",
        'effacer' => "<a href='delete_bon_suite.php?num_bon=".$data['num_bon'].".amp;nom=".$data['nom']."'
                            class='confirm'>
                            <img border='0' src='image/delete.png' alt='delete' Title='Supprimer' ></a>",
        'print' => "<form action='fpdf/bon_pdf.php' method='post' target='_blank' >
                        <input type='hidden' name='num_bon' value=".$data['num_bon']." />
                        <input type='hidden' name='nom' value=".$data['nom']." /> 
                        <input type='hidden' name='user' value='adm' />
                        <input type='image' src='image/print.png' style=' border: none; margin: 0;' alt=".$lang_imprimer." Title='Imprimer'/>
                        </form>"     
    );
$json_array['aaData'][] = $json_data;
}
header('Content-Type: application/json');
echo json_encode($json_array);