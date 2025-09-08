<?php

namespace App\Licensing\Infrastructure\ReadModel\Elastic;

use App\Licensing\ReadModel\Client\ClientDTO;
use App\Licensing\ReadModel\Client\ClientReadModelInterface;
use Elastic\Elasticsearch\ClientBuilder;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ElasticClientReadModel implements ClientReadModelInterface
{
    const INDEX = 'clients';

    public function __construct(
        private NormalizerInterface $normalizer,
        private DenormalizerInterface $denormalizer,
    ) {
    }

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
                'body' => [
                    'mappings' => [
                        'properties' => [
                            'name' => ['type' => 'text'],
                            'description' => ['type' => 'text'],
                            'licenseType' => ['type' => 'text']
                        ]
                    ]
                ]
            ]);
        }

        return $client;
    }

    public function create(ClientDTO $clientDTO): void
    {
        $data = $this->normalizer->normalize($clientDTO);
        $this->getClient()->index([
            'index' => self::INDEX,
            'refresh' => true,
            'id' => $clientDTO->id,
            'body' => $data,
        ]);
    }

    public function update(string $id, array $data): void
    {
        $this->getClient()->update([
            'index' => self::INDEX,
            'id' => $id,
            'body' => [
                'doc' => $data,
            ]
        ]);
    }

    public function delete(string $id): void
    {
        $this->getClient()->delete([
            'index' => self::INDEX,
            'id' => $id,
        ]);
    }

    public function listAll(): array
    {
        $params = [
            'index' => self::INDEX,
            'body' => [
                'query' => [
                    'match_all' => new \stdClass(),
                ]
            ]
        ];
        $response = $this->getClient()->search($params)->asArray();
        $result = [];
        foreach ($response['hits']['hits'] as $hit) {
            $result[] = $this->denormalizer->denormalize($hit['_source'], ClientDTO::class);
        }
        return $result;
    }

    public function getById(string $id): ?ClientDTO
    {
        $result = $this->getClient()->get(['index' => self::INDEX, 'id' => $id])->asArray();
        $clientDTO = $this->denormalizer->denormalize($result['_source'], ClientDTO::class);
        return $clientDTO;
    }
}
