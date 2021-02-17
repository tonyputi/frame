<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameProvider extends Model
{
    use HasFactory;

    /**
     * Get the game provider queues for the application.
     */
    public function gameProviderQueues()
    {
        return $this->hasMany(GameProviderQueue::class);
    }

   /**
     * Get the game provider queues for the application.
     */
    public function gameActiveProviderQueue()
    {
        return $this->hasOne(GameProviderQueue::class)
            ->where('is_active', true)
            ->withDefault();
    }

    /**
     * Get the game provider queues for the application.
     */
    public function expiredGameProviderQueue()
    {
        return $this->hasMany(GameProviderQueue::class)
            ->where('is_active', true)
            ->where('ended_at', '<', $this->freshTimestamp());
    }

    /**
     * Get the game provider queues for the application.
     */
    //public function candidateGameProviderQueue()
    //{
    //    return $this->hasMany(GameProviderQueue::class)
    //        ->where('is_active', false)
    //        ->where('started_at', '<=', now)
    //        ->where('ended_at', '>=', now);
    //}
}
