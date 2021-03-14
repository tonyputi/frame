<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

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
        return $this->bookings()
            ->available();
    }

    /**
     * Get the next booking for that provider
     *
     * @return HasMany
     */
    public function nextBooking()
    {
        return $this->hasOne(Booking::class, 'location_id')
            ->available()
            ->orderBy('started_at', 'asc');
    }

    /**
     * Get the current booking for that provider
     *
     * @return HasMany
     */
    public function currentBooking()
    {
        return $this->hasOne(Booking::class, 'location_id')
            ->current()
            ->orderBy('started_at', 'asc');
    }

    /**
     * Get the game provider queues for the application.
     */
    public function expiredBookings()
    {
        return $this->hasMany(Booking::class, 'location_id')
            ->expired()
            ->orderBy('started_at', 'asc');
    }

    /**
     * return location block value always
     *
     * @param string $value
     * @return string
     */
    public function getLocationBlockAttribute($value)
    {
        return $value ?? $this->defaultLocationBlock();
    }

    /**
     * set location block value
     *
     * @param string $value
     * @return string
     */
    // public function setLocationBlockAttribute($value)
    // {
    //     $this->attributes['location_block'] = $value ?? $this->defaultLocationBlock();
    // }

    /**
     * Get the nginx configuration
     *
     * @param  string  $value
     * @return string
     */
    public function getNginxConfigAttribute($value)
    {
        $keys = ['{{ modifier }}', '{{ match }}', '{{ slot }}', '{{ host }}'];

        if($this->currentBooking()->exists())
        {
            $values = [$this->location_modifier, $this->location_match, $this->location_block, $this->currentBooking->user->host];

            return str_replace($keys, $values, File::get(base_path('stubs/nginx.location.stub')));
        }

        if($this->default_host)
        {
            $values = [$this->location_modifier, $this->location_match, $this->location_block, $this->default_host];

            return str_replace($keys, $values, File::get(base_path('stubs/nginx.location.stub')));
        }
    }

    /**
     * Get the default nginx location block configuration
     *
     * @param  string  $value
     * @return string
     */
    public static function defaultLocationBlock()
    {
        return <<<'EOD'
        auth_basic off;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_redirect off;
        EOD;
    }
}
