<?php
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr*/
include_once("include/config/common.php");
//===============================================
//pour controler si bien logu�

class Auth{
    static function isLogged(){
        if (isset($_SESSION['Auth']) && isset($_SESSION['Auth']['login']) && isset($_SESSION['Auth']['pass'])&& isset($_SESSION['Auth']['tblpref'])) {
            extract($_SESSION['Auth']);
            $sql="SELECT num FROM ".$tblpref."user WHERE login='$login' AND pwd='$pass' ";
            $req=mysql_query($sql) or die (mysql_error());
            if( mysql_num_rows($req)>0){
                return true;
            }
            else{
                return false;
            }
        }
        else {
            return false;
        }
    }
}
//===============================================
include_once("include/config/var.php");
include_once 'lib/Zebra_Session.php';
$session = new Zebra_Session;

 $login=$_SESSION['Auth']['login'];
 $lang=$_SESSION['Auth']['lang'];
 $tblpref=$_SESSION['Auth']['tblpref'];

if($_SESSION['Auth']=='')
{
	echo "Vous n'êtes pas autorisé à accéder à cette zone\n\n";
	echo print_r($HTTP_SESSION_VARS);
	echo "\n\n";
	//include('login.inc.php');
	exit;
}

if ($lang=='')
{ 
	$lang ="fr";  
}

$sqlz = "SELECT * FROM ".$tblpref."user WHERE ".$tblpref."user.login = \"$login\"";
$req = mysql_query($sqlz) or die('Erreur SQL !<br/>'.$sqlz.'<br/>'.mysql_error());
while($data = mysql_fetch_array($req))
{
	$user_num    = $data['num'];
	$user_nom    = $data["nom"];
	$user_prenom = $data["prenom"];
	$user_email  = $data['email'];
	$user_fact   = $data['fact'];
	$user_com    = $data['com'];
	$user_dev    = $data['dev'];
	$user_admin  = $data['admin'];
	$user_dep    = $data['dep'];
	$user_stat   = $data['stat'];
	$user_art    = $data['art'];
	$user_cli    = $data['cli'];
	$print_user  = $data['print_user'];
	$user_menu   = $data['menu'];
}
 if ($entrep_nom==""){
    $message="<h1>Il semblerait que vous n'ayez pas encore configuré Net-Billetterie</h1>";
    include("admin.php");
  }
?>
