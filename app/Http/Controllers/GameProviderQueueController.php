<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Rules\AvailableTime;
use Illuminate\Http\Request;
use App\Models\GameProviderQueue;
use App\Http\Resources\GameProviderQueueResource;

class GameProviderQueueController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $gameProviderQueues = GameProviderQueue::with(['user', 'gameProvider', 'environment', 'application'])
            ->available()
            ->when($request->input('search'), function($query) use($request) {
                $query->whereHas('user', fn($query) => $query->where('name', 'like', "%{$request->search}%"));
                $query->orWhereHas('gameProvider', fn($query) => $query->where('name', 'like', "%{$request->search}%"));
            })
            ->orderBy('started_at', 'asc')
            ->paginate();

        return Inertia::render('GameProviderQueues/Index', [
            'gameProviderQueues' => GameProviderQueueResource::collection($gameProviderQueues),
            'permissions' => [
                'canCreateGameProviderQueue' => true,
                'canUpdateGameProviderQueue' => true,
                'canDeleteGameProviderQueue' => true,
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_provider_id' => ['required'],
            'started_at' => ['required', new AvailableTime('game_provider_queues', $request->only('game_provider_id'))],
            'ended_at' => ['required', new AvailableTime('game_provider_queues', $request->only('game_provider_id'))]
        ]);

        $GameProviderQueue = new GameProviderQueue($request->input());
        $GameProviderQueue->user_id = $request->user()->id;
        $GameProviderQueue->save();

        return back(303);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return GameProviderQueue::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        GameProviderQueue::findOrFail($id)->update($request->input());

        return back(303);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        GameProviderQueue::findOrFail($id)->delete($id);
        
        return back();
    }
}
