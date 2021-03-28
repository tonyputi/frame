<?php

namespace App\Models;

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

        if($this->default_hostname)
        {
            return $this->default_hostname;
        }
    }

    /**
     * return the location ipv4 value
     *
     * @param string $value
     * @return string
     */
    public function getIpv4Attribute()
    {
        if($this->currentBooking()->exists())
        {
            return $this->currentBooking->user->ipv4;
        }

        if($this->default_ipv4)
        {
            return $this->default_ipv4;
        }
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
        return $this->hostname and $this->ipv4;
    }

    /**
     * return the proxable url
     *
     * @param string $value
     * @return string
     */
    public function getProxyPassAttribute($value)
    {
        return "https://{$this->hostname}/{$this->location_match}";
    }

    /**
     * set the location match value
     *
     * @param string $value
     * @return void
     */
    public function setLocationMatchAttribute($value)
    {
        $this->attributes['location_match'] = trim($value, '/');
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
     * Get the nginx configuration
     *
     * @param  string  $value
     * @return string
     */
    public function getNginxConfigAttribute($value)
    {
        $keys = ['{{ modifier }}', '{{ match }}', '{{ slot }}', '{{ hostname }}'];

        $values = [$this->location_modifier, $this->location_match, $this->location_block, $this->hostname];

        return str_replace($keys, $values, File::get(base_path('stubs/nginx.location.stub')));
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
