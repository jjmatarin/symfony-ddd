<?php

namespace App\Management\Infrastructure\Persistence\Elasticsearch;

use App\Management\Domain\Model\Owner\Owner;
use App\Management\Domain\Model\Owner\OwnerId;
use App\Management\Domain\Model\Owner\OwnerRepositoryInterface;
use App\Shared\Domain\Model\Email;
use App\Shared\Domain\Model\ShortDescription;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticOwnerRepository implements OwnerRepositoryInterface
{
    const INDEX = 'owners';

    private function getClient()
    {
        $client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts(['http://elasticsearch:9200'])
            ->build();

        $response = $client->indices()->exists(['index' => self::INDEX]);
        if ($response->getStatusCode() != 200) {
            $client->indices()->create([
                'index' => self::INDEX,
            ]);
        }

        return $client;
    }

    public function getById(OwnerId $id): ?Owner
    {
        $result = $this->getClient()->get(['index' => self::INDEX, 'id' => $id->value])->asArray();
        $data = $result['_source'];

        $reflectionClass = new \ReflectionClass(Owner::class);
        $entity = $reflectionClass->newInstanceWithoutConstructor();
        $reflectionClass->getProperty('id')->setValue($entity, OwnerId::fromString($data['id']));
        $reflectionClass->getProperty('email')->setValue($entity, Email::fromString($data['email']));
        $reflectionClass->getProperty('name')->setValue($entity, ShortDescription::fromString($data['name']));

        return $entity;
    }

    public function persist(Owner $owner): void
    {
        $data = [
            'id' => $owner->getId()->value,
            'name' => $owner->getName()->value,
            'email' => $owner->getEmail()->value,
        ];
        $this->getClient()->index([
            'index' => self::INDEX,
            'refresh' => true,
            'id' => $owner->getId()->value,
            'body' => $data,
        ]);
    }
}
