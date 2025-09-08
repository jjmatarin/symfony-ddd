<?php

namespace App\Licensing\Domain\Model\Client;

readonly class LicenseLogItem
{
    public function __construct(
        public \DateTimeImmutable $date,
        public int $version,
        public LicenseTypeEnum $licenseType
    ) {
    }
}
