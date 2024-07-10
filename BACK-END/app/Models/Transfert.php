<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Transfert extends Model
{
    use HasFactory;
    protected $table = 'transfert';
    protected $fillable =[
        'date_envoi',
        'date_recu',
        'etat_transf',
        'motif',
        'id_pat',
        'id_pers',
        'id_pers_r',
        'id_ser',
        'id_cons',
        'etat_caisse',
        'status',
    ];

    static public function getAllPatTrans()
    {
        return self::select('transfert.*','users.*','patient.*','service.*','transfert.id as id_transfert','service.id as id_service')
        ->join('patient','patient.id','transfert.id_pat')
        ->join('users','users.id','patient.id_user')
        ->join('type_users','type_users.id','users.id_type_user')
        ->join('service','service.id','transfert.id_ser')
        ->where('patient.is_delete','=',0)
        ->where('transfert.etat_transf','=','Envoyé')
        ->get();
    }

    static public function PatSer($id_ser)
    {
        $query = self::select('transfert.*', 'users.*', 'patient.*', 'transfert.id as id_transfert')
        ->join('patient', 'patient.id', '=', 'transfert.id_pat')
        ->join('users', 'users.id', '=', 'patient.id_user')
        ->where('transfert.etat_transf', '=', 'Envoyé')
        ->where('transfert.etat_caisse', '=', 1);

        if ($id_ser != 8) {
            $query->where('transfert.id_ser', '=', $id_ser);
        }

        return $query->get();
    }


    static public function PatPer($id_pers_r)
    {
        $serviceId = DB::table('appartenir')
        ->where('id_per', '=', $id_pers_r)
            ->where('status', '=', 0)
            ->value('id_ser');
        $query = self::select('transfert.*','users.*','patient.*','transfert.id as id_transfert')
        ->join('patient','patient.id','transfert.id_pat')
        ->join('users','users.id','patient.id_user')
        ->where('transfert.etat_transf','=','Reçu')
        ->where('transfert.etat_caisse','=',1);
        if ($serviceId != 8) {
            $query->where('transfert.id_pers_r','=',$id_pers_r);
        }
        return $query->get();
    }

    static public function PatSerC()
    {
        return self::select('transfert.*','users.*','patient.*','service.*','transfert.id as id_transfert','service.id as id_service')
        ->join('patient','patient.id','transfert.id_pat')
        ->join('users','users.id','patient.id_user')
        ->join('type_users','type_users.id','users.id_type_user')
        ->join('service','service.id','transfert.id_ser')
        ->where('patient.is_delete','=',0)
        ->where('transfert.etat_transf','=','Envoyé')
        ->whereIn('transfert.etat_caisse', [0, 2])
        ->get();
    }

    static public function SearchPatSer($id_ser,$search)
    {
        $query = self::select('transfert.*','users.*','patient.*','transfert.id as id_transfert')
        ->join('patient','patient.id','transfert.id_pat')
        ->join('users','users.id','patient.id_user')
        ->where('transfert.etat_transf','=','Envoyé');
        if ($id_ser != 8) {
            $query->where('transfert.id_ser', '=', $id_ser);
        }
        $query->where(function ($queryBuilder) use ($search){
            $queryBuilder->where('users.nom','LIKE','%'.$search.'%')->orWhere('users.prenom','LIKE','%'.$search.'%');
        });
        return $query->get();
    }

    static public function countser($id_ser)
    {
        return self::select('transfert.*','transfert.id as id_transfert')
            ->where('transfert.etat_transf','=','Envoyé')
            ->where('transfert.etat_caisse','=',1)
            ->where('transfert.id_ser','=',$id_ser)
            ->count();
    }

    static public function getid($id_cons)
    {
        return self::select('transfert.*')
            ->where('id_cons','=',$id_cons)
            ->get();
    }
}
