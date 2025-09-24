<?php

namespace App\Management\Infrastructure\Presentation\API\Symfony;

use App\Licensing\Application\GetClient\GetClientQuery;
use App\Management\Application\Owner\GetOwner\GetOwnerQuery;
use App\Shared\Infrastructure\Presentation\API\Symfony\BaseController;
use App\Management\Application\Owner\CreateOwner\CreateOwnerCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/owners')]
class OwnersController extends BaseController
{
    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        return $this->processCommand($request, CreateOwnerCommand::class);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function get(string $id, Request $request): JsonResponse
    {
        return $this->processQuery($request, GetOwnerQuery::class, ['id' => $id]);
    }
}
