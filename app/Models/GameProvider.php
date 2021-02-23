<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameProvider extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'location_modifier', 'location_match'
    ];

    /**
     * Get the game provider queues for the application.
     */
    public function gameProviderQueues()
    {
        return $this->hasMany(GameProviderQueue::class)
            ->orderBy('started_at', 'desc');
    }

    /**
     * Get the game provider queues for the application.
     */
    public function candidateGameProviderOnQueue()
    {
        return $this->hasOne(GameProviderQueue::class)
            ->orderBy('started_at', 'desc')
            ->with('user')
            ->withDefault();
    }

    /**
     * Get the game provider queues for the application.
     */
    public function activeGameProviderOnQueue()
    {
        return $this->hasOne(GameProviderQueue::class)
            ->where('is_active', true)
            ->withDefault();
    }

    /**
     * Get the game provider queues for the application.
     */
    // public function expiredGameProviderQueue()
    // {
    //     return $this->hasMany(GameProviderQueue::class)
    //         ->where('is_active', true)
    //         ->where('ended_at', '<', $this->freshTimestamp());
    // }

    /**
     * Get the game provider queues for the application.
     */
    // public function candidateGameProviderQueue()
    // {
    //    return $this->hasMany(GameProviderQueue::class)
    //        ->where('is_active', false)
    //        ->where('started_at', '<=', $this->freshTimestamp())
    //        ->where('ended_at', '>=', $this->freshTimestamp());
    // }
}
