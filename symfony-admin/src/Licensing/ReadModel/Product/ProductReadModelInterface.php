<?php

namespace App\Licensing\ReadModel\Product;

interface ProductReadModelInterface
{
    public function getById(string $id): ?ProductDTO;
}
