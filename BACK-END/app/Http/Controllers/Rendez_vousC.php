<?php

namespace App\Http\Controllers;

use App\Models\Rendez_vous;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use App\Models\Personnel;
use Illuminate\Support\Facades\Mail;
use App\Mail\RdvMail;

class Rendez_vousC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idpers)
    {
        return Rendez_vous::getRDVen($idpers);
    }

    public function indexpat($idpat)
    {
        return Rendez_vous::getRDVenpat($idpat);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "medecin_r" => "required",
            "idpat" => "required",
            "motif_r" => "required",
            "date_r" => "required",
        ]);
        $rdv = New Rendez_vous();
        $rdv->date_r = $request->date_r;
        $rdv->notes = $request->note_r;
        $rdv->motif_r = $request->motif_r;
        $rdv->status = 'Demandé';
        $rdv->id_pat = $request->idpat;
        $rdv->id_pers = $request->medecin_r;
        $rdv->save();

        return($rdv);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Rendez_vous::getRDVunique($id);
    }

    public function showall(string $id)
    {
        return Rendez_vous::getRDVenall($id);
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
        $pat = Patient::where('id', $request->id_pat)->first();
        $per = Personnel::where('id', $request->id_pers)->first();
        $usersp = User::where('id', $pat['id_user'])->first();
        $usersper = User::where('id', $per['id_user'])->first();
        $rdv = Rendez_vous::find($id);
        $rdv->date_r = $request->date;
        $rdv->status = $request->status;
        $rdv->time_r = $request->time;
        $rdv->id_pat = $request->id_pat;
        $rdv->id_pers = $request->id_pers;
        $rdv->save();
        if ($request->status == "Confirmé") {
            $password = [
                'title' => 'Mail en provenance de MediTrack (Rendez-vous)',
                'date' => $request->date,
                'nomspers' => $usersper['nom'] . ' ' . $usersper['prenom'],
                'noms' => $usersp['nom'] . ' ' . $usersp['prenom'],
                'body' => 'Je vous confirme le rendez-vous médical que nous avons programmé ensemble à '. $request->time,
                'motif' => 'suivi de votre traitement',
            ];
            Mail::to($usersp['email'])->send(new RdvMail($password));
        }
        if ($request->status == "Annulé") {
            $password = [
                'title' => 'Mail en provenance de MediTrack (Rendez-vous)',
                'date' => $request->date,
                'nomspers' => $usersper['nom'] . ' ' . $usersper['prenom'],
                'noms' => $usersp['nom'] . ' ' . $usersp['prenom'],
                'body' => 'Votre rendez-vous a été annulé',
                'motif' => 'Pas de disponibilite',
            ];
            Mail::to($usersp['email'])->send(new RdvMail($password));
        }
        if ($request->status == "Reporté") {
            $password = [
                'title' => 'Mail en provenance de MediTrack (Rendez-vous)',
                'date' => $request->date,
                'nomspers' => $usersper['nom'] . ' ' . $usersper['prenom'],
                'noms' => $usersp['nom'] . ' ' . $usersp['prenom'],
                'body' => 'Votre rendez-vous à été reporté au '. $request->date.' à ' . $request->time,
                'motif' => 'suivi de votre traitement',
            ];
            Mail::to($usersp['email'])->send(new RdvMail($password));
        }

        return($rdv);
    }

    public function updatep(Request $request, string $id)
    {
        $rdv = Rendez_vous::find($id);
        $rdv->date_r = $request->date;
        $rdv->status = $request->status;
        $rdv->id_pat = $request->id_pat;
        $rdv->id_pers = $request->id_pers;
        $rdv->save();
        return ($rdv);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
