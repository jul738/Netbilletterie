<?php
/* Net Billetterie Copyright(C)2012 Jose Das Neves
Logiciel de billetterie libre.
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jose Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
if(isset($_GET['num_client'])){
$new_client = $_GET['num_client'];
}
?>

<table border="0" class="page" align="center">
    <tr>
        <td class="page" align="center">
            <h3>Creer un Abonnement</h3>
        </td>
    </tr>
    <tr>
        <td class="page" align="center" style="background:#E8E8EC;">
<?php
             if ($message!='') {
             echo"<table><tr><td>$message</td></tr></table>";
            }
            if ($user_com == n) {
            echo"<h1>$lang_commande_droit";
            exit;
            }
            $jour = date("d");
            $mois = date("m");
            $annee = date("Y");

            $rqSql = "SELECT num_client, nom, nom2, prenom FROM " . $tblpref ."client WHERE actif != 'n' AND `num_client`!='1'";
            if ($user_com == r) {
            $rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'n' AND `num_client`!='1'
            and (" . $tblpref ."client.permi LIKE '$user_num,'
            or " . $tblpref ."client.permi LIKE '%,$user_num,'
            or " . $tblpref ."client.permi LIKE '%,$user_num,%'
            or " . $tblpref ."client.permi LIKE '$user_num,%')
            ";
            }
             ?>
        </td>
    </tr>
    <tr>
        <td>
            
        <center>                
<table>
    
    <tr>
        <td>
            <form name="formu" method="post" action="new_suite_abonnement.php" onSubmit="return verif_formulaire()">
                            <table>
                            <caption><?php echo "$lang_cre_bon"; ?></caption>
    <tr>
        <td class="texte0" >
<?php
    require_once("include/configav.php");
        $rqSql="$rqSql order by nom";
        $result = mysql_query( $rqSql ) or die( "Execution requete impossible.");
?>
                <SELECT NAME='listeville'>
                <OPTION VALUE="">Cliquez ici et commencez a ecrire le nom</OPTION>
<?php
                while ( $row = mysql_fetch_array( $result)) {
                $numclient = $row["num_client"];
                $nom = $row["nom"];
                $nom2 = $row["nom2"];
                $prenom = $row["prenom"];
?>
                <OPTION VALUE='<?php echo $numclient; ?>'<?php if($numclient == $new_client){echo 'selected';}?>><?php echo $nom." ".$prenom; ?></OPTION>
<?php
                }
?>
                </SELECT>
        </td>
    </tr>
    <tr>
<?php
//=============================================
//pour que les articles soit classes par saison
$mois=date("n");
if ($mois=="10"||$mois=="11"||$mois=="12") {
 $mois=date("n");
}
else{
  $mois =date("0n");
}
$jour =date("d");
$date_ref="$mois-$jour";
$annee = date("Y");
//pour le formulaire
$annee_1=isset($_POST['annee_1'])?$_POST['annee_1']:"";
if ($annee_1=='')
{
  $annee_1= $annee ;
  if ($mois.'-'.$jour <= $fin_saison)
  {
  $annee_1=$annee_1;
  }
  if ($mois.'-'.$jour >= $fin_saison)
  {
  $annee_1=$annee_1+1;
  }
}
$annee_2= $annee_1 -1;
//=============================================


    $rqSql3= "SELECT num_abonnement, nom_abonnement, tarif_abonnement, nombre_spectacle
              FROM abonnement";
$result3 = mysql_query( $rqSql3 )or die( mysql_error()."Execution requete -rqSql3- impossible.");?>

        <td class="texte0" colspan='2'>
    <SELECT NAME='num_abonnement'>
    <OPTION VALUE="">Choisir l'abonnement</OPTION>
<?php
        while ( $row = mysql_fetch_array( $result3)) 
                {
        $num_abonnement = $row["num_abonnement"];
        $nom_abonnement = $row["nom_abonnement"];
        $tarif_abonnement = $row["tarif_abonnement"];
?>
    <OPTION VALUE='<?php echo $num_abonnement; ?>'><?php echo "$nom_abonnement $tarif_abonnement $devise "; ?></OPTION>
<?php           }

if ($user_admin != 'n')
    {
    
//tarif gratuit pour admin
$sqltarifgratuit = "SELECT nom_tarif, prix_tarif, id_tarif, DATE_FORMAT(saison, '%d/%m/%Y' ) AS date
                    FROM ".$tblpref."tarif
                    WHERE saison
                    BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
                    AND nom_tarif='gratuit'";
$reqtarifgratuit = mysql_query($sqltarifgratuit) or die('Erreur SQLtarifgratuit !<br>'.$sqltarifgratuit.'<br>'.mysql_error());

        while($data = mysql_fetch_array($reqtarifgratuit))
            {
            $nom_tarif = $data['nom_tarif'];
            $prix_tarif = $data['prix_tarif'];
            $num_tarif =$data['id_tarif'];
            ?>
            <OPTION VALUE='<?php echo $num_abonnement; ?>'><?php echo "$nom_abonnement $tarif_abonnement $devise "; ?></OPTION>
            <?php
            } // fin du while
    } //fin du if ?>
            
    </SELECT>
        </td>
    </tr>
    <tr>
        <td>&nbsp;
        </td>
    </tr>
    <tr>
        <td class="submit" colspan="6">
        <input type="hidden" name="date" value="<?php echo"$jour/$mois/$annee";?>" >
        <input type="image" name="Submit" src="image/valider.png" value="Demarrer" border="0"></td>
    </tr>
                        </table>
            </form>
        </td>
    </tr>
    </center>
</table>
            
        </td>
    </tr>
</table>

<?php
include_once("include/bas.php");
?>




