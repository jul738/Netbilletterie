<?php
//common.php cr�� grace � l'installeur de Net-Billetterie, soyez prudent si vous l'�ditez
$user= "root";//l'utilisateur de la base de donn�es mysql
$pwd= "b2Emi0902";//le mot de passe � la base de donn�es mysql
$db= "netbilletterie";//le nom de la base de donn�es mysql
$host= "localhost";//l'adresse de la base de donn�es mysql 
$default_lang= "fr";//la langue de l'interface et des factures cr��es par Net-Billetterie : voir la doc pour les abbr�viations
$tblpref= "";//prefixe des tables 
$db2 = mysql_connect($host,$user,$pwd) or die ("serveur de base de données injoignable, verifiez dans /Net-Billetterie/include/config/common.php si $host est correct.");
mysql_select_db($db) or die ("La base de donn�es est injoignable, verifiez dans /Net-Billetterie/include/config/common.php si $user, $pwd, $db sont exacts.");
mysql_set_charset('utf8', $db2);
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
?>