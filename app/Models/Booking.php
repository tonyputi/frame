<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'applied_at' => 'datetime'
    ];

    /**
     * Get the environment that owns the game provider queue.
     */
    public function environment()
    {
        return $this->belongsTo(Environment::class);
    }

    /**
     * Get the application that owns the game provider queue.
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the game provider that owns the game provider queue.
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Get the game provider that owns the game provider queue.
     */
    public function gameProvider()
    {
        return $this->belongsTo(GameProvider::class, 'location_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include current bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCurrent($query)
    {
        return $query->whereRaw("? BETWEEN started_at AND ended_at", [$this->freshTimestamp()->toIso8601String()]);
    }

    /**
     * Scope a query to only include available/queable bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('ended_at', '>=', $this->freshTimestamp()->toIso8601String());
    }

    /**
     * Scope a query to only include expired bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpired($query)
    {
        return $query->where('ended_at', '<', $this->freshTimestamp()->toIso8601String());
    }

    /**
     * Scope a query to only include active bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query, $value = true)
    {
        // return $query->where('is_active', $value);
        if($value) {
            $query->whereNotNull('applied_at');
        } else {
            $query->whereNull('applied_at');
        }
        
        return $query;
    }

    /**
     * Scope a query to only include active bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $value)
    {
        $query->whereHas('user', fn($query) => $query->where('name', 'like', "%{$value}%"));
        $query->orWhereHas('gameProvider', fn($query) => $query->where('name', 'like', "%{$value}%"));

        return $query;
    }

    public function getIsActiveAttribute()
    {
        return $this->started_at->isPast() and $this->ended_at->isFuture();
    }
}
