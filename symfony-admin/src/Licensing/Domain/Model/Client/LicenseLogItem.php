<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\Model\EntityId;

readonly class LicenseLogItem
{
    public function __construct(
        public \DateTimeImmutable $date,
        public int $version,
        public LicenseTypeEnum $licenseType,
        public EntityId $productId
    ) {
    }
}
