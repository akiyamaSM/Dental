<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operation extends Model
{
    use SoftDeletes;
    protected $fillable =[
        'patient_id',
        'tooth_id',
        'type_id',
        'price',
        'notice',
    ];

    /**
     * Get The Patient whom concerned by this Operation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function concern()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * Get The Type Of The Operation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get on What an Operation is Done
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function about()
    {
        return $this->belongsTo(Tooth::class, 'tooth_id');
    }
    /**
     * Get the List of Sessions of a specific Operation
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * Get the List of Payments of a specific Operation
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'operation_id');
    }
}
