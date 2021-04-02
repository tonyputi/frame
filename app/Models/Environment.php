<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany(Location::class, 'environment_id');
    }

    /**
     * Get all the locations that belongs to the enviroment
     *
     * @return HasMany
     */
    public function processableLocations()
    {
        return $this->locations()->with('currentBooking');
    }
}
