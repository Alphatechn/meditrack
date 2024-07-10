<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appartenir extends Model
{
    use HasFactory;
    protected $table = 'appartenir';
    protected $fillable =[
        'date_debut',
        'date_fin',
        'id_ser',
        'id_per',
        'status',
    ];

    static public function getser($id)
    {
        return self::select('appartenir.*')
            ->where('appartenir.id_per','=',$id)
            ->where('appartenir.status','=',0)
            ->first();
    }

}
