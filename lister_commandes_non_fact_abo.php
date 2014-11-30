<?php 
/* Net Billetterie Copyright(C)2012 Jose Das Neves
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php"); 
include_once("include/headers.php");
include_once("include/fonction.php");?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<?php
include_once("include/finhead.php");
include_once("include/head.php");
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
?> 


<table  class="page" align="center">

    <tr>
        <td class="page" align="center">
             <h3>Liste des abonnements non encaissees par la perception <br/>Saison culturelle <?php echo "$annee_2 - $annee_1"; ?></h3>
        </td>
    </tr>
    
    <tr>
        <td  class="page" align="center">
            <?php

            if ($message!='') {
             echo"<table><tr><td>$message</td></tr></table>";
            }
            if ($user_dev == n) {
            echo"<h1>$lang_commande_droit";
            exit;
            }
            if ($user_com == y) {
            $sql = "SELECT mail, login, num_client, num_abo_com, ctrl, fact, attente, coment, tot_tva, nom, num_abonnement,
		    DATE_FORMAT(date,'%d-%m-%Y') AS date, tot_tva as ttc, paiement, banque, titulaire_cheque
		    FROM abonnement_comm
		    RIGHT JOIN client on abonnement_comm.client_num = num_client
		    WHERE date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
                    AND attente='0'
		    AND fact='non'";
                             //ORDER BY ".$tblpref."bon_comm.`num_bon` DESC

            if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
            {
            $sql .= " ORDER BY " . $_GET[ordre] . " ASC";
            }
            else
            {
            $sql .= "ORDER BY ".$tblpref."abonnement_comm.`num_abo_com` DESC ";
            }}
            $req = mysql_query($sql) or die('Erreur SQL ? !<br>'.$sql2.'<br>'.mysql_error());

            

/* pagination */
// Parametrage de la requete (ne pas modifier le nom des variable)

//=====================================================
// Nombre d'enregistrements par page a afficher
$parpage = 50;
//=====================================================


//==============================================================================
// Declaration et initialisation des variables (ici ne rien modifier)
//==============================================================================

// On definit le suffixe du lien url qui affichera les pages
// $_SERVEUR['PHP_SELF'] donne l'arborescence de la page courante
$url = $_SERVER['PHP_SELF']."?limit=";

$total = mysql_query($sql); // Resultat total de la requete $sql
$nblignes = mysql_num_rows($total); // Nbre total d'enregistrements
// On calcule le nombre de pages a afficher en arrondissant
// le resultat au nombre superieur grace a la fonction ceil()
$nbpages = ceil($nblignes/$parpage); 

 // Si une valeur 'limit' est passee par url, on verifie la validite de
// cette valeur par mesure de securite avec la fonction validlimit()
 // cette fonction retourne automatiquement le resultat de la requete
 $result = validlimit($nblignes,$parpage,$sql);

 //=====================================================
  /*  pour changer le paiement */
 //===================================================== 
 $num_abo_com=isset($_POST['num_abo_com'])?$_POST['num_abo_com']:"";
 $paiement=isset($_POST['paiement'])?$_POST['paiement']:"";
 $sql4 = "UPDATE ".$tblpref."abonnement_comm SET `paiement`='" . $paiement . "' WHERE `num_abo_com` = '" . $num_abo_com . "'";
mysql_query($sql4) OR die("<p>Erreur Mysql<br/>$sql4<br/>".mysql_error()."</p>");

 
?>
    <center>
        <table class="boiteaction">
                <tr>
                    <th><?php echo $lang_numero; ?></a></th>
                    <th><?php echo $lang_client; ?></a></th>
                    <th>Nom de l'abonnement</th>
                    <th><?php echo $lang_date; ?></th>
                    <th><?php echo $lang_total_ttc; ?></a></th>
                    <th>Regle?</a></th>
                    <th>Banque</th>
                    <th>Titulaire du cheque</th>
                    <th>Controle</th>
		    <th>Encaisse</th>
	            <th>Action</th>
                </tr>
                
                    <?php
                    

                    
                            
                    $nombre = 1;
                    while($data = mysql_fetch_array($result))
                    {
                      $num_abo_com = $data['num_abo_com'];
		      $ctrl = $data['ctrl'];
		      $pointage = $data['fact'];
                      $paiement = $data['paiement'];
                      $tva = $data["tot_tva"];
                      $date = $data["date"];
                      $num_abonnement = $data["num_abonnement"];
                      $nom = $data['nom'];
                      $nom = htmlentities($nom, ENT_QUOTES);
                      $nom_html = htmlentities (urlencode ($nom));
                      $num_client = $data['num_client'];
                      $banque = stripslashes($data['banque']);
                      $titulaire_cheque = $data['titulaire_cheque'];
                      $mail = $data['mail'];
                      $login = $data['login'];
                      $coment = $data['coment'];
                      $ttc = $data['ttc'];
                      $nombre = $nombre +1;
                            if($nombre & 1){
                            $line="0";
                            }else{
                            $line="1";
                            }
                    
                    //On recup le prix et le nom de l abonnement 
                    $sql_prix = "SELECT A.tarif_abonnement, A.nom_abonnement
                                 FROM abonnement_comm AC, abonnement A
                                 WHERE AC.num_abonnement = A.num_abonnement
                                 AND AC.num_abo_com = '$num_abo_com'";
                    $sql_prix_brut = mysql_query($sql_prix) or die('Erreur SQL ? !<br>'.$sql_prix_brut.'<br>'.mysql_error());
                    while($data4 = mysql_fetch_array($sql_prix_brut))
                    {
                        $tarif_abonnement = $data4['tarif_abonnement'];
                        $nom_abonnement = $data4['nom_abonnement'];
                        
                      ?>
                <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo $line ?>'">
                    <td class="highlight"><?php echo "$num_abo_com"; ?></td>
                    <td class="highlight"><?php echo "$nom"; ?></td>
                    <td class="highlight"><?php echo "$nom_abonnement" ; ?></td>
                    <td class="highlight"><?php echo "$date"; ?></td>
                    <td class="highlight"><?php echo $tarif_abonnement ; ?></td>
                    <td class="highlight"><?php echo "$paiement"; ?></td>
                    <td class="highlight"><?php echo $banque;?></td>
                    <td class="highlight"><?php echo $titulaire_cheque;?></td>
		    <td class="highlight"><?php echo $ctrl; ?></td>
		    <td class="highlight"><?php echo $pointage; ?></td>
                    <td class="highlight"><a href='form_paiement_abonnement.php?num_abo_com=<?php echo "$num_abo_com" ;?>'>
                    <img border="0" alt="Modifier" src="image/edit.gif" Title="Modifier"></a></td>
              <?php } 
                    }?>
                </tr>
        </table>
</center>
        </td>
    </tr>

    <tr>
        <td>
             <?php
//=====================================================
// Menu de pagination que l'on place apr�s la requ�te 
//======================================================
 echo "<div class='pagination'>";
 echo pagination($url,$parpage,$nblignes,$nbpages,$initial);
function position($parpage){
if (isset($_GET['limit'])) {
    $pointer = split('[,]', $_GET['limit']); // On scinde $_GET['limit'] en 2
    $debut = $pointer[0];
    $page = ($debut/$parpage)+1;
return $page;
}
}
 echo "</div>";

 mysql_free_result($result); // Lib�re le r�sultat de la m�moire
 ?>
        </td>
    </tr>
    <tr>
        <td>
        <?php
include("help.php");
include_once("include/bas.php");
$url = $_SERVER['PHP_SELF'];
$file = basename ($url); 
?>
        </td>
    </tr>
</table>

<?php 

if ($file=="form_commande.php" or $file=="login.php") { 
echo"</table>"; 
}
 ?> 

