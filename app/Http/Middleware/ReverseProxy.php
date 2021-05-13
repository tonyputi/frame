<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Location;
use Illuminate\Http\Request;

class ReverseProxy
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
//        $request->headers->remove('host');
//        $request->headers->set('x-real-ip', $request->ip());
//        // here i can user $request->ips()
//        $request->headers->set('x-forwarded-for', $request->ips());
//        // $request->headers->set('x-forwarded-for', $this->forwardedFor($request->header('x-forwarded-for'), $request->ip()));
//        $request->headers->set('x-forwarded-host', $request->getHost());
//        $request->headers->set('x-forwarded-proto', $request->getScheme());

        return $next($request);
    }

    /**
     * Properly append ip to x-forwarded-for headers
     *
     * @param string $proxies
     * @param string $ip
     * @return string
     */
    private function forwardedFor($proxies, $ip = null)
    {
        $proxies = array_filter(explode(', ', $proxies));
        $proxies = array_merge($proxies, [$ip]);

        return implode(', ', $proxies);
    }
}
