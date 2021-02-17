<?php

use App\Http\Controllers\EnvironmentController;
use App\Http\Controllers\GameProviderController;
use App\Http\Controllers\GameProviderQueuesController;
use App\Http\Controllers\GameProvidersController;
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
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/reservation', [GameProviderQueuesController::class, 'index'])->name('reservations.index');
    Route::get('/game-providers', [GameProviderController::class, 'index'])->name('game_provider.index');
    Route::get('/game-provider/{id}', [GameProviderController::class, 'show'])->name('game_provider.show');
    Route::post('/game-provider/create', [GameProviderController::class, 'store'])->name('game_provider.store');
    Route::put('/game-provider/{id}/update', [GameProviderController::class, 'update'])->name('game_provider.update');
    Route::delete('/game-provider/{id}/delete',[GameProviderController::class, 'delete'])->name('game_provider.destroy');

    Route::get('/game-providers-queue', [GameProviderQueuesController::class, 'index'])->name('game_provider_queue.index');
    Route::get('/game-provider-queue/{id}', [GameProviderQueuesController::class, 'show'])->name('game_provider_queue.show');
    Route::post('/game-provider-queue/create', [GameProviderQueuesController::class, 'store'])->name('game_provider_queue.store');
    Route::put('/game-provider-queue/{id}/update', [GameProviderQueuesController::class, 'update'])->name('game_provider_queue.update');
    Route::delete('/game-provider-queue/{id}/delete',[GameProviderQueuesController::class, 'delete'])->name('game_provider_queue.destroy');

    Route::get('/environments', [EnvironmentController::class, 'index'])->name('environment.index');
    Route::get('/environment/{id}', [EnvironmentController::class, 'show'])->name('environment.show');
    Route::post('/environment/create', [EnvironmentController::class, 'store'])->name('environment.store');
    Route::put('/environment/{id}/update', [EnvironmentController::class, 'update'])->name('environment.update');
    Route::delete('/environment/{id}/delete',[EnvironmentController::class, 'delete'])->name('environment.destroy');

    Route::put('/user/miscellanea/{id}', [UserMiscellanea::class, 'update'])->name('user_miscellanea.update');

});

