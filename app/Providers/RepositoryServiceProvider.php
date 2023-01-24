<?php

namespace App\Providers;

use App\Interfaces\MenuInterface;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserInterface;
use App\Interfaces\StripeInterface;
use App\Interfaces\ReservationInterface;
use App\Repositories\UserRepository;
use App\Repositories\StripeRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\MenuRepository;

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
        $this->app->bind(ReservationInterface::class, ReservationRepository::class);
    }
}
