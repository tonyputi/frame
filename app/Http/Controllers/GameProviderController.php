<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameProviderResource;
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
        $gameProviders = GameProvider::query()
            ->with('candidateGameProviderOnQueue')
            ->withCount('gameProviderQueues')
            ->paginate(static::GAME_PROVIDERS_LIMIT);

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
        return Inertia::render('GameProviders/Show');
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
    public function show(GameProvider $gameProvider)
    {
        return Inertia::render('GameProviders/Show', [
            'gameProvider' => new GameProviderResource($gameProvider),
            'permissions' => [
                'canUpdateGameProvider' => true
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, GameProvider $gameProvider)
    {
        $gameProvider->update($request->except('_method'));

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

        return redirect()->route('game-providers.index');
    }
}
