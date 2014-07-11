<?php 
/* Net Billetterie Copyright(C)2012 Jose Das Neves
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Jose Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");?>
<script type="text/javascript" src="javascripts/confdel.js"></script>

<table class="page" >
<tr>
<td  class="page" align="center">
 <?php
if ($user_cli == n) { 
echo"<h1>$lang_client_droit";
exit;  
}


$article_numero=isset($_GET['article'])?$_GET['article']:"";

//Lister reservation et billet du soir
$sql = "SELECT *
        FROM client C, cont_bon CB, bon_comm BC , tarif T
        WHERE CB.bon_num=BC.num_bon
        AND BC.client_num=C.num_client
        AND CB.article_num = $article_numero
        AND BC.attente=0
        AND CB.id_tarif = T.id_tarif";

//Lister Abonement qui comprend ce spectacle
$sql_abo = "SELECT C.civ, C.nom, C.rue, C.ville, C.cp, C.tel, C.mail, AC.quanti, A.nom_abonnement
            FROM abonnement_comm AC, client C, abonnement A
            WHERE AC.client_num = C.num_client
            AND AC.num_abonnement = A.num_abonnement
                AND AC.num_spectacle_1 = $article_numero
                 OR AC.num_spectacle_2 = $article_numero
                 OR AC.num_spectacle_3 = $article_numero
                 OR AC.num_spectacle_4 = $article_numero
                 OR AC.num_spectacle_5 = $article_numero
                 OR AC.num_spectacle_6 = $article_numero
                 OR AC.num_spectacle_7 = $article_numero";


if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
{
$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
}else{
$sql .= " ORDER BY CB.num ASC ";
}


$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

$sql2="SELECT DATE_FORMAT(date_spectacle,'%d/%m/%Y') AS date_spectacle, article, stock, num FROM " . $tblpref ."article WHERE num=$article_numero";
$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req2))
    {
    $article = $data['article'];
    $article_numero= $data['num'];
    $date = $data['date_spectacle'];
    $stock = $data['stock'];


?>
<center><table class="boiteaction">
  <caption>Liste des spectateurs pour: <br><?php
  if ($stock>0){
  echo "$article le $date - Il reste $stock places";
  
  }
 else {
   echo "$article le $date - La liste d'attente est a $stock places";
    }
    ?> <br><br>
  <?php if ($user_admin != n) { ?>
  <a href="form_mailing.php?article=<?php echo $article_numero;?>">Envoyer un mail a tous ces spectateurs</a><br> <?php } ?>
 <!-- <a href="fpdf/liste_spectateurs.php?article=<?php echo $article_numero;?>" target="_blank">Imprimer la liste de tous ces spectateurs</a></caption> -->

        
      <?php } ?>

        <tr>
            <th colspan="9"> Reservations : </th>
        </tr>
        
                <tr>        
                    <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=civ">Nom</a></th>
                    <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=nom">Prenom</a></th>
                    <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=rue">Telephone</a></th>
                    <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=cp">Mail</a></th>
                    <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=ville">Nom abonnement</a></th>
                    <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=tel">Nombre place</a></th>
                </tr>

<?php
$nombre =1;
while($data = mysql_fetch_array($req))
    {
		$article_num = $data['article_num'];
		$bon_num = $data['bon_num'];
		$num_client = $data['num_client'];
		$nom = $data['nom'];
		$nom_html= stripslashes($nom);
		$nom2 = $data['nom2'];
		$rue = $data['rue'];
		$ville = $data['ville'];
		$cp = $data['cp'];
		$tva = $data['num_tva'];
		$mail =$data['mail'];
		$num = $data['num_client'];
		$civ = $data['civ'];
		$tel = $data['tel'];
		$fax = $data['fax'];
		$nom_tarif = $data['nom_tarif'];
		$quanti = $data['quanti'];
		$to_tva_art = $data['to_tva_art'];
$total_tva = $data['SUM(to_tva_art)'];			
		
    if($nombre & 1){
                    $line="0";
                    }else{
                    $line="1"; 
                    }
		?>
		<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte <?php echo "$line" ?>'">
         <!--           <td class="highlight"><?php  // echo $civ; ?></td> -->
                    <td class="highlight"><?php echo $nom_html; ?></td>
         <!--           <td class="highlight"><?php // echo $rue; ?></td>
                    <td class="highlight"><?php // echo $cp; ?></td> -->
                    <td class="highlight"><?php echo $prenom ; ?></td> 
          <!--          <td class="highlight"><?php // echo $ville; ?></td> -->
                    <td class="highlight"><?php echo $tel; ?></td>
                    <td class="highlight"><a href="mailto:<?php echo $mail; ?>" ><?php echo "$mail"; ?></a></td>
                    <td class="highlight"><?php echo $nom_tarif; ?></td>
                    <td class="highlight"><?php echo $quanti; ?></td>
                </tr>
		

		<?php
		}
$aide = client;
?>
                <tr>
                    <td colspan="9"> <!-- Espace de separation --> </td>
                </tr>
                
                <tr>
                    <th colspan="9"> Abonnements : </th>
                </tr>
                <tr>
         <!--           <th><small> Civilite </small></th>  -->
                    <th><small> Nom  </small></th>
                    <th><small> Prenom  </small></th>
                <!--    <th><small> Rue </small></th>
         <!--           <th><small> Code postal </small></th> -->
          <!--          <th><small> Ville </small></th>  -->
                    <th><small> Telephone </small></th>
                    <th><small> Mail </small></th>
                    <th><small> Nom abonnement </small></th>
                    <th><small> Nombre place</small></th>
                </tr>
<?php 

$req_abo = mysql_query($sql_abo) or die('Erreur SQL !<br>'.$sql_abo.'<br>'.mysql_error());
        
$nombre_abo =1;
    while($data2 = mysql_fetch_array($req_abo))
    {
    $civ_abo = $data2['civ'];
    $nom_abo = $data2['nom'];
    $tel_abo = $data2['tel'];
    $mail_abo = $data2['mail'];
    $nom_abonnement_abo = $data2['nom_abonnement'];
    $quanti_abo = $data2['quanti'];
    $rue_abo = $data2 ['rue'];
    $ville_abo = $data2['ville'];
    $cp_abo = $data2['cp'];
       
        if($nombre_abo & 1){
                    $line="0";
                    }else{
                    $line="1"; 
                    }


?>        
        <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte <?php echo "$line" ?>'">
		<td class="highlight"><?php echo $civ_abo ;?></td>
                <td class="highlight"><?php echo $nom_abo ;?></td>
                <td class="highlight"><?php echo $rue_abo ;?></td>
                <td class="highlight"><?php echo $ville_abo ;?></td>
                <td class="highlight"><?php echo $cp_abo ;?></td>
                <td class="highlight"><?php echo $tel_abo ;?></td>
                <td class="highlight"><?php echo $mail_abo ;?></td>
                <td class="highlight"><?php echo $nom_abonnement_abo ;?></td>
                <td class="highlight"><?php echo $quanti_abo ;?></td>
        </tr>
        
<?php

   } 
   
?>
<!--tr><td class='totalmontant' colspan="3">TOTAL DU SPECTACLE</td>

<td class='totaltexte'><?php echo "$total_tva $devise "; ?></td><td colspan='2' class='totalmontant'>
</td></tr-->

</table></center><tr><td>
<?php
include("help.php");	
echo"</td></tr><tr><td>";
include_once("include/bas.php");
?> 
</td></tr>
<?php
$url = $_SERVER['PHP_SELF'];
$file = basename ($url);
if ($file=="form_client.php") { 
echo"</table>"; 
} ?>
</table>
</body>
</html>
