<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameProvider extends Model
{
    use HasFactory;

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
