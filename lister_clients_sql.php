<?php

include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");

$sql = " SELECT DISTINCT C.num_client, C.nom, C.nom2, C.rue, C.ville, C.cp, C.mail, C.prenom, C.tel
       FROM client C
       WHERE actif='y' 
       AND C.num_client !='1'";

$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

$json_array = array(
//'draw' => 1,
'iTotalRecords' => 0,
'iTotalDisplayRecords' => 0,
'aaData' => array(),
);

while($data = mysql_fetch_array($req)) {
   $num_client = $data['num_client'];
   $nom = $data['nom'];
    $nom=stripslashes($nom);
    $nom2 = $data['nom2'];
    $rue = $data['rue'];
    $rue=stripslashes($rue);
    $ville = $data['ville'];
    $ville=stripslashes($ville);
    $cp = $data['cp'];
    $mail =$data['mail'];
    $num = $data['num_client'];
    $prenom = $data['prenom'];
    $tel = $data['tel']; 
    $req_recup_abo = "SELECT ab.type_abonnement
                  FROM abonnement AS ab, abonnement_comm AS ac
                  WHERE ab.num_abonnement = ac.num_abonnement
                  AND ac.client_num = '$num'
                  AND ac.date_fin >= CURDATE()";

    $recup_abo_brut = mysql_query($req_recup_abo)or die('Erreur !<br>'.$req_recup_abo.'<br>'.mysql_error());
    while ($data5 = mysql_fetch_array($recup_abo_brut))
            {
            $type_abonnement = $data5['type_abonnement'];
            }
    if ($type_abonnement == Concert) {
        $concert = "Oui";} 
    else {
        $concert = "Non"; 
    };
    if ($type_abonnement == Spectacle_JP) {
        $jp = "Oui";} 
    else {
        $jp = "Non"; 
    };
    $json_data = array(
        'num_client' => $num_client,
        'nom' => $nom,
        'prenom' => $prenom,
        'rue' => $rue,
        'cp' => $cp,
        'ville'=> $ville,
        'email' => '<a href="form_mailing.php?nom='.$num_client.'" >'.$mail.'</a>',
        'telephone' => $tel,
        'concert' => $concert,
        'jp' => $jp,
        'actions' => '<a href="edit_client.php?num='.$num_client.'">
                      <img border="0"src="image/edit.png" alt='.$lang_editer.'></a>
                      <a href="voir_reservation_client.php?num_client='.$num_client.'" >
                      <img border="0" alt="voir" src="image/voir.gif" Title="Voir les reservation"></a>
                      <a href="dupliquer_client.php?num_client='.$num_client.'" >
                      <img border="0" alt="voir" src="image/duplicat.png" Title="Dupliquer le spectateur"></a>',
    );
    $json_array['aaData'][] = $json_data;
}
header('Content-Type: application/json');
echo json_encode($json_array);
?>
