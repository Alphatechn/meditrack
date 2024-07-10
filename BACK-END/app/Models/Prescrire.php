<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescrire extends Model
{
    use HasFactory;
    protected $table = 'prescrire';
    protected $fillable =[
        'dose',
        'prise',
        'medicament',
    ];

    static public function getPres($id)
    {
        return self::select('prescrire.*')
            ->where('prescrire.id_consul','=',$id)
            ->where('prescrire.status','=',0)
            ->get();
    }
}
