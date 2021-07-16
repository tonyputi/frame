<?php

namespace App\Providers;

use App\Models\Location;
use App\Services\ReverseProxy\ReverseProxyController;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\Environment;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->configureEnviroments();

            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });

        // THIS IS THE RIGHT WAY TO DO IT
        // Route::bind('location', function ($value) {
        //     $domain = $this->app->request->getHost();
        //
        //     // $environment = Environment::with('proxableLocations')
        //     //     ->where('domain', $domain)
        //     //     ->whereHas('proxableLocations', fn ($query) => $query->where('match', $value))
        //     //     ->firstOrFail();
        //     //
        //     // return $environment->proxableLocations->first();
        //
        //     // TODO: WE ARE NOT TAKING THE PROXABLE ONLY
        //     return Location::where('match', $value)
        //         ->whereHas('environment', fn ($query) => $query->where('domain', $domain))
        //         ->firstOrFail();
        // });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    protected function configureEnviroments()
    {
        try {
            // ANOTHER WAY TO DO IT
            // Environment::routes()->each(function($route) {
            //     Route::namespace($this->namespace)
            //         ->domain($route->domain)
            //         ->middleware($route->middleware)
            //         ->prefix($route->prefix)
            //         ->any($route->match, ReverseProxyController::class)
            //         ->name(Str::slug($route->name));
            // });

            Environment::with('proxableLocations')->each(function($environment) {
                Route::namespace($this->namespace)
                    ->domain($environment->domain)
                    ->middleware($environment->middleware)
                    ->prefix($environment->prefix)
                    ->group(fn($router) =>
                        $environment->proxableLocations->each(fn($location) =>
                            $router->any("{$location->match}/{params?}", ReverseProxyController::class)
                                ->where('params', '.*')
                                ->name(Str::slug($location->name))));
            });
        } catch(QueryException $e) {
            // we need to inform application that setup is not completed
            report($e);
        }
    }
}
