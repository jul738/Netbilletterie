<?php
 function pagination($url,$parpage,$nblignes,$nbpages)
 {
 // On crée le code html pour la pagination
 $initial=isset($_GET['initial'])?$_GET['initial']:"";
 $ordre=isset($_GET['ordre'])?$_GET['ordre']:"";
 $par_page=isset($_GET['parpage'])?$_GET['parpage']:"";
 
 $html = precedent($url,$parpage,$nblignes,$initial); // On cr�e le lien precedent
 // On v�rifie que l'on a plus d'une page � afficher
 if ($nbpages > 1) {
 // On boucle sur les num�ros de pages � afficher
 for ($i = 0 ; $i < $nbpages ; ++$i) {
 $limit = $i * $parpage; // On calcule le d�but de la valeur 'limit'
 $limit = $limit.",".$parpage; // On fait une concat�nation avec $parpage
  // On affiche les liens des num�ros de pages
 $html .= "<a href=".$url.$limit."&initial=".$initial."&ordre=".$ordre."&parpage=".$par_page.">".($i + 1)."</a> | " ;
 }
      $page=position($parpage);
      //si y pas de limit c est que cest la premi�re page
      if(empty($page)){$page =1;}
      echo "<h1>PageN°$page/$nbpages</h1>";
      


 }
 // Si l'on a qu'une page on affiche rien

 else {
 $html .= "";
 }
 $html .= suivant($url,$parpage,$nblignes); // On cr�e le lien suivant
 // On retourne le code html
 return $html;
 }
 function validlimit($nblignes,$parpage,$sql)
 {
 // On v�rifie l'existence de la variable $_GET['limit']
 // $limit correspond � la clause LIMIT que l'on ajoute � la requ�te $sql
 if (isset($_GET['limit'])) {
 $pointer = split('[,]', $_GET['limit']); // On scinde $_GET['limit'] en 2
 $debut = $pointer[0];
 $fin = $pointer[1];
 // On v�rifie la conformit� de la variable $_GET['limit']
 if (($debut >= 0) && ($debut < $nblignes) && ($fin == $parpage)) {
 // Si $_GET['limit'] est valide on lance la requ�te pour afficher la page
 $limit = $_GET['limit']; // On r�cup�re la valeur 'limit' pass�e par url
 $sql .= " LIMIT ".$limit.";"; // On ajoute $limit � la requ�te $sql
 $result = mysql_query($sql); // Nouveau r�sultat de la requ�te
 }
 // Sinon on affiche la premi�re page
 else {
 $sql .= " LIMIT 0,".$parpage.";"; // On ajoute la valeur LIMIT � la requ�te
 $result = mysql_query($sql); // Nouveau r�sultat de la requ�te
 }
 }
 // Si la valeur 'limit' n'est pas connue, on affiche la premi�re page
 else {
 $sql .= " LIMIT 0,".$parpage.";"; // On ajoute la valeur LIMIT � la requ�te
 $result = mysql_query($sql); // Nouveau r�sultat de la requ�te
 }
 // On retourne le r�sultat de la requ�te
 return $result;
 }
 function precedent($url,$parpage,$nblignes,$initial,$ordre)
 {
 // On vérifie qu'il y a au moins 2 pages à afficher
 if ($nblignes > $parpage) {
 // On vérifie l'existence de la variable $_GET['limit']
 if (isset($_GET['limit'])) {
 // On scinde la variable 'limit' en utilisant la virgule comme séparateur
 $pointer = split('[,]', $_GET['limit']);
 // On récupère le nombre avant la virgule et on soustrait la valeur $parpage
 $pointer = $pointer[0]-$parpage;
 // Si on atteint la premi�re page, pas besoin de lien 'Précédent'
 if ($pointer < 0) {
 $precedent = "";
 }
 // Sinon on affiche le lien avec l'url de la page précédente
 else {
 $limit = "$pointer,$parpage";
  $ordre= $_GET['ordre'];
  $par_page= $_GET['parpage'];
 $precedent = "<a href='".$url.$limit."&initial=".$initial."&ordre=".$ordre."&parpage=".$par_page."'>Pr�c�dent</a> | ";
 }
 }
 else {
 $precedent = ""; // On est à la première page, pas besoin de lien 'Précédent'
 }
 }
 else {
 $precedent = ""; // On a qu'une page, pas besoin de lien 'Pr�c�dent'
 }
 return $precedent;
 }
 
 function suivant($url,$parpage,$nblignes,$initial,$ordre)
 {
 // On v�rifie qu'il y a au moins 2 pages � afficher
 if ($nblignes > $parpage) {
 // On v�rifie l'existence de la variable $_GET['limit']
 if (isset($_GET['limit']['initial'])) {
 // On scinde la variable 'limit' en utilisant la virgule comme s�parateur
 $pointer = split('[,]', $_GET['limit']);
 // On r�cup�re le nombre avant la virgule auquel on ajoute la valeur $parpage
 $pointer = $pointer[0] + $parpage;
 // Si on atteint la derni�re page, pas besoin de lien 'Suivant'
 if ($pointer >= $nblignes) {
 $suivant = "";
 }
 // Sinon on affiche le lien avec l'url de la page suivante
 else  {
 $limit = "$pointer,$parpage";
 $initial= $_GET['initial'];
 $ordre= $_GET['ordre'];
 $par_page= $_GET['parpage'];
 $suivant = "<a class='pagination' href=".$url.$limit."&initial=".$initial."&ordre=".$ordre."&parpage=".$par_page.">Suivant</a>";
 }
 }
 // Si pas de valeur 'limit' on affiche le lien de la deuxi�me page
 if (@$_GET['limit']== false) {
	 
$initial= $_GET['initial'];
$ordre= $_GET['ordre'];
$par_page= $_GET['parpage'];
 $suivant = "<a href=".$url.$parpage."&initial=".$initial.",".$parpage."&initial=".$initial."&ordre=".$ordre."&parpage=".$par_page."></a>";
 }
 }
 else {
 $suivant = ""; // On a qu'une page, pas besoin de lien 'Suivant'
 }
 return $suivant;
 } 

 function date_fr($format, $timestamp=false) {
    if ( !$timestamp ) $date_en = date($format);
    else               $date_en = date($format,$timestamp);

    $texte_en = array(
        "Monday", "Tuesday", "Wednesday", "Thursday",
        "Friday", "Saturday", "Sunday", "January",
        "February", "March", "April", "May",
        "June", "July", "August", "September",
        "October", "November", "December"
    );
    $texte_fr = array(
        "Lundi", "Mardi", "Mercredi", "Jeudi",
        "Vendredi", "Samedi", "Dimanche", "Janvier",
        "F&eacute;vrier", "Mars", "Avril", "Mai",
        "Juin", "Juillet", "Ao&ucirc;t", "Septembre",
        "Octobre", "Novembre", "D&eacute;cembre"
    );
    $date_fr = str_replace($texte_en, $texte_fr, $date_en);

    $texte_en = array(
        "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun",
        "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul",
        "Aug", "Sep", "Oct", "Nov", "Dec"
    );
    $texte_fr = array(
        "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim",
        "Jan", "F&eacute;v", "Mar", "Avr", "Mai", "Jui",
        "Jui", "Ao&ucirc;", "Sep", "Oct", "Nov", "D&eacute;c"
    );
    $date_fr = str_replace($texte_en, $texte_fr, $date_fr);

    return $date_fr;
}
?>