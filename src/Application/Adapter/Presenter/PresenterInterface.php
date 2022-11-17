<?php

namespace App\Application\Adapter\Presenter;

interface PresenterInterface
{
    public function present(OutputInterface $output): void;
}
