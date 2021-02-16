<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasinoProvider extends Model
{
    use HasFactory;

    /**
     * Set hostname and make sure that is stored as lower string
     *
     * @param $value
     */
    public function setHostnameAttribute($value)
    {
        $this->attributes['hostname'] = strtolower($value);
    }
}
