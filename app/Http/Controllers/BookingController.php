<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Rules\AvailableTime;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Http\Resources\BookingResource;
use App\Models\GameProvider;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $bookings = Booking::with(['user', 'gameProvider', 'environment', 'application'])
            ->when($request->input('search'), fn($query) => $query->filter($request->search))
            ->available()
            ->orderBy('started_at', 'asc')
            ->paginate();

        return Inertia::render('Bookings/Index', [
            'bookings' => BookingResource::collection($bookings),
            'permissions' => [
                'canCreateBooking' => true,
                'canUpdateBooking' => true,
                'canDeleteBooking' => true,
            ]
        ]);
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
            'started_at' => ['required', new AvailableTime('bookings', $request->only('game_provider_id'))],
            'ended_at' => ['required', new AvailableTime('bookings', $request->only('game_provider_id'))]
        ]);

        $booking = new Booking($request->input());
        $booking->game_provider_id = $gameProvider->id;
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
    public function show(Booking $booking)
    {
        return Inertia::render('Bookings/Index', [
            'booking' => new BookingResource($booking),
            'permissions' => [
                'canCreateBooking' => true,
                'canUpdateBooking' => true,
                'canDeleteBooking' => true,
            ]
        ]);
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
            'started_at' => ['sometimes', new AvailableTime('bookings', $request->only('game_provider_id'))],
            'ended_at' => ['sometimes', new AvailableTime('bookings', $request->only('game_provider_id'))]
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