<?php

namespace App\Providers;

use App\Appointment;
use App\Operation;
use App\Patient;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('valid', function($attribute, $value, $parameters, $validator) {
            $operation = Operation::findOrFail($parameters[0]);
            $payed = $operation->payments()->sum('versed');
            $price = $operation->price;

            if($price < $payed + $value){
                return false;
            }
            return true;
        });
        Validator::extend('is_available', function($attribute, $value, $parameters, $validator) {
            $idAppointment = $parameters[0];

                $patient = Patient::findOrFail($value);
            if($patient){
                $counter = $patient->currentAppointments();
                if($idAppointment != null)// eliminate the current Appointment
                    $counter = $counter->where('id', '!=', $idAppointment);
                return $counter->count() == 0;
            }
            return false;
        });

        Validator::extend('is_not_in_the_past', function($attribute, $value, $parameters, $validator) {
            return Carbon::parse($value) >= Carbon::now();
        });

        Validator::extend('is_doctor_available', function($attribute, $value, $parameters, $validator) {

            $id = $parameters[0];
            $appointment_at = Carbon::parse($value);
            $appointment_at_sub = Carbon::parse($value)->subMinute(15);
            $appointment_at_plus = Carbon::parse($value)->addMinute(15);
            $appointment = Appointment::whereBetween('appointment_at', [
                $appointment_at_sub, // from
                $appointment_at // to
            ]);

            if($id != null)
                $appointment = $appointment->where('id', '!=', $id);
            if($appointment->count() > 0) return false;

            $appointment = Appointment::whereBetween('appointment_at', [
                $appointment_at, // from
                $appointment_at_plus // to
            ]);

            if($id != null)
                $appointment = $appointment->where('id', '!=', $id);

            if($appointment->count() > 0) return false;

            return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
