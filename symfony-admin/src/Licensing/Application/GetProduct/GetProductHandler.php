<?php

namespace App\Licensing\Application\GetProduct;

use App\Common\Bus\QueryHandlerInterface;
use App\Common\Domain\Exception\NotFoundException;
use App\Common\Domain\Model\EntityId;
use App\Licensing\ReadModel\Product\ProductDTO;
use App\Licensing\ReadModel\Product\ProductReadModelInterface;

readonly class GetProductHandler implements QueryHandlerInterface
{
    public function __construct(
        private ProductReadModelInterface $productReadModel,
    ) {
    }

    public function __invoke(GetProductQuery $command): GetProductResponse
    {
        /** @var ProductDTO $product */
        $product = $this->productReadModel->getById(EntityId::fromString($command->id));
        if ($product === null) {
            throw new NotFoundException("Product not found");
        }

        return new GetProductResponse(
            id: $product->id,
            name: $product->name,
            price: $product->price,
        );
    }
}
