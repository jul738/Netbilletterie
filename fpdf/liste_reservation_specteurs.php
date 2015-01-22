<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require('mysql_table.php');
include("../include/config/common.php");
include("../include/config/var.php");
include("../include/language/fr.php");
include_once("../include/configav.php");
include_once("../include/fonction.php");

//on GET le numero du spectacle

define('FPDF_FONTPATH','font/');
$client_numero = isset($_GET['client_num'])?$_GET['client_num']:"";

class PDF extends PDF_MySQL_Table
{
    public $client_numero;
    public $logo;
    
    public function createData($input){
        $this->client_numero = $input;
    }
    
    public function Logo($logo){
        $this->logo = $logo;
    }
    
    function Header()
    {
        //Recupere les info client
$req_recup_info_client = "SELECT nom, prenom, rue, ville, cp, mail, tel
                          FROM client c
                          WHERE c.num_client ='$this->client_numero'";
$recup_info_client_brut = mysql_query($req_recup_info_client) or die('Erreur SQL2 !<br>'.$req_recup_info_client.'<br>'.mysql_error());
while($data = mysql_fetch_array($recup_info_client_brut))
    {
$nom = $data['nom'];
$prenom = $data['prenom'];
$rue = $data['rue'];
$ville = $data['ville'];
$cp = $data['cp'];
$mail = $data['mail'];
$tel = $data['tel'];
    }
        //le logo
    $this->Image("$this->logo",20,8,0,15,'jpg');
    $this->SetFillColor(255,238,204);


    //les infos du spectacle
    $this->SetFont('big_noodle_titling','',10);
    $this->SetY(12);
    $this->SetX(60);
    $this->MultiCell(130,6,utf8_decode("Liste des réservation pour :  \n - $nom $prenom."),0,C,0);

    $this->cell(80,5, utf8_decode('Nom du spectacle'), 1, 0, L, 0);
    $this->cell(33,5, utf8_decode('Date'), 1,0, L, 0);
    $this->cell(20,5, 'Horaire', 1, 0, L, 0);
    $this->cell(40, 5, 'Tarif', 1, 0, L, 0);
    $this->cell(20, 5, 'Nombre', 1, 0, L, 0);
    $this->setXY(10, $this->GetY()+5);
 
    }
    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('calibri','',8);
        // Print current and total page numbers
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    public function chexkResas() {
        $select_bon_comm = "SELECT num_bon FROM bon_comm WHERE client_num = $this->client_numero";
        $result_bon_comm = mysql_query($select_bon_comm) or die ('Erreur sql check résas');
        if (mysql_num_rows($result_bon_comm)==0){
            return false;
        }
        else {
            return true;
        }
    }
    
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
    //Ajoute du JavaScript pour lancer la bo�te d'impression ou imprimer immediatement
    $param=($dialog ? 'true' : 'false');
    $script=str_repeat("print($param);",$nb_impr);
		
    $this->IncludeJS($script);
}
//fin js

function TableResas(){
    
    $client_numero = $this->client_numero;
    
    $this->setXY(10, $this->GetY()+5);
    
    $select_resas = "SELECT client_num, id_article, bc.id_tarif, a.article, a.date_spectacle, a.horaire, t.nom_tarif, COUNT( num_bon ) AS compteur
FROM bon_comm AS bc, article AS a, tarif AS t
WHERE bc.client_num = $client_numero
AND bc.id_article = a.num
AND bc.id_tarif = t.id_tarif
GROUP BY id_article, bc.id_tarif
ORDER BY a.date_spectacle, a.horaire";;
$req_resas = mysql_query($select_resas) or die('Erreur séléction réservations');

    while($result_resas = mysql_fetch_array($req_resas))
	{
            $nb_article = $result_resas['article'];
            $this->cell(80,5, $nb_article, 1, 0, L, 0);
            $nb_date_timestamp = strtotime($result_resas['date_spectacle']);
            $nb_date = date_fr('l d-m-Y', $nb_date_timestamp);
            $this->cell(33,5, $nb_date, 1,0, L, 0);
            $nb_horaire = $result_resas['horaire'];
            $this->cell(20,5, $nb_horaire, 1, 0, L, 0);
            $nb_tarif = $result_resas['nom_tarif'];
            $this->cell(40, 5, $nb_tarif, 1, 0, L, 0);
            $nb_count = $result_resas['compteur'];
            $this->cell(20, 5, $nb_count, 1, 0, L, 0);
            $this->setXY(10, $this->GetY()+5);
	}     
    }
}
$pdf=new PDF('p','mm','a4');
//On ajoute les polices
$pdf->AddFont('calibri','','calibri.php');
$pdf->AddFont('big_noodle_titling','','big_noodle_titling.php');
$pdf->createData($client_numero);
$pdf->AliasNbPages();
$pdf->Logo($logo);
$file="liste_resa_spectateur.pdf";

$pdf->SetFont('calibri','',8);
$pdf->SetY(32);
$pdf->SetX(10);

//On vérifie s'il y a des résas de particuliers
$resa = $pdf->chexkResas();

if ($resa ==TRUE){
$pdf->header = 1;
$pdf->AddPage();
$pdf->TableResas();
}

$pdf->AutoPrint(false, $nbr_impr);

//Sauvegarde du PDF dans le fichier
$pdf->Output($file,"I");

echo "<HTML><SCRIPT>document.location='$file';</SCRIPT></HTML>";

?>