<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'firstName',
        'lastName',
        'CIN',
        'birthDay',
        'phone',
        'address',
        'gender',
    ];

    public function getFullNameAttribute()
    {
        return $this->firstName. ' ' .$this->lastName;
    }

    /**
     * Get the full name prefixed by the CIN code
     * @return string
     */
    public function getUniquePatientAttribute()
    {
        return $this->CIN. ' | '.$this->fullName;
    }
    /**
     * @param $date
     */
    public function setBirthDayAttribute($date)
    {
        $this->attributes['birthDay'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function illnesses()
    {
        return $this->belongsToMany(Illness::class, 'illness_patients')
            ->withPivot(['notice'])
            ->withTimestamps();
    }

    /**
     * The List operations Of a Specific Patient
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operations()
    {
        return $this->hasMany(Operation::class);
    }


    /**
     * Get the list of Appointments made By a specific Patient
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the list of the Current Appointments of a Patient
     * @return mixed
     */
    public function currentAppointments()
    {
        return $this->appointments()->where('state', 0);
    }

    public function versed()
    {

    }


    /**
     * Patient Has Many Payments through the operations
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Operation::class);
    }
}
