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

//récup info necessaire
$type_abonnement=isset($_POST['type_abonnement'])?$_POST['type_abonnement']:"";
$nom_abonnement=isset($_POST['nom_abonnement'])?$_POST['nom_abonnement']:"";
$nombre_spectacle=isset($_POST['nombre_spectacle'])?$_POST['nombre_spectacle']:"";
$tarif_abonnement=isset($_POST['tarif_abonnement'])?$_POST['tarif_abonnement']:"";


// req met a jour la table et creer une nouvelle formule d'abonnement
$req_new_abonnement = "INSERT INTO ". $tblpref ."abonnement(nom_abonnement, nombre_spectacle, tarif_abonnement, type_abonnement, selection)
                       VALUES ('$nom_abonnement', '$nombre_spectacle', '$tarif_abonnement', '$type_abonnement', '1')";
mysql_query($req_new_abonnement) or die('Erreur SQL !<br>'.$req_new_abonnement.'<br>'.mysql_error());


?>

    <table border="0" class="page" align="center">

            <tr>
                <caption>La formule d'abonnement a ete cree avec succes ! </caption>	
            </tr>
            
            <tr>
            <!-- Bouton : Lister les formules d'abonnement -->
                <td> 
                    <a href='gerer_new_abonnement.php'><img border =0 src="image/new_mini_abonnement.png" alt=""> <br> Ajouter une nouvelle formule d'abonnement </a>
                </td>

            <!-- Bouton : Créer une nouvelle formule d'abonnement  -->
                <td>
                    <a href='gerer_abonnement.php'><img border =0 src="image/lister_abonnement_gris.png" alt=""> <br> Lister les differentes formules d'abonnements </a>
                </td>
            </tr>
    </table>


<?php
include_once("include/bas.php");
?>