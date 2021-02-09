<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    /**
     * Get the nginx configuration
     *
     * @param  string  $value
     * @return string
     */
    public function getConfigAttribute($value)
    {
        $keys = ['{{ modifier }}', '{{ match }}'];
        $values = [$this->modifier, $this->match];

        return str_replace($keys, $values, File::get(base_path('stubs/nginx.location.stub')));
    }
}
