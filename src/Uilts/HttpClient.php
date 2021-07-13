<?php


namespace Zbanx\CasClient\Uilts;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Zbanx\CasClient\Exceptions\CasClientException;

class HttpClient
{
    private $client;
    private $signature;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('cas.server')
        ]);
        $this->signature = config('cas.app_id') . ':' . config('cas.app_secret');
    }

    /**
     * @throws GuzzleException
     * @throws CasClientException
     */
    public function request($method, $uri, $options = [])
    {
        $options['headers'] = array_merge($options['headers'] ?? [], ['X-Signature' => $this->signature]);
        $response = $this->client->request($method, $uri, $options);

        // 记录请求日志
        if (config('cas.request.log', false)) {
            $channel = config('cas.request.log_channel');
            Log::channel($channel)->info(__METHOD__, compact('method', 'uri', 'options'));
        }

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents(), true);
        }
        throw new CasClientException('response invalid');
    }

}