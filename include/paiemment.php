<?php
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr*/

// on recupere tous les type de paiement
$sqltype_paiement = "SELECT * FROM " . $tblpref ."type_paiement ORDER BY nom ASC ";
$sqltype_paiement = mysql_query($sqltype_paiement) or die('Erreur SQL !<br>'.$sqltype_paiement.'<br>'.mysql_error());
?>
<center><h1>Choisir le mode de paiement</h1>
		
				<select name="paiement" onchange="if(this.value != -1){if(confirm('<?php echo"$lang_conf_carte_reg";?> '+ forms['payement<?php echo "$max";?>'].elements['num'].value +' <?php echo"$lang_par ";?>'+ this.value)){forms['payement<?php echo "$max";?>'].submit();}else{return false}}">
		<?php 
                if ($paiement !="")
                { ?>
                    <option value="<?php echo $paiement;?>"><?php if ($paiement=="non") { $paiement='En attente de paiement';} echo $paiement;?></option>
                   <?php
                } ?>
				<option value="non">En attente de paiement</option>
				<?php
					while($data = mysql_fetch_array($sqltype_paiement)){
						$nom = $data['nom'];
						?>
            <option value="<?php echo $nom;?>"><?php echo $nom;?></option>
			<?php } ?>

		</select>
