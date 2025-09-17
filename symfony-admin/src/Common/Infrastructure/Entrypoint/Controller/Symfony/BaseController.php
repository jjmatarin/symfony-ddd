<?php

namespace App\Common\Infrastructure\Entrypoint\Controller\Symfony;

use App\Common\Bus\CommandBusInterface;
use App\Common\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

abstract class BaseController extends AbstractController
{
    public function __construct(
        protected readonly CommandBusInterface $commandBus,
        protected readonly QueryBusInterface $queryBus,
        protected readonly DenormalizerInterface $denormalizer,
        protected readonly SerializerInterface $serializer,
        protected readonly DecoderInterface $decoder
    ) {
    }

    protected function processCommand(
        Request $request,
        string $commandType,
        array $params = [],
        ?int $statusCode = Response::HTTP_NO_CONTENT
    ): JsonResponse {
        $actionArray = [];
        if ('' !== $request->getContent()) {
            $actionArray = $this->decoder->decode($request->getContent(), 'json');
        }
        $action = $this->denormalizer->denormalize(array_merge($actionArray, $params), $commandType);
        $this->commandBus->execute($action);

        return $this->json([], status: $statusCode);
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