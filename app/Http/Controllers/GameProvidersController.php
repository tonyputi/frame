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
            ->with('gameActiveProviderQueue')
            ->when($request->search, fn($query) => $query->where('name', 'like', "%{$request->search}%"))
            ->paginate(static::CASINO_PROVIDERS_LIMIT);

        return Inertia::render('GameProviders', [
            'gameProviders' => $game_providers
                ->map(function ($resource) {
                    return [
                        'id' => $resource->id,
                        'name' => $resource->name,
                        'location_modifier' => $resource->location_modifier,
                        'location_match' => $resource->location_match,
                        'is_available' => !!!$resource->gameActiveProviderQueue->host,
                        'notes' => !!!$resource->gameActiveProviderQueue->notes,
                        'host' => $resource->gameActiveProviderQueue->host,
                        'started_at' => $resource->gameActiveProviderQueue->started_at,
                        'ended_at' => $resource->gameActiveProviderQueue->ended_at,
                    ];
                }),
            'meta' => $game_providers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
