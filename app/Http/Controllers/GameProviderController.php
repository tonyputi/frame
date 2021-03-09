<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\GameProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\JetstreamResource;
use App\Http\Resources\GameProviderResource;

class GameProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $collection = GameProvider::query()
            ->when($request->input('search'), fn($query) => $query->where('name', 'like', "%{$request->search}%"))
            ->with('currentBooking.user')
            ->withCount('nextBookings')
            ->paginate();

        // TODO: this is a workaround. inertia should already provide
        // a way to convert JsonResponse to proper array
        $props = JetstreamResource::collection($collection)
            ->additional(['permissions' => [
                'canCreateGameProvider' => true,
                'canUpdateGameProvider' => true,
                'canDeleteGameProvider' => true,
            ]])
            ->toResponse($request)
            ->getData(true);

        return Inertia::render('GameProviders/Index', $props);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('GameProviders/Show', [
            'gameProvider' => new GameProviderResource(new GameProvider),
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

        $gameProvider = GameProvider::create($request->input());

        return redirect()
            ->route('game-providers.index')
            ->banner("Game Provider: {$gameProvider->name} created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  GameProvider  $gameProvider
     * @return \Inertia\Response
     */
    public function show(Request $request, GameProvider $gameProvider)
    {
        return Inertia::render('GameProviders/Show', [
            'gameProvider' => new GameProviderResource($gameProvider),
            'permissions' => [
                'canUpdateGameProvider' => true,
                'canDeleteGameProvider' => true,
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
        return Inertia::render('GameProviders/Show', [
            'gameProvider' => new GameProviderResource($gameProvider),
            'permissions' => [
                'canUpdateGameProvider' => true,
                'canDeleteGameProvider' => false,
            ]
        ]);
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
            'name' => ['sometimes', 'required', "unique:game_providers,name,{$gameProvider->id}"],
            'location_modifier' => ['sometimes', 'required'],
            'location_match' => ['sometimes', 'required'],
            'location_block' => ['sometimes', 'required'],
        ]);

        $gameProvider->update($request->except('_method'));

        return back(303)->banner("Game Provider: {$gameProvider->name} updated!");
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

        return redirect()
            ->route('game-providers.index')
            ->banner("Game Provider: {$gameProvider->name} deleted!");
    }
}
