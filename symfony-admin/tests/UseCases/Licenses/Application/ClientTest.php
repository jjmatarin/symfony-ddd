<?php

namespace App\Tests\UseCases\Licenses\Application;

use App\Common\Domain\EventHandling\DomainEventPublisher;
use App\Common\Domain\Exception\NotFoundException;
use App\Common\Domain\Model\EntityId;
use App\Licensing\Application\CreateClient\CreateClientCommand;
use App\Licensing\Application\CreateClient\CreateClientHandler;
use App\Licensing\Application\GetClient\GetClientHandler;
use App\Licensing\Application\GetClient\GetClientQuery;
use App\Licensing\Application\UpdateClient\UpdateClientCommand;
use App\Licensing\Application\UpdateClient\UpdateClientHandler;
use App\Licensing\Domain\Model\Client\ClientWasCreated;
use App\Licensing\Domain\Model\Client\ClientWasUpdated;
use App\Licensing\Infrastructure\Persistence\Dummy\DummyClientRepository;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testCreateAndUpdateClient(): void
    {
        DomainEventPublisher::getInstance()->reset();
        $clientRepository = new DummyClientRepository();

        $id = EntityId::generate();
        $productId = EntityId::generate();
        $createClientCommand = new CreateClientCommand(
            $id->get(), 'Client name', 'asdf@asdf.com', 'Desc', 'basic', $productId
        );
        $createClientHandler = new CreateClientHandler($clientRepository);
        $createClientHandler->__invoke($createClientCommand);
        $this->assertCount(1, DomainEventPublisher::getInstance()->getEvents());
        $this->assertInstanceOf(ClientWasCreated::class, DomainEventPublisher::getInstance()->getEvents()[0]);
        DomainEventPublisher::getInstance()->reset();

        $getClientQuery = new GetClientQuery($id->get());
        $getClientHandler = new GetClientHandler($clientRepository);
        $clientResponse = $getClientHandler->__invoke($getClientQuery);
        $this->assertEquals('Client name', $clientResponse->name);

        $updateClientCommand = new UpdateClientCommand(
            $id->get(), 'Client name updated', 'qwer@awer.com', 'Desc updated'
        );
        $updateClientHandler = new UpdateClientHandler($clientRepository);
        $updateClientHandler->__invoke($updateClientCommand);
        $this->assertCount(1, DomainEventPublisher::getInstance()->getEvents());
        $this->assertInstanceOf(ClientWasUpdated::class, DomainEventPublisher::getInstance()->getEvents()[0]);
        DomainEventPublisher::getInstance()->reset();

        $this->assertEquals('Client name updated', $updateClientCommand->name);
    }

    public function testGetClientNotFoundException(): void
    {
        $this->expectException(NotFoundException::class);

        $clientRepository = new DummyClientRepository();
        $id = EntityId::generate();
        $getClientQuery = new GetClientQuery($id->get());
        $getClientHandler = new GetClientHandler($clientRepository);
        $getClientHandler->__invoke($getClientQuery);
    }
}