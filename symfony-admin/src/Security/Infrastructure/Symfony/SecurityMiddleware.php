<?php

namespace App\Security\Infrastructure\Symfony;

use App\Licensing\Application\CreateClient\CreateClientCommand;
use App\Licensing\Application\UpdateClient\UpdateClientCommand;
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
        $permissions = [
            CreateClientCommand::class => ['ROLE_ADMIN'],
            UpdateClientCommand::class => ['ROLE_ADMIN2'],
        ];

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

        $permission = $permissions[$message];
        if (!in_array($roles[0], $permission, true)) {
            throw new AuthenticationException('Invalid role');
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
