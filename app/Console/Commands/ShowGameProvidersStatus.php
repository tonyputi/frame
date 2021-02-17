<?php

namespace App\Console\Commands;

use App\Models\GameProvider;
use Illuminate\Console\Command;

class ShowGameProvidersStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game-providers:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show game providers status';

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
        $collection = GameProvider::with('gameActiveProviderQueue')
            ->get(['id', 'name', 'location_modifier', 'location_match']);

        $collection = GameProvider::with('gameActiveProviderQueue')
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
           ['ID', 'Name', 'Modifier', 'Match', 'Host', 'Started at', 'Ended at'],
           $collection->toArray()
        );

        // file_put_contents('/tmp/nginx.reload', $this->showAsNginxConfig($collection));

        // $this->info($this->showAsNginxConfig($collection));
    }

    protected function showAsNginxConfig($collection)
    {
        return view('nginx.casino-providers', compact('collection'));
    }
}
