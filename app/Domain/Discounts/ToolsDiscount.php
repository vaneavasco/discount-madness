<?php

namespace App\Domain\Discounts;

class ToolsDiscount extends Discount
{
    function applyDiscount(array $orderData, array $clientData, array $productData): array
    {
        $cheapest = ['id' => 0, 'val' => 0];
        $tools = array_filter($productData, function($item) use ($cheapest){
            if($item['product-category'] == 1) {
                if($cheapest['id'] == 0 || $cheapest['val'] > $item['unit-price']) {
                    $cheapest['id'] = $item['product-id'];
                    $cheapest['val'] = $item['unit-price'];
                }
                return true;
            }
            return false;
        });

        return $this->apply20Percent($orderData, $tools, $cheapest);
    }

    protected function apply20Percent($orderData, $tools, $cheapest)
    {
        if(count($tools) > 1) {
            foreach($orderData['items'] as $item) {
                if($item['productId'] == $cheapest['id']) {
                    $orderData['discount'][] = [
                        'ToolsDiscount' => round($item['unit-price'] * 0.2,2)
                    ];
                }
            }
        }

        return $orderData;
    }
}
