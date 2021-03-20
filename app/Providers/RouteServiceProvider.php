<?php

namespace App\Providers;

use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\LocationController;
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

            $this->configureLocations();
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

    /**
     * Generate dynamic locations as routes
     *
     * @return void
     */
    protected function configureLocations()
    {
        try {
            Route::namespace($this->namespace)
                ->middleware(config('frame.middleware'))
                ->domain(config('frame.domain'))
                ->prefix(config('frame.prefix'))
                ->group(function() {
                    Location::with('currentBooking.user')->each(function($location) {
                        // $location->routable or $location->configurable
                        if($location->host) {
                            Route::any($location->location_match, LocationController::class)
                                ->name(Str::slug($location->name));
                        }
                    });
                });
        } catch(QueryException $e) {
            // we need to inform application that setup is not completed
            report($e);
        }
        
    }
}
