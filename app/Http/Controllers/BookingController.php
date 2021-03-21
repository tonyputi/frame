<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Booking;
use App\Models\GameProvider;
use App\Rules\AvailableTime;
use Illuminate\Http\Request;
    use App\Notifications\LocationBooked;
use App\Http\Resources\JetstreamResource;
use App\Notifications\BookingCreated;

class BookingController extends Controller
{

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Booking::class, 'booking');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $collection = Booking::with(['user', 'gameProvider', 'environment', 'application'])
            ->when($request->game_provider, fn($query) => $query->where('location_id', $request->game_provider))
            ->when($request->input('search'), fn($query) => $query->filter($request->search))
            ->available()
            ->orderBy('started_at', 'asc')
            ->paginate();

        // TODO: this is a workaround. inertia should already provide
        // a way to convert JsonResponse to proper array
        $props = JetstreamResource::collection($collection)
            ->additional(['permissions' => [
                'canCreate' => true
            ]])
            ->toResponse($request)
            ->getData(true);


        return Inertia::render('Bookings/Index', $props);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $props = (new JetstreamResource(new Booking))
            ->toResponse($request)
            ->getData(true);

        return Inertia::render('Bookings/Show', $props);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, GameProvider $gameProvider)
    {
        $request->validate([
            'started_at' => [
                'required',
                'date',
                'before:ended_at',
                new AvailableTime('bookings', $gameProvider->id)
            ],
            'ended_at' => [
                'required',
                'date',
                'after:started_at',
                new AvailableTime('bookings', $gameProvider->id)
            ]
        ]);

        $booking = new Booking($request->input());
        $booking->location_id = $gameProvider->id;
        $booking->user_id = $request->user()->id;
        $booking->save();

        $request->user()->notify(new BookingCreated($booking));

        return back(303)->banner("Game Provider: {$gameProvider->name} booked!");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Booking $booking)
    {
        $props = (new JetstreamResource($booking))
            ->toResponse($request)
            ->getData(true);

        return Inertia::render('Bookings/Show', $props);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Booking $booking)
    {
        $props = (new JetstreamResource($booking))
            ->toResponse($request)
            ->getData(true);

        return Inertia::render('Bookings/Edit', $props);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'started_at' => ['sometimes', new AvailableTime('bookings', $request->only('location_id'))],
            'ended_at' => ['sometimes', new AvailableTime('bookings', $request->only('location_id'))]
        ]);

        $booking->update($request->input());

        return back(303);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return back();
    }
}
