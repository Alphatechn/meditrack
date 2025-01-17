<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    use HasFactory;
    protected $table = 'element';
    protected $fillable =[
        'status',
        'montant',
        'libelle',
    ];
}
