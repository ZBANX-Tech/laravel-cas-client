<?php


namespace Zbanx\CasClient\Uilts;


use GuzzleHttp\Client;

class HttpClient
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('cas.server')
        ]);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $uri)
    {
        $response = $this->client->request($method, $uri);
        return $response;
    }

}