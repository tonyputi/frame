<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Location;
use App\ProxyPass;
use Illuminate\Support\Arr;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Request;
use GuzzleHttp\Handler\CurlHandler;

class LocationController extends Controller
{
    public function __invoke(Request $request)
    {
        $uri = $request->route()->uri();
        $location = Location::where('location_match', "/{$uri}")->firstOrFail();
        
        $url = "https://{$location->host}{$location->location_match}";

        if($request->getQueryString()) {
            $url.= "?{$request->getQueryString()}";
        }

        // dd($url, $request->fullUrl());

        $proxy = new ProxyPass($request, $url);
        return $proxy->send();

        dd($request->header());

        $headers = $this->sanitizeHeaders($request->header(), ['cookie']);

        $handler = new CurlHandler();
        $stack = HandlerStack::create($handler); // Wrap w/ middleware
        $client = new Client([
            'timeout' => 20.0,
            'handler' => $stack,
            'headers' => array_merge([
                'x-forwarded-for' => $request->ip(),
                'x-forwarded-host' => $request->getHost(),
                'x-forwarded-proto' => $request->getScheme(),
                // 'forwarded' => "for={$request->ip()};host={$request->getHost()},proto={$request->getScheme()}"
            ], $headers)
        ]);

        // $url = $request->getScheme() . '://' . $request->any;
        $url = "http://sikaniaimmobiliare.com/" . $request->any;

        $response = $client->request($request->method(), $url, $request->input());
        $responseBody = $response->getBody();

        $responseHeaders = $this->sanitizeHeaders($response->getHeaders(), ['connection', 'transfer-encoding']);
        // $responseHeaders['connection'] = 'close';

        // dd($responseHeaders, $response->getHeaders());

        return response($responseBody)->withHeaders([
            'Server' => $responseHeaders['server'],
            'Date' => $responseHeaders['date'],
            'Content-Type' => $responseHeaders['content-type'],
            'Set-Cookie' => Arr::get($responseHeaders, 'set-cookie'),
        ]);
    }

    public function sanitizeHeaders($headers, $ignores = [])
    {
        return collect($headers)
            ->reject(fn($value, $key) => in_array(strtolower($key), $ignores))
            ->mapWithKeys(fn($value, $key) => [strtolower($key) => is_array($value) ? implode(', ', $value) : $value])
            ->toArray();
    }
}
