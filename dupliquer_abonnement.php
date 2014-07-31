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

$num_abo_com=isset($_GET['num_abo_com'])?$_GET['num_abo_com']:"";

            //Recuperation des information sur la vente de abonnement
            $req_info_abonnement = "SELECT ac.client_num, ac.ctrl, ac.fact, ac.paiement, ac.nombre_place, ac.num_spectacle_1, ac.num_spectacle_2, ac.num_spectacle_3, ac.num_spectacle_4, ac.num_spectacle_5, ac.num_spectacle_6, ac.num_spectacle_7, a.nom_abonnement, a.num_abonnement, a.tarif_abonnement
                                    FROM abonnement_comm AS ac, abonnement AS a
                                    WHERE ac.num_abo_com = '$num_abo_com'
                                    AND ac.num_abonnement = a.num_abonnement";
            $recup_info_abonnement = mysql_query( $req_info_abonnement )or die( "Execution requete -recup_info_abonnement- impossible.");
                                        while($data4 = mysql_fetch_array($recup_info_abonnement))
                                            {
                                            $nom_abonnement_duplique = $data4['nom_abonnement'];
                                            $num_abonnement_duplique = $data4['num_abonnement'];
                                            $tarif_abonnement_duplique = $data4['tarif_abonnement'];
                                            $client_num_duplique = $data4['client_num'];
                                            $paiement_duplique = $data4['paiement'];
                                            $fact_duplique = $data4['fact'];
                                            $ctrl_duplique = $data4['ctrl'];
                                            $client_num_duplique = $data4['client_num'];
                                            $nombre_place_duplique = $data4['nombre_place'];
                                            $num_spectacle_1_duplique = $data4['num_spectacle_1'];
                                            $num_spectacle_2_duplique = $data4['num_spectacle_2'];
                                            $num_spectacle_3_duplique = $data4['num_spectacle_3'];
                                            $num_spectacle_4_duplique = $data4['num_spectacle_4'];
                                            $num_spectacle_5_duplique = $data4['num_spectacle_5'];
                                            $num_spectacle_6_duplique = $data4['num_spectacle_6'];
                                            $num_spectacle_7_duplique = $data4['num_spectacle_7'];                                            
                                            }
                                             
                                            
                         //recupe nom client a qui on a duplique son abonnement
                         $req_info_client = "SELECT nom, prenom
                                             FROM client
                                             WHERE num_client = '$client_num_duplique'";
               $recup_info_client = mysql_query( $req_info_client )or die( "Execution requete -req_info_client- impossible.");
                                        while($data5 = mysql_fetch_array($recup_info_client))
                                            {
                                            $nom_duplique = $data5['nom'];
                                            $prenom_duplique = $data5['prenom'];
                                            }

                                            
               //recup total dans abonnement_paiement
               $req_info_montant_paiement = "SELECT total_ttc
                                             FROM abonnement_paiement
                                             WHERE num_abo_com = '$num_abo_com'";
               $recup_info_montant_paiement = mysql_query($req_info_montant_paiement)or die("Execution requete -req_info_montant_paiement- impossible.");
                                              while($data6 = mysql_fetch_array($recup_info_montant_paiement))
                                                   {
                                                   $total_duplique = $data6['total_ttc'];
                                                   }
                         
                                                   
                                                                                               
                        //recup info spectacle horaire & date pour le spectacle 1
                        $req_info_article_1 = "SELECT article, horaire, date_spectacle
                                             FROM article
                                             WHERE num = '$num_spectacle_1_duplique'";
                        $recup_info_article_1 = mysql_query($req_info_article_1)or die("Execution requete -recup_info_article_1- impossible.");
                                                       while($data6 = mysql_fetch_array($recup_info_article_1))
                                                            {
                                                            $article_1_duplique = $data6['article'];
                                                            $horaire_1_duplique = $data6['horaire'];
                                                            $date_spectacle_1_duplique = $data6['date_spectacle'];
                                                            }
                                                            
                        //recup info spectacle horaire & date pour le spectacle 2
                        $req_info_article_2 = "SELECT article, horaire, date_spectacle
                                             FROM article
                                             WHERE num = '$num_spectacle_2_duplique'";
                        $recup_info_article_2 = mysql_query($req_info_article_2)or die("Execution requete -recup_info_article_2- impossible.");
                                                       while($data7 = mysql_fetch_array($recup_info_article_2))
                                                            {
                                                            $article_2_duplique = $data7['article'];
                                                            $horaire_2_duplique = $data7['horaire'];
                                                            $date_spectacle_2_duplique = $data7['date_spectacle'];
                                                            }
                        
                        //recup info spectacle horaire & date pour le spectacle 3
                        $req_info_article_3 = "SELECT article, horaire, date_spectacle
                                             FROM article
                                             WHERE num = '$num_spectacle_3_duplique'";
                        $recup_info_article_3 = mysql_query($req_info_article_3)or die("Execution requete -recup_info_article_3- impossible.");
                                                       while($data8 = mysql_fetch_array($recup_info_article_3))
                                                            {
                                                            $article_3_duplique = $data8['article'];
                                                            $horaire_3_duplique = $data8['horaire'];
                                                            $date_spectacle_3_duplique = $data8['date_spectacle'];
                                                            }
                                                            
                        //recup info spectacle horaire & date pour le spectacle 4
                        $req_info_article_4 = "SELECT article, horaire, date_spectacle
                                             FROM article
                                             WHERE num = '$num_spectacle_4_duplique'";
                        $recup_info_article_4 = mysql_query($req_info_article_4)or die("Execution requete -recup_info_article_4- impossible.");
                                                       while($data9 = mysql_fetch_array($recup_info_article_4))
                                                            {
                                                            $article_4_duplique = $data9['article'];
                                                            $horaire_4_duplique = $data9['horaire'];
                                                            $date_spectacle_4_duplique = $data9['date_spectacle'];
                                                            }
                                                            
                        //recup info spectacle horaire & date pour le spectacle 5
                        $req_info_article_5 = "SELECT article, horaire, date_spectacle
                                             FROM article
                                             WHERE num = '$num_spectacle_5_duplique'";
                        $recup_info_article_5 = mysql_query($req_info_article_5)or die("Execution requete -recup_info_article_5- impossible.");
                                                       while($data10 = mysql_fetch_array($recup_info_article_5))
                                                            {
                                                            $article_5_duplique = $data10['article'];
                                                            $horaire_5_duplique = $data10['horaire'];
                                                            $date_spectacle_5_duplique = $data10['date_spectacle'];
                                                            }
                                                            
                        //recup info spectacle horaire & date pour le spectacle 6
                        $req_info_article_6 = "SELECT article, horaire, date_spectacle
                                             FROM article
                                             WHERE num = '$num_spectacle_6_duplique'";
                        $recup_info_article_6 = mysql_query($req_info_article_6)or die("Execution requete -recup_info_article_6- impossible.");
                                                       while($data11 = mysql_fetch_array($recup_info_article_6))
                                                            {
                                                            $article_6_duplique = $data11['article'];
                                                            $horaire_6_duplique = $data11['horaire'];
                                                            $date_spectacle_6_duplique = $data11['date_spectacle'];
                                                            }
                                                            
                        //recup info spectacle horaire & date pour le spectacle 7
                        $req_info_article_7 = "SELECT article, horaire, date_spectacle
                                             FROM article
                                             WHERE num = '$num_spectacle_7_duplique'";
                        $recup_info_article_7 = mysql_query($req_info_article_7)or die("Execution requete -recup_info_article_7- impossible.");
                                                       while($data12 = mysql_fetch_array($recup_info_article_7))
                                                            {
                                                            $article_7_duplique = $data12['article'];
                                                            $horaire_7_duplique = $data12['horaire'];
                                                            $date_spectacle_7_duplique = $data12['date_spectacle'];
                                                            }
?>


<?php

//ici on decremnte le stock
    //Pour le Spectacle 1
    $sql122 = "UPDATE article SET stock = (stock - 1) WHERE num = '$num_spectacle_1_duplique'";
    mysql_query($sql122) or die('Erreur SQL122 !<br>'.$sql122.'<br>'.mysql_error());
        //Pour le spectacle 2
        $sql13 = "UPDATE article SET stock = (stock - 1) WHERE num = '$num_spectacle_2_duplique'";
        mysql_query($sql13) or die('Erreur SQL13 !<br>'.$sql13.'<br>'.mysql_error());
            //Pour le spectacle 3
            $sql14 = "UPDATE article SET stock = (stock - 1) WHERE num = '$num_spectacle_3_duplique'";
            mysql_query($sql14) or die('Erreur SQL14 !<br>'.$sql14.'<br>'.mysql_error());
                //Pour le spectacle 4
                $sql15 = "UPDATE article SET stock = (stock - 1) WHERE num = '$num_spectacle_4_duplique'";
                mysql_query($sql15) or die('Erreur SQL15 !<br>'.$sql15.'<br>'.mysql_error());
                    //Pour le spectacle 5
                    $sql16 = "UPDATE article SET stock = (stock - 1) WHERE num = '$num_spectacle_5_duplique'";
                    mysql_query($sql16) or die('Erreur SQL16 !<br>'.$sql16.'<br>'.mysql_error());
                        //Pour le spectacle 6
                        $sql17 = "UPDATE article SET stock = (stock - 1) WHERE num = '$num_spectacle_6_duplique'";
                        mysql_query($sql17) or die('Erreur SQL17 !<br>'.$sql17.'<br>'.mysql_error());
                            //Pour le spectacle 7
                            $sql18 = "UPDATE article SET stock = (stock - 1) WHERE num = '$num_spectacle_7_duplique'";
                            mysql_query($sql18) or die('Erreur SQL18 !<br>'.$sql18.'<br>'.mysql_error());

?>
<table border="0" class="page" align="center">
	<tr>
        
		<td class="page" align="center">
                    <h3>Vous avez duplique l'abonnement de <?php echo $nom_duplique ;?> <?php echo $prenom_duplique ;?> : </h3>	
                </td>
        </tr>
        <tr>
		<td>
	      		<table class="boiteaction">
                            
                    <form action="new_fin_abonnement.php" method="post" name="abonnement_duplique">
                                
	  			<caption> Veuillez renseigne les modifications :</caption>
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
            
                                        
            <td> <?php echo  $num_abo_com ; ?></td>
             
        <td class="texte0" >
<?php
            $rqSql = "SELECT num_client, nom, prenom, nom2 FROM " . $tblpref ."client WHERE actif != 'n' AND `num_client`!='1'";
            if ($user_com == r) 
                {
            $rqSql = "SELECT num_client, nom, prenom
                      FROM " . $tblpref ."client 
                      WHERE actif != 'n' AND `num_client`!='1'
                      and (" . $tblpref ."client.permi LIKE '$user_num,'
                      or " . $tblpref ."client.permi LIKE '%,$user_num,'
                      or " . $tblpref ."client.permi LIKE '%,$user_num,%'
                      or " . $tblpref ."client.permi LIKE '$user_num,%')";
                }
            
        $rqSql="$rqSql order by nom";
        $result = mysql_query( $rqSql ) or die( "Execution requete impossible.");
?>
            
                <SELECT NAME='listeville'>
                    <OPTION VALUE="">Renseigner nouveaux nom</OPTION>
<?php
                        while ( $row = mysql_fetch_array( $result)) 
                            {
                            $numclient = $row["num_client"];
                            $nom = $row["nom"];
                            $nom2 = $row["nom2"];
                            $prenom = $row["prenom"];
?>
                    <OPTION VALUE='<?php echo $client_num_nouveaux; ?>'><?php echo $nom;?> <?php echo $prenom ;?></OPTION>
<?php
                        } // fin du while (liste spectateur)
?>
                </SELECT>
        </td>
            <td> <?php echo $nom_abonnement_duplique ;?></td>
            <td> <?php echo $nombre_place_duplique ;?></td>
            <td> <?php  echo  $total_duplique ; echo $devise ; ?></td>
            <td><?php echo $paiement_duplique ;?></td>
            
            <td>    <b> <?php echo $article_1_duplique ; ?>           </b><br/> <br/>
                        <?php echo $horaire_1_duplique ;?>            <br/> <br/>
                        <?php echo $date_spectacle_1_duplique  ; ?>    <br/> <br/>          
            </td>
            
            <td>    <b> <?php echo $article_2_duplique  ; ?>           </b><br/> <br/>
                        <?php echo $horaire_2_duplique  ;?>            <br/> <br/>
                        <?php echo $date_spectacle_2_duplique  ; ?>    <br/> <br/>          
            </td>
             
            <td>    <b> <?php echo $article_3_duplique  ; ?>           </b><br/> <br/>
                        <?php echo $horaire_3_duplique  ;?>            <br/> <br/>
                        <?php echo $date_spectacle_3_duplique  ; ?>    <br/> <br/>          
            </td>
             
            <td>    <b> <?php echo $article_4_duplique  ; ?>           </b><br/> <br/>
                        <?php echo $horaire_4_duplique  ;?>            <br/> <br/>
                        <?php echo $date_spectacle_4_duplique ; ?>    <br/> <br/>          
            </td>
              
            <td>    <b> <?php echo $article_5_duplique  ; ?>           </b><br/> <br/>
                        <?php echo $horaire_5_duplique  ;?>            <br/> <br/>
                        <?php echo $date_spectacle_5_duplique  ; ?>    <br/> <br/>          
            </td>
               
            <td>    <b> <?php echo $article_6_duplique  ; ?>           </b><br/> <br/>
                        <?php echo $horaire_6_duplique  ;?>            <br/> <br/>
                        <?php echo $date_spectacle_6_duplique  ; ?>    <br/> <br/>          
            </td>
               
               
            <td>    <b> <?php echo $article_7_duplique  ; ?>           </b><br/> <br/>
                        <?php echo $horaire_7_duplique  ;?>            <br/> <br/>
                        <?php echo $date_spectacle_7_duplique  ; ?>    <br/> <br/>          
            </td>
        </tr>   

<?php
//on calcule les information concernant la tva
$tva = 0 ;
$total_tva = ($total * 1) - $total ;
$total_ttc = $total + $total_tva  ;
$total_ht = $total ;

//on recupere les info date
   $date_vente = date('Y-m-d');     
   $jour =date("d");
   $date_ref="$mois-$jour";
   $mois = date("m");
   $annee = date("Y");
   $date_debut = date('Y-m-d');
   $date_fin = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " + 365 day")); 

//On ajoute cette vente d'abonnement dans la bdd
// num_abo_com / client_num / date /date_debut / date_fin / user / soir / tot_tva / attente / ctrl / fact / date_fact / paiement / comment / num_abonnement / banque / titulaire_cheque / print / nombre_place / choix_spectacle_1 / num_spectacle_1  
$req_vente_duplication = "INSERT INTO abonnement_comm (client_num, date, date_debut, date_fin, ctrl, fact, paiement, num_abonnement, nombre_place, num_spectacle_1, num_spectacle_2, num_spectacle_3, num_spectacle_4, num_spectacle_5, num_spectacle_6, num_spectacle_7)
                          VALUES ('$client_num_duplique', '$annee-$mois-$jour', '$date_debut', '$date_fin', '$ctrl_duplique', '$fact_duplique', '$paiement_duplique', '$num_abonnement_duplique', '$nombre_place_duplique', '$num_spectacle_1_duplique', '$num_spectacle_2_duplique', '$num_spectacle_3_duplique', '$num_spectacle_4_duplique', '$num_spectacle_5_duplique', '$num_spectacle_6_duplique', '$num_spectacle_7_duplique')";
mysql_query($req_vente_duplication) or die('Erreur SQL role . INSERT INTO !<br>'.$req_vente_duplication.'<br>'.mysql_error());                                         
//ensuite faire sur page d'apres un update si $duplication est present, trouv facon recup ceux num_abo_com du dupliq a pas lautre

//On enregistre la vente dans la table abonnement_paiement
$req_creation_vente = "INSERT INTO abonnement_paiement (num_client, paiement, total_ttc, total_tva, total_ht, date_vente, id_abonnement)
                       VALUES ('$client_num_duplique', '$paiement_duplique', '$total', '$total_tva', '$total_ht', '$date_vente', '$num_abonnement_duplique')";
mysql_query($req_creation_vente) or die('Erreur SQL !<br>'.$req_creation_vente.'<br>'.mysql_error());

?>
        
        <tr> 
	    <td class="submit" colspan="13">
                <input name="num_abonnement_duplique" value="<?php echo $num_abonnement_duplique ;?>" type="hidden">
                <input name="client_num_nouveaux" value="<?php echo $client_num_nouveaux ;?>" type="hidden">
                <!-- <input name="client" value="<?php //echo  $client ;?>" type="hidden"> -->
                <input name="num_abo_com" value="<?php echo $num_abo_com ;?>" type="hidden">
                <input name="nom_duplique" value="<?php echo $nom_duplique ;?>" type="hidden">
                <input name="paiement_duplique" value="<?php echo $paiement_duplique ;?>" type="hidden">
                <input name="nombre_place_duplique" value="<?php echo $nombre_place_duplique ;?>" type="hidden">
                <input name="tarif_abonnement_duplique" value="<?php echo $tarif_abonnement_duplique ;?>" type="hidden">
                <input name="num_spectacle_1_duplique" value="<?php echo $num_spectacle_1_duplique ;?>" type="hidden">
                <input name="num_spectacle_2_duplique" value="<?php echo $num_spectacle_2_duplique ;?>" type="hidden">
                <input name="num_spectacle_3_duplique" value="<?php echo $num_spectacle_3_duplique ;?>" type="hidden">
                <input name="num_spectacle_4_duplique" value="<?php echo $num_spectacle_4_duplique ;?>" type="hidden">
                <input name="num_spectacle_5_duplique" value="<?php echo $num_spectacle_5_duplique ;?>" type="hidden">
                <input name="num_spectacle_6_duplique" value="<?php echo $num_spectacle_6_duplique ;?>" type="hidden">
                <input name="num_spectacle_7_duplique" value="<?php echo $num_spectacle_7_duplique ;?>" type="hidden">
                <input name="duplication" value="1" type="hidden">
		<input type="image" name="Submit" src="image/valider.png" value="Demarrer"  border="0">              
            </td>
	</tr>
        </form>

        </table>
</table>
       

<?php
include_once("include/bas.php");
?>
