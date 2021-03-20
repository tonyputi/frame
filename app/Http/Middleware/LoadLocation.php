<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Location;
use Illuminate\Http\Request;

class LoadLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->location = Location::where('location_match', $request->route()->uri())->firstOrFail();
        
        return $next($request);
    }
}
