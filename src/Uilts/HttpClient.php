<?php


namespace Zbanx\CasClient\Uilts;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Zbanx\CasClient\Exceptions\CasClientException;

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
     * @throws GuzzleException
     * @throws CasClientException
     */
    public function request($method, $uri)
    {
        $response = $this->client->request($method, $uri);
        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents(), true);
        }
        throw new CasClientException('response invalid');
    }

}