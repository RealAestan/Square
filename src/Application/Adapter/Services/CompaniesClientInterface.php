<?php

namespace App\Application\Adapter\Services;

interface CompaniesClientInterface
{
    public function fetchCompanies(string $cityName, string $zipCode, string $jobTitle, int $size, int $page): array;
}
