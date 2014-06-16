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
                WHERE num_client = $client";
    $req = mysql_query($sql_nom) or die('Erreur SQL_nom !<br>'.$sql.'<br>'.mysql_error());
    while($data = mysql_fetch_array($req))
    {
    $nom = $data['nom'];
    $nom2 = $data['nom2'];
    $phrase = "$lang_abo_cree";
    ?>
        
        <?php
        $rqnbspectacle = "SELECT nombre_spectacle
                          FROM abonnement
                          WHERE num_abonnement = '$num_abonnement'";
        $Rep_rqnbspectacle = mysql_query($rqnbspectacle) or die( "Execution requete -rqnbspectacle- impossible.");
        while($data = mysql_fetch_array($Rep_rqnbspectacle))
        {
            $nombre_spectacle = $data['nombre_spectacle'];
        }
        ?>
            
                        Test valeur :  <br/>
                        $client (id du client) = <?php  echo "$client"; ?> <br/>
                        $nom = <?php  echo "$nom";?> <br/>
                        $num_abonnement (id de l'abonnement) = <?php  echo "$num_abonnement"?>; <br/>
                        $num_abo_com (id de la vente de l'abonnement) = <?php echo "$num_abo_com"?>; <br/> 
                        $nombre_spectacle = <?php echo"$nombre_spectacle"?>;
           
    <h1><?php echo "$phrase: $nom - $nom2 $lang_bon_cree2 $date <br>";?></h1><br/>
    Veuillez renseigner les <?php echo "$nombre_spectacle" ?> spectacles :
    <?PHP
    }

    // on creer une vente d'abonnement	
    $sql1 = "INSERT INTO " . $tblpref ."abonnement_comm(client_num, date, num_abonnement, user) VALUES ('$client', '$annee-$mois-$jour', '$num_abonnement', '$user_nom')";
    mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
   
    // on affiche les infos de l'abonnement
    $sql_num = "SELECT num_abo_com
                FROM abonnement_comm
                WHERE client_num = $client order by num_abo_com desc limit 1 ";
    $req = mysql_query($sql_num) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($data = mysql_fetch_array($req));
    {
    $num_abo_com = $data['nom_abo_com'];
    ?>
    <h3><?php echo "$lang_commande_numero $num_abo_com saisi par \"$user_nom\"";?></h3><br>
    <?PHP
    }
    ?>
      <center>
          <form name='formu2' method='post' action='new_fin_abonnement.php'>
          <table class="boiteaction">
          <caption>Composer l abonnement</caption>
          <?php

          // pour ne montrer que les abonnement selectionnable
          $rqSql11 = "SELECT num_abonnement, nombre_spectacle, tarif_abonnement
                      FROM ". $tblpref ."abonnement
                      WHERE selection = '1'";
          $result11 = mysql_query( $rqSql11 ) or die( "Execution requete -rqSql11- impossible.");
          ?> </td> </tr>
       
          <tr>
          <td class="texte0">Choisir la quantite d'abonnement </td>
          <td class="texte_left" colspan="3">
          <input type="text" name="quanti" value="1" SIZE="1"></td>

          </tr>
          <tr>
          <td class="texte0">Choisir les spectacles </td>
          
          <td class="texte_left">
              <?php
          // Pour n 'affiches que les spectable selectionnable
           $rqSql = "SELECT ac.num_abo_com , ab.nombre_spectacle
                     FROM abonnement AS ab, abonnement_comm AS ac
                     WHERE ac.client_num = '$numclient'
                     AND ab.num_abonnement = ac.num_abonnement ";
           $result = mysql_query( $rqSql )or die( "Execution requete -rqSql- impossible.");
           
           
            $i=1;
            while ( $row = mysql_fetch_array( $result)) 
            {
                
                $num_abonnement = $row["num_abonnement"];
                $nombre_spectacle= $row["nombre_spectacle"];

                ?>

                    <?php
             // lister les numero et les nom des spectacle active (meme ceux complet)
             $sql_liste_article = "SELECT num, article
                                   FROM article 
                                   WHERE actif != 'non'";
             $liste_article = mysql_query( $sql_liste_article )or die( "Execution requete -liste_article- impossible.");
                                  
                        while ( $liste_spectacle = mysql_fetch_array( $liste_article))  
                        {
                            $liste_spectacle_contenu_nom = $liste_spectacle["article"];
                            $liste_spectacle_contenu_num = $liste_spectacle["num"];
                    ?>
                          <?php 
                            $i++; 
                            //Permet d'affiher autant de spectacle que compris dans l'abonnement selectionne
                            for($nb = 1; $nb <= $nombre_spectacle; $nb++)
                            {
                                // autoriser autant de champs 'choisir un spectacle' que l'abonnement le permet
                                //for ($nb_limite = $nombre_spectacle; $nb_limite != $nb ;  )
                                //    {
                                    // condition
                                 //   }
                            ?>
                            <select name='liste_choix_spectacle'>
                                <OPTION VALUE="">Choisir un spectacle</OPTION>
                                <OPTION VALUE='<?php echo $liste_spectacle_contenu_num; ?>'><?php echo $liste_spectacle_contenu_nom; ?></OPTION>
                            </select>
                            <?php  
                            }
                        }
            }
            ?>
              <br>
              <?php echo "$liste_spectacle_contenu_nom"; ?> - ceci est un echo de liste_spectacle_contenu_nom
            <td class="texte0">Choisir la <?php echo "$lang_liste_abo";?>
              <?php
                $rqSql3 = "SELECT num_abonnement, nom_abonnement, tarif_abonnement
                          FROM ". $tblpref ."abonnement
                           WHERE tarif_abonnement = '$tarif_abonnement'";
                $result3 = mysql_query( $rqSql3 ) or die( "Execution requete -rqSql3- impossible.");
                while ( $row = mysql_fetch_array( $result3)) 
                {
                  $num_abonnement = $row["num_abonnement"];
                  $nom_abonnement = $row["nom_abonnement"];
                  $tarif_abonnement = $row["tarif_abonnement"];
              ?>
                
                
            </td>
            <td class="texte_left">
              <SELECT NAME='num_abonnement'>
              <OPTION VALUE='<?php echo "$num_abonnement"; ?>><?php echo "$nom_abonnement $tarif_abonnement $devise "; ?></OPTION>
                <?php 
                }
                ?>
              <?php
              //on recupere les abonnement pour la selection du form
                $rqSql4= "SELECT num_abonnement, nom_abonnement, tarif_abonnement
                          FROM ".$tblpref."abonnement
                          WHERE selection='1'         
                          ORDER BY nom_abonnement ASC";
                $result4 = mysql_query( $rqSql4 )
                or die( "Execution requete -rqSql4- impossible.");
                while ( $row = mysql_fetch_array( $result4)) 
                {
                  $num_abonnement = $row["num_abonnement"];
                  $nom_abonnement = $row["nom_abonnement"];
                  $tarif_abonnement = $row["tarif_abonnement"];
                ?>
              <OPTION VALUE='<?php echo "$num_abonnement"; ?>'><?php echo "$nom_abonnement $tarif_abonnement $devise "; ?></OPTION>
                <?php 
                }
                ?>
              <br>
              <br>
                     
         <?php include_once("include/paiemment.php"); ?><br/><br/>
              <input type="image" name="Submit" src='image/valider.png' value="<?php echo "$lang_ter_enr"; ?>" >
              <br/><br/>
              <td style="text-align: center;">
					<h3>Imprimer les abonnements
                                            <a href="print_ticket_abo.php?num_abo_com=<?php echo"$num_abo_com";?>" onclick="edition();return false;"><img border=0 src= image/billetterie_v2.png ></a></h3> 
					</td>
              <input type="submit" name="Submit" value="Ajouter un abonnement"><br>
              
              </SELECT>
            </td>
          </tr>
          <tr>
            <td class="submit" colspan="4">
              <input  name="nom" id="nom" value='<?php echo $nom ?>'>
              <input  name="num_abo_com"  value='<?php echo $num_abo_com ?>'>
              <input  name="num_client" value='<?php echo $client ?>'>
              <input style="color:#961a1a;background:yellow" type="submit" name="Submit" value='Enregistrer l abonnement'>
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

