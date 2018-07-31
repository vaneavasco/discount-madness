<?php
namespace App\Domain\Gateways;

class CustomersGateway
{
    const DATA_SOURCE = 'customers';
    use JsonAPITrait;

    public function getCustomers(array $filters = []): array
    {
        $products = $this->getData(static::DATA_SOURCE, $filters);

        return $products;
    }
}