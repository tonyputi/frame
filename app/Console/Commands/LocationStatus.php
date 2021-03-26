<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\GameProvider;
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

        if(config('frame.stack') != 'nginx') {
            $this->hidden = true;
        }
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
                    'location_modifier' => $resource->location_modifier,
                    'location_match' => $resource->location_match,
                    'host' => $resource->gameActiveProviderQueue->host,
                    'started_at' => $resource->gameActiveProviderQueue->started_at,
                    'ended_at' => $resource->gameActiveProviderQueue->ended_at,
                ];
            });

        $this->table(
           ['ID', 'Name', 'Modifier', 'Match', 'Hostname', 'Started at', 'Ended at'],
           $collection->toArray()
        );
    }
}
