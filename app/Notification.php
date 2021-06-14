<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $fillable = [
        'status',
        'amount',
        'order-id',
        'date',
        'intTransaction-id'
    ];
}
