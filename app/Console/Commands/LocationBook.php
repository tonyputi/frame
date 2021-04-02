<?php

namespace App\Console\Commands;

use DatePeriod;
use DateInterval;
use App\Models\User;
use App\Models\Booking;
use App\Models\Location;
use Carbon\CarbonPeriod;
use App\Rules\AvailableTime;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

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
        });
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = $this->getUser();
        $location = $this->getLocation();
        $date = $this->getDate();
        $started_at = $this->getStart($date);
        $ended_at = $this->getEnd($date);

        // we need to validate if booking collide with others
        $validator = Validator::make(compact('started_at', 'ended_at'), [
            'started_at' => ['date', 'before:ended_at', new AvailableTime('bookings', ['location_id' => $location->id])],
            'ended_at' => ['date', 'after:started_at', new AvailableTime('bookings', ['location_id' => $location->id])]
        ]);

        if ($validator->fails()) {
            foreach($validator->errors() as $error) {
                $this->error($error);
            }
            
            return -1;
        }

        $booking = Booking::create([
            'performed_by' => $user->id,
            'user_id' => $user->id,
            'location_id' => $location->id,
            'started_at' => $started_at,
            'ended_at' => $ended_at
        ]);

        $this->info("Booking location '{$location->name}' for user '{$user->name}' on date '{$date}' starting at '{$started_at}' and ending at '{$ended_at}'");

        return 0;
    }

    /**
     * Get user by id or email
     *
     * @return User
     */
    protected function getUser()
    {
        $query = User::query();

        if($this->option('user')) {
            return $query->where(function($query) {
                $query->where('id', $this->option('user'));
                $query->orWhere('email', $this->option('user'));
            })->firstOrFail();
        } else {
            $choices = User::pluck('email')->toArray();
            $email = $this->choice('Which user?', $choices, 0, null, false);

            return $query->where('email', $email)->firstOrFail();
        }
    }

    /**
     * Get location by id or name
     *
     * @return Location
     */
    protected function getLocation()
    {
        $query = Location::query();

        if($this->option('location')) {
            return $query->where(function($query) {
                $query->where('id', $$this->option('location'));
                $query->orWhere('name', $this->option('location'));
            })->firstOrFail();
        } else {
            $choices = Location::pluck('name')->toArray();
            $name = $this->choice('Which user?', $choices, 0, null, false);

            return $query->where('name', $name)->firstOrFail();
        }

    }

    protected function getDate()
    {
        if($this->option('date')) {
            return Carbon::parse($this->option('date'));
        } else {
            $range = Carbon::dateRange(today(), today()->addDays(7))
                ->map(fn($date) => $date->toDateString());
            return $this->anticipate('What date? YYYY-MM-DD', $range);
        }
    }

    protected function getStart($date)
    {
        $time = $this->option('start');

        if(!$time) {
            $range = Carbon::dateRange(now(), today()->addDay(), 'PT1M')
                ->map(fn($date) => $date->format('H:i'));

            $time = $this->anticipate('What time you want to start? HH:MM', $range);
        }

        return Carbon::parse($date . ' ' . $time);
    }

    protected function getEnd($date)
    {
        $time = $this->option('end');

        if(!$time) {
            $range = Carbon::dateRange(now()->addMinutes(15), today()->addDay(), 'PT1M')
                ->map(fn($date) => $date->format('H:i'));

            $time = $this->anticipate('What time you want to end? HH:MM', $range);
        }

        return Carbon::parse($date . ' ' . $time);
    }
}
