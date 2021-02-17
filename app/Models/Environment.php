<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Environment extends Model
{
    use HasFactory;

    /**
     * Get the game provider queues for the application.
     */
    public function gameProviderQueues()
    {
        return $this->hasMany(GameProviderQueue::class);
    }
}
