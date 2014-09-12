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
$req_liste_abo_vendu = "SELECT ac.num_abo_com, c.nom, c.prenom, ac.date, a.nom_abonnement, ac.num_resa_1, ac.num_resa_2, ac.num_resa_3, ac.num_resa_4, ac.num_resa_5, ac.num_resa_6, ac.num_resa_7, commentaire
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
                <th><small> Nom du Spectateur </small></th>
                <th><small> Prénom du Spectateur </small></th>
                <th><small>Date de creation   </small></th>
                <th><small>Abo                </small></th>
                <th><small>Spectacle 1        </small></th>
                <th><small>Spectacle 2        </small></th>
                <th><small>Spectacle 3        </small></th>
                <th><small>Spectacle 4        </small></th>
                <th><small>Spectacle 5        </small></th>
                <th><small>Spectacle 6        </small></th>
                <th><small>Spectacle 7        </small></th>
                <th><small>Commentaire        </small></th>
                <th><small>Voir               </small></th>
                <th><small>Edit               </small></th>
                <th><small>Supr               </small></th>
                <th><small>Impr               </small></th>
                <th><small>Dupli              </small></th>
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
                        $prenom = $data['prenom'];
                        $date = $data['date'];
                        $nom_abonnement = $data['nom_abonnement'];
                        $num_resa_1 = $data['num_resa_1'];
                        $num_resa_2 = $data['num_resa_2'];
                        $num_resa_3 = $data['num_resa_3'];
                        $num_resa_4 = $data['num_resa_4'];
                        $num_resa_5 = $data['num_resa_5'];
                        $num_resa_6 = $data['num_resa_6'];
                        $num_resa_7 = $data['num_resa_7'];
                        $commentaire = $data['commentaire'];
                    if($nombre & 1)
                        {
                        $line="0";
                        }else  
                            {
                            $line="1";
                            }
                            // ON récupère les nom des spectacles correspondant au numéro
                            $req_spectacle_1 = 'SELECT article FROM article, bon_comm AS bc WHERE bc.num_bon='.$num_resa_1.' AND bc.id_article = article.num';
                            $sql_spectacle_1 = mysql_query($req_spectacle_1);
                            $choix_spectacle_1 = mysql_result($sql_spectacle_1,0);
                            
                                                        // ON récupère les nom des spectacles correspondant au numéro
                            $req_spectacle_2 = 'SELECT article FROM article, bon_comm AS bc WHERE bc.num_bon='.$num_resa_2.' AND bc.id_article = article.num';
                            $sql_spectacle_2 = mysql_query($req_spectacle_2);
                            $choix_spectacle_2 = mysql_result($sql_spectacle_2,0);
                            
                                                        // ON récupère les nom des spectacles correspondant au numéro
                            $req_spectacle_3 = 'SELECT article FROM article, bon_comm AS bc WHERE bc.num_bon='.$num_resa_3.' AND bc.id_article = article.num';
                            $sql_spectacle_3 = mysql_query($req_spectacle_3);
                            $choix_spectacle_3 = mysql_result($sql_spectacle_3,0);
                            
                                                        // ON récupère les nom des spectacles correspondant au numéro
                            $req_spectacle_4 = 'SELECT article FROM article, bon_comm AS bc WHERE bc.num_bon='.$num_resa_4.' AND bc.id_article = article.num';
                            $sql_spectacle_4 = mysql_query($req_spectacle_4);
                            $choix_spectacle_4 = mysql_result($sql_spectacle_4,0);
                            
                                                        // ON récupère les nom des spectacles correspondant au numéro
                            $req_spectacle_5 = 'SELECT article FROM article, bon_comm AS bc WHERE bc.num_bon='.$num_resa_5.' AND bc.id_article = article.num';
                            $sql_spectacle_5 = mysql_query($req_spectacle_5);
                            $choix_spectacle_5 = mysql_result($sql_spectacle_5,0);
                            
                                                        // ON récupère les nom des spectacles correspondant au numéro
                            $req_spectacle_6 = 'SELECT article FROM article, bon_comm AS bc WHERE bc.num_bon='.$num_resa_6.' AND bc.id_article = article.num';
                            $sql_spectacle_6 = mysql_query($req_spectacle_6);
                            $choix_spectacle_6 = mysql_result($sql_spectacle_6,0);
                            
                                                        // ON récupère les nom des spectacles correspondant au numéro
                            $req_spectacle_7 = 'SELECT article FROM article, bon_comm AS bc WHERE bc.num_bon='.$num_resa_7.' AND bc.id_article = article.num';
                            $sql_spectacle_7 = mysql_query($req_spectacle_7);
                            $choix_spectacle_7 = mysql_result($sql_spectacle_7,0);
                ?>

                        <td> <?php echo $num_abo_com       ; ?> </td>
                        <td> <?php echo $nom               ; ?> </td>
                        <td> <?php echo $prenom               ; ?> </td>
                        <td> <?php echo $date              ; ?> </td>
                        <td> <?php echo $nom_abonnement    ; ?> </td>
                        <td> <?php echo $choix_spectacle_1 ; ?> </td>
                        <td> <?php echo $choix_spectacle_2 ; ?> </td>
                        <td> <?php echo $choix_spectacle_3 ; ?> </td>
                        <td> <?php echo $choix_spectacle_4 ; ?> </td>
                        <td> <?php echo $choix_spectacle_5 ; ?> </td>
                        <td> <?php echo $choix_spectacle_6 ; ?> </td>
                        <td> <?php echo $choix_spectacle_7 ; ?> </td>
                        <td> <?php echo $commentaire; ?></td>
                        <td><a href='voir_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>' >
                                <img border="0" alt="voir" src="image/voir.png" Title="Voir les details"></a></td>
                        <td><a href='edit_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>' >
                                <img border="0" alt="modifier" src="image/edit.png" Title="Modifier l'abonnement"></a></td>
                        <td><a href='delete_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>' >
                                <img border="0" alt="supprimer" src="image/delete.png" Title="Supprimer l'abonnement"></a></td>
                        <td><form action="fpdf/abonnement_pdf.php" method="post" target="_blank" >
                                <input type="hidden" name="num_abo_com" value="<?php echo $num_abo_com ?>" />
                                <input type="hidden" name="user" value="adm" />
                                <input type="image" src="image/print.png" style=" border: none; margin: 0;" alt="<?php echo $lang_imprimer; ?>" Title="Imprimer"/>
                            </form>
                         </td>
                                <td><a href='dupliquer_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>' >
                                                                <img border="0" alt="voir" src="image/duplicat.png" Title="Dupliquer le spectateur"></a></td>
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
