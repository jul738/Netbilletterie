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
            $req_info_abonnement = "SELECT num_abo_com, client_num, date_debut, date_fin, ctrl, fact, paiement, ac.num_abonnement, ac.date, nombre_place, num_resa_1, num_resa_2, num_resa_3, num_resa_4, num_resa_5, num_resa_6, num_resa_7, tarif_abonnement, nom_abonnement, nom, prenom
                         FROM abonnement_comm AS ac, abonnement AS a, client AS c
                         WHERE num_abo_com = '$num_abo_com'
                         AND ac.num_abonnement = a.num_abonnement
                         AND ac.client_num = c.num_client";

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
                                            $num_resa_1_duplique = $data4['num_resa_1'];
                                            $num_resa_2_duplique = $data4['num_resa_2'];
                                            $num_resa_3_duplique = $data4['num_resa_3'];
                                            $num_resa_4_duplique = $data4['num_resa_4'];
                                            $num_resa_5_duplique = $data4['num_resa_5'];
                                            $num_resa_6_duplique = $data4['num_resa_6'];
                                            $num_resa_7_duplique = $data4['num_resa_7']; 
                                            $total_duplique = $data4['tarif_abonnement'];
                                            $nom_duplique = $data4['nom'];
                                            $prenom_duplique = $data5['prenom'];
                                            }
                                             
                                    // On récupère le nom du paiement 
                                    if ((!empty($paiement)) || ($paiement == 'non')){
                                        $sql_nom_paiement = "SELECT nom FROM type_paiement AS id_type_paiement = '$paiement'";
                                        $req_nom_paiement = mysql_query($sql_nom_paiement) or die ('Erreur SQL selection nom paiement');
                                        while ($nom_paiement = mysql_fetch_array($req_nom_paiement)){
                                            $paiement = $nom_paiement['nom'];
                                        }
                                    }
                                            
                        //recup info spectacle horaire & date pour le spectacle 1
                        $req_info_article_1 = "SELECT a.num, a.article, a.horaire, a.date_spectacle
                                        FROM article a, abonnement_comm ac, bon_comm AS bc
                                        WHERE bc.num_bon = '$num_resa_1_duplique'
                                        AND bc.id_article = a.num";
                        $recup_info_article_1 = mysql_query($req_info_article_1)or die("Execution requete -recup_info_article_1- impossible.");
                                                       while($data6 = mysql_fetch_array($recup_info_article_1))
                                                            {
                                                            $num_spectacle_1_duplique = $data6['num'];
                                                            $article_1_duplique = $data6['article'];
                                                            $horaire_1_duplique = $data6['horaire'];
                                                            $date_spectacle_1_duplique = $data6['date_spectacle'];
                                                            }
                                                            
                        //recup info spectacle horaire & date pour le spectacle 2
                        $req_info_article_2 = "SELECT a.num, a.article, a.horaire, a.date_spectacle
                                        FROM article a, abonnement_comm ac, bon_comm AS bc
                                        WHERE bc.num_bon = '$num_resa_2_duplique'
                                        AND bc.id_article = a.num";
                        $recup_info_article_2 = mysql_query($req_info_article_2)or die("Execution requete -recup_info_article_2- impossible.");
                                                       while($data7 = mysql_fetch_array($recup_info_article_2))
                                                            {
                                                            $num_spectacle_2_duplique = $data7['num'];
                                                            $article_2_duplique = $data7['article'];
                                                            $horaire_2_duplique = $data7['horaire'];
                                                            $date_spectacle_2_duplique = $data7['date_spectacle'];
                                                            }
                        
                        //recup info spectacle horaire & date pour le spectacle 3
                        $req_info_article_3 = "SELECT a.num, a.article, a.horaire, a.date_spectacle
                                        FROM article a, abonnement_comm ac, bon_comm AS bc
                                        WHERE bc.num_bon = '$num_resa_3_duplique'
                                        AND bc.id_article = a.num";
                        $recup_info_article_3 = mysql_query($req_info_article_3)or die("Execution requete -recup_info_article_3- impossible.");
                                                       while($data8 = mysql_fetch_array($recup_info_article_3))
                                                            {
                                                            $num_spectacle_3_duplique = $data8['num'];
                                                            $article_3_duplique = $data8['article'];
                                                            $horaire_3_duplique = $data8['horaire'];
                                                            $date_spectacle_3_duplique = $data8['date_spectacle'];
                                                            }
                                                            
                        //recup info spectacle horaire & date pour le spectacle 4
                        $req_info_article_4 = "SELECT a.num, a.article, a.horaire, a.date_spectacle
                                        FROM article a, abonnement_comm ac, bon_comm AS bc
                                        WHERE bc.num_bon = '$num_resa_4_duplique'
                                        AND bc.id_article = a.num";
                        $recup_info_article_4 = mysql_query($req_info_article_4)or die("Execution requete -recup_info_article_4- impossible.");
                                                       while($data9 = mysql_fetch_array($recup_info_article_4))
                                                            {
                                                            $num_spectacle_4_duplique = $data9['num'];
                                                            $article_4_duplique = $data9['article'];
                                                            $horaire_4_duplique = $data9['horaire'];
                                                            $date_spectacle_4_duplique = $data9['date_spectacle'];
                                                            }
                                                            
                        //recup info spectacle horaire & date pour le spectacle 5
                        $req_info_article_5 = "SELECT a.num, a.article, a.horaire, a.date_spectacle
                                        FROM article a, abonnement_comm ac, bon_comm AS bc
                                        WHERE bc.num_bon = '$num_resa_5_duplique'
                                        AND bc.id_article = a.num";
                        $recup_info_article_5 = mysql_query($req_info_article_5)or die("Execution requete -recup_info_article_5- impossible.");
                                                       while($data10 = mysql_fetch_array($recup_info_article_5))
                                                            {
                                                            $num_spectacle_5_duplique = $data10['num'];
                                                            $article_5_duplique = $data10['article'];
                                                            $horaire_5_duplique = $data10['horaire'];
                                                            $date_spectacle_5_duplique = $data10['date_spectacle'];
                                                            }
                                                            
                        //recup info spectacle horaire & date pour le spectacle 6
                        $req_info_article_6 = "SELECT a.num, a.article, a.horaire, a.date_spectacle
                                        FROM article a, abonnement_comm ac, bon_comm AS bc
                                        WHERE bc.num_bon = '$num_resa_6_duplique'
                                        AND bc.id_article = a.num";
                        $recup_info_article_6 = mysql_query($req_info_article_6)or die("Execution requete -recup_info_article_6- impossible.");
                                                       while($data11 = mysql_fetch_array($recup_info_article_6))
                                                            {
                                                            $num_spectacle_6_duplique = $data11['num'];
                                                            $article_6_duplique = $data11['article'];
                                                            $horaire_6_duplique = $data11['horaire'];
                                                            $date_spectacle_6_duplique = $data11['date_spectacle'];
                                                            }
                                                            
                        //recup info spectacle horaire & date pour le spectacle 7
                        $req_info_article_7 = "SELECT a.num, a.article, a.horaire, a.date_spectacle
                                        FROM article a, abonnement_comm ac, bon_comm AS bc
                                        WHERE bc.num_bon = '$num_resa_7_duplique'
                                        AND bc.id_article = a.num";
                        $recup_info_article_7 = mysql_query($req_info_article_7)or die("Execution requete -recup_info_article_7- impossible.");
                                                       while($data12 = mysql_fetch_array($recup_info_article_7))
                                                            {
                                                            $num_spectacle_7_duplique = $data12['num'];
                                                            $article_7_duplique = $data12['article'];
                                                            $horaire_7_duplique = $data12['horaire'];
                                                            $date_spectacle_7_duplique = $data12['date_spectacle'];
                                                            }
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
            
                <SELECT NAME='client_num_nouveaux'>
                    <OPTION VALUE="">Renseigner nouveaux nom</OPTION>
<?php
                        while ( $row = mysql_fetch_array( $result)) 
                            {
                            $numclient = $row["num_client"];
                            $nom = $row["nom"];
                            $nom2 = $row["nom2"];
                            $prenom = $row["prenom"];
?>
                    <OPTION VALUE='<?php echo $numclient; ?>'><?php echo $nom;?> <?php echo $prenom ;?></OPTION>
<?php
                        } // fin du while (liste spectateur)
?>
                </SELECT>
        </td>
            <td> <?php echo $nom_abonnement_duplique ;?></td>
            <td> <?php echo $nombre_place_duplique ;?></td>
            <td> <?php  echo  $total_duplique ; echo $devise ; ?></td>
            <td><?php echo $paiement ;?></td>
            
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

?>
        
        <tr> 
	    <td class="submit" colspan="13">
                <input name="num_abonnement_duplique" value="<?php echo $num_abonnement_duplique ;?>" type="hidden">
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
