<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use App\Notifications\BookingApplied;
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
        Booking::current()->notified(false)->each(function($booking) {
            User::each(fn($user) => $user->notify(new BookingApplied($booking)));
            $booking->notified_at = Carbon::now();
            $booking->save();
        });
    }
}
