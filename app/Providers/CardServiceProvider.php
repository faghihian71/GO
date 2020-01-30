<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CardServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Card\CardRepositoryInterface',
            'App\Repositories\Card\CardRepository'
        );

        $this->app->bind(
            'App\Services\Card\CardServiceInterface',
            'App\Services\Card\CardService'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
