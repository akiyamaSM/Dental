<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Illness extends Model
{
    protected $table = 'illnesses';
    protected $fillable = [ 'name' ];

    /**
     * Patients who have that Illness
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'illness_patients')
                    ->withPivot(['notice'])
                    ->withTimestamps();
    }
}
