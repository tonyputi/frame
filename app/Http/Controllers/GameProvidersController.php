<?php

namespace App\Http\Controllers;


use App\Models\GameProvider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GameProvidersController extends Controller
{

    const CASINO_PROVIDERS_LIMIT = 24;

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $game_providers = GameProvider::query()
            ->when($request->search, fn($query) => $query->where('name', 'like', "%{$request->search}%"))
            ->paginate(static::CASINO_PROVIDERS_LIMIT);

        return Inertia::render('GameProviders', [
            'gameProviders' => $game_providers->items(),
            'meta' => $game_providers
        ]);
    }
}
