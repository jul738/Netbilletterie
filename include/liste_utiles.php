<?php

function liste_paiement() {
    // on recupere tous les type de paiement
$sqltype_paiement = "SELECT * FROM " . $tblpref ."type_paiement ORDER BY nom ASC ";
$sqltype_paiement = mysql_query($sqltype_paiement) or die('Erreur SQL !<br>'.$sqltype_paiement.'<br>'.mysql_error());
$paiement_liste = '<select name="paiement" onchange="if(this.value != -1){if(confirm('.$lang_conf_carte_reg.'+ forms[\'payement '.$max.'].elements[\'num\'].value +'.$lang_par.'+ this.value)){forms[\'payement '.$max.'].submit();}else{return false}}">';
                if ($paiement !="")
                { 
                   $paiement_liste .= '<option value="'.$paiement.'">';
                   if ($paiement=="non") 
                       { $paiement ='En attente de paiement';} 
                       $paiement_liste .= $paiement.'</option>';
                } 
                $paiement_liste .= '<option value="non">En attente de paiement</option>';
		while($data = mysql_fetch_array($sqltype_paiement)){
                    $nom = $data['nom'];
                    $paiement_liste .= '<option value="'.$nom.'">'.$nom.'</option>';
		}
                $paiement_liste .= '</select>';

                return $paiement_liste;
}
?>