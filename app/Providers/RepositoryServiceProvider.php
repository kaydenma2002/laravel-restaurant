<?php

namespace App\Providers;

use App\Interfaces\MenuInterface;
use App\Repositories\MenuRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\ClaimInterface;
use App\Repositories\ClaimRepository;
use App\Interfaces\UserInterface;
use App\Repositories\UserRepository;
use App\Interfaces\StripeInterface;
use App\Repositories\StripeRepository;
use App\Interfaces\OrderInterface;
use App\Repositories\OrderRepository;
use App\Interfaces\CartInterface;

use App\Repositories\CartRepository;
use App\Interfaces\RestaurantInterface;
use App\Repositories\RestaurantRepository;
use App\Repositories\AdminRepository;
use App\Interfaces\AdminInterface;
use App\Repositories\ItemRepository;
use App\Interfaces\ItemInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(MenuInterface::class, MenuRepository::class);
        $this->app->bind(StripeInterface::class, StripeRepository::class);
        $this->app->bind(ClaimInterface::class,ClaimRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);
        $this->app->bind(CartInterface::class, CartRepository::class);
        $this->app->bind(RestaurantInterface::class, RestaurantRepository::class);
        $this->app->bind(AdminInterface::class, AdminRepository::class);
        $this->app->bind(ItemInterface::class, ItemRepository::class);
    }
}
