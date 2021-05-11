<?php

namespace App\Services\ReverseProxy;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Request;

class ReverseProxyNg
{
    /**
     * guzzle options
     * 
     * @var array
     */
    protected array $options = [];

    /**
     * The method for the request.
     *
     * @var string
     */
    protected $pendingMethod;

    /**
     * The uri for the request.
     *
     * @var string
     */
    protected $pendingUri;

    /**
     * The raw body for the request.
     *
     * @var string
     */
    protected $pendingBody;

    /**
     * The transfer stats for the request.
     *
     * \GuzzleHttp\TransferStats
     */
    protected $transferStats;

    /**
     * Class constructor
     *
     */
    public function __construct($method, $uri, $options = [])
    {
        $this->pendingMethod = $method;
        $this->pendingUri = $uri;

        $this->withOptions(array_merge([
            'http_errors' => false,
            'on_stats' => fn ($transferStats) => $this->transferStats = $transferStats,
        ], $options));
    }

    /**
     * Create reverse proxy from laravel request
     *
     * @param Request $request
     * @return static
     */
    public static function createFromRequest(Request $request, $options = [])
    {
        $headers = clone($request->headers);
        $headers->remove('host');

        // dd(get_class_methods($request->headers));

        $prefix = trim($request->route()->getPrefix(), '/') . '/';
        $path = ltrim($request->path(), $prefix);
        // $path = Str::of($request->path())->after($prefix);

        $proxy = new static($request->method(), $path, $options);
        $proxy->withHeaders($headers->all());
        
        return $proxy;
    }

    /**
     * Merge new options into the client.
     *
     * @param  array  $options
     * @return $this
     */
    public function withOptions(array $options)
    {
        return tap($this, fn ($request) => $this->options = array_merge_recursive($this->options, $options));
    }

    /**
     * Add the given headers to the request.
     *
     * @param  array  $headers
     * @return $this
     */
    public function withHeaders(array $headers)
    {
        return $this->withOptions(compact('headers'));
    }

    /**
     * Build the Guzzle client.
     *
     * @return \GuzzleHttp\Client
     */
    public function buildClient()
    {
        return new Client([
            'handler' => $this->buildHandlerStack(),
            'cookies' => true,
        ]);
    }

    /**
     * Build the before sending handler stack.
     *
     * @return \GuzzleHttp\HandlerStack
     */
    public function buildHandlerStack()
    {
        return tap(HandlerStack::create(), function ($stack) {
            // $stack->push($this->buildBeforeSendingHandler());
            // $stack->push($this->buildRecorderHandler());
            // $stack->push($this->buildStubHandler());

            // $this->middleware->each(function ($middleware) use ($stack) {
            //     $stack->push($middleware);
            // });
        });
    }

    public function pass($base_uri, $options = [])
    {
        $uri = "{$base_uri}/{$this->pendingUri}";

        $this->withOptions($options);

        return $this->buildClient()->request($this->pendingMethod, $uri, $this->options);
    }    
}