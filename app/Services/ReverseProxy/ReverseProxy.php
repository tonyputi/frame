<?php

namespace App\Services\ReverseProxy;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Request;

class ReverseProxy
{
    /**
     * The number of times to try the request.
     *
     * @var int
     */
    protected $tries = 1;

    /**
     * The number of milliseconds to wait between retries.
     *
     * @var int
     */
    protected $retryDelay = 100;

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
    protected $method;

    /**
     * The uri for the request.
     *
     * @var string
     */
    protected $uri;

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
        $this->method = $method;
        $this->uri = $uri;

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
    public static function createFromRequest(Request $request, $uri, $options = [])
    {
        $headers = clone($request->headers);
        $headers->remove('host');
        $headers->set('connection', 'close');
        $headers->set('x-forwarded-for', $request->ips());
        $headers->set('x-forwarded-host', $request->getHost());
        $headers->set('x-forwarded-proto', $request->getScheme());

        $proxy = new static($request->method(), $uri, $options);
        $proxy->withHeaders($headers->all());
        $proxy->withQueryString($request->query());
        $proxy->withContent($request->getContent());

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
     * Add the given headers to the request.
     *
     * @param  array  $query
     * @return $this
     */
    public function withQueryString(array $query = [])
    {
        return $this->withOptions(compact('query'));
    }

    /**
     * Add the given headers to the request.
     *
     * @param  mixed  $content
     * @return $this
     */
    public function withContent($content = null)
    {
        unset($this->options['json']);
        unset($this->options['body']);

        if(!empty($content)) {
            if(is_array($content)) {
                $this->options['json'] = $content;
            } else if(is_string($content)) {
                $this->options['body'] = $content;
            }
        }

        return $this;
    }

    /**
     * Resolve the request by the provided hostname, ip and port
     *
     * @param  mixed  $content
     * @return $this
     */
    public function resolve($hostname, $ip, $port)
    {
        return $this->withOptions([
            'curl' => [
                CURLOPT_RESOLVE => ["{$hostname}:{$port}:{$ip}"]
            ]
        ]);
    }

    /**
     * Apply the callback's proxy changes if the given "value" is true.
     *
     * @param  mixed  $condition
     * @param  callable  $callback
     * @return mixed|$this
     */
    public function when($condition, $callback)
    {
        if ($condition) {
            return $callback($this, $condition) ?: $this;
        }

        return $this;
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

    /**
     * Execute the proxy pass request
     *
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function pass($options = [])
    {
        $this->withOptions($options);

        info('proxy-pass-options', $options);

        // return retry($this->tries, function () {
        //     try {
        //         return tap($this->buildClient()->request($this->method, $this->uri, $this->options), function ($response) {
        //             $success = ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300);
        //
        //             if ($this->tries > 1 && ! $success) {
        //                 $callback = func_get_args()[0] ?? null;
        //
        //                 throw tap(new RequestException($this), function ($exception) use ($callback) {
        //                     if ($callback && is_callable($callback)) {
        //                         $callback($this, $exception);
        //                     }
        //                 });
        //             }
        //         });
        //     } catch (ConnectException $e) {
        //         throw new ConnectionException($e->getMessage(), 0, $e);
        //     }
        // }, $this->retryDelay ?? 100);

        return $this->buildClient()
            ->request($this->method, $this->uri, $this->options);
    }
}
