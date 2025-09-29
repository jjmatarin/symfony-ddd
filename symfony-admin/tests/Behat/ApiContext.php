<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Behat\Step\Then;
use Behat\Step\When;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class ApiContext implements Context
{
    private KernelInterface $kernel;

    private Response $response;

    private KernelBrowser $client;

    private array $content;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->client = $this->kernel->getContainer()->get('test.client');
    }

    #[Then('the response should be valid')]
    public function theResponseShouldBeValid(): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }
        Assert::assertNotEquals(500, $this->response->getStatusCode());
    }

    #[When('I request :url')]
    public function iRequest(string $url): void
    {
        $this->client->followRedirects();
        $this->client->jsonRequest('GET', $url);
        $this->response = $this->client->getResponse();
        $this->content = json_decode($this->response->getContent(), true);
    }

    #[Then('the response data is a array of length :length')]
    public function theResponseDataIsAArrayOfLength(int $length): void
    {
        Assert::assertCount($length, $this->content);
    }

    #[Then('the response data index :index as values:')]
    public function theResponseDataIndexAsValues(int $index, TableNode $values): void
    {
        $item = $this->content[$index];
        $valueList = $values->getRowsHash();
        foreach ($valueList as $key => $value) {
            Assert::assertEquals($value, $item[$key]);
        }
    }

    #[Then('the response data has values:')]
    public function theResponseDataAsValues(TableNode $values): void
    {
        $item = $this->content;
        $valueList = $values->getRowsHash();
        foreach ($valueList as $key => $value) {
            Assert::assertEquals($value, $item[$key]);
        }
    }

    /**
     * @When /^lo que sea$/
     */
    public function loQueSea()
    {
        throw new PendingException();
    }
}
