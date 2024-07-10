<?php

namespace App\Http\Controllers;

use App\Models\Antecedant;
use App\Models\Consultation;
use TCPDF;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Prescrire;
use App\Models\Rendez_vous;
use App\Models\ResultP;
use App\Models\CaisseMvt;
use App\Models\Caisse;

class PdfController extends Controller
{
    public function ordo(string $numero_recu)
    {
        $C = Caisse::PatPerPayeUn($numero_recu);
        $CM = CaisseMvt::where('num_recu', '=', $numero_recu)->get();
        // Création d'une nouvelle instance TCPDF
        $pdf = new TCPDF('L', 'mm', 'A5', true, 'UTF-8', false);
        $pdf->SetMargins(10, 10, 10); // Marges: gauche, haut, droite

        // Définition des informations du document
        $pdf->SetCreator('Mon Application');
        $pdf->SetAuthor('Nom de l\'auteur');
        $pdf->SetTitle('Reçu de Caisse');
        $pdf->SetSubject('Reçu de paiement');

        // Début du document
        $pdf->AddPage();

        // tete de page
        $pdf->SetY(0);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, "FONDATION MEDICAL NGOUALEM'S - CAMEROUN", 0, 1, 'C');

        // Définition du contenu du reçu de caisse
        $pdf->SetFont('helvetica', '', 10);

        // Titre
        $pdf->Cell(0, 8, 'Reçu de Caisse N° : ' . $numero_recu, 1, 1, 'C');

        // Informations du paiement (exemple)
        $date = date('d-m-Y');
        $heure = date('H:i:s');
        $nomClient = $C->nom . ' ' . $C->prenom;
        $receipt_number = '987654321';

        $qrCodeData =
            'Reçu #' . $numero_recu . PHP_EOL
            . 'Date : ' . $C->date_c . PHP_EOL
            . 'Montant : ' . $C->verser . ' FCFA' . PHP_EOL
            . 'Patient : ' . $C->nom . ' ' . $C->prenom . PHP_EOL
            . 'Motif de versement : ' . $C->motif . PHP_EOL
            . 'Structure : FMN-C';
        $qrCodeSize = 30; // Taille du code QR en millimètres
        $qrCodePosX = 180; // Position X du code QR
        $qrCodePosY = 20; // Position Y du code QR
        $pdf->write2DBarcode($qrCodeData, 'QRCODE,L', $qrCodePosX, $qrCodePosY, $qrCodeSize, $qrCodeSize);

        $pdf->Ln(2);
        $pdf->Cell(30, 7, 'Date et Heure :', 0, 0);
        $pdf->Cell(40, 7, $date . ' à ' . $heure, 0, 1);

        $pdf->Cell(30, 7, 'Nom du Patient :', 0, 0);
        $pdf->Cell(40, 7, $nomClient, 0, 1);

        $pdf->Cell(30, 7, 'Motif de paiement : ', 0, 0);
        $pdf->Cell(40, 7, $C->motif, 0, 1);
        $pdf->Ln(4);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(230, 230, 230);

        // Calculer la largeur des colonnes en fonction de la taille de la page
        $largeurCelluleDescription = 0.4 * $pdf->getPageWidth(); // 40% de la largeur de la page
        $pdf->SetX(40);
        $pdf->Cell(10, 7, 'N°', 1, 0, 'C', true);

        $pdf->Cell($largeurCelluleDescription, 7, 'Designation', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Montant', 1, 1, 'C', true);
        $i = 1;
        $pdf->SetFont('helvetica', '', 10);
        foreach ($CM as $row) {
            $pdf->SetX(40);
            $pdf->Cell(10, 7, $i, 1, 0, 'C', true);
            $pdf->Cell($largeurCelluleDescription, 7, $row->libelle, 1, 0, 'L');
            $pdf->Cell(40, 7, $row->montant . ' FCFA', 1, 1, 'R');
            $i++;
        }

        // Total
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', 'B', 10);

        $pdf->Cell(30, 7, 'Total à Payer ', 1, 0, 'L');
        $pdf->Cell(40, 7, $C->prix . ' FCFA', 1, 0, 'R');
        $pdf->Cell(30, 7, 'Montant versé : ', 1, 0, 'R');
        $pdf->Cell(40, 7, $C->verser . ' FCFA', 1, 0, 'R');
        $pdf->Cell(15, 7, 'Reste : ', 1, 0, 'R');
        $pdf->Cell(35, 7, $C->reste . ' FCFA', 1, 1, 'R');
        $pdf->Ln(2);
        $pdf->Cell(40, 7, 'Montant en lettre :', 1, 0, 'L');
        $pdf->Cell(0, 7, $C->lettre, 1, 1, 'L');
        $pdf->Ln(2);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(50, 10, "Patient", 0, 0, 'C');
        $pdf->Cell(100, 10, "", 0, 0, 'C');
        $pdf->Cell(50, 10, "Caisse", 0, 0, 'C');

        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output('recu.pdf', 'I');
        }, 'recu.pdf');
    }
    public function recu(string $numero_recu)
    {
        $C = Caisse::PatPerPayeUn($numero_recu);
        $CM = CaisseMvt::where('num_recu', '=', $numero_recu)->get();
        // Création d'une nouvelle instance TCPDF
        $pdf = new TCPDF('L', 'mm', 'A5', true, 'UTF-8', false);
        $pdf->SetMargins(10, 10, 10); // Marges: gauche, haut, droite

        // Définition des informations du document
        $pdf->SetCreator('Mon Application');
        $pdf->SetAuthor('Nom de l\'auteur');
        $pdf->SetTitle('Reçu de Caisse');
        $pdf->SetSubject('Reçu de paiement');

        // Début du document
        $pdf->AddPage();

        // tete de page
        $pdf->SetY(0);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, "FONDATION MEDICAL NGOUALEM'S - CAMEROUN", 0, 1, 'C');

        // Définition du contenu du reçu de caisse
        $pdf->SetFont('helvetica', '', 10);

        // Titre
        $pdf->Cell(0, 8, 'Reçu de Caisse N° : ' . $numero_recu, 1, 1, 'C');

        // Informations du paiement (exemple)
        $date = date('d-m-Y');
        $heure = date('H:i:s');
        $nomClient = $C->nom . ' ' . $C->prenom;
        $receipt_number = '987654321';

        $qrCodeData =
            'Reçu #' . $numero_recu . PHP_EOL
            . 'Date : ' . $C->date_c . PHP_EOL
            . 'Montant : ' . $C->verser . ' FCFA' . PHP_EOL
            . 'Patient : ' . $C->nom . ' ' . $C->prenom . PHP_EOL
            . 'Motif de versement : ' . $C->motif . PHP_EOL
            . 'Structure : FMN-C';
        $qrCodeSize = 30; // Taille du code QR en millimètres
        $qrCodePosX = 180; // Position X du code QR
        $qrCodePosY = 20; // Position Y du code QR
        $pdf->write2DBarcode($qrCodeData, 'QRCODE,L', $qrCodePosX, $qrCodePosY, $qrCodeSize, $qrCodeSize);

        $pdf->Ln(2);
        $pdf->Cell(30, 7, 'Date et Heure :', 0, 0);
        $pdf->Cell(40, 7, $date . ' à ' . $heure, 0, 1);

        $pdf->Cell(30, 7, 'Nom du Patient :', 0, 0);
        $pdf->Cell(40, 7, $nomClient, 0, 1);

        $pdf->Cell(30, 7, 'Motif de paiement : ', 0, 0);
        $pdf->Cell(40, 7, $C->motif, 0, 1);
        $pdf->Ln(4);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(230, 230, 230);

        // Calculer la largeur des colonnes en fonction de la taille de la page
        $largeurCelluleDescription = 0.4 * $pdf->getPageWidth(); // 40% de la largeur de la page
        $pdf->SetX(40);
        $pdf->Cell(10, 7, 'N°', 1, 0, 'C', true);

        $pdf->Cell($largeurCelluleDescription, 7, 'Designation', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Montant', 1, 1, 'C', true);
        $i = 1;
        $pdf->SetFont('helvetica', '', 10);
        foreach ($CM as $row) {
            $pdf->SetX(40);
            $pdf->Cell(10, 7, $i, 1, 0, 'C', true);
            $pdf->Cell($largeurCelluleDescription, 7, $row->libelle, 1, 0, 'L');
            $pdf->Cell(40, 7, $row->montant . ' FCFA', 1, 1, 'R');
            $i++;
        }

        // Total
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', 'B', 10);

        $pdf->Cell(30, 7, 'Total à Payer ', 1, 0, 'L');
        $pdf->Cell(40, 7, $C->prix . ' FCFA', 1, 0, 'R');
        $pdf->Cell(30, 7, 'Montant versé : ', 1, 0, 'R');
        $pdf->Cell(40, 7, $C->verser . ' FCFA', 1, 0, 'R');
        $pdf->Cell(15, 7, 'Reste : ', 1, 0, 'R');
        $pdf->Cell(35, 7, $C->reste . ' FCFA', 1, 1, 'R');
        $pdf->Ln(2);
        $pdf->Cell(40, 7, 'Montant en lettre :', 1, 0, 'L');
        $pdf->Cell(0, 7, $C->lettre, 1, 1, 'L');
        $pdf->Ln(2);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(50, 10, "Patient", 0, 0, 'C');
        $pdf->Cell(100, 10, "", 0, 0, 'C');
        $pdf->Cell(50, 10, "Caisse", 0, 0, 'C');

        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output('recu.pdf', 'I');
        }, 'recu.pdf');
    }

    public function generatePDF($iduser, $idpat)
    {
        $user = User::find($iduser);
        $pat = Patient::find($idpat);
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Définir les informations du document
        $pdf->SetCreator('MEDITRACK');
        $pdf->SetAuthor('Nom de l\'auteur');
        $pdf->SetTitle('Dossier médical');
        $pdf->SetSubject('Dossier médical');
        $pdf->SetKeywords('dossier, médical');
        $pdf->AddPage();

        // Définir les couleurs
        $primaryColor = array(0, 102, 0); // Bleu
        $secondaryColor = array(255, 255, 255); // Blanc

        // Ajouter un cadre global
        $pdf->SetDrawColor($primaryColor[0], $primaryColor[1], $primaryColor[2]); // Couleur bleue pour le cadre
        $pdf->SetLineWidth(2);
        $pdf->RoundedRect(10, 10, 190, 277, 5, '1111', 'D'); // Créer un cadre autour de la page
        // Ajouter l'image
        $image_file = public_path('upload/profile/' . $user->profil); // Remplacez par le chemin de votre image
        $LOGMIN = public_path('images/LOGMIN.png'); // Remplacez par le chemin de votre image
        $LOHS = public_path('images/LOHS.png'); // Remplacez par le chemin de votre image
        $pdf->Image($LOHS, 15, 52, 20, 20, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
        $pdf->Image($LOGMIN, 175, 52, 20, 20, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);

        $hospitalName = "FONDATION MEDICAL NGOUALEM'S - CAMEROUN";
        // Ajouter le nom de l'hôpital
        $pdf->SetFont('helvetica', '', 14);
        $pdf->Cell(0, 10, 'REPUBLIQUE DU CAMEROUN', 0, 1, 'C');
        $pdf->SetFont('helvetica', 'I', 12);
        $pdf->Cell(0, 3, 'Paix - Travail - Patrie', 0, 1, 'C');
        // Ajouter un trait en pointillés en dessous du nom de l'hôpital
        $pdf->SetLineStyle(array('dash' => 3, 'phase' => 0)); // Définir le style de ligne en pointillés
        $pdf->Line(
            (210 - 30) / 2, // Coordonnée X de départ (centré sur 5 cm)
            $pdf->GetY() + 1, // Coordonnée Y de départ (5 pixels en dessous du texte)
            (210 - 30) / 2 + 30, // Coordonnée X de fin (50 mm = 5 cm)
            $pdf->GetY() + 1 // Coordonnée Y de fin (même que le départ)
        );
        $pdf->SetLineStyle(''); // Réinitialiser le style de ligne par défaut
        $pdf->SetFont('helvetica', '', 14);
        $pdf->Cell(0, 10, 'MINISTERE DE LA SANTE PUBLIQUE', 0, 1, 'C');
        // Ajouter un trait en pointillés en dessous du nom de l'hôpital
        $pdf->SetLineStyle(array('dash' => 3, 'phase' => 0)); // Définir le style de ligne en pointillés
        $pdf->Line(
            (210 - 30) / 2, // Coordonnée X de départ (centré sur 5 cm)
            $pdf->GetY(), // Coordonnée Y de départ (5 pixels en dessous du texte)
            (210 - 30) / 2 + 30, // Coordonnée X de fin (50 mm = 5 cm)
            $pdf->GetY()  // Coordonnée Y de fin (même que le départ)
        );
        $pdf->SetLineStyle(array('dash' => 3, 'phase' => 0)); // Réinitialiser le style de ligne par défaut
        $pdf->SetFont('helvetica', '', 16);
        // $pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]); // Couleur bleue pour le texte
        // Ajouter le titre
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->SetTextColor($secondaryColor[0], $secondaryColor[1], $secondaryColor[2]); // Couleur blanche pour le titre
        $pdf->SetFillColor($primaryColor[0], $primaryColor[1], $primaryColor[2]); // Couleur de fond bleue
        $pdf->Cell(0, 15, $hospitalName, 0, 1, 'C', true);

        $pdf->SetFont('helvetica', '', 16);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 1, '', 0, 1, 'C');
        $pdf->Cell(0, 1, 'B.P : 90 MBOUDA               TEL : 677-16-24-12', 0, 1, 'C');

        $pdf->SetFont('helvetica', 'Bu', 30);
        $pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
        $pdf->Cell(0, 1, '', 0, 1, 'C');
        $pdf->Cell(0, 10, 'DOSSIER MEDICAL', 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Numero : ' . $pat->code, 0, 1, 'C');

        // Définir les dimensions du cadre
        $cadre_largeur = 180;
        $cadre_hauteur = 95;

        // Définir les marges intérieures
        $marge_interieure = 5;

        // Ajouter le cadre
        $pdf->Rect(
            ($pdf->GetPageWidth() - $cadre_largeur) / 2, // Coordonnée X du coin supérieur gauche
            $pdf->GetY() + 10, // Coordonnée Y du coin supérieur gauche
            $cadre_largeur, // Largeur du cadre
            $cadre_hauteur, // Hauteur du cadre
            'D' // Style du trait (D pour double)
        );

        // Ajouter la photo du patient (35x45 mm)
        $pdf->Image(
            $image_file,
            ($pdf->GetPageWidth() - $cadre_largeur) / 2 + $marge_interieure, // Coordonnée X de la photo
            $pdf->GetY() + 10 + $marge_interieure, // Coordonnée Y de la photo
            35,
            45
        ); // Largeur et hauteur de la photo

        // Ajouter le code QR
        $qrCodeData = 'Ici les information du patient : ' . $user->nom . ' ' . $user->prenom . ' enregistré au numéro (' . $pat->code . ') dans notre centre hospitalier : ' . $hospitalName . ', https://fondationngoualem.com/' . $pat->code; // Remplacez par les données réelles que vous souhaitez encoder dans le code QR
        $qrCodeSize = 35; // Taille du code QR en millimètres
        $qrCodePosX = ($pdf->GetPageWidth() - $cadre_largeur) / 2 + $marge_interieure; // Position X du code QR
        $qrCodePosY = $pdf->GetY() + 10 + $marge_interieure + 50; // Position Y du code QR
        $pdf->write2DBarcode($qrCodeData, 'QRCODE,L', $qrCodePosX, $qrCodePosY, $qrCodeSize, $qrCodeSize);

        // Ajouter les informations du patient libelle
        $pdf->SetFont('helvetica', 'B', 14);

        $x = ($pdf->GetPageWidth() - $cadre_largeur) / 2 + $marge_interieure + 40;
        $y = $pdf->GetY() + 10 + $marge_interieure;

        $pdf->SetXY($x, $y);
        $pdf->Cell(0, 5, 'Nom : ', 0, 1, 'L');
        $y += 8;
        $pdf->SetXY($x, $y);
        $pdf->Cell(0, 5, 'Prénom : ', 0, 1, 'L');
        $y += 8;
        $pdf->SetXY($x, $y);
        $pdf->Cell(0, 5, 'Sexe : ', 0, 1, 'L');
        $y += 8;
        $pdf->SetXY($x, $y);
        $pdf->Cell(0, 5, 'Date de naissance : ', 0, 1, 'L');
        $y += 8;
        $pdf->SetXY($x, $y);
        $pdf->Cell(0, 5, 'Lieu de naissance : ', 0, 1, 'L');
        $y += 8;
        $pdf->SetXY($x, $y);
        $pdf->Cell(0, 5, 'Adresse : ', 0, 1, 'L');
        $y += 8;
        $pdf->SetXY($x, $y);
        $pdf->Cell(0, 5, 'Profession : ', 0, 1, 'L');
        $y += 8;
        $pdf->SetXY($x, $y);
        $pdf->Cell(0, 5, 'Groupe sanguin : ', 0, 1, 'L');
        $y += 8;
        $pdf->SetXY($x, $y);
        $pdf->Cell(0, 5, 'Contact urgent : ', 0, 1, 'L');

        $y += 8;
        $pdf->SetXY($x, $y);
        $pdf->Cell(0, 5, 'Nom Pere : ', 0, 1, 'L');

        $y += 8;
        $pdf->SetXY($x, $y);
        $pdf->Cell(0, 5, 'Nom Mere : ', 0, 1, 'L');

        // CADRE POUR LES ANTECEDENTS
        $cadre_largeur = 180;
        $cadre_hauteur = 70;

        // Définir les marges intérieures
        $marge_interieure = 5;

        // Ajouter le cadre
        $pdf->Rect(
            ($pdf->GetPageWidth() - $cadre_largeur) / 2, // Coordonnée X du coin supérieur gauche
            $pdf->GetY() + 10, // Coordonnée Y du coin supérieur gauche
            $cadre_largeur, // Largeur du cadre
            $cadre_hauteur, // Hauteur du cadre
            'S' // Style du trait (S pour continu)
        );

        $pdf->SetY(212);
        $pdf->SetFont('helvetica', 'BU', 16);
        $pdf->Cell(0, 8, 'ANTECEDENTS', 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->SetX(18);
        $pdf->Cell(0, 8, 'MEDICAUX : ', 0, 1, 'L');
        $pdf->SetX(18);
        $pdf->Cell(0, 8, 'CHIRURGICAUX : ', 0, 1, 'L');
        $pdf->SetX(18);
        $pdf->Cell(0, 8, 'GYNECO-OBST : ', 0, 1, 'L');
        $pdf->SetX(18);
        $pdf->Cell(0, 8, 'IMMUNOLOGIQUES : ', 0, 1, 'L');
        $pdf->SetX(18);
        $pdf->Cell(0, 8, 'ALLERGIQUES : ', 0, 1, 'L');
        $pdf->SetX(18);
        $pdf->Cell(0, 8, 'AUTRES : ', 0, 1, 'L');


        // VALEURS RECUPEREES DE LA BD
        // INFO PATIENT
        $pdf->SetFont('helvetica', '', 14);
        $x1 = 75;
        $y1 = 116;
        $pdf->SetXY($x1, $y1);
        $pdf->Cell(0, 5, $user->nom, 0, 1, 'L');
        $y1 += 8;
        $pdf->SetXY($x1 + 8, $y1);
        $pdf->Cell(0, 5, $user->prenom, 0, 1, 'L');
        $y1 += 8;
        $pdf->SetXY($x1, $y1);
        if ($user->sexe == "M") {
            $genre = "Masculin";
        } else {
            $genre = "Feminin";
        }
        $pdf->Cell(0, 5, $genre, 0, 1, 'L');
        $y1 += 8;
        $pdf->SetXY($x1 + 33, $y1);
        $pdf->Cell(0, 5, $pat->date_naissance, 0, 1, 'L');
        $y1 += 8;
        $pdf->SetXY($x1 + 33, $y1);
        $pdf->Cell(0, 5, $pat->lieu, 0, 1, 'L');
        $y1 += 8;
        $pdf->SetXY($x1 + 8, $y1);
        $pdf->Cell(0, 5, $user->adresse, 0, 1, 'L');
        $y1 += 8;
        $pdf->SetXY($x1 + 15, $y1);
        $pdf->Cell(0, 5, $pat->profession, 0, 1, 'L');
        $y1 += 8;
        $pdf->SetXY($x1 + 30, $y1);
        $pdf->Cell(0, 5, $pat->grp_san, 0, 1, 'L');
        $y1 += 8;
        $pdf->SetXY($x1 + 28, $y1);
        $pdf->Cell(0, 5, $pat->contact_urgent, 0, 1, 'L');
        $y1 += 8;
        $pdf->SetXY($x1 + 15, $y1);
        $pdf->Cell(0, 5, $pat->nom_p, 0, 1, 'L');
        $y1 += 8;
        $pdf->SetXY($x1 + 15, $y1);
        $pdf->Cell(0, 5, $pat->nom_m, 0, 1, 'L');

        $ante = Antecedant::selectRaw('
        GROUP_CONCAT(DISTINCT medi) AS medi,
        GROUP_CONCAT(DISTINCT chiru) AS chiru,
        GROUP_CONCAT(DISTINCT immu) AS immu,
        GROUP_CONCAT(DISTINCT gyneco) AS gyneco,
        GROUP_CONCAT(DISTINCT aller) AS aller,
        GROUP_CONCAT(DISTINCT autres) AS autres,
        id_pat
    ')
            ->where('id_pat', $idpat)
            ->groupBy('id_pat')
            ->first();
        if ($ante != '') {
            // INFO PATIENT - ANTECEDENTS
            $pdf->SetFont('helvetica', '', 14);
            $y2 = 220;
            $x2 = 50;
            $pdf->SetXY($x2, $y2);
            $pdf->Cell(0, 8, $ante['medi'], 0, 1, 'L');
            $y2 += 8;
            $pdf->SetXY($x2 + 10, $y2);
            $pdf->Cell(0, 8, $ante['chiru'], 0, 1, 'L');
            $y2 += 8;
            $pdf->SetXY($x2 + 10, $y2);
            $pdf->Cell(0, 8, $ante['gyneco'], 0, 1, 'L');
            $y2 += 8;
            $pdf->SetXY($x2 + 20, $y2);
            $pdf->Cell(0, 8, $ante['immu'], 0, 1, 'L');
            $y2 += 8;
            $pdf->SetXY($x2 + 10, $y2);
            $pdf->Cell(0, 8, $ante['aller'], 0, 1, 'L');
            $y2 += 8;
            $pdf->SetXY($x2 - 5, $y2);
            $pdf->Cell(0, 8, $ante['autres'], 0, 1, 'L');
        }
        // LES ELEMENTS COMPLET



        $cons = Consultation::getCons($idpat);

        if ($cons != '') {
            foreach ($cons as $value) {
                $pdf->AddPage();
                // Définir les dimensions des cadres
                $left_frame_width = 50;
                $left_frame_height = 18;
                $right_frame_width = 80;
                $right_frame_height = 10;

                // Définir la position des cadres à 10 cm de la marge
                $left_frame_x = 10; // 10 cm de la marge gauche
                $left_frame_y = 10; // 20 mm du haut de la page
                $right_frame_x = $left_frame_x + $left_frame_width + 60; // 10 mm entre les deux cadres
                $right_frame_y = $left_frame_y;

                // Créer le cadre de gauche
                $pdf->SetFillColor(220, 220, 220);
                $pdf->Rect($left_frame_x, $left_frame_y, $left_frame_width, $left_frame_height, 'F');
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetFont('helvetica', 'B', 12);
                $pdf->Text($left_frame_x, $left_frame_y, 'Taille : ' . $value->taille . 'cm');
                $pdf->Text($left_frame_x, $left_frame_y + 5, 'Poids : ' . $value->poids . 'kg');
                $pdf->Text($left_frame_x, $left_frame_y + 10, 'Temperature : ' . $value->temperature . '°c');

                // Créer le cadre de droite
                $pdf->Rect($right_frame_x, $right_frame_y, $right_frame_width, $right_frame_height, 'F');
                $pdf->SetFont('helvetica', 'BU', 14);
                $pdf->Text($right_frame_x + 15, $right_frame_y + 1, $value->cons_date);

                // Écrire du texte sur la deuxième page
                $pdf->SetFont('helvetica', 'BU', 14);
                $pdf->MultiCell(190, 10, 'SYMPTOMES', 0, 'C', false, 1, $left_frame_x, $left_frame_y + $left_frame_height + 5, true, 0, false, true, 0, 'T', false);
                $pdf->SetFont('helvetica', '', 14);
                // Ajouter un autre MultiCell à la suite
                $pdf->MultiCell(190, 10, '  ' . $value->symptome, 0, 'L', false, 1, $left_frame_x, $pdf->GetY(), true, 0, false, true, 0, 'T', false);

                $pdf->SetFont('helvetica', 'BU', 14);
                $pdf->MultiCell(190, 10, 'DIAGNOSTIQUES', 0, 'C', false, 1, $left_frame_x, $pdf->GetY() + 5, true, 0, false, true, 0, 'T', false);
                $pdf->SetFont('helvetica', '', 14);

                $pdf->MultiCell(190, 10, '   ' . $value->diagnostique, 0, 'L', false, 1, $left_frame_x, $pdf->GetY(), true, 0, false, true, 0, 'T', false);

                if ($value->exam_recom != 'ok') {
                    $pdf->SetFont('helvetica', 'BU', 14);
                    $pdf->MultiCell(190, 10, 'EXAMENS RECOMMANDES', 0, 'C', false, 1, $left_frame_x, $pdf->GetY() + 5, true, 0, false, true, 0, 'T', false);
                    $pdf->SetFont('helvetica', '', 14);
                    $pdf->MultiCell(190, 10, '   ' . $value->exam_recom, 0, 'L', false, 1, $left_frame_x, $pdf->GetY(), true, 0, false, true, 0, 'T', false);
                    $pdf->SetFont('helvetica', 'BU', 14);
                    $pdf->MultiCell(190, 10, 'RDV avec les resultat', 0, 'R', false, 1, $left_frame_x, $pdf->GetY(), true, 0, false, true, 0, 'T', false);

                    $pdf->SetFont('helvetica', 'BU', 14);
                    $pdf->MultiCell(190, 10, 'RESULTAT LABO', 0, 'C', false, 1, $left_frame_x, $pdf->GetY() + 5, true, 0, false, true, 0, 'T', false);
                    $pdf->SetFont('helvetica', '', 14);

                    $resu = ResultP::getResult($value->id_consultation);

                    $pdf->SetFillColor(225, 225, 225);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetDrawColor(0, 0, 0);
                    $pdf->SetLineWidth(0.3);
                    $pdf->SetLineStyle(array('dash' => 0, 'phase' => 0));
                    $pdf->SetFont('helvetica', 'B', 14);

                    // Table header
                    $header = array('Examen', 'Resultat');
                    $pdf->SetX(10);
                    $pdf->Cell(50, 7, $header[0], 1, 0, 'C', 1);
                    $pdf->Cell(140, 7, $header[1], 1, 0, 'C', 1);
                    $pdf->Ln();

                    $pdf->SetFont('helvetica', '', 14);
                    if ($resu != '') {
                        foreach ($resu as $rows) {
                            if ($rows->result_text !== null && $rows->result_text != 'null') {
                                $pdf->MultiCell(50, 8, $rows->exam, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
                                $pdf->MultiCell(140, 8, '  ' . $rows->result_text, 1, 'L', 0, 1, '', '', true, 0, false, true, 0);
                            } else {
                                $pdf->MultiCell(50, 54, '  ' . $rows->exam, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
                                $imageHeight = 50;
                                $pdf->Image(public_path('images/' . $rows->result_image), 68, $pdf->GetY() + 2, 0, $imageHeight, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
                                $pdf->Ln($imageHeight + 2); // Ajoute un saut de ligne en fonction de la hauteur de l'image
                            }
                        }
                        $pdf->Ln(2);
                        $pdf->SetFont('helvetica', 'BU', 14);
                        $pdf->Cell(0, 8, 'Laboratoire', 0, 1, 'R');

                        $pres = Prescrire::getPres($value->id_consultation);
                        if ($pres != '') :
                            // Table header
                            $header = array('Médicament', 'Dose', 'Prise');

                            // Set table properties
                            $pdf->SetFont('helvetica', '', 14);
                            $pdf->SetFillColor(225, 225, 225);
                            $pdf->SetTextColor(0, 0, 0);
                            $pdf->SetDrawColor(0, 0, 0);
                            $pdf->SetLineWidth(0.3);
                            $pdf->SetLineStyle(array('dash' => 0, 'phase' => 0));
                            $pdf->SetFont('helvetica', 'BU', 14);
                            $pdf->Cell(0, 8, 'PRESCRIPTION', 0, 1, 'C');
                            $pdf->Ln();
                            $pdf->SetFont('helvetica', 'B', 14);

                            // Write table header
                            // $pdf->SetX(35);
                            $pdf->Cell(60, 7, $header[0], 1, 0, 'C', 1);
                            $pdf->Cell(60, 7, $header[1], 1, 0, 'C', 1);
                            $pdf->Cell(60, 7, $header[2], 1, 0, 'C', 1);
                            $pdf->Ln();
                            $pdf->SetFont('helvetica', '', 14);
                            // Write table data


                            foreach ($pres as $row) {
                                // $pdf->SetX(35);
                                $pdf->MultiCell(60, 7, $row->medicament, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
                                $pdf->MultiCell(60, 7, $row->dose, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
                                $pdf->MultiCell(60, 7, $row->prise, 1, 'L', 0, 1, '', '', true, 0, false, true, 0);
                            }
                        endif;

                        $rdv = Rendez_vous::where('id_cons', $value->id_consultation)->first();
                        if ($rdv != '') {
                            $pdf->Ln(2);
                            $pdf->SetFont('helvetica', 'BU', 14);
                            $pdf->Cell(0, 8, 'Rendez-vous le : ' . $rdv['date_r'], 0, 1, 'R');
                        }
                    }
                } else {
                    // Table header
                    $header = array('Médicament', 'Dose', 'Prise');

                    // Set table properties
                    $pdf->SetFont('helvetica', '', 14);
                    $pdf->SetFillColor(225, 225, 225);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetDrawColor(0, 0, 0);
                    $pdf->SetLineWidth(0.3);
                    $pdf->SetLineStyle(array('dash' => 0, 'phase' => 0));
                    $pdf->SetFont('helvetica', 'BU', 14);
                    $pdf->Cell(0, 8, 'PRESCRIPTION', 0, 1, 'C');
                    $pdf->Ln();
                    $pdf->SetFont('helvetica', 'B', 14);

                    // Write table header
                    $pdf->SetX(35);
                    $pdf->Cell(45, 7, $header[0], 1, 0, 'C', 1);
                    $pdf->Cell(45, 7, $header[1], 1, 0, 'C', 1);
                    $pdf->Cell(45, 7, $header[2], 1, 0, 'C', 1);
                    $pdf->Ln();
                    $pdf->SetFont('helvetica', '', 14);
                    // Write table data

                    $pres = Prescrire::getPres($value->id_consultation);
                    foreach ($pres as $row) {
                        $pdf->SetX(35);
                        $pdf->Cell(45, 7, $row->medicament, 1, 0, 'L', 0);
                        $pdf->Cell(45, 7, $row->dose, 1, 0, 'L', 0);
                        $pdf->Cell(45, 7, $row->prise, 1, 0, 'L', 0);
                        $pdf->Ln();
                    }

                    $rdv = Rendez_vous::where('id_cons', $value->id_consultation)->first();
                    if ($rdv != '') {
                        $pdf->Ln(2);
                        $pdf->SetFont('helvetica', 'BU', 14);
                        $pdf->Cell(0, 8, 'Rendez-vous le : ' . $rdv['date_r'], 0, 1, 'R');
                    }
                    // Restore the previous line style

                }
                $pdf->Ln(2);
                $pdf->SetFont('helvetica', 'BU', 12);
                $pdf->Cell(0, 8, 'Consulté par : ', 0, 1, 'C');
                $pdf->SetFont('helvetica', 'B', 14);
                $pdf->Cell(0, 8, $value->nom . ' ' . $value->prenom, 0, 1, 'C');
            }
        }
        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output('Dossier_Medical.pdf', 'I');
        }, 'Dossier_Medical.pdf');
    }
}
