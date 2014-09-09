<?php 
/* Net Billetterie Copyright(C)2012 Jose Das Neves
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jose Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
include_once("include/fonction.php");



//pour le formulaire
$article_numero=isset($_POST['article_numero'])?$_POST['article_numero']:"";
$attente=isset($_POST['attente'])?$_POST['attente']:"";
if ($attente=='') { $attente=0; }

//=============================================
//pour que les articles soit classes par saison
$mois=date("n");
if ($mois=="11"||$mois=="12") {
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

//requette 
$sql = "SELECT C.num_client, nom, client_num, mail, tel, ville, date FROM ".$tblpref."client C, ".$tblpref."bon_comm BC  
		WHERE BC.client_num=C.num_client
		AND C.actif='y'
		AND BC.attente=$attente	 
		AND date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
if ($article_numero != '')
{
$sql .= " AND BC.id_article = $article_numero";
}
$sql .= " GROUP by C.num_client
	  ORDER by C.nom asc ";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$nb = mysql_num_rows($req);
//nom du  spectacle'
if ($article_numero!=""){
$sql2 = "SELECT article FROM ".$tblpref."article WHERE num=$article_numero";
$req2 = mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());
$data = mysql_fetch_array($req2);
$article = $data['article'];
}
?>
<script type="text/javascript" src="javascripts/confdel.js"></script>

<table width="760" border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
		<h3>Liste des spectateurs suivant les criteres de recherche "<?php echo "$article <br/> Nombre de reservations $nb"; ?>"</h3>
		</td>
	</tr>
	<tr>
		<td  class="page" align="center">
			<center>
				<table class="boiteaction">
					<caption><?php echo $lang_clients_existants; ?></caption>		   
					   <form method="POST" action="rechercher_clients.php" >
					   <tr>
							<td>
							   <h5>En fonction de la saison</h5><br>
									<select name="annee_1">
									<option value="<?php $date4=(date("Y")-1);echo"$date4"; ?>"><?php $date_4=$date4-1;echo"$date_4 - $date4"; ?></option>
									<option value="<?php $date5=(date("Y")-2);echo"$date5"; ?>"><?php $date_5=$date5-1;echo"$date_5 - $date5"; ?></option>
									<option value="<?php $date6=(date("Y")-3);echo"$date6"; ?>"><?php $date_6=$date6-1;echo"$date_6 - $date6"; ?></option>
									<option value="<?php $date7=(date("Y")-4);echo"$date7"; ?>"><?php $date_7=$date7-1;echo"$date_7 - $date7"; ?></option>
									<option value="<?php $date8=(date("Y")-5);echo"$date8"; ?>"><?php $date_8=$date8-1;echo"$date_8 - $date8"; ?></option>
									<option value="<?php $date9=(date("Y")-6);echo"$date9"; ?>"><?php $date_9=$date9-1;echo"$date_9 - $date9"; ?></option>
                                                                        <option value="<?php $date3=date("Y");echo"$date3"; ?>" selected="selected"><?php $date_3=$date3-1;echo"$date_3 - $date3"; ?></option>
                                                                        <option value="<?php $date2=(date("Y")+1);echo"$date2"; ?>"><?php $date_2=$date2-1;echo"$date_2 - $date2"; ?></option>
									</select>
							</td>
							<td>
								<h5>En fonction du spectacle</h5><br>
									<select name="article_numero">
										<?php if ($article_numero=="") 
										{ 	
										?>
											<option value="">Tous les spectacles de la saison</option>
											<?php }
											else {
										$sql5 = "SELECT * FROM ".$tblpref."article WHERE num=$article_numero";
										$req5 = mysql_query($sql5) or die('Erreur SQL5 !<br>'.$sql5.'<br>'.mysql_error());
										while($data = mysql_fetch_array($req5)){
														$article = $data['article'];
														$article_html = stripslashes($article);																
														$actif = $data['actif'];
														} ?>
											<option value="<?php echo $article_numero; ?>"><?php echo "$article_html-$actif"; ?></option>
											<?php
											} ?>
											<option value="">Tous les spectacles de la saison</option>
											<?PHP
													$sql3 = "SELECT * FROM ".$tblpref."article 
													WHERE date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison' ORDER BY date_spectacle";
													$req3 = mysql_query($sql3) or die('Erreur SQL3 !<br>'.$sql3.'<br>'.mysql_error());
													
												while($data = mysql_fetch_array($req3)){
														$article = $data['article'];		
														$article_html = stripslashes($article);
														$num =$data['num'];	
														$actif =$data['actif'];
														?>

											<option value="<?php echo $num; ?>"><?php echo "$article_html - $actif"; ?></option>
											<?php }?>

									</select>
									<select name="attente">
										<option  value="<?php echo $attente ?>"><?php if ($attente==0) {$texte= "Sur les reservations";} 
										if ($attente==1) {$texte= "Sur liste d'attente";}echo $texte; ?></option>
										<option  value=0>Sur les r�servations</option>
										<option  value=1>Sur liste d'attente </option>
									</select>
								
								</td>
								<!--td>
								<h5>Sur la liste d'attente</h5><br>
												<select name="article_numero">
													<option value="">Les spectacles complets de la saison</option>
													<?php
															$sql3 = "SELECT * FROM ".$tblpref."article 
															WHERE date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
															AND stock<=0";
															$req3 = mysql_query($sql3) or die('Erreur SQL3 !<br>'.$sql3.'<br>'.mysql_error());
															
														while($data = mysql_fetch_array($req3)){
																$article = $data['article'];		
																$article_html = stripslashes($article);
																$num =$data['num'];	
																?>

													<option value="<?php echo $num; ?>"><?php echo " $num $article_html"; ?></option>
													<?php }?>
													<select>
													<input  name="attente" value=1>1=liste d'attente <br>0=hors liste d'attente
													</select>

												  </select>
								
								</td-->
							</tr>
							<tr>
								<td colspan="3">
								<input type="submit" name="Submit" value="Envoyer la recherche">
								</td>
							</tr>								
						</form>
			   				</table>
			</center>
		</td>
	</tr>
	<tr><td><center><table class="boiteaction">
							<tr>
								<th><?php echo $lang_nom; ?></a></th>
								<th><?php echo $lang_ville; ?></a></th>
								<th><?php  echo $lang_tele;?></a></th>
								<th><?php echo $lang_email; ?></a></th>
								<th colspan="2"><?php echo $lang_action; ?></th>
							</tr>
								<?php
								$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
								while($data = mysql_fetch_array($req)){
										$nom = $data['nom'];
										$nom_html= addslashes($nom);
										$rue = $data['rue'];
										$ville = $data['ville'];
										$cp = $data['cp'];
										$mail =$data['mail'];
										$num = $data['num_client'];
										$civ = $data['civ'];
										$tel = $data['tel'];
										$nombre = $nombre +1;								
								?>
							<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
								
								<td class="highlight"><?php echo $nom; ?></td>			
								<td class="highlight"><?php echo $ville; ?></td>
								<td class="highlight"><?php echo $tel; ?></td>
								<td class="highlight"><a href="mailto:<?php echo $mail; ?>" ><?php echo "$mail"; ?></a></td>
								<td class="highlight"><a href='edit_client.php?num=<?php echo "$num" ?>'><img border='0'src='image/edit.gif' alt='Modifier la fiche spectateur'></a></td>
								<td class="highlight"><a href='del_client.php?num=<?php echo "$num"; ?>' onClick="return confirmDelete('<?php echo"$lang_cli_effa $nom_html ?"; ?>')"><img border='0'src='image/delete.png'  alt='<?php echo $lang_supprimer; ?>'></a></td>
								<?php
								} ?>
							</tr>
							<tr> 
								<td  colspan="6"><br><h1>Liste des spectateurs ayant un mail<br>(Copier coller les adresses. Pour les envois groupes ne pas oublie de mettre en cci)</h1> </td>
							</tr>
							<tr>
								<td colspan="6">
								<?php $req1 = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error()); 
									while($data = mysql_fetch_array($req1)){
									$mail =$data['mail'];
									echo  " $mail;" ;
									}  ?> 
									</td>
							
							</tr>
				</table>
			</center>
		</td>
	</tr>
	<tr>
		<td>
			<?php

			include("help.php");	
			echo"</td></tr><tr><td>";
			include_once("include/bas.php");
			?> 
		</td>
	</tr>
		<?php
		$url = $_SERVER['PHP_SELF'];
		$file = basename ($url);
		if ($file=="form_client.php") { 
		echo"</table>"; 
		} ?>
</table>
</body>
</html>
