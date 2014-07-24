<?php 
/* Net Billetterie Copyright(C)2012 Jose Das Neves
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Jose Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("javascripts/verif_form.js");
include_once("include/head.php");
include_once("include/finhead.php");

//ON calcule le prix moyen par billet, dabord on compte le nombres de billet vendu, ensuite on calcule la somme de ces billet, on divise la somme par le nombre. 

//SQL On compte le nombre de billet vendu
$req_compte_nb_billet = "SELECT COUNT(num)AS nb_billet
                         FROM cont_bon
                         WHERE prix_tarif != '0' OR ''";
$recup_compte_nb_billet_brut = mysql_query($req_compte_nb_billet) or die('Erreur count nb billet !<br>'.$req_compte_nb_billet.'<br>'.mysql_error());
                        while($data1 = mysql_fetch_array($recup_compte_nb_billet_brut))
                            {
                            $nb_billet = $data1['nb_billet'];
                            }

//SQL On compte la somme total que represente tous les bllet vendu
$req_compte_prix_total = "SELECT SUM(prix_tarif)AS prix_total
                          FROM cont_bon
                          WHERE prix_tarif != '0' OR ''";
$recup_compte_prix_total_brut = mysql_query($req_compte_prix_total) or die('Erreur count nb billet !<br>'.$req_compte_prix_total.'<br>'.mysql_error());
                        while($data2 = mysql_fetch_array($recup_compte_prix_total_brut))
                            {
                            $prix_total = $data2['prix_total'];
                            }


//On calcule le total des ventes par rapport au nombre de billet pour avoir le prix moyen : 
$prixmoyenparbillet = $prix_total / $nb_billet;
$nbr = number_format($prixmoyenparbillet,2);

?>


<table  class="page" align="center">
    
    <tr>
        <td class="page" align="center">
        <h3> Statistiques </h3>
        </td>
    </tr>
      
            <td  class="page" align="center">
                

    <table class="boiteaction">            
            <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo $line ?>'">
               <td class="highlight"> Prix moyen par billet :  <?php echo $nbr ;?> <?php echo $devise ; ?> </td>
            </tr>
            
            <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo $line ?>'">
               <td class="highlight"> Nombre de billets vendu :  <?php echo $nb_billet ;?> </td>
            </tr>
            
            <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo $line ?>'">
               <td class="highlight"> Somme genere par la vente des billets :  <?php echo $prix_total ;?> <?php echo $devise ; ?> </td>
            </tr>

    </table>
</table>








<?php
include_once("include/bas.php"); 
?>

