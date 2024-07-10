<?php

namespace App\Helpers;

use TCPDF;

class PdfHelper
{
    public static function generatePdf($title, $content)
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Définir les informations du document
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Votre Nom');
        $pdf->SetTitle($title);
        $pdf->SetSubject('Génération de PDF avec TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, exemple, test, guide');

        // Ajouter une page
        $pdf->AddPage();

        // Définir le style de police
        $pdf->SetFont('helvetica', '', 12);

        // Écrire le contenu dans le PDF
        $pdf->writeHTML($content, true, false, true, false, '');

        // Générer le PDF
        return $pdf->Output('example.pdf', 'I');
    }
}
