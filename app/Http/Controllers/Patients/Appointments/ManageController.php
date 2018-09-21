<?php

namespace App\Http\Controllers\Patients\Appointments;

use App\Appointment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAppointmentRequest;
use App\Jobs\CreateAppointment;
use App\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManageController extends Controller
{

    /**
     * Get the list of Appointments of Certain Patient
     * @param Patient $patient
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Patient $patient)
    {
        $appointments = $patient->appointments()->get();
        return view('Appointments.patient.all', compact('appointments', 'patient'));
    }

    /**
     * Get the list of the next Appointments of a Certain Patient
     * @param Patient $patient
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function current(Patient $patient)
    {
        $appointments = $patient->appointments();
        return view('Appointments.Patient.current', compact('appointments'));
    }

    /**
     * Get the list of Appointments
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function all()
    {
        $appointments = Appointment::with('concern')->orderBy('appointment_at', 'asc')->get();
        $patients = Patient::all();
        $list = $patients->pluck('uniquePatient', 'id')->toArray();
        return view('Appointments.All', compact('appointments', 'list'));
    }

    /**
     * Create a new Appointment
     * @param CreateAppointmentRequest|Request $request
     * @return mixed
     */
    public function store(CreateAppointmentRequest $request)
    {
        return $this->makeAppointment($request);
    }


    /**
     * @param Appointment $appointment
     * @param CreateAppointmentRequest $request
     * @return bool|int
     */
    public function update(Appointment $appointment, CreateAppointmentRequest $request)
    {
            $appointment->update($request->all());
        return $appointment;
    }


    /**
     * Delete the row
     * @param Appointment $appointment
     * @return Appointment
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return $appointment;
    }

    /**
     * Cancel the Appointment
     * @param Appointment $appointment
     * @return Appointment
     */
    public function cancel(Appointment $appointment)
    {
        $appointment->cancel()->save();
        return $appointment;
    }

    /**
     * Activate the Appointment
     * @param Appointment $appointment
     * @return Appointment
     */
    public function activate(Appointment $appointment)
    {
        $appointment->activate()->save();
        return $appointment;
    }

    /**
     * Validate the Appointment
     * @param Appointment $appointment
     * @return Appointment
     */
    public function confirm(Appointment $appointment)
    {
        $appointment->confirm()->save();
        return $appointment;
    }
    /**
     * Prepare the data
     * @param $data
     * @return Appointment|bool
     */
    public function makeAppointment($data)
    {
        $data['appointment_at'] = Carbon::parse($data->appointment_at);
        $appointment = new Appointment($data->all());
        $patient = Patient::findOrFail($data->patient_id);
        if($patient->appointments()->save($appointment)){
            return $appointment;
        }
        return false;
    }

}
