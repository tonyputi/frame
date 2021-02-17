<?php

namespace App\Console\Commands;

use App\Models\GameProvider;
use App\Models\GameProviderQueue;
use Illuminate\Console\Command;

class ShowGameProviderNginxConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game-providers:config';

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
        GameProviderQueue::where('is_active', true)->each(function($resource) {
            $this->line($resource->nginxConfig);
        });

        return 0;
    }
}
