<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use App\Notifications\BookingAppliedNotification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class Heartbeat implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 1. get all the bookings that will be processed in the next 5 minutes
        // 2. foreach booking send notification to the user regarding the next booking

        // 1. get all the new unnotified bookings
        // 2. notify all the users that are not own the booking regarding the new booking

        Booking::current()->notified(false)->each(function($booking) {
            User::each(fn($user) => $user->notify(new BookingAppliedNotification($booking)));
            $booking->notified_at = Carbon::now();
            $booking->save();
        });
    }
}
