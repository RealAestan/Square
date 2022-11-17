<?php

namespace App\Domain\Model;

class City
{
    private string $name;
    private string $inseeCode;

    public static function createFromArray(array $data): self
    {
        $city = new self();

        $city->name = $data['properties']['nom'];
        $city->inseeCode = $data['properties']['code'];

        return $city;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInseeCode(): string
    {
        return $this->inseeCode;
    }
}
