<?php
// Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
// Lister abonnement.php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
include_once("include/configav.php");
?>

<?php
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

//Affiche les abonnement vendu 
$req_liste_abo_vendu = "SELECT ac.num_abo_com, c.nom, ac.date, a.nom_abonnement, ac.quanti, ac.choix_spectacle_1, ac.choix_spectacle_2, ac.choix_spectacle_3, ac.choix_spectacle_4, ac.choix_spectacle_5, ac.choix_spectacle_6, ac.choix_spectacle_7
                        FROM abonnement_comm ac, abonnement a, client c
                        WHERE ac.num_abonnement = a.num_abonnement
                        AND c.num_client = ac.client_num
                        ORDER BY ac.num_abo_com ASC";
$liste_abo_vendu = mysql_query($req_liste_abo_vendu) or die('Erreur Req_liste_abo !<br>'.$req_liste_abo_vendu.'<br>'.mysql_error());
?>

<table border="0" class="page" align="center">
<?php echo $horaire_spectacle_1_vendu ;?>
    <tr>
        <td class="page" align="center">
            <h3>Liste des Abonnements </h3>
    </tr>
        <td>


<table id="datatables" class="display">
    
<caption> Les Abonnements de la saison :  <?php echo "$annee_2 - $annee_1"; ?> </caption>
    <thead>
            <tr>
                <th><small>Num Abo            </small></th>
                <th><small>Spectateur         </small></th>
                <th><small>Date de creation   </small></th>
                <th><small>Abo                </small></th>
                <th><small>Qte                </small></th>
                <th><small>Spectacle 1        </small></th>
                <th><small>Spectacle 2        </small></th>
                <th><small>Spectacle 3        </small></th>
                <th><small>Spectacle 4        </small></th>
                <th><small>Spectacle 5        </small></th>
                <th><small>Spectacle 6        </small></th>
                <th><small>Spectacle 7        </small></th>
                <th><small>Voir               </small></th>
                <th><small>Modifier           </small></th>
                <th><small>Supprimer          </small></th>
                <th><small>Imprimer           </small></th>
                <th><small>Mail               </small></th>
            </tr>
    </thead>
    <tbody>
            <tr>
                <?php
                $nombre="1";
		while($data = mysql_fetch_array($liste_abo_vendu))
                {

                        $num_abo_com = $data['num_abo_com'];
                        $nom = $data['nom'];
                        $date = $data['date'];
                        $nom_abonnement = $data['nom_abonnement'];
                        $quanti = $data['quanti'];
                        $choix_spectacle_1 = $data['choix_spectacle_1'];
                        $choix_spectacle_2 = $data['choix_spectacle_2'];
                        $choix_spectacle_3 = $data['choix_spectacle_3'];
                        $choix_spectacle_4 = $data['choix_spectacle_4'];
                        $choix_spectacle_5 = $data['choix_spectacle_5'];
                        $choix_spectacle_6 = $data['choix_spectacle_6'];
                        $choix_spectacle_7 = $data['choix_spectacle_7'];
                    if($nombre & 1)
                        {
                        $line="0";
                        }else  
                            {
                            $line="1";
                            } 
                ?>

                        <td> <?php echo $num_abo_com       ; ?> </td>
                        <td> <?php echo $nom               ; ?> </td>
                        <td> <?php echo $date              ; ?> </td>
                        <td> <?php echo $nom_abonnement    ; ?> </td>
                        <td> <?php echo $quanti            ; ?> </td>
                        <td> <?php echo $choix_spectacle_1 ; ?> </td>
                        <td> <?php echo $choix_spectacle_2 ; ?> </td>
                        <td> <?php echo $choix_spectacle_3 ; ?> </td>
                        <td> <?php echo $choix_spectacle_4 ; ?> </td>
                        <td> <?php echo $choix_spectacle_5 ; ?> </td>
                        <td> <?php echo $choix_spectacle_6 ; ?> </td>
                        <td> <?php echo $choix_spectacle_7 ; ?> </td>
                        <td><a href='voir_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>' >
                                <img border="0" alt="voir" src="image/voir.png" Title="Voir les details"></a></td>
                        <td><a href='edit_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>' >
                                <img border="0" alt="voir" src="image/edit.png" Title="Modifier l'abonnement"></a></td>
                        <td><a href='delete_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>' >
                                <img border="0" alt="supprimer" src="image/delete.png" Title="Supprimer l'abonnement"></a></td>
                        <td><a href='fpdf/abonnement_pdf.php?num_abo_com=<?php echo "$num_abo_com"; ?>' >
                                <img border="0" alt="mail" src="image/print.png" Title="Imprimer l'abonnement"></a></td>
                                <td><a href='/fpdf/bon_pdf.php?num_abo_com=<?php echo "$num_abo_com"; ?>'>
                                <img border="0" alt="mail" src="image/mail.png" Title="Envoyer un mail au spectateur"></a></td>
                </tr>
          <?php } //Fin du while ?> 
                </table>
    </tbody>
</table>


<?php
include_once("include/bas.php");
?>
