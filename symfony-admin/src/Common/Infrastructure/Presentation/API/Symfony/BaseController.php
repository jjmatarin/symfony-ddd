<?php

namespace App\Common\Infrastructure\Presentation\API\Symfony;

use App\Common\Bus\CommandBusInterface;
use App\Common\Bus\QueryBusInterface;
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
        $response = $this->commandBus->execute($action);

        if (null === $response) {
            return $this->json([], status: Response::HTTP_NO_CONTENT);
        }

        return $this->json(['data' => $response], status: Response::HTTP_OK);
    }

    protected function processQuery(
        Request $request,
        string $queryType,
        array $params = [],
    ): JsonResponse {
        $actionArray = $request->query->all();
        $action = $this->denormalizer->denormalize(array_merge($actionArray, $params), $queryType);
        $response = $this->queryBus->execute($action);

        if (null === $response) {
            return $this->json([], status: Response::HTTP_NO_CONTENT);
        }

        return $this->json(['data' => $response], status: Response::HTTP_OK);
    }
}
