<?php

namespace App\Providers;

use App\AmoCrm\AmoCrmClientFactory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AmoCrmClientFactory::class, function (Container $app) {
            $factory = new AmoCrmClientFactory(config('services')['amocrm']);
            return $factory;
        });
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
