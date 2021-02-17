<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameProviderQueue extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

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
     * Set host and make sure that is stored as lower string
     *
     * @param $value
     */
    public function setHostAttribute($value)
    {
        $this->attributes['host'] = strtolower($value);
    }
}
