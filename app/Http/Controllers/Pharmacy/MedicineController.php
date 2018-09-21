<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Requests\CreateMedicineRequest;
use App\Medicine;
use App\Unit;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MedicineController extends Controller
{
    /**
     * Show the list of Medicines
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $units = Unit::pluck('name', 'id')->toArray();
        $medicines = Medicine::with('unit')->get();
        return view('Pharmacy.Medicines.index', compact('medicines', 'units'));
    }

    /**
     * Create a new Medicine
     * @param CreateMedicineRequest $request
     * @return bool|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function store(CreateMedicineRequest $request)
    {
        $medicine = new Medicine($request->all());
        $unit = Unit::findOrFail($request->unit_id);
        if($unit->medicines()->save($medicine)){
            $res = Medicine::with('unit')->find($medicine->id);
            return $res;
        }
        return false;
    }
}
