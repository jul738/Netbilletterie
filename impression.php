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
include_once("include/fonction.php");
include_once("include/finhead.php");
include_once("include/head.php");
$date_today= date("Y-m-d");
list($annee, $mois, $jour) = explode("-", $date_today);
                                $date_today = "$jour-$mois-$annee";
?>
<table class="page" align="center">
	<tr>
		<td>
			<li>
			<form action="print_detail_bon.php" method="get">
				<center>
					<table>
						<b>Liste detaillee de toutes les reservations en cours</b></li>
						<tr>
							<td><li>Imprimer en choisissant les dates entre le</td>
							<td> <input name="date_debut" type="text" size="10" maxlength="40"  value="<?php echo $date_today;?>" ></td>
							<td>et le </td>
							<td> <input name="date_fin" type="text" size="10" maxlength="40" value="<?php echo $date_today;?>"></td>
							<td> <input type="submit" name="Submit" value="Imprimer"></td>
						</tr>
                    </table>
                </center>
              </form>
			</li><hr>
			<li>
			<form action="print_pointes_ok.php" method="get">
				<center>
					<table>
						<b>Liste detaillee des reservations pour la perception</b></li>
						<tr>
							<td><li>Imprimer en choisissant les dates entre le</td>
							<td> <input name="date_debut" type="text" size="10" maxlength="40"  value="<?php echo $date_today;?>" ></td>
							<td>et le </td>
							<td> <input name="date_fin" type="text" size="10" maxlength="40" value="<?php echo $date_today;?>"></td>
							<td> <input type="submit" name="Submit" value="Imprimer"></td>
						</tr>
                    </table>
                </center>
              </form>
			</li><hr>
			<li>
			<form action="print_pointes_ok_light.php" method="get">
				<center>
					<table>
						<b>Detail des encaissements pour la perception</b></li>
						<tr>
							<td><li>Imprimer en choisissant les dates entre le</td>
							<td> <input name="date_debut" type="text" size="10" maxlength="40"  value="<?php echo $date_today;?>" ></td>
							<td>et le </td>
							<td> <input name="date_fin" type="text" size="10" maxlength="40" value="<?php echo $date_today;?>"></td>

							<td> <input type="submit" name="Submit" value="Imprimer"></td>
						</tr>
                    </table>
                </center>
              </form>
			</li><hr>
        </td>
    </tr>
</table>
<?php
include_once("include/bas.php");
?>
