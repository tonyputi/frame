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
            $request->headers->remove('host');
            $request->headers->set('x-real-ip', $request->ip());
            $request->headers->set('x-forwarded-for', $request->ips());
            $request->headers->set('x-forwarded-host', $request->getHost());
            $request->headers->set('x-forwarded-proto', $request->getScheme());

            $this->withHeaders($request->header());

            if($request->getContent()) {
                $this->withBody($request->getContent(), $request->header('content-type'));
                $options[$this->bodyFormat] = $this->pendingBody;
            }

            logger('request', [
                'method' => $request->method(),
                'route' => $request->route()->uri(),
                'headers' => $request->header(),
                'query' => $request->query(),
                'content' => $request->getContent()
            ]);

            return $this->send($request->method(), $url, $options);
        });
    }
}
