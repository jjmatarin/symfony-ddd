<?php

namespace App\Licensing\Application\GetClientPdf;

use App\Common\Bus\QueryHandlerInterface;
use App\Common\Domain\Exception\NotFoundException;
use App\Common\Domain\Model\EntityId;
use App\Licensing\Application\GetClient\GetClientQuery;
use App\Licensing\Application\GetClient\GetClientResponse;
use App\Licensing\Application\GetClient\GetClientResponseProduct;
use App\Licensing\Domain\Model\Client\ClientRepositoryInterface;
use App\Licensing\Domain\Service\ClientReportGenerator;
use App\Licensing\ReadModel\Client\ClientReadModelInterface;
use App\Licensing\ReadModel\Product\ProductReadModelInterface;

readonly class GetClientPdfHandler implements QueryHandlerInterface
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private ClientReportGenerator $clientReportGenerator,
    ) {
    }

    public function __invoke(GetClientPdfQuery $command): GetClientPdfResponse
    {
        $client = $this->clientRepository->getById(EntityId::fromString($command->id));
        if ($client === null) {
            throw new NotFoundException("Client not found");
        }

        $response = $this->clientReportGenerator->generateReport($client);

        return new GetClientPdfResponse(
            filename: $client->getId() . '.pdf',
            data: $response,
        );
    }
}
