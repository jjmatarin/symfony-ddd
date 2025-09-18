<?php

namespace App\Tests\Unit\Licenses\Domain\Model;

use App\Common\Domain\EventHandling\DomainEventPublisher;
use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\Client;
use App\Licensing\Domain\Model\Client\LicenseTypeEnum;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testClient(): void
    {
        DomainEventPublisher::getInstance()->reset();
        $client = Client::create(
            id: EntityId::generate(),
            name: 'Client test',
            email: 'asdf@asdf.com',
            description: 'Client description',
            licenseType: LicenseTypeEnum::BASIC,
            productId: EntityId::generate(),
        );
        $this->assertCount(1, $client->getLicensesLog());
        $this->assertEquals(1, $client->getActiveLicenseVersion());
        $this->assertEquals(LicenseTypeEnum::BASIC, $client->getActiveLicenseType());

        $this->assertCount(1, DomainEventPublisher::getInstance()->getEvents());

        $client->changeLicense(LicenseTypeEnum::PREMIUM, $client->getActiveLicenseProductId());
        $this->assertCount(2, $client->getLicensesLog());
        $this->assertEquals(LicenseTypeEnum::PREMIUM, $client->getActiveLicenseType());

        $this->assertCount(2, DomainEventPublisher::getInstance()->getEvents());
    }
}