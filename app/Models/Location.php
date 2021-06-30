<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locations';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

    /**
     * Get the environment that own the location
     *
     * @return BelongsTo
     */
    public function environment()
    {
        return $this->belongsTo(Environment::class, 'environment_id');
    }

    /**
     * Get all the bookings history for that provider
     *
     * @return HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'location_id')
            ->orderBy('started_at', 'asc');
    }

    /**
     * Get all the new booking history for that provider
     *
     * @return HasMany
     */
    public function nextBookings()
    {
        return $this->bookings()->next();
    }

    /**
     * Get the next booking for that provider
     *
     * @return HasMany
     */
    public function nextBooking()
    {
        return $this->hasOne(Booking::class, 'location_id')->next();
    }

    /**
     * Get the current booking for that provider
     *
     * @return HasMany
     */
    public function currentBooking()
    {
        return $this->hasOne(Booking::class, 'location_id')->current();
    }

    /**
     * Get the location queues for the application.
     */
    public function pastBookings()
    {
        return $this->hasMany(Booking::class, 'location_id')->past();
    }

    /**
     * Return only current proxable locations
     *
     * @param [type] $query
     * @return void
     */
    public function scopeProxable($query)
    {
        $query->whereHas('bookings', fn($query) => $query->current());
        $query->orWhereNotNull('default_redirect_to');
        $query->orWhereHas('environment', fn($query) => $query->whereNotNull('default_redirect_to'));

        return $query;
    }

    /**
     * return the location hostname value
     *
     * @param string $value
     * @return string
     */
    public function getDefaultRedirectToAttribute($value)
    {
        return $value ?? optional($this->environment)->default_redirect_to;
    }

    /**
     * return the location ip value
     *
     * @param string $value
     * @return string
     */
    public function getDefaultRedirectIpAttribute($value)
    {
        return $value ?? optional($this->environemnt)->default_redirect_ip;
    }

    /**
     * return the location hostname value
     *
     * @param string $value
     * @return string
     */
    public function getHostnameAttribute()
    {
        if($this->currentBooking()->exists())
        {
            return $this->currentBooking->user->hostname;
        }

        return $this->default_redirect_to;
    }

    /**
     * return the location ip value
     *
     * @param string $value
     * @return string
     */
    public function getIpAttribute()
    {
        if($this->currentBooking()->exists())
        {
            return $this->currentBooking->user->ip;
        }

        return $this->default_redirect_ip;
    }

    /**
     * return true if the location is currently processable
     *
     * @param string $value
     * @return string
     */
    public function getIsProcessableAttribute($value)
    {
        return !!$this->hostname;
    }

    /**
     * return true if user has resolve option anebled
     *
     * @param string $value
     * @return string
     */
    public function getHasResolveOptionAttribute($value)
    {
        return $this->hostname and $this->ip;
    }

    /** 
     * return the proxable url
     *
     * @param string $value
     * @return string
     */
    public function getProxyPassAttribute($value)
    {
        return "https://{$this->hostname}/{$this->match}";
    }

    /**
     * set the location match value
     *
     * @param string $value
     * @return void
     */
    public function setMatchAttribute($value)
    {
        $this->attributes['match'] = trim($value, '/');
    }
}
