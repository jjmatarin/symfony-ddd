<?php

namespace App\Tests\E2E;

use App\Common\Domain\Model\EntityId;

class ClientsTest extends AbstractTestBase
{
    public function testListClients(): void
    {
        $this->init();

        $response = $this->request('GET', '/api/v1/clients');
        $prevCount = count($response);

        $id = EntityId::generate()->get();
        $this->request('POST', '/api/v1/clients', [
            'id' => $id,
            'name' => 'Test Client',
            'email' => 'asdf@asdf.com',
            'description' => 'Test Client desc',
            'licenseType' => 'basic',
            'productId' => '01K5RW4NQ6XM1NJ3CYDDTR2TKV',
        ], [], 204);
        sleep(2);

        $response = $this->request('GET', '/api/v1/clients');
        $this->assertCount($prevCount + 1, $response);

        $response = $this->request('GET', '/api/v1/clients/' . $id);
        $this->assertEquals('Test Client', $response['name']);
        $this->assertEquals('asdf@asdf.com', $response['email']);
        $this->assertEquals('basic', $response['activeLicenseType']);

        $this->request('PUT', '/api/v1/clients/' . $id, [
            'name' => 'Test Client updated',
            'email' => 'asdf@asdf.com',
            'description' => 'Test Client updated',
        ], [], 204);
        sleep(1);

        $response = $this->request('GET', '/api/v1/clients/' . $id);
        $this->assertEquals('Test Client updated', $response['name']);
        $this->assertEquals('basic', $response['activeLicenseType']);

        $this->request('PATCH', '/api/v1/clients/' . $id, [
            'licenseType' => 'medium',
            'productId' => '01K5RW9AYM7V911BJM8RFCB8W3',
        ], [], 204);
        sleep(1);

        $response = $this->request('GET', '/api/v1/clients/' . $id);
        $this->assertEquals('Test Client updated', $response['name']);
        $this->assertEquals('medium', $response['activeLicenseType']);

//        $this->request('DELETE', '/api/v1/clients/' . $id, [], [], 204);
//        sleep(2);
//
//        $response = $this->request('GET', '/api/v1/clients');
//        $this->assertCount($prevCount, $response);
    }
}
