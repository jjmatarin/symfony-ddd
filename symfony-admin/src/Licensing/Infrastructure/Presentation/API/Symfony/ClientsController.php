<?php

namespace App\Licensing\Infrastructure\Presentation\API\Symfony;

use App\Common\Infrastructure\Presentation\API\Symfony\BaseController;
use App\Licensing\Application\Client\ChangeClientLicense\ChangeClientLicenseCommand;
use App\Licensing\Application\Client\CreateClient\CreateClientCommand;
use App\Licensing\Application\Client\DeleteClient\DeleteClientCommand;
use App\Licensing\Application\Client\GetClient\GetClientCommand;
use App\Licensing\Application\Client\ListClients\ListClientsCommand;
use App\Licensing\Application\Client\UpdateClient\UpdateClientCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/clients')]
class ClientsController extends BaseController
{
    #[Route('', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        return $this->processQuery($request, ListClientsCommand::class);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function get(Request $request, string $id): JsonResponse
    {
        return $this->processQuery($request, GetClientCommand::class, ['id' => $id]);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        return $this->processCommand($request, CreateClientCommand::class);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(string $id, Request $request): JsonResponse
    {
        return $this->processCommand($request, UpdateClientCommand::class, ['id' => $id]);
    }

    #[Route('/{id}', methods: ['PATCH'])]
    public function changeLicense(string $id, Request $request): JsonResponse
    {
        return $this->processCommand($request, ChangeClientLicenseCommand::class, ['id' => $id]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(string $id, Request $request): JsonResponse
    {
        return $this->processCommand($request, DeleteClientCommand::class, ['id' => $id]);
    }

}
