<?php

namespace App\Http\Controllers\Patients\Payments;

use App\Patient;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ManageController extends Controller
{
    /**
     * Show the Operations of a Single Patient
     * @param Patient $patient
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Patient $patient)
    {
        return view('Patients.Payments.index', compact('patient'));
    }
}
