<?php

namespace Client;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

require __DIR__.'/../../vendor/autoload.php';

class ApiClient
{
    private HttpClientInterface $httpClient;
    private Serializer $serializer;

    public static function getInstance()
    {
        return new self();
    }

    public function __construct()
    {
        $this->httpClient = HttpClient::create();
        $this->serializer = new Serializer([new ObjectNormalizer(), new ArrayDenormalizer()], [new JsonEncoder()]);
    }

    public function query(string $endpoint, ?string $responseType = null): mixed
    {
        $response = $this->httpClient->request('GET', $endpoint, []);
        $content = $response->getContent();
        if ($responseType === null) {
            return $content;
        }
        return $this->serializer->deserialize($content, $responseType, 'json');
    }

    public function post(string $endpoint, mixed $payload): void
    {
        $this->httpClient->request('POST', $endpoint, [
            'json' => $this->serializer->normalize($payload)
        ]);
    }
}
