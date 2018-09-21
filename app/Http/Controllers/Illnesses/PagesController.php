<?php

namespace App\Http\Controllers\Illnesses;

use App\Illness;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function index()
    {
        $illnesses = Illness::all();
        return view('Illnesses.index', compact('illnesses')) ;
    }


}
