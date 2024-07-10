<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\Prive;
use App\Models\Appartenir;
use Illuminate\Support\Str;
use App\Models\User;
class PersonnelC extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Personnel::getAllPersonnel();
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
        $fields= $request->validate([
            "nom"=>"required|string",
            "prenom"=>"required|string",
            "telephone"=>"required",
            "sexe"=>"required",
            "adresse"=>"required|string",
            "type_user"=>"required",
            "date_embauche"=>"required",
            "sit_mat"=>"required",
            "email"=>"required|string|unique:users,email",
        ]);

        $rec=Personnel::getMatricule();
            if($rec==''){
                $newmatricule=date('y').'-FMN-101';
            }else{
               $nombre=substr($rec->matricule,0,2);
                if($nombre!=date('y')){
                    $newmatricule=date('y').'-FMN-101';
                }else{
                    $nbre=strlen($rec->matricule)-3;
                    $lastnumber = intval(substr($rec->matricule,$nbre));
                    $newnumber= $lastnumber + 1;
                    $numberformatte= str_pad($newnumber,3,'0',STR_PAD_LEFT);
                    $newmatricule=date('y').'-FMN-'.$numberformatte;
                }
            }

        $user = new User();
        $user->nom=$fields['nom'];
        $user->prenom=$fields['prenom'];
        $user->telephone=$fields['telephone'];
        $user->adresse=$fields['adresse'];
        $user->id_type_user=$fields['type_user'];
        $user->sit_mat=$fields['sit_mat'];
        $user->email =$fields['email'];
        $user->sexe =$fields['sexe'];
        if(!empty($request->file('image'))){
            $ext= $request->file('image')->getClientOriginalExtension();
            $file = $request->file('image');
            $filename = $newmatricule.'.'.$ext;
            $file->move('upload/profile/',$filename);
            $user->profil = $filename;
        }

        function genererMotDePasse() {
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
        $password=[
            'title' => 'Mail en provenance de MediTrack',
            'body' => 'bienvenue votre mot de passe de connexion est :'.$motDePasse,
        ];
        $user->save();
        Mail::to($fields['email'])->send(new SendEmail($password));
        $personnel = new Personnel();
        $personnel->matricule=$newmatricule;
        $personnel->date_embauche=$fields['date_embauche'];
        $personnel->id_user=$user->id;
        $personnel->save();

        $appartenir = new Appartenir();
        $appartenir->id_ser=$request->service;
        $appartenir->id_per=$personnel->id;
        $appartenir->save();

        $prive=new Prive();
        $prive->id_user=$user->id;
        $prive->pass=$motDePasse;
        $prive->save();
        $response = [
            'user'=>$user,
            'personnel'=>$personnel,
            'appartenir'=>$appartenir,
            'prive'=>$prive,
        ];
        return($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $fields= $request->validate([
            "nom"=>"required|string",
            "prenom"=>"required|string",
            "telephone"=>"required",
            "adresse"=>"required|string",
            "type_user"=>"required",
            "date_embauche"=>"required",
            "sit_mat"=>"required",
            "sexe"=>"required",
        ]);


        $personnel =Personnel::find($id);
        $personnel->date_embauche=$fields['date_embauche'];
        $personnel->save();

        $user = User::find($personnel->id_user);
        $user->nom=$fields['nom'];
        $user->prenom=$fields['prenom'];
        $user->telephone=$fields['telephone'];
        $user->adresse=$fields['adresse'];
        $user->id_type_user=$fields['type_user'];
        $user->sit_mat=$fields['sit_mat'];
        $user->sexe=$fields['sexe'];
        $user->email = $request->email;
        if(!empty($request->file('image'))){
            if(!empty($user->getProfile()))
            {
                unlink('upload/profile/'.$user->profil);
            }
            $ext= $request->file('image')->getClientOriginalExtension();
            $file = $request->file('image');
            $filename = $personnel->matricule.'.'.$ext;
            $file->move('upload/profile/',$filename);
            $user->profil = $filename;
        }
        $user->save();
        // Mail::to('alphredtatong@gmail.com')->send(new SendEmail($password));
        $response = [
            'user'=>$user,
            'personnel'=>$personnel,
        ];
        return($response);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $personnel = Personnel::find($id);
        $personnel->is_delete=1;
        $personnel->save();
        return($personnel);
    }
}
