<?php

namespace App\Service\Geocoding;

use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractGeocoding implements IGeocoding
{
    protected string $baseUrl;
    protected HttpClientInterface $client;

    /**
    * AbstractGeocoding constructor.
    * @param string $baseUrl
    * @param HttpClientInterface $client
    */
    public function __construct(string $baseUrl, HttpClientInterface $client)
    {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
    }

    abstract protected function geocode(string $location): array;
}
