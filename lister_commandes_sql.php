<?php

include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/fonction.php");
include_once("include/utils.php"); 

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

$sql = "SELECT mail, login, num_client, num_bon, fact, ctrl, attente, coment, tot_tva, nom, prenom, bc.id_tarif,
              prix_tarif AS ttc, paiement, article, num, date_spectacle, horaire
              FROM ".$tblpref."bon_comm AS bc, ".$tblpref."tarif AS t, client AS c, ".$tblpref."article AS a
              WHERE date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
              AND bc.id_tarif = t.id_tarif
              AND bc.client_num = c.num_client
              AND bc.id_article = a.num
              AND attente='0'
              ";
          
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());

$json_array = array(
//'draw' => 1,
'iTotalRecords' => 0,
'iTotalDisplayRecords' => 0,
'aaData' => array(),
);

while($data = mysql_fetch_array($req)) {
    $num_bon = $data['num_bon'];
    $pointage = $data['fact'];
    $ctrl = $data['ctrl'];
    $paiement = $data['paiement'];
    $tva = $data["tot_tva"];
    $date_spectacle = strtotime($data["date_spectacle"]);
    $date = date_fr('l d-m-Y', $date_spectacle);
    $article = $data["article"];
    $num = $data["num"];
    $horaire = $data["horaire"];
    $id_tarif = $data["id_tarif"];
    $nom = $data['nom'];
    $nom=stripslashes($nom);
    $nom = htmlentities($nom, ENT_QUOTES);
    $nom_html = htmlentities (urlencode ($nom));
    $prenom = stripslashes($data['prenom']);
    $num_client = $data['num_client'];
    $mail = $data['mail'];
    $login = $data['login'];
    $coment = $data['coment'];
    $coment=stripslashes($coment);
    $ttc = $data['ttc'];
    $json_data = array(
        'numero' => $num_bon,
        'nom' => $nom,
        'prenom' => $prenom,
        'spectacle' => $article.'<br />'.$date.'<br />'.$horaire,
        'total' => montant_financier($ttc),
        'regle' => $paiement,
        'encaisse' => $pointage,
        'controle' => $ctrl,
        'commentaire' => $coment,
        'voir' => '<a href="voir_reservation.php?num_bon='.$num_bon.'" >
                            <img border="0" alt="voir" src="image/voir.png" Title="Voir la commande" /></a>',
        'changer' => '<a href="form_editer_bon.php?num_bon='.$num_bon.'&amp;id_tarif='.$id_tarif.'" >
                            <img border="0" alt="editer" src="image/edit.png" Title="Modifier la commande" /></a>',
        'dupliquer' =>  '<form action="form_commande.php" method="post">
                            <input type="hidden" name="id-client" value='.$num_client.'></input>
                            <input type="hidden" name="commentaire" value='.$coment.'></input>
                            <input type="hidden" name="id-paiement" value='.$paiement.'></input>
                            <input type="hidden" name="id-article" value='.$num.'></input>
                            <input type="hidden" name="id-tarif" value='.$id_tarif.'></input>                    
                            <input type="submit" value="" class="duplication"</input>
                        </form>',
        'effacer' => '<a href="delete_bon_suite.php?num_bon='.$num_bon.'&amp;nom='.$nom_html.'"
                            onClick="return confirmDelete("'.$lang_con_effa.' '.$num_bon.'")">
                            <img border="0" src="image/delete.png" alt="delete" Title="Supprimer" ></a>',
        'imprimer' => '<form action="fpdf/bon_pdf.php" method="post" target="_blank" >
                        <input type="hidden" name="num_bon" value='.$num_bon.'></input>
                        <input type="hidden" name="nom" value='.$nom.'></input> 
                        <input type="hidden" name="user" value="adm"></input>
                        <input type="image" src="image/print.png" style=" border: none; margin: 0;" alt='.$lang_imprimer.' Title="Imprimer"></input>
                        </form>',
        'envoyer' => '<form action="fpdf/bon_pdf.php" method="post" onClick="return confirmDelete("'.$lang_con_env_pdf.' '.$num_bon.'")">
                                <input type="hidden" name="num_bon" value='.$num_bon.'></input>
                                <input type="hidden" name="nom" value='.$nom.'></input>
                                <input type="hidden" name="user" VALUE="adm"></input>
                                <input type="hidden" name="ext" VALUE=".pdf"></input>
                                <input type="hidden" name="mail" VALUE="y"></input>
                                <input type="image" src="image/mail.png" alt="mail" Title="Envoyer par mail"></input>
                        </form>',
    );
    $json_array['aaData'][] = $json_data;
}
header('Content-Type: application/json');
echo json_encode($json_array);
?>