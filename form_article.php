<?php 
/* Net Billetterie Copyright(C)2012 Jose Das Neves
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jose Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("javascripts/verif_form.js");
include_once("include/head.php");
include_once("include/finhead.php");
?>

<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
<h3>Formulaire de creation de spectacle</h3>
</td>
</tr>
<tr>
<td  class="page" align="center">
<?php 
if ($user_art == n) { 
echo "<h1>$lang_article_droit";
exit;  
}
 if ($message1 !='') {
 echo"<table><tr><td>$message1</td></tr></table>";
}


$jour = date("d");
$mois = date("m");
$annee = date("Y");?>
  
      <form action="article_new.php" method="post" name="article" id="article" onSubmit="return verif_formulaire()" enctype="multipart/form-data" >
        <center><table>
          <caption>
          <?php echo $lang_article_creer; ?>
          </caption>

          <tr> 
              <td class="texte0"> <?php echo "$lang_art_no"; ?> <small>(sans Apostrophe )</small></td>
            <td align=left> <input name="article" type="text" id="article" size="80" maxlength="40">
            </td>
          </tr>
          
  <!--        <tr>
                <td class="texte1"> Representation numero : </td>
                <td class="texte1">
                    <SELECT name="numero_representation">
                        <OPTION VALUE="1">1</OPTION>
                        <OPTION VALUE="2">2</OPTION>
                        <OPTION VALUE="3">3</OPTION>
                        <OPTION VALUE="4">4</OPTION>
                        <OPTION VALUE="5">5</OPTION>
                        <OPTION VALUE="6">6</OPTION>
                        <OPTION VALUE="7">7</OPTION>
                        <OPTION VALUE="8">8</OPTION>
                        <OPTION VALUE="9">9</OPTION>
                        <OPTION VALUE="10">10</OPTION>
          </tr> -->
		                  
            <tr> 
                <td class="texte1"> Type d'evenement : </td>
                <td class="texte1">
                    <SELECT name="type_article">
                        <OPTION VALUE="Spectacle_JP">Spectacle Jeune Public</OPTION>
                        <OPTION VALUE="Concert">Concert</OPTION>
                        <OPTION VALUE="Chorale">Chorale</OPTION>
                        <OPTION VALUE="Theatre">Theatre</OPTION>
                        <OPTION VALUE="Conference_Debat">Conference et Debat</OPTION>
                        <OPTION VALUE="Experience_numerique">Experience Numerique</OPTION>
                        <OPTION VALUE="Art_numerique">Art numerique</OPTION>
                        <OPTION VALUE="Spectacle">Spectacle</OPTION>
                        <OPTION VALUE="Autre">Autre</OPTION>
                    </select>
                </td>
	    </tr>      
        
	    <tr> 
                <td class="texte0">Lieu </td>
                <td align=left> <input name="lieu" type="text" id="lieu" size="40" maxlength="40">
                </td>
            </tr>
		  
            <tr> 
                <td class="texte0">Horaire</td>
                <td align=left> <input name="horaire" type="text" id="horaire" size="20" maxlength="40">
                </td>
            </tr>
		  

            <tr> 
            <td class="texte0">Date </td>
            <td class="texte0">
                        Jour(JJ)
			<input name="jour" type="text" id="jour" size="8" maxlength="2">
			Mois(MM)
            <input name="mois" type="text" id="mois" size="8" maxlength="2">
			Annee (AAAA)
            <input name="annee" type="text" id="annee" size="16" maxlength="4"></td>
         
            <!-- td class='< ?php echo couleur_alternee (); ?>'> < ?php echo $lang_prix_uni; ?></td>
            <td class='< ?php echo couleur_alternee (FALSE); ?>'> <input name="prix" type="text" id="prix"> &euro;</td> -->
            </tr> 
            
            <tr> 
                <td class='<?php echo couleur_alternee (); ?>'> <?php echo "$langCommentaire" ?> : </td>
                <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="commentaire" type="text" size="80" id="commentaire">
                </td>
            </tr>
            
	  <tr>
            <td class='<?php echo couleur_alternee (); ?>'>Nombres de places en ventes :</TD>
            <td align=left><input name='stock' type='text'> </td>
	  </tr>
          
	  <tr>
            <td class='<?php echo couleur_alternee (); ?>'>Alerte places restantes : </td>
            <td align=left><input name='stomin' type='text'></td>
	  </tr>
          
	  <tr>
            <td class='<?php echo couleur_alternee (); ?>'>Capacite totale de la salle : </td>
            <td align=left><input name='stomax' type='text'></td>
	</tr>

	<tr>
		<td class='<?php echo couleur_alternee (); ?>'>
				<input type="hidden" name="MAX_FILE_SIZE" value="100000">
				Fichier au format 100 px HT. x 190 px larg.: 
		</td>
     
     
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
		<td align=left> <input name="cheminimage"  type="text" SIZE="60" readonly="readonly" onclick="openKCFinder(this)"
			value="<?php if ($logo!=""){echo $logo;} else {echo"Choisir une image jpg";}?>" /><br/> Cliquez dans la case ci dessus pour choisir un fichier image <br/> 
			puis cliquer sur parcourir pour choisir l'image a telecharger depuis votre ordinateur<br/>et enfin double cliquer sur cette derniere.
		</td>
	</tr>
            <td class="submit" colspan="2"> <input type="image" name="Submit" src="image/valider.png" value="Demarrer"  border="0"> 
              </td>
          </tr>
        </table></center>
      </form>
<?php
$aide = article;
require_once("lister_articles.php");
?>





