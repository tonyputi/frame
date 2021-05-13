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
     * Get the location that owns the location queue.
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
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
        return $query->when($value, fn($query) => $query->whereNotNull('applied_at'), fn($query) => $query->whereNull('applied_at'));
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
        return $query->when($notified, fn($query) => $query->whereNotNull('notified_at'), fn($query) => $query->whereNull('notified_at'));
    }

    /**
     * Scope a query to only include next/queable bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNext($query)
    {
        return $query->where('ended_at', '>=', $this->freshTimestamp())
            ->orderBy('started_at', 'asc');
    }

    /**
     * Scope a query to only include current bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCurrent($query)
    {
        return $query->whereRaw('? BETWEEN started_at AND ended_at', [$this->freshTimestamp()])
            ->orderBy('started_at', 'asc');
    }

    /**
     * Scope a query to only include past bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePast($query)
    {
        return $query->where('ended_at', '<', $this->freshTimestamp())
            ->orderBy('started_at', 'asc');
    }

    /**
     * Scope a query to only include active bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $value)
    {
        return $query->where(fn($query) =>
            $query->whereHas('user', fn($query) => $query->where('name', 'like', "%{$value}%"))
                ->orWhereHas('location', fn($query) => $query->where('name', 'like', "%{$value}%")));
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
