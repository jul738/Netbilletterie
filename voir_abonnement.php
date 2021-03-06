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
include_once("include/fonction.php");

// on récupère le numero de vente de l'abonnement
$num_abo_com=isset($_GET['num_abo_com'])?$_GET['num_abo_com']:"";
?>

<?php
// On récupère toutes les informations sur la vente en fonction du numero de vente de l'abonnement 
$req_recup_info_vente = "SELECT num_abo_com, client_num, date_debut, date_fin, ctrl, fact, paiement, ac.num_abonnement, ac.date, nombre_place, num_resa_1, num_resa_2, num_resa_3, num_resa_4, num_resa_5, num_resa_6, num_resa_7, tarif_abonnement, nom_abonnement, c.nom, c.prenom, commentaire 
                         FROM abonnement_comm AS ac, abonnement AS a, client AS c, type_paiement AS p
                         WHERE num_abo_com = '$num_abo_com'
                         AND ac.num_abonnement = a.num_abonnement
                         AND ac.client_num = c.num_client";

$recup_info_vente_brut = mysql_query($req_recup_info_vente) or die ( 'Execution requete -req_recup_info_vente- impossible.');
           
    while($data = mysql_fetch_array($recup_info_vente_brut))
        {
    $client_num = $data['client_num'];
    $num_abonnement = $data['num_abonnement'];
    $date = $data['date'];
    $nombre_spectacle = $data['nombre_place'];
    $num_resa_1 = $data['num_resa_1'];
    $num_resa_2 = $data['num_resa_2'];
    $num_resa_3 = $data['num_resa_3'];
    $num_resa_4 = $data['num_resa_4'];
    $num_resa_5 = $data['num_resa_5'];
    $num_resa_6 = $data['num_resa_6'];    
    $num_resa_7 = $data['num_resa_7']; 
    $tarif_abonnement = $data['tarif_abonnement'];
    $nom_abonnement = $data['nom_abonnement'];
    $date_debut = $data['date_debut'];
    $date_fin = $data['date_fin'];
    $ctrl = $data['ctrl'];
    $fact = $data['fact'];
    $nom = $data['nom'];  
    $prenom = $data['prenom'];
    $commentaire = $data['commentaire'];
    $paiement = $data['paiement'];
        }
        
        // On récupère le nom du paiement 
        if ((!empty($paiement)) || ($paiement == 'non')){
            $sql_nom_paiement = "SELECT nom FROM type_paiement WHERE id_type_paiement = '$paiement'";
            $req_nom_paiement = mysql_query($sql_nom_paiement) or die ('Erreur SQL selection nom paiement');
            while ($nom_paiement = mysql_fetch_array($req_nom_paiement)){
                $paiement = $nom_paiement['nom'];
            }
        }
// On récupère l'horaire & date & type_article des spectacles pour l'afficher dans le recap
            // Horaire & date du spectacle 1
            $req_horaire_spectacle_1 = "SELECT a.article, a.horaire, a.date_spectacle, a.type_article, a.numero_representation, a.article, a.num
                                        FROM article a, abonnement_comm ac, bon_comm AS bc
                                        WHERE bc.num_bon = '$num_resa_1'
                                        AND bc.id_article = a.num";
            $horaire_spectacle_brut_1 = mysql_query( $req_horaire_spectacle_1 )or die( "Execution requete -req_horaire_spectacle_1- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_1))
                                            {
                                            $choix_spectacle_1 = $data['article'];
                                            $horaire_spectacle_1_vendu = $data['horaire'];
                                            $date1 = strtotime($data['date_spectacle']);
                                            $date_spectacle_1_vendu = date_fr('l d-m-Y', $date1);
                                            $type_spectacle_1_vendu = $data['type_article'];
                                            $numero_repre_spectacle_1_vendu = $data['numero_representation'];
                                            }

             // Horaire  & date du spectacle 2
            $req_horaire_spectacle_2 = "SELECT a.article, a.horaire, a.date_spectacle, a.type_article, a.numero_representation, a.article, a.num
                                        FROM article a, abonnement_comm ac, bon_comm AS bc
                                        WHERE bc.num_bon = '$num_resa_2'
                                        AND bc.id_article = a.num";
            $horaire_spectacle_brut_2 = mysql_query( $req_horaire_spectacle_2 )or die( "Execution requete -req_horaire_spectacle_2- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_2))
                                            {
                                            $choix_spectacle_2 = $data['article'];
                                            $horaire_spectacle_2_vendu = $data['horaire'];
                                            $date2 = strtotime($data['date_spectacle']);
                                            $date_spectacle_2_vendu = date_fr('l d-m-Y', $date2);
                                            $type_spectacle_2_vendu = $data['type_article'];
                                            $numero_repre_spectacle_2_vendu = $data['numero_representation'];
                                            }  
                                            
            // Horaire & date du spectacle 3
            $req_horaire_spectacle_3 = "SELECT a.article, a.horaire, a.date_spectacle, a.type_article, a.numero_representation, a.article, a.num
                                        FROM article a, abonnement_comm ac, bon_comm AS bc
                                        WHERE bc.num_bon = '$num_resa_3'
                                        AND bc.id_article = a.num";
            $horaire_spectacle_brut_3 = mysql_query( $req_horaire_spectacle_3 )or die( "Execution requete -req_horaire_spectacle_3- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_3))
                                            {
                                            $choix_spectacle_3 = $data['article'];
                                            $horaire_spectacle_3_vendu = $data['horaire'];
                                            $date3 = strtotime($data['date_spectacle']);
                                            $date_spectacle_3_vendu = date_fr('l d-m-Y', $date3);
                                            $type_spectacle_3_vendu = $data['type_article'];
                                            $numero_repre_spectacle_3_vendu = $data['numero_representation'];
                                            }                                            
                                            
            // Horaire & date du spectacle 4
            $req_horaire_spectacle_4 = "SELECT a.article, a.horaire, a.date_spectacle, a.type_article, a.numero_representation, a.article, a.num
                                        FROM article a, abonnement_comm ac, bon_comm AS bc
                                        WHERE bc.num_bon = '$num_resa_4'
                                        AND bc.id_article = a.num";
            $horaire_spectacle_brut_4 = mysql_query( $req_horaire_spectacle_4 )or die( "Execution requete -req_horaire_spectacle_4- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_4))
                                            {
                                              $choix_spectacle_4 = $data['article'];
                                            $horaire_spectacle_4_vendu = $data['horaire'];
                                            $date4 = strtotime($data['date_spectacle']);
                                            $date_spectacle_4_vendu = date_fr('l d-m-Y', $date4);
                                            $type_spectacle_4_vendu = $data['type_article'];
                                            $numero_repre_spectacle_4_vendu = $data['numero_representation'];
                                            }                                            
                                            
            // Horaire & date du spectacle 5
            $req_horaire_spectacle_5 = "SELECT a.article, a.horaire, a.date_spectacle, a.type_article, a.numero_representation, a.article, a.num
                                        FROM article a, abonnement_comm ac, bon_comm AS bc
                                        WHERE bc.num_bon = '$num_resa_5'
                                        AND bc.id_article = a.num";
            $horaire_spectacle_brut_5 = mysql_query( $req_horaire_spectacle_5 )or die( "Execution requete -req_horaire_spectacle_5- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_5))
                                            {
                                              $choix_spectacle_5 = $data['article'];
                                            $horaire_spectacle_5_vendu = $data['horaire'];
                                            $date5 = strtotime($data['date_spectacle']);
                                            $date_spectacle_5_vendu = date_fr('l d-m-Y', $date5);
                                            $type_spectacle_5_vendu = $data['type_article'];
                                            $numero_repre_spectacle_5_vendu = $data['numero_representation'];
                                            }                                            
                                            
            // Horaire & date du spectacle 6
            $req_horaire_spectacle_6 = "SELECT a.article, a.horaire, a.date_spectacle, a.type_article, a.numero_representation, a.article, a.num
                                        FROM article a, abonnement_comm ac, bon_comm AS bc
                                        WHERE bc.num_bon = '$num_resa_6'
                                        AND bc.id_article = a.num";
            $horaire_spectacle_brut_6 = mysql_query( $req_horaire_spectacle_6 )or die( "Execution requete -req_horaire_spectacle_6- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_6))
                                            {
                                              $choix_spectacle_6 = $data['article'];
                                            $horaire_spectacle_6_vendu = $data['horaire'];
                                            $date6 = strtotime($data['date_spectacle']);
                                            $date_spectacle_6_vendu = date_fr('l d-m-Y', $date6);
                                            $type_spectacle_6_vendu = $data['type_article'];
                                            $numero_repre_spectacle_6_vendu = $data['numero_representation'];
                                            }
                                            
            // Horaire & date du spectacle 7
            $req_horaire_spectacle_7 = "SELECT a.article, a.horaire, a.date_spectacle, a.type_article, a.numero_representation, a.article, a.num
                                        FROM article a, abonnement_comm ac, bon_comm AS bc
                                        WHERE bc.num_bon = '$num_resa_7'
                                        AND bc.id_article = a.num";
            $horaire_spectacle_brut_7 = mysql_query( $req_horaire_spectacle_7 )or die( "Execution requete -req_horaire_spectacle_7- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_7))
                                            {
                                              $choix_spectacle_7 = $data['article'];
                                            $horaire_spectacle_7_vendu = $data['horaire'];
                                            $date7 = strtotime($data['date_spectacle']);
                                            $date_spectacle_7_vendu = date_fr('l d-m-Y', $date7);
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
            <th> Numéro d'abonnement </th>  
            <th> Nom du spectateur   </th>  
            <th> Prénom du spectateur   </th>  
            <th> Abonnement choisi </th> 
            <th> Nombre de spectacles </th>
            <th> Total               </th>
            <th>Paiement</th>
            <th> Spectacle choix 1   </th>
            <th> Spectacle choix 2   </th>
            <th> Spectacle choix 3   </th>
            <th> Spectacle choix 4   </th>
            <th> Spectacle choix 5   </th>
            <th> Spectacle choix 6   </th>
            <th> Spectacle choix 7   </th>
            <th> Commentaire </th>
        <tr/>

        <tr>
            <td> <?php echo "$num_abo_com"; ?>   </td>
            <td> <?php echo $nom ; ?>            </td>
            <td> <?php echo $prenom ; ?>            </td>
            <td> <?php echo $nom_abonnement ;?>  </td>
            <td> <?php echo $nombre_spectacle ;?></td>
            <td> <?php echo $tarif_abonnement; echo"$devise"; ?></td>
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
            <td> <?php echo $commentaire; ?></td>
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
        
        
                <td>
                    <a href='edit_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>'><img border =0 src="image/edit.png" alt=""> <br> Modifier l'abonnement </a>
                </td>
                <td>
                    <form action="fpdf/abonnement_pdf.php" method="post" target="_blank" >
                                <input type="hidden" name="num_abo_com" value="<?php echo $num_abo_com ?>" />
                                <input type="hidden" name="user" value="adm" />
                                <input type="image" src="image/print.png" style=" border: none; margin: 0;" alt="<?php echo $lang_imprimer; ?>" Title="Imprimer"/><br />Imprimer l'abonnement
                    </form>
                
                <td>
                    <a href='dupliquer_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>' onclick="edition();return false;"><img border=0 src="image/duplicat.png"><br> Dupliquer l'abonnement </a>
                </td>        
        </tr> 
        
</table>




<?php
include_once("include/bas.php");
?>