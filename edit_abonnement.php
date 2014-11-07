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

//On recupere le nom de l'abonnment que le client a (pour savoir ce que l'on modifie) 
                            $req_recup_nom_abo = "SELECT ac.num_abo_com, ac.num_abonnement, a.nom_abonnement, ac.client_num, ac.paiement, ac.commentaire
                                                  FROM abonnement a, abonnement_comm ac
                                                  WHERE ac.num_abo_com = '$num_abo_com'
                                                  AND a.num_abonnement = ac.num_abonnement";
                            $req_recup_nom_abo_brut = mysql_query( $req_recup_nom_abo )or die( "Execution requete -req_recup_nom_abo- impossible.");

                              while($data = mysql_fetch_array($req_recup_nom_abo_brut))
                                {
                                $nom_abonnement = $data['nom_abonnement'];
                                $num_abonnement = $data['num_abonnement'];
                                $num_client = $data['client_num'];
                                $paiement = $data['paiement'];
                                $commentaire = $data['commentaire'];
                                }
                                
//On recupere le nom du client
                            $req_recup_client = "SELECT ac.num_abo_com, ac.num_abonnement, c.nom
                                                 FROM client c, abonnement_comm ac
                                                 WHERE ac.num_abo_com = '$num_abo_com'
                                                 AND c.num_client = ac.client_num";
                            $req_recup_client_brut = mysql_query( $req_recup_client )or die( "Execution requete -req_recup_client- impossible.");

                              while($data = mysql_fetch_array($req_recup_client_brut))
                                {
                                $nom_du_client = $data['nom'];
                                }  
                                
//On recupere le type_abonnement pour faire un tri sur la liste des choix propose
        $req_recup_type = "SELECT type_abonnement
                           FROM abonnement
                           WHERE num_abonnement = '$num_abonnement'";
        $recup_type_brut = mysql_query($req_recup_type) or die( "Execution requete -req_recup_type- impossible.");
        while($data = mysql_fetch_array($recup_type_brut))
                    {
                    $type_abonnement = $data['type_abonnement'];
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

?>



<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
                    <h3>Modification de l'abonnement "<?php echo"$nom_abonnement" ; ?>" de <?php echo"$nom_du_client"; ?>   :</h3>	
                </td>
        </tr>
        <tr>
	    <td>
	        <table class="boiteaction">
	            <caption> Edition de l'abonnement :</caption>
            </td>
        </tr>
        <form method='post' action='new_fin_abonnement.php'>
        <tr>
            <td>
                Modifier les spectacles
            </td>
            <td>
<?php

            // Choisir les spectacles (renseigner dans $nom_spectacle_x_vendu)
                      $rqSql = "SELECT ab.nombre_spectacle
                                FROM abonnement AS ab, abonnement_comm AS ac
                                WHERE ac.num_abo_com = '$num_abo_com'
                                AND ab.num_abonnement = ac.num_abonnement ";
           $result = mysql_query( $rqSql )or die( "Execution requete -rqSql- impossible.");     

            while ( $row = mysql_fetch_array( $result)) 
            {
                $nombre_spectacle= $row["nombre_spectacle"];
            }   
                //On affiche un champs  select pour chaque spectacle
                    for($nb = 1; $nb <= $nombre_spectacle; $nb++)
                            {
                            ?>
                                <SELECT name='liste_choix_spectacle_<?php echo $nb ;?>'>
                                    
                                
                                <?php
                                 // lister les numero et les nom des spectacle active (meme ceux complet)
                                $sql_liste_article = "SELECT num, article, type_article, horaire, date_spectacle
                                                      FROM article 
                                                      WHERE actif != 'non'
                                                      AND type_article = '$type_abonnement'";
                                $liste_article = mysql_query( $sql_liste_article )or die( "Execution requete -liste_article- impossible.");
                                // Récupérer le nom de l'ancien spectable
                                $req_recup_ancien_val = "SELECT a.num
                                                        FROM abonnement_comm AS ac, bon_comm AS bc, article AS a
                                                        WHERE num_abo_com = '$num_abo_com'
                                                        AND ac.num_resa_".$nb." = bc.num_bon
                                                        AND bc.id_article = a.num";
                               $ancien_id_spectacle= mysql_query($req_recup_ancien_val)or die( "Execution requete -req_recup_ancien_val- impossible.");
                                $id_spectacle = mysql_fetch_row($ancien_id_spectacle);

                                while ( $liste_spectacle = mysql_fetch_array( $liste_article))  
                                {
                                    $liste_spectacle_contenu_nom = $liste_spectacle["article"];
                                    $liste_spectacle_contenu_num = $liste_spectacle["num"];
                                    $liste_spectacle_contenu_type_article = $liste_spectacle["type_article"];
                                    $liste_spectacle_contenu_horaire = $liste_spectacle["horaire"];
                                    $liste_spectacle_contenu_date = $liste_spectacle["date_spectacle"];                                    
                                    ?>
                                    
                                    <OPTION VALUE='<?php echo $liste_spectacle_contenu_num; ?>' <?php if ($id_spectacle[0] == $liste_spectacle_contenu_num) { ?> selected <?php } ; ?>><?php echo $liste_spectacle_contenu_type_article; ?> : <?php echo $liste_spectacle_contenu_nom; ?> [ <?php echo $liste_spectacle_contenu_horaire; ?> ] <?php echo $liste_spectacle_contenu_date; ?></OPTION>
                                    <?php
                                }
                                ?>
                                </SELECT>
                            <?php  

                            } // fin de la boucle for
                            // On récupère l'id des anciennes resas pour MAJ du stock et de la résa
                            $select_ancienne_resa = "SELECT num_resa_1, num_resa_2, num_resa_3, num_resa_4, num_resa_5, num_resa_6, num_resa_7 FROM abonnement_comm AS ac WHERE num_abo_com = '$num_abo_com'";
                            $req_ancienne_resa = mysql_query($select_ancienne_resa) or die ('erreur sql selection resa');
                            while($data_ancienne_resa = mysql_fetch_array($req_ancienne_resa)){
                                $ancienne_resa_1 = $data_ancienne_resa['num_resa_1'];
                                $ancienne_resa_2 = $data_ancienne_resa['num_resa_2'];
                                $ancienne_resa_3 = $data_ancienne_resa['num_resa_3'];
                                $ancienne_resa_4 = $data_ancienne_resa['num_resa_4'];
                                $ancienne_resa_5 = $data_ancienne_resa['num_resa_5'];
                                $ancienne_resa_6 = $data_ancienne_resa['num_resa_6'];
                                $ancienne_resa_7 = $data_ancienne_resa['num_resa_7'];
                            }
            ?>
            </td>
        </tr>
        <tr> 
                <td class="texte0">
                  Moyen de paiement
                </td>
                <td class="texte_left" colspan="3">
                            <SELECT name='paiement'>
                                <OPTION VALUE="">Choisir un moyen de paiement</OPTION>
                                
                                <?php
                                 // lister les numero et les nom des spectacle active (pas ceux complet)
                                $req_recup_paiement = "SELECT id_type_paiement, nom
                                                       FROM type_paiement ";
                                $recup_paiement_brut = mysql_query( $req_recup_paiement )or die( "Execution requete -req_recup_paiement- impossible.");

                                while ( $recup_paiement = mysql_fetch_array( $recup_paiement_brut))  
                                {
                                    $paiement_nom = $recup_paiement["nom"];
                                    $paiement_id = $recup_paiement["id_type_paiement"];
                                    ?>
                                    <OPTION VALUE='<?php echo $paiement_id; ?>' <?php if($paiement_id == $paiement){ echo 'selected'; } ?>><?php echo $paiement_nom; ?></OPTION>
                                    <?php
                                }
                                ?>
                            </SELECT>
                </td>
            </tr>
            <tr>
                <td>
                    Commentaire pour l'abonnement
                </td>
                <td>
                    <textarea name="commentaire" class="text_left" rows="4" cols="70"><?php if(!empty($commentaire)) { echo $commentaire;} ?></textarea>
                </td>
            </tr>
    <tr>
        <input  name="edit_abonnement" id="edit_abonnement" type="hidden" value='1'>
        <input  name="num_abo_com" id="num_abo_com" type="hidden" value='<?php echo $num_abo_com ;?>'>
        <input  name="num_abonnement" id="num_abonnement" type="hidden" value='<?php echo $num_abonnement ;?>'>
        <input  name="nom_abonnement" id="nom_abonnement" type="hidden" value='<?php echo $nom_abonnement ;?>'>
        <input  name="nombre_spectacle" id="nombre_spectacle" type="hidden" value='<?php echo $nombre_spectacle ;?>'>
        <input  name="tarif_abonnement" id="tarif_abonnement" type="hidden" value='<?php echo $tarif_abonnement ;?>'>
        <input  name="num_client" id="num_client" type="hidden" value='<?php echo $num_client ;?>'>
        <input  name="nom" id="nom" type="hidden" value='<?php echo $nom_du_client ;?>'>
        <input name="edit" id="edit" type="hidden" value="y">
        <input name="ancien-resa-1" type="hidden" value='<?php echo $ancienne_resa_1; ?>'>
        <input name="ancien-resa-2" type="hidden" value='<?php echo $ancienne_resa_2; ?>'>
        <input name="ancien-resa-3" type="hidden" value='<?php echo $ancienne_resa_3; ?>'>
        <input name="ancien-resa-4" type="hidden" value='<?php echo $ancienne_resa_4; ?>'>
        <input name="ancien-resa-5" type="hidden" value='<?php echo $ancienne_resa_5; ?>'>
        <input name="ancien-resa-6" type="hidden" value='<?php echo $ancienne_resa_6; ?>'>
        <input name="ancien-resa-7" type="hidden" value='<?php echo $ancienne_resa_7; ?>'>
    </tr>
    <tr>
        <th> <input type="image" name="Submit" src='image/valider.png'> </th>
    </tr>  
</table>    
</table>
</form>
<?php
include_once("include/bas.php");
?>