<?php

namespace App\Tests\E2E;

class ClientsTest extends AbstractTestBase
{
    public function testCreateUpdateAndDeleteClient(): void
    {
        $this->init();
        $response = $this->request('GET', '/api/v1/clients');
        $prevCount = count($response['data']);

        $response = $this->request('POST', '/api/v1/clients', [
            'name' => 'Test Client',
            'description' => 'Test Client desc',
            'licenseType' => 'basic',
            'productId' => '01K4MNR2BSS8RT5GHGX73WWM5E',
        ]);
        $id = $response['data']['id'];
        sleep(2);

        $response = $this->request('GET', '/api/v1/clients');
        $this->assertCount($prevCount + 1, $response['data']);

        $response = $this->request('GET', '/api/v1/clients/' . $id);
        $this->assertEquals('Test Client', $response['data']['name']);
        $this->assertEquals('Test Client desc', $response['data']['description']);
        $this->assertEquals('basic', $response['data']['licenseType']);

        $this->request('PUT', '/api/v1/clients/' . $id, [
            'name' => 'Test Client bla',
            'description' => 'Test Client desc ble',
        ], [], 204);
        sleep(2);

        $response = $this->request('GET', '/api/v1/clients/' . $id);
        $this->assertEquals('Test Client bla', $response['data']['name']);
        $this->assertEquals('Test Client desc ble', $response['data']['description']);
        $this->assertEquals('basic', $response['data']['licenseType']);

        $this->request('PATCH', '/api/v1/clients/' . $id, [
            'licenseType' => 'medium',
            'productId' => '01K4MNR2BSS8RT5GHGX73WWM5E',
        ], [], 204);
        sleep(2);

        $response = $this->request('GET', '/api/v1/clients/' . $id);
        $this->assertEquals('Test Client bla', $response['data']['name']);
        $this->assertEquals('Test Client desc ble', $response['data']['description']);
        $this->assertEquals('medium', $response['data']['licenseType']);

        $this->request('DELETE', '/api/v1/clients/' . $id, [], [], 204);
        sleep(2);

        $response = $this->request('GET', '/api/v1/clients');
        $this->assertCount($prevCount, $response['data']);

    }
}
