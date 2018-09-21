<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [ 'state', 'appointment_at', 'notice' ];

    protected $dates = ['created_at', 'updated_at', 'appointment_at'];


    /**
     * Confirm that the patient went to the Appointment
     * @return $this
     */
    public function confirm()
    {
        $this->state = 1;
        return $this;
    }

    /**
     * Cancel the Appointment
     * @return $this
     */
    public function cancel()
    {
        $this->state = -1;
        return $this;
    }

    /**
     * Activate the Appointment
     * @return $this
     */
    public function activate()
    {
        $this->state = 0;
        return $this;
    }

    /**
     * Get the Patient who has made the Appointment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function concern()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

}
