<?php
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr*/
session_cache_limiter('private');

if ($_POST['user']== 'adm') { 
require_once("../include/verif2.php");  
}

//error_reporting(0);
require_once('mysql_table.php');	
include_once("../include/config/common.php");
include_once("../include/config/var.php");
include_once("../include/language/$lang.php");
include_once("../include/configav.php"); 
include_once('../include/fonction.php');

//On inclut le répertoire des polices
define('FPDF_FONTPATH','font/');

$num_abo_com=isset($_POST['num_abo_com'])?$_POST['num_abo_com']:"";
$devise = ereg_replace('&euro;', $euro, $devise);
$slogan = stripslashes($slogan);
$entrep_nom= stripslashes($entrep_nom);
$social= stripslashes($social);
$tel= stripslashes($tel);
$tva_vend= stripslashes($tva_vend);
$compte= stripslashes($compte);
$reg= stripslashes($reg);
$mail= stripslashes($mail);

$mois = date("n");
$annee = date("Y");
if ($annee_1=='')
    {
         $annee_1= $annee ;
        if ($mois <= 6)
         {
            $annee_1=$annee_1;
         }
        if ($mois >= 7)
          {
            $annee_1=$annee_1+1;
          }
    }
$annee_2= $annee_1 -1;

//on récupère le nombre de specacle
$sql = "
SELECT nombre_spectacle, type_abonnement
FROM ".$tblpref."abonnement_comm AS ac, ".$tblpref."abonnement AS a 
WHERE ac.num_abo_com = $num_abo_com 
    AND ac.num_abonnement = a.num_abonnement";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while($data_nb = mysql_fetch_array($req)){
            $nb_li = $data_nb['nombre_spectacle'];
            $type_abonnement = $data_nb['type_abonnement'];
        }

//On récupère les infos sur l'abonnement et sur le client
$select_abo = "SELECT ac.date, nom_abonnement, tarif_abonnement, commentaire, p.nom AS nom_paiement, c.nom AS client_nom, prenom, rue, ville, cp, tel
                FROM ".$tblpref."abonnement_comm AS ac, ".$tblpref."abonnement AS a, ".$tblpref."type_paiement AS p, ".$tblpref."client AS c
                WHERE ac.num_abo_com = $num_abo_com 
                AND ac.num_abonnement = a.num_abonnement
                AND ac.paiement = p.id_type_paiement
                AND ac.client_num = c.num_client";
$req_abo = mysql_query($select_abo) or die ('Erreur séléction abonnement <br>'.$sql.'<br>'.mysql_error());
while($data_abo = mysql_fetch_array($req_abo)){
    $nom = $data_abo['client_nom'];
    $prenom = $data_abo['prenom'];
    $rue = $data_abo['rue'];
    $cp = $data_abo['cp'];
    $ville = $data_abo['ville'];
    $telephone = $data_abo['tel'];
    $nom_abo = $data_abo['nom_abonnement'];
    $date_abo = $data_abo['date'];
    $total = $data_abo['tarif_abonnement'].' EUROS';
}

class PDF extends PDF_MySQL_Table
{

function Header()
{		}
//debut Js
var $javascript;
    var $n_js;

    function IncludeJS($script) {
        $this->javascript=$script;
    }

    function _putjavascript() {
        $this->_newobj();
        $this->n_js=$this->n;
        $this->_out('<<');
        $this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R ]');
        $this->_out('>>');
        $this->_out('endobj');
        $this->_newobj();
        $this->_out('<<');
        $this->_out('/S /JavaScript');
        $this->_out('/JS '.$this->_textstring($this->javascript));
        $this->_out('>>');
        $this->_out('endobj');
    }

    function _putresources() {
        parent::_putresources();
        if (!empty($this->javascript)) {
            $this->_putjavascript();
        }
    }

    function _putcatalog() {
        parent::_putcatalog();
        if (isset($this->javascript)) {
            $this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
        }
    }
		function AutoPrint($dialog=false, $nb_impr)
{
    //Ajoute du JavaScript pour lancer la boite d'impression ou imprimer immediatement
    $param=($dialog ? 'true' : 'false');
    $script=str_repeat("print($param);",$nb_impr);
		
    $this->IncludeJS($script);
}
//fin js

}
$pdf=new PDF('p','mm','a4');
//On ajoute les polices
$pdf->AddFont('calibri','','calibri.php');
$pdf->AddFont('big_noodle_titling','','big_noodle_titling.php');
$pdf->Open();

$pdf->AddPage();

//Le type de concert
if ($type_abonnement == 'Concert'){
    $pdf->Image("guitare.jpg",30,50,0,30,'jpg');
    $pdf->SetFont('big_noodle_titling','',28);
    $pdf->SetY(60);
    $pdf->SetX(60);
    $pdf->MultiCell(90,6,"Abonnement Concert",0,C,0);
    $pdf->SetTextColor(0,0,255);
}
if ($type_abonnement == 'Spectacle_JP'){
    $pdf->Image("clown.jpg",30,50,0,30,'jpg');
    $pdf->SetFont('big_noodle_titling','',28);
    $pdf->SetY(60);
    $pdf->SetX(60);
    $pdf->MultiCell(90,6,"Abonnement Jeune Public",0,C,0);
    $pdf->SetTextColor(194,8,8);
}

//Troisieme cellule le slogan
$pdf->SetFont('big_noodle_titling','',20);
$pdf->SetY(70);
$pdf->SetX(60);
$pdf->MultiCell(90,6,"$slogan $annee_2-$annee_1",0,C,0);
$pdf->SetTextColor(0,0,0);

//deuxieme cellule les coordonées clients
$pdf->SetFont('calibri','',12);
$pdf->SetY(80);
$pdf->SetX(60);
$pdf->MultiCell(90,6,"$nom $prenom \n $rue \n $cp  $ville \n $telephone",0,C,0);

//Le tableau des spectacles

// On récupère les spectacles associés à l'article et on les affiche
$select_resa = "SELECT article, lieu, horaire, date_spectacle, num_resa_1, num_resa_2, num_resa_3, num_resa_4, num_resa_5, num_resa_6, num_resa_7
FROM ".$tblpref."article AS a, ".$tblpref."bon_comm AS bc, ".$tblpref."abonnement_comm AS ac 
WHERE  bc.id_article = a.num
AND ac.num_abo_com = $num_abo_com
AND bc.num_bon IN (num_resa_1, num_resa_2, num_resa_3, num_resa_4, num_resa_5, num_resa_6, num_resa_7)
ORDER BY date_spectacle";
$result_resa = mysql_query($select_resa) or die ('Erreur de séléction des réservations');

                $pdf->SetFont('calibri','',12);
                $pdf->SetXY(50,$pdf->GetY()+10);
		while($data_resa = mysql_fetch_array($result_resa))
		{
		$article = utf8_decode($data_resa['article']);
		$date_brute = strtotime($data_resa['date_spectacle']);
                $date = date_fr('l d-m-Y', $date_brute);
                $horaire = $data_resa['horaire'];
                $pdf->MultiCell(110,6,"$article \n $date $horaire",0,C,0);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetXY(50,$pdf->GetY()+1);
		}

//$pdf->ln(10);

//Troisieme cellule info pratique
$pdf->SetFont('calibri','',9);
$pdf->SetY(230);
$pdf->SetX(60);
$pdf->MultiCell(90,4,utf8_decode("Abonnement à presenter à l'entrée des spectacles. \n Retrait des billets sur place au plus tard 15 minutes avant la séance. \n Attention  ! Après l'heure annoncée de la séance, l'accès à la salle n'est plus garanti."),0,C,0);

if($autoprint=='y' and $_POST['mail']!='y' and $_POST['user']=='adm'){
$pdf->AutoPrint(false, $nbr_impr);
}
//Sauvegarde du PDF dans le fichier
$pdf->Output("$file","I");
//Redirection JavaScript
//echo "<HTML><SCRIPT>document.location='$file';</SCRIPT></HTML>";
if ($_POST['mail']=='y') {
$to = "$mail_client";
$sujet = "Bon de commande de $entrep_nom";
$message = "Bonjour, \n Veuillez trouver ci-joint une copie de votre bon de commande pour les spectacles de la saison culturelle. \n Merci de conserver ce mail pour pouvoir l'imprimer en cas de besoin. \n \n
Meilleurs salutations de l'équipe de la saison culturelle.";
$fichier = "$file";
$typemime = "pdf";
$nom = "$file";
$reply = "$mail";
$from = "$entrep_nom<$mail>";
require "../include/CMailFile.php";
$newmail = new CMailFile("$sujet","$to","$from","$message","$fichier","application/pdf");
$newmail->sendfile();

echo "<HTML><SCRIPT>document.location='../lister_commandes.php';</SCRIPT></HTML>";
  
} else { 
echo "<HTML><SCRIPT>document.location='$file';</SCRIPT></HTML>";
}
?> 