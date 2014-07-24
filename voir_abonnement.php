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

// on récupère le numero de vente de l'abonnement
$num_abo_com=isset($_GET['num_abo_com'])?$_GET['num_abo_com']:"";
?>

<?php
// On récupère toutes les informations sur la vente en fonction du numero de vente de l'abonnement 
$req_recup_info_vente = "SELECT num_abo_com, client_num, date_debut, date_fin, ctrl, fact, paiement, num_abonnement, date, quanti, nombre_place, choix_spectacle_1, choix_spectacle_2, choix_spectacle_3, choix_spectacle_4, choix_spectacle_5, choix_spectacle_6, choix_spectacle_7 
                         FROM abonnement_comm
                         WHERE num_abo_com = '$num_abo_com'";

$recup_info_vente_brut = mysql_query($req_recup_info_vente) or die ( "Execution requete -req_recup_info_vente- impossible.");
           
    while($data = mysql_fetch_array($recup_info_vente_brut))
        {
    $client_num = $data['client_num'];
    $num_abonnement = $data['num_abonnement'];
    $date = $data['date'];
    $quanti = $data['quanti'];
    $nombre_spectacle = $data['nombre_place'];
    $choix_spectacle_1 = $data['choix_spectacle_1'];
    $choix_spectacle_2 = $data['choix_spectacle_2'];
    $choix_spectacle_3 = $data['choix_spectacle_3']; // supr les choix_spectacle au dessu de 1. Il faut fair une requete pour tous les valider selon le bon $num[article] 
    $choix_spectacle_4 = $data['choix_spectacle_4']; // la requete du dessus est bonne car elle recup seulement le nom, il faut edit les requete du dessous pour avoir la bonne horaire en faisan apelle a 'num_spectacle_1'[abonnement_comm]
    $choix_spectacle_5 = $data['choix_spectacle_5'];
    $choix_spectacle_6 = $data['choix_spectacle_6'];    
    $choix_spectacle_7 = $data['choix_spectacle_7']; 
    
    $date_debut = $data['date_debut'];
    $date_fin = $data['date_fin'];
    $ctrl = $data['ctrl'];
    $fact = $data['fact'];
    $paiement = $data['paiement'];    
        }

// On fais des requetes pour récupérer les information des différentes tables en utilisant les variables récup au dessus (ex : nom spectacle, nom spectateur, prix abo, ect)
// Nom spectateur
$req_recup_nom_spec = "SELECT num_client, nom
                       FROM client
                       WHERE num_client = '$client_num'";
$recup_nom_spec_brut = mysql_query($req_recup_nom_spec) or die ( "Execution requete -req_recup_nom_spec- impossible.");      
    while($data = mysql_fetch_array($recup_nom_spec_brut))
    {
    $nom = $data['nom'];    
    }
    
// recup Nom abonnement & nombre_spectacle
$req_recup_abo = "SELECT num_abonnement, nom_abonnement, tarif_abonnement
                  FROM abonnement 
                  WHERE num_abonnement = '$num_abonnement'";
$recup_abo_brut = mysql_query($req_recup_abo) or die ( "Execution requete -req_recup_abo- impossible.");      
    while($data = mysql_fetch_array($recup_abo_brut))
    {
    $nom_abonnement = $data['nom_abonnement'];
    $tarif_abonnement = $data['tarif_abonnement'];
    }

// On récupère l'horaire & date & type_article des spectacles pour l'afficher dans le recap
            // Horaire & date du spectacle 1
            $req_horaire_spectacle_1 = "SELECT a.horaire, a.date_spectacle, a.type_article, a.numero_representation, a.article, a.num
                                        FROM article a, abonnement_comm ac
                                        WHERE article = '$choix_spectacle_1'
                                        AND ac.num_spectacle_1 = a.num";
            $horaire_spectacle_brut_1 = mysql_query( $req_horaire_spectacle_1 )or die( "Execution requete -req_horaire_spectacle_1- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_1))
                                            {
                                            $horaire_spectacle_1_vendu = $data['horaire'];
                                            $date_spectacle_1_vendu = $data['date_spectacle'];
                                            $type_spectacle_1_vendu = $data['type_article'];
                                            $numero_repre_spectacle_1_vendu = $data['numero_representation'];
                                            }

             // Horaire  & date du spectacle 2
            $req_horaire_spectacle_2 = "SELECT a.horaire, a.date_spectacle, a.type_article, a.numero_representation, a.article, a.num
                                        FROM article a, abonnement_comm ac
                                        WHERE article = '$choix_spectacle_2'
                                        AND ac.num_spectacle_2 = a.num";
            $horaire_spectacle_brut_2 = mysql_query( $req_horaire_spectacle_2 )or die( "Execution requete -req_horaire_spectacle_2- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_2))
                                            {
                                            $horaire_spectacle_2_vendu = $data['horaire'];
                                            $date_spectacle_2_vendu = $data['date_spectacle'];
                                            $type_spectacle_2_vendu = $data['type_article'];
                                            $numero_repre_spectacle_2_vendu = $data['numero_representation'];
                                            }  
                                            
            // Horaire & date du spectacle 3
            $req_horaire_spectacle_3 = "SELECT a.horaire, a.date_spectacle, a.type_article, a.numero_representation, a.article, a.num
                                        FROM article a, abonnement_comm ac
                                        WHERE article = '$choix_spectacle_3'
                                        AND ac.num_spectacle_3 = a.num";
            $horaire_spectacle_brut_3 = mysql_query( $req_horaire_spectacle_3 )or die( "Execution requete -req_horaire_spectacle_3- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_3))
                                            {
                                            $horaire_spectacle_3_vendu = $data['horaire'];
                                            $date_spectacle_3_vendu = $data['date_spectacle'];
                                            $type_spectacle_3_vendu = $data['type_article'];
                                            $numero_repre_spectacle_3_vendu = $data['numero_representation'];
                                            }                                            
                                            
            // Horaire & date du spectacle 4
            $req_horaire_spectacle_4 = "SELECT a.horaire, a.date_spectacle, a.type_article, a.numero_representation, a.article, a.num
                                        FROM article a, abonnement_comm ac
                                        WHERE article = '$choix_spectacle_4'
                                        AND ac.num_spectacle_4 = a.num";
            $horaire_spectacle_brut_4 = mysql_query( $req_horaire_spectacle_4 )or die( "Execution requete -req_horaire_spectacle_4- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_4))
                                            {
                                            $horaire_spectacle_4_vendu = $data['horaire'];
                                            $date_spectacle_4_vendu = $data['date_spectacle'];
                                            $type_spectacle_4_vendu = $data['type_article'];
                                            $numero_repre_spectacle_4_vendu = $data['numero_representation'];
                                            }                                            
                                            
            // Horaire & date du spectacle 5
            $req_horaire_spectacle_5 = "SELECT a.horaire, a.date_spectacle, a.type_article, a.numero_representation, a.article, a.num
                                        FROM article a, abonnement_comm ac
                                        WHERE article = '$choix_spectacle_5'
                                        AND ac.num_spectacle_5 = a.num";
            $horaire_spectacle_brut_5 = mysql_query( $req_horaire_spectacle_5 )or die( "Execution requete -req_horaire_spectacle_5- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_5))
                                            {
                                            $horaire_spectacle_5_vendu = $data['horaire'];
                                            $date_spectacle_5_vendu = $data['date_spectacle'];
                                            $type_spectacle_5_vendu = $data['type_article'];
                                            $numero_repre_spectacle_5_vendu = $data['numero_representation'];
                                            }                                            
                                            
            // Horaire & date du spectacle 6
            $req_horaire_spectacle_6 = "SELECT a.horaire, a.date_spectacle, a.type_article, a.numero_representation, a.article, a.num
                                        FROM article a, abonnement_comm ac
                                        WHERE article = '$choix_spectacle_6'
                                        AND ac.num_spectacle_6 = a.num";
            $horaire_spectacle_brut_6 = mysql_query( $req_horaire_spectacle_6 )or die( "Execution requete -req_horaire_spectacle_6- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_6))
                                            {
                                            $horaire_spectacle_6_vendu = $data['horaire'];
                                            $date_spectacle_6_vendu = $data['date_spectacle'];
                                            $type_spectacle_6_vendu = $data['type_article'];
                                            $numero_repre_spectacle_6_vendu = $data['numero_representation'];
                                            }
                                            
            // Horaire & date du spectacle 7
            $req_horaire_spectacle_7 = "SELECT a.horaire, a.date_spectacle, a.type_article, a.numero_representation, a.article, a.num
                                        FROM article a, abonnement_comm ac
                                        WHERE article = '$choix_spectacle_7'
                                        AND ac.num_spectacle_7 = a.num";
            $horaire_spectacle_brut_7 = mysql_query( $req_horaire_spectacle_7 )or die( "Execution requete -req_horaire_spectacle_7- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_7))
                                            {
                                            $horaire_spectacle_7_vendu = $data['horaire'];
                                            $date_spectacle_7_vendu = $data['date_spectacle'];
                                            $type_spectacle_7_vendu = $data['type_article'];
                                            $numero_repre_spectacle_7_vendu = $data['numero_representation'];
                                            }                                            
                                            
?>
<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
                    <h3>Information sur l'abonnement de <?php echo"$nom"; ?> du [<?php echo"$date_debut" ; ?> au <?php echo "$date_fin" ;?>] :</h3>	
                </td>
        </tr>
        <tr>
		<td>
	      		<table class="boiteaction">
	  			<caption> Detail de l'abonnement :</caption>
                </td>
                
	<tr>
            <th> Numero d'abonnement </th>  
            <th> Nom du spectateur   </th>  
            <th> Abonnement choisie  </th> 
            <th> Nombre de spetacles </th>
            <th> Total               </th>
            <th>Paiement</th>
            <th>Controle</th>
            <th>Encaisse</th>
            <th> Spectacle choix 1   </th>
            <th> Spectacle choix 2   </th>
            <th> Spectacle choix 3   </th>
            <th> Spectacle choix 4   </th>
            <th> Spectacle choix 5   </th>
            <th> Spectacle choix 6   </th>
            <th> Spectacle choix 7   </th>
        <tr/>

        <tr>
            <td> <?php echo "$num_abo_com"; ?>   </td>
            <td> <?php echo $nom ; ?>            </td>
            <td> <?php echo $nom_abonnement ;?>  </td>
            <td> <?php echo $nombre_spectacle ;?></td>
            <td> <?php $total = $quanti * $tarif_abonnement ; echo "$total"; echo"$devise"; ?></td>
            <td><?php echo $ctrl ;?></td>
            <td><?php echo $fact ;?></td>
            <td><?php echo $paiement ;?></td>
        
            <td>    <b> <?php echo "$choix_spectacle_1" ; ?>     </b><br/> <br/>
                        <?php echo "$horaire_spectacle_1_vendu" ;?>  <br/> <br/>
                        <?php echo "$date_spectacle_1_vendu" ; ?>    <br/> <br/>          
            </td>
            
            <td>    <b> <?php echo "$choix_spectacle_2" ; ?>     </b> <br/> <br/>
                        <?php echo "$horaire_spectacle_2_vendu" ; ?>  <br/> <br/>
                        <?php echo "$date_spectacle_2_vendu" ; ?>     <br/> <br/>
            </td>
             
            <td>   <b>  <?php echo "$choix_spectacle_3" ; ?>     </b> <br/> <br/>
                        <?php echo "$horaire_spectacle_3_vendu" ; ?>  <br/> <br/>
                        <?php echo "$date_spectacle_3_vendu" ; ?>     <br/> <br/>
            </td>
             
            <td>  <b>   <?php echo "$choix_spectacle_4" ; ?>     </b> <br/> <br/>
                        <?php echo "$horaire_spectacle_4_vendu" ; ?>  <br/> <br/>
                        <?php echo "$date_spectacle_4_vendu" ; ?>     <br/> <br/>
            </td>
              
            <td>  <b>  <?php echo "$choix_spectacle_5" ; ?>     </b> <br/> <br/>
                       <?php echo "$horaire_spectacle_5_vendu" ; ?>  <br/> <br/>
                       <?php echo "$date_spectacle_5_vendu" ; ?>     <br/> <br/>
            </td>
               
            <td>  <b> <?php echo "$choix_spectacle_6" ; ?>     </b>  <br/> <br/>
                      <?php echo "$horaire_spectacle_6_vendu" ; ?>   <br/> <br/>
                      <?php echo "$date_spectacle_6_vendu" ; ?>      <br/> <br/>
            </td>
               
               
            <td> <b> <?php echo "$choix_spectacle_7" ; ?>       </b> <br/> <br/>
                     <?php echo "$horaire_spectacle_7_vendu" ; ?>    <br/> <br/>
                     <?php echo "$date_spectacle_7_vendu" ; ?>       <br/> <br/>
            </td>
        </tr>   
         


        
            </table>
</table>

<table border="0" class="page" align="center">

        <tr>
                <td> 
                    <a href='new_abonnement.php'><img border =0 src="image/new_mini_abonnement.png" alt=""> <br> Ajouter un nouvel d'abonnement </a>
                </td>

                <td>
                    <a href='lister_abonnement.php'><img border =0 src="image/lister_abonnement_gris.png" alt=""> <br> Lister les differentes Abonnements </a>
                </td>
        
        
            <form>
                <td>
                    <a href='edit_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>'><img border =0 src="image/edit.png" alt=""> <br> Modifier l'abonnement </a>
                </td>
                <td>
                    <a href='print_ticket_abo.php?num_abo_com=<?php echo "$num_abo_com"; ?>' onclick="edition();return false;"><img border=0 src="image/billetterie_v2.png"><br> Imprimer l'abonnement </a>
                </td>
                
                <td>
                    <a href='dupliquer_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>' onclick="edition();return false;"><img border=0 src="image/duplicat.png"><br> Dupliquer l'abonnement </a>
                </td>
            </form>
        
        </tr> 
        
</table>




<?php
include_once("include/bas.php");
?>