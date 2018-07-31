<?php

namespace App\Domain\Repositories;

use App\Domain\Gateways\ProductsGateway;

class ProductsRepository
{
    /** @var  ProductsGateway */
    protected $productsGateway;

    public function __construct(ProductsGateway $productsGateway)
    {
        $this->productsGateway = $productsGateway;
    }

    public function getProduct(string $productId):array
    {
        return $this->productsGateway->getProducts(['id' => $productId]);
    }
}