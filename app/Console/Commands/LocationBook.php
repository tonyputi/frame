<?php

namespace App\Console\Commands;

use DatePeriod;
use DateInterval;
use App\Models\User;
use App\Models\Booking;
use App\Models\Location;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class LocationBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:book
        {--u|user= : The user that want to book the location}
        {--l|location= : Specify the location by name}
        {--d|date= : Specify the booking date}
        {--s|start= : Specify the booking start time}
        {--e|end= : Specify the booking end time}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Book a location for a certain period of time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        Carbon::macro('dateRange', function ($start, $end, $unit = 'P1D') {
            return new Collection(CarbonPeriod::create($start, $end, $unit));
            // return new Collection(new DatePeriod($start, new DateInterval('P1D'), $end));
        });
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if($this->option('user')) {
            $user = $this->getUserByIdOrEmail($this->option('user'));
        } else {
            $user = $this->getUserByChoice();
        }

        if($this->option('location')) {
            $location = $this->getLocationByIdOrName($this->option('location'));
        } else {
            $location = $this->getLocationByChoice();
        }

        if($this->option('date')) {
            $date = Carbon::parse($this->option('date'));
        } else {
            $range = Carbon::dateRange(today(), today()->addDays(7))
                ->map(fn($date) => $date->toDateString());
            $date = $this->anticipate('What date? YYYY-MM-DD', $range);
        }

        if($this->option('start')) {
            $start = Carbon::parse($date . ' ' . $this->option('start'));
        } else {
            $range = Carbon::dateRange(now(), today()->addDay(), 'PT1M')
                ->map(fn($date) => $date->format('H:i'));
            $start = $this->anticipate('What time you want to start? HH:MM', $range);
        }

        if($this->option('start')) {
            $end = Carbon::parse($date . ' ' . $this->option('end'));
        } else {
            $range = Carbon::dateRange(now()->addMinutes(15), today()->addDay(), 'PT1M')
                ->map(fn($date) => $date->format('H:i'));
            $end = $this->anticipate('What time you want to start? HH:MM', $range);
        }

        // we need to validate if booking collide with others

        $booking = Booking::create([
            'performed_by' => $user->id,
            'user_id' => $user->id,
            'location_id' => $location->id,
            'started_at' => $start,
            'ended_at' => $end
        ]);

        $this->info("Booking location '{$location->name}' for user '{$user->name}'");

        return 0;
    }

    /**
     * Get user by id or email
     *
     * @param string $value
     * @return User
     */
    protected function getUserByIdOrEmail(string $value)
    {
        return User::where(function($query) use($value) {
            $query->where('id', $value);
            $query->orWhere('email', $value);
        })->firstOrFail();
    }

    /**
     * Get user by multiple choice
     *
     * @return User
     */
    protected function getUserByChoice()
    {
        $choices = User::pluck('email')->toArray();
        $email = $this->choice('Which user?', $choices, 0, null, false);

        return User::where('email', $email)->firstOrFail();
    }

    /**
     * Get location by id or name
     *
     * @param string $value
     * @return Location
     */
    protected function getLocationByIdOrName(string $value)
    {
        return Location::where(function($query) use($value) {
            $query->where('id', $value);
            $query->orWhere('name', $value);
        })->firstOrFail();
    }

    /**
     * Get location by multiple choice
     *
     * @return Location
     */
    protected function getLocationByChoice()
    {
        $choices = Location::pluck('name')->toArray();
        $name = $this->choice('Which user?', $choices, 0, null, false);

        return Location::where('name', $name)->firstOrFail();
    }
}
