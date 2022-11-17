<?php

namespace App\Application\UseCase\GetCompaniesWithHighestEmploymentPotential;

use App\Application\Adapter\Presenter\PresenterInterface;
use App\Application\Adapter\Services\CompaniesClientInterface;

class GetCompaniesWithHighestEmploymentPotential
{
    public function __construct(private CompaniesClientInterface $companiesClient)
    {
    }

    public function execute(GetCompaniesWithHighestEmploymentPotentialInput $input, PresenterInterface $presenter): void
    {
        $data = $this->companiesClient->fetchCompanies(
            $input->getCity(),
            $input->getZipCode(),
            $input->getJobTitle(),
            $input->getSize(),
            $input->getPage()
        );

        $presenter->present(GetCompaniesWithHighestEmploymentPotentialOutput::instantiate(
            $data['companies'],
            $input->getPage(),
            min($input->getSize(), count($data['companies'])),
            $data['total']
        ));
    }
}
