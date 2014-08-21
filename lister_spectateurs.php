<?php 
/* Net Billetterie Copyright(C)2012 Jose Das Neves
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Jose Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");?>
<script type="text/javascript" src="javascripts/confdel.js"></script>

<table class="page" >
<tr>
<td  class="page" align="center">
 <?php
if ($user_cli == n) { 
echo"<h1>$lang_client_droit";
exit;  
}


$article_numero=isset($_GET['article'])?$_GET['article']:"";

//Lister reservation et billet du soir
$sql = "SELECT *
        FROM client C, bon_comm BC , tarif T
        WHERE BC.client_num=C.num_client
        AND BC.id_article = $article_numero
        AND BC.attente=0
        AND BC.id_tarif = T.id_tarif
        AND BC.paiement = 'non'";

if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
{
$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
}else{
$sql .= " ORDER BY BC.num_bon ASC ";
}

$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

$sql2="SELECT DATE_FORMAT(date_spectacle,'%d/%m/%Y') AS date_spectacle, article, stock, num FROM " . $tblpref ."article WHERE num=$article_numero";
$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req2))
    {
    $article = $data['article'];
    $article_numero= $data['num'];
    $date = $data['date_spectacle'];
    $stock = $data['stock'];


?>
<center><table class="boiteaction">
  <caption>Liste des spectateurs pour: <br><?php
  if ($stock>0){
  echo "$article le $date - Il reste $stock places";
  
  }
 else {
   echo "$article le $date - La liste d'attente est a $stock places";
    }
    ?> <br><br>
  <?php if ($user_admin != n) { ?>
  <a href="form_mailing.php?article=<?php echo $article_numero;?>">Envoyer un mail a tous ces spectateurs</a><br> <?php } ?>
 <!-- <a href="fpdf/liste_spectateurs.php?article=<?php echo $article_numero;?>" target="_blank">Imprimer la liste de tous ces spectateurs</a></caption> -->

        
      <?php } ?>

        <tr>
            <th colspan="9"> Reservations : </th>
        </tr>
        
                <tr>        
                    <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=civ">Nom</a></th>
                    <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=nom">Prenom</a></th>
                    <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=rue">Telephone</a></th>
                    <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=cp">Mail</a></th>
                    <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=ville">Nom abonnement</a></th>
                    <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>">Tarif</a></th>
                    <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>">Paiement</a></th>
                    <th>Valider</th>
                </tr>

<?php
$nombre =1;
while($data = mysql_fetch_array($req))
    {
		$article_num = $data['id_article'];
		$bon_num = $data['num_bon'];
		$num_client = $data['client_num'];
		$nom = $data['nom'];
		$nom_html= stripslashes($nom);
		$nom2 = $data['nom2'];
		$rue = $data['rue'];
		$ville = $data['ville'];
		$cp = $data['cp'];
		$tva = $data['num_tva'];
		$mail =$data['mail'];
		$num = $data['num_client'];
		$civ = $data['civ'];
		$tel = $data['tel'];
		$fax = $data['fax'];
		$nom_tarif = $data['nom_tarif'];
		$prix_tarif = $data['prix_tarif'];		
		
    if($nombre & 1){
                    $line="0";
                    }else{
                    $line="1"; 
                    }
		?>
                <!--On ajoute un formulaire par ligne pour la transformation en billet-->
                <form action="lister_spectateurs" method="POST" id="resa-billet" name="resa-billet">
		<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte <?php echo "$line" ?>'">
                    <td class="highlight"><?php echo $nom_html; ?></td>
                    <td class="highlight"><?php echo $prenom ; ?></td> 
                    <td class="highlight"><?php echo $tel; ?></td>
                    <td class="highlight"><a href="mailto:<?php echo $mail; ?>" ><?php echo "$mail"; ?></a></td>
                    <td class="highlight"><?php echo $nom_tarif; ?></td>
                    <td class="highlight">
                        <?php $rqSql3= "SELECT id_tarif, nom_tarif, prix_tarif, saison FROM " . $tblpref ."tarif
													 WHERE nom_tarif<>'gratuit'
													 AND selection='1'
													 ORDER BY nom_tarif ASC";
											$result3 = mysql_query( $rqSql3 )or die( mysql_error()."Execution requete impossible.");?>
									   <SELECT NAME='id_tarif'>
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
                    <td class="highlight">
                        <?php 
                            include("include/paiemment.php");
			?>
                    </td>
                    <td class="highlight">
                        <input type="hidden" name="num_bon" value="<?php echo $bon_num;?>">
                        <input type="submit" name="Submit" value='Enregistrer le billet'></td>
                </tr></form>
		

		<?php
		}

?>
</table></center>

<?php
include("help.php");	
echo"</td></tr>";
?>
<tr><td>
        <!-- On ajoute une table avec la liste des invités -->
<center><table class="boiteaction">
        <caption>Invités / Éxonérés : </caption>
</table></center>
    </td></tr>
<tr>
    <td>
        <!-- On ajoute une table avec la liste des personnes étant arrivées -->
        <center><table class="boiteaction">
            <caption> Personnes arrivées : </caption>
        </table></center>
    </td>
</tr>
<?php
echo "<tr><td>";
include_once("include/bas.php");
?> 
</td></tr>

<?php
$url = $_SERVER['PHP_SELF'];
$file = basename ($url);
if ($file=="form_client.php") { 
echo"</table>"; 
} ?>
</table>
</body>
</html>
