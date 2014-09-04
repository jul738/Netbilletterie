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


$date = date('Y-m-d');
$date_debut = date('Y-m-d');
$date_fin = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " + 365 day"));

//Si duplication insertion des infos dans les tables
$duplication = isset($_POST['duplication'])?$_POST['duplication']:NULL;
if (isset($duplication))
    {
    // On recupere les information de la duplication 
    $num_abonnement=isset($_POST['num_abonnement_duplique'])?$_POST['num_abonnement_duplique']:"";
    $num_client=isset($_POST['client_num_nouveaux'])?$_POST['client_num_nouveaux']:""; //Le numero client du spectateur pour qui on a dupliquer labonnement (nouveaux possedant)
    $paiement=isset($_POST['paiement_duplique'])?$_POST['paiement_duplique']:"";
    $nombre_spectacle=isset($_POST['nombre_place_duplique'])?$_POST['nombre_place_duplique']:"";
    $tarif_abonnement=isset($_POST['tarif_abonnement_duplique'])?$_POST['tarif_abonnement_duplique']:"";
    $choix_spectacle_1_vendu=isset($_POST['num_spectacle_1_duplique'])?$_POST['num_spectacle_1_duplique']:"";
    $choix_spectacle_2_vendu=isset($_POST['num_spectacle_2_duplique'])?$_POST['num_spectacle_2_duplique']:"";
    $choix_spectacle_3_vendu=isset($_POST['num_spectacle_3_duplique'])?$_POST['num_spectacle_3_duplique']:"";
    $choix_spectacle_4_vendu=isset($_POST['num_spectacle_4_duplique'])?$_POST['num_spectacle_4_duplique']:"";
    $choix_spectacle_5_vendu=isset($_POST['num_spectacle_5_duplique'])?$_POST['num_spectacle_5_duplique']:"";
    $choix_spectacle_6_vendu=isset($_POST['num_spectacle_6_duplique'])?$_POST['num_spectacle_6_duplique']:"";
    $choix_spectacle_7_vendu=isset($_POST['num_spectacle_7_duplique'])?$_POST['num_spectacle_7_duplique']:"";
    //On recupere le nom et le prenom du nouveau client a qui on a fais un duplication d'abonnement
    $req_nouveau_info_client = "SELECT nom, prenom
                                  FROM client
                                  WHERE num_client = '$num_client'";
    $req_nouveau_info_client_brut = mysql_query( $req_nouveau_info_client )or die( "Execution requete -req_nouveau_info_client- impossible.");

                                          while($data = mysql_fetch_array($req_nouveau_info_client_brut))
                                            {
                                            $nom = $data['nom'];
                                            $prenom = $data['prenom'];
                                            }

        // On crée l'abonnement dans la table
        $req_vente_duplication = "INSERT INTO abonnement_comm (client_num, date, date_debut, date_fin, num_abonnement, user, nombre_place)
                                  VALUES ('$num_client', '$date', '$date_debut', '$date_fin', '$num_abonnement', '$user_nom', '$nombre_spectacle')";
        mysql_query($req_vente_duplication) or die('Erreur SQL role . INSERT INTO !<br>'.$req_vente_duplication.'<br>'.mysql_error());                                         
        //On récupère l'id de l'abonnement que l'on vient de créer
        $sql_num_abo = "SELECT num_abo_com FROM abonnement_comm ORDER BY num_abo_com DESC LIMIT 1";
        $result_num_abo = mysql_query($sql_num_abo) OR DIE ('Erreur SQL récupération id resa');
                while($data_abo = mysql_fetch_array($result_num_abo))
                    {
                        $num_abo_com = $data_abo['num_abo_com'];
                    }
                    }

    else
        {  
        // on récupère les info envoye par new_suite_abonnement.php & edit_abonnement
        $num_abonnement=isset($_POST['num_abonnement'])?$_POST['num_abonnement']:"";
        $num_client=isset($_POST['num_client'])?$_POST['num_client']:"";
        $num_abo_com=isset($_POST['num_abo_com'])?$_POST['num_abo_com']:"";
        //rajoute
        $client=isset($_POST['client'])?$_POST['client']:"";
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
        $commentaire = isset($_POST['commentaire'])?$_POST['commentaire']:"";
        } //Fin du else
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

 
    //ici on decremnte le stock
    //Pour le Spectacle 1
    $sql122 = "UPDATE article SET stock = (stock - 1) WHERE num = '$choix_spectacle_1_vendu'";
    mysql_query($sql122) or die('Erreur SQL122 !<br>'.$sql122.'<br>'.mysql_error());
        //Pour le spectacle 2
    $sql13 = "UPDATE article SET stock = (stock - 1) WHERE num = '$choix_spectacle_2_vendu'";
    mysql_query($sql13) or die('Erreur SQL13 !<br>'.$sql13.'<br>'.mysql_error());
    //Pour le spectacle 3
    $sql14 = "UPDATE article SET stock = (stock - 1) WHERE num = '$choix_spectacle_3_vendu'";
    mysql_query($sql14) or die('Erreur SQL14 !<br>'.$sql14.'<br>'.mysql_error());
    //Pour le spectacle 4
    $sql15 = "UPDATE article SET stock = (stock - 1) WHERE num = '$choix_spectacle_4_vendu'";
    mysql_query($sql15) or die('Erreur SQL15 !<br>'.$sql15.'<br>'.mysql_error());
    //Pour le spectacle 5
    $sql16 = "UPDATE article SET stock = (stock - 1) WHERE num = '$choix_spectacle_5_vendu'";
    mysql_query($sql16) or die('Erreur SQL16 !<br>'.$sql16.'<br>'.mysql_error());
    //Pour le spectacle 6
    $sql17 = "UPDATE article SET stock = (stock - 1) WHERE num = '$choix_spectacle_6_vendu'";
    mysql_query($sql17) or die('Erreur SQL17 !<br>'.$sql17.'<br>'.mysql_error());
    //Pour le spectacle 7
    $sql18 = "UPDATE article SET stock = (stock - 1) WHERE num = '$choix_spectacle_7_vendu'";
    mysql_query($sql18) or die('Erreur SQL18 !<br>'.$sql18.'<br>'.mysql_error());
          
       // On crée les réservations associées
       if(!empty($choix_spectacle_1_vendu)){	
            $sql1 = "INSERT INTO " . $tblpref ."bon_comm(client_num, date, id_tarif, user, id_article) VALUES ('$num_client', '$date', '26', '$user_nom', '$choix_spectacle_1_vendu')";
            mysql_query($sql1) or die('Erreur SQL création réservation !<br>'.$sql1.'<br>'.mysql_error());
            // On récupère l'id de la résa créée
            $sql1_resa = "SELECT num_bon FROM bon_comm ORDER BY num_bon DESC LIMIT 1";
            $result_resa1 = mysql_query($sql1_resa) OR DIE ('Erreur SQL récupération id resa');
                while($data_resa1 = mysql_fetch_array($result_resa1))
                    {
                        $num_resa_1 = $data_resa1['num_bon'];
                    }
       }
       if(!empty($choix_spectacle_2_vendu)){		
            $sql2 = "INSERT INTO " . $tblpref ."bon_comm(client_num, date, id_tarif, user, id_article) VALUES ('$num_client', '$date', '26', '$user_nom', '$choix_spectacle_2_vendu')";
            mysql_query($sql2) or die('Erreur SQL création réservation !<br>'.$sql2.'<br>'.mysql_error());
                        // On récupère l'id de la résa créée
            $sql2_resa = "SELECT num_bon FROM bon_comm ORDER BY num_bon DESC LIMIT 1";
            $result_resa2 = mysql_query($sql2_resa) OR DIE ('Erreur SQL récupération id resa');
                while($data_resa2 = mysql_fetch_array($result_resa2))
                    {
                $num_resa_2 = $data_resa2['num_bon'];
                    }
       }
       if(!empty($choix_spectacle_3_vendu)){		
            $sql3 = "INSERT INTO " . $tblpref ."bon_comm(client_num, date, id_tarif, user, id_article) VALUES ('$num_client', '$date', '26', '$user_nom', '$choix_spectacle_3_vendu')";
            mysql_query($sql3) or die('Erreur SQL création réservation !<br>'.$sql3.'<br>'.mysql_error());
                        // On récupère l'id de la résa créée
            $sql3_resa = "SELECT num_bon FROM bon_comm ORDER BY num_bon DESC LIMIT 1";
            $result_resa3 = mysql_query($sql3_resa) OR DIE ('Erreur SQL récupération id resa');
                while($data_resa3 = mysql_fetch_array($result_resa3))
                    {
                $num_resa_3 = $data_resa3['num_bon'];
                    }
       }
       if(!empty($choix_spectacle_4_vendu)){		
            $sql4 = "INSERT INTO " . $tblpref ."bon_comm(client_num, date, id_tarif, user, id_article) VALUES ('$num_client', '$date', '26', '$user_nom', '$choix_spectacle_4_vendu')";
            mysql_query($sql4) or die('Erreur SQL création réservation !<br>'.$sql4.'<br>'.mysql_error());
                        // On récupère l'id de la résa créée
            $sql4_resa = "SELECT num_bon FROM bon_comm ORDER BY num_bon DESC LIMIT 1";
            $result_resa4 = mysql_query($sql4_resa) OR DIE ('Erreur SQL récupération id resa');
                while($data_resa4 = mysql_fetch_array($result_resa4))
                    {
                        $num_resa_4 = $data_resa4['num_bon'];
                    }
       }
       if(!empty($choix_spectacle_5_vendu)){		
            $sql5 = "INSERT INTO " . $tblpref ."bon_comm(client_num, date, id_tarif, user, id_article) VALUES ('$num_client', '$date', '26', '$user_nom', '$choix_spectacle_5_vendu')";
            mysql_query($sql5) or die('Erreur SQL création réservation !<br>'.$sql5.'<br>'.mysql_error());
                        // On récupère l'id de la résa créée
            $sql5_resa = "SELECT num_bon FROM bon_comm ORDER BY num_bon DESC LIMIT 1";
            $result_resa5 = mysql_query($sql5_resa) OR DIE ('Erreur SQL récupération id resa');
                while($data_resa5 = mysql_fetch_array($result_resa5))
                    {
                        $num_resa_5 = $data_resa5['num_bon'];
                    }
       }
       if(!empty($choix_spectacle_6_vendu)){		
            $sql6 = "INSERT INTO " . $tblpref ."bon_comm(client_num, date, id_tarif, user, id_article) VALUES ('$num_client', '$date', '26', '$user_nom', '$choix_spectacle_6_vendu')";
            mysql_query($sql6) or die('Erreur SQL création réservation !<br>'.$sql6.'<br>'.mysql_error());
                        // On récupère l'id de la résa créée
            $sql6_resa = "SELECT num_bon FROM bon_comm ORDER BY num_bon DESC LIMIT 1";
            $result_resa6 = mysql_query($sql6_resa) OR DIE ('Erreur SQL récupération id resa');
                while($data_resa6 = mysql_fetch_array($result_resa6))
                    {
                        $num_resa_6 = $data_resa6['num_bon'];
                    }
       }
       if(!empty($choix_spectacle_7_vendu)){		
            $sql7 = "INSERT INTO " . $tblpref ."bon_comm(client_num, date, id_tarif, user, id_article) VALUES ('$num_client', '$date', '26', '$user_nom', '$choix_spectacle_7_vendu')";
            mysql_query($sql7) or die('Erreur SQL création réservation !<br>'.$sql7.'<br>'.mysql_error());
                        // On récupère l'id de la résa créée
            $sql7_resa = "SELECT num_bon FROM bon_comm ORDER BY num_bon DESC LIMIT 1";
            $result_resa7 = mysql_query($sql7_resa) OR DIE ('Erreur SQL récupération id resa');
                while($data_resa7 = mysql_fetch_array($result_resa7))
                    {
                        $num_resa_7 = $data_resa7['num_bon'];
                    }
       }

    // On met à jour la BDD -> en rentrent l'id de la réservation, on peu maintenant recuperer un spectacle qui a le meme nom mais pas la meme horaire -> representation
    $req_choix_spectacle ="UPDATE ".$tblpref."abonnement_comm 
                           SET num_resa_1 = '$num_resa_1' , num_resa_2 = '$num_resa_2' , num_resa_3 = '$num_resa_3', num_resa_4 = '$num_resa_4', num_resa_5 = '$num_resa_5' , num_resa_6 = '$num_resa_6', num_resa_7 = '$num_resa_7', paiement = '$paiement', commentaire = '$commentaire'
                           WHERE num_abo_com = '$num_abo_com'";
    mysql_query($req_choix_spectacle) or die('Erreur SQL  req_choix_spectacle !<br>'.$req_choix_spectacle.'<br>'.mysql_error());
   
        
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
            <th> Numéro d'abonnement </th>  
            <th> Nom du spectateur </th>  
            <th> Abonnement choisi </th> 
            <th> Nombre de spectacles </th>
            <th> Total </th>
            <th>Moyen de paiement</th>
            <th> Spectacle choix 1 </th>
            <th> Spectacle choix 2 </th>
            <th> Spectacle choix 3 </th>
            <th> Spectacle choix 4 </th>
            <th> Spectacle choix 5 </th>
            <th> Spectacle choix 6 </th>
            <th> Spectacle choix 7 </th>
            <th> Commentaire </th>
        <tr/>

        <tr>
            <td> <?php echo "$num_abo_com"; ?></td>
            <td> <?php echo $nom ; ?></td>
            <td> <?php echo $nom_abonnement ;?></td>
            <td> <?php echo $nombre_spectacle ;?></td>
            <td> <?php $total = $tarif_abonnement ; echo "$total"; echo"$devise"; ?></td>
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
            <td>
                <?php echo $commentaire; ?>
            </td>
        </tr>   
        
<?php
//on calcule les information concernant la tva --> LA MAISON POUR TOUS NE PAYE PAS DE TVA <--
$tva = 0 ;
$total_tva = ($total * 1) - $total ;
$total_ttc = $total + $total_tva  ;
$total_ht = $total ;

//on recupere la date d aujourd hui
$date_vente = date('Y-m-d');     
?>
        
        </table>
</table> 

<table border="0" class="page" align="center">

        <tr>
                <td> 
                    <a href='new_abonnement.php'><img border =0 src="image/new_mini_abonnement.png" alt=""> <br> Ajouter un nouvel d'abonnement </a>
                </td>

                <td>
                    <a href='lister_abonnement.php'><img border =0 src="image/lister_abonnement_gris.png" alt=""> <br> Lister les differentes abonnements </a>
                </td>
                      
                <td>
                    <a href='edit_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>'><img border =0 src="image/edit.png" alt=""> <br> Modifier l'abonnement </a>
                </td>
                
                <td>
                    <a href='dupliquer_abonnement.php?num_abo_com=<?php echo "$num_abo_com"; ?>' onclick="edition();return false;"><img border=0 src="image/duplicat.png"><br> Dupliquer l'abonnement </a>
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
