<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Caisse extends Model
{
    use HasFactory;
    protected $table = 'caisse';
    protected $fillable =[
        'motif',
        'prix',
        'lettre',
        'etat_caisse',
        'numero_recu',
        'id_pers',
        'id_pat',
    ];

    static public function getNum_R()
    {
        return self::orderBy('numero_recu','desc')->first();
    }


    static public function getAllPatpaye()
    {
        return self::select('caisse.*','personnel.*','patient.*')
        ->join('patient','patient.id','caisse.id_pat')
        ->join('personnel','personnel.id','caisse.id_pers')
        ->where('caisse.etat_caisse','=','Payé')
        ->get();
    }

    static public function PatPerPaye($idpers)
    {
        $serviceId = DB::table('appartenir')
            ->where('id_per', '=', $idpers)
            ->where('status', '=', 0)
            ->value('id_ser');
        $query = self::select('caisse.*', 'users.*', 'patient.*', 'caisse.id as id_caisse','caisse.created_at as date_c')
            ->join('patient', 'patient.id', 'caisse.id_pat')
            ->join('users', 'users.id', 'patient.id_user')
            ->where('caisse.etat_caisse', '=', 'Payé');
        if ($serviceId != 8) {
            $query->where('caisse.id_pers', '=', $idpers);
        }
        return $query->get();
    }

    static public function PatPerPayeUn($num_caisse)
    {

        $query = self::select('caisse.*', 'users.*', 'patient.*', 'caisse.id as id_caisse', 'caisse.created_at as date_c')
        ->join('patient', 'patient.id', 'caisse.id_pat')
        ->join('users', 'users.id', 'patient.id_user')
        ->where('caisse.etat_caisse', '=', 'Payé');

            $query->where('caisse.numero_recu', '=', $num_caisse);

        return $query->first();
    }

}
