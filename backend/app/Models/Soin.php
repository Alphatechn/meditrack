<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soin extends Model
{
    use HasFactory;
    protected $table = 'soin';
    protected $fillable =[
        'libelle',
        'cout',
        'traitement',
        'status',
    ];
}
