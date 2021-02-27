<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\GameProviderQueue;
use App\Http\Resources\GameProviderQueueResource;

class GameProviderQueuesController extends Controller
{
    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $gameProviderQueues = GameProviderQueue::query()
            // ->when($request->input('search'), fn($query) => $query->where('name', 'like', "%{$request->search}%"))
            ->with(['user', 'gameProvider', 'environment', 'application'])
            ->paginate();

        return Inertia::render('GameProviderQueues/Index', [
            'gameProviderQueues' => $gameProviderQueues,
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
