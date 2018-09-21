<?php

namespace App;

use App\Traits\Excludable;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * A Unit may be assigned to many medicines
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
