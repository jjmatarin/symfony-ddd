<?php

namespace App\Common\Report;

interface ReportGeneratorInterface
{
    public function generate(string $template, array $params = []): string;
}
