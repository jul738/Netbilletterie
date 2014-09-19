<?php 
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
include_once("include/configav.php");
include_once("include/head.php");
include_once('include/fonction.php');
?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<script type="text/javascript">
function verif_formulaire() {
	var msg = "";
 
if(document.formu2.id_tarif.value == "")  {
		msg += "Veuillez saisir le tarif!\n";
		document.formu2.id_tarif.style.backgroundColor = "#F3C200";
	}
 
	if (msg == "") return(true);
	else	{
		alert(msg);
		return(false);
	}
}
</script>

<?php

$num_bon=isset($_POST['num_bon'])?$_POST['num_bon']:"";
$attente=isset($_POST['attente'])?$_POST['attente']:"";

//on change le bon s'il vient de la liste d'attente en modifant le champ attente à 0
if($attente=='1'){
$sql22 = "UPDATE `".$tblpref."bon_comm` SET `attente` = '0' WHERE `num_bon` = '$num_bon'";
mysql_query($sql22) or die("Erreur SQL22 !<br>'.$sql22.'<br>.mysql_error()<br><a href='lister_commandes.php'>retour a la liste</a>");
}

if($num_bon=='')
    {
        $num_bon=isset($_GET['num_bon'])?$_GET['num_bon']:"";
    }
    



		//on recupère les info du bon de commande
$sql = "SELECT  coment, client_num, nom, paiement, fact, ctrl, user, id_tarif, id_article FROM ".$tblpref."bon_comm 
	RIGHT JOIN ".$tblpref."client on ".$tblpref."bon_comm.client_num = ".$tblpref."client.num_client
	WHERE num_bon = $num_bon";
$req = mysql_query($sql) or die("Erreur SQL !<br>'.$sql.'<br>.mysql_error()<br><a href='lister_commandes.php'>retour a la liste</a>");
$data = mysql_fetch_array($req);
$paiement = $data["paiement"];
$paiement=stripslashes($paiement);
$num_client = htmlentities($data['client_num'], ENT_QUOTES);
$coment = $data['coment'];
$coment=stripslashes($coment);
$nom=$data['nom'];
$nom=stripslashes($nom);
$pointage=$data['fact'];
$ctrl=$data['ctrl'];
$user = $data['user'];
$id_tarif_resa = $data['id_tarif'];
$id_article = $data['id_article'];

//=============================================
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
//pour le formulaire
$annee_1=isset($_POST['annee_1'])?$_POST['annee_1']:"";
if ($annee_1=='') 
{
  $annee_1= $annee ;
  if ($mois.'-'.$jour <= $fin_saison)
  {
  $annee_1=$annee_1;
  }
  if ($mois.'-'.$jour >= $fin_saison)
  {
  $annee_1=$annee_1+1;
  }  
}
$annee_2= $annee_1 -1;
//=============================================
//on recupère les infos des spectacles
$rqSql1 = "SELECT uni, num, article, date_spectacle AS date, prix_htva, stock, stomin, stomax
                                            FROM ".$tblpref."article
                                            WHERE stock > '0'
                                            AND date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
                                            ORDER BY date_spectacle, horaire ASC";
$result = mysql_query( $rqSql1 )
             or die( "Exécution requetes impossible1.<br> <a href='lister_commandes.php'>retour a la liste</a>");
?>

<script type="text/javascript">
function edition()
    {
    options = "Width=700,Height=700" ;
    window.open( "print_tickets.php?num_bon=<?php echo $num_bon; ?>", "edition", options ) ;
    }
	</script>
	
	
<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center"></td>
	</tr>
	<tr>
		<td  class="page" align="center">
			<?php
			//les infos du bon => nom du spectateur
			$sql_nom = "SELECT  nom, nom2 FROM ".$tblpref."client WHERE num_client = $num_client";
			$req = mysql_query($sql_nom) or die("Erreur SQL_nom !<br>'.$sql_nom.'<br>.mysql_error()<br><a href='lister_commandes.php'>retour a la liste</a>");
			while($data = mysql_fetch_array($req))
				{
					$nom = $data['nom'];
					$phrase = "$lang_bon_cree";
							$date = date("d-m-Y");
							?>
					<h1><?php echo "$phrase: $nom $lang_bon_cree2 $date <br>par: $user<br>";?></h1><br>
					<?php 
				} ?>

			<h3><a href="lister_commandes.php"><img src="image/retour.png" alt= "Retour a la liste des reservations">Revenir a la liste des reservations</a></h3>

		</td>
	</tr>
	<tr>
		<td>
			<table class="boiteaction">	
				<!-- formulaire d'edition du bon de commande -->
				<form name="formu2" method="post" action="edit_bon_suite.php" onSubmit="return verif_formulaire()">
					<?php
					if( $pointage!='ok'){ 
						if( $voir!='ok'){?>
				<caption>
					<?php echo "$lang_bon_editer $lang_numero $num_bon"; ?> 
				</caption>
				<tr> 
					<!-- choisir le spectacle -->
					<td class="texte0"><br>choisir le <?php echo $lang_article; ?>(s)    
							<?php
						include_once("include/configav.php");
							$rqSql = "SELECT uni, num, article, date_spectacle AS date, prix_htva, stock, stomin, stomax
										FROM ".$tblpref."article
										WHERE stock > '0'
										AND date_spectacle BETWEEN NOW() AND '$annee_1-$fin_saison'
										ORDER BY date_spectacle, horaire ASC";
						$result = mysql_query( $rqSql )or die( "Exécution requête impossible3.<br> <a href='lister_commandes.php'>retour a la liste</a>");
						?>
					</td>
					<td class="texte_left">
						<?php                                                    
							$i=1;
							while ( $row = mysql_fetch_array( $result)) 
							{
								$num = $row["num"];
								$article = stripslashes($row["article"]);
								$date_timestampt = strtotime($row["date"]);
                                                                $date = date_fr('l d-m-Y', $date_timestampt);
								$stock = $row['stock'];
								$min = $row['stomin'];
																	
								if ($stock <= $min && $stock >= 1  ){
									$stock="Attention plus que $stock places";
									$style= 'style="color:#961a1a; background:#ece9d8;"';
									$option="".$article." ---". $date." ---".$stock."";
								}
								else{
									 $stock= "Le stock est de ".$stock." places";
									 $style= 'style="color:black; background-color:##99fe98;"';
									 $option="".$article." ---". $date." ---".$stock."";
								}
						?>
                                                <input  type="radio" VALUE='<?php echo $num; ?>' name="article" <?php if ($id_article == $num){ echo "checked";}?> ><b <?php echo$style; ?>><?php echo" $option"; ?><b><br>
						<?php $i++; 
							}
						?>
					</td>
				</tr>
						
				<tr> 
					<!-- choisir le tarif -->
                                        <td>Choisir le<?php echo "$lang_tarif";?></td>
                                        <td colspan="2" class="texte0">
						<?php $rqSql3= "SELECT id_tarif, nom_tarif, prix_tarif, saison FROM ".$tblpref."tarif
										WHERE saison BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
										AND selection='1'
										ORDER BY nom_tarif ASC" ;
								$result3 = mysql_query( $rqSql3 ) or die( "Exécution requétesssss impossible.<br> <a href='lister_commandes.php'>retour a la liste</a>");
						?>		   
					<SELECT NAME='id_tarif'>
						
							<?php
								while ( $row = mysql_fetch_array( $result3)) 
								{
										$id_tarif = $row["id_tarif"];
										$nom_tarif = $row["nom_tarif"];
										$prix_tarif = $row["prix_tarif"];  ?>
                                                                                <OPTION VALUE='<?php echo $id_tarif;?>' <?php if($id_tarif == $id_tarif_resa) {echo "selected";}?>><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
								<?php 
								}
							?>
					</SELECT>
					</td>
				</tr>
                                <tr>
                                    <td>Paiement</td>
                                    <td class="highlight">
                                        <?php 
                                            include("include/paiemment.php");
                                        ?>
                                    </td>
                                </tr>
                                <tr>
					<td><?php echo $lang_ajo_com_bo ?><br> </td>
					<td><textarea name="coment" cols="45" rows="3"><?php echo $coment; ?></textarea><br> 
                                        </td>
                                </tr>
				<tr> 
					<td class="submit" colspan="9"> 
                                                <input name="ancien_article" type="hidden" value='<?php echo $id_article; ?>'>
						<input name="num_bon" type="hidden"  value='<?php echo $num_bon; ?>'>
						<input style="color:#961a1a;background:yellow" type="submit" name="Submit" value="Enregistrer la réservation"></td>
							<?php 
							} }
							else {
								$message = "<center><h1>Cette commande a &#233t&#233 point&#233e OK et ne peut &#234tre modifi&#233e</h1>";
								echo $message;
							}
							?>
					</td>
				</tr> 
				</form>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
				<?php 
				//si le billet n'a encore jamais �t� imprim�
						if($print!='ok'){ ?>
					<td >
					<h3 >Imprimer les billets
						<a href="print_tickets.php?num_bon=<?php echo"$num_bon";?>" onclick="edition();return false;"><img border=0 src= image/billetterie.png ></a></h3> 
					</td>
						<?php 
						}
						 else {?>
					<td class='<?php echo couleur_alternee (FALSE); ?>' colspan='7'> </td> 
						  <?php 
						 } ?>
				</tr>
			</table>
		</td>
	</tr>

</table>
	
<?php 
include_once("include/bas.php");
 ?>