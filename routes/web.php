<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EnvironmentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReverseProxyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['domain' => 'frame.videoslots.com'], function() {
    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });

    Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
        Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
        Route::resource('environments', EnvironmentController::class);
        Route::post('environments/duplicate', [EnvironmentController::class, 'duplicate'])->name('environments.duplicate');

        Route::resource('environments.locations', LocationController::class)->shallow();
        Route::resource('locations.bookings', BookingController::class)->shallow();

        Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
        Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::put('bookings/{booking}/release', [BookingController::class, 'release'])->name('bookings.release');
    });
});

// FIND A WAY TO PUT THIS MANNER TO ROUTE SERVICE PROVIDER
//Route::group(['prefix' => 'proxy'], function () {
//    Route::get('{location:match}', ReverseProxyController::class)->where('location', '.*');
//});
