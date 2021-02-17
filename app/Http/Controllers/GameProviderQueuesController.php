<?php

namespace App\Http\Controllers;

use App\Models\GameProviderQueue;
use App\Models\GameProvider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GameProviderQueuesController extends Controller
{
    const GAME_PROVIDER_QUEUE_LIMIT = 20;

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $game_providers = GameProvider::all();

        $game_provider_queue = GameProviderQueue::orderBy('ended_at', 'desc')->paginate(self::GAME_PROVIDER_QUEUE_LIMIT);
        return Inertia::render('Reservations', [
            'gameProviderQueue' => $game_provider_queue,
            'casinoProviders' => $game_providers,
            'casinoProvidersNames' => $game_providers->pluck('name')
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
