<?php

namespace App\Http\Controllers;
use TCPDF;
use App\Models\Caisse;
use App\Models\CaisseMvt;
use App\Models\Transfert;
use Illuminate\Http\Request;

class CaisseC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        return Caisse::PatPerPaye($id);
    }

    public function showc($num_caisse)
    {
        return CaisseMvt::where('num_recu', '=', $num_caisse)->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($num_caisse)
    {
        return Caisse::where('numero_recu','=',$num_caisse)->first();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        // Fonction pour récupérer le dernier numéro de matricule
        function get_last_matricule()
        {

            $rec = Caisse::getNum_R();
            // Code pour récupérer le dernier numéro de matricule depuis une base de données ou un fichier
            if ($rec == '') {
                $last_matricule = '00000';
                return $last_matricule;
            } else {
                $last_matricule = $rec->numero_recu;
                return $last_matricule;
            }
        }

        // Fonction pour générer le prochain numéro de matricule
        function generate_next_matricule($last_matricule)
        {
            // Incrémenter le numéro
            $next_matricule = $last_matricule + 1;

            // Vérifier que le numéro a 5 chiffres
            if (strlen(strval($next_matricule)) < 5) {
                $next_matricule = str_pad($next_matricule, 5, "0", STR_PAD_LEFT);
            }

            return $next_matricule;
        }
        // Récupérer le dernier numéro de matricule enregistré
        $last_matricule = get_last_matricule();

        // Générer le prochain numéro de matricule
        $next_matricule = generate_next_matricule($last_matricule);

        // Afficher le prochain numéro de matricule
        // echo "Prochain numéro de matricule : " . $next_matricule;
        // $request->validate([
        //     "motif"=>"required",
        //     "prix"=>"required",
        //     "verser"=>"required",
        //     "reste"=>"required",
        //     "lettre"=>"required",
        //     "id_pers"=>"required",
        //     "id_pat"=>"required",
        // ]);
        $data = $request->all();

        $items = $data['items'];
        $motif = $data['taskName'];
        $prix = $data['prix'];
        $verser = $data['verser'];
        $reste = $data['reste'];
        $lettre = $data['lettre'];
        $id_pers = $data['id_pers'];
        $id_pat = $data['id_pat'];
        $id_transfert = $data['id_transfert'];

        // Enregistrer les examens
        foreach ($items as $item) {
            $caisseM = new CaisseMvt();
            $caisseM->libelle = $item['libelle'];
            $caisseM->montant = $item['montant'];
            $caisseM->num_recu = $next_matricule;
            $caisseM->save();
        }



        $caisse = new Caisse();
        $caisse->motif = $motif;
        $caisse->prix = $prix;
        $caisse->verser = $verser;
        $caisse->reste = $reste;
        $caisse->lettre = $lettre;
        if ($reste == '0') {
            $caisse->etat_caisse = 'Payé';
        } else {
            $caisse->etat_caisse = 'Manque';
        }
        $caisse->numero_recu = $next_matricule;
        $caisse->id_pers = $id_pers;
        $caisse->id_pat = $id_pat;
        $caisse->save();

        $trans = Transfert::find($id_transfert);
        if ($reste == '0') {
            $trans->etat_caisse = '1';
        } else {
            $trans->etat_caisse = '2';
        }
        $trans->num_caisse = $next_matricule;
        $trans->save();
        $respo = [
            'caisse' => $caisse,
            'caisseM' => $caisseM,
            'trans' => $trans,
        ];
        $NU= $next_matricule;
        $C = Caisse::PatPerPayeUn($NU);
        $CM = CaisseMvt::where('num_recu', '=', $NU)->get();
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
        $pdf->Cell(0, 8, 'Reçu de Caisse N° : ' . $NU, 1, 1, 'C');

        // Informations du paiement (exemple)
        $date = date('d-m-Y');
        $heure = date('H:i:s');
        $nomClient = $C->nom . ' ' . $C->prenom;
        $receipt_number = '987654321';

        $qrCodeData =
        'Reçu #' . $NU . PHP_EOL
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
        $pdf->Cell(40, 7,
            $date . ' à ' . $heure,
            0,
            1
        );

        $pdf->Cell(30, 7, 'Nom du Patient :', 0, 0);
        $pdf->Cell(40, 7, $nomClient, 0, 1);

        $pdf->Cell(30, 7, 'Motif de paiement : ', 0, 0);
        $pdf->Cell(40, 7, $C->motif, 0, 1);
        $pdf->Ln(4);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(230,
            230,
            230
        );

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
        $pdf->SetFont('helvetica', 'B',
            10
        );

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
        $pdf->Cell(100, 10,
            "",
            0,
            0,
            'C'
        );
        $pdf->Cell(50, 10, "Caisse", 0, 0, 'C');

        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output('recu.pdf', 'I');
        }, 'recu.pdf');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Caisse::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data = $request->all();

        $verser = $data['verser'];
        $reste = $data['reste'];
        $lettre = $data['lettre'];
        $id_transfert = $data['id_transfert'];

        $caisse = Caisse::find($id);
        $caisse->verser = $verser;
        $caisse->reste = $reste;
        $caisse->lettre = $lettre;
        if ($reste == '0') {
            $caisse->etat_caisse = 'Payé';
        } else {
            $caisse->etat_caisse = 'Manque';
        }
        $caisse->save();

        $trans = Transfert::find($id_transfert);
        if ($reste == '0') {
            $trans->etat_caisse = '1';
        } else {
            $trans->etat_caisse = '2';
        }
        $trans->save();
        $respo = [
            'caisse' => $caisse,
            'trans' => $trans,
        ];
        return ($respo);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Caisse::destroy($id);
    }
}
