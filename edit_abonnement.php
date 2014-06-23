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

//On recupere l'ID de l'abonnement
$num_abo_com=isset($_GET['num_abo_com'])?$_GET['num_abo_com']:"";

?>
Test variable : <br/>
Ceci est le numero de vente de l'abonnement :  <?php echo $num_abo_com; ?> <br/><br/><br/>

        <?php
// choix de l'abonnement (à renseigner dans $num_abonnement_new)
        $rqSql3= "SELECT num_abonnement, nom_abonnement, tarif_abonnement, nombre_spectacle
                  FROM abonnement";
        $result3 = mysql_query( $rqSql3 )or die( mysql_error()."Execution requete -rqSql3- impossible.");?>

<form method='post' action='new_fin_abonnement.php'>
<table align="center">
    <caption>Recomposer l'abonnement</caption>
    <tr>
        <th class="texte0" colspan='2'>
        <SELECT NAME='num_abonnement'>
            <OPTION VALUE="">Choisir l'<?php echo "$lang_abonnement";?></OPTION>
            <?php
            while ( $row = mysql_fetch_array( $result3))
                  {
            $num_abonnement = $row["num_abonnement"];
            $nom_abonnement = $row["nom_abonnement"];
            $tarif_abonnement = $row["tarif_abonnement"];
            ?>
            <OPTION VALUE='<?php echo $num_abonnement; ?>'><?php echo "$nom_abonnement $tarif_abonnement $devise "; ?></OPTION>
            <?php }
            
                if ($user_admin != 'n')
                {                
                //tarif gratuit pour admin
                $sqltarifgratuit = "SELECT nom_tarif, prix_tarif, id_tarif, DATE_FORMAT(saison, '%d/%m/%Y' ) AS date
                                    FROM ".$tblpref."tarif
                                    WHERE saison
                                    BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
                                    AND nom_tarif='gratuit'";
                $reqtarifgratuit = mysql_query($sqltarifgratuit) or die('Erreur SQLtarifgratuit !<br>'.$sqltarifgratuit.'<br>'.mysql_error());
                        while($data = mysql_fetch_array($reqtarifgratuit))
                        {
                        $nom_tarif = $data['nom_tarif'];
                        $prix_tarif = $data['prix_tarif'];
                        $num_tarif =$data['id_tarif'];
            ?>
            <OPTION VALUE='<?php echo $num_abonnement; ?>'><?php echo "$nom_abonnement $tarif_abonnement $devise "; ?></OPTION>
        </SELECT>
        </th>
    </tr>
            <?php
                        } // fin du while
                } //fin du if ?>


            <!-- saisir quantite ($quanti) -->
    <tr>
            <th>Choisir la quantite : 
                      <input type="text" name="quanti" value="1" SIZE="1"></th>
    </tr>
    <tr>
            <th>
            <?php
            // Choisir les spectacles (renseigner dans $nom_spectacle_x_vendu)
                      $rqSql = "SELECT ac.num_abo_com , ab.nombre_spectacle
                                FROM abonnement AS ab, abonnement_comm AS ac
                                WHERE ac.num_abo_com = '$num_abo_com'
                                AND ab.num_abonnement = ac.num_abonnement ";
           $result = mysql_query( $rqSql )or die( "Execution requete -rqSql- impossible.");
           
            $i=1;
            while ( $row = mysql_fetch_array( $result)) 
            {
               // $num_abonnement_test = $row["num_abonnement"];
                $nombre_spectacle= $row["nombre_spectacle"];
                
                //On affiche un champs  select pour chaque spectacle
                
              
                    for($nb = 1; $nb <= $nombre_spectacle; $nb++)
                            {
                                
                            ?>
                                <SELECT name='liste_choix_spectacle_<?php echo $nb;?>'>
                                <OPTION VALUE="">Choisir un spectacle</OPTION>
                                
                                <?php
                                 // lister les numero et les nom des spectacle active (meme ceux complet)
                                $sql_liste_article = "SELECT num, article, type_article, horaire, date_spectacle
                                                      FROM article 
                                                      WHERE actif != 'non'";
                                $liste_article = mysql_query( $sql_liste_article )or die( "Execution requete -liste_article- impossible.");

                                while ( $liste_spectacle = mysql_fetch_array( $liste_article))  
                                {
                                    $liste_spectacle_contenu_nom = $liste_spectacle["article"];
                                    $liste_spectacle_contenu_num = $liste_spectacle["num"];
                                    $liste_spectacle_contenu_type_article = $liste_spectacle["type_article"];
                                    $liste_spectacle_contenu_horaire = $liste_spectacle["horaire"];
                                    $liste_spectacle_contenu_date = $liste_spectacle["date_spectacle"];                                    
                                    ?>
                                    <OPTION VALUE='<?php echo $liste_spectacle_contenu_num; ?>'><?php echo $liste_spectacle_contenu_type_article; ?> : <?php echo $liste_spectacle_contenu_nom; ?> / <?php echo $liste_spectacle_contenu_horaire; ?> / <?php echo $liste_spectacle_contenu_date; ?></OPTION>
                                    <?php
                                }
                                ?>
                                </SELECT>
                            <?php  
                            } // fin de la boucle for

            }
            ?>
                </th>
    </tr>
-> Verifier les variables avant requete update ! 
            <?php
            //Mise a jour de la vente de l'abonnement //Update sur new_fin_abonnement /!\
            //$req_update_abonnement = "UPDATE abonnement_comm 
            //                          SET quanti = '$quanti', choix_spectacle_1 = 'liste_choix_spectacle_1', choix_spectacle_2 = 'liste_choix_spectacle_2', choix_spectacle_3 = 'liste_choix_spectacle_3', choix_spectacle_4 = 'liste_choix_spectacle_4', choix_spectacle_5 = 'liste_choix_spectacle_5', choix_spectacle_6 = 'liste_choix_spectacle_6', choix_spectacle_7 = 'liste_choix_spectacle_7'
            //                          WHERE num_abo_com = $num_abo_com";
            //$update_abonnement = mysql_query($req_update_abonnement) or die('Erreur Req_liste_abo !<br>'.$req_update_abonnement.'<br>'.mysql_error());
            
            
//On récupère les information sur la vente de l'abonnement pour les envoier au récap : new_fin_abonnement
$req_recup_info_abonnement = "SELECT ac.num_abonnement, a.nom_abonnement, c.num_client, c.nom
                              FROM abonnement_comm ac, client c, abonnement a
                              WHERE ac.num_abo_com = '$num_abo_com'
                              AND ac.client_num = c.num_client
                              AND a.num_abonnement = ac.num_abonnement";
$recup_info_abonnement_brut = mysql_query( $req_recup_info_abonnement )or die( "Execution requete -req_recup_info_abonnement- impossible.");

                              while($data = mysql_fetch_array($recup_info_abonnement_brut))
                                {
                                $num_abonnement = $data['num_abonnement'];
                                $nom_abonnement = $data['nom_abonnement'];
                                $num_client = $data['num_client'];
                                $nom = $data['nom'];
                                }
            ?>
    <tr>
        <th> <input  name="num_abo_com" id="num_abo_com" type="hidden" value='<?php echo $num_abo_com ;?>'> </th>
        <th> <input  name="num_abonnement" id="num_abonnement" type="hidden" value='<?php echo $num_abonnement ;?>'> </th>
        <th> <input  name="nom_abonnement" id="nom_abonnement" type="hidden" value='<?php echo $nom_abonnement ;?>'> </th>
        <th> <input  name="nombre_spectacle" id="nombre_spectacle" type="hidden" value='<?php echo $nombre_spectacle ;?>'> </th>
        <th> <input  name="tarif_abonnement" id="tarif_abonnement" type="hidden" value='<?php echo $tarif_abonnement ;?>'> </th>
        <th> <input  name="num_client" id="num_client" type="hidden" value='<?php echo $num_client ;?>'> </th>
        <th> <input  name="nom" id="nom" type="hidden" value='<?php echo $nom ;?>'> </th>
        <th> <input type="image" name="Submit" src='image/valider.png'> </th>
    </tr>
    
</table>
</form>
<?php
include_once("include/bas.php");
?>