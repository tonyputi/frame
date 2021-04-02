<?php

namespace App\Providers;

use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\ReverseProxyController;
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
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            
            $this->configureEnviroments();
        });
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
            Environment::each(function($environment) {
                Route::namespace($this->namespace)
                    ->domain($environment->domain)
                    ->middleware($environment->middleware)
                    ->prefix($environment->prefix)
                    ->group(function($router) use($environment) {
                        $this->configureLocations($environment->processableLocations);
                        // $environment->locations()->with('currentBooking')->each(function($location) use($router) {
                        //     if($location->isProcessable) {
                        //         $router->any($location->match, ReverseProxyController::class)
                        //             ->name(Str::slug($location->name));
                        //     }
                        // });
                    });
            });
        } catch(QueryException $e) {
            // we need to inform application that setup is not completed
            report($e);
        }
    }

    /**
     * Generate dynamic locations as routes
     *
     * @return void
     */
    protected function configureLocations($locations)
    {
        $locations->each(function($location) {
            if($location->isProcessable) {
                Route::any($location->match, ReverseProxyController::class)
                    ->name(Str::slug($location->name));
            }
        });   
    }
}
