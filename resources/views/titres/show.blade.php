<?php
/**
 * Created by PhpStorm.
 * User: HenriJ
 * Date: 11/01/2018
 * Time: 00:23
 */

use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Auth;

$chemin_qr = "../public/img/qrcodes/qrcode" . $titre->numero . ".png";
QrCode::format('png');
QrCode::generate($titre->numero, $chemin_qr);

class TitrePDF extends Fpdf
{

    function Header()
    {
        parent::Header(); // TODO: Change the autogenerated stub
    }

    function Footer()
    {
        // To be implemented in your own inherited class
        $this::SetY(-15);
        $this::SetFont('Helvetica', '', 6);
        $this::Cell(0, 10, utf8_decode("Imprimé par l'Application de Gestion des Titres d'Accès Temporaires au Port Autonome de Cotonou (AGTAT-PAC). Copyright 2018"), 0, "", "L");

    }
}

/*START OF HEADER*/
$pdf = new TitrePDF();
$pdf::AddPage();
$pdf::SetAutoPageBreak(false);
$pdf::SetFont('Arial', 'BU', 14);
$pdf::Cell(0, 20, utf8_decode(strtoupper("Titre d'accÈs temporaire au Port")), 0, "", "C");

$pdf::Ln(15);
$pdf::SetFont('Courier', 'I', 12);
$pdf::SetX(45);
$pdf::SetFillColor(211, 211, 211);
$pdf::Cell(60, 7.5, 'LAISSEZ PASSER', 1, "", "C", true);

$pdf::Ln(12);
$pdf::SetFont('Helvetica', '', 10);
$pdf::MultiCell(100, 10, utf8_decode(
    "Structure : \n     " . strtoupper($titre->usager->structure->raison_sociale)
), 0, "L");

$pdf::SetY(37);
$pdf::SetX(100);
$pdf::SetFont('Helvetica', 'B', 12);
$pdf::SetDrawColor(122, 122, 122);
$pdf::SetLineWidth(0.8);
$pdf::Cell(40, 8, utf8_decode('N° TITRE'), 1, "", "C");

$pdf::SetY(46);
$pdf::SetX(95);
$pdf::SetFont('Helvetica', 'B', 13);
$pdf::SetDrawColor(255, 255, 255);
$pdf::Cell(50, 10, utf8_decode($titre->numero), 0, "", "C");


$pdf::SetY(55);
$pdf::Ln(5);
$pdf::SetFont('Helvetica', '', 10);
/*END OF HEADER*/


/*BODY*/
if ($titre->typeTitre->code === "BT") {

    $pdf::SetFont('Arial', '', 25);
    $pdf::SetTextColor(238,238,238);
    $pdf::RotatedText(45,125,strtoupper($titre->usager->nom.' '.$titre->usager->prenom),45);

    $pdf::SetFont('Helvetica', '', 10);
    $pdf::SetTextColor(0,0,0);
    $pdf::MultiCell(150, 10, utf8_decode(
        "Nom : " . strtoupper($titre->usager->nom) . "\n" .
        "Prénoms : " . strtoupper($titre->usager->prenom) . "\n" .
        "Fonction : " . strtoupper($titre->usager->fonction) . "\n" .
        "Téléphone : " . strtoupper($titre->usager->telephone) . "\n" .
        "Installation Portuaire : " . ($titre->zone->libelle) . "\n" .
        "Coût du badge HT   : " . strtoupper(number_format($titre->cout, 0, ',', ' .')) . " FCFA                      Durée : " . $titre->duree . " Heures\n" .
        "Coût du badge TTC : " . number_format(intval($titre->cout) * 1.18, 0, ',', ' .') . " FCFA\n" .
        "Délivrance : " . date('d/m/Y à H:i', strtotime($titre->date_delivrance)) . "                          Expiration : " . date('d/m/Y à H:i', strtotime("+$titre->duree hours", strtotime($titre->date_delivrance)))

    ), 0, "L");

    $pdf::Image($chemin_qr, 10, 140, 30);

} else if ($titre->typeTitre->code === "MT") {

    $vehicule = DB::table('vehicules')->where('user_id',$titre->usager_id)->first();

    $pdf::SetFont('Arial', '', 35);
//    $pdf::SetTextColor(150,150,150);
    $pdf::SetTextColor(230,230,230);

    $pdf::RotatedText(50,120,strtoupper($vehicule->immatriculation),45);

    $pdf::SetFont('Helvetica', '', 10);
    $pdf::SetTextColor(0,0,0);
    $pdf::MultiCell(150, 10, utf8_decode(
        "Immatr. véhicule : " . strtoupper($vehicule->immatriculation) . "\n" .
        "Respo. Chauffeur : " . strtoupper($titre->usager->nom) ." ".$titre->usager->prenom. "\n" .
        "Téléphone : " . strtoupper($titre->usager->telephone) . "\n" .
        "Installation Portuaire : " . ($titre->zone->libelle) . "\n" .
        "Coût du macaron HT   : " . strtoupper(number_format($titre->cout, 0, ',', ' .')) . " FCFA                 Durée : " . $titre->duree . " Heures\n" .
        "Coût du macaron TTC : " . number_format(intval($titre->cout) * 1.18, 0, ',', ' .') . " FCFA\n" .
        "Délivrance : " . date('d/m/Y à H:i', strtotime($titre->date_delivrance)) . "                          Expiration : " . date('d/m/Y à H:i', strtotime("+$titre->duree hours", strtotime($titre->date_delivrance)))

    ), 0, "L");

    $pdf::Image($chemin_qr, 10, 130, 30);
}
/*END OF BODY*/

$pdf::Cell(97.5, 10, utf8_decode('Caissier(ère)'), 0, "", "R");
$pdf::Ln(7);
$pdf::SetX(85.5);
$pdf::Cell(50, 10, utf8_decode(Auth::user()->prenom .' '. Auth::user()->nom), 0, "", "L");
$pdf::Ln(26);
$pdf::SetFont('Helvetica', '', 8);
$pdf::Cell(30, 10, utf8_decode('Cotonou, le ' . date("d/m/Y")), 0, "", "L");

$pdf->Footer();

$pdf::Output();
exit;
?>

