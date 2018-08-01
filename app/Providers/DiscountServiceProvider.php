<?php

namespace App\Providers;

use App\Domain\Discounts\Over1000Discount;
use App\Domain\Discounts\SwitchesDiscount;
use App\Domain\Discounts\ToolsDiscount;
use App\Domain\Gateways\CustomersGateway;
use App\Domain\Gateways\ProductsGateway;
use App\Domain\Repositories\CustomersRepository;
use App\Domain\Repositories\ProductsRepository;
use App\Domain\Services\DiscountService;
use Illuminate\Support\ServiceProvider;

class DiscountServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CustomersRepository::class, function ($app) {
            return new CustomersRepository(
                $app->make(CustomersGateway::class)
            );
        });

        $this->app->singleton(ProductsRepository::class, function ($app) {
            return new ProductsRepository(
                $app->make(ProductsGateway::class)
            );
        });

        $this->app->singleton(DiscountService::class, function ($app) {
            $discountService = new DiscountService(
                $app->make(CustomersRepository::class),
                $app->make(ProductsRepository::class)
            );

            $discountService->addDiscountType(new SwitchesDiscount());
            $discountService->addDiscountType(new ToolsDiscount());
            $discountService->addDiscountType(new Over1000Discount());

            return $discountService;
        });

    }
}