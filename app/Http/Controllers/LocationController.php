<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\JetstreamResource;
use App\Models\Environment;

class LocationController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Location::class, 'location');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $collection = Location::query()
            ->when($request->environment, fn($query) => $query->where('environment_id', $request->environment))
            ->when($request->input('search'), fn($query) => $query->where('name', 'like', "%{$request->search}%"))
            ->with('currentBooking.user')
            ->withCount('nextBookings')
            ->paginate();

        // TODO: this is a workaround. inertia should already provide
        // a way to convert JsonResponse to proper array
        $props = JetstreamResource::collection($collection)
            ->additional([
                'permissions' => [
                    'canCreate' => $request->user()->can('create', Location::class)
                ]
            ])
            ->toResponse($request)
            ->getData(true);

        return Inertia::render('Locations/Index', $props);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $props = (new JetstreamResource(new Location))
            ->toResponse($request)
            ->getData(true);
        // TODO: this shit is just to be able to have logo_url on the location
        unset($props['data']['permissions']);

        $props['meta']['environments'] = Environment::pluck('id', 'name');

        return Inertia::render('Locations/Show', $props);
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
            'name' => ['required', 'string'],
            'match' => ['required'],
        ]);

        $location = Location::create($request->input());

        return redirect()
            ->route('locations.index')
            ->banner("Location: {$location->name} created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  Location  $location
     * @return \Inertia\Response
     */
    public function show(Request $request, Location $location)
    {
        $props = (new JetstreamResource($location))
            ->toResponse($request)
            ->getData(true);

        $props['meta']['environments'] = Environment::pluck('id', 'name');

        return Inertia::render('Locations/Show', $props);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Location $location)
    {
        $props = (new JetstreamResource($location))
            ->toResponse($request)
            ->getData(true);

        $props['meta']['environments'] = Environment::pluck('id', 'name');

        return Inertia::render('Locations/Show', $props);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  Location  $location
     * @return Response
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => ['sometimes', 'required', "string"],
            'match' => ['sometimes', 'required'],
        ]);

        $location->update($request->except('_method'));

        return back(303)->banner("Location: {$location->name} updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Location  $location
     * @return Response
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()
            ->route('locations.index')
            ->banner("Location: {$location->name} deleted!");
    }
}
