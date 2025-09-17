<?php

namespace App\Tests\E2E;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AbstractTestBase extends WebTestCase
{
    protected ?KernelBrowser $client = null;

    protected function init(): void
    {
        self::ensureKernelShutdown();
        $this->client = static::createClient();
    }

    protected function request(string $method, string $url, array $body = [], array $headers = [], ?int $assertResponseCode = 200): ?array
    {
        $this->client->jsonRequest($method, $url, $body, $headers);
        $this->client->followRedirects();
        $response = $this->client->getResponse();
        if ($response->getStatusCode() == 500) {
            var_dump($response->getContent());
        }
        if ($assertResponseCode !== null) {
            $this->assertEquals($assertResponseCode, $response->getStatusCode());
        }
        $this->assertNotEquals(500, $response->getStatusCode());
        $content = $response->getContent();
        if ($content == null) {
            return null;
        }
        return json_decode($content, true);
    }

}
