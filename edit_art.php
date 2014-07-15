<?php 
/* Net Billetterie Copyright(C)2012 Jose Das Neves
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jose Das Neves pitu69@hotmail.fr*/
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/configav.php");
include_once("include/language/$lang.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");

if ($user_art == n) { 
echo "<h1>$lang_article_droit";
exit;  
}

$article=isset($_GET['article'])?$_GET['article']:"";
$sql = "SELECT * FROM " . $tblpref ."article  
 WHERE num=$article";

$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$article = $data['article'];
		$article=stripslashes($article);
                $numero_representation = $data['numero_representation'];
		$num =$data['num'];
		$lieu =$data['lieu'];
		$horaire =$data['horaire'];
                $annule =$data['annule'];
		$date =$data['date_spectacle'];
		$prix = $data['prix_htva'];
		$tva = $data['taux_tva'];
		$uni = $data['uni'];
		$stock = $data['stock'];
		$min = $data['stomin'];
		$max = $data['stomax'];
		$commentaire = $data['commentaire'];
		$image = $data['image_article'];
		}
	?>		
<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center"><?php echo"<h3>$lang_modi_no $article </h3>"; ?></td>
	</tr>
	<tr>
		<td class="page" align="center">
			<center>
				<form action="article_update.php" method="post" name="id_tarif" id="id_tarif">
					<table class="boiteaction">
						<tr class="texte">
                                                    <th>Annule</th>
							<th><?php  echo "$lang_article" ;?></th>
                                                        <th> Type d'evenement </th>
                                                        <th>Representation numero</th>
							<th>Lieu</th>
							<th>Horaire</th>
							<th>Date (aaaa-mm-jj)</th>
							<th><?php echo "$lang_stock"; ?></th>
							<th><?php echo "$lang_stomax"; ?></th>
							<th><?php echo "$lang_stomin"; ?></th>
							<th>Commentaire</th>
						</tr>
						<tr>
                                                        <td><select name="annule">
                                                            <option value="0"selected>non</option> 
                                                            <option value="1">oui</option>
                                                            </select>
                                                        </td>
                                                
							<td><input name="article" type="text" size="15" value ="<?php echo"$article" ; ?> "></td>
                                                        <td class="texte1">
                                                            <SELECT name="type_article">
                                                                <OPTION VALUE="Spectacle">Spectacle</OPTION>
                                                                <OPTION VALUE="Spectacle_JP">Spectacle Jeune Public</OPTION>
                                                                <OPTION VALUE="Concert">Concert</OPTION>
                                                                <OPTION VALUE="Chorale">Chorale</OPTION>
                                                                <OPTION VALUE="Theatre">Theatre</OPTION>
                                                                <OPTION VALUE="Conference_Debat">Conference et Debat</OPTION>
                                                                <OPTION VALUE="Experience_numerique">Experience Numerique</OPTION>
                                                                <OPTION VALUE="Art_numerique">Art numerique</OPTION>
                                                                <OPTION VALUE="Autre">Autre</OPTION>
                                                            </select></td>
                                                        <td><input name="numero_representation" type="number" size="5" value ="<?php echo"$numero_representation" ;?>"></td>
							<td><input name="lieu" type="text" size="5" value ="<?php echo"$lieu" ;?>"></td>
							<td><input name="horaire" type="text" size="10" value ="<?php echo"$horaire" ;?>"></td>
							<td><input name="date" type="text" size="10" value ="<?php echo"$date" ;?>"></td>
							<td><input name="stock" type="text" size="5" value ="<?php echo"$stock" ;?>"></td>
							<td><input name="max" type="text" size="5" value ="<?php echo"$max" ;?>"></td>
							<td><input name="min" type="text" size="5" value ="<?php echo"$min" ;?>"></td>
							<td><input name="commentaire" type="text" size="10" value ="<?php echo"$commentaire" ;?>"></td>
						</tr>
						<tr>
						<th  colspan="2">Image<br/> <img src="<?php echo $image;?>"  height="100" ></th>
								<script type="text/javascript">
								function openKCFinder(field) {
								window.KCFinder = {
								callBack: function(url) {
								field.value = url;
								window.KCFinder = null;
								}
								};
								window.open('<?php echo $url_root;?>/kcfinder/browse.php?type=images&lang=fr&dir=images/public', 'kcfinder_textbox',
								'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
								'resizable=1, scrollbars=0, width=800, height=600'
								);
								}
								</script>
						<td  colspan="6" align="left"> <input name="image"  type="text" SIZE="60" readonly="readonly" onclick="openKCFinder(this)"
							value="<?php if ($image!=""){echo $image;} else {echo"Choisir une image jpg";}?>" /><br/> Cliquez dans la case ci dessus pour choisir un fichier image: hauteur 100px<br/> 
							puis cliquer sur upload pour choisir l'image a telecharger depuis votre ordinateur<br/>et enfin double cliquer sur cette derniere.
						</td>
                                                </tr>
						<tr>
							<td colspan="3" class="submit">
							<input name="num" type="hidden" value= <?php echo "$num" ;?></td>
							<td class="submit" colspan="4"> <input type="image" name="Submit" src="image/valider.png" value="Demarrer"  border="0"> 
							<td colspan="4" class="submit"></td>
						</tr>
					</table>
				</form>	
			</center>			
		</td>
	</tr>
	
</table>
		
<?php

include_once("include/bas.php");
?>
</td></tr></table>
