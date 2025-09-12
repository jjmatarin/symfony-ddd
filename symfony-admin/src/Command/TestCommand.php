<?php

namespace App\Command;

use App\Common\Bus\CommandBusInterface;
use App\Common\Domain\Model\Currency;
use App\Common\Domain\Model\EntityId;
use App\Common\Domain\Model\Money;
use App\Licensing\Application\Client\CreateClient\CreateClientCommand;
use App\Licensing\Application\Client\UpdateClient\UpdateClientCommand;
use App\Licensing\Domain\Model\Product\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:test',
    description: 'Add a short description for your command',
)]
class TestCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CommandBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /*
        $price = new Price(new Money(150, new Currency('EUR')), new \DateTimeImmutable());
        $formativeAction = new Product(
            id: EntityId::generate(),
            name: 'Test formative action',
            description: 'Test formative action',
            price: $price
        );

        $this->entityManager->persist($formativeAction);
        $this->entityManager->flush();

        $product = $this->entityManager->find(Product::class, EntityId::fromString('01K4MNR2BSS8RT5GHGX73WWM5E'));
        $product->changePrice(new Money(120, new Currency('EUR')));
        var_dump($product);
        $this->entityManager->flush();

        $command = new CreateClientCommand(
            name: 'Testttttasdf',
            description: 'Desc...',
            licenseType: 'basic',
            productId: '01K4MNR2BSS8RT5GHGX73WWM5E'
        );
        $this->commandBus->execute($command);
        */

        $command = new UpdateClientCommand(
            id: '01K4ZEPT2KYV0CZ36MA7RGG70Z',
            name: 'Testttttasdf updated',
            description: 'Desc... basdf sadf asdf asdf asd fasd f'
        );
        $this->commandBus->execute($command);

        return Command::SUCCESS;
    }
}
