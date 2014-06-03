<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head_mailing.php");
include_once("include/head.php");
include_once("include/finhead.php");
$Sql_spectateur = "SELECT num_client, nom FROM ".$tblpref."client 
WHERE actif != 'non' 
AND nom!='caisse soirée'
ORDER BY nom ASC";
$result_spectateur = mysql_query( $Sql_spectateur )or die( "Exécution requête impossible_spectateur.");
?>


<table border="0" class="page" align="center">
	<?php
	if ($user_dep !='y') { ?>
	<tr>
		<td class="page" align="center">
			<?php echo "<h1>$lang_admin_droit";
			exit; }?>
		</td>
	</tr>
	<tr>
				<script type="text/javascript">
				function verif_formulaire()
				{
					if(document.formu.client_num.value == "")  {
						alert("Veuillez Choisir un spectateur!");
						document.formu.client_num.focus();
						return false;
					}
					if(document.formu.titre.value == "")  {
						alert("Veuillez Choisir un titre!");
						document.formu.titre.focus();
						return false;
					}
					
					if (agree=confirm("Veuillez confirmer l'envoi du message?"))
					{
						alert("Attention, si la liste des destinataires est longues, cela peut prendre plusieurs minutes!");
						return true ;}
					
					else
					return false ;				
					
				}
				</script>
		<td  class="page" align="center">
			<form action="mailing.php" method="post"  name="formu" onSubmit="return verif_formulaire()">
				<table class="boiteaction">
					<tr>
						<h1>Vous voulez envoyer un mail à un spectateur?<br> Selectionner le dans le menu déroulant  </h1>
					</tr>
					<tr>
							<SELECT NAME="client_num" align="center">
								<OPTION VALUE="">Choisissez le spectateur</OPTION>
								<?php
									while($data = mysql_fetch_array($result_spectateur))
									{
									$client_num = $data['num_client'];
									$nom = $data['nom'];
									?>
								<OPTION VALUE="<?php echo $client_num; ?>"><?php echo $nom; ?></OPTION>
								<?php } ?>
							</SELECT>
					</tr>
					<tr>
						<td class="texte0"><?php echo $lang_mailing_list_titremessage; ?><input type="text" name="titre"></td>
					</tr>
					<tr>
						<td class="texte0"><h1><?php echo  "$lang_mailing_list_message"; ?></h1></td>
						<td>
							<noscript>
								<strong>CKEditor requires JavaScript to run</strong>. In a browser with no JavaScript
								support, like yours, you should still see the contents (HTML data) and you should
								be able to edit it normally, without a rich editor interface.
							</noscript>
						</td>
					</tr>
					<tr>
						<td>
						<textarea class="ckeditor" cols="80" id="editor1" name="message" rows="10"><?php echo $signature; ?></textarea>
							<script type="text/javascript">
							CKEDITOR.replace( 'editor1' );
							</script>
						</td>
					 </tr>
						<td class= "submit" colspan="2">
							<input type="image" name="Submit" src="image/envoyer.png" value="Démarrer"  border="0">
						</td>
					</tr>
				</table>
			</form>
			<?php 
			$aide = mailing;
			?><!-- InstanceEndEditable --> 
		</td>
	</tr>
</table>
<?php
include_once("include/bas.php");
?>

