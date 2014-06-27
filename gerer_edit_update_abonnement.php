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

//On continue des récupérer le $num_abonnement qui est l'ID de l'abonnement que l'on edit
$num_abonnement=isset($_POST['num_abonnement'])?$_POST['num_abonnement']:"";

//On récupère les nouvelles informations de l'abonnement
$type_abonnement_new=isset($_POST['type_abonnement_new'])?$_POST['type_abonnement_new']:"";
$nom_abonnement_new=isset($_POST['nom_abonnement_new'])?$_POST['nom_abonnement_new']:"";
$nombre_spectacle_new=isset($_POST['nombre_spectacle_new'])?$_POST['nombre_spectacle_new']:"";
$tarif_abonnement_new=isset($_POST['tarif_abonnement_new'])?$_POST['tarif_abonnement_new']:"";
$selection_new=isset($_POST['selection_new'])?$_POST['selection_new']:"";


// req met a jour la table et creer une nouvelle formule d'abonnement
$req_update_abonnement = "UPDATE abonnement
                          SET nom_abonnement = '$nom_abonnement_new', nombre_spectacle = '$nombre_spectacle_new', tarif_abonnement = '$tarif_abonnement_new', type_abonnement = '$type_abonnement_new', selection = '$selection_new'
                          WHERE num_abonnement = '$num_abonnement'";
mysql_query($req_update_abonnement) or die('Erreur SQL !<br>'.$req_update_abonnement.'<br>'.mysql_error());


?>

    <table border="0" class="page" align="center">

            <tr>
                <caption>La formule d'abonnement a ete mis a jour avec succes ! </caption>	
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