<?php

namespace App\Security;

use Contracts\Stamps\SecurityTokenStamp;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SecurityMiddleware implements MiddlewareInterface
{
    public function __construct(
        private HttpClientInterface $http,
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {


        $tokenStamp = $envelope->last(SecurityTokenStamp::class);

        $response = $this->http->request('GET', 'http://app-auth/.well-known/internal-public.pem');
        if (200 !== $response->getStatusCode()) {
            throw new AuthenticationException('Invalid external token');
        }
        $data = $response->toArray(false);

        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($data['public-key']) // tu secret
        );
        $token = $config->parser()->parse($tokenStamp->token);
        $roles = $token->claims()->get('roles');
        $message = get_class($envelope->getMessage());


        return $stack->next()->handle($envelope, $stack);
    }
}
