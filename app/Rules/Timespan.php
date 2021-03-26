<?php

namespace App\Rules;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rules\DatabaseRule;

class Timespan implements Rule
{
    use DatabaseRule;

    /**
     * The table to be used by the rule
     *
     * @var [type]
     */
    protected $table;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $columns = ['started_at', 'ended_at'])
    {
        $this->table = $this->resolveTableName($table);
        $this->columns = $columns;
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
        dump($this->wheres);

        $value = Carbon::parse($value)->toDateTimeString();

        $query = DB::table($this->table);
        // $query->where($this->extraConditions);
        // $query->where('location_id', 1);
        $query->whereRaw('? BETWEEN ? AND ?', [$value, $this->columns[0], $this->columns[1]]);

        return !$query->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
