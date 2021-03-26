<?php

namespace App\Models;

use App\Events\BookingCreated;
use App\Events\BookingDeleted;
use App\Events\BookingUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'notified_at' => 'timestamp',
        'applied_at' => 'timestamp'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_active',
    ];

    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Eloquent events.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => BookingCreated::class,
        'updated' => BookingUpdated::class,
        'deleted' => BookingDeleted::class
    ];

    /**
     * Get the game provider that owns the game provider queue.
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Get the game provider that owns the game provider queue.
     * 
     * @deprecated
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
     * Scope a query to only include active bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     * @deprecated 
     */
    public function scopeActive($query, $value = true)
    {
        if($value) {
            $query->whereNotNull('applied_at');
        } else {
            $query->whereNull('applied_at');
        }
        
        return $query;
    }

    /**
     * Scope a query to only include available/queable bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('ended_at', '>=', $this->freshTimestamp());
    }

    /**
     * Scope a query to only include current bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCurrent($query)
    {
        return $query->whereRaw("? BETWEEN started_at AND ended_at", [$this->freshTimestamp()]);
    }

    /**
     * Scope a query to only include expired bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpired($query)
    {
        return $query->where('ended_at', '<', $this->freshTimestamp());
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

    /**
     * Scope a query to only include notified bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  boolean  $notified
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotified($query, $notified = true)
    {
        $query->when($notified, fn($query) => $query->whereNotNull('notified_at'), fn($query) => $query->whereNull('notified_at'));
    }

    /**
     * Get computed is_active attribute
     *
     * @return boolean
     */
    public function getIsActiveAttribute()
    {
        return optional($this->started_at)->isPast() and optional($this->ended_at)->isFuture();
    }
}
