<?php

namespace App\Application\UseCase\GetCompaniesWithHighestEmploymentPotential;

use App\Application\Adapter\Presenter\PaginatedCollectionOutputInterface;

class GetCompaniesWithHighestEmploymentPotentialOutput implements PaginatedCollectionOutputInterface
{
    private array $companies;

    private int $page;

    private int $size;

    private int $total;

    public static function instantiate(array $companies, int $page, int $size, int $total): self
    {
        $output = new self();

        $output->companies = $companies;
        $output->page = $page;
        $output->size = $size;
        $output->total = $total;

        return $output;
    }

    public function getArray(): array
    {
        return $this->companies;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
