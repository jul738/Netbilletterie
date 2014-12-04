<?php
// Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
// Lister abonnement.php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
include_once("include/configav.php");


$num_client=isset($_GET['num_client'])?$_GET['num_client']:"";

//Recupere toutes les info client et on les insere dans le formulaire
                    
        $req_recup_horaire_date = "SELECT *
                                   FROM client
                                   WHERE num_client = '$num_client'";
$recup_horaire_date_brut = mysql_query($req_recup_horaire_date) or die('Erreur SQL1 !<br>'.$$req_recup_horaire_date.'<br>'.mysql_error());
                            while($data2 = mysql_fetch_array($recup_horaire_date_brut))
                                {
                                $nom_duplique = $data2['nom'];
                                $prenom_duplique = $data2['prenom'];
                                $rue_duplique = $data2['rue'];
                                $ville_duplique = $data2['ville'];
                                $tel_duplique = $data2['tel'];
                                $mail_duplique = $data2['mail'];
                                $cp_duplique = $data2['cp'];
                                }  
?>

<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
				<h3>Formulaire de creation de spectateur</h3>
		</td>
	<tr>
		<td  class="page" align="center">
		<?php 
		if ($user_cli == n) { 
		echo"<h1>$lang_client_droit";
		exit;  
		}
		 ?> 
		<form action="client_new.php" method="post" enctype="application/x-www-form-urlencoded" name="client" id="dupliquer-client" onSubmit="return check();">
                    <center>
                    <table >
				<caption><?php echo $lang_client_ajouter; ?></caption>
				<tr> 
					<td class="texte1">Nom</td>
					<td class="texte1"><input name="nom" type="text" id="nom" value="<?php echo $nom_duplique ;?>" onKeyUp="javascript:couleur(this);"></td>
				</tr>
                                <tr> 
					<td class="texte1">Prenom</td>
					<td class="texte1"><input name="prenom" type="text" id="nom" value="<?php echo $prenom_duplique ;?>" onKeyUp="javascript:couleur(this);"></td>
				</tr>
				<tr> 
					<td class="texte0"><?php echo $lang_rue; ?></td>
					<td class="texte1"><input name="rue" type="text" id="rue" value="<?php echo $rue_duplique ;?>"> </td>
				</tr>
				<tr> 
					<td class="texte1"><?php echo $lang_code_postal; ?> </td>
					<td class="texte0"><input name="code_post" type="text" id="code_post" value="<?php echo $cp_duplique ;?>"> </td>
				</tr>
				<tr> 
					<td  class="texte0"><?php echo $lang_ville; ?></td>
					<td class="texte1"><input name="ville" type="text" id="ville" value="<?php echo $ville_duplique ;?>"> </td>
				</tr>				
				<tr> 
					<td class="texte1"><?php echo $lang_tele; ?></td>
					<td class="texte1"><input name="tel" type="text" id="tel" value="<?php echo $tel_duplique ;?>"> </td>
				</tr> 
				<tr> 
					<td  class="texte0"><?php echo $lang_email; ?></td>
					<td class="texte1"><input name="mail" type="text" value="<?php echo $mail_duplique ;?>" onKeyUp="javascript:couleur(this);"> </td>
				</tr>
				<tr>
					<td  class="texte1">Confirmer l'<?php echo $lang_email; ?></td>
					<td class="texte0"><input name="mail2" type="text" value="<?php echo $mail_duplique ;?>" onKeyUp="javascript:couleur(this);"> </td>
				</tr>
				<tr> 
					<td class="submit" colspan="2">
                                                <input type="hidden" name="client-parent" value="<?php echo $num_client; ?>" />
						<input type="image" name="Submit" src="image/valider.png" value="Demarrer"  border="0">
					</td>
				</tr>
                                
			</table>
                    </center>
		</form>
		</td>
	<tr/>
<?php 
include("lister_clients.php");
?>


<?php
include_once("include/bas.php");
?>
