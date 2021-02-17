<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameProviderQueue extends Model
{
    use HasFactory;

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
}
