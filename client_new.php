<?php
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/config/var.php");

$mail_admin = "$mail";
$nom=isset($_POST['nom'])?$_POST['nom']:"";
$nom=AddSlashes($nom);
$nom_sup=isset($_POST['nom_sup'])?$_POST['nom_sup']:"";
$rue=isset($_POST['rue'])?$_POST['rue']:"";
$rue=AddSlashes($rue);
$ville=isset($_POST['ville'])?$_POST['ville']:"";
$ville=AddSlashes($ville);
$code_post=isset($_POST['code_post'])?$_POST['code_post']:"";
$num_tva=isset($_POST['num_tva'])?$_POST['num_tva']:"";
$mail_cli=isset($_POST['mail'])?$_POST['mail']:"";
$prenom=isset($_POST['prenom'])?$_POST['prenom']:"";
$tel=isset($_POST['tel'])?$_POST['tel']:"";
$fax=isset($_POST['fax'])?$_POST['fax']:"";
$ville= ucwords($ville);
$nom= ucwords($nom);
$num_client_parent=isset($_POST['client-parent'])?$_POST['client-parent']:"";

$nom = strtoupper( $nom );

if($nom=='' && (empty($mail) || empty($tel1)))
    {
   $message= "<h1>$lang_oubli_champ</h1>";
    include('form_client.php'); // On inclus le formulaire d'identification
    exit;
    }

$sql1 = "INSERT INTO " . $tblpref ."client(nom, nom2, rue, ville, cp, num_tva, login, pass, mail, prenom, tel, fax) VALUES ('$nom', '$nom_sup', '$rue', '$ville', '$code_post', '$num_tva', '$login', '$pass', '$mail_cli', '$prenom', '$tel', '$fax')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

// ON récupère le numéro du dernier client inséré

$select_last_client = "SELECT num_client FROM client ORDER BY num_client DESC LIMIT 0,1";
$req_last_client = mysql_query($select_last_client) or die ('Erreur séléction dernier client');
$data_last_client = mysql_fetch_array($req_last_client);
$nouveau_client = $data_last_client['num_client'];

//On insert le lien entre le client dupliqué et le client enfant
$sql_insert_client_liens = "INSERT INTO " . $tblpref ."client_liens(num_client_parent, num_client_enfant) VALUES ('$num_client_parent', '$nouveau_client')";
mysql_query($sql_insert_client_liens) or die('Erreur SQL!<br>'.$sql_insert_client_liens.'<br>'.mysql_error());

//On récupère le nom du dernier client
$sql3 = "SELECT nom FROM " . $tblpref ."client WHERE num_client=".$nouveau_client."";

$req3= mysql_query($sql3) or die('Erreur SQL3 !<br>'.$sql3.'<br>'.mysql_error());

while($data = mysql_fetch_array($req3))
    {
        $nom=StripSlashes($data['nom']);
    }
            $message.= "<center><h2>Le client <font color=#009EDF>$nom </font> a bien ete enregistre </h2></center>";
    
    // On ajoute les boutons pour faire une réservation ou un abonnement à ce client : 
    $message.="<center><div class='page'>
        <div class='submit bouton'>
        <a href='form_commande.php?num_client=$nouveau_client'>Créer une réservation pour $nom </a>
            </div>
            <div class='submit bouton'>
            <a href='new_abonnement.php?num_client=$nouveau_client'> Créer un abonnement pour $nom </a>
                </div>
        </div>
    </center>";
    
    include("form_client.php");
?>
