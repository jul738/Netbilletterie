<?php

include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");

//=============================================
//pour que les articles soit class�s par saison
$mois=date("n");
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

$sql_request_nolimit ="SELECT COUNT(*)
            FROM ".$tblpref."bon_comm
            RIGHT JOIN " . $tblpref ."client on " . $tblpref ."bon_comm.client_num = num_client
            WHERE date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
            AND soir<>'0.00'
            AND soir<>''
            AND attente='0'";
$count = mysql_query($sql_request_nolimit) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
if (!$count) { echo("No result!".PHP_EOL);}
else { $json_array['iTotalRecords'] = intval(mysql_result($count, 0)); }

$sql = "SELECT mail, login, num_client, num_bon, fact, ctrl, attente, coment, tot_tva, nom, soir, id_tarif,
            DATE_FORMAT(date,'%d-%m-%Y') AS date, tot_tva as ttc, paiement
            FROM ".$tblpref."bon_comm
            RIGHT JOIN " . $tblpref ."client on " . $tblpref ."bon_comm.client_num = num_client
            WHERE date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
            AND soir<>'0.00'
            AND soir<>''
            AND attente='0'";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$json_array['iTotalDisplayRecords'] = intval(mysql_numrows($req));

while ($data = mysql_fetch_assoc($req)) {
    $soir = $data['soir'];
            if ($soir=="0" || $soir == ""){$soir="";}
        else {$soir = "pour ".$soir."";};
    $json_data = array(
        'num_bon' => $data['num_bon'],
        'encaisse' => $data['fact'],
        'controle' => $data['ctrl'],
        'regle' => $data['paiement'],
        'total' => $data['tot_tva'],
        'date' => $data['date'],
        'nom' => $data['nom'],
        'coment' => $data['coment'],
        'voir' => "<a href='form_editer_bon.php?num_bon=".$data['num_bon']."&amp;id_tarif=".$data['id_tarif']."&amp;voir=ok' >
                            <img border='0' alt='voir' src='image/voir.gif' Title='Voir la commande'></a>",
        'changer' => "<a href='form_editer_bon.php?num_bon=".$data['num_bon']."&amp;id_tarif=".$data['id_tarif']."' >
                            <img border='0' alt='editer' src='image/edit.gif' Title='Modifier la commande'></a>",
        'effacer' => "<a href='delete_bon_suite.php?num_bon=".$data['num_bon']."&amp;nom=".$data['nom']."' class='confirm'>
                            <img border='0' src='image/delete.png' alt='delete' Title='Supprimer' ></a>",
        'print' => "<form action='fpdf/bon_pdf.php' method='post' target='_blank' >
                        <input type='hidden' name='num_bon' value=".$data['num_bon']." />
                        <input type='hidden' name='nom' value=".$data['nom']." /> 
                        <input type='image' src='image/printer.gif' style=' border: none; margin: 0;' alt='".$lang_imprimer."' Title='Imprimer'/>
                        </form>",
       'envoyer' => "<form action='fpdf/bon_pdf.php' method='post'>
                                <input type='hidden' name='num_bon' value=".$data['num_bon']."/>
                                <input type='hidden' name='nom' value=".$data['nom']."/>
                                <input type='hidden' name='user' VALUE='adm'/>
                                <input type='hidden' name='ext' VALUE='.pdf'/>
                                <input type='hidden' name='mail' VALUE='y'/>
                                <input type='image' src='image/mail.gif' alt='mail' Title='Envoyer par mail'/>
                        </form>"
    );
$json_array['aaData'][] = $json_data;
}
header('Content-Type: application/json');
echo json_encode($json_array);