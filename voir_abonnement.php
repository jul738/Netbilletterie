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

Ceci est le $num_bon_com : <?php echo $num_abo_com ; ?> </br>

<?php
// On récupère toutes les information sur la vente en fonction du numero de vente de l'abonnement 
$req_recup_info_vente = "SELECT num_abo_com, client_num, num_abonnement, date, quanti, nombre_place, choix_spectacle_1, choix_spectacle_2, choix_spectacle_3, choix_spectacle_4, choix_spectacle_5, choix_spectacle_6, choix_spectacle_7 
                         FROM abonnement_comm
                         WHERE num_abo_com = '$num_abo_com'";
$recup_info_vente_brut = mysql_query($req_recup_info_vente) or die ( "Execution requete -req_recup_info_vente- impossible.");
           
    while($data = mysql_fetch_array($recup_info_vente_brut))
    {
    $client_num = $data['client_num'];
    $date = $data['date'];
    $quanti = $data['quanti'];
    $nombre_spectacle = $data['nombre_place'];
    $num_abonnement = $data['num_abonnement'];
    $choix_spectacle_1 = $data['choix_spectacle_1'];
    $choix_spectacle_2 = $data['choix_spectacle_2'];
    $choix_spectacle_3 = $data['choix_spectacle_3'];
    $choix_spectacle_4 = $data['choix_spectacle_4'];
    $choix_spectacle_5 = $data['choix_spectacle_5'];
    $choix_spectacle_6 = $data['choix_spectacle_6'];    
    $choix_spectacle_7 = $data['choix_spectacle_7'];    
    }
    
// On fais des requetes pour récupérer les information des différente table en utilisant les variable récup au dessus (ex : nom spectacle, nom spectateur, prix abo, ect)

// Nom spectateur
$req_recup_nom_spec = "SELECT num_client, nom
                       FROM client
                       WHERE num_client = '$client_num'";
$recup_nom_spec_brut = mysql_query($req_recup_nom_spec) or die ( "Execution requete -req_recup_nom_spec- impossible.");      
    while($data = mysql_fetch_array($recup_nom_spec_brut))
    {
    $nom = ['nom'];    
    }
    
// recup Nom abonnement & nombre_spectacle
$req_recup_abo = "SELECT num_abonnement, nom_abonnement, tarif_abonnement
                  FROM abonnement 
                  WHERE num_abonnement = '$num_abonnement'";
$recup_abo_brut = mysql_query($req_recup_abo) or die ( "Execution requete -req_recup_abo- impossible.");      
    while($data = mysql_fetch_array($recup_abo_brut))
    {
    $nom_abonnement = ['nom_abonnement'];
    $tarif_abonnement = ['tarif_abonnement'];
    }

// récup horaire spectacle choix & date & nom
    
    // Pour le spectacle numero 1    
    $req_recup_article_1 = "SELECT num, article, type_article, date_spectacle, horaire 
                            FROM article
                            WHERE num = '$choix_spectacle_1'";
    $recup_article_brut_1 = mysql_query($req_recup_article_1 ) or die ( "Execution requete -req_recup_article_1 - impossible.");      
        while($data = mysql_fetch_array($recup_article_brut_1))
        {
        $num_spectacle_1 = ['num'];
        $nom_spectacle_1 = ['article'];
        $type_spectacle_1 = ['type_article'];
        $date_spectacle_1 = ['date_spectacle'];
        $horaire_spectacle_1 = ['horaire'];
        }

?>

<br/>
<br/>
<br/>
<br/>

<!--
    <table align="center">
        <tr> 
            <th> <h3> Test des variables : </h3> </th>    
        </tr>
        <tr>
            <th>$quanti (d'abonnement) = <?php // echo "$quanti"; ?> </th>
        </tr>
        <tr>
            <th>$num_abonnement (id abonnement, recup page precedent) = <?php // echo "$num_abonnement"; ?> </th>
        </tr>
        <tr>
            <th> $num_client (id client) = <?php // echo "$num_client"; ?> </th>
                <tr>
            <th> $client : <?php // echo $client ; ?> </th>
        </tr>
        </tr>
            <tr>
            <th> $nom (nom du client) = <?php // echo "$nom"; ?> </th>
        </tr>
        <tr>
            <th> $nom_abonnement : <?php // echo  $nom_abonnement ; ?> </th>
        </tr>
        <tr>
            <th> $num_abo_com (id vente de l'abonnement) = <?php // echo $num_abo_com; ?> </th>
        </tr>
        <tr>
            <th> $tarif_abonnement : <?php // echo $tarif_abonnement ;?></th>
        </tr>
            <tr>
            <th> $nombre_spectacle : <?php // echo $nombre_spectacle ;?></th>
        </tr>
    </table>
-->


<?php
            // On récupère l'horaire & date & type_article des spectacles pour l'afficher dans le recap
            // Horaire & date du spectacle 1
            $req_horaire_spectacle_1 = "SELECT horaire, date_spectacle, type_article
                                        FROM article
                                        WHERE num = ' $choix_spectacle_1'";
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
                                        WHERE num = ' $choix_spectacle_2'";
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
                                        WHERE num = ' $choix_spectacle_3'";
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
                                        WHERE num = ' $choix_spectacle_4'";
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
                                        WHERE num = ' $choix_spectacle_5'";
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
                                        WHERE num = ' $choix_spectacle_6'";
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
                                        WHERE num = ' $choix_spectacle_7'";
            $horaire_spectacle_brut_7 = mysql_query( $req_horaire_spectacle_7 )or die( "Execution requete -req_horaire_spectacle_7- impossible.");

                                          while($data = mysql_fetch_array($horaire_spectacle_brut_7))
                                            {
                                            $horaire_spectacle_7_vendu = $data['horaire'];
                                            $date_spectacle_7_vendu = $data['date_spectacle'];
                                            $type_spectacle_7_vendu = $data['type_article'];
                                            }                                            
                                            
// On récupère le prix de l'abonnement choisie
$req_prix_abonnement = "SELECT tarif_abonnement
                        FROM abonnement
                       WHERE num_abonnement = '$num_abonnement'";
$prix_abonnement_brut = mysql_query( $req_prix_abonnement )or die( "Execution requete -req_prix_abonnement- impossible.");

                             while($data = mysql_fetch_array($prix_abonnement_but))
                             {
                              $tarif_abonnement = $data['tarif_abonnement'];
                             }

// On récupère le nom de chacun des spectacles en fonction de leur ID : 
                            //afficher le nom de l'abonnement choisi 
                            $req_nom_abonnement = "SELECT nom_abonnement 
                                                   FROM abonnement
                                                   WHERE num_abonnement = $num_abonnement ";
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

//On insert la liste des choix spectacle dans la BDD grace au variable de la req du dessus             
//$req_choix_spectacle ="INSERT INTO abonnement_comm (choix_spectacle_1, choix_spectacle_2, choix_spectacle_3, choix_spectacle_4, choix_spectacle_5, choix_spectacle_6, choix_spectacle_7)
//                              VALUES ('$nom_spectacle_1_vendu', '$nom_spectacle_2_vendu', '$nom_spectacle_3_vendu', '$nom_spectacle_4_vendu','$nom_spectacle_5_vendu', '$nom_spectacle_6_vendu', '$nom_spectacle_7_vendu')";
//mysql_query($req_choix_spectacle) or die('Erreur SQL !<br>'.$req_choix_spectacle.'<br>'.mysql_error());

                                
// On met à jour la BDD 
$req_choix_spectacle ="UPDATE abonnement_comm 
                       SET quanti = '$quanti', choix_spectacle_1 = '$nom_spectacle_1_vendu' , choix_spectacle_2 = '$nom_spectacle_2_vendu' , choix_spectacle_3 = '$nom_spectacle_3_vendu' , choix_spectacle_4 = '$nom_spectacle_4_vendu' , choix_spectacle_5 = '$nom_spectacle_5_vendu' , choix_spectacle_6 = '$nom_spectacle_6_vendu' , choix_spectacle_7 = '$nom_spectacle_7_vendu'
                       WHERE num_abo_com = $num_abo_com";
mysql_query($req_choix_spectacle) or die('Erreur SQL !<br>'.$req_choix_spectacle.'<br>'.mysql_error());


?>
<div class="page">
<h3> L'abonnement de <?php echo"$nom"; ?> a bien ete enregistre. </h3>

<table border="0" class="page" align="center">

    <caption>Recapitulatif de la vente de l'abonnement :</caption>  
    
    <tr>
        <th>Numero d'abonnement</th>  
        <th>Nom du spectateur</th>  
        <th> Abonnement choisie</th> 
        <th>Nombre de spetacles que comprend cette abonnement</th>
        <th>Total</th> 
        <th>Liste des spectacles choisie</th>  <br/><br/> 
        <th>Horaires</th>
        <th>Dates</th>
    <tr/>
    <tr>
        <th> <?php echo "$num_abo_com" ; ?></th>
        <th> <?php echo $nom ; ?></th>
        <th> <?php echo $nom_abonnement ;?></th>
        <th> <?php echo $nombre_spectacle ;?></th>
        <th> <?php echo "$tarif_abonnement" ; ?> x <?php echo "$quanti"; ?> = <?php $total = $quanti * $tarif_abonnement ; echo "$total"; echo"$devise"; ?></th>
        
        <th> 
            </br>   <?php echo"$nom_spectacle_1_vendu" ; ?> <br/> <br/> 
                    <?php echo"$nom_spectacle_2_vendu" ; ?> <br/> <br/> 
                    <?php echo"$nom_spectacle_3_vendu" ; ?> <br/><br/> 
                    <?php echo"$nom_spectacle_4_vendu" ; ?> <br/> <br/> 
                    <?php echo"$nom_spectacle_5_vendu" ; ?> <br/> <br/> 
                    <?php echo"$nom_spectacle_6_vendu" ; ?> <br/> <br/> 
                    <?php echo"$nom_spectacle_7_vendu" ; ?> 
        </th>
        <th> 
            </br>   <?php echo"$horaire_spectacle_1_vendu" ; ?> <br/> <br/>
                    <?php echo"$horaire_spectacle_2_vendu" ; ?> <br/> <br/> 
                    <?php echo"$horaire_spectacle_3_vendu" ; ?> <br/> <br/> 
                    <?php echo"$horaire_spectacle_4_vendu" ; ?> <br/> <br/> 
                    <?php echo"$horaire_spectacle_5_vendu" ; ?> <br/> <br/> 
                    <?php echo"$horaire_spectacle_6_vendu" ; ?> <br/> <br/>   
                    <?php echo"$horaire_spectacle_7_vendu" ; ?> <br/> <br/>        
        </th>
        <th>
             </br>  <?php echo"$date_spectacle_1_vendu" ; ?> <br/> <br/>
                    <?php echo"$date_spectacle_2_vendu" ; ?> <br/> <br/> 
                    <?php echo"$date_spectacle_3_vendu" ; ?> <br/> <br/> 
                    <?php echo"$date_spectacle_4_vendu" ; ?> <br/> <br/> 
                    <?php echo"$date_spectacle_5_vendu" ; ?> <br/> <br/> 
                    <?php echo"$date_spectacle_6_vendu" ; ?> <br/> <br/>   
                    <?php echo"$date_spectacle_7_vendu" ; ?> <br/> <br/> 
        </th>
    </tr>   
</table>

<!--
<h3>Imprimer l'abonnement : 
                <a href="print_ticket_abo.php?num_abo_com=<?php // echo"$numero_vente_abo";?>" onclick="edition();return false;"><img border=0 src= image/billetterie_v2.png ></a></h3> 
-->		

        <form action='lister_abonnement.php'> <br/>
            <input type="submit" name="Submit" value="Lister les abonnement" onclick="self.location.href='new_abonnement.php'"><br/><br/>
        </form>

        <!-- Bouton edit modifie l'abonnement en cour -->
        <form>
        <td><a href='edit_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>' >
        <img border="0" alt="voir" src="image/edit.png" Title="Modifier l'abonnement"></a></td>
        </form>
        
<!-- Bouton pour créer un nouvel  -->
        <form action='new_abonnement.php'> <br/>
            <input type="submit" name="Submit" value="Ajouter un autre abonnement" onclick="self.location.href='new_abonnement.php'"><br/><br/>
        </form>
</div>

<?php
include_once("include/bas.php");
?>