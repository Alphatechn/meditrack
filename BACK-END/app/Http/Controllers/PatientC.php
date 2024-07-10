<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Mail\SendMail;
use App\Models\Antecedant;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Prive;

class PatientC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Patient::getAllPatient();
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
        $fields = $request->validate([
            "nom" => "required|string",
            "prenom" => "required|string",
            "telephone" => "required",
            "sexe" => "required",
            "adresse" => "required|string",
            "date_naissance" => "required",
            "lieu" => "required",
            "contact_urgent" => "required",
            "sit_mat" => "required",
        ]);

        $rec = Patient::getCode();
        if ($rec == '') {
            $newcode = date('y') . '-PAT-101';
        } else {
            $nombre = substr($rec->code, 0, 2);
            if ($nombre != date('y')) {
                $newcode = date('y') . '-PAT-101';
            } else {
                $nbre = strlen($rec->code) - 3;
                $lastnumber = intval(substr($rec->code, $nbre));
                $newnumber = $lastnumber + 1;
                $numberformatte = str_pad($newnumber, 3, '0', STR_PAD_LEFT);
                $newcode = date('y') . '-PAT-' . $numberformatte;
            }
        }

        $user = new User();
        $user->nom = $fields['nom'];
        $user->prenom = $fields['prenom'];
        $user->telephone = $fields['telephone'];
        $user->adresse = $fields['adresse'];
        $user->id_type_user = 6;
        $user->sit_mat = $fields['sit_mat'];
        $user->sexe = $fields['sexe'];
        if (!empty($request->file('image'))) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $file = $request->file('image');
            $filename = $newcode . '.' . $ext;
            $file->move('upload/profile/', $filename);
            $user->profil = $filename;
        }

        function genererMotDePasse()
        {
            $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
            $motDePasse = '';
            $longueur = 8;

            // Générer un mot de passe aléatoire
            for ($i = 0; $i < $longueur; $i++) {
                $motDePasse .= $caracteres[rand(0, strlen($caracteres) - 1)];
            }

            // S'assurer que le mot de passe contient au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial
            while (!preg_match('/[a-z]/', $motDePasse) || !preg_match('/[A-Z]/', $motDePasse) || !preg_match('/[0-9]/', $motDePasse) || !preg_match('/[^a-zA-Z0-9]/', $motDePasse)) {
                $motDePasse = '';
                for ($i = 0; $i < $longueur; $i++) {
                    $motDePasse .= $caracteres[rand(0, strlen($caracteres) - 1)];
                }
            }

            // Mélanger les caractères du mot de passe
            $motDePasseMelange = str_shuffle($motDePasse);

            return $motDePasseMelange;
        }

        $motDePasse = genererMotDePasse();
        // echo $motDePasse;

        $user->password = bcrypt($motDePasse);
        $password = [
            'title' => 'Mail en provenance de MediTrack',
            'body' => 'bienvenue votre mot de passe de connexion est :' . $motDePasse,
        ];
        if (!empty($request->email)) {
            $request->validate([
                "email" => "required|string|unique:users,email",
            ]);
            $user->email = $request->email;
            Mail::to($request->email)->send(new SendEmail($password));
        }
        $user->save();
        $patient = new Patient();
        $patient->code = $newcode;
        $patient->date_naissance = $fields['date_naissance'];
        $patient->lieu = $fields['lieu'];
        $patient->contact_urgent = $fields['contact_urgent'];
        $patient->id_user = $user->id;
        $patient->profession = $request->profession;
        $patient->grp_san = $request->grp_san;
        $patient->nom_p = $request->nom_pere;
        $patient->nom_m = $request->nom_mere;
        $patient->save();

        $antecedants = new Antecedant();
        $antecedants->medi = $request->a_medi;
        $antecedants->chiru = $request->a_chiru;
        $antecedants->gyneco = $request->a_gyneco;
        $antecedants->immu = $request->a_immu;
        $antecedants->aller = $request->a_aller;
        $antecedants->autres = $request->a_autres;
        $antecedants->id_pat = $patient->id;
        $antecedants->save();

        $prive = new Prive();
        $prive->id_user = $user->id;
        $prive->pass = $motDePasse;
        $prive->save();
        $response = [
            'user' => $user,
            'patient' => $patient,
            'prive' => $prive,
        ];
        return ($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    public function ante(string $id)
    {
        $ante = Antecedant::selectRaw('
        GROUP_CONCAT(DISTINCT medi) AS medi,
        GROUP_CONCAT(DISTINCT chiru) AS chiru,
        GROUP_CONCAT(DISTINCT immu) AS immu,
        GROUP_CONCAT(DISTINCT gyneco) AS gyneco,
        GROUP_CONCAT(DISTINCT aller) AS aller,
        GROUP_CONCAT(DISTINCT autres) AS autres,
        id_pat
    ')
            ->where('id_pat', $id)
            ->groupBy('id_pat')
            ->first();
            return ($ante);
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
        $fields = $request->validate([
            "nom" => "required|string",
            "prenom" => "required|string",
            "telephone" => "required",
            "sexe" => "required",
            "adresse" => "required|string",
            "date_naissance" => "required",
            "lieu" => "required",
            "contact_urgent" => "required",
            "sit_mat" => "required",
        ]);

        $patient = Patient::find($id);
        $patient->date_naissance = $fields['date_naissance'];
        $patient->lieu = $fields['lieu'];
        $patient->contact_urgent = $fields['contact_urgent'];
        $patient->profession = $request->profession;
        $patient->grp_san = $request->grp_san;
        $patient->nom_m = $request->nom_m;
        $patient->nom_p = $request->nom_p;
        $patient->save();

        $user = User::find($patient->id_user);
        $user->nom = $fields['nom'];
        $user->prenom = $fields['prenom'];
        $user->telephone = $fields['telephone'];
        $user->adresse = $fields['adresse'];
        $user->sit_mat = $fields['sit_mat'];
        $user->sexe = $fields['sexe'];
        if (!empty($request->file('image'))) {
            if (!empty($user->getProfile())) {
                unlink('upload/profile/' . $user->profil);
            }
            $ext = $request->file('image')->getClientOriginalExtension();
            $file = $request->file('image');
            $filename = $patient->code . '.' . $ext;
            $file->move('upload/profile/', $filename);
            $user->profil = $filename;
        }

        $user->email = $request->email;
        $user->save();
        $response = [
            'user' => $user,
            'patient' => $patient,
        ];
        return ($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Patient::find($id);
        $patient->is_delete = 1;
        $patient->save();
        return ($patient);
    }
}
