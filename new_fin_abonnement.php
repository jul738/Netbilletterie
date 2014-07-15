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

// on récupère les info envoye par new_suite_abonnement.php & edit_abonnement
$num_abonnement=isset($_POST['num_abonnement'])?$_POST['num_abonnement']:"";
$num_client=isset($_POST['num_client'])?$_POST['num_client']:"";

//rajoute
$client=isset($_POST['client'])?$_POST['client']:"";
$num_abo_com=isset($_POST['num_abo_com'])?$_POST['num_abo_com']:"";
$nom=isset($_POST['nom'])?$_POST['nom']:"";
$paiement=isset($_POST['paiement'])?$_POST['paiement']:"";
$nombre_spectacle=isset($_POST['nombre_spectacle'])?$_POST['nombre_spectacle']:"";
$tarif_abonnement=isset($_POST['tarif_abonnement'])?$_POST['tarif_abonnement']:"";
$choix_spectacle_1_vendu=isset($_POST['liste_choix_spectacle_1'])?$_POST['liste_choix_spectacle_1']:"";
$choix_spectacle_2_vendu=isset($_POST['liste_choix_spectacle_2'])?$_POST['liste_choix_spectacle_2']:"";
$choix_spectacle_3_vendu=isset($_POST['liste_choix_spectacle_3'])?$_POST['liste_choix_spectacle_3']:"";
$choix_spectacle_4_vendu=isset($_POST['liste_choix_spectacle_4'])?$_POST['liste_choix_spectacle_4']:"";
$choix_spectacle_5_vendu=isset($_POST['liste_choix_spectacle_5'])?$_POST['liste_choix_spectacle_5']:"";
$choix_spectacle_6_vendu=isset($_POST['liste_choix_spectacle_6'])?$_POST['liste_choix_spectacle_6']:"";
$choix_spectacle_7_vendu=isset($_POST['liste_choix_spectacle_7'])?$_POST['liste_choix_spectacle_7']:"";

?>

<br/>
<br/>
<br/>
<br/>

<?php
            // On récupère l'horaire & date & type_article des spectacles pour l'afficher dans le recap
            // Horaire & date du spectacle 1
            $req_horaire_spectacle_1 = "SELECT horaire, date_spectacle, type_article
                                        FROM article
                                        WHERE num = '$choix_spectacle_1_vendu'";
            $horaire_spectacle_brut_1 = mysql_query( $req_horaire_spectacle_1 )or die( "Execution requete -req_horaire_spectacle_1- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_1))
                                            {
                                            $horaire_spectacle_1_vendu = $data['horaire'];
                                            $date_spectacle_1_vendu = $data['date_spectacle'];
                                            $type_spectacle_1_vendu = $data['type_article'];
                                            }

             // Horaire  & date du spectacle 2
            $req_horaire_spectacle_2 = "SELECT horaire, date_spectacle, type_article
                                        FROM article
                                        WHERE num = '$choix_spectacle_2_vendu'";
            $horaire_spectacle_brut_2 = mysql_query( $req_horaire_spectacle_2 )or die( "Execution requete -req_horaire_spectacle_2- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_2))
                                            {
                                            $horaire_spectacle_2_vendu = $data['horaire'];
                                            $date_spectacle_2_vendu = $data['date_spectacle'];
                                            $type_spectacle_2_vendu = $data['type_article'];
                                            }  
                                            
            // Horaire & date du spectacle 3
            $req_horaire_spectacle_3 = "SELECT horaire, date_spectacle, type_article
                                        FROM article
                                        WHERE num = '$choix_spectacle_3_vendu'";
            $horaire_spectacle_brut_3 = mysql_query( $req_horaire_spectacle_3 )or die( "Execution requete -req_horaire_spectacle_3- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_3))
                                            {
                                            $horaire_spectacle_3_vendu = $data['horaire'];
                                            $date_spectacle_3_vendu = $data['date_spectacle'];
                                            $type_spectacle_3_vendu = $data['type_article'];
                                            }                                            
                                            
            // Horaire & date du spectacle 4
            $req_horaire_spectacle_4 = "SELECT horaire, date_spectacle, type_article
                                        FROM article
                                        WHERE num = '$choix_spectacle_4_vendu'";
            $horaire_spectacle_brut_4 = mysql_query( $req_horaire_spectacle_4 )or die( "Execution requete -req_horaire_spectacle_4- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_4))
                                            {
                                            $horaire_spectacle_4_vendu = $data['horaire'];
                                            $date_spectacle_4_vendu = $data['date_spectacle'];
                                            $type_spectacle_4_vendu = $data['type_article'];
                                            }                                            
                                            
            // Horaire & date du spectacle 5
            $req_horaire_spectacle_5 = "SELECT horaire, date_spectacle, type_article
                                        FROM article
                                        WHERE num = '$choix_spectacle_5_vendu'";
            $horaire_spectacle_brut_5 = mysql_query( $req_horaire_spectacle_5 )or die( "Execution requete -req_horaire_spectacle_5- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_5))
                                            {
                                            $horaire_spectacle_5_vendu = $data['horaire'];
                                            $date_spectacle_5_vendu = $data['date_spectacle'];
                                            $type_spectacle_5_vendu = $data['type_article'];
                                            }                                            
                                            
            // Horaire & date du spectacle 6
            $req_horaire_spectacle_6 = "SELECT horaire, date_spectacle, type_article
                                        FROM article
                                        WHERE num = '$choix_spectacle_6_vendu'";
            $horaire_spectacle_brut_6 = mysql_query( $req_horaire_spectacle_6 )or die( "Execution requete -req_horaire_spectacle_6- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_6))
                                            {
                                            $horaire_spectacle_6_vendu = $data['horaire'];
                                            $date_spectacle_6_vendu = $data['date_spectacle'];
                                            $type_spectacle_6_vendu = $data['type_article'];
                                            }
                                            
            // Horaire & date du spectacle 7
            $req_horaire_spectacle_7 = "SELECT horaire, date_spectacle, type_article
                                        FROM article
                                        WHERE num = '$choix_spectacle_7_vendu'";
            $horaire_spectacle_brut_7 = mysql_query( $req_horaire_spectacle_7 )or die( "Execution requete -req_horaire_spectacle_7- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_7))
                                            {
                                            $horaire_spectacle_7_vendu = $data['horaire'];
                                            $date_spectacle_7_vendu = $data['date_spectacle'];
                                            $type_spectacle_7_vendu = $data['type_article'];
                                            }                                            
                                            
// On récupère le nom de chacun des spectacles en fonction de leur ID : 
                            //afficher le nom de l'abonnement choisi 
                            $req_nom_abonnement = "SELECT nom_abonnement 
                                                   FROM abonnement
                                                   WHERE num_abonnement = '$num_abonnement'";
                            $nom_abonnement_brut = mysql_query( $req_nom_abonnement )or die( "Execution requete -req_nom_abonnement- impossible.");

                              while($data = mysql_fetch_array($nom_abonnement_brut))
                                {
                                $nom_abonnement = $data['nom_abonnement'];
                                }

                            //Requete pour retenir le nom du spectacle en fonction de son ID
                                // Requete pour le choix numero 1
                            $req_recup_nom_spectacle_1 = "SELECT num, article
                                                          FROM article
                                                          WHERE num = '$choix_spectacle_1_vendu'";
                            $recup_nom_spectacle_1 = mysql_query( $req_recup_nom_spectacle_1 )or die( "Execution requete -req_recup_nom_spectacle_1- impossible.");

                              while($data = mysql_fetch_array($recup_nom_spectacle_1))
                                {
                                $nom_spectacle_1_vendu = $data['article'];
                                }

                                // Requete pour le choix numero 2
                            $req_recup_nom_spectacle_2 = "SELECT num, article
                                                          FROM article
                                                          WHERE num = '$choix_spectacle_2_vendu'";
                            $recup_nom_spectacle_2 = mysql_query( $req_recup_nom_spectacle_2 )or die( "Execution requete -req_recup_nom_spectacle_2- impossible.");

                              while($data = mysql_fetch_array($recup_nom_spectacle_2))
                                {
                                $nom_spectacle_2_vendu = $data['article'];
                                }

                                // Requete pour le choix numero 3
                            $req_recup_nom_spectacle_3 = "SELECT num, article
                                                          FROM article
                                                          WHERE num = '$choix_spectacle_3_vendu'";
                            $recup_nom_spectacle_3 = mysql_query( $req_recup_nom_spectacle_3 )or die( "Execution requete -req_recup_nom_spectacle_3- impossible.");

                              while($data = mysql_fetch_array($recup_nom_spectacle_3))
                                {
                                $nom_spectacle_3_vendu = $data['article'];
                                }

                                // Requete pour le choix numero 4
                            $req_recup_nom_spectacle_4 = "SELECT num, article
                                                          FROM article
                                                          WHERE num = '$choix_spectacle_4_vendu'";
                            $recup_nom_spectacle_4 = mysql_query( $req_recup_nom_spectacle_4 )or die( "Execution requete -req_recup_nom_spectacle_4- impossible.");

                              while($data = mysql_fetch_array($recup_nom_spectacle_4))
                                {
                                $nom_spectacle_4_vendu = $data['article'];
                                }    

                                // Requete pour le choix numero 5
                            $req_recup_nom_spectacle_5 = "SELECT num, article
                                                          FROM article
                                                          WHERE num = '$choix_spectacle_5_vendu'";
                            $recup_nom_spectacle_5 = mysql_query( $req_recup_nom_spectacle_5 )or die( "Execution requete -req_recup_nom_spectacle_5- impossible.");

                              while($data = mysql_fetch_array($recup_nom_spectacle_5))
                                {
                                $nom_spectacle_5_vendu = $data['article'];
                                } 

                                // Requete pour le choix numero 6
                            $req_recup_nom_spectacle_6 = "SELECT num, article
                                                          FROM article
                                                          WHERE num = '$choix_spectacle_6_vendu'";
                            $recup_nom_spectacle_6 = mysql_query( $req_recup_nom_spectacle_6 )or die( "Execution requete -req_recup_nom_spectacle_6- impossible.");

                              while($data = mysql_fetch_array($recup_nom_spectacle_6))
                                {
                                $nom_spectacle_6_vendu = $data['article'];
                                } 

                                // Requete pour le choix numero 7
                            $req_recup_nom_spectacle_7 = "SELECT num, article
                                                          FROM article
                                                          WHERE num = '$choix_spectacle_7_vendu'";
                            $recup_nom_spectacle_7 = mysql_query( $req_recup_nom_spectacle_7 )or die( "Execution requete -req_recup_nom_spectacle_7- impossible.");

                              while($data = mysql_fetch_array($recup_nom_spectacle_7))
                                {
                                $nom_spectacle_7_vendu = $data['article'];
                                }     

// on recupere le nom du moyen de paiement
                                $req_recup_nom_paiement = "SELECT tp.nom, tp.id_type_paiement
                                                           FROM type_paiement tp
                                                           WHERE tp.id_type_paiement ='$paiement'";
                                $recup_nom_paiement_brut = mysql_query( $req_recup_nom_paiement )or die( "Execution requete -req_recup_nom_paiement- impossible.");
                                 while($data = mysql_fetch_array($recup_nom_paiement_brut))
                                        {
                                  $paiement_nom = $data['nom'];
                                        }     


// On met à jour la BDD -> en rentrent le nom du spectacle mais aussi sont ID, on peu maintenant recuperer un spectacle qui a le meme nom mais pas la meme horaire -> representation
$req_choix_spectacle ="UPDATE abonnement_comm 
                       SET quanti = '$quanti', choix_spectacle_1 = '$nom_spectacle_1_vendu', num_spectacle_1 = '$choix_spectacle_1_vendu' , choix_spectacle_2 = '$nom_spectacle_2_vendu', num_spectacle_2 = '$choix_spectacle_2_vendu' , choix_spectacle_3 = '$nom_spectacle_3_vendu', num_spectacle_3 = '$choix_spectacle_3_vendu' , choix_spectacle_4 = '$nom_spectacle_4_vendu', num_spectacle_4 = '$choix_spectacle_4_vendu' , choix_spectacle_5 = '$nom_spectacle_5_vendu', num_spectacle_5 = '$choix_spectacle_5_vendu' , choix_spectacle_6 = '$nom_spectacle_6_vendu', num_spectacle_6 = '$choix_spectacle_6_vendu' , choix_spectacle_7 = '$nom_spectacle_7_vendu', num_spectacle_7 = '$choix_spectacle_7_vendu'
                       WHERE num_abo_com = $num_abo_com";
mysql_query($req_choix_spectacle) or die('Erreur SQL  req_choix_spectacle !<br>'.$req_choix_spectacle.'<br>'.mysql_error());

$quanti = 1 ; // le nombre de billet a decrementer du stock (article)

//ici on decremnte le stock
    //Pour le Spectacle 1
    $sql122 = "UPDATE article SET stock = (stock - $quanti) WHERE num = '$choix_spectacle_1_vendu'";
    mysql_query($sql122) or die('Erreur SQL122 !<br>'.$sql122.'<br>'.mysql_error());
        //Pour le spectacle 2
        $sql13 = "UPDATE article SET stock = (stock - $quanti) WHERE num = '$choix_spectacle_2_vendu'";
        mysql_query($sql13) or die('Erreur SQL13 !<br>'.$sql13.'<br>'.mysql_error());
            //Pour le spectacle 3
            $sql14 = "UPDATE article SET stock = (stock - $quanti) WHERE num = '$choix_spectacle_3_vendu'";
            mysql_query($sql14) or die('Erreur SQL14 !<br>'.$sql14.'<br>'.mysql_error());
                //Pour le spectacle 4
                $sql15 = "UPDATE article SET stock = (stock - $quanti) WHERE num = '$choix_spectacle_4_vendu'";
                mysql_query($sql15) or die('Erreur SQL15 !<br>'.$sql15.'<br>'.mysql_error());
                    //Pour le spectacle 5
                    $sql16 = "UPDATE article SET stock = (stock - $quanti) WHERE num = '$choix_spectacle_5_vendu'";
                    mysql_query($sql16) or die('Erreur SQL16 !<br>'.$sql16.'<br>'.mysql_error());
                        //Pour le spectacle 6
                        $sql17 = "UPDATE article SET stock = (stock - $quanti) WHERE num = '$choix_spectacle_6_vendu'";
                        mysql_query($sql17) or die('Erreur SQL17 !<br>'.$sql17.'<br>'.mysql_error());
                            //Pour le spectacle 7
                            $sql18 = "UPDATE article SET stock = (stock - $quanti) WHERE num = '$choix_spectacle_7_vendu'";
                            mysql_query($sql18) or die('Erreur SQL18 !<br>'.$sql18.'<br>'.mysql_error());

?>
<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
                    <h3>L'abonnement de <?php echo"$nom"; ?> a bien ete enregistre. </h3>	
                </td>
        </tr>
        <tr>
		<td>
	      		<table class="boiteaction">
	  			<caption> Recapitulatif de la vente de l'abonnement :</caption>
                </td>
                
	<tr>
            <th> Numero d'abonnement </th>  
            <th> Nom du spectateur </th>  
            <th> Abonnement choisie </th> 
            <th> Nombre de spetacles </th>
            <th> Total </th>
            <th>Moyen de paiement</th>
            <th> Spectacle choix 1 </th>
            <th> Spectacle choix 2 </th>
            <th> Spectacle choix 3 </th>
            <th> Spectacle choix 4 </th>
            <th> Spectacle choix 5 </th>
            <th> Spectacle choix 6 </th>
            <th> Spectacle choix 7 </th>
        <tr/>

        <tr>
            <td> <?php echo "$num_abo_com"; ?></td>
            <td> <?php echo $nom ; ?></td>
            <td> <?php echo $nom_abonnement ;?></td>
            <td> <?php echo $nombre_spectacle ;?></td>
            <td> <?php $total = $quanti * $tarif_abonnement ; echo "$total"; echo"$devise"; ?></td>
            <td><?php echo $paiement_nom ;?></td>
        
            <td>    <b> <?php echo"$nom_spectacle_1_vendu" ; ?> </b><br/> <br/>
                        <?php echo"$horaire_spectacle_1_vendu" ;?>  <br/> <br/>
                        <?php echo"$date_spectacle_1_vendu" ; ?>    <br/> <br/>          
            </td>
            
            <td>    <b> <?php echo"$nom_spectacle_2_vendu" ; ?> </b> <br/> <br/>
                        <?php echo"$horaire_spectacle_2_vendu" ; ?>  <br/> <br/>
                        <?php echo"$date_spectacle_2_vendu" ; ?>     <br/> <br/>
            </td>
             
            <td>   <b>  <?php echo"$nom_spectacle_3_vendu" ; ?> </b> <br/> <br/>
                        <?php echo"$horaire_spectacle_3_vendu" ; ?>  <br/> <br/>
                        <?php echo"$date_spectacle_3_vendu" ; ?>     <br/> <br/>
            </td>
             
            <td>  <b>   <?php echo"$nom_spectacle_4_vendu" ; ?> </b> <br/> <br/>
                        <?php echo"$horaire_spectacle_4_vendu" ; ?>  <br/> <br/>
                        <?php echo"$date_spectacle_4_vendu" ; ?>     <br/> <br/>
            </td>
              
            <td>  <b>  <?php echo"$nom_spectacle_5_vendu" ; ?> </b> <br/> <br/>
                       <?php echo"$horaire_spectacle_5_vendu" ; ?>  <br/> <br/>
                       <?php echo"$date_spectacle_5_vendu" ; ?>     <br/> <br/>
            </td>
               
            <td>  <b> <?php echo"$nom_spectacle_6_vendu" ; ?> </b>  <br/> <br/>
                      <?php echo"$horaire_spectacle_6_vendu" ; ?>   <br/> <br/>
                      <?php echo"$date_spectacle_6_vendu" ; ?>      <br/> <br/>
            </td>
               
               
            <td> <b> <?php echo"$nom_spectacle_7_vendu" ; ?>   </b> <br/> <br/>
                     <?php echo"$horaire_spectacle_7_vendu" ; ?>    <br/> <br/>
                     <?php echo"$date_spectacle_7_vendu" ; ?>       <br/> <br/>
            </td>
        </tr>   
        
<?php
        //on calcule les information concernant la tva
$tva = 0 ;
$total_tva = ($total * 1) - $total ;
$total_ttc = $total + $total_tva  ;
$total_ht = $total ;

//on recupere la date d aujourd hui
$date_vente = date('Y-m-d');     
 
//On enregistre la vente dans la table abonnement_paiement
$req_creation_vente = "INSERT INTO abonnement_paiement (num_abo_com, num_client, paiement, quantite, total_ttc, total_tva, total_ht, date_vente, id_abonnement)
                       VALUES ('$num_abo_com', '$num_client', '$paiement', '$quanti', '$total', '$total_tva', '$total_ht', '$date_vente', '$num_abonnement')";
mysql_query($req_creation_vente) or die('Erreur SQL !<br>'.$req_creation_vente.'<br>'.mysql_error());
?>
        
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
        </tr> 

</table>

<!--
<h3>Imprimer l'abonnement : 
                <a href="print_ticket_abo.php?num_abo_com=<?php // echo"$numero_vente_abo";?>" onclick="edition();return false;"><img border=0 src= image/billetterie_v2.png ></a></h3> 
-->		

<?php
include_once("include/bas.php");
?>