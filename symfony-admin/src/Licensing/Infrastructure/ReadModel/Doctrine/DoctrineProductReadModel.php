<?php

namespace App\Licensing\Infrastructure\ReadModel\Doctrine;

use App\Licensing\Domain\Model\Client\Client;
use App\Licensing\Domain\Model\Client\ClientStatusEnum;
use App\Licensing\Domain\Model\Product\Product;
use App\Licensing\ReadModel\Client\ClientDTO;
use App\Licensing\ReadModel\Client\ClientReadModelInterface;
use App\Licensing\ReadModel\Product\ProductDTO;
use App\Licensing\ReadModel\Product\ProductReadModelInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineProductReadModel extends EntityRepository implements ProductReadModelInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        $metadata = $registry->getManager('read_model')->getClassMetadata(Product::class);
        parent::__construct($registry->getManager('read_model'), $metadata);
    }

    public function getById(string $id): ?ProductDTO
    {
        /** @var Product $product */
        $product = $this->find($id);
        if (null === $product) {
            return null;
        }
        return new ProductDTO(
            $product->getId()->get(),
            $product->getName(),
            $product->getPrice()->getAmount(),
        );
    }
}
