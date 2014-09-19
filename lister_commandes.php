<?php 
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php"); 
include_once("include/headers.php");
include_once("include/fonction.php");?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<?php
include_once("include/head.php");
include_once("include/finhead.php");
?> 

<table  class="page" align="center">

  <tr>
    <td class="page" align="center">
       <h3>Liste des reservations 
         <?php if ($user_admin == 'y'||$user_dev=='y'){?>
        <SCRIPT LANGUAGE="JavaScript">
        if(window.print)
          {
          document.write('<A HREF="javascript:window.print()"><img border=0 src= image/printer.gif ></A>');
          }
        </SCRIPT>
        <?php } ?>
      </h3>
        </td>
        <?php
        if (!empty($message)){
            echo $message;
        }?>
    </tr>
    
    <tr>
        <td  class="page" align="center">
            <?php
            if ($user_com == n) {
            echo"<h1>$lang_commande_droit";
            exit;
            }

//=============================================
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
            if ($user_com =='y') 
            {
              $sql = "SELECT mail, login, num_client, num_bon, fact, ctrl, attente, coment, tot_tva, nom, prenom, bc.id_tarif,
              prix_tarif AS ttc, paiement, article, date_spectacle, horaire
              FROM ".$tblpref."bon_comm AS bc, ".$tblpref."tarif AS t, client AS c, ".$tblpref."article AS a
              WHERE date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
              AND bc.id_tarif = t.id_tarif
              AND bc.client_num = c.num_client
              AND bc.id_article = a.num
              AND attente='0'
              ";
            
                  $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
            }



?>
    <center>
        <table id="datatables" class="display">
            <caption> Les commandes de la saison culturelle <?php echo "$annee_2 - $annee_1"; ?> </caption>
                
      <thead>
               
                <tr>
                    <th><?php echo $lang_numero; ?></th>
                    <th><?php echo $lang_client; ?></th>
                    <th> Prénom du spectateur</th>
                    <th>Spectacle</th>
                    <th><?php echo $lang_total_ttc; ?></th>
                    <th>Regle?</th>
          <?php if ($user_admin == 'y'||$user_dev=='y') 
            { ?>                  
                    <th>Encaisse</th>
                    <th>Controle</th>
          <?php }?>
                    <th>Commentaires</th>
                    <th><small>Voir</small></th>
                    <th><small>Changer</small></th>
                    <th><small>Effacer</small></th>
                    <th><small>Print</small></th>
          <?php if ($user_admin == 'y'||$user_dev=='y') 
            { ?>
                    <th><small>Envoyer</small></th>
            <?php } ?>
          </tr>
                </thead>
                <tbody>
                    <?php
                    $nombre = 1;
                    while($data = mysql_fetch_array($req))
                    {
                      $num_bon = $data['num_bon'];
                      $pointage = $data['fact'];
                      $ctrl = $data['ctrl'];
                      $paiement = $data['paiement'];
                      $tva = $data["tot_tva"];
                      $date_spectacle = strtotime($data["date_spectacle"]);
                      $date = date_fr('l d-m-Y', $date_spectacle);
                      $article = $data["article"];
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
                      $nombre = $nombre +1;
                            if($nombre & 1){
                            $line="0";
                            }else{
                            $line="1";
                            }
                      ?>
                <tr>
                    <td><?php echo "$num_bon"; ?></td>
                    <td><?php echo "$nom"; ?></td>
                    <td><?php echo "$prenom"; ?></td>
                    <td><?php echo $article.'<br />'; echo $date.'<br />'; echo $horaire; ?></td>
                    <td><?php echo montant_financier($ttc); ?></td>
                    <td><?php echo "$paiement"; ?></td>
                    <td><?php echo "$pointage"; ?></td>
                    <td><?php echo "$ctrl"; ?></td>
                    <td><?php echo "$coment"; ?></td>
                    <td><a href='voir_reservation.php?num_bon=<?php echo "$num_bon"; ?>' >
                            <img border="0" alt="voir" src="image/voir.png" Title="Voir la commande"></a></td>
                    <td><a href='form_editer_bon.php?num_bon=<?php echo "$num_bon"; ?>&amp;id_tarif=<?php echo "$id_tarif"; ?>' >
                            <img border="0" alt="editer" src="image/edit.png" Title="Modifier la commande"></a></td>
                    <td><a href='delete_bon_suite.php?num_bon=<?php echo $num_bon; ?>&amp;nom=<?php echo "$nom_html"; ?>'
                            onClick="return confirmDelete('<?php echo"$lang_con_effa $num_bon"; ?>')">
                            <img border="0" src="image/delete.png" alt="delete" Title="Supprimer" ></a></td>
                    <td>
                        <form action="fpdf/bon_pdf.php" method="post" target="_blank" >
                        <input type="hidden" name="num_bon" value="<?php echo $num_bon ?>" />
                        <input type="hidden" name="nom" value="<?php echo $nom ?>" /> 
                        <input type="hidden" name="user" value="adm" />
                        <input type="image" src="image/print.png" style=" border: none; margin: 0;" alt="<?php echo $lang_imprimer; ?>" Title="Imprimer"/>
                        </form>
                    </td>
                      <?php if ($user_admin =='y' || $user_dev =='y') 
                      {
                      if ($mail != '' )
                      {
                      ?>
                    <td>
                        <form action="fpdf/bon_pdf.php" method="post" onClick="return confirmDelete('<?php echo"$lang_con_env_pdf $num_bon"; ?>')">
                                <input type="hidden" name="num_bon" value="<?php echo $num_bon; ?>"/>
                                <input type="hidden" name="nom" value="<?php echo $nom; ?>"/>
                                <input type="hidden" name="user" VALUE="adm"/>
                                <input type="hidden" name="ext" VALUE=".pdf"/>
                                <input type="hidden" name="mail" VALUE="y"/>
                                <input type="image" src="image/mail.png" alt="mail" Title="Envoyer par mail"/>
                        </form> 
                    </td>
                      <?php
                      }
                      
                      else
                      {
                      ?>
                      <td></td>
                      <?php
                      }
                    }// fin du if admin
                    } // fin du while  ?>
                </tr>
                </tbody>
        </table>
    </center>
        </td>
    </tr>
    
  </td>
</tr>

</table>
<?php

include_once("include/bas.php");
 
?>