<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antecedant extends Model
{
    use HasFactory;
    protected $table = 'antecedents';
    protected $fillable =[
        'medi',
        'chiru',
        'gyneco',
        'immu',
        'aller',
        'autres',
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
}
