<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Requests\CreateUnitRequest;
use App\Unit;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    /**
     * Show the list of Units
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
      $units = Unit::all();
      return view('Pharmacy.Units.index', compact('units'));
    }

    /**
     * Store a new Unit
     * @param CreateUnitRequest $request
     * @return static
     */
    public function store(CreateUnitRequest $request)
    {
        $unit = Unit::create($request->all());
        return $unit;
    }


    /**
     * Update Units information
     * @param Unit $unit
     * @param CreateUnitRequest $request
     * @return Unit
     */
    public function update(Unit $unit, CreateUnitRequest $request)
    {
        $unit->update($request->all());
        return $unit;
    }

    /**
     * Delete a Unit
     * @param Unit $unit
     * @return Unit
     * @throws \Exception
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return $unit;
    }
}
