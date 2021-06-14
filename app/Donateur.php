<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donateur extends Model
{
    //
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'numero',
        'montant',
        'reference_don'
    ];
}
