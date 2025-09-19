<?php

namespace App\Licensing\Infrastructure\Entrypoint\Controller\Symfony;

use App\Common\Infrastructure\Entrypoint\Controller\Symfony\BaseController;
use App\Licensing\Application\ChangeClientLicense\ChangeClientLicenseCommand;
use App\Licensing\Application\CreateClient\CreateClientCommand;
use App\Licensing\Application\DeleteClient\DeleteClientCommand;
use App\Licensing\Application\GetClient\GetClientQuery;
use App\Licensing\Application\ListClients\ListClientsQuery;
use App\Licensing\Application\UpdateClient\UpdateClientCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/clients')]
class ClientsController extends BaseController
{
    #[Route('', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        return $this->processQuery($request, ListClientsQuery::class);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function get(string $id, Request $request): JsonResponse
    {
        return $this->processQuery($request, GetClientQuery::class, ['id' => $id]);
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
