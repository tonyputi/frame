<?php

namespace App\Http\Controllers;

use App\Models\Environment;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Dashboard::class, 'dashboard');
    }

    /**
     * Return the dashboard
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('Dashboard', [
            'environments' => Environment::pluck('id', 'name')
        ]);
    }
}
