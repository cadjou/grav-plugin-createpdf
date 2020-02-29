<?php
// (c) Xavier Nicolay
// Exemple de génération de devis/facture PDF
namespace Grav\Plugin;

$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->addSociete( 'Groupe LBAC SAS', implode("\n",[
                  '24 rue Saint-Jean',
                  '01300 BELLEY',
                  'RCS de Bourg en Bresse 809 474 414',
                  'Au capital de 2 000 ' . EURO]),
                  'logo.png');
$pdf->fact_dev( "Pro Forma", "2005-01" );
$pdf->temporaire('Pro Forma - Pro Forma - Pro Forma - Pro Forma');
$pdf->addDate(date("d/m/Y"));
$pdf->addClient("517");
$pdf->addPageNumber("1");
$pdf->addClientAdresse("Ste Zahia Dehar\nM. Alexo SOSSA\n73, Avenue des Champs Elysees\n75008 Paris\nEmail : gina.sossa92@gmail.com");
$pdf->addReglement("Chèque à réception de facture");
$pdf->addEcheance(date("d/m/Y",strtotime('+4 weeks')));
$pdf->addNumTVA("FR27809474414");
$pdf->addReference("Devis ... du ....");
$cols=array( "REFERENCE"    => 23,
             "DESIGNATION"  => 78,
             "QUANTITE"     => 22,
             "P.U. HT"      => 26,
             "MONTANT H.T." => 30,
             "TVA"          => 11 );
$pdf->addCols( $cols);
$cols=array( "REFERENCE"    => "L",
             "DESIGNATION"  => "L",
             "QUANTITE"     => "C",
             "P.U. HT"      => "R",
             "MONTANT H.T." => "R",
             "TVA"          => "C" );
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols);

$y    = 109;
$line = array( "REFERENCE"    => 'NDD COM',
               "DESIGNATION"  => implode("\n",['Nom de Domaine',
                                 'zahia.com',
                                 'Redirection du domaine sur : https://www.instagram.com/zahiaofficiel/?hl=fr']),
               "QUANTITE"     => '1',
               "P .U. HT"      => '15',
               "MONTANT H.T." => '15',
               "TVA"          => '1' );
$size = $pdf->addLine( $y, $line );
$y   += $size + 2;

$pdf->addCadreTVAs();
        
// invoice = array( "px_unit" => value,
//                  "qte"     => qte,
//                  "tva"     => code_tva );
// tab_tva = array( "1"       => 19.6,
//                  "2"       => 5.5, ... );
// params  = array( "RemiseGlobale" => [0|1],
//                      "remise_tva"     => [1|2...],  // {la remise s'applique sur ce code TVA}
//                      "remise"         => value,     // {montant de la remise}
//                      "remise_percent" => percent,   // {pourcentage de remise sur ce montant de TVA}
//                  "FraisPort"     => [0|1],
//                      "portTTC"        => value,     // montant des frais de ports TTC
//                                                     // par defaut la TVA = 19.6 %
//                      "portHT"         => value,     // montant des frais de ports HT
//                      "portTVA"        => tva_value, // valeur de la TVA a appliquer sur le montant HT
//                  "AccompteExige" => [0|1],
//                      "accompte"         => value    // montant de l'acompte (TTC)
//                      "accompte_percent" => percent  // pourcentage d'acompte (TTC)
//                  "Remarque" => "texte"              // texte
$tot_prods = array( array ( "px_unit" => 15, "qte" => 1, "tva" => 1 ));
$tab_tva = array( "1"       => 19.6,
                  "2"       => 5.5);
$params  = array( "RemiseGlobale" => 0,
                      "remise_tva"     => 1,       // {la remise s'applique sur ce code TVA}
                      "remise"         => 0,       // {montant de la remise}
                      "remise_percent" => 10,      // {pourcentage de remise sur ce montant de TVA}
                  "FraisPort"     => 0,
                      "portTTC"        => 10,      // montant des frais de ports TTC
                                                   // par defaut la TVA = 19.6 %
                      "portHT"         => 0,       // montant des frais de ports HT
                      "portTVA"        => 19.6,    // valeur de la TVA a appliquer sur le montant HT
                  "AccompteExige" => 0,
                      "accompte"         => 0,     // montant de l'acompte (TTC)
                      "accompte_percent" => 15,    // pourcentage d'acompte (TTC)
                  "Remarque" => "Avec un acompte, svp..." );

$pdf->addTVAs( $params, $tab_tva, $tot_prods);
$pdf->addCadreEurosFrancs();
$pdf->AddPage();
foreach(array_fill(0,10,'O') as $x=>$dy)
{
    foreach(array_fill(0,10,'O') as $y=>$v)
    {
        $pdf->SetFont( "Arial", "B", 3);
        $pdf->SetXY($x * 2, $y );
		$pdf->Cell( 1 ,1, $v);
    }
}

$pdf->Output();
?>
