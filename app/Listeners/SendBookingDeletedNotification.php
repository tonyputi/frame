<?php

namespace App\Listeners;

use App\Events\BookingDeleted;
use App\Models\User;
use App\Notifications\BookingCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendBookingDeletedNotification
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
     * @param  BookingDeleted  $event
     * @return void
     */
    public function handle(BookingDeleted $event)
    {
        $users = User::where('id', '<>', $event->booking->user_id)->get();
        Notification::send($users, new BookingCreatedNotification($event->booking));
    }
}
