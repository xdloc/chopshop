<?php
declare(strict_types=1);

namespace App\Framework;

use App\Exceptions\ApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Api
{
    private ?Client $client = null;

    public function __construct()
    {
        $this->client = new Client();

    }

    /**
     * @throws GuzzleException
     * @throws ApiException
     * @throws \JsonException
     */
    public function get(string $url, array $params = []): mixed
    {
        try {
            $response = $this->client->request('get', $url, $params);
        } catch (\Exception $exception) {
            throw new ApiException('Api Malfunction', $exception->getCode(), $exception);
        }

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws GuzzleException
     * @throws ApiException
     * @throws \JsonException
     */
    public function post(string $url, array $params = [])
    {
        try {
            $response = $this->client->request('post', $url, $params);
        } catch (\Exception $exception) {
            throw new ApiException('Api Malfunction', $exception->getCode(), $exception);
        }

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}