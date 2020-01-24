<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Product\ProductRepositoryInterface',
            'App\Repositories\Product\ProductRepository'
        );

        $this->app->bind(
            'App\Services\Product\ProductServiceInterface',
            'App\Services\Product\ProductService'
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
