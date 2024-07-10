<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultP extends Model
{
    use HasFactory;
    protected $table = 'resultp';
    protected $fillable =[
        'id',
        'id_pat',
        'id_pers',
        'id_cons',
        'exam',
        'result_text',
        'result_image',
    ];

    static public function getAllPatient($idcons)
    {
        return self::select('resultp.*','personnel.*','patient.*','users.*','resultp.created_at as result_date','resultp.id as id_resultp')
        ->join('patient','patient.id','resultp.id_pat')
        ->join('users','users.id','patient.id_user')
        ->join('personnel','personnel.id','resultp.id_pers')
        ->where('resultp.id_cons','=',$idcons)
        ->get();
    }

    static public function getResult($idcons)
    {
        return self::select('resultp.*')
        ->where('id_cons','=',$idcons)
        ->get();
    }
}
