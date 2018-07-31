<?php

namespace App\Domain\Gateways;

class ProductsGateway
{
    const DATA_SOURCE = 'products';
    use JsonAPITrait;

    public function getProducts(array $filters = []): array
    {
        $products = $this->getData(static::DATA_SOURCE, $filters);

        return $products;
    }
}