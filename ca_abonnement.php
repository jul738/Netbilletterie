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
include_once("include/head.php");
include_once("include/finhead.php");
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

<table  border="0" class="page" align="center">
    <tr>
		<td class="page" align="center">
			<h3>Chiffre d'affaires par abonnement pour la saison : <?php echo "$annee_2-$annee_1"; ?>
				 <?php if ($user_admin!='n'||$user_dev!='n'){?>
				<SCRIPT LANGUAGE="JavaScript">
				if(window.print)
					{
					document.write('<A HREF="javascript:window.print()"><img border=0 src= image/print.png ></A>');
					}
				</SCRIPT>
				<?php } ?>
			</h3> <br>
		</td>
    </tr>
    <tr>
        <td  class="page" align="center">
            <?php
            if ($user_stat== n)
            {
                echo"<h1>$lang_statistique_droit";
                exit;
            }?>
                <!--formulaire du choix de saison-->
                <center>
                    <form action="ca_abonnement.php" method="post">
                        <table >
                            <tr>
                             <td width="27%" class="texte0">
                                <select name="annee_1">
                                    <option value="<?php echo"$annee_1"; ?>"><?php $date_1=$annee_1-1;echo"$date_1 -$annee_1"; ?></option>
                                    <option value="<?php $date=date("Y");echo"$date"; ?>"><?php $date=date("Y");$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                                    <option value="<?php $date=(date("Y")-1);echo"$date"; ?>"><?php $date=(date("Y")-1);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                                    <option value="<?php $date=(date("Y")-2);echo"$date"; ?>"><?php $date=(date("Y")-2);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                                    <option value="<?php $date=(date("Y")-3);echo"$date"; ?>"><?php $date=(date("Y")-3);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                                    <option value="<?php $date=(date("Y")-4);echo"$date"; ?>"><?php $date=(date("Y")-4);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                                    <option value="<?php $date=(date("Y")-5);echo"$date"; ?>"><?php $date=(date("Y")-5);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                                    <option value="<?php $date=(date("Y")-6);echo"$date"; ?>"><?php $date=(date("Y")-6);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                                </select>
                             </td>
                             <td class="submit" colspan="4"><input type="submit" value='Choisir la saison culturelle'></td>
			    </tr>
			</table>
		    </form>
		</center>
                <!--fin du formulaire du choix de saison-->
				  

                                  
                                    <table class="boiteaction">

					<tr>
						<th>Abonnement</th>
						<th>Quantite vendu</th>
						<th>Total</th>
						<th>Pourcentage de vente</th>
					</tr>
                                        
<?php
                                    //On liste la quantite vendu d abonnement par abonnement 
                                    $req_recup_quanti_abonnement = "SELECT SUM( ac.quanti ) AS quanti, a.nom_abonnement, a.num_abonnement
                                                                    FROM abonnement_comm ac, abonnement a
                                                                    WHERE a.num_abonnement = ac.num_abonnement
                                                                    GROUP BY a.num_abonnement
                                                                    ORDER BY quanti DESC ";
                                    $recup_quanti_vendu_brut = mysql_query($req_recup_quanti_abonnement)or die('Erreur !<br>'.$req_recup_quanti_abonnement.'<br>'.mysql_error());
                                    while ($data2 = mysql_fetch_assoc($recup_quanti_vendu_brut))
                                                    {
                                                    $quanti_par_abonnement = $data2['quanti'];
                                                    $nom_des_abonnement = $data2['nom_abonnement'];
                                                    $num_des_abonnement = $data2['num_abonnement'];
                                                    
                                                    
                                                    //Recup le total des vente par abonnement
                                                    $req_recup_vente_abo_1 = "SELECT SUM(ap.total_ttc) AS total_par_abonnement, a.nom_abonnement
                                                                              FROM abonnement_paiement ap, abonnement a
                                                                              WHERE ap.id_abonnement = ".$num_des_abonnement."
                                                                              GROUP BY a.nom_abonnement";
                                                    $recup_vente_abo_brut_1 = mysql_query($req_recup_vente_abo_1)or die('Erreur !<br>'.$req_recup_vente_abo_1.'<br>'.mysql_error());
                                                    while ($data5 = mysql_fetch_array($recup_vente_abo_brut_1))
                                                        {
                                                $total_par_abonnement = $data5['total_par_abonnement'];
                                                        } // fin while $quanti_par_abonnement & $nom_abonnement
 
                                                
                                                        //Rq on recupere le chiffre total des vente de tous les abonnement reunie
                                                        $req_recup_tot_abonnement = "SELECT SUM(total_ttc) AS total_vente_abonnement
                                                                                     FROM abonnement_paiement";
                                                        $recup_tot_abonnement_brut = mysql_query($req_recup_tot_abonnement)or die('Erreur !<br>'.$req_recup_tot_abonnement.'<br>'.mysql_error());
                                                        while ($data4 = mysql_fetch_array($recup_tot_abonnement_brut))
                                                                        {
                                                                        $total_vente_abonnement = $data4['total_vente_abonnement'];
                                                        
    
                                                                        
                                //On calcule le pourcentage de vente que represente chaqu'un des abonnements 
                                $pourcent_par_abonnement = $total_par_abonnement / $total_vente_abonnement * 100 ;
                                                                                 } // fin while $total_par_abonnement
                                                
?>      
                                       
                                    <tr>
                                        <td> <?php echo $nom_des_abonnement ;?> </td>
                                        <td> <?php echo $quanti_par_abonnement ;?> </td>
                                        <td> <?php echo $total_par_abonnement ;?> <?php echo $devise ;?> </td>
                                        <td> <?php echo $pourcent_par_abonnement ;?> % </td>
                                    </tr>
                                            
                                            
<?php    


                                                                                       } //fin while $pourcent_par_abonnement
?>
                                    </table>
<?php 
    include("help.php");
    include_once("include/bas.php");
?>