<?php

namespace App\Tests\E2E;

use App\Common\Domain\Model\EntityId;

class ClientsTest extends AbstractTestBase
{
    public function testListClients(): void
    {
        $this->init();

        //$response = $this->request('GET', '/api/v1/clients');
        //$prevCount = count($response['data']);

        $id = EntityId::generate()->get();
        $this->request('POST', '/api/v1/clients', [
            'id' => $id,
            'name' => 'Test Client',
            'email' => 'asdf@asdf.com',
            'description' => 'Test Client desc',
            'licenseType' => 'basic',
            'productId' => EntityId::generate()->get(),
        ], [], 204);
        sleep(1);

//        $response = $this->request('GET', '/api/v1/clients');
//        $this->assertCount($prevCount + 1, $response['data']);
//
//        $response = $this->request('GET', '/api/v1/clients/' . $id);
//        $this->assertEquals('Test Client', $response['data']['name']);
//        $this->assertEquals('asdf@asdf.com', $response['data']['email']);
//        $this->assertEquals('basic', $response['data']['activeLicenseType']);
//
//        $this->request('PUT', '/api/v1/clients/' . $id, [
//            'name' => 'Test Client updated',
//            'email' => 'asdf@asdf.com',
//            'description' => 'Test Client updated',
//        ], [], 204);
//        sleep(1);
//
//        $response = $this->request('GET', '/api/v1/clients/' . $id);
//        $this->assertEquals('Test Client updated', $response['data']['name']);
//        $this->assertEquals('basic', $response['data']['activeLicenseType']);
//
//        $this->request('PATCH', '/api/v1/clients/' . $id, [
//            'licenseType' => 'medium',
//            'productId' => '01K4MNR2BSS8RT5GHGX73WWM5E',
//        ], [], 204);
//        sleep(1);
//
//        $response = $this->request('GET', '/api/v1/clients/' . $id);
//        $this->assertEquals('Test Client updated', $response['data']['name']);
//        $this->assertEquals('medium', $response['data']['activeLicenseType']);
//
//        $this->request('DELETE', '/api/v1/clients/' . $id, [], [], 204);
//        sleep(1);
//
//        $response = $this->request('GET', '/api/v1/clients');
//        $this->assertCount($prevCount, $response['data']);
    }
}