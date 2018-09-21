<?php

namespace App\Jobs;

use App\Appointment;
use App\Patient;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateAppointment extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $data;

    protected $appointment;

    /**
     * Create a new job instance.
     *
     * @param $request
     */
    public function __construct($request)
    {
        $this->data = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $appointment = new Appointment($this->data);
      $patient = Patient::findOrFail($this->data['patient_id']);
      if($patient->appointments()->save($appointment)){
          return $appointment->toJson();
      }
      return false;
    }
}
