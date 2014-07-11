<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
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

<!-- Information spectacles a venir -->
<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
                    <h3> Les prochains spectacles a venir : </h3>	
                </td>
        </tr>
        <tr>
		<td>
	      		<table class="boiteaction">
	  			<caption>  </caption>
                </td>
    </tr>
    
    <tr>
        <th> Affiche </th>
        <th> Type </th>
        <th> Nom </th>
        <th> Numero de representation </th>
        <th> Commmentaire </th>
        <th> Lieux & horaires </th>
        <th> Dates </th>
        <th> Places restant </th>
                        
<?php
    $nb="1";
    $sql_art = "SELECT image_article, article, type_article, numero_representation, lieu, horaire, date_spectacle, commentaire, stock
                FROM article 
                WHERE date_spectacle > CURRENT_DATE
                LIMIT 3";
    $recup_art_brut = mysql_query($sql_art)or die('Erreur !<br>'.$sql_art.'<br>'.mysql_error());
    // est egale ou superieur a CURRENT_DATE, limit 3
                        while ($data1 = mysql_fetch_assoc($recup_art_brut))
                {
                            $image = $data1['image_article'];
                            $nom_spectacle = $data1['article'];
                            $type = $data1['type_article'];
                            $num_representation = $data1['numero_representation'];
                            $lieu = $data1['lieu'];
                            $horaire = $data1['horaire'];
                            $date = $data1['date_spectacle'];
                            $com = $data1['commentaire'];
                            $stock = $data1['stock'];
                            
                            $nb = $nb +1;
                                    if($nb & 1)
                                      {
                                       $line="0";
                                       }else  
                                            {
                                            $line="1";
                                            } 
?>
        <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
        <td class="highlight"><img src="<?php echo$image; ?>" height="100"></td>
        <td class="highlight"><?php echo $type ; ?></td>
        <td class="highlight"><?php echo $nom_spectacle ; ?></td>
        <td class="highlight"><?php echo $num_representation ; ?></td>
        <td class="highlight"><?php echo $com ; ?></td>
        <td class="highlight"><?php echo $lieu ; ?> </br>-</br> <?php echo $horaire ; ?></td>
        <td class="highlight"><?php echo $date ; ?></td>
        <td class="highlight"><?php echo $stock ; ?></td>
        </tr>
        
        <?php
                }
        ?>
        
                        </table>
</table>

<!-- Information abonnement -->
<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
                    <h3>Liste des differentes formules d'Abonnements </h3>	
                </td>
        </tr>
        <tr>
		<td>
	      		<table class="boiteaction">
	  			<caption>  </caption>
                </td>
    </tr>
    
    <tr>
        <th> Numero d'abonnement    </th>
        <th> Nom d'abonnement       </th>
        <th> Tarif de l'abonnement  </th>
        
<?php
            $nombre="1";
            //  On liste la quantite vendu d abonnement par abonnement 
            $req_recup_quanti_abonnement = "SELECT nom_abonnement, num_abonnement, tarif_abonnement
                                            FROM abonnement";
            $recup_quanti_vendu_brut = mysql_query($req_recup_quanti_abonnement)or die('Erreur !<br>'.$req_recup_quanti_abonnement.'<br>'.mysql_error());
                    while ($data2 = mysql_fetch_assoc($recup_quanti_vendu_brut))
                {
                            $tarif_abonnement = $data2['tarif_abonnement'];
                            $nom_abonnement = $data2['nom_abonnement'];
                            $num_abonnement = $data2['num_abonnement'];
                            $nombre = $nombre +1;
                                    if($nombre & 1)
                                      {
                                       $line="0";
                                       }else  
                                            {
                                            $line="1";
                                            } 
?>
        
    <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
        <td class="highlight"><?php echo $num_abonnement ; ?></td>
        <td class="highlight"><?php echo $nom_abonnement ; ?></td>
        <td class="highlight"><?php echo $tarif_abonnement ; ?></td>
    </tr>
    
            <?php
                }
            ?>
                        </table>
</table>

     
<!-- Information statistique general -->                    
<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
                    <h3>Statistique General </h3>	
                </td>
        </tr>
        <tr>
		<td>
	      		<table class="boiteaction">
	  			<caption>  </caption>

<?php
                //  On liste la quantite de spectateur
            $req_recup_quanti_abonnement = "SELECT COUNT(num_client) AS nombre_de_client
                                            FROM client";
            $recup_quanti_vendu_brut = mysql_query($req_recup_quanti_abonnement)or die('Erreur !<br>'.$req_recup_quanti_abonnement.'<br>'.mysql_error());
                    while ($data3 = mysql_fetch_assoc($recup_quanti_vendu_brut))
                {
                            $nb_spec = $data3['nombre_de_client'];
                }
                
                //  On liste la quantite d abonne
            $req_recup_quanti_abonnement = "SELECT COUNT(num_abo_com) AS nombre_abonne
                                            FROM abonnement_comm";
            $recup_quanti_vendu_brut = mysql_query($req_recup_quanti_abonnement)or die('Erreur !<br>'.$req_recup_quanti_abonnement.'<br>'.mysql_error());
                    while ($data4 = mysql_fetch_assoc($recup_quanti_vendu_brut))
                {
                            $nb_abo= $data4['nombre_abonne'];
                }
                
?>
        <tr>
            <th>Nombre total de spectateurs </th>
            <th>Nombre total d'abonnement vendu</th>
        </tr>
        <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
            <td class="highlight"><?php echo $nb_spec ;?> personnes</td>
            <td class="highlight"><?php echo $nb_abo ;?></td>
        </tr>

                    </table>
</table>

                    
<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
                    <h3>Documentation </h3>	
                </td>
        </tr>
        <tr>
		<td>
	      		<table class="boiteaction">
                            <caption> Cliquer ici pour vous diriger vers la documentationlis</caption>
</table>
</table>




<?php
include_once("include/bas.php");
?>