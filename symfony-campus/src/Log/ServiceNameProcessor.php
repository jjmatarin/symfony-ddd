<?php

namespace App\Log;

use Monolog\Attribute\AsMonologProcessor;
use Monolog\LogRecord;

#[AsMonologProcessor]
class ServiceNameProcessor
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $record['extra']['service'] = 'app-campus';
        return $record;
    }
}
