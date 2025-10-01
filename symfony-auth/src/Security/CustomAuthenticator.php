<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class CustomAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private JWTTokenManagerInterface $jwtManager,
        private UserProviderInterface $userProvider,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return $request->getPathInfo() === '/api/login' && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $data = json_decode($request->getContent(), true);
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        // Lógica custom sin base de datos

        if ($username === 'admin' && $password === '1234') {
            return new SelfValidatingPassport(
                new UserBadge($username, function () use ($username) {
                    return $this->userProvider->loadUserByIdentifier($username);
                })
            );
        }

        throw new AuthenticationException('Credenciales inválidas');
    }

    public function onAuthenticationSuccess(Request $request, $token, string $firewallName): ?JsonResponse
    {
        $jwtToken = $this->jwtManager->createFromPayload($token->getUser(), [
            'id' => $token->getUser()->getId(),
        ]);
        return new JsonResponse(['token' => $jwtToken]);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?JsonResponse
    {
        return new JsonResponse(['error' => 'Unauthorized'], 401);
    }
}
