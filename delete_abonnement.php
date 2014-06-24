<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
include_once("include/configav.php");

// On récupère le numero de vente de l'abonnement
$num_abo_com=isset($_GET['num_abo_com'])?$_GET['num_abo_com']:"";

?>
<!-- test variable $num_abo_com : (<?php // echo $num_abo_com ; ?>) -->

<form method='post' action='new_fin_abonnement.php'>
<table border="0" class="page" align="center">
    <tr>    
        <td class="page" align="center">
            <h3> Suppression d'Abonnement </h3>
        </td>
    </tr>
    <tr>
        <th> L'abonnement a ete supprime avec succes ! </th>
    </tr>
    
    <tr>   
        <th>
            <!-- lister les abonnement -->
            <form action='lister_abonnement.php'> <br/>
                        <input type="submit" name="Submit" value="Lister les abonnement" onclick="self.location.href='new_abonnement.php'"><br/><br/>
            </form>
        </th>
    </tr>
    <tr>
        <th>
            <!-- Bouton pour créer un nouvel  -->
                    <form action='new_abonnement.php'> <br/>
                        <input type="submit" name="Submit" value="Ajouter un autre abonnement" onclick="self.location.href='new_abonnement.php'"><br/><br/>
                    </form>
        </th>
    </tr>                
    </table>
</form>
<?php
$req_delete_abo = "DELETE 
                   FROM abonnement_comm
                   WHERE num_abo_com = '$num_abo_com'";
$delete_abo = mysql_query( $req_delete_abo )or die( "Il y à eu une erreur lors de la supression de l'abonnement");
?>

<?php
include_once("include/bas.php");
?>
