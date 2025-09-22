<?php

namespace App\Licensing\Infrastructure\ReadModel\Elastic;

use App\Licensing\ReadModel\Client\ClientDTO;
use App\Licensing\ReadModel\Client\ClientReadModelInterface;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ElasticClientReadModel implements ClientReadModelInterface
{
    const INDEX = 'clients';

    public function __construct(
        private ParameterBagInterface $parameterBag,
        private DenormalizerInterface $denormalizer,
    ) {
    }

    private function getClient()
    {
        $elasticsearchUrl = $this->parameterBag->get('elasticsearch_url');
        $client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts([$elasticsearchUrl])
            ->build();

        $response = $client->indices()->exists(['index' => self::INDEX]);
        if ($response->getStatusCode() != 200) {
            $client->indices()->create([
                'index' => self::INDEX,
            ]);
        }

        return $client;
    }

    public function create(string $id, array $data): void
    {
        $this->getClient()->index([
            'index' => self::INDEX,
            'refresh' => true,
            'id' => $id,
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
        $response = $this->getClient()->search([
            'index' => self::INDEX,
            'body' => [
                'query' => [
                    'match_all' => new \stdClass(),
                ]
            ]
        ])->asArray();

        $result = [];
        foreach ($response['hits']['hits'] as $hit) {
            $result[] = $this->getClientDTO(array_merge($hit['_source'], ['id' => $hit['_id']]));
        }

        return $result;
    }

    public function getById(string $id): ?ClientDTO
    {
        try {
            $result = $this->getClient()->get(['index' => self::INDEX, 'id' => $id])->asArray();
            return $this->getClientDTO(array_merge($result['_source'], ['id' => $id]));
        } catch (ClientResponseException $e) {
            if (404 === $e->getCode()) {
                return null;
            }
            throw $e;
        }
    }

    private function getClientDTO(array $data): ClientDTO
    {
        return $this->denormalizer->denormalize($data, ClientDTO::class);
    }

}