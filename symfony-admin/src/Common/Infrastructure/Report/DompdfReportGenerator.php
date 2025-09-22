<?php

namespace App\Common\Infrastructure\Report;

use App\Common\Report\ReportGeneratorInterface;
use Dompdf\Dompdf;
use Twig\Environment;

class DompdfReportGenerator implements ReportGeneratorInterface
{
    public function __construct(
        private Environment $twig,
    ) {
    }

    public function generate(string $template, array $params = []): string
    {
        $dompdf = new Dompdf();
        $html = $this->twig->render($template, $params);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();

        return base64_encode($dompdf->output());
    }
}
