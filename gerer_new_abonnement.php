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


<form action='gerer_new_update_abonnement.php' method="POST">
    <table border="0" class="page" align="center">
            <tr>
                    <td class="page" align="center">
                        <h3>Creation d'une nouvelle formule d'abonnement : </h3>	
                    </td>
            </tr>
            <tr>
                <td>
                    <table class="boiteaction">
                        <caption> Renseigner les donnees de l'abonnement</caption>
                </td>
            </tr>
            <tr>
                    <th>Type d'abonnement</th>
                    <th>Nom de l'abonnement</th>
                    <th>Nombre de spectacle</th>
                    <th>Tarif de l'abonnement</th>
            </tr>
            <tr>
                <td>
                    <SELECT name="type_abonnement">
                        <OPTION VALUE="Spectacle">Concert</OPTION>
                        <OPTION VALUE="Concert">Spectacles Jeunes Public</OPTION>
                    </SELECT>
                </td>
                <td>
                    <input type="text" name="nom_abonnement" SIZE="25">
                </td>
                <td>
                    <input type="number" name="nombre_spectacle" SIZE="2">
                </td>
                <td>
                    <input type="number" name="tarif_abonnement" SIZE="2">
                </td>
            </tr>
            <tr>
                <th class="submit" colspan="4"><input type="image" name="Submit" src='image/valider.png'></th>
            </tr>
            </table>
    </table>             
</form>

<?php
include_once("include/bas.php");
?>

