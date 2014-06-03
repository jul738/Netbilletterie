<?php
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Jos� Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");

$list_fer=array(7);//Liste pour les jours feri�; EX: $list_fer=array(7,1)==>tous les dimanches et les Lundi seront des jours f�riers

$sql="select date_spectacle from factux_article";
$req=mysql_query($sql);
$k=0;
while($data=mysql_fetch_array($req))
{
	$list_spe[$k]=$data[0];
	$k++;
}
if($k==0)
	$list_spe[0]="";
if(isset($_GET['admin']))
	$lien_redir="agenda_gestion.php";
else
	$lien_redir="agenda_date_info.php";//Lien de redirection apres un clic sur une date, NB la date selectionner va etre ajouter � ce lien afin de la r�cuperer ult�rieurement 
if(isset($_GET['admin']))
	$clic=1;//1==>Activer les clic sur tous les dates; 2==>Activer les clic uniquement sur les dates speciaux; 3==>D�sactiver les clics sur tous les dates
else
	$clic=2;
$col1="#d6f21a";//couleur au passage du souris pour les dates normales

$col2="#8af5b5";//couleur au passage du souris pour les dates speciaux

$col3="#6a92db";//couleur au passage du souris pour les dates f�ri�

$mois_fr = Array("", "Janvier", "F�vrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Ao�t","Septembre", "Octobre", "Novembre", "D�cembre");


if(isset($_GET['mois']) && isset($_GET['annee']))
{
	$mois=$_GET['mois'];
	$annee=$_GET['annee'];
}
else
{
	$mois=date("n");
	$annee=date("Y");
}
$s=strlen($mois)-1;
if($mois<10)
	$mois=$mois[$s];
$ccl2=array($col1,$col2,$col3);
$l_day=date("t",mktime(0,0,0,$mois,1,$annee));
$x=date("N", mktime(0, 0, 0, $mois,1 , $annee));
$y=date("N", mktime(0, 0, 0, $mois,$l_day , $annee));
$titre=$mois_fr[$mois]." : ".$annee;
//echo $l_day;
?>

<table class="page">
<tr>
<td>
<center>
<h1>Agenda</h1>
	<form name="dt" method="get" action="">
		<?php
		if(isset($_GET['admin']))
			echo '<input type="hidden" name="admin" />';
		?>
		<select name="mois" id="mois" onChange="change()" class="liste">
		<?php
			for($i=1;$i<13;$i++)
			{
				echo '<option value="'.$i.'"';
				if($i==$mois)
					echo ' selected ';
				echo '>'.$mois_fr[$i].'</option>';
			}
		?>
		</select>
		<select name="annee" id="annee" onChange="change()" class="liste">
		<?php
			for($i=2009;$i<2035;$i++)
			{
				echo '<option value="'.$i.'"';
				if($i==$annee)
					echo ' selected ';
				echo '>'.$i.'</option>';
			}
		?>
		</select>
	</form>
	<table class="tableau"><caption><?php echo $titre ;?></caption>
		<tr><th>Lun</th><th>Mar</th><th>Mer</th><th>Jeu</th><th>Ven</th><th>Sam</th><th>Dim</th></tr>
		<tr>
			<?php
			//echo $y;
			$case=0;
			if($x>1)
				for($i=1;$i<$x;$i++)
				{
					echo '<td class="desactive">&nbsp;</td>';
					$case++;
				}
			for($i=1;$i<($l_day+1);$i++)
			{
				$f=$y=date("N", mktime(0, 0, 0, $mois,$i , $annee));
				if($i<10)
					$jj="0".$i;
				else
					$jj=$i;
				if($mois<10)
					$mm="0".$mois;
				else
					$mm=$mois;
				$da=$annee."-".$mm."-".$jj;
				$lien=$lien_redir;
				$lien.="?dt=".$da;
				echo "<td";
				if(in_array($da, $list_spe))
				{
					echo " class='special' onmouseover='over(this,1,2)'";
					if($clic==1||$clic==2)
						echo " onclick='go_lien(\"$lien\",this)' ";
				}
				else if(in_array($f, $list_fer))
				{
					echo " class='ferier' onmouseover='over(this,2,2)'";
					if($clic==1)
						echo " onclick='go_lien(\"$lien\",this)' ";
				}
				else 
				{
					echo" onmouseover='over(this,0,2)' ";
					if($clic==1)
						echo " onclick='go_lien(\"$lien\",this)' ";
				}
				echo" onmouseout='over(this,0,1)'>$i</td>";
				$case++;
				if($case%7==0)
					echo "</tr><tr>";
				
			}
			if($y!=7)
				for($i=$y;$i<7;$i++)
				{
					echo '<td class="desactive">&nbsp;</td>';
				}
			?></tr>
			</table>
			<?php
				if(isset($_GET['mod']))
					echo "<div id='notif'>Calendrier modifi�</div>";
				elseif(isset($_GET['add']))
					echo "<div id='notif'>Ev�nement ajout�</div>";
			?>
		</td>
</tr>

</table >


<script type="text/javascript">
function change()
{
	document.dt.submit();
}
	function over(this_,a,t)
{
	<?php 
	echo "var c2=['$ccl2[0]','$ccl2[1]','$ccl2[2]'];";
	?>
	var col;
	if(t==2)
		this_.style.backgroundColor=c2[a];
	else
		this_.style.backgroundColor="";
}
function go_lien(a,this_)
{
	over(this_,0,1);
	top.document.location=a;
}
</script>
<?php
include("help.php");
include_once("include/bas.php");
?>
