<?php

namespace App\Controller;

use App\Security\InternalTokenManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    public function __construct(
        private InternalTokenManager $internalTokenManager
    ) {
    }
    #[Route('/api/validate-external-token')]
    public function validateExternalToken(): JsonResponse
    {
        $token = $this->internalTokenManager->createInternalToken();
        return $this->json($token);
    }

    #[Route('/api/test')]
    public function test(): JsonResponse
    {
        return new JsonResponse(['asdf' => 'asdf']);
    }

    #[Route('/.well-known/internal-public.pem', methods: ['GET'])]
    public function __invoke(): Response
    {
        $pem = file_get_contents('/app/config/jwt/public-internal.pem');
        return new JsonResponse(['public-key' => $pem]);
    }

}
