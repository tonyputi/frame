<?php

namespace App\Console\Commands;

use Illuminate\Database\Eloquent\Collection;
use App\Models\GameProvider;
use Illuminate\Console\Command;

class AttachGameProviderToHost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game-providers:attach
        {hostname : The hostname to redirect to game provider requests. ie vs1234.videoslots.com}
        {--p|provider= : Specify the game provider by id or name}
        {--d|detach : When specified the hostname gonna be detached from game provider}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Redirect game provider to specified hostname';

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
     * @return void
     */
    public function handle()
    {
        $hostname = $this->argument('hostname');

        if($this->option('provider')) {
            $collection = $this->getProvidersByName($this->option('provider'));
        } else {
            $collection = $this->getProvidersByChoice();
        }

        $collection->each(function($resource) use($hostname) {
            if($this->option('detach')) {
                $resource->host = NULL;
                $this->info("<<< Stop redirecting {$resource->name} to {$hostname}");
            } else {
                $resource->host = $hostname;
                $this->info(">>> Start redirecting {$resource->name} to {$hostname}");
            }

            $resource->save();
        });
    }


    /**
     * Get providers by choice
     *
     * @return Collection
     */
    protected function getProvidersByChoice()
    {
        $choices = GameProvider::orderBy('id')
            ->get()
            ->mapWithKeys(fn($resource) => [$resource->id => $resource->name]);

        $choice = $this->anticipate('Which provider?', $choices);
        $collection = $this->getProvidersByName($choice);

        if(!$collection->count()) {
            $this->error("No match found!");
            return 1;
        }

        return $collection;
    }

    /**
     * Get providers by name
     *
     * @param string $name
     * @return Collection
     */
    protected function getProvidersByName(string $name = null)
    {
        return GameProvider::where('name', 'like', "{$name}%")->get();
    }
}
