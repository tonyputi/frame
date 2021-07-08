<?php

namespace App\Listeners;

use App\Events\BookingUpdated;
use App\Models\User;
use App\Notifications\BookingCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendBookingUpdatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BookingUpdated  $event
     * @return void
     */
    public function handle(BookingUpdated $event)
    {
        $users = User::where('id', '<>', $event->booking->user_id)->get();
        Notification::send($users, new BookingCreatedNotification($event->booking));
    }
}
