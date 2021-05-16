<?php

namespace App\Console\Commands;

use App\Models\Location;
use Illuminate\Console\Command;

class LocationStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show location status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $collection = Location::with('currentBooking.user')
            ->get()
            ->map(function($resource) {
                return [
                    'id' => $resource->id,
                    'name' => $resource->name,
                    'environment' => $resource->environment->name,
                    'match' => $resource->match,
                    'host' => $resource->hostname,
                    'ip' => $resource->ip,
                    'started_at' => optional($resource->currentBooking)->started_at,
                    'ended_at' => optional($resource->currentBooking)->ended_at,
                ];
            });

        $this->table(
           ['ID', 'Name', 'Environment', 'Match', 'Hostname', 'IP', 'Started at', 'Ended at'],
           $collection->toArray()
        );
    }
}
