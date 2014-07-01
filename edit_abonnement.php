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

//On recupere le nom de l'abonnment que le client avais (pour savoir ce que l'on modifie) 
                            $req_recup_nom_abo = "SELECT ac.num_abo_com, ac.num_abonnement, a.nom_abonnement
                                                  FROM abonnement a, abonnement_comm ac
                                                  WHERE ac.num_abo_com = '$num_abo_com'
                                                  AND a.num_abonnement = ac.num_abonnement";
                            $req_recup_nom_abo_brut = mysql_query( $req_recup_nom_abo )or die( "Execution requete -req_recup_nom_abo- impossible.");

                              while($data = mysql_fetch_array($req_recup_nom_abo_brut))
                                {
                                $nom_abonnement = $data['nom_abonnement'];
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
                    echo $type_abonnement;
                    echo $num_abonnement ;
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
            <th> Choisir la quantite : 
                      <input type="text" name="quanti" value="1" SIZE="1">
            </th>
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
                                    <OPTION VALUE='<?php echo $liste_spectacle_contenu_num; ?>'><?php echo $liste_spectacle_contenu_type_article; ?> : <?php echo $liste_spectacle_contenu_nom; ?> [ <?php echo $liste_spectacle_contenu_horaire; ?> ] <?php echo $liste_spectacle_contenu_date; ?></OPTION>
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
<?php      
            
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
        <input  name="num_abo_com" id="num_abo_com" type="hidden" value='<?php echo $num_abo_com ;?>'>
        <input  name="num_abonnement" id="num_abonnement" type="hidden" value='<?php echo $num_abonnement ;?>'>
        <input  name="nom_abonnement" id="nom_abonnement" type="hidden" value='<?php echo $nom_abonnement ;?>'>
        <input  name="nombre_spectacle" id="nombre_spectacle" type="hidden" value='<?php echo $nombre_spectacle ;?>'>
        <input  name="tarif_abonnement" id="tarif_abonnement" type="hidden" value='<?php echo $tarif_abonnement ;?>'>
        <input  name="num_client" id="num_client" type="hidden" value='<?php echo $num_client ;?>'>
        <input  name="nom" id="nom" type="hidden" value='<?php echo $nom ;?>'>
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