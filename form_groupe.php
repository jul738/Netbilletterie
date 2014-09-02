<?php 
/* Net Billetterie Copyright(C)2014 Vanessa Kovalsky David
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Vanessa Kovalsky vanessa.kovalsky@free.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");

// On fait les requêtes SQL qui vont bien si un ID est passé
if(isset($_GET['num_groupe'])){
    $num_groupe = $_GET['num_groupe'];
    $requete_groupe = "SELECT nom_structure, adresse, telephone FROM groupe WHERE num_groupe = ".$num_groupe."";
    $sql_groupe = mysql_query($requete_groupe) or die('Erreur SQL sélection groupe !<br>'.$requete_groupe.'<br>'.mysql_error());
    while($data_groupe = mysql_fetch_array($sql_groupe)){
        $nom_structure = $data_groupe['nom_structure'];
        $adresse_structure = $data_groupe['adresse'];
        $telephone_structure = $data_groupe['telephone'];
    }
}

// On crée le fomulaire
?>
<div id="form-groupe">
    <h3>Formulaire de création d'un groupe</h3>
        <form action="groupe.php" method="post" name="form-groupe" id="form-groupe">
            <label for="nom-groupe">Nom de la structure</label> : <input type='text' name="nom-groupe" id="nom-groupe" required <?php if(isset($nom_structure)){ echo "value=".$nom_structure.""; }; ?>><?php if(isset($nom_structure)){ echo $nom_structure;}; ?></input><br />
            <label for="adresse-groupe">Adresse de la structure</label> : <textarea name="adresse-groupe" id="adresse-groupe" required <?php if(isset($adresse_structure)){ echo "value=".$adresse_structure."";}; ?>><?php if(isset($adresse_structure)){ echo $adresse_structure;}; ?></textarea><br />
            <label for="telephone-groupe">Téléphone de la structure</label> : <input type="tel" name="telephone-groupe" id="telephone-groupe" required <?php if(isset($telephone_structure)){ echo "value=".$telephone_structure.""; }; ?>><?php if(isset($telephone_structure)){ echo $telephone_structure;}; ?></input><br />
            <?php if(isset($num_groupe)){
              ?>
            <input type="hidden" name="num-groupe" id="num-groupe" value="<?php echo $num_groupe; ?>"></input>
            <?php
            }
            ?>
            <input type="submit" name="valider-groupe" id="valider-groupe" value="Créer le groupe"></input>
        </form>
</div>
<?php
include_once("include/bas.php");
?>