<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Location;
use Illuminate\Console\Command;

class DumpConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dump:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // $collection = Location::all()->map(function($resource) {
        //     return [
        //         'name'       => $resource->name,
        //         'modifier'   => $resource->modifier,
        //         'match'      => $resource->match,
        //         'is_enabled' => $resource->is_enabled,
        //         'config'     => $resource->config,
        //     ];
        // });

        // $this->table(
        //     ['Name', 'Modifier', 'Match', 'Enabled', 'Config'],
        //     $collection->toArray()
        // );

        $users = User::all(['name', 'email', 'hostname', 'ip4addr']);

        $this->table(
            ['name', 'email', 'hostname', 'ip'],
            $users->toArray()
        );

        // $collection = Location::where('is_enabled', true)->get();
        // foreach($collection as $location) {
        //     // $this->info($location->config);
        //     $this->info(view('nginx.location', $location));
        // }
    }
}
