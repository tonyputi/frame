<?php

namespace App\Http\Controllers;

use App\Services\ProxyPass;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __invoke(Request $request)
    {
        $url = "https://{$request->location->host}/{$request->location->location_match}";

        if($request->getQueryString()) {
            $url.= "?{$request->getQueryString()}";
        }

        $proxy = new ProxyPass($request, $url);
        
        return $proxy->send();
    }
}
