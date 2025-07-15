<?php

namespace App\Command;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\ClientInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:test-elastic',
    description: 'Add a short description for your command',
)]
class TestElasticCommand extends Command
{
    const INDEX = 'Test';

    private ClientInterface $client;

    public function __construct(
    ) {
        $this->client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts(['http://elasticsearch:9200'])
            ->build();
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->create([
            'title' => 'asdf',
            'name' => 'qqqqq',
            'type' => 2
        ]);

        var_dump($response);

        return Command::SUCCESS;
    }

    private function create(array $data)
    {
        return $this->client->index([
            'index' => self::INDEX,
            'body' => ['doc' => $data],
        ]);
    }

    private function update(string $id, array $data)
    {
        return $this->client->update([
            'index' => self::INDEX,
            'id' => $id,
            'body' => $data,
        ]);
    }

    private function delete(string $id): void
    {
        $this->client->delete([
            'index' => self::INDEX,
            'id' => $id,
        ]);
    }
}
