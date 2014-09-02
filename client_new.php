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
$login=isset($_POST['login'])?$_POST['login']:"";
$pass=isset($_POST['pass'])?$_POST['pass']:"";
$mail_cli=isset($_POST['mail'])?$_POST['mail']:"";
$pass2=isset($_POST['pass2'])?$_POST['pass2']:"";
$prenom=isset($_POST['prenom'])?$_POST['prenom']:"";
$tel=isset($_POST['tel'])?$_POST['tel']:"";
$fax=isset($_POST['fax'])?$_POST['fax']:"";
$ville= ucwords($ville);
$nom= ucwords($nom);
$abonne_jp=isset($_POST['abonne_jp'])?$_POST['abonne_jp']:"";
$abonne_chanson=isset($_POST['abonne_chanson'])?$_POST['abonne_chanson']:"";
$num_client_parent=isset($_POST['client-parent'])?$_POST['client-parent']:"";

$nom = strtoupper( $nom );

$sql2 = "SELECT * FROM ".$tblpref."client , ".$tblpref."abonne
WHERE nom= 'client.".$nom."'
AND rue= 'client.".$rue."'
AND abonne_jp= 'abonne.".$abonne_jp."'
AND abonne_chanson= 'abonne.".$abonne_chanson."'
AND ville= 'client.".$ville."'";
$req2 = mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());
while($data = mysql_fetch_array($req2))
    {
    $client = $data['num_client'];
    $nom1 = stripslashes($data['nom']);
    $prenom1 =$data['prenom'];
    $nom2 = $data['nom2'];
    $rue1 = $data['rue'];
    $ville1 = stripslashes($data['ville']);
    $mail1 =$data['mail'];
    $tel1 = $data['tel'];
    $abonne_jp1 = $data['abonne_jp'];
    $abonne_chanson1 = $data['abonne_chanson'];
    
    if ($nom1!=""){
        echo "<h3><font color=red> $nom1 $prenom demeurant: $rue1 a $ville1<br> Dont le mail est: $mail1 , et egalement abonne a : $abonne_chanson1 , $abonne_jp1 <br>est deja sur la liste</font></h3><hr> <a href='form_client.php'>Retour au formulaire de saisie </a><br><a href='form_commande.php'>Ou aller directement a la saisie de commande</a> ";
        exit;
    }

}
if($pass != $pass2)
    {
    echo "<h1>$lang_mot_pa</h1>";
    include('form_client.php');
    exit;
    }

$pass = md5($pass);


if($nom=='' && (empty($mail) || empty($tel1)))
    {
   $message= "<h1>$lang_oubli_champ</h1>";
    include('form_client.php'); // On inclus le formulaire d'identification
    exit;
    }
if ($login !=''){
$sql = "SELECT * FROM " . $tblpref ."client WHERE login = '".$login."'";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$test = mysql_num_rows($req);
if ($test > 0) { 
$message= "<h1> $lang_er_mo_pa</h1>";
    include('form_client.php');
    exit;
		}
}
$sql1 = "INSERT INTO " . $tblpref ."client(nom, nom2, rue, ville, cp, num_tva, login, pass, mail, prenom, tel, fax) VALUES ('$nom', '$nom_sup', '$rue', '$ville', '$code_post', '$num_tva', '$login', '$pass', '$mail_cli', '$prenom', '$tel', '$fax')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

// Requete gestion des Abonnement // 
$sql100 = "INSERT INTO " . $tblpref ."abonne(abonne_jp, abonne_chanson) VALUES ('$abonne_jp', '$abonne_chanson')";
mysql_query($sql100) or die('Erreur SQL !<br>'.$sql100.'<br>'.mysql_error());

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
        $message= "<center><h2>Le client <font color=#009EDF>$nom </font> a bien ete enregistre </h2></center>";
        include("form_client.php");
    }
?>
