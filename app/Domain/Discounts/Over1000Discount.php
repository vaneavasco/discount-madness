<?php

namespace App\Domain\Discounts;

class Over1000Discount extends Discount
{
    function applyDiscount(array $orderData, array $clientData, array $productData): array
    {
        if($clientData['revenue'] > 1000) {
            $orderData['discount'][] = [
                'Over1000Discount' => round($orderData['total'] * 0.1, 2)
            ];
        }

        return $orderData;
    }
}