<?php

namespace App\Http\Controllers;

// use App\Services\ReverseProxy\ReverseProxy;
use App\Models\Location;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ReverseProxyController extends Controller
{
    public function __invoke(Request $request)
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

        // OLD STUFF

        // if($request->getQueryString()) {
        //     $location->proxy_pass.= "?{$request->getQueryString()}";
        // }

        // $proxy = new ReverseProxy($request, $location->proxy_pass);
        
        // return $proxy->send();
    }
}
