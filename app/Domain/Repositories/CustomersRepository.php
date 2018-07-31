<?php
/**
 * Created by PhpStorm.
 * User: vanea
 * Date: 31.07.2018
 * Time: 18:13
 */

namespace App\Domain\Repositories;


use App\Domain\Gateways\CustomersGateway;

class CustomersRepository
{
    /** @var  CustomersGateway */
    protected $customersGateway;

    public function __construct(CustomersGateway $customersGateway)
    {
        $this->customersGateway = $customersGateway;
    }

    public function getCustomer(string $customerId)
    {
        return $this->customersGateway->getCustomers(['id' => $customerId]);
    }
}