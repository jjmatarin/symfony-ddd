<?php

namespace App\Shared\Infrastructure\Presentation\API\Symfony;

use App\Shared\Bus\CommandBusInterface;
use App\Shared\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

abstract class BaseController extends AbstractController
{
    public function __construct(
        protected readonly CommandBusInterface $commandBus,
        protected readonly QueryBusInterface $queryBus,
        protected readonly DenormalizerInterface $denormalizer,
        protected readonly SerializerInterface $serializer,
    ) {
    }

    protected function processCommand(
        Request $request,
        string $commandType,
        array $params = [],
    ): JsonResponse {
        $actionArray = [];
        if ('' !== $request->getContent()) {
            $actionArray = $this->serializer->decode($request->getContent(), 'json');
        }
        $action = $this->denormalizer->denormalize(array_merge($actionArray, $params), $commandType);
        $this->commandBus->execute($action);

        return $this->json([], status: Response::HTTP_NO_CONTENT);
    }

    protected function processQuery(
        Request $request,
        string $queryType,
        array $params = [],
    ): JsonResponse {
        $actionArray = $request->query->all();
        $action = $this->denormalizer->denormalize(array_merge($actionArray, $params), $queryType);
        $response = $this->queryBus->query($action);

        if (null === $response) {
            return $this->json([], status: Response::HTTP_NO_CONTENT);
        }

        return $this->json($response, status: Response::HTTP_OK);
    }
}
