<?php

namespace App\Http\Controllers;

use App\Models\GameProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class GameProviderController extends Controller
{
//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        return Inertia::render('GameProvider/Index', [
//            'GameProviders' => GameProvider::all()
//        ]);
//    }
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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $GameProvider = GameProvider::create($request->input());

        return response($GameProvider, 201);
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

        return response(NULL, 204);
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

        return response(NULL, 204);
    }
}
