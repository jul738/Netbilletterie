<?php
/* Net Billetterie Copyright(C)2012 Jose Das Neves
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jose Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/head.php");
include_once("include/headers.php");
include_once("include/finhead.php");
include_once("include/configav.php");

///=============================================
//pour que les articles soit classes par saison
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
?>

<table border="0" class="page" align="center">
  <tr>
    <td  class="page" align="center">
    <?php

    //on recupere les infos client et le numero d'abonnement choisi
    $client=isset($_POST['listeville'])?$_POST['listeville']:"";
    $date=isset($_POST['date'])?$_POST['date']:"";
    // on récupère le numero d'abonnement choisie sur la page precedente new_abonnement.php
    $num_abonnement=isset($_POST['num_abonnement'])?$_POST['num_abonnement']:"";
    
    
    if ($client=="") 
    {
    $client=isset($_GET['listeville'])?$_GET['listeville']:"";
    $date=isset($_GET['date'])?$_GET['date']:"";
    $num_abonnement=isset($_GET['num_abonnement'])?$_GET['num_abonnement']:"";
    }

    list($jour, $mois,$annee) = preg_split('/\//', $date, 3);

    include_once("include/language/$lang.php");
    if($client=='0')
    {
    $message="<h1> $lang_choix_client</h1>";
    exit;
    }

    //on recupere les info du client pour la 1er ligne de la page
    $sql_nom = "SELECT  nom, nom2 
                FROM ". $tblpref ."client 
                WHERE num_client = '$client'";
    $req = mysql_query($sql_nom) or die('Erreur SQL_nom !<br>'.$sql.'<br>'.mysql_error());
    while($data = mysql_fetch_array($req))
    {
    $nom = $data['nom'];
    $nom2 = $data['nom2'];
    $phrase = "$lang_abo_cree";
    ?>
        
        <?php
            //On recupere le type_abonnement pour faire un tri sur la liste des choix propose
        $req_recup_type = "SELECT type_abonnement, tarif_abonnement
                           FROM abonnement
                           WHERE num_abonnement = '$num_abonnement'";
        $recup_type_brut = mysql_query($req_recup_type) or die( "Execution requete -req_recup_type- impossible.");
        while($data = mysql_fetch_array($recup_type_brut))
                    {
                    $type_abonnement = $data['type_abonnement'];
                    $tarif_abonnement = $data['tarif_abonnement'];
                    }
        
        // On récupère le nombre de place diponible dans cette abonnement grace à l'ID de l'abonnement
        $rqnbspectacle = "SELECT nombre_spectacle
                          FROM abonnement
                          WHERE num_abonnement = '$num_abonnement'";
        $Rep_rqnbspectacle = mysql_query($rqnbspectacle) or die( "Execution requete -rqnbspectacle- impossible.");
        while($data = mysql_fetch_array($Rep_rqnbspectacle))
        {
            $nombre_spectacle = $data['nombre_spectacle'];
        }
        ?>                        
                        <br/><h3><?php echo "$phrase: $nom - $nom2 $lang_bon_cree2 $date <br>";?></h3><br/>
    
    <?php
    }
    $date_debut = date('Y-m-d');
    $date_fin = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " + 365 day"));
    // on creer une vente d'abonnement	
    $sql1 = "INSERT INTO ". $tblpref ."abonnement_comm(client_num, date, date_debut, date_fin, num_abonnement, user, nombre_place) VALUES ('$client', '$annee-$mois-$jour', '$date_debut', '$date_fin', '$num_abonnement', '$user_nom', '$nombre_spectacle')";
    mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
   

    
    // on met à jour le bdd
    // requete sql update
    // modifier : orignial pour le 'bon_suite_soir.php'
    // $sql12 = "UPDATE `" . $tblpref ."article` SET `stock` = (stock - ".$quanti.") WHERE `num` = '".$num."'";
    
    // on récupère l' ID de la vente d'abonnment que l'on vien de faire (création vente abo requete précedente)
    $sql_num = "SELECT num_abo_com
                FROM abonnement_comm
                WHERE client_num = '$client'
                ORDER BY num_abo_com DESC
                LIMIT 1";

        $req_num_abo = mysql_query($sql_num) or die ( "Execution requete -sql_num- impossible.");
           
    while($data = mysql_fetch_assoc($req_num_abo))
        {
    $num_abo_com = $data['num_abo_com'];
    ?>
     Abonnement numero : <?php echo"$num_abo_com  saisi par \"$user_nom\"";?><br/>
     Veuillez renseigner les <?php echo "$nombre_spectacle" ?> spectacles : <br/><br/>
    <?PHP
        }
    ?>
      <center>
          <form name='formu2' method='post' action='new_fin_abonnement.php'>
            <table class="boiteaction" style="border-spacing : 20px";>
                <caption>Composer l'abonnement</caption>
          
            </td>    
        </tr>
        <tr>
            <td class="texte0">Choisir la quantite d'abonnement 
            </td>
            <td class="texte_left" colspan="3">
                <input type="text" name="quanti" value="1" SIZE="1">
            </td>

        </tr>
        <tr>
            <td class="texte0">Choisir les spectacles 
            </td>
            <td class="texte_left">
         
                <?php
          // Pour avoir le nombre de spectacles
           $rqSql = "SELECT ac.num_abo_com , ab.nombre_spectacle
                     FROM abonnement AS ab, abonnement_comm AS ac
                     WHERE ac.num_abo_com = '$num_abo_com'
                     AND ab.num_abonnement = ac.num_abonnement ";
           $result = mysql_query( $rqSql )or die( "Execution requete -rqSql- impossible.");
           
            $i=1;
            while ( $row = mysql_fetch_array( $result)) 
            {
               // $num_abonnement_test = $row["num_abonnement"];
                $nombre_spectacle= $row["nombre_spectacle"];
                
                //On affiche un champs  select pour chaque spectacle
                
              
                    for($nb = 1; $nb <= $nombre_spectacle; $nb++)
                            {
                                
                            ?>
                                <SELECT name='liste_choix_spectacle_<?php echo $nb;?>'>
                                <OPTION VALUE="">Choisir un spectacle</OPTION>
                                
                                <?php
                                 // lister les numero et les nom des spectacle active (pas ceux complet)
                                $sql_liste_article = "SELECT num, article, type_article, horaire, date_spectacle
                                                      FROM article 
                                                      WHERE actif != 'non'
                                                      AND stock > '0'
                                                      AND type_article = '$type_abonnement'";
                                $liste_article = mysql_query( $sql_liste_article )or die( "Execution requete -liste_article- impossible.");

                                while ( $liste_spectacle = mysql_fetch_array( $liste_article))  
                                {
                                    $liste_spectacle_contenu_nom = $liste_spectacle["article"];
                                    $liste_spectacle_contenu_num = $liste_spectacle["num"];
                                    $liste_spectacle_contenu_type_article = $liste_spectacle["type_article"];
                                    $liste_spectacle_contenu_horaire = $liste_spectacle["horaire"];
                                    $liste_spectacle_contenu_date_spectacle = $liste_spectacle["date_spectacle"];
                                    ?>
                                    <OPTION VALUE='<?php echo $liste_spectacle_contenu_num; ?>'><?php echo $liste_spectacle_contenu_type_article; ?> : <?php echo $liste_spectacle_contenu_nom; ?> <?php echo $liste_spectacle_contenu_date_spectacle; ?> [<?php echo $liste_spectacle_contenu_horaire; ?>]</OPTION>
                                    <?php
                                }
                                ?>
                                </SELECT>
                            <?php  
                            } // fin de la boucle for

            }
                ?>

              
                </td>
           </tr>

           <tr> 
                <td class="texte0">
                  Moyen de paiement
                </td>
                <td class="texte_left" colspan="3">
                            <SELECT name='paiement'>
                                <OPTION VALUE="">Choisir un moyen de paiement</OPTION>
                                
                                <?php
                                 // lister les numero et les nom des spectacle active (pas ceux complet)
                                $req_recup_paiement = "SELECT id_type_paiement, nom
                                                       FROM type_paiement ";
                                $recup_paiement_brut = mysql_query( $req_recup_paiement )or die( "Execution requete -req_recup_paiement- impossible.");

                                while ( $recup_paiement = mysql_fetch_array( $recup_paiement_brut))  
                                {
                                    $paiement_nom = $recup_paiement["nom"];
                                    $paiement_id = $recup_paiement["id_type_paiement"];
                                    ?>
                                    <OPTION VALUE='<?php echo $paiement_id; ?>'><?php echo $paiement_nom; ?></OPTION>
                                    <?php
                                }
                                ?>
                            </SELECT>
                </td>
            </tr>
            <tr>
                <td class="submit" colspan="4">
                  <input  name="num_client" id="num_client" type="hidden" value='<?php echo $client; ?>'>
                  <input  name="nom" id="nom" type="hidden" value='<?php echo $nom; ?>'>
                  <input  name="num_abonnement" id="num_abonnement" type="hidden" value='<?php echo $num_abonnement; ?>'>
                  <input  name="num_abo_com" id="num_abo_com" type="hidden" value='<?php echo $num_abo_com; ?>'>
                  <input  name="nombre_spectacle" id="nombre_spectacle" type="hidden" value='<?php echo $nombre_spectacle; ?>'>
                  <input  name="tarif_abonnement" id="tarif_abonnement" type="hidden" value='<?php echo $tarif_abonnement; ?>'>
                  <input type="image" name="Submit" src='image/valider.png'>
                </td>
            </tr>
            </table>
          </form>                
      </center>
    </td>
  </tr>
</table>
<?php
include_once("include/bas.php");
?>

