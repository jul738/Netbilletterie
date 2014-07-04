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

// On récupère le numero de vente de l'abonnement
$num_abonnement=isset($_GET['num_abonnement'])?$_GET['num_abonnement']:"";

$req_recup_abo = "SELECT num_abonnement, nom_abonnement, nombre_spectacle, tarif_abonnement, selection
                  FROM abonnement
                  WHERE num_abonnement = '$num_abonnement'";
$recup_abo_brut = mysql_query($req_recup_abo) or die('Erreur SQL !<br>'.$req_recup_abo.'<br>'.mysql_error());		
            while($data = mysql_fetch_array($recup_abo_brut))
                {
    $nom_abonnement = $data['nom_abonnement'];
    $nombre_spectacle = $data['nombre_spectacle'];
    $tarif_abonnement = $data['tarif_abonnement'];
    $selection = $data['selection'];
                }
                
                
$req_recup_ancien_val = "SELECT nom_abonnement, nombre_spectacle, tarif_abonnement, type_abonnement
                         FROM abonnement
                         WHERE num_abonnement = '$num_abonnement'";
$recup_ancien_val_brut = mysql_query($req_recup_ancien_val)or die( "Execution requete -req_recup_ancien_val- impossible.");
        while($data7 = mysql_fetch_array($recup_ancien_val_brut))
        {
        $nom_abonnement_ancien = $data7['nom_abonnement'];
        $nombre_spectacle_ancien = $data7['nombre_spectacle'];
        $tarif_abonnement_ancien = $data7['tarif_abonnement'];
        $type_abonnement_ancien = $data7['type_abonnement'];
        }
                
?>

<form action='gerer_edit_update_abonnement.php' method="POST">
    <table border="0" class="page" align="center">
            <tr>
                    <td class="page" align="center">
                        <h3>Modification d'une formule d'abonnement  </h3>	
                    </td>
            </tr>
            <tr>
                <td>
                    <table class="boiteaction">
                        <caption> Renseigner les nouvelles donnees de l'Abonnement</caption>
                </td>
            </tr>
            <tr>
                    <th>Type d'abonnement</th>
                    <th>Nom de l'abonnement</th>
                    <th>Nombre de spectacles</th>
                    <th>Tarif de l'abonnement</th>
                    <th>Selectionnable</th>
            </tr>
            <tr>
                
            <tr>
                <th><?php $type_abonnement ; ?></th>
                <th><?php $nom_abonnement ; ?></th>
                <th><?php $nomre_spectacle ; ?></th>
                <th><?php $tarif_abonnement ; ?></th>
                <th><?php $selection ; ?></th>
            </tr>
            
            <tr>
                <td>
                    <SELECT name="type_abonnement_new">
                        <OPTION VALUE="<?php $type_abonnement_ancien ;?>"> <?php echo $type_abonnement_ancien ;?></OPTION>
                        <OPTION VALUE="Spectacle">Concert</OPTION>
                        <OPTION VALUE="Concert">Spectacles Jeunes Public</OPTION>
                    </SELECT>
                </td>
                <td>
                    <input type="text" name="nom_abonnement_new" SIZE="25" value="<?php echo $nom_abonnement_ancien ;?>">
                </td>
                <td>
                    <input type="number" name="nombre_spectacle_new" SIZE="2" value="<?php echo $nombre_spectacle_ancien ;?>">
                </td>
                <td>
                    <input type="number" name="tarif_abonnement_new" SIZE="2" value="<?php echo $tarif_abonnement_ancien ;?>">
                </td>
                <td>
                    <SELECT name="selection_new">
                        <OPTION VALUE="1">Oui</OPTION>
                        <OPTION VALUE="0">Non</OPTION>
                    </select>
                </td>
            </tr>
            
            <tr>
                <th class="submit" colspan="5"><input type="image" name="Submit" src='image/valider.png'></th>
                <input  name="num_abonnement" id="num_abonnement" type="hidden" value='<?php echo $num_abonnement; ?>'>
            </tr>
            </table>
    </table>             
</form>

<?php
include_once("include/bas.php");
?>