<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ProductImageRepository;
use App\Repositories\Eloquent\SizeRepository;
use App\Repositories\Eloquent\BrandRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\AccountRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\OrderItemRepository;
use App\Repositories\Eloquent\TempImageRepository;
use App\Repositories\Eloquent\ProductSizeRepository;
use App\Repositories\Eloquent\ShippingRepository;
use App\Repositories\Contracts\SizeRepositoryInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use app\Repositories\Contracts\OrderItemRepositoryInterface;
use App\Repositories\Contracts\TempImageRepositoryInterface;
use App\Repositories\Contracts\ProductSizeRepositoryInterface;
use App\Repositories\Interfaces\ProductImageRepositoryInterface;
use App\Repositories\Contracts\ShippingRepositoryInterface;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class

        );
        $this->app->bind(
            BrandRepositoryInterface::class,
            BrandRepository::class

        );
        $this->app->bind(
            SizeRepositoryInterface::class,
            SizeRepository::class

        );
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class

        );
        $this->app->bind(
            TempImageRepositoryInterface::class,
            TempImageRepository::class

        );
         $this->app->bind(
        ProductImageRepositoryInterface::class,
        ProductImageRepository::class
    );
         $this->app->bind(
        ProductSizeRepositoryInterface::class,
        ProductSizeRepository::class
    );
         $this->app->bind(
        AccountRepositoryInterface::class,
        AccountRepository::class
    );
         $this->app->bind(
        OrderRepositoryInterface::class,
        OrderRepository::class
    );
         $this->app->bind(
        OrderItemRepositoryInterface::class,
        OrderItemRepository::class
    );
         $this->app->bind(
        ShippingRepositoryInterface::class,
        ShippingRepository::class
    );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
