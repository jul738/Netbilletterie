<?php
/* Net Billetterie Copyright(C)2012 Jose Das Neves
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jose Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
//include('eviterMessageAvertissement.php');

include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
include_once("include/configav.php");
include_once("include/head.php");

$quanti=isset($_POST['quanti'])?$_POST['quanti']:"";
$num_client=isset($_POST['num_client'])?$_POST['num_client']:"";
$id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";
$article=isset($_POST["article"])?$_POST["article"]:"";
$comment = isset($_POST['coment'])?$_POST['coment']:"";

//=============================================
//pour que les articles soit classes par saison
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
?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<SCRIPT language="JavaScript" type="text/javascript">
	function confirmDelete(num)
	{
	var agree=confirm('confirmer l\'effacement'+num);
	if (agree)
	 return true ;
	else
	 return false ;
	}

	function verif_formulaire()
		{
	if(document.formu2.article.value == "0")  {
	alert("Veuillez Choisir un spectacle!");
	document.formu2.article.focus();
	return false;
			}
		}

	function edition()
		{
		options = "Width=700,Height=700" ;
		window.open( "print_tickets.php?num_bon=<?php echo $num_bon; ?>", "edition", options ) ;
		}
</script>
<?php


if($quanti=='' )
    {
    $message= "<h1>$lang_champ_oubli </h1>";
include('bon_suite.php'); 
    exit;
    }

    //on recupere le prix_tarif
$rqSql33= "SELECT id_tarif, nom_tarif, prix_tarif FROM ".$tblpref."tarif WHERE id_tarif=$id_tarif ";
				 $result33 = mysql_query( $rqSql33 )
             or die( "Execution requete33 impossible.");
						while ( $row = mysql_fetch_array( $result33)) {
    							$id_tarif = $row["id_tarif"];
    							$nom_tarif = $row["nom_tarif"];
							$prix_tarif = $row["prix_tarif"];}
                            $mont_tva = $prix_tarif * $quanti ;


// Pour l'ARTICLE  
          
        //on controle s'il y a assez de stock pour article
       if ($article!="") 
              {
                  $rqSql11= "SELECT stock, article FROM ".$tblpref."article WHERE num=$article ";
                  $result11 = mysql_query( $rqSql11 ) or die( "Execution requete rqsql11 impossible.");
                          while ( $row = mysql_fetch_array( $result11)) {
                                  $stock = $row["stock"];
                                  $nom_article= stripslashes($row["article"]);}
                                  $tre=$stock-$quanti;
                                  if($tre<0){
                                      $message1= "<h1>Impossibilite d'enregister <font color=red>$nom_article</font> <br> Car vous avez demande <font color=red>$quanti</font> place(s) et il n'en reste que <font color=red>$stock</font></h1>";
                                      continue;
                                      }
              // Si quanti = 1 
              //On créé la réservation
              if ($quanti == 1){
                    $sql_insert_resa = "INSERT INTO " . $tblpref ."bon_comm(client_num, date, id_tarif, user, id_article, coment) VALUES ('$num_client', '$annee-$mois-$jour', '$id_tarif', '$user_nom', '$article', '$comment')";
                    mysql_query($sql_insert_resa) OR DIE('Erreur SQL! <br>'.$sql_insert_resa.'<br>'.mysql_error());
              }
              //Si plusieurs résa, alors on créer les autres réservations
              else{
                  //Puis on créer les réservations supplémentaires
                  for($q=1; $q <= $quanti; $q++){
                    $sql_insert_resa = "INSERT INTO " . $tblpref ."bon_comm(client_num, date, id_tarif, user, id_article, comment) VALUES ('$num_client', '$annee-$mois-$jour', '$id_tarif', '$user_nom', '$article', '$comment')";
                    mysql_query($sql_insert_resa) OR DIE('Erreur SQL! <br>'.$sql_insert_resa.'<br>'.mysql_error());
                  }
              }
              //ici on decremnte le stock
              $sql12 = "UPDATE `".$tblpref."article` SET `stock` = (stock - ".$quanti.") WHERE `num` = '".$article."'";
              mysql_query($sql12) or die('Erreur SQL12 !<br>'.$sql12.'<br>'.mysql_error());

              //On change le statut du spectacle par complet si le stock est en <=0

                              $result111 = mysql_query( $rqSql11 ) or die( "Execution requete rqsql111 impossible.");
                              while ( $row = mysql_fetch_array( $result111)) {
                                  $stock = $row["stock"];}
                              if ( $stock <=0){
                              $sql121 = "UPDATE `".$tblpref."article` SET `actif` = 'COMPLET' WHERE `num` =$article";
                              mysql_query($sql121) or die('Erreur SQL121 !<br>'.$sql121.'<br>'.mysql_error());
                              }
                              else {
                              $sql122 = "UPDATE `".$tblpref."article` SET `actif` = '' WHERE `num` =$article";
                              mysql_query($sql122) or die('Erreur SQL122 !<br>'.$sql122.'<br>'.mysql_error());
                              }
            }// Fin du if article n'est pas vide 

                ?>


<table border="0" class="page" align="center">
	<tr>
		<td>
			<table class='boiteaction'>
				<?php
				//On recupere les info du client
					$sql_nom = "SELECT  nom, nom2 FROM ".$tblpref."client WHERE num_client = $num_client";
					$req = mysql_query($sql_nom) or die('Erreur SQL client!<br>'.$sql.'<br>'.mysql_error());
					while($data = mysql_fetch_array($req))
						{
							$nom = $data['nom'];
							$nom2 = $data['nom2'];
							$phrase = "$lang_bon_cree";
							$date = date("d-m-Y");
				?>
				<h1><?php echo "$phrase: $nom - $nom2 $lang_bon_cree2 $date <br>";?></h1><br>
				<?php 
						} 

				?>
			<caption>Les réservations de <?php echo $nom; ?></caption>
				<tr>
					<!-- th> Numero billet(s) </th-->
					<th><?php echo $lang_article ;?></th>
					<th><?php echo $lang_montant_htva ;?></th>
					<?php if ($impression=="y") { 
						if ($print_user=="y") { ?>
					<th>Imprimer billet(s)</th>
					<?php } } ?>
					<th><? echo $lang_supprimer ;?></th>
				</tr>
						 <?php
						//on recherche tout les contenus du bon et on les detaille
						$sql = "SELECT bc.num_bon, bc.id_tarif, DATE_FORMAT(a.date_spectacle,'%d-%m-%Y') AS date, a.article, t.nom_tarif, t.prix_tarif
							FROM ".$tblpref."bon_comm AS bc, ".$tblpref."article AS a, ".$tblpref."tarif AS t
							WHERE  bc.client_num = '".$num_client."' 
                                                            AND bc.id_article = a.num
                                                            AND bc.id_tarif = t.id_tarif";
						$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

						while($data = mysql_fetch_array($req))
							{
                                                                $num_bon = $data['num_bon'];
								$article = stripslashes($data['article']);
								$id_tarif = $data['id_tarif'];
								$prix_tarif = $data['prix_tarif'];
                                                                $date = $data['date'];
								$nom_tarif = $data['nom_tarif'];
								$nombre = $nombre +1;
								if($nombre & 1){
								$line="0";
								}else{
								$line="1";
								}
                                                                
								?>
				<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">				
					<?php
					//on recupere infos du carnet au depart de la saison et la quantite vendu depuis jusqu'a ce bon en filtrant par tarif
					$sql10 = "
					SELECT BC.id_tarif, T.nom_tarif, T.prix_tarif, T.carnet
					FROM ". $tblpref."bon_comm BC, ". $tblpref."tarif T, ". $tblpref."article ART
					WHERE BC.attente=0
					AND BC.fact='ok'
					AND BC.id_tarif=T.id_tarif
					AND ART.num= BC.id_article
					AND BC.num_bon <= '$num_bon'
					AND BC.id_tarif='$id_tarif'";
					$req10 = mysql_query($sql10) or die('Erreur SQL10 !<br>'.$sql10.'<br>'.mysql_error());
					while($data = mysql_fetch_array($req10))
					{
					$carnet = $data['carnet'];
					$id_tarif = $data['id_tarif'];
					?>
					<!-- td  WIDTH=20% class ='highlight'>
						<?php 
						 
							 //Pour chaque enregistrement le N° du premier billet vendu
							 if ($t!=$id_tarif){
								 $q='';
								 }
							 if ($q==''){$q=$quanti;}
							 else {$q=$q+$quanti;}
							$du=$carnet+$quanti01-intval($q);
 
							 //Pour chaque enregistrement le N° du dernier billet vendu
							 $au=$carnet+$quanti01-1;
//							 echo "carnet=$carnet- quanti01 =$quanti01-quanti_q=$q- quanti_boucle$quanti-au=$au<br>";


//							echo " Billet(s) vendu. ";
							$billet=$du;
							for($i=0; $i<$quanti; $i++)
							 {
							 echo "Numero".sprintf('%1$04d',$billet).", ";
							 $billet++;
							}
							 echo "<br/>";


							 $t=$id_tarif;
							 $quanti01 = $du-1;
				} 
										?>
					</td-->
					<td class ='highlight'><?php echo"$type_article | $article | $date| $nom_tarif";?></td>
					<td class ='highlight'><?php echo"$prix_tarif $devise"; ?></td>
					<?php if ($impression=="y") { 
						if ($print_user=="y") { ?>
					<td><A HREF="print_ticket_bon.php?num_bon=<?php echo"$num_bon"; ?>" onClick="window.open('print_ticket_bon.php?num_cont=<?php echo"$num_cont";?>&amp;num_bon=<?php echo"$num_bon"; ?>','_blank','toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=1, copyhistory=0, menuBar=0, width=600, height=800');return(false)">
                                                <img border=0 src= image/print.png></a>
					</td>
					<?php } } ?>
					<td class ='highlight'><a href="delete_bon_suite.php?num_bon=<?php echo"$num_bon"; ?>&amp;nom=<?php echo"$nom"; ?>" onClick='return confirmDelete(<?php echo"$num_cont"; ?>)'><img border="0" src="image/delete.png" alt="effacer" ></a>&nbsp;</td>
				</tr>
								<?php 
							}
								//on calcule la somme des réservations
								$sql = "SELECT SUM(t.prix_tarif)
                                                                        FROM ".$tblpref."bon_comm AS bc, ".$tblpref."article AS a, ".$tblpref."tarif AS t
                                                                        WHERE  bc.client_num = '".$num_client."' 
                                                                        AND bc.id_article = a.num
                                                                        AND bc.id_tarif = t.id_tarif";
								$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
								while($data = mysql_fetch_array($req))
									{
										$total = $data['SUM(t.prix_tarif)'];
							?>
				<tr>
					<td class='totalmontant' colspan="3">TOTAL DES RÉSERVATIONS</td>
					<td class='totaltexte'><?php echo "$total $devise "; ?></td><td colspan='2' class='totalmontant'><?php
									} ?>
					</td>
                                </tr>
                        </table>
                </td>
        </tr>
        <tr class="bouton submit">
            <center>
            <td align="center">
                    <table>
                        <tr class="bouton submit">
                <td>
                    <a href="form_commande.php?num_client=<?php echo $num_client;?>">Ajouter une nouvelle réservation pour <?php echo $nom; ?></a>
		</td>
					</tr>
				</table>
		</td>
            </center>
	</tr>
	<?php if ($impression=="y") { 
		if ($print_user=="y") { ?>
		<tr>
		<td>
			<table>
				<tr>
				<?php 
						if($print!='ok'){ ?>
					<td style="text-align: center;">
					<h3>Imprimer les billets
						<a href="print_tickets.php?num_bon=<?php echo"$num_bon";?>" onclick="edition();return false;"><img border=0 src= image/billetterie_v2.png ></a></h3> 
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
	<?php } } ?>
</table>
<?php
include("include/bas.php");
 ?>
