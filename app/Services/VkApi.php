<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;

class VkApi
{
    const API_URL = "https://api.vk.com/method/";
    const API_VERSION = '5.69';
    const API_TIMEOUT = 30.0;

    protected $http;
    protected $token;
    protected $version;

    public function __construct($version = null, ClientInterface $http = null)
    {
        $this->http = $this->getHttpClient($http);
        $this->version = $version ?: self::API_VERSION;
    }

    public function request($method, $params = [], $token)
    {
        $options = $this->buildOptions($params, $token);
        $response = $this->http->request('POST', $method, $options);

        return $this->getResponseDate($response);
    }

    protected function buildOptions($params, $token)
    {
        $params['v'] = $this->version;
        $params['access_token'] = $token;

        return [RequestOptions::FORM_PARAMS => $params];
    }

    protected function getResponseDate($response)
    {
        $data = json_decode((string)$response->getBody(), true);

        if(empty($data['response']))
            throw new \Exception('Error: ' . $data['error']['error_msg']);

        if($data)
            return $data;
    }

    private function getHttpClient(ClientInterface $http = null)
    {
        return $http ?: new Client([
            'base_uri' => self::API_URL,
            'timeout' => self::API_TIMEOUT,
            'http_errors' => false,
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);
    }
}