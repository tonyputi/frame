<?php

namespace App\Listeners;

use App\Events\BookingDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        //
    }
}
