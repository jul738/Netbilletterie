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


$article_numero=isset($_GET['article'])?$_GET['article']:"";
$client_num=isset($_GET['nom'])?$_GET['nom']:"";


?>

<script type="text/javascript">
	function verif_formulaire()
	{
		if(document.edit.article.value == "")  
		{
			alert("Veuillez Choisir un spectacle!");
			document.edit.article.focus();
			return false;
		}
		if(document.edit.titre.value == "")  
		{
			alert("Veuillez donner un titre au message!");
			document.edit.titre.focus();
			return false;
		}
		if (agree=confirm("Veuillez confirmer l'envoi du message?"))
		{
		alert("Attention, si la liste des destinataires est longues, cela peut prendre plusieurs minutes!");
		return true ;
		}

		else
		return false ;				
	}
</script>

<table border="0" class="page" align="center">
	<?php
	if ($user_dep !='y') { ?>
	<tr>
		<td class="page" align="center">
			<?php echo "<h1>$lang_admin_droit";
			exit; ?>
		</td>
	</tr>
		<?php } 
		//pour que les articles de la selection soit de la saison du moment
		$mois = date("n");
		$annee = date("Y");
		$annee_1= $annee ;
		if ($mois <= 6)
			{
			$annee_1=$annee_1;
			}
		if ($mois >= 7)
			{
			$annee_1=$annee_1+1;
			}
			$annee_2= $annee_1 -1;

		$rqSql_article = "SELECT num, article, date_spectacle FROM " . $tblpref ."article
			WHERE  date_spectacle
				BETWEEN '$annee_2-08-01'
				AND '$annee_1-07-01'
			ORDER BY date_spectacle";
			$result_article = mysql_query( $rqSql_article )or die( "Exécution requête impossible_article.");
		?>
	<tr>
		<td  class="page" align="center">
			<form action="mailing.php" method="post" id="edit" name="edit" onSubmit="return verif_formulaire()">
				<table class="boiteaction">
					<tr>
						<h1>Vous voulez envoyer un mail aux spectateurs?<br> Selectionner le spectacle  </h1>
					</tr>
					<tr>
							<SELECT NAME="article" align="center">
								<OPTION VALUE="">Choisissez le spectacle</OPTION>
								<?php
									while($data = mysql_fetch_array($result_article))
									{
									$article_numero = $data['num'];
									$article = $data['article'];
									$date = $data['date_spectacle'];
									list($annee, $mois, $jour) = explode("-", $date);
									?>
								<OPTION VALUE="<?php echo $article_numero; ?>"><?php echo " $article $jour-$mois-$annee"; ?></OPTION>
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
							<input type="image" name="Submit" src="image/envoyer.png" value="Démarrer"  border="0" ><h1>Attention, si la liste de destinataires est longue, cela peut prendre plusieurs minutes! <br />Soyez patient! </h1>
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

