<?php

namespace App\Services\ReverseProxy;

use App\Models\Location;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
        // $base_uri = "{$request->getScheme()}://{$location->hostname}";
        // return $request->proxypass($base_uri, []);

        $location = Location::with('environment')
            ->where('match', $request->route()->uri())
            ->firstOrFail();

        return $request->proxy($location->proxy_pass)
            ->when(!!$location->ip, fn($proxy) => $proxy->resolve($location->hostname, $location->ip, $request->getPort()))
            ->pass();
    }
}
