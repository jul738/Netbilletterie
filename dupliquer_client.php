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
			<?php
			if($message!=''){
				echo"<tr><TD>$message</tr><tr>";
				if($user_com=='y'){
			?> 
				<tr>
					<td>
						<form name="formu" method="get" action="bon.php" onSubmit="return verif_formulaire()">
						<center> <table>
							<tr>
									<?php 
									$jour = date("d");
									$mois = date("m");
									$annee = date("Y");?>
								<td class="texte0"><?php echo "date" ?></td>
								<td class="texte0"><input type="text" name="date" value="<?php echo"$jour/$mois/$annee" ?>" readonly="readonly"/></td>
							</tr>
							<tr>
								<td class="texte0">Choisir le<?php echo "$lang_tarif";?>
										<?php
										$rqSql3= "SELECT id_tarif, nom_tarif, prix_tarif, DATE_FORMAT(saison, '%d/%m/%Y' ) AS date FROM " . $tblpref ."tarif
												WHERE saison
												BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
												AND selection=1
												ORDER BY nom_tarif ASC";
												$result3 = mysql_query( $rqSql3 ) or die( "Execution requete $rqSql3 impossible.");?>
								</td>
									<script type="text/javascript">
									function verif_formulaire(){
										if(document.formu.id_tarif.value == "")  {
											alert("Veuillez Choisir le tarif!");
											document.formu.id_tarif.focus();
											return false;
										}
									}
									</script>
								<td class="texte0">
									<SELECT NAME='id_tarif'>
										<OPTION VALUE="">Choisissez </OPTION>
											<?php
											while ( $row = mysql_fetch_array( $result3)) 
											{
												$id_tarif = $row["id_tarif"];
												$nom_tarif = $row["nom_tarif"];
												$prix_tarif = $row["prix_tarif"];
											?>
										<OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
											 <?php
											}
											?>
									</SELECT>
								</td>
							<tr>
								<input type="hidden" name="listeville" value='<?php if ( $num==""){echo $client;} else {echo $num;} ?>'>
								<td class="submit" colspan="6"> <input type="submit" name="Submit" value="Creer une reservation pour <?php $nom=stripslashes($nom); echo "$civ $nom"; ?>"> </td>
							</tr>
						</table></center>
						</form>
					</td>
				</tr>
			<?php
			} }
			?>
	<tr>
		<td  class="page" align="center">
		<?php 
		if ($user_cli == n) { 
		echo"<h1>$lang_client_droit";
		exit;  
		}
		 ?> 
		<form action="client_new.php" method="post" enctype="application/x-www-form-urlencoded" name="client" onSubmit="return check();">
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
						<input type="image" name="Submit" src="image/valider.png" value="Demarrer"  border="0">
					</td>
				</tr>
                                
			</table>
		</form>
		</td>
	<tr/>
<?php 
include("lister_clients.php");
?>


<?php
include_once("include/bas.php");
?>
