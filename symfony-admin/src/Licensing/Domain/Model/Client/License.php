<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\Model\EntityId;

class License
{
    private Client $client;
    private int $version;

    private \DateTimeImmutable $date;

    private LicenseTypeEnum $type;
    private EntityId $productId;

    public static function create(
        Client $client,
        int $version,
        LicenseTypeEnum $type,
        EntityId $productId,
    ) {
        return new self($client, $version, $type, $productId);
    }

    private function __construct(
        Client $client,
        int $version,
        LicenseTypeEnum $type,
        EntityId $productId,
    ) {
        $this->client = $client;
        $this->version = $version;
        $this->type = $type;
        $this->productId = $productId;

        $this->date = new \DateTimeImmutable();
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getType(): LicenseTypeEnum
    {
        return $this->type;
    }

    public function getProductId(): EntityId
    {
        return $this->productId;
    }
}
