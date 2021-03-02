<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    /**
     * Get the game provider queues for the application.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
