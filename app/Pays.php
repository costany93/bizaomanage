<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    //
    protected $fillable = [
        'name'
    ];

    public function donateur(){
        return $this->hasMany('App\Donateur');
    }
}
