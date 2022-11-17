<?php

namespace App\Infrastructure\Security\ApiKey;

use App\Infrastructure\Security\ApiKey\Repository\ApiKeyRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    public function __construct(private ApiKeyRepository $apiKeyRepository)
    {
    }

    public function supports(Request $request): ?bool
    {
        return true;
    }

    public function authenticate(Request $request): Passport
    {
        $key = $request->headers->get('X-AUTH-TOKEN');
        $apiKey = $this->apiKeyRepository->findOneBy(['key' => $key]);
        if (!$apiKey instanceof ApiKey) {
            throw new CustomUserMessageAuthenticationException('Invalid X-AUTH-TOKEN provided');
        }
        $apiKey->useQuota();
        if ($apiKey->getQuota() < 0) {
            throw new CustomUserMessageAuthenticationException('You are out of quota');
        }
        $this->apiKeyRepository->save($apiKey, true);

        $request->attributes->set('quota_left', $apiKey->getQuota());

        return new SelfValidatingPassport(new UserBadge($apiKey->getUserIdentifier()));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
