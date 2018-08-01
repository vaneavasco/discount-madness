<?php

namespace App\Domain\Discounts;

/**
 * Class Over1000Discount
 * @package App\Domain\Discounts
 */
class Over1000Discount extends Discount
{
    /**
     * @param array $orderData
     * @param array $clientData
     * @param array $productData
     *
     * @return array
     */
    function applyDiscount(array $orderData, array $clientData, array $productData): array
    {
        $discount = [];
        if($clientData['revenue'] > 1000) {
            $discount = [
                'over1000Discount' => ['totalDiscount' => 10]
            ];
        }

        return $discount;
    }
}
