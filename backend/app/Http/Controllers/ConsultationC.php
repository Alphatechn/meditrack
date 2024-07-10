<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use App\Models\Transfert;
use App\Models\Prescrire;
use App\Models\Rendez_vous;
use Illuminate\Support\Facades\Mail;
use App\Mail\RdvMail;
use App\Models\Patient;
use App\Models\Personnel;
use App\Models\User;

class ConsultationC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showmed(string $id)
    {
        return Consultation::getMed($id);
    }

    public function index(string $id)
    {
        return Consultation::getAllPatient($id);
    }

    public function indexlabo(string $id)
    {
        return Consultation::getAllPatientLabo($id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            "temperature"=>"required",
            "poids"=>"required",
            "taille"=>"required",
            "type_cons"=>"required",
            "symptome"=>"required",
            // "examr"=>"required",
          //  "status"=>"required",
            "id_pat"=>"required",
            "id_pers"=>"required",
        ]);



        $consultation = new Consultation();

        if(!empty($request->examr)){
            // insertion avec prise en compte des examens recommandes
            $consultation->temperature=$request->temperature;
            $consultation->poids=$request->poids;
            $consultation->taille=$request->taille;
            $consultation->type_cons=$request->type_cons;
            $cont='Mouvement:'.$request->mouvement.'/n';
            $cont+='Oedemes:'.$request->oedemes.'/n';
            $cont+='P:'.$request->p.'/n';
            $cont+='OBST:'.$request->obst.'/n';
            $cont+='Bassin:'.$request->bassin.'/n';
            $cont+='DDR:'.$request->ddr.'/n';
            $cont+='DPA:'.$request->dpa.'/n';
            $cont+='Albumine:'.$request->albumine.'/n';
            $cont+='Sucre:'.$request->sucre.'/n';
            $cont+='TA:'.$request->ta.'/n';
            $cont+='GS:'.$request->gs.'/n';
            $cont+='Rhesus:'.$request->rhesus.'/n';
            $consultation->symptome=$request->$cont;
            $consultation->diagnostique=$request->diagnostique;
            $consultation->exam_recom=$request->examr;
            $consultation->id_pers=$request->id_pers;
            $consultation->id_pat=$request->id_pat;
            $consultation->save();
            // modification dans la table transfert
            $trans = Transfert::find($request->id_transfert);
            $trans->etat_transf='Reçu';
            $trans->date_recu=date("Y-m-d");
            $trans->id_pers_r=$request->id_pers;
            $trans->save();
            // Transfert a la Maternité  pour examen
            $transfert = new Transfert();
            $transfert->id_pat=$request->id_pat;
            $transfert->id_ser='4';
            $transfert->id_pers=$request->id_pers;
            $transfert->etat_transf='Envoyé';
            $transfert->motif=$request->examr;
            $transfert->date_envoi=date("Y-m-d");
            $transfert->save();
        }else{
            // insertion sans prise en compte des examens recommandes
            $consultation->temperature=$request->temperature;
            $consultation->poids=$request->poids;
            $consultation->taille=$request->taille;
            $consultation->type_cons=$request->type_cons;
            $cont = 'Mouvement:' . $request->mouvement . ' | ';
            $cont .= 'Oedemes:' . $request->oedemes . ' | ';
            $cont .= 'P:' . $request->p . ' | ';
            $cont .= 'OBST:' . $request->obst . ' | ';
            $cont .= 'Bassin:' . $request->bassin . ' | ';
            $cont .= 'DDR:' . $request->ddr . ' | ';
            $cont .= 'DPA:' . $request->dpa . ' | ';
            $cont .= 'Albumine:' . $request->albumine . ' | ';
            $cont .= 'Sucre:' . $request->sucre . ' | ';
            $cont .= 'TA:' . $request->ta . ' | ';
            $cont .= 'GS:' . $request->gs . ' | ';
            $cont .= 'Rhesus:' . $request->rhesus . ' | ';
            $consultation->symptome=$request->symptome.' '.$cont;
            $consultation->diagnostique=$request->diagnostique;
            $consultation->exam_recom="ok";
            $consultation->id_pers=$request->id_pers;
            $consultation->id_pat=$request->id_pat;
            $consultation->save();
                // modification dans la table transfert
            $trans = Transfert::find($request->id_transfert);
            $trans->etat_transf='Reçu';
            $trans->date_recu=date("Y-m-d");
            $trans->id_pers_r=$request->id_pers;
            $trans->save();
            // // prescriptions

            // // Récupération des données de la partie "items"
            // $itemsData = $request->input('items');

            // // Conversion des données JSON en tableau d'objets PHP
            // $items = json_decode($itemsData, true);
            // foreach ($items as $item) {


            //     $prescrire = new Prescrire();
            //     $prescrire->dose=$item['dose'];
            //     $prescrire->prise=$item['prise'];
            //     $prescrire->medicament=$item['libelle'];
            //     $prescrire->id_consul=$consultation->id;
            //     $prescrire->id_pat=$request->id_pat;
            //     $prescrire->id_pers=$request->id_pers;
            //     $prescrire->save();
            // }

        }

        return($consultation);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
                "temperature"=>"required",
                "poids"=>"required",
                "taille"=>"required",
                "type_cons"=>"required",
                "symptome"=>"required",
                // "examr"=>"required",
              //  "status"=>"required",
                "id_pat"=>"required",
                "id_pers"=>"required",
            ]);



            $consultation = new Consultation();

            if(!empty($request->examr)){
                $consultation->temperature=$request->temperature;
                $consultation->poids=$request->poids;
                $consultation->taille=$request->taille;
                $consultation->type_cons=$request->type_cons;
                $consultation->symptome=$request->symptome;
                $consultation->diagnostique=$request->diagnostique;
                $consultation->exam_recom=$request->examr;
                $consultation->id_pers=$request->id_pers;
                $consultation->id_pat=$request->id_pat;
                $consultation->save();

                $trans = Transfert::find($request->id_transfert);
                $trans->etat_transf='Reçu';
                $trans->date_recu=date("Y-m-d");
                $trans->id_pers_r=$request->id_pers;
                $trans->save();

                $transfert = new Transfert();
                $transfert->id_pat=$request->id_pat;
                $transfert->id_ser='4';
                $transfert->id_pers=$request->id_pers;
                $transfert->etat_transf='Envoyé';
                $transfert->motif=$request->examr;
                $transfert->id_cons=$consultation->id;
                $transfert->date_envoi=date("Y-m-d");
                $transfert->save();
            }else{

                $consultation->temperature=$request->temperature;
                $consultation->poids=$request->poids;
                $consultation->taille=$request->taille;
                $consultation->type_cons=$request->type_cons;
                $consultation->symptome=$request->symptome;
                $consultation->diagnostique=$request->diagnostique;
                $consultation->exam_recom="ok";
                $consultation->id_pers=$request->id_pers;
                $consultation->id_pat=$request->id_pat;
                $consultation->save();

                $trans = Transfert::find($request->id_transfert);
                $trans->etat_transf='Reçu';
                $trans->date_recu=date("Y-m-d");
                $trans->id_pers_r=$request->id_pers;
                $trans->save();
                // Récupération des données de la partie "items"
                $itemsData = $request->input('items');

                // Conversion des données JSON en tableau d'objets PHP
                $items = json_decode($itemsData, true);
                foreach ($items as $item) {


                    $prescrire = new Prescrire();
                    $prescrire->dose=$item['dose'];
                    $prescrire->prise=$item['prise'];
                    $prescrire->medicament=$item['libelle'];
                    $prescrire->id_consul=$consultation->id;
                    $prescrire->id_pat=$request->id_pat;
                    $prescrire->id_pers=$request->id_pers;
                    $prescrire->save();
                }

            }

        return($consultation);



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Consultation::getUnPatient($id);
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
    public function update(Request $request)
    {
        $request->validate([
            "temperature"=>"required",
            "poids"=>"required",
            "taille"=>"required",
            "type_cons"=>"required",
            "symptome"=>"required",
            // "examr"=>"required",
          //  "status"=>"required",
            "id_pat"=>"required",
            "id_pers"=>"required",
        ]);



        $consultation =Consultation::find($request->id_consultation);

        if($request->examr != 'ok'){
            $consultation->temperature=$request->temperature;
            $consultation->poids=$request->poids;
            $consultation->taille=$request->taille;
            $consultation->type_cons=$request->type_cons;
            $consultation->symptome=$request->symptome;
            $consultation->diagnostique=$request->diagnostique;
            $consultation->exam_recom=$request->examr;
            $consultation->save();

            $transa = Transfert::where('id_cons',$request->id_consultation)->first();
            $trans = Transfert::find($transa->id);
            $trans->motif=$request->examr;
            $trans->save();
        }else{

            $consultation->temperature=$request->temperature;
            $consultation->poids=$request->poids;
            $consultation->taille=$request->taille;
            $consultation->type_cons=$request->type_cons;
            $consultation->symptome=$request->symptome;
            $consultation->diagnostique=$request->diagnostique;
            $consultation->exam_recom="ok";
            $consultation->save();

            // Récupération des données de la partie "items"
            $itemsData = $request->input('items');

            // Conversion des données JSON en tableau d'objets PHP
            $items = json_decode($itemsData, true);
            foreach ($items as $item) {


                $prescrire = new Prescrire();
                $prescrire->dose=$item['dose'];
                $prescrire->prise=$item['prise'];
                $prescrire->medicament=$item['libelle'];
                $prescrire->id_consul=$request->id_consultation;
                $prescrire->id_pat=$request->id_pat;
                $prescrire->id_pers=$request->id_pers;
                $prescrire->save();
            }

            $itemsMData = $request->input('itemsM');

            // Conversion des données JSON en tableau d'objets PHP
            $itemsM = json_decode($itemsMData, true);
            foreach ($itemsM as $itemM) {


                $prescrireM = Prescrire::find($itemM['id']);
                $prescrireM->dose=$itemM['dose'];
                $prescrireM->prise=$itemM['prise'];
                $prescrireM->save();
            }

        }

        return($consultation);


    }

    public function prescrire(Request $request)
    {
        if(!empty($request->notes_r)){
            $pat = Patient::where('id',$request->id_pat)->first();
            $per = Personnel::where('id',$request->id_pers)->first();
            $usersp = User::where('id',$pat['id_user'])->first();
            $usersper = User::where('id',$per['id_user'])->first();
            $rdv = new Rendez_vous();
            $rdv->notes = $request->notes_r;
            $rdv->date_r = $request->date_r;
            $rdv->motif_r = 'Suivi';
            $rdv->status = 'Confirmé';
            $rdv->id_cons=$request->id_consultation;
            $rdv->id_pat=$request->id_pat;
            $rdv->id_pers=$request->id_pers;
            $rdv->save();
            $password=[
                'title' => 'Mail en provenance de MediTrack (Rendez-vous)',
                'date' => $request->date_r,
                'nomspers' => $usersper['nom'].' '.$usersper['prenom'],
                'noms' => $usersp['nom'].' '.$usersp['prenom'],
                'body' => 'Je vous confirme le rendez-vous médical que nous avons programmé ensemble ',
                'motif' => 'suivi de votre traitement',
            ];
            Mail::to($usersp['email'])->send(new RdvMail($password));
        }


            // Récupération des données de la partie "items"
            $itemsData = $request->input('items');

            // Conversion des données JSON en tableau d'objets PHP
            $items = json_decode($itemsData, true);
            foreach ($items as $item) {


                $prescrire = new Prescrire();
                $prescrire->dose=$item['dose'];
                $prescrire->prise=$item['prise'];
                $prescrire->medicament=$item['libelle'];
                $prescrire->id_consul=$request->id_consultation;
                $prescrire->id_pat=$request->id_pat;
                $prescrire->id_pers=$request->id_pers;
                $prescrire->save();
            }

            $itemsMData = $request->input('itemsM');

            // Conversion des données JSON en tableau d'objets PHP
            $itemsM = json_decode($itemsMData, true);
            foreach ($itemsM as $itemM) {


                $prescrireM = Prescrire::find($itemM['id']);
                $prescrireM->dose=$itemM['dose'];
                $prescrireM->prise=$itemM['prise'];
                $prescrireM->save();
            }


        return($rdv);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Consultation::destroy($id);
    }
}
