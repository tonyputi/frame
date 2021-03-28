<?php

namespace App\Services\ReverseProxy;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Request;
use GuzzleHttp\Handler\CurlHandler;

class ReverseProxy
{
    protected const default_config = [
        'timeout' => 20.0
    ];

    protected array $headers = [];

    protected string $url;

    protected string $method;

    protected $queryString;

    protected $content;

    protected $resolve;

    /**
     * Class constructor
     *
     * @param Request $request
     * @param string $url
     */
    public function __construct(Request $request, $url)
    {
        logger('request', [
            'route' => $request->route()->uri(),
            'headers' => $request->header(),
            'query' => $request->query(),
            'content' => $request->getContent()
        ]);

        $this->headers = Arr::except($request->header(), ['host']);
        $this->headers['x-real-ip'] = $request->ip();
        // here we need to append ip to chain
        $this->headers['x-forwarded-for'] = [implode(', ', array_merge(explode(', ', $request->header('x-forwarded-for')), [$request->ip()]))];
        $this->headers['x-forwarded-host'] = $request->getHost();
        $this->headers['x-forwarded-proto'] = $request->getScheme();

        $this->resolve = null;

        $this->withUrl($url);
        $this->withMethod($request->method());
        $this->withQueryString($request->getQueryString());
        $this->withContent($request->getContent());
    }

    /**
     * Set proxy headers
     *
     * @param array $headers
     * @return void
     */
    public function withHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    /**
     * Set proxy method
     *
     * @param string $method
     * @return void
     */
    public function withMethod(string $method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Set proxy url to be called
     *
     * @param string $url
     * @return void
     */
    public function withUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Set proxy query string
     *
     * @param string $queryString
     * @return void
     */
    public function withQueryString(string $queryString)
    {
        $this->queryString = $queryString;
        return $this;
    }

    /**
     * Set proxy body
     *
     * @param string $body
     * @return void
     */
    public function withContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Set internal curl resolve system
     *
     * @param string $hostname
     * @param string $ip
     * @param integer $port
     * @return void
     */
    public function withResolve(string $hostname, string $ip, int $port)
    {
        $this->resolve = "{$hostname}:{$port}:{$ip}";
        return $this;
    }

    /**
     * Send the request
     *
     * @return response
     */
    public function send()
    {
        $options = ['headers' => $this->headers];

        if($this->resolve) {
            $options['curl'] = [
                CURLOPT_RESOLVE => [$this->resolve]
            ];
        }

        $response = $this->client()->request($this->method, $this->url, $options);

        $responseBody = $response->getBody();
        $responseHeaders = $this->sanitizeHeaders($response->getHeaders(), ['connection', 'transfer-encoding']);
        
        return response($responseBody)->withHeaders($responseHeaders);
    }

    /**
     * Return new guzzle client
     *
     * @param array $config
     * @return Client
     */
    protected function client($config = [])
    {
        $handler = HandlerStack::create(new CurlHandler());

        return new Client(array_merge(static::default_config, compact('handler'), $config));
    }

    /**
     * sanitize headers
     *
     * @param array $headers
     * @param array $ignores
     * @return void
     */
    protected function sanitizeHeaders($headers, $ignores = [])
    {
        $headers = array_filter($headers, fn($key) => !in_array(strtolower($key), $ignores), ARRAY_FILTER_USE_KEY);
        
        array_walk($headers, fn(&$value) => $value = is_array($value) ? implode(', ', $value) : $value);
        // $headers = array_map(fn($key, $value) => [$key => $value], array_keys($headers), $headers);

        return $headers;
    }
}