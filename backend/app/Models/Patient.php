<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $table = 'patient';
    protected $fillable =[
        'code',
        'date_naissance',
        'lieu',
        'contact_urgent',
        'id_user',
        'profession',
        'grp_san',
        'nom_p',
        'nom_m'
    ];

    static public function getCode()
    {
        return self::orderBy('code','desc')->first();
    }

    static public function getAllPatient()
    {
        return self::select('patient.*','users.*','type_users.*','patient.id as id_patient')
        ->join('users','users.id','patient.id_user')
        ->join('type_users','type_users.id','users.id_type_user')
        ->where('patient.is_delete','=',0)
        ->get();
    }

}
