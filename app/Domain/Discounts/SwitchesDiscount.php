<?php

namespace App\Domain\Discounts;

class SwitchesDiscount extends Discount
{
    public function applyDiscount(array $orderData, array $clientData, array $productData): array
    {
        $applyForProducts = [];
        foreach ($productData as $product) {
            if ($product['product-category'] == 2 && $product['quantity'] >= 5) {
                $applyForProducts[] = $product['product-id'];
            }
        }

        $orderData = $this->applyFreeProduct($orderData, $applyForProducts);

        return $orderData;
    }

    protected function applyFreeProduct(array $orderData, array $applyForProducts): array
    {
        foreach ($orderData['items'] as $orderItem) {
            if (in_array($orderItem['product-id'], $applyForProducts)) {
                if ($orderItem['quantity'] == 5) {
                    $orderItem['quantity']++;
                } else {
                    $orderItem['total'] -= $orderItem['unit-price'];
                }
                $orderData['discount'][] = [
                    'SwitchesDiscount' => $orderItem['unit-price']
                ];
            }
        }

        return $orderData;
    }
}
