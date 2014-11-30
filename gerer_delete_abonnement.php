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

$req_recup_abo = "SELECT num_abonnement, nom_abonnement, nombre_spectacle, tarif_abonnement, type_abonnement
                  FROM abonnement
                  WHERE num_abonnement = '$num_abonnement'";
$recup_abo_brut = mysql_query($req_recup_abo) or die('Erreur SQL !<br>'.$req_recup_abo.'<br>'.mysql_error());		
            while($data = mysql_fetch_array($recup_abo_brut))
                {
    $nom_abonnement = $data['nom_abonnement'];
                }
?>

<br/><br/>

<table border="0" class="page" align="center">
    
    <caption> L'abonnement <?php $nom_abonnement ;?> a bien ete supprime </caption>
               
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
$req_delete_formule_abo = "DELETE FROM abonnement
                           WHERE num_abonnement = '$num_abonnement'";
mysql_query($req_delete_formule_abo) or die('Erreur SQL !<br>'.$req_delete_formule_abo.'<br>'.mysql_error());
?>

<?php
include_once("include/bas.php");
?>