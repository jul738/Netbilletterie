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
include_once("include/fonction.php");

$num_client=isset($_GET['num_client'])?$_GET['num_client']:"";
?>

<?php                       

//Recupere les info client
$req_recup_info_client = "SELECT c.nom, c.prenom, c.rue, c.ville, c.cp, c.mail, c.tel
                          FROM client c
                          WHERE c.num_client = '$num_client'";
$recup_info_client_brut = mysql_query($req_recup_info_client) or die('Erreur SQL2 !<br>'.$req_recup_info_client.'<br>'.mysql_error());
while($data = mysql_fetch_array($recup_info_client_brut))
    {
$nom = $data['nom'];
$prenom = $data['prenom'];
$rue = $data['rue'];
$ville = $data['ville'];
$cp = $data['cp'];
$mail = $data['mail'];
$tel = $data['tel'];
    }

// Récupère les infos des clients liés
$req_client_lies = "SELECT c.nom, c.prenom, c.num_client
                    FROM client AS c, client_liens as cl
                    WHERE cl.num_client_parent = '$num_client'
                    AND c.num_client = cl.num_client_enfant";
$recup_infos_client_lies = mysql_query($req_client_lies) or die('Erreur SQL !<br>'.$req_client_lies.'<br>'.mysql_error());
while($data_client_lie = mysql_fetch_array($recup_infos_client_lies)){
    $client_lie[] = $data_client_lie;
}

?>
<table  class="page" align="center">
    
    <tr>
        <td class="page" align="center">
        <h3> Informations sur <?php echo $nom ;?> <?php echo $prenom ;?> :</h3>
        </td>
    </tr>
      
            <td  class="page" align="center">
                            
    <table class="boiteaction">            
        <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo $line ?>'">
            <td class="highlight"><?php echo $rue ;?>, <?php echo $ville ;?> <?php echo $cp ;?> </td>
        </tr>

        <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo $line ?>'">
            <td class="highlight"><?php echo $tel ;?></td>
        </tr>

        <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo $line ?>'">
            <td class="highlight"><?php echo $mail ;?></td>
        </tr>
    </table>
    
            <?php
                if(!empty($client_lie)) {
            ?>
            <tr class="page" align="center">
                        <td class="page" align="center">
                         <h3> Spectateurs en lien avec <?php echo $nom ;?> <?php echo $prenom ;?> :</h3>
                        </td>
            </tr>
            <td  class="page" align="center">
            <table class="boiteaction">  
                <?php
                foreach($client_lie as $client_enfant){
                ?>
                <tr onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo $line ?>'">
                   <td class="highlight"> <a href="voir_reservation_client.php?num_client=<?php echo $client_enfant['num_client']; ?>"><?php echo $client_enfant['nom'] ; echo $client_enfant['prenom']; ?></a></td>
                </tr>
                <?php
                }
                ?>
            </table>
            </td>
            <?php
                }
            ?>
            
</table>

<?php
//On récupère le nombre de réservations par spectacle et par tarif
    $select_nb = "SELECT client_num, id_article, bc.id_tarif, a.article, a.date_spectacle, a.horaire, t.nom_tarif, COUNT( num_bon ) AS compteur
FROM bon_comm AS bc, article AS a, tarif AS t
WHERE bc.client_num = $num_client
AND bc.id_article = a.num
AND bc.id_tarif = t.id_tarif
GROUP BY id_article, bc.id_tarif
ORDER BY a.date_spectacle, a.horaire";
    
   $result_nb = mysql_query($select_nb) or die ('Erreur nb résas par spectacle et tarif');
   
   ?>
<table class="page" align="center">
    
    <tr>
        <td class="page" align="center">
             <h3>Nombre de réservations :</h3>
        </td>
    </tr>
    <tr>
        <td  class="page" align="center">
                            <center>
        <table class="boiteaction">
                <tr>
                    <th>Nom de la representation</a></th>
                    <th>Date</th>
                    <th>Horaire</th>
                    <th>Tarif</th>
                    <th>Nombre</th>
                </tr>
<?php   
   //On ajoute les infos dans le tableau
   
   while($data_nb = mysql_fetch_array($result_nb)){
       $nb_article = $data_nb['article'];
       $nb_date_timestamp = strtotime($data_nb['date_spectacle']);
       $nb_date = date_fr('l d-m-Y', $nb_date_timestamp);
       $nb_horaire = $data_nb['horaire'];
       $nb_tarif = $data_nb['nom_tarif'];
       $nb_count = $data_nb['compteur'];
       ?>
                <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo $line ?>'">
                    <td class="highlight"><?php echo "$nb_article"; ?></td>
                    <td class="highlight"><?php echo "$nb_date"; ?></td>
                    <td class="highlight"><?php echo "$nb_horaire" ; ?></td>
                    <td class="highlight"><?php echo "$nb_tarif"; ?></td>
                    <td class="highlight"><?php echo "$nb_count"; ?></td>
                </tr>
<?php
   } // fin du while nb resa
?>
        </table>

                </center>
        </td>
    </tr>
</table>

<table  class="page" align="center">
    
    <tr>
        <td class="page" align="center">
             <h3>Réservations en cours :</h3>
        </td>
    </tr>
    
    <tr>
        <td  class="page" align="center">
                            <center>
        <table class="boiteaction">
                <tr>
                    <th>Numéro</a></th>
                    <th>Nom de la representation</a></th>
                    <th>Date</th>
                    <th>Horaire</th>
                    <th>Total</a></th>
                    <th colspan='2'>Action</a></th>
                </tr>
                
            <?php  
//Recupere tous les reservation grace a son numero client
$req_recup_info_resa = "SELECT num_bon, date, article, num, horaire, date_spectacle, prix_tarif
                        FROM bon_comm AS bc, article AS a, tarif AS t
                        WHERE bc.id_article = a.num 
                        AND bc.client_num = '$num_client'
                        AND bc.id_tarif = t.id_tarif";
$recup_info_client_brut = mysql_query($req_recup_info_resa) or die('Erreur SQL0 !<br>'.$req_recup_info_client.'<br>'.mysql_error());
    while($data2 = mysql_fetch_array($recup_info_client_brut))
        {
        $num_bon = $data2['num_bon'];
        $date_resa = $data2['date'];
        $soir = $data2['article'];
        $num_article = $data2['num'];
        $horaire = $data2['horaire'];
        $date_resa = $data2['date_spectacle'];
        $total_resa = $data2['prix_tarif'];
        
            ?>
                
                <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo $line ?>'">
                    <td class="highlight"><?php echo "$num_bon"; ?></td>
                    <td class="highlight"><?php echo "$soir"; ?></td>
                    <td class="highlight"><?php echo "$date_resa" ; ?></td>
                    <td class="highlight"><?php echo "$horaire"; ?></td>
                    <td class="highlight"><?php echo "$total_resa"; ?></td>
                    <td class="highlight"><a href='form_editer_bon.php?num_bon=<?php echo "$num_bon" ;?>'>
                    <img border="0" alt="Modifier" src="image/edit.png" Title="Modifier"></a></td>
                    <td class="highlight"><a href='delete_bon_suite.php?num_bon=<?php echo "$num_bon" ;?>&nom=<?php echo $nom; ?>'>
                    <img border="0" alt="Modifier" src="image/delete.png" Title="Supprimer"></a></td>
                </tr>
<?php   } // Fin du while reservation  ?>
                
        </table>

                </center>
        </td>
    </tr>
    
</table>

        

<table  class="page" align="center">
    
    <tr>
        <td class="page" align="center">
             <h3>Abonnements en cours :</h3>
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
                       FROM abonnement AS a, abonnement_comm AS ac
                       WHERE ac.client_num = '$num_client'
                       AND ac.num_abonnement = a.num_abonnement
                       AND ac.date_fin > CURDATE()";
$recup_info_abo_brut = mysql_query($req_recup_info_abo) or die('Erreur SQL3 !<br>'.$req_recup_info_abo.'<br>'.mysql_error());
                        while($data3 = mysql_fetch_array($recup_info_abo_brut))
                            {
                            $num_abo_com = $data3['num_abo_com'];
                            $nom_abonnement = $data3['nom_abonnement'];
                            $date_debut = $data3['date_debut'];
                            $date_fin = $data3['date_fin'];
                            $total = $data3['tarif_abonnement'];
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


