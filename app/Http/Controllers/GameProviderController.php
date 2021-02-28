<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameProviderResource;
use App\Models\GameProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class GameProviderController extends Controller
{
    /**
     * Show the game provider list
     * 
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $gameProviders = GameProvider::query()
            ->when($request->input('search'), fn($query) => $query->where('name', 'like', "%{$request->search}%"))
            ->with('candidateGameProviderOnQueue.user')
            ->withCount('gameProviderQueues')
            ->paginate();

        return Inertia::render('GameProviders/Index', [
            'gameProviders' => GameProviderResource::collection($gameProviders),
            'permissions' => [
                'canCreateGameProvider' => true,
                'canUpdateGameProvider' => true,
                'canDeleteGameProvider' => true,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('GameProviders/Show', [
            'gameProvider' => new GameProviderResource(new GameProvider([
                'location_modifier' => '~*'
            ])),
            'permissions' => [
                'canDeleteGameProvider' => false,
            ]
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
        $request->validate([
            'name' => ['required', 'unique:game_providers'],
            'location_modifier' => ['required'],
            'location_match' => ['required'],
        ]);

        GameProvider::create($request->input());

        return redirect()->route('game-providers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  GameProvider  $gameProvider
     * @return \Inertia\Response
     */
    public function show(GameProvider $gameProvider)
    {
        return Inertia::render('GameProviders/Show', [
            'gameProvider' => new GameProviderResource($gameProvider),
            'permissions' => [
                'canUpdateGameProvider' => true,
                'canDeleteGameProvider' => true
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  GameProvider  $gameProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(GameProvider $gameProvider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  GameProvider  $gameProvider
     * @return Response
     */
    public function update(Request $request, GameProvider $gameProvider)
    {
        $request->validate([
            'name' => ['required', "unique:game_providers,name,{$gameProvider->id}"],
            'location_modifier' => 'required',
            'location_match' => 'required',
        ]);

        $gameProvider->update($request->except('_method'));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  GameProvider  $gameProvider
     * @return Response
     */
    public function destroy(GameProvider $gameProvider)
    {
        $gameProvider->delete();

        return redirect()->route('game-providers.index');
    }
}
