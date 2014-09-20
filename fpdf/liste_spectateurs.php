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
//on GET le numero du spectacle

define('FPDF_FONTPATH','font/');
$article_numero = isset($_GET['article'])?$_GET['article']:"";

class PDF extends PDF_MySQL_Table
{
    public $article_numero;
    public $logo;
    
    public function createData($input){
        $this->article_numero = $input;
    }
    
    public function Logo($logo){
        $this->logo = $logo;
    }
    
    function Header()
    {
        //on recupère les infos du spectacle
        $sql2="SELECT DATE_FORMAT(date_spectacle,'%d/%m/%Y') AS date_spectacle, article, stock, num, lieu, horaire FROM ".$tblpref."article WHERE num=$this->article_numero";
        $req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while($data = mysql_fetch_array($req2)){
        $article = $data['article'];
        $article_numero= $data['num'];
        $date = $data['date_spectacle'];
        $stock = $data['stock'];
        }

        //On récupère le nombre de billet vendu
        $select_nb_billet = "SELECT COUNT(num_bon) FROM bon_comm WHERE id_article=$article_numero";
        $req_nb_billet = mysql_query($select_nb_billet) or die ('Erreur comptage billet');
        while ($data_nb_billet = mysql_fetch_array($req_nb_billet)){
            $nb_billet = $data_nb_billet['COUNT(num_bon)'];
        }

        //le logo
    $this->Image("$this->logo",20,8,0,15,'jpg');
    $this->SetFillColor(255,238,204);


    //les infos du spectacle
    $this->SetFont('big_noodle_titling','',10);
    $this->SetY(12);
    $this->SetX(60);
    $this->MultiCell(130,6,"Liste des spectateurs pour :  \n - $article -  le $date. \n Il reste $stock places. $nb_billet places de vendus",0,C,0);

    if ($this->header ==1 ){
                $this->cell(50,5, utf8_decode('nom Prénom'), 1, 0, L, 0);
                $this->cell(23,5, utf8_decode('Téléphone'), 1,0, L, 0);
                $this->cell(40,5, 'Tarif', 1, 0, L, 0);
                $this->cell(80, 5, 'Commentaire', 1, 0, L, 0);
                $this->setXY(10, $this->GetY()+5);
    }
    elseif ($this->header == 2){
                $this->cell(50,5, utf8_decode('nom du groupe'), 1, 0, L, 0);
                $this->cell(30,5, utf8_decode('Nom du référent'), 1,0, L, 0);
                $this->cell(20,5, utf8_decode('Téléphone'), 1, 0, L, 0);
                $this->cell(5, 5, 'En', 1, 0, L, 0);
                $this->cell(5, 5, 'Ad', 1, 0, L, 0);
                $this->cell(80, 5, 'Commentaire', 1, 0, L, 0);
                $this->setXY(10, $this->GetY()+5);
    }
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

    public function checkGroupe(){
        $select_comm_groupe = "SELECT num_bon_groupe FROM bon_comm_groupe WHERE id_article = $this->article_numero";
        $result_comm_groupe = mysql_query($select_comm_groupe) or die ('Erreur sql check groupe');
        if (mysql_num_rows($result_comm_groupe)==0){
            return false;
        }
        else {
            return true;
        }
    }
    
    public function chexkParticulier() {
        $select_bon_comm = "SELECT num_bon FROM bon_comm WHERE id_article = $this->article_numero";
        $result_bon_comm = mysql_query($select_bon_comm) or die ('Erreur sql check particulier');
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

function TableParticulier(){
    
    $article_numero = $this->article_numero;
    
    $this->setXY(10, $this->GetY()+5);
    
    $select_spectateurs = "SELECT DISTINCT(BC.num_bon), nom, prenom, tel, nom_tarif, coment FROM ".$tblpref."client C, ".$tblpref."cont_bon CB, ".$tblpref."bon_comm BC , ".$tblpref."tarif T,".$tblpref."article A
	WHERE BC.client_num=C.num_client
	AND BC.id_article = $article_numero
	AND A.num = $article_numero
	AND BC.id_tarif = T.id_tarif 
	ORDER BY C.nom, BC.id_tarif";
$req_spectateurs = mysql_query($select_spectateurs) or die('Erreur séléction spectateur');

    while($result_spectateurs = mysql_fetch_array($req_spectateurs))
	{
            $nom = $result_spectateurs['nom'];
            $prenom = $result_spectateurs['prenom'];
            $this->cell(50,5, $nom.' '.$prenom, 1, 0, L, 0);
            $telephone = $result_spectateurs['tel'];
            $this->cell(23,5, $telephone, 1,0, L, 0);
            $tarif = $result_spectateurs['nom_tarif'];
            $this->cell(40,5, $tarif, 1, 0, L, 0);
            $commentaire = $result_spectateurs['coment'];
            $this->cell(80, 5, $commentaire, 1, 0, L, 0);
            $this->setXY(10, $this->GetY()+5);
	}     
        }
        
        function TableGroupe(){
            $select_groupe = "SELECT nom_structure, nom_referent, telephone_referent, nb_enfants, nb_accompagnateurs, coment FROM bon_comm_groupe AS bcg, groupe AS g WHERE bcg.id_article = $this->article_numero AND bcg.num_groupe = g.num_groupe";
            $result_groupe = mysql_query($select_groupe) or die ('Erreur séléction groupe');
            while($data_groupe = mysql_fetch_array($result_groupe)){
                $nom_groupe = $data_groupe['nom_structure'];
                $this->cell(50,5, utf8_decode($nom_groupe), 1, 0, L, 0);
                $nom_referent = $data_groupe['nom_referent'];
                $this->cell(30,5, utf8_decode($nom_referent), 1,0, L, 0);
                $tel_referent = $data_groupe['telephone_referent'];
                $this->cell(20,5, utf8_decode($tel_referent), 1, 0, L, 0);
                $enfant = $data_groupe['nb_enfants'];
                $this->cell(5, 5, $enfant, 1, 0, L, 0);
                $adulte = $data_groupe['nb_accompagnateurs'];
                $this->cell(5, 5, $adulte, 1, 0, L, 0);
                $commentaire = $data_groupe['coment'];
                $this->cell(80, 5, utf8_decode($commentaire), 1, 0, L, 0);
                $this->setXY(10, $this->GetY()+5);
            }
            
        }

}
$pdf=new PDF('p','mm','a4');
//On ajoute les polices
$pdf->AddFont('calibri','','calibri.php');
$pdf->AddFont('big_noodle_titling','','big_noodle_titling.php');
$pdf->createData($article_numero);
$pdf->AliasNbPages();
$pdf->Logo($logo);
$file="liste_pour_spectacle.pdf";

$pdf->SetFont('calibri','',8);
$pdf->SetY(32);
$pdf->SetX(10);

//On vérifie s'il y a des résas de particuliers
$resa = $pdf->chexkParticulier();
if ($resa ==TRUE){
$pdf->header = 1;
$pdf->AddPage();
$pdf->TableParticulier();
}
//On vérifie s'il y a des groupes pour savoir s'il faut afficher la page
$groupe = $pdf->checkGroupe();
if ($groupe == TRUE){
$pdf->header = 2;
$pdf->AddPage();
$pdf->TableGroupe();
}
$pdf->AutoPrint(false, $nbr_impr);

//Sauvegarde du PDF dans le fichier
$pdf->Output($file,"I");

echo "<HTML><SCRIPT>document.location='$file';</SCRIPT></HTML>";

?>