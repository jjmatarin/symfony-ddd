<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\Model\EntityId;

class License
{
    private Client $client;
    private int $version;
    private \DateTimeImmutable $date;
    private LicenseTypeEnum $licenseType;
    private EntityId $productId;

    public function __construct(Client $client, int $version, LicenseTypeEnum $licenseType, EntityId $productId)
    {
        $this->client = $client;
        $this->version = $version;
        $this->licenseType = $licenseType;
        $this->productId = $productId;
        $this->date = new \DateTimeImmutable();
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getLicenseType(): LicenseTypeEnum
    {
        return $this->licenseType;
    }

    public function getProductId(): EntityId
    {
        return $this->productId;
    }
}
