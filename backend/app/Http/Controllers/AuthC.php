<?php

namespace App\Http\Controllers;
use App\Models\Type_user;
use App\Models\Appartenir;
use App\Models\Personnel;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use Mockery\Matcher\Type;
use Illuminate\Support\Str;
class AuthC extends Controller
{
    public function renewpass(Request $request, $id_user)
    {

        $user = User::where('id',$id_user)->first();
        $fields= $request->validate([
            "a_pass"=>"required|string",
            "n_pass"=>"required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/",
            "c_pass"=>"required|same:n_pass",

        ]);
        if(!Hash::check($fields['a_pass'], $user->password)){
            $response = [
                'messa'=>"entrez un mot de passe valide !",
            ];

            return response($response, 401) ;
        }
        if($fields['c_pass'] != $fields['n_pass']){
            $response = [
                'messa'=>"Le mot de passe de confirmation est different !",
            ];

            return response($response, 401) ;
        }

        $user->password = Hash::make($request->n_pass);
        $user->save();

        $response = [
            'user'=>$user,
        ];

        return response($response,201);
    }
    public function user($id_user)
    {
        $user = User::where('id',$id_user)->first();
        $type_user = Type_user::find($user->id_type_user);
        $response = [
            'user'=>$user,
            'type_user'=>$type_user,
        ];

        return response($response,201);
    }
    public function updateuser(Request $request, string $id)
    {
        $fields= $request->validate([
            "nom"=>"required|string",
            "prenom"=>"required|string",
            "telephone"=>"required",
            "sexe"=>"required",
            "adresse"=>"required|string",
            "sit_mat"=>"required",
        ]);

        $user = User::find($id);
        $user->nom=$fields['nom'];
        $user->prenom=$fields['prenom'];
        $user->telephone=$fields['telephone'];
        $user->adresse=$fields['adresse'];
        $user->sit_mat=$fields['sit_mat'];
        $user->sexe =$fields['sexe'];
        if(isset($request->supp)){
            $user->profil='imgp.jpg';
        }

        if($request->travail=='Patient'){
            $patient = Patient::where('id_user',$id)->first();
            if(!empty($request->file('image'))){
                if(!empty($user->getProfile()))
                {
                    unlink('upload/profile/'.$user->profil);
                }
                $ext= $request->file('image')->getClientOriginalExtension();
                $file = $request->file('image');
                $filename = $patient->code.'.'.$ext;
                $file->move('upload/profile/',$filename);
                $user->profil = $filename;
            }
        }else{
            $personnel = Personnel::where('id_user',$id)->first();
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
        }


        $user->email = $request->email;
        $user->save();
        $response = [
            'user'=>$user,
        ];
        return($response);
    }
    public function login(Request $request)
    {
        $fields = $request->validate([
            "email"=>"required|string",
            "password"=>"required|string",
        ]);

        $user = User::where('email',$fields['email'])->first();

        if(!$user){
            $response = [
                'message'=>"entrez un email valide !",
            ];

            return response($response, 401) ;
        }
        if(!$user || !Hash::check($fields['password'], $user->password)){
            $response = [
                'messa'=>"entrez un mot de passe valide !",
            ];

            return response($response, 401) ;
        }
        $type_user = Type_user::find($user->id_type_user);
        $personnel = Personnel::where('id_user',$user->id)->first();
        $appartenir='';
        $patient='';
        if($personnel !=''){
            $appartenir = Appartenir::getser($personnel->id);
        }else{
            $patient = Patient::where('id_user',$user->id)->first();
        }
        $token = $user->createToken('nouveau_token')->plainTextToken;
        $response = [
            'appartenir'=>$appartenir,
            'personnel'=>$personnel,
            'patient'=>$patient,
            'user'=>$user,
            'type_user'=>$type_user,
            'token'=>$token,
        ];

        return response($response,201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        $response = [
            'message'=>"vous etes desormais deconnecte !",
        ];

        return $response;
    }

    public function PostForgotPassword(Request $request)
    {
        $request->validate([
            "email"=>"required|string",
        ]);
        $user = User::getEmailSingle($request->email);
        if(!empty($user)){
            $user->remember_token = Str::random(30);
            $user->save();
            Mail::to($user->email)->send(new ForgotPasswordMail($user));
            $response = [
                'message'=>"reussi !",
            ];

            return response($response,201);
        }else{
            $response = [
                'message'=>"Adresse email non existant !",
            ];

            return response($response,401);
        }
    }

    public function reset($remember_token)
    {
        $user = User::getTokenSingle($remember_token);
        if(!empty($user)){
            $response = [
                'valid' => true,
                'user' => $user
            ];
            return response($response, 201);
        }else{
            $response = [
                'valid' => false,
                'message' => 'Token not found'
            ];
            return response($response, 401);
        }

    }

    public function PostReset(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
            'cpassword' => 'required|same:password',
        ], [
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
            'cpassword.same' => 'Le mot de passe et la confirmation du mot de passe doivent correspondre.',
        ]);
        if($request->password == $request->cpassword)
        {
            $user = User::getTokenSingle($request->token);
            if(!empty($user)){
                $user->password = Hash::make($request->password);
                $user->remember_token=Str::random(30);
                $user->save();

                return response($user, 201);
            }else{
                $response = [
                    'valid' => false,
                    'message' => 'Le token a expiré veuillez reprendre la procedure'
                ];
                return response($response);
            }

        }
        else
        {
            $response = [
                'valid' => false,
                'message' => 'Le mot de passe et la confirmation du mot de passe sont differents'
            ];
            return response($response);
        }
    }
}
