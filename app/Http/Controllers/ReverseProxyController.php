<?php

namespace App\Http\Controllers;

use App\Services\ReverseProxy;
use Illuminate\Http\Request;

class ReverseProxyController extends Controller
{
    public function __invoke(Request $request)
    {
        $url = "https://{$request->location->host}/{$request->location->location_match}";

        if($request->getQueryString()) {
            $url.= "?{$request->getQueryString()}";
        }

        $proxy = new ReverseProxy($request, $url);
        
        return $proxy->send();
    }
}
