<?php

namespace App\Http\Controllers;

use App\Models\GameProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class GameProviderController extends Controller
{

    const GAME_PROVIDERS_LIMIT = 24;

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $game_providers = GameProvider::query()
            ->with('gameActiveProviderQueue')
            ->withCount('gameProviderQueues')
            ->when($request->search, fn($query) => $query->where('name', 'like', "%{$request->search}%"))
            ->orderBy('started_at', 'asc')
            ->paginate(static::GAME_PROVIDERS_LIMIT);

        return Inertia::render('GameProviders', [
            'gameProviders' => $game_providers
                ->map(function ($resource) {
                    return [
                        'id' => $resource->id,
                        'name' => $resource->name,
                        'location_modifier' => $resource->location_modifier,
                        'location_match' => $resource->location_match,
                        'is_available' => !!!$resource->gameActiveProviderQueue->user_id,
                        'notes' => !!!$resource->gameActiveProviderQueue->notes,
                        'user' => $resource->gameActiveProviderQueue->user,
                        'started_at' => $resource->gameActiveProviderQueue->started_at,
                        'ended_at' => $resource->gameActiveProviderQueue->ended_at,
                        'game_provider_queues_count' => $resource->game_provider_queues_count
                    ];
                }),
            'meta' => $game_providers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $GameProvider = GameProvider::create($request->input());

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        return Inertia::render('GameProvider/Show', [
            'GameProvider' => GameProvider::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        GameProvider::findOrFail($id)->update($request->input());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        GameProvider::findOrFail($id)->delete($id);

        return back();
    }
}
