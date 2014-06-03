<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
DÃ©veloppÃ© depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : JoséDas Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php"); 
include_once("include/headers.php");
include_once("include/fonction.php");?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<?php
include_once("include/head.php");
include_once("include/finhead.php");

  //=============
  /* Les POST*/
 //==============
 $id_type_paiement=isset($_POST['id_type_paiement'])?$_POST['id_type_paiement']:"";
 $new=isset($_POST['new'])?$_POST['new']:"";
 $nom=isset($_POST['nom'])?$_POST['nom']:"";
 $update=isset($_POST['update'])?$_POST['update']:"";
   //=============
  /* Les GET*/
 //==============
 $delete=isset($_GET['delete'])?$_GET['delete']:"";
 $id_type_paiement=isset($_GET['id_type_paiement'])?$_GET['id_type_paiement']:"";
 

  //=====================================================
  /*  pour changer le nom de la type_paiement */
 //===================================================== 
 if($update=="y"){
 $sql4 = "UPDATE " . $tblpref ."type_paiement SET `nom`='" . $nom . "' WHERE `id_type_paiement` = '".$id_type_paiement."'";
mysql_query($sql4) OR die("<p>Erreur Mysql4<br/>$sql4<br/>".mysql_error()."</p>");
}
 //=====================================================
  /*  pour ajouter un type_paiement */
 //===================================================== 
 if($new=="y"){
 $sql5 = "INSERT INTO " . $tblpref ."type_paiement ( id_type_paiement, date, nom) VALUES (NULL, CURRENT_TIMESTAMP , '".$nom."') ";
mysql_query($sql5) OR die("<p>Pour des raisons technique vous ne pouvez pas avoir d'apostrophe dans le nom des types de paiements. </p>");
}

 //=====================================================
  /*  pour supprimer un type_paiement */
 //===================================================== 
 if($delete=="y"){  
 $sql6 = "DELETE FROM " . $tblpref ."type_paiement WHERE id_type_paiement = '".$id_type_paiement."' ";
mysql_query($sql6) OR die("<p>Erreur Mysql6<br/>$sql6<br/>".mysql_error()."</p>");
}

?> 


<table  class="page" align="center">

	<tr>
		<td>
			 <h3>Liste des types de paiement </h3>
        </td>
    </tr>
    <tr>
        <td  class="page" align="center">
            <?php

            if ($message!='') {
             echo"<table><tr><td>$message</td></tr></table>";
            }
            if ($user_com == n) {
            echo"<h1>$lang_commande_droit";
            exit;
            }

           $sql = "SELECT * FROM ".$tblpref."type_paiement ";

            $result = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());



?>
    <center>
        <table class="boiteaction">
				<tr>
                    <th>Type de paiement</th>
                    <th>Action</th>
                </tr>
                    <?php
                    while($data = mysql_fetch_array($result))
                    {
                      $id_type_paiement = $data['id_type_paiement'];
                      $nom = stripcslashes($data['nom']);
                      ?>
                <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
                
                 <td class="highlight">
						<form action="lister_paiement.php" method="post" >
						<input type="text" name="nom" value="<?php echo $nom ?>" />	
						<input type="hidden" name="id_type_paiement" value="<?php echo $id_type_paiement ?>" />
						<input type="hidden" name="update" value="y" />
						<input type="submit"  Title="modifier" value="Modifier"/>
						</form>
                    </td>
                    <td class="highlight"><a href='lister_paiement.php?delete=y&id_type_paiement=<?php echo $id_type_paiement; ?>'
                            onClick="return confirmDelete(' Vous &#234;tes sur de vouloir effacer ce type de paiement - <?php echo $nom; ?> - de la liste?')">
                            <img border="0" src="image/delete.png" alt="delete" Title="Supprimer" ></a>
                    </td>

                </tr>
                	<?php
					} ?>
        </table>
</center>
        </td>
    </tr>
   <tr>
		<td>
			<form action="lister_paiement.php" method="post" >
			<center>
				<table>
					<tr><h1>Ajouter un type de paiement &#224;  la liste</h1></tr>
					<tr>
						<td ><input name="nom" type="text" >
						</td>
					</tr>
					</tr>
							<input name="new" type="hidden" value="y">
						<td class="submit" > <input type="image" name="Submit" src="image/valider.png" value="D&#233;marrer"  border="0"> </td>
					</tr>
				</table>
			</center>
			</form>
		</td>
    </tr>
    
</table>

        <?php
include_once("include/bas.php");
?>

