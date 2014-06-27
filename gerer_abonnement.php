<?php 
/* Net Billetterie Copyright(C)2012 Jose Das Neves
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jose Das Neves pitu69@hotmail.fr
Modification : Jules Murot [Colibre: http://colibre.org/ ] julesmurot8@gmail.com */
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("javascripts/verif_form.js");
include_once("include/head.php");
include_once("include/finhead.php");


//On liste tous les abonnements, actif comme pas actif
$req_liste_abonnement = "SELECT num_abonnement, nom_abonnement, tarif_abonnement, nombre_spectacle, type_abonnement, selection
                         FROM abonnement";
$liste_abonnement_brut = mysql_query($req_liste_abonnement) or die( "Execution requete -req_liste_abonnement- impossible.");
?>

<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
                    <h3>Liste des differentes formules d'Abonnements </h3>	
                </td>
        </tr>
        <tr>
		<td>
	      		<table class="boiteaction">
	  			<caption> Liste des abonnements </caption>
                </td>
	<tr>
            <th>Type d'abonnement</th>
            <th> Nom </th>
            <th> Prix </th>
            <th> Nombre de spectacles </th>
            <th> Selectionnable </th>
            <th colspan="2"> Action </th>

        </tr>
                <?php
		$nombre="1";
		while($data = mysql_fetch_array($liste_abonnement_brut))
                {
                $num_abonnement = $data["num_abonnement"];
                $nom_abonnement = $data["nom_abonnement"];
                $tarif_abonnement = $data["tarif_abonnement"];
                $nombre_spectacle = $data["nombre_spectacle"];
                $type_abonnement = $data["type_abonnement"];
                $selection = $data["selection"];
                $nombre = $nombre +1;
                    if($nombre & 1)
                        {
                        $line="0";
                        }else  
                            {
                            $line="1";
                            } 
		?>

        <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
                <td class="highlight"><?php echo "$type_abonnement"; ?></td>
		<td class="highlight"><?php echo "$nom_abonnement"; ?></td>
		<td class="highlight"><?php echo "$tarif_abonnement";?><?php echo "$devise";?></td>
		<td class="highlight"><?php echo "$nombre_spectacle"; ?></td>
                <td class="highlight"><?php if ($selection=='1') {echo "oui";} else {echo "non"; } ?></td>
                <td class="highlight"><a href='gerer_edit_abonnement.php?num_abonnement=<?php echo "$num_abonnement"; ?>'><img border=0 alt="<?php echo $lang_editer; ?>" src="image/edit.png"></a></td>
                <td class="highlight"><a href='gerer_delete_abonnement.php?num_abonnement=<?php echo "$num_abonnement"; ?>'><img border=0 alt="<?php echo $lang_suprimer; ?>" src="image/delete.png" ></a></td>
        </tr>
		
               <?php
		} //fin du while
		?>
			</table>
		</td>
	</tr>
	<tr>
		<td><a href='gerer_new_abonnement.php?num_abonnement=<?php echo "$num_abonnement"; ?>'><img border =0 src="image/new_mini_abonnement.png" alt=""> <br> Creer une formule d'abonnement</a>
		</td>
	</tr>
</table>

<?php
include_once("include/bas.php");
?>