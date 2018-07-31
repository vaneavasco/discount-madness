<?php
/**
 * Created by PhpStorm.
 * User: vanea
 * Date: 31.07.2018
 * Time: 18:55
 */

namespace App\Domain\Discounts;


abstract class Discount
{
    abstract function applyDiscount(array $orderData, array $clientData, array $productData) : array;
}