<?php

namespace App\Licensing\Domain\Service;

use App\Common\Report\ReportGeneratorInterface;
use App\Licensing\Domain\Model\Client\Client;

class ClientReportGenerator
{
    public function __construct(
        private ReportGeneratorInterface $reportGenerator,
    ) {
    }

    public function generateReport(Client $client): string
    {
        $params = [
            'clientName' => $client->getName(),
            'clientEmail' => $client->getEmail(),
            'licencesLog' => $client->getLicensesLog()
        ];
        $template = 'client.html.twig';
        return $this->reportGenerator->generate($template, $params);
    }
}
