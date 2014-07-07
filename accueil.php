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
?>


<table  class="page" align="center">

    <tr>
        <td class="page" align="center">
             <h3>Les prochains spectacles :</h3>
        </td>
    </tr>
<?php

    $sql = "SELECT * FROM article 
            WHERE date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
    // est egale ou superieur a CURRENT_DATE, limit 3
?>
    <tr>
        <td  class="page" align="center">       </td>
</table>


<table  class="page" align="center">

    <tr>
        <td class="page" align="center">
             <h3>Les Differents tarifs d'abonnements : </h3>
        </td>
    </tr>
    
    <tr>
        <td  class="page" align="center">       </td>
</table>


- recap des tarif des abonnement 
- les 3 prochain spectacle
- le nombre d'abonne
- le nombre de client






<?php
include_once("include/bas.php");
?>