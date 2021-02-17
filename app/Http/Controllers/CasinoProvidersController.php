<?php

namespace App\Http\Controllers;


use App\Models\CasinoProvider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CasinoProvidersController extends Controller
{

    const CASINO_PROVIDERS_LIMIT = 20;

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $casino_providers = CasinoProvider::query()
            ->when($request->search, fn($query) => $query->where('name', 'like', "%{$request->search}%"))
            ->limit(static::CASINO_PROVIDERS_LIMIT)
            ->get();


        return Inertia::render('CasinoProviders', [
           'casinoProviders' => $casino_providers
        ]);
    }
}
