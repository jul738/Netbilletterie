<?php

/* Net Billetterie Copyright(C)2014 Vanessa Kovalsky David
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors: Vanessa Kovalsky vanessa.kovalsky@free.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");

// On récupère la liste des groupes

$select_groupes = "SELECT * FROM groupe";
$req_groupes = mysql_query($select_groupes) or die('Erreur sql groupes'.$select_groupes.'<br>'.mysql_error());

// ON affiche les groupes dans un tableau
?>
<center><table class="boiteaction page">
        <caption>Liste des groupes</caption>
        <tr>
            <th>Nom de la structure</th>
            <th>Rue</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Voir</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        
        <?php
        while($data_groupes = mysql_fetch_array($req_groupes)){
          $num_groupe = $data_groupes['num_groupe'];
          $nom_structure = $data_groupes['nom_structure'];
          $rue_structure = $data_groupes['rue'];
          $cp_structure = $data_groupes['cp'];
          $ville_structure = $data_groupes['ville'];
          $telephone_structure = $data_groupes['telephone'];
          $email_structure = $data_groupes['email'];
          ?>
        <tr onmouseover="this.className='highlight'" onmouseout="this.className='texte <?php echo "$line" ?>'">
            <td class="highlight"><?php echo $nom_structure;?></td>
            <td class="highlight"><?php echo $rue_structure;?></td>
            <td class="highlight"><?php echo $cp_structure;?></td>
            <td class="highlight"><?php echo $ville_structure;?></td>
            <td class="highlight"><?php echo $telephone_structure;?></td>
            <td class="highlight"><?php echo $email_structure;?></td>
            <td class="highlight"><a href='groupe.php?num_groupe=<?php echo $num_groupe;?>'><img border="0" title="Voir le groupe" src="image/voir.gif" alt="voir"></a></td>
            <td class="highlight"><a href='form_groupe.php?num_groupe=<?php echo $num_groupe;?>'><img border="0" alt="Modifier"  title="Modifier le groupe"src="image/edit.png"></a></td>
            <td class="highlight"><a href='delete_groupe.php?num_groupe=<?php echo $num_groupe;?>'><img border="0" title="Supprimer le groupe" alt="delete" src="image/delete.png"></a></td>
        </tr>
        <?php
        } // fin du while data_groupes
        ?>
    </table></center>
<?php
include_once("include/bas.php");
?>