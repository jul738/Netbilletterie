<?php
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");

// On récupère la liste des groupes

$select_groupes = "SELECT * FROM groupe";
$req_groupes = mysql_query($select_groupes) or die('Erreur sql groupes'.$select_groupes.'<br>'.mysql_error());

$json_array = array(
//'draw' => 1,
'iTotalRecords' => 0,
'iTotalDisplayRecords' => 0,
'aaData' => array(),
);

while($data_groupes = mysql_fetch_array($req_groupes)){
    $num_groupe = $data_groupes['num_groupe'];
    $nom_structure = $data_groupes['nom_structure'];
    $rue_structure = $data_groupes['rue'];
    $cp_structure = $data_groupes['cp'];
    $ville_structure = $data_groupes['ville'];
    $telephone_structure = $data_groupes['telephone'];
    $email_structure = $data_groupes['email'];
    $json_data = array(
        'nom' => $nom_structure,
        'rue' => $rue_structure,
        'cp' => $cp_structure,
        'ville' => $ville_structure,
        'telephone' => $telephone_structure,
        'email' => $email_structure,
        'voir' => '<a href="groupe.php?num_groupe='.$num_groupe.'"><img border="0" title="Voir le groupe" src="image/voir.gif" alt="voir"></a>',
        'modifier' => '<a href="form_groupe.php?num_groupe='.$num_groupe.'"><img border="0" alt="Modifier"  title="Modifier le groupe"src="image/edit.png"></a>',
        'supprimer' => '<a href="delete_groupe.php?num_groupe='.$num_groupe.'"><img border="0" title="Supprimer le groupe" alt="delete" src="image/delete.png"></a>',
    );
    $json_array['aaData'][] = $json_data;
}
header('Content-Type: application/json');
echo json_encode($json_array);
?>