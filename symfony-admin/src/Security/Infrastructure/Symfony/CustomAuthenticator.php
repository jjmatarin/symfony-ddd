<?php

namespace App\Security\Infrastructure\Symfony;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private HttpClientInterface $http,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): Passport
    {
        $authHeader = $request->headers->get('Authorization');
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            throw new AuthenticationException('Missing token');
        }

        $externalToken = substr($authHeader, 7);
        $response = $this->http->request('GET', 'http://app-auth/api/validate-external-token', [
            'headers' => ['Authorization' => 'Bearer '.$externalToken],
        ]);
        if (200 !== $response->getStatusCode()) {
            throw new AuthenticationException('Invalid external token');
        }
        $data = $response->toArray(false);
        $internalJwt = $data['token'] ?? null;
        if (!$internalJwt) {
            throw new AuthenticationException('No internal token returned');
        }

        return new SelfValidatingPassport(
            new UserBadge($data['id'], function () use ($data) {
                return new User($data['id'], $data['token'], $data['roles']);
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse([
            'error' => 'No autorizado',
            'message' => $exception->getMessage(),
        ], Response::HTTP_UNAUTHORIZED);
    }
}
