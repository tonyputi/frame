<?php

namespace App\Providers;

use App\Events\BookingCreated;
use App\Events\BookingDeleted;
use App\Events\BookingUpdated;
use App\Listeners\SendBookingCreatedNotification;
use App\Listeners\SendBookingUpdatedNotification;
use App\Listeners\SendBookingDeletedNotification;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        BookingCreated::class => [
            SendBookingCreatedNotification::class
        ],
        BookingUpdated::class => [
            SendBookingUpdatedNotification::class
        ],
        BookingDeleted::class => [
            SendBookingDeletedNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
