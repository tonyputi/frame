<?php

namespace App\Console\Commands;

use App\Models\CasinoProvider;
use Illuminate\Console\Command;

class ShowCasinoProvidersStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'casino:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show casino providers status';

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
        $collection = CasinoProvider::all(['id', 'name', 'slug', 'host']);

         $this->table(
             ['ID', 'Name', 'Slug', 'Host'],
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
