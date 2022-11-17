<?php

namespace App\Infrastructure\Controller\Api;

use App\Application\UseCase\GetCompaniesWithHighestEmploymentPotential\GetCompaniesWithHighestEmploymentPotential;
use App\Application\UseCase\GetCompaniesWithHighestEmploymentPotential\GetCompaniesWithHighestEmploymentPotentialInput;
use App\Infrastructure\Presenter\JsonPresenter;
use Assert\AssertionFailedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GetCompaniesWithHighestEmploymentPotentialController extends AbstractController
{
    #[Route('/companies', name: 'app_get_companies_with_highest_employment_potential')]
    public function getCompaniesWithHighestEmploymentPotential(
        Request $request,
        JsonPresenter $presenter,
        GetCompaniesWithHighestEmploymentPotential $companiesWithHighestEmploymentPotential
    ): JsonResponse {
        try {
            $input = GetCompaniesWithHighestEmploymentPotentialInput::instantiate($request->query->all());
        } catch (AssertionFailedException $exception) {
            return new JsonResponse([
                'property' => $exception->getPropertyPath(),
                'error' => $exception->getMessage(),
            ], 400);
        }

        $companiesWithHighestEmploymentPotential->execute($input, $presenter);

        return new JsonResponse($presenter->getJson(), 200, [], true);
    }
}
