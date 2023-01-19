<?php

namespace App\Providers;

use App\Interfaces\MenuInterface;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserInterface;
use App\Repositories\MenuRepository;
use App\Repositories\UserRepository;
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
    }
}
