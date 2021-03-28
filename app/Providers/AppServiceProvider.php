<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Client\PendingRequest;

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
        // TODO: this is for the ones using MySQL
        Schema::defaultStringLength(191);

        PendingRequest::macro('proxyPass', function($request, $url, $options = []) {
            $this->withHeaders($request->header());

            if($request->getContent()) {
                $this->withBody($request->getContent(), $request->header('content-type'));
            }

            return $this->send($request->method(), $url, $options);
        });
    }
}
