<?php

namespace App\Common\Infrastructure\Log;

use Monolog\Attribute\AsMonologProcessor;
use Monolog\LogRecord;

#[AsMonologProcessor]
class ServiceNameProcessor
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $record['extra']['service'] = 'app-admin';
        return $record;
    }
}
