<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rendez_vous extends Model
{
    use HasFactory;
    protected $table = 'rendez_vous';
    protected $fillable =[
        'id_pat',
        'id_pers',
        'motif_r',
        'date_r',
        'time_r',
        'notes',
        'id_cons',
        'status',
        'is_delete',
    ];


    static public function getRDVen($idpers)
    {
        return self::select('rendez_vous.*', 'personnel.*', 'patient.*', 'users.*', 'rendez_vous.created_at as result_date','rendez_vous.status as status_r', 'rendez_vous.id as id_rdv')
        ->join('patient', 'patient.id', 'rendez_vous.id_pat')
        ->join('users', 'users.id', 'patient.id_user')
        ->join('personnel', 'personnel.id', 'rendez_vous.id_pers')
        ->where( 'rendez_vous.id_pers', '=', $idpers)
        ->where('rendez_vous.status', '!=', 'Réalisé')
        ->get();
    }

    static public function getRDVenpat($idpat)
    {
        return self::select('rendez_vous.*', 'personnel.*', 'patient.*', 'users.*', 'rendez_vous.created_at as result_date', 'rendez_vous.status as status_r', 'rendez_vous.id as id_rdv')
        ->join('patient', 'patient.id', 'rendez_vous.id_pat')
        ->join('users', 'users.id', 'patient.id_user')
        ->join('personnel', 'personnel.id', 'rendez_vous.id_pers')
        ->where('rendez_vous.id_pat', '=', $idpat)
            ->where('rendez_vous.status', '!=', 'Réalisé')
            ->get();
    }

    static public function getRDVenall($idpers)
    {
        return self::select('rendez_vous.*', 'personnel.*', 'patient.*', 'users.*', 'rendez_vous.created_at as result_date', 'rendez_vous.status as status_r', 'rendez_vous.id as id_rdv')
        ->join('patient', 'patient.id', 'rendez_vous.id_pat')
        ->join('users', 'users.id', 'patient.id_user')
        ->join('personnel', 'personnel.id', 'rendez_vous.id_pers')
        ->where('rendez_vous.id_pers', '=', $idpers)
            ->where('rendez_vous.status', '=', 'Réalisé')
            ->get();
    }

    static public function getRDVunique($idrdv)
    {
        return self::select('rendez_vous.*', 'personnel.*', 'patient.*', 'users.*', 'rendez_vous.created_at as result_date', 'rendez_vous.status as status_r', 'rendez_vous.id as id_rdv')
        ->join('patient', 'patient.id', 'rendez_vous.id_pat')
        ->join('users', 'users.id', 'patient.id_user')
        ->join('personnel', 'personnel.id', 'rendez_vous.id_pers')
        ->where('rendez_vous.id', '=', $idrdv)
        ->get();
    }
}
