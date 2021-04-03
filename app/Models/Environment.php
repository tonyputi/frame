<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Environment extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

    /**
     * Get all the locations that belongs to the enviroment
     *
     * @return HasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Get all the proxable locations that belongs to the enviroment
     *
     * @return HasMany
     */
    public function proxableLocations()
    {
        return $this->locations()->proxable();
    }

    /**
     * scope query to return only current proxable routes.
     * it is perform all the logic on the database side.
     *
     * @param [type] $query
     * @return void
     */
    public function scopeRoutes($query)
    {
        $query->select(
            'environments.middleware',
            'environments.domain',
            'environments.prefix',
            'locations.name', 
            'locations.match',
            DB::raw('CASE
                WHEN users.hostname IS NOT NULL THEN users.hostname
                WHEN locations.default_redirect_to IS NOT NULL THEN locations.default_redirect_to
                WHEN environments.default_redirect_to IS NOT NULL THEN environments.default_redirect_to
            END AS hostname'),
            DB::raw('CASE
                WHEN users.ipv4 IS NOT NULL THEN users.ipv4
                WHEN locations.default_redirect_ipv4 IS NOT NULL THEN locations.default_redirect_ipv4
                WHEN environments.default_redirect_ipv4 IS NOT NULL THEN environments.default_redirect_ipv4
            END AS ipv4'));
        $query->join('locations', 'locations.environment_id', '=', 'environments.id');
        $query->leftJoin('bookings', 'bookings.location_id', '=', 'locations.id');
        $query->leftJoin('users', 'bookings.user_id', '=', 'users.id');
        $query->where(function($query) {
            $query->whereNotNull('users.hostname');
            $query->WhereRaw('? BETWEEN started_at AND ended_at', [$this->freshTimestamp()]);
        });
        $query->orWhereNotNull('locations.default_redirect_to');
        $query->orWhereNotNull('environments.default_redirect_to');

        return $query;
    }
}
