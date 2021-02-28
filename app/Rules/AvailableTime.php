<?php

namespace App\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class AvailableTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $extraConditions = [])
    {
        $this->table = $table;
        $this->extraConditions = $extraConditions;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $query = DB::table($this->table);
        $query->where($this->extraConditions);
        $query->whereRaw('? BETWEEN started_at AND ended_at', [$value]);
        // $query->whereRaw('? BETWEEN strftime("%Y-%m-%d %H:%M:00", started_at) AND strftime("%Y-%m-%d %H:%M:00", ended_at)', [$value]);

        // dd($query->get());

        return !$query->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The game provider is already reseved for :attribute.';
    }
}
