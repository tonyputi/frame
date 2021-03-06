<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Environment;
use Illuminate\Http\Request;
use App\Http\Resources\JetstreamResource;

class EnvironmentController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Environment::class, 'environment');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $collection = Environment::query()
            ->when($request->input('search'), fn($query) => $query->where('name', 'like', "%{$request->search}%"))
            ->withCount('locations')
            ->paginate();

        // TODO: this is a workaround. inertia should already provide
        // a way to convert JsonResponse to proper array
        $props = JetstreamResource::collection($collection)
            ->additional([
                'permissions' => [
                    'canCreate' => $request->user()->can('create', Environment::class)
                ]
            ])
            ->toResponse($request)
            ->getData(true);

        return Inertia::render('Environments/Index', $props);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $props = (new JetstreamResource(new Environment))
            ->toResponse($request)
            ->getData(true);

        return Inertia::render('Environments/Show', $props);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:environments'],
            'domain' => ['required'],
        ]);

        $environment = Environment::create($request->input());

        return redirect()
            ->route('environments.index')
            ->banner("Environment: {$environment->name} created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Environment $environment)
    {
        $props = (new JetstreamResource($environment))
            ->toResponse($request)
            ->getData(true);

        return Inertia::render('Environments/Show', $props);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Environment $environment)
    {
        $props = (new JetstreamResource($environment))
            ->toResponse($request)
            ->getData(true);

        return Inertia::render('Environments/Show', $props);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Environment $environment)
    {
        $request->validate([
            'name' => ['sometimes', 'required', "unique:environments,name,{$environment->id}"]
        ]);

        $environment->update($request->except('_method'));

        return back(303)->banner("Environment: {$environment->name} updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Environment $environment)
    {
        $environment->delete();

        return redirect()
            ->route('environments.index')
            ->banner("Environment: {$environment->name} deleted!");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:environments'],
            'domain' => ['required'],
            'withLocations' => ['boolean']
        ]);

        $environment = Environment::findOrFail($request->id);
        $cloned = $environment->replicate()
            ->fill($request->except('id', 'withLocations'));
        $cloned->save();

        if($request->withLocations) {
            $environment->locations->each(function($location) use($cloned) {
                $cloned->locations()->save($location->replicate());
            });
        }

        return redirect()
            ->route('environments.index')
            ->banner("Environment: {$environment->name} created!");
    }
}
