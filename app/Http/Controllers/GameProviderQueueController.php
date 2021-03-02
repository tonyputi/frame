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
        $bookings = GameProviderQueue::with(['user', 'gameProvider', 'environment', 'application'])
            ->when($request->input('search'), fn($query) => $query->filter($request->search))
            ->available()
            ->orderBy('started_at', 'asc')
            ->paginate();

        return Inertia::render('GameProviderQueues/Index', [
            'gameProviderQueues' => GameProviderQueueResource::collection($bookings),
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

        $booking = new GameProviderQueue($request->input());
        $booking->user_id = $request->user()->id;
        $booking->save();

        return back(303);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(GameProviderQueue $booking)
    {
        return Inertia::render('GameProviderQueues/Index', [
            'gameProviderQueues' => new GameProviderQueueResource($booking),
            'permissions' => [
                'canCreateGameProviderQueue' => true,
                'canUpdateGameProviderQueue' => true,
                'canDeleteGameProviderQueue' => true,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GameProviderQueue $booking)
    {
        $request->validate([
            'started_at' => ['required', new AvailableTime('game_provider_queues', $request->only('game_provider_id'))],
            'ended_at' => ['required', new AvailableTime('game_provider_queues', $request->only('game_provider_id'))]
        ]);

        $booking->update($request->input());

        return back(303);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(GameProviderQueue $booking)
    {
        $booking->delete();
        
        return back();
    }
}
