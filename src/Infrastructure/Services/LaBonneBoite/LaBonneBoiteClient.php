<?php

namespace App\Infrastructure\Services\LaBonneBoite;

use App\Application\Adapter\Services\CompaniesClientInterface;
use App\Domain\Model\Company;
use App\Infrastructure\Services\GeoAPI\GeoAPIClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LaBonneBoiteClient implements CompaniesClientInterface
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client, private GeoAPIClient $geoAPIClient, private string $clientId, private string $clientSecret)
    {
        $this->client = $client->withOptions([
            'base_uri' => 'https://api.pole-emploi.io',
        ]);
    }

    private function getBearerToken(): string
    {
        $response = $this->client->request('POST', 'https://entreprise.pole-emploi.fr/connexion/oauth2/access_token?realm=partenaire', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'body' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
                'scope' => 'api_labonneboitev1',
            ],
        ]);

        if (200 !== $response->getStatusCode()) {
            throw new \Exception('La Bonne Boite API does not respond');
        }

        $content = $response->toArray();

        return $content['access_token'];
    }

    public function fetchCompanies(string $cityName, string $zipCode, string $jobTitle, int $size, int $page): array
    {
        $cities = $this->geoAPIClient->fetchCities($cityName, $zipCode);

        if (empty($cities)) {
            return [
                'companies' => [],
                'total' => 0,
            ];
        }

        $response = $this->client->request(
            'GET',
            sprintf(
                '/partenaire/labonneboite/v1/company/?commune_id=%s&rome_codes_keyword_search=%s&page_size=%d&page=%d',
                $cities[0]->getInseeCode(),
                $jobTitle,
                $size,
                $page
            ),
            [
                'auth_bearer' => $this->getBearerToken(),
            ]
        );

        if (200 !== $response->getStatusCode()) {
            throw new \Exception('La Bonne Boite API does not respond');
        }

        $content = $response->toArray();

        return [
            'companies' => array_map(function (array $company) {
                return Company::createFromArray($company);
            }, $content['companies']),
            'total' => $content['companies_count'],
        ];
    }
}
