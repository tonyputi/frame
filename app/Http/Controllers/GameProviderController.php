<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\GameProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\JetstreamResource;
use App\Models\Environment;

class GameProviderController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(GameProvider::class, 'game_provider');
    }

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
            ->additional([
                'permissions' => [
                    'canCreate' => $request->user()->can('create', GameProvider::class)
                ]
            ])
            ->toResponse($request)
            ->getData(true);

        return Inertia::render('GameProviders/Index', $props);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $props = (new JetstreamResource(new GameProvider))
            ->toResponse($request)
            ->getData(true);
        // TODO: this shit is just to be able to have logo_url on the location
        unset($props['data']['permissions']);

        $props['meta']['environments'] = Environment::pluck('id', 'name');

        return Inertia::render('GameProviders/Show', $props);
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
            'name' => ['required', 'unique:locations'],
            'match' => ['required'],
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
        $props = (new JetstreamResource($gameProvider))
            ->toResponse($request)
            ->getData(true);

        $props['meta']['environments'] = Environment::pluck('id', 'name');

        return Inertia::render('GameProviders/Show', $props);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  GameProvider  $gameProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, GameProvider $gameProvider)
    {
        $props = (new JetstreamResource($gameProvider))
            ->toResponse($request)
            ->getData(true);

        $props['meta']['environments'] = Environment::pluck('id', 'name');

        return Inertia::render('GameProviders/Show', $props);
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
            'name' => ['sometimes', 'required', "unique:locations,name,{$gameProvider->id}"],
            'match' => ['sometimes', 'required'],
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
