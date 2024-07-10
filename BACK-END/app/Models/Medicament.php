<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
    use HasFactory;
    protected $table = 'medicament';
    protected $fillable =[
        'libelle',
        'id_cat',
        'prix',

    ];

    static public function getAllMed()
    {
        return self::select('medicament.*','categories.*','medicament.id as id_medicament','categories.libelle as categorie','medicament.libelle as medi')
        ->join('categories','categories.id','medicament.id_cat')
        ->get();
    }
    static public function getSingleMed($id)
    {
        return self::select('medicament.*','categories.*','medicament.id as id_medicament','categories.libelle as categorie','medicament.libelle as medi')
        ->join('categories','categories.id','medicament.id_cat')
        ->where('medicament.id','=',$id)
        ->get();
    }
}
