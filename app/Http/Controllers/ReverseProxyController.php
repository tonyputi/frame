<?php

// 2305949
namespace App\Http\Controllers;

use App\Services\ReverseProxy\ReverseProxy;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReverseProxyController extends Controller
{
    /**
     * Call the proxy pass method of the request
     *
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request, Location $location)
    {
        $base_uri = "{$request->getScheme()}://{$location->hostname}";

        return $request->proxypass($base_uri, []);

        // $location = Location::with('environment')->where('match', $request->route()->uri())->firstOrFail();
        // return $request->proxypass($location->proxy_pass);

        // return $this->callStable($request);
    }

    protected function callStable(Request $request)
    {
        $location = Location::where('match', $request->route()->uri())->firstOrFail();

        $url = $location->proxy_pass;
        if($request->getQueryString()) {
            $url.= "?{$request->getQueryString()}";
        }

        $options = [];
        if($location->hasResolveOption){
            $options['curl'] = [
                CURLOPT_RESOLVE => ["{$location->hostname}:{$request->getPort()}:{$location->ipv4}"]
            ];
        }

        return Http::proxyPass($request, $url, $options);
    }

    protected function callOld(Request $request)
    {
        $location = Location::where('match', $request->route()->uri())->firstOrFail();

        if($request->getQueryString()) {
            $location->proxy_pass.= "?{$request->getQueryString()}";
        }

        $proxy = new ReverseProxy($request, $location->proxy_pass);
        
        return $proxy->send();
    }
}
