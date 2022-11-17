<?php

namespace App\Application\Adapter\Presenter;

interface PaginatedCollectionOutputInterface extends OutputInterface
{
    public function getArray(): array;

    public function getPage(): int;

    public function getSize(): int;

    public function getTotal(): int;
}
