<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GenerateNginxServerConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:nginx-server-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate base nginx config';

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
        $filepath = 'nginx/server.conf';

        $keys = ['{{ app_domain }}', '{{ app_path }}'];
        $values = ['gp.videoslots.com', storage_path('app/nginx')];

        Storage::disk('local')->put($filepath, str_replace($keys, $values, File::get(base_path('stubs/nginx.server.stub'))));
        
        return 0;
    }
}
