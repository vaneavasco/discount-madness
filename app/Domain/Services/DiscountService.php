<?php

namespace App\Domain\Services;

use App\Domain\Discounts\Discount;
use App\Domain\Repositories\CustomersRepository;
use App\Domain\Repositories\ProductsRepository;

class DiscountService
{
    /** @var  CustomersRepository */
    protected $customersRepository;
    /** @var  ProductsRepository */
    protected $productsRepository;

    /** @var Discount[] */
    protected $discounts = [];

    public function __construct(CustomersRepository $customerRepository, ProductsRepository $productsRepository)
    {
        $this->customersRepository = $customerRepository;
        $this->productsRepository  = $productsRepository;
    }

    public function applyDiscount(array $order): array
    {
        $customerData = $this->customersRepository->getCustomer($order['customer-id']);
        $productData  = $order['items'];
        $completeProductData = array_map(
            function ($item) {
                $productCategoryData      = $this->productsRepository->getProduct($item['product-id']);
                $item['product-category'] = (!empty($productCategoryData)) ? reset($productCategoryData)['category'] : 0;

                return $item;
            },
            $productData
        );

        foreach ($this->discounts as $discount) {
            $discount->applyDiscount($order, reset($customerData), $completeProductData);
        }

        return $order;
    }

    public function addDiscount(Discount $discount)
    {
        $this->discounts[] = $discount;
    }
}