<?php

namespace App\Http\Controllers;


use App\Models\CasinoProvider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CasinoProvidersController extends Controller
{

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('CasinoProviders', [
           'casinoProviders' => CasinoProvider::all()
        ]);
    }
}
