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

    //On recupere les info sur les spectacle que reserve le client
//$req_recup_info_article = "SELECT horaire, type_article, date_spectacle
//                           FROM article
//                           WHERE article = '$soir'";
//$recup_info_article_brut = mysql_query($req_recup_info_article) or die('Erreur SQL2 !<br>'.$req_recup_info_article.'<br>'.mysql_error());
//while($data = mysql_fetch_array(recup_info_article_brut))
//    {
//    $horaire = $data['horaire'];
//    $date_spectacle = $data['date_spectacle'];
//    }
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
                    <th>Action</a></th>
                </tr>
                
            <?php
            
//Recupere tous les reservation grace a son numero client
$req_recup_info_resa = "SELECT *
                        FROM bon_comm
                        WHERE client_num = '$num_client'";
$recup_info_client_brut = mysql_query($req_recup_info_client) or die('Erreur SQL2 !<br>'.$req_recup_info_client.'<br>'.mysql_error());
    while($data = mysql_fetch_array($recup_info_client_brut))
        {
        $num_bon = $data['num_bon'];
        $date_resa = $data['date'];
        $soir = $data['soir'];
            ?>
                
                <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo $line ?>'">
                    <td class="highlight"><?php echo "$num_bon"; ?></td>
                    <td class="highlight"><?php echo "$soir"; ?></td>
                    <td class="highlight"><?php echo "$date_spectacle" ; ?></td>
                    <td class="highlight"><?php echo "$horaire"; ?></td>
                    <td class="highlight"><?php echo $quanti ; ?></td>
                    <td class="highlight"><?php echo "$total"; ?></td>
                    <td class="highlight"><a href='form_editer_bon.php?num_bon=<?php echo "$num_bon" ;?>'>
                    <img border="0" alt="Modifier" src="image/edit.gif" Title="Modifier"></a></td>
                </tr>
        </table>
<?php   } ?>
                </center>
        </td>
    </tr>

    <tr>
        <td>
            
<?php
//Recupere le num_abo_com equivalent num_bon pour les abonnement. 
$req_recup_info_resa = "SELECT
                        FROM 
                        WHERE";
$recup_info_client_brut = mysql_query($req_recup_info_client) or die('Erreur SQL2 !<br>'.$req_recup_info_client.'<br>'.mysql_error());
while($data = mysql_fetch_array($recup_info_client_brut))
    {
    }
?>
            
</table>

<?php
include_once("include/bas.php");
?>


