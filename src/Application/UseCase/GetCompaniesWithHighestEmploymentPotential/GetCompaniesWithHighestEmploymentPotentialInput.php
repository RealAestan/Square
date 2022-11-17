<?php

namespace App\Application\UseCase\GetCompaniesWithHighestEmploymentPotential;

use Assert\Assertion;

class GetCompaniesWithHighestEmploymentPotentialInput
{
    public const KEY_CITY = 'city';
    public const KEY_ZIP_CODE = 'zip_code';
    public const KEY_JOB_TITLE = 'job_title';
    public const KEY_SIZE = 'size';
    public const KEY_PAGE = 'page';

    private int $size;

    private int $page;

    private string $city;

    private string $zipCode;

    private string $jobTitle;

    public static function instantiate(array $data): self
    {
        self::validate($data);

        $input = new self();

        $input->city = $data[self::KEY_CITY];
        $input->zipCode = $data[self::KEY_ZIP_CODE];
        $input->jobTitle = $data[self::KEY_JOB_TITLE];
        $input->size = $data[self::KEY_SIZE] ?? 30;
        $input->page = $data[self::KEY_PAGE] ?? 1;

        return $input;
    }

    private static function validate(array $data): void
    {
        Assertion::string($data[self::KEY_CITY] ?? null, null, self::KEY_CITY);

        Assertion::integerish($data[self::KEY_ZIP_CODE] ?? null, null, self::KEY_ZIP_CODE);
        Assertion::length($data[self::KEY_ZIP_CODE] ?? null, 5, null, self::KEY_ZIP_CODE);

        Assertion::string($data[self::KEY_JOB_TITLE] ?? null, null, self::KEY_JOB_TITLE);

        Assertion::nullOrIntegerish($data[self::KEY_SIZE] ?? null, null, self::KEY_SIZE);
        Assertion::nullOrGreaterOrEqualThan($data[self::KEY_SIZE] ?? null, 1, null, self::KEY_SIZE);

        Assertion::nullOrIntegerish($data[self::KEY_PAGE] ?? null, null, self::KEY_PAGE);
        Assertion::nullOrGreaterOrEqualThan($data[self::KEY_PAGE] ?? null, 1, null, self::KEY_PAGE);
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getJobTitle(): string
    {
        return $this->jobTitle;
    }
}
