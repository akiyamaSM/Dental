<?php

namespace App\Http\Controllers\Patients;

use App\Http\Requests\PatientRequest;
use App\Http\Controllers\Controller;
use App\Illness;
use App\Jobs\CreatePatient;
use App\Http\Requests;
use App\Operation;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageController extends Controller
{
    /**
     * Method to show Create Form of the Client
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $illnesses = Illness::all();
        return view('Patients.create', compact('illnesses'));
    }


    /**
     * Creation of a new patient
     * @param PatientRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PatientRequest $request)
    {
        DB::transaction(function() use ($request)  {
            $patient = $this->dispatch(new CreatePatient($request));
            if($request->illness_id !=null){
                $patient->illnesses()->sync($request->illness_id);
            }
            session()->flash('message', 'Votre patient <b>'. $patient->fullName .'</b> - a éte enregistré.');
        });
        return redirect(route('admin.patient.index'));
    }


    /**
     * @param Patient $patient
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Patient $patient)
    {
        /*dd($patient->payments()->get());*/
        return view('Patients.show', compact('patient'));
    }

    /**
     * Show the List of Patients
     */
    public function index()
    {
        $patients = Patient::all();
        return view('Patients.index', compact('patients'));
    }

    /**
     * Part Of The API
     * @param Patient $patient
     * @return Patient
     * @throws \Exception
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return $patient;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function history()
    {
        $patients = Patient::onlyTrashed()->get();
        return view('Patients.history', compact('patients'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function forceDestroy($id)
    {
        $patient = Patient::onlyTrashed()
                          ->where('id', $id)
                          ->first();
        $patient->forceDelete();
        return $patient;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function revive($id)
    {
        $patient = Patient::onlyTrashed()
            ->where('id', $id)
            ->first();
        $patient->restore();
        return $patient;
    }


}
