<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

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
     * Get the game provider that owns the game provider queue.
     */
    public function gameProvider()
    {
        return $this->belongsTo(GameProvider::class);
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

    /**
     * Get the nginx configuration
     *
     * @param  string  $value
     * @return string
     */
    public function getNginxConfigAttribute($value)
    {
        $keys = ['{{ modifier }}', '{{ match }}', '{{ hostname }}'];
        $values = [$this->gameProvider->location_modifier, $this->gameProvider->location_match, $this->host];

        return str_replace($keys, $values, File::get(base_path('stubs/nginx.location.stub')));
    }
}
