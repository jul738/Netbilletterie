<?php 
/* Net Billetterie Copyright(C)2014 Vanessa Kovalsky David
 Logiciel de billetterie libre. 
Developpe depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Vanessa Kovalsky vanessa.kovalsky@free.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");

// On récupère l'id du groupe

if(!empty($_GET['num_groupe'])){
    $num_groupe = $_GET['num_groupe'];
}

// On supprime le groupe

$sql_delete_groupe = "DELETE FROM ".$tblpref."groupe WHERE num_groupe = '".$num_groupe."'";
mysql_query($sql_delete_groupe) or die('Erreur SQL suppression groupe !<br>'.$sql_delete_groupe.'<br>'.mysql_error());

echo "Le groupe ".$num_groupe." a bien été supprimé";

include_once("lister_groupes.php");