<?php

namespace App\Http\Controllers;

use App\Models\GameProviderQueue;
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
        $game_provider_queue = GameProviderQueue::orderBy('ended_at', 'desc')->paginate(self::GAME_PROVIDER_QUEUE_LIMIT);
        return Inertia::render('GameProviderQueue', [
           'gameProviderQueue' => $game_provider_queue
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\GameProviderQueue  $gameProviderQueue
     * @return \Illuminate\Http\Response
     */
    public function show(GameProviderQueue $gameProviderQueue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GameProviderQueue  $gameProviderQueue
     * @return \Illuminate\Http\Response
     */
    public function edit(GameProviderQueue $gameProviderQueue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GameProviderQueue  $gameProviderQueue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GameProviderQueue $gameProviderQueue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GameProviderQueue  $gameProviderQueue
     * @return \Illuminate\Http\Response
     */
    public function destroy(GameProviderQueue $gameProviderQueue)
    {
        //
    }
}
