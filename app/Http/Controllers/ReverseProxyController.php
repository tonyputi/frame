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
        $location = Location::where('location_match', $request->route()->uri())->firstOrFail();
        if($request->getQueryString()) {
            $location->proxy_pass.= "?{$request->getQueryString()}";
        }

        $options = [];
        if($location->hasResolveOption){
            $option['curl'] = [
                CURLOPT_RESOLVE => ["{$location->hostname}:{$location->ipv4}"]
            ];
        }

        return Http::proxyPass($request, $location->proxy_pass, $options);

        // if($request->getQueryString()) {
        //     $url.= "?{$request->getQueryString()}";
        // }

        // $proxy = new ReverseProxy($request, $location->proxy_pass);
        
        // return $proxy->send();
    }
}
