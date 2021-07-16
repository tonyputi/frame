<?php

namespace App\Services\ReverseProxy;

use App\Models\Location;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class ReverseProxyController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Call the proxy pass method of the request
     *
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request, Location $location)
    {
        // computing match removing params from path
        // $match = Str::of($request->path())->remove($request->route('params'))->trim('/');
        $match = Str::of($request->route()->uri())->remove('{params?}')->trim('/');

        $location = Location::with('environment')
            ->where('match', $match)
            ->firstOrFail();

        $proxy_pass = trim($location->proxy_pass, '/');
        if ($request->route('params')) {
           $proxy_pass .= '/' . $request->route('params');
        }

        return $request->proxy($proxy_pass)
            ->when(!!$location->ip, fn($proxy) => $proxy->resolve($location->hostname, $location->ip, $request->getPort()))
            ->pass();
    }

    /**
     * Call the proxy pass method of the request
     *
     * @param Request $request
     * @return void
     */
    // public function __invoke(Request $request, Location $location)
    // {
    //     $location = Location::with('environment')
    //         ->where('match', $request->route()->uri())
    //         ->firstOrFail();
    //
    //     return $request->proxy($location->proxy_pass)
    //         ->when(!!$location->ip, fn($proxy) => $proxy->resolve($location->hostname, $location->ip, $request->getPort()))
    //         ->pass();
    // }
}
