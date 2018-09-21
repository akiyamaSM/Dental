<?php

namespace App\Http\Controllers\Illnesses;

use App\Illness;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class ManageController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
       return Illness::all();
    }

    /**
     * @return Illness Model
     */
    public function store()
    {
        return Illness::create(Request::all());
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function update($id)
    {
        Illness::findOrFail($id)->update(Request::all());
        return Illness::findOrFail($id);
    }

}
