<?php
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
include_once("include/fonction.php");

    if(isset($_GET['num_client'])){
        $client = $_GET['num_client'];
    }

    //pour que les articles soit classés par saison
$mois=date("n");
if ($mois=="10"||$mois=="11"||$mois=="12") {
 $mois=date("n");
}
else{
  $mois =date("0n");
}
$jour =date("d");
$date_ref="$mois-$jour";
$annee = date("Y");

  if ($mois.'-'.$jour >= $fin_saison)
  {
  $annee_1=$annee+1;
  }  
  else {
      $annee_1 = $annee;
  }

//pour le formulaire
$annee_2= $annee_1 -1;
?>
<script type="text/javascript">
function verif_formulaire()
		{
	if(document.formu.id_tarif.value == "")  {
	alert("Veuillez Choisir le tarif!");
	document.formu.id_tarif.focus();
	return false;
					}
	if(document.formu.listeville.value == "")  {
	alert("Veuillez Choisir un spectateur!");
	document.formu.listeville.focus();
	return false;
					}
		}
</script>
<table border="0" class="page" align="center">
    <tr>
        <td class="page" align="center">
                <h3>Creer une Reservation </h3>
        </td>
    </tr>
    <tr>
        <td  class="page" align="center" style="background:#E8E8EC;">
            <?php
             if ($message!='') {
             echo"<table><tr><td>$message</td></tr></table>";
            }
            if ($user_com == n) {
            echo"<h1>$lang_commande_droit";
            exit;
            }            
            $jour = date("d");
            $mois = date("m");
            $annee = date("Y");

            $rqSql = "SELECT num_client, nom, nom2, prenom FROM " . $tblpref ."client WHERE actif != 'n' AND `num_client`!='1'";
            if ($user_com == r) {
            $rqSql = "SELECT num_client, nom, prenom FROM " . $tblpref ."client WHERE actif != 'n' AND `num_client`!='1'
                     and (" . $tblpref ."client.permi LIKE '$user_num,'
                     or  " . $tblpref ."client.permi LIKE '%,$user_num,'
                     or  " . $tblpref ."client.permi LIKE '%,$user_num,%'
                     or  " . $tblpref ."client.permi LIKE '$user_num,%')
                    ";
            }
             ?> 
       </td>
	</tr>
	<tr> 
		<td>
			<center>
			<table>
				<tr>
					<td>
						<form name="formu" method="post" action="bon_suite.php" onSubmit="return verif_formulaire()">
							<table>
								<tr>
                                                                    	<td><?php echo "$lang_cre_bon"; ?></td>
									<td  class="texte0" >
											 <?php
											 require_once("include/configav.php");
											 $rqSql="$rqSql order by nom";
											 $result = mysql_query( $rqSql ) or die( "Execution requete impossible.");
											 ?>
										<SELECT NAME='num_client'>
											<OPTION VALUE="">Cliquez ici et commencez a ecrire le nom</OPTION>
											<?php
											while ( $row = mysql_fetch_array( $result)) {
											$numclient = $row["num_client"];
											$nom = $row["nom"];
											$nom2 = $row["nom2"];
                                                                                        $prenom = $row['prenom'];
											?>
                                                                                        <OPTION VALUE='<?php echo $numclient; ?>' <?php if($numclient==$client){ echo 'selected';} ?>><?php echo $nom.' '; echo $prenom; ?></OPTION>
											<?php
											}
											?>
										</SELECT>
									</td>
								</tr>
                                                                          <tr>
          <td><strong>Choisir la quantite d'entree par spectacle </strong></td>
          <td colspan="3">
          <input type="text" name="quanti" value="1" SIZE="1"></td>

          </tr>
          								<tr>
                                                                    <td class="texte0">Choisir le<?php echo "$lang_tarif";?>
										<?php

											$rqSql3= "SELECT id_tarif, nom_tarif, prix_tarif, saison FROM " . $tblpref ."tarif
													 WHERE saison
													 BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
													 AND nom_tarif<>'gratuit'
													 AND selection='1'
													 ORDER BY nom_tarif ASC";
											$result3 = mysql_query( $rqSql3 )or die( mysql_error()."Execution requete impossible.");?>
									<td class="texte0" colspan='2'>
									   <SELECT NAME='id_tarif' id='id_tarif'>
											<OPTION VALUE="">Choisir le<?php echo "$lang_tarif";?></OPTION>
											<?php
											while ( $row = mysql_fetch_array( $result3)) {
													$id_tarif = $row["id_tarif"];
													$nom_tarif = $row["nom_tarif"];
													$prix_tarif = $row["prix_tarif"];
													?>
											<OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
											<?php }
												if ($user_admin != 'n'){
													//tarif gratuit pour admin 
														$sqltarifgratuit = "SELECT nom_tarif, prix_tarif, id_tarif, DATE_FORMAT(saison, '%d/%m/%Y' ) AS date FROM ".$tblpref."tarif
													WHERE saison
														BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
														AND nom_tarif='gratuit'";
													$reqtarifgratuit = mysql_query($sqltarifgratuit) or die('Erreur SQLtarifgratuit !<br>'.$sqltarifgratuit.'<br>'.mysql_error());
													while($data = mysql_fetch_array($reqtarifgratuit))
													{
																	$nom_tarif = $data['nom_tarif'];
																	$prix_tarif = $data['prix_tarif'];
																	$id_tarif =$data['id_tarif'];
											?>
										<OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
											<?php
													}
												}?>
										</SELECT>
									</td>
								</tr>
          <tr>
          <td class="texte0">Choisir le  <?php echo "$lang_article"; ?></td>
          <?php
          echo date();
          //pour n 'affiches que les articles  en stock
          $select_article = "SELECT uni, num, article, date_spectacle AS date, prix_htva, stock, stomin, stomax, type_article, horaire
                    FROM " . $tblpref ."article
                    WHERE stock > '0'
                    AND date_spectacle >= NOW() - INTERVAL 1 DAY
                    ORDER BY date_spectacle, horaire ASC";
          $result_article = mysql_query($select_article)or die( "Execution requete impossible.");

          ?>
          <td class="texte_left">
            <?php                                                    

            while ( $row_article = mysql_fetch_array($result_article)) 
            {
              $num = $row_article["num"];
              $article= stripslashes($row_article["article"]);
              $type_article = $row_article['type_article'];
              $horaire = $row_article['horaire'];
              $date_timesamp = strtotime($row_article["date"]);
              $date = date_fr('l d-m-Y', $date_timesamp);
              $stock = $row_article['stock'];
              $min = $row_article['stomin'];

                if ($stock<=0 ) 
                {
                 $option="complet";
                }
                elseif ($stock <= $min && $stock >= 1  ) 
                {
                  $stock="Attention plus que $stock places";
                  $style= 'style="color:#961a1a; background:#ece9d8;"';
                  $option="$type_article - ".$article." - ". $date." $horaire - ".$stock."";
                }
                else 
                {
                  $stock= "Le stock est de ".$stock." places";
                  $option="$type_article - ".$article." - <strong>". $date."</strong> -" .$horaire." - ".$stock."";
                }
            ?>
            <input  type="radio" VALUE='<?php echo $num; ?>' name="article"  ><?php echo" $option"; ?><br>
            <?php 
            }
            ?>
          </tr>     <tr>
              <td>Paiement</td>
              <td class="highlight">
                        <?php 
                            include("include/paiemment.php");
			?>
              </td></tr>
                                                                <tr>
                                                                    <td>Commentaire pour la réservation </td>
                                                                    <td colspan="2"><textarea name="coment" cols="45" rows="3"></textarea></td>
                                                                </tr>
								<tr>
									<td class="submit" colspan="6"> 
									<input type="hidden" name="date" value="<?php echo"$jour/$mois/$annee";?>" >
									<input type="image" name="Submit" src="image/valider.png" value="Demarrer"  border="0"></td>
								</tr>
							</table>
						</form>	
					</td>
				</tr>
			</center>
			</table>
		</td>
	</tr>
	<tr>
            <td class="texte0"><h1><a href="form_commande_soir.php"><img src="image/billetterie_v2.png">Formulaire pour les enregistrements le jour du spectacle </a></h1>
		</td>
	</tr>
</table>
<?php
include_once("include/bas.php");
?>





