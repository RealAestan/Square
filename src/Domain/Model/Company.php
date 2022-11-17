<?php

namespace App\Domain\Model;

class Company
{
    private string $siret;
    private string $name;
    private string $address;
    private string $city;
    private string $contactMode;
    private int $distance;
    private string $headcountText;
    private string $naf;
    private string $nafText;
    private float $longitude;
    private float $latitude;
    private int $stars;
    private bool $internship;

    public static function createFromArray(array $data): self
    {
        $company = new self();

        $company->siret = $data['siret'];
        $company->name = $data['name'];
        $company->address = $data['address'];
        $company->city = $data['city'];
        $company->contactMode = $data['contact_mode'];
        $company->distance = $data['distance'];
        $company->headcountText = $data['headcount_text'];
        $company->naf = $data['naf'];
        $company->nafText = $data['naf_text'];
        $company->longitude = $data['lon'];
        $company->latitude = $data['lat'];
        $company->stars = $data['stars'];
        $company->internship = $data['alternance'];

        return $company;
    }

    public function getSiret(): string
    {
        return $this->siret;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getContactMode(): string
    {
        return $this->contactMode;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    public function getHeadcountText(): string
    {
        return $this->headcountText;
    }

    public function getNaf(): string
    {
        return $this->naf;
    }

    public function getNafText(): string
    {
        return $this->nafText;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getStars(): int
    {
        return $this->stars;
    }

    public function getInternship(): bool
    {
        return $this->internship;
    }
}
