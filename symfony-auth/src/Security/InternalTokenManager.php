<?php

namespace App\Security;

use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class InternalTokenManager
{
    public function __construct(
        private JWTTokenManagerInterface $externalValidator,
        private TokenStorageInterface $tokenStorage,
    ) {

    }

    public function createInternalToken(): array
    {
        $externalJwt = $this->tokenStorage->getToken()->getCredentials();

        // 1. Validar el token externo (Lexik ya maneja esto)
        $payload = $this->externalValidator->parse($externalJwt);

        $now = new DateTimeImmutable();

        $internalJwtConfig = Configuration::forAsymmetricSigner(
            new Sha256(),
            InMemory::file('/app/config/jwt/private-internal.pem'),
            InMemory::file('/app/config/jwt/public-internal.pem')
        );

        // 2. Crear token interno (TTL corto)
        $token = $internalJwtConfig->builder()
            ->issuedBy('auth-service')          // iss
            ->permittedFor('internal')          // aud
            ->identifiedBy(bin2hex(random_bytes(8))) // jti
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now)
            ->expiresAt($now->modify('+60 seconds')) // TTL corto
            ->relatedTo($payload['username'])   // sub
            ->withClaim('roles', $payload['roles'] ?? [])
            ->withClaim('id', $payload['id'] ?? null)
            ->getToken(
                $internalJwtConfig->signer(),
                $internalJwtConfig->signingKey()
            );

        return [
            'id' => $payload['id'] ?? null,
            'roles' => $payload['roles'] ?? [],
            'token' => $token->toString()
        ];
    }
}
