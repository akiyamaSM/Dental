<?php

namespace App\Http\Controllers\Patients\Operations;

use App\Http\Requests\CreateOperationRequest;
use App\Http\Requests\CreatePaymentRequest;
use App\Operation;
use App\Patient;
use App\Payment;
use App\Session;
use App\Tooth;
use App\Type;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Request;

class ManageController extends Controller
{

    /**
     * Show the Operations of a Single Patient
     * @param Patient $patient
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Patient $patient)
    {
        return view('Patients.Operations.index', compact('patient'));
    }

    /**
     * @param Patient $patient
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Patient $patient)
    {
        $teeth = Tooth::lists('name', 'id');
        $types = Type::lists('name', 'id');
        return view('Patients.Operations.create', compact('patient', 'teeth', 'types'));
    }

    public function store(CreateOperationRequest $request,Patient $patient )
    {
        $request['patient_id'] = $patient->id;
        $operation = Operation::create($request->all());
        DB::transaction(function() use ($request, $patient, $operation)  {
            $session = new Session(['notice' => 'test']);
            $operation->sessions()->save($session);
            session()->flash('message', 'Welcome to <b>Light Bootstrap Dashboard</b> - a beautiful freebie for every web developer.');
        });

        return redirect(route('patient.operation.show', [$patient, $operation]));
    }

    /**
     * @param Patient $patient
     * @param Operation $operation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Patient $patient, Operation $operation)
    {
        return view('Patients.Operations.show', compact('patient', 'operation'));
    }


    /**
     * @param Operation $operation
     * @return Operation
     * @throws \Exception
     */
    public function terminate(Operation $operation)
    {
        $operation->delete();
        return $operation;
    }

    /**
     * @param Patient $patient
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function history(Patient $patient, $id)
    {
        $operation = Operation::onlyTrashed()
            ->where('id', $id)
            ->first();

        return view('Patients.Operations.history', compact('patient', 'operation'));
    }


    /**
     * Make a new Session
     * @param Operation $operation
     * @return Session
     */
    public function storeSession(Operation $operation)
    {
        $session = new Session(Request::all());
        $operation->sessions()->save($session);
        return $session;
    }

    /**
     * make a new Payment
     * @param $id Of Operation
     * @param CreatePaymentRequest $request
     * @return Payment
     */
    public function makePayment($id, CreatePaymentRequest $request)
    {
        $operation = Operation::withTrashed()
                              ->where('id', $id)
                              ->first();
        $payment = new Payment($request->all());
        $operation->payments()->save($payment);
        return $payment;
    }


}
