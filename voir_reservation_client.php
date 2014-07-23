<?php 
/* Net Billetterie Copyright(C)2012 Jose Das Neves
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jose Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");

$num_client=isset($_GET['num_client'])?$_GET['num_client']:"";


?>

<?php

                    
        $req_recup_horaire_date = "SELECT a.horaire, a.date_spectacle
                                   FROM cont_bon AS cb, article AS a
                                   WHERE cb.article_num = '$num_article'";
$recup_horaire_date_brut = mysql_query($req_recup_horaire_date) or die('Erreur SQL1 !<br>'.$$req_recup_horaire_date.'<br>'.mysql_error());
                            while($data2 = mysql_fetch_array($recup_horaire_date_brut))
                                {
                                $horaire = $data2['horaire'];
                                $date_spectacle = $data2['date_spectacle'];
                                }                    
                    

//Recupere les info client
$req_recup_info_client = "SELECT c.nom, c.prenom, bc.num_bon
                          FROM client c, bon_comm bc
                          WHERE c.num_client = '$num_client'
                          AND bc.client_num = '$num_client'";
$recup_info_client_brut = mysql_query($req_recup_info_client) or die('Erreur SQL2 !<br>'.$req_recup_info_client.'<br>'.mysql_error());
while($data = mysql_fetch_array($recup_info_client_brut))
    {
$nom = $data['nom'];
$prenom = $data['prenom'];
//$num_bon = $data['num_bon'];
    }


?>

<table  class="page" align="center">
    
    <tr>
        <td class="page" align="center">
             <h3>Reservation en cour pour <?php echo $nom ;?> <?php echo $prenom ;?> :</h3>
        </td>
    </tr>
    
    <tr>
        <td  class="page" align="center">
                            <center>
        <table class="boiteaction">
                <tr>
                    <th>Numero</a></th>
                    <th>Nom de la representation</a></th>
                    <th>Date</th>
                    <th>Horaire</th>
                    <th>Quantite</a></th>
                    <th>Total</a></th>
                    <th colspan='2'>Action</a></th>
                </tr>
                
            <?php  
//Recupere tous les reservation grace a son numero client
$req_recup_info_resa = "SELECT * 
                        FROM bon_comm AS bc, cont_bon AS cb, article AS a
                        WHERE bc.num_bon = cb.bon_num 
                        AND cb.article_num = a.num 
                        AND bc.client_num = '$num_client'
                        AND cb.article_num = a.num";
$recup_info_client_brut = mysql_query($req_recup_info_resa) or die('Erreur SQL0 !<br>'.$req_recup_info_client.'<br>'.mysql_error());
    while($data2 = mysql_fetch_array($recup_info_client_brut))
        {
        $num_bon = $data2['num_bon'];
        $date_resa = $data2['date'];
        $soir = $data2['article'];
        $num_article = $data2['num'];
        $horaire = $data2['horaire'];
        $date_resa = $data2['date_spectacle'];
        $quanti = $data2['quanti'];
        $total_resa = $data2['prix_tarif'];
        
            ?>
                
                <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo $line ?>'">
                    <td class="highlight"><?php echo "$num_bon"; ?></td>
                    <td class="highlight"><?php echo "$soir"; ?></td>
                    <td class="highlight"><?php echo "$date_resa" ; ?></td>
                    <td class="highlight"><?php echo "$horaire"; ?></td>
                    <td class="highlight"><?php echo $quanti ; ?></td>
                    <td class="highlight"><?php echo "$total_resa"; ?></td>
                    <td class="highlight"><a href='form_editer_bon.php?num_bon=<?php echo "$num_bon" ;?>'>
                    <img border="0" alt="Modifier" src="image/edit.png" Title="Modifier"></a></td>
                    <td class="highlight"><a href='form_editer_bon.php?num_bon=<?php echo "$num_bon" ;?>'>
                    <img border="0" alt="Modifier" src="image/delete.png" Title="Supprimer"></a></td>
                </tr>
<?php   } // Fin du while reservation  ?>
                
        </table>

                </center>
        </td>
    </tr>

        

        <tr>
        <td class="page" align="center">
             <h3>Abonnement en cour pour <?php echo $nom ;?> <?php echo $prenom ;?> :</h3>
        </td>
    </tr>
    
    <tr>
        <td  class="page" align="center">
                            <center>
        <table class="boiteaction">
                <tr>
                    <th>Numero</a></th>
                    <th>Nom de l'abonnement</a></th>
                    <th>Date de debut</th>
                    <th>Date de fin</th>
                    <th>Total</a></th>
                    <th colspan='3'>Action</a></th>
                </tr>
                
                    <?php

                    
//Recupere le num_abo_com equivalent num_bon pour les abonnement. 
$req_recup_info_abo = "SELECT *
                       FROM abonnement AS a, abonnement_comm AS ac, abonnement_paiement AS ap
                       WHERE ac.client_num = '$num_client'
                       AND ap.num_client = '$num_client'
                       AND ac.num_abonnement = a.num_abonnement
                       AND ac.num_abo_com = ap.num_abo_com
                       AND ac.date_fin > CURDATE()";
$recup_info_abo_brut = mysql_query($req_recup_info_abo) or die('Erreur SQL3 !<br>'.$req_recup_info_abo.'<br>'.mysql_error());
                        while($data3 = mysql_fetch_array($recup_info_abo_brut))
                            {
                            $num_abo_com = $data3['num_abo_com'];
                            $nom_abonnement = $data3['nom_abonnement'];
                            $date_debut = $data3['date_debut'];
                            $date_fin = $data3['date_fin'];
                            $total = $data3['total_ttc'];
                    ?>                
                
                <tr>
                    <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo $line ?>'">
                    <td class="highlight"><?php echo "$num_abo_com"; ?></td>
                    <td class="highlight"><?php echo "$nom_abonnement"; ?></td>
                    <td class="highlight"><?php echo "$date_debut"; ?></td>
                    <td class="highlight"><?php echo "$date_fin"; ?></td>
                    <td class="highlight"><?php echo "$total"; ?></td>
                    <td><a href='voir_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>' >
                                <img border="0" alt="voir" src="image/voir.png" Title="Voir les details"></a></td>
                    <td><a href='edit_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>' >
                                <img border="0" alt="modifier" src="image/edit.png" Title="Modifier l'abonnement"></a></td>
                    <td><a href='delete_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>' >
                                <img border="0" alt="supprimer" src="image/delete.png" Title="Supprimer l'abonnement"></a></td>
                </tr>
                      <?php } //fin du while abonnement ?>
        </table>
</table>

<?php
include_once("include/bas.php");


//Note perso : afficher la reservation et l'abonnement masi renvoyer sur -> Recapitulatif pour l'abonnement / form_editer_bon.php / Enlever le bouton d'edition
?>


