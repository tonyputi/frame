<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Client\PendingRequest;
use App\Services\ReverseProxy\ReverseProxy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // create macro to handle proxy pass from request
        Request::macro('proxy', fn($uri) => ReverseProxy::createFromRequest($this, $uri));
        Request::macro('proxypass', fn(string $uri, array $options = []) => $this->proxy($uri)->pass($options));
    }
}
