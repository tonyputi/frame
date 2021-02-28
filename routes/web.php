<?php

use App\Http\Controllers\EnvironmentController;
use App\Http\Controllers\GameProviderController;
use App\Http\Controllers\GameProviderQueuesController;
use App\Http\Controllers\UserMiscellanea;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    Route::resource('applications', ApplicationController::class);
    Route::resource('game-providers', GameProviderController::class);
    Route::resource('game-provider-queues', GameProviderQueueController::class);
});

