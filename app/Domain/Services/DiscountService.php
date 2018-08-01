<?php

namespace App\Domain\Services;

use App\Domain\Discounts\Discount;
use App\Domain\Repositories\CustomersRepository;
use App\Domain\Repositories\ProductsRepository;

/**
 * Class DiscountService
 * @package App\Domain\Services
 */
class DiscountService
{
    /** @var  CustomersRepository */
    protected $customersRepository;
    /** @var  ProductsRepository */
    protected $productsRepository;

    /** @var Discount[] */
    protected $discounts = [];

    /**
     * DiscountService constructor.
     *
     * @param CustomersRepository $customerRepository
     * @param ProductsRepository $productsRepository
     */
    public function __construct(CustomersRepository $customerRepository, ProductsRepository $productsRepository)
    {
        $this->customersRepository = $customerRepository;
        $this->productsRepository  = $productsRepository;
    }

    /**
     * @param array $order
     *
     * @return array
     */
    public function applyDiscount(array $order): array
    {
        $customerData        = $this->customersRepository->getCustomer($order['customer-id']);
        $productData         = $order['items'];
        $completeProductData = array_map(
            function ($item) {
                $productCategoryData      = $this->productsRepository->getProduct($item['product-id']);
                $item['product-category'] = (!empty($productCategoryData)) ? reset($productCategoryData)['category'] : 0;

                return $item;
            },
            $productData
        );
        /**
         * discounts should be applied in the exact order the service returns them
         * otherwise a kind of precedence for discounts should be enforced
         */
        $discounts = [];
        foreach ($this->discounts as $discount) {
            $discounts = array_merge($discounts, $discount->applyDiscount($order, reset($customerData), $completeProductData));
        }

        return $discounts;
    }

    /**
     * @param Discount $discount
     */
    public function addDiscountType(Discount $discount)
    {
        $this->discounts[] = $discount;
    }
}
