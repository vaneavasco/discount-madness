<?php

namespace App\Domain\Discounts;

/**
 * Class SwitchesDiscount
 * @package App\Domain\Discounts
 */
/**
 * Class SwitchesDiscount
 * @package App\Domain\Discounts
 */
class SwitchesDiscount extends Discount
{
    /**
     * @param array $orderData
     * @param array $clientData
     * @param array $productData
     *
     * @return array
     */
    public function applyDiscount(array $orderData, array $clientData, array $productData): array
    {
        $applyForProducts = [];
        foreach ($productData as $product) {
            if ($product['product-category'] == 2 && $product['quantity'] >= 5) {
                $applyForProducts[] = $product['product-id'];
            }
        }

        $discount = $this->applyFreeProduct($orderData, $applyForProducts);

        return $discount;
    }

    /**
     * @param array $orderData
     * @param array $applyForProducts
     *
     * @return array
     */
    protected function applyFreeProduct(array $orderData, array $applyForProducts): array
    {
        $discount = [];
        foreach ($orderData['items'] as $orderItem) {
            if (in_array($orderItem['product-id'], $applyForProducts)) {
                if ($orderItem['quantity'] == 5) {
                    $discount['switchesDiscount'] = [
                        'bonusFreeItem' => [
                            $orderItem['product-id']
                        ]
                    ];
                } else {
                    $discount['switchesDiscount'] = [
                        'itemDiscount' => [
                            $orderItem['product-id'] => 100
                        ]
                    ];
                }
            }
        }

        return $discount;
    }
}
