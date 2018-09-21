<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tooth extends Model
{
    protected $fillable = [
        'code',
        'name'
    ];
}
