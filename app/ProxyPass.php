<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Psr7\Request as ProxyRequest;
use Illuminate\Http\Request;

class ProxyPass
{
    const default_config = [
        'timeout' => 20.0
    ];

    protected $config;

    protected $headers = [];

    protected $url;

    protected $method;

    protected $queryString;

    protected $content;

    public function __construct(Request $request, $url)
    {
        $this->withHeaders(array_merge([
            'X-Real-IP' => $request->ip(),
            'X-Forwarded-For' => $request->ip(),
            // 'X-Forwarded-Host' => $request->getHost(),
            // 'X-Forwarded-Proto' => $request->getScheme(),
        ], $request->header()));

        $this->withUrl($url);
        $this->withMethod($request->method());
        $this->withQueryString($request->getQueryString());
        $this->withContent($request->getContent());
    }

    public function withHeaders($headers)
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    public function withMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function withUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function withQueryString($queryString)
    {
        $this->queryString = $queryString;
        return $this;
    }

    public function withContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function client($config = [])
    {
        $handler = new CurlHandler();
        $stack = HandlerStack::create($handler);

        return new Client(array_merge(static::default_config, ['handler' => $stack], $config));
    }

    public function send()
    {       
        $request = new ProxyRequest($this->method, $this->url, $this->headers, $this->content);
        $response = $this->client()->send($request);

        $responseBody = $response->getBody();
        $responseHeaders = $this->sanitizeHeaders($response->getHeaders(), ['connection', 'transfer-encoding']);
        
        return response($responseBody)->withHeaders($responseHeaders);
    }

    protected function sanitizeHeaders($headers, $ignores = [])
    {
        $headers = array_filter($headers, fn($key) => !in_array(strtolower($key), $ignores), ARRAY_FILTER_USE_KEY);
        
        array_walk($headers, fn(&$value) => $value = is_array($value) ? implode(', ', $value) : $value);
        // $headers = array_map(fn($key, $value) => [$key => $value], array_keys($headers), $headers);

        return $headers;
    }
}