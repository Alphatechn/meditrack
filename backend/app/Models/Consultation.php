<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Consultation extends Model
{
    use HasFactory;
    protected $table = 'consultation';
    protected $fillable =[
        'temperature',
        'poids',
        'taille',
        'type_cons',
        'symptome',
        'diagnostique',
        'exam_recom',
        'status',
        'id_pat',
        'id_pers',
    ];

    static public function getCons($idpat)
    {
        return self::select('consultation.*','personnel.*','consultation.created_at as cons_date','consultation.id as id_consultation','users.*')
        ->join('personnel','personnel.id','consultation.id_pers')
        ->join('users','users.id','personnel.id_user')
        ->where('consultation.id_pat','=',$idpat)
        ->get();
    }

    static public function getMed($idpat)
    {
        return self::select('users.*','personnel.id as id_personnel')
        ->join('personnel', 'personnel.id', '=', 'consultation.id_pers')
        ->join('users', 'users.id', '=', 'personnel.id_user')
        ->where('consultation.id_pat', '=', $idpat)
        ->groupBy('consultation.id_pers')
        ->get();
    }


    static public function getAllPatient($pers)
    {
        $serviceId = DB::table('appartenir')
        ->where('id_per', '=', $pers)
        ->where('status', '=', 0)
        ->value('id_ser');
        $query = self::select('consultation.*','personnel.*','patient.*','users.*','consultation.created_at as cons_date','consultation.id as id_consultation')
        ->join('patient','patient.id','consultation.id_pat')
        ->join('users','users.id','patient.id_user')
        ->join('personnel','personnel.id','consultation.id_pers');
        if ($serviceId != 8) {
            $query->where('consultation.id_pers','=',$pers);
        }
        return $query->get();
    }

    static public function getAllPatientLabo($pers)
    {
        $serviceId = DB::table('appartenir')
        ->where('id_per', '=', $pers)
            ->where('status', '=', 0)
            ->value('id_ser');
        $query =  self::select('consultation.*','personnel.*','patient.*','users.*','consultation.created_at as cons_date','consultation.id as id_consultation')
        ->join('patient','patient.id','consultation.id_pat')
        ->join('users','users.id','patient.id_user')
        ->join('personnel','personnel.id','consultation.id_pers')
        ->join('transfert','transfert.id_cons','consultation.id');
        if ($serviceId != 8) {
            $query->where('consultation.id_pers', '=', $pers);
        }
        return $query->where('consultation.exam_recom','!=','ok')
        ->where('transfert.etat_transf','=','Reçu')
        ->get();
    }

    static public function getUnPatient($id_cons)
    {
        return self::select('consultation.*','personnel.*','patient.*','users.*','consultation.created_at as cons_date','consultation.id as id_consultation')
        ->join('patient','patient.id','consultation.id_pat')
        ->join('users','users.id','patient.id_user')
        ->join('personnel','personnel.id','consultation.id_pers')
        ->where('consultation.id','=',$id_cons)
        ->get();
    }
}
