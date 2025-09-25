<?php

namespace Client;

use App\Licensing\Application\CreateClient\CreateClientCommand;
use Contracts\DTO\Admin\ListClientsItem;

class AdminClient
{
    private ApiClient $client;

    public static function getInstance()
    {
        return new self();
    }

    private function __construct()
    {
        $this->client = ApiClient::getInstance();
    }

    public function listAllClients(): array
    {
        return $this->client->query('http://app-admin/api/v1/clients', ListClientsItem::class . '[]');
    }

    public function createClient(CreateClientCommand $command): void
    {
        $this->client->post('http://app-admin/api/v1/clients', $command);
    }
}
