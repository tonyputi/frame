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
    public function __construct($extraConditions = [])
    {
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
        $query = DB::table('game_provider_queues');
        $query->where($this->extraConditions);
        $query->whereRaw('? BETWEEN started_at AND ended_at', [$value]);

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
