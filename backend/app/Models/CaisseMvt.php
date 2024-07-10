<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaisseMvt extends Model
{
    use HasFactory;
    protected $table = 'caisse_mvts';
    protected $fillable =[
        'libelle',
        'montant',
        'num_recu',
    ];
}
