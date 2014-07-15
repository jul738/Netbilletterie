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
?>

<script type="text/javascript" src="javascripts/confdel.js"></script>
<?php
include_once("include/finhead.php");
include_once("include/fonction.php");
?>

<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
			<h3>Liste des spectateurs</h3>
		</td>
	</tr>
	<tr>
		<td  class="page" align="center">
		<?php 
		if ($user_cli == n) { 
		echo"<h1>$lang_client_droit";
		exit;  
		}

		$initial=isset($_GET['initial'])?$_GET['initial']:"";
                                
                
                // requete sql avec les abonnement // 
                $sql = " SELECT DISTINCT C.num_client, C.nom, C.nom2, C.rue, C.ville, C.cp, C.mail, C.prenom, C.tel, C.fax, A.abonne_jp, A.abonne_chanson, A.abonne_date
                FROM client C, abonne A
                WHERE C.num_client = A.num_abonne
                AND C.nom LIKE '$initial%' 
		AND actif='y' 
                AND `C.num_client`!='1'";
                
		 if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
		{
		$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
		} 
		else {
		//$sql = " SELECT * FROM ".$tblpref ."client WHERE nom LIKE '$initial%' AND actif='y' AND `num_client`!='1' ORDER BY nom ASC";
                  $sql = " SELECT C.num_client, C.nom, C.nom2, C.rue, C.ville, C.cp, C.mail, C.prenom, C.tel, C.fax, A.abonne_jp, A.abonne_chanson, A.abonne_date
                FROM client C, abonne A
                WHERE C.num_client = A.num_abonne
                AND C.nom LIKE '$initial%' 
		AND actif='y' 
                AND C.num_client!='1'
                ORDER BY C.nom ASC";                
		  }
		$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                
                
//On recupere la date d aujourd hui (pour tester si abonne oui ou non /Oui si date_ajd est compris entre date_debut et date_fin dans abonnement_comm sinon /Non
$date_ajd = date('Y-m-d');  



		?>
			<center>
				<table id="datatables" class="display">
					<caption><?php echo $lang_clients_existants; ?></caption>
					<thead>
						<tr>
							
							<th>Nom</th>
                                                        <th>Prenom</th>
							<th><?php echo $lang_rue; ?></th>
							<th><?php echo $lang_code_postal; ?></th>
							<th><?php echo $lang_ville; ?></th>
							<th><?php  echo $lang_tele;?></th>
                                                        <th><?php echo $lang_abonne_chanson; ?></th>
                                                        <th><?php echo $lang_abonne_jp; ?></th> 
							<th><?php echo $lang_email; ?></th>                                                        
    							<th>Modifie</th>
                                                        <th>Reservations</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$nombre =1;
						while($data = mysql_fetch_array($req))
							{
								$num_client = $data['num_client'];
                                                                $nom = $data['nom'];
								$nom=stripslashes($nom);
								$nom2 = $data['nom2'];
								$rue = $data['rue'];
								$rue=stripslashes($rue);
								$ville = $data['ville'];
								$ville=stripslashes($ville);
								$cp = $data['cp'];
								$tva = $data['num_tva'];
								$mail =$data['mail'];
								$num = $data['num_client'];
								$prenom = $data['prenom'];
								$tel = $data['tel'];
								$fax = $data['fax'];
                                                                $abonne_chanson = $data['abonne_chanson'];
                                                                $abonne_jp = $data['abonne_jp'];
								$nombre = $nombre +1;
								if($nombre & 1){
								$line="0";
								}else{
								$line="1"; 
								}
                                                                
//Rq si abonnement afficher jp afficher oui sinon non / afficher concert oui sinon non 
$req_recup_abo = "SELECT ab.type_abonnement
                  FROM abonnement AS ab, abonnement_comm AS ac
                  WHERE ab.num_abonnement = ac.num_abonnement
                  AND ac.client_num = '$num'
                  AND ac.date_fin <= CURRENT_DATE";

$recup_abo_brut = mysql_query($req_recup_abo)or die('Erreur !<br>'.$req_recup_abo.'<br>'.mysql_error());
            $type_abonnement = '';
            while ($data5 = mysql_fetch_array($recup_abo_brut))
            {
            $type_abonnement = $data5['type_abonnement'];

            }
            ?>
					<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
							<td><?php echo $nom; ?></td>
                                                        <td><?php echo $prenom; ?></td>
							<td><?php echo $rue; ?></td>
							<td><?php echo $cp; ?></td>
							<td><?php echo $ville; ?></td>
							<td><?php echo $tel; ?></td>
                                                        <td><?php if ($type_abonnement == Concert) {echo "Oui";} else {echo "Non"; } ?></td>
                                                        <td><?php if ($type_abonnement == Spectacle_JP) {echo "Oui";} else {echo "Non"; } ?></td>
							<td><a href="form_mailing.php?nom=<?php echo "$num"; ?>" ><?php echo "$mail"; ?></a></td>
							<td><a href="edit_client.php?num=<?php echo "$num" ?>"><img border='0'src='image/edit.png' alt='<?php echo $lang_editer; ?>'></a></td>
                                                        <td class="highlight"><a href='voir_reservation_client.php?num_client=<?php echo "$num_client"; ?>' >
                            <img border="0" alt="voir" src="image/voir.gif" Title="Voir les reservation"></a></td>
                                                            <?php
							} ?>
					</tr>
					</tbody>
				</table>
			</center>
		</td>
	</tr>
</table>
<?php
include_once("include/bas.php");
?>

