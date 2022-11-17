<?php

namespace App\Infrastructure\Services\GeoAPI;

use App\Domain\Model\City;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GeoAPIClient
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client->withOptions([
            'base_uri' => 'https://geo.api.gouv.fr',
        ]);
    }

    /**
     * @return City[]
     */
    public function fetchCities(string $cityName, string $zipCode): array
    {
        $response = $this->client->request(
            'GET',
            sprintf(
                '/communes?codePostal=%s&nom=%s&format=geojson',
                $zipCode,
                $cityName
            )
        );

        if (200 !== $response->getStatusCode()) {
            throw new \Exception('Geo API does not respond');
        }

        $content = $response->toArray();

        return array_map(function (array $city) {
            return City::createFromArray($city);
        }, $content['features']);
    }
}
