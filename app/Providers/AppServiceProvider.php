<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Calculo\CalculoService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       $this->app->bind('calculo', function () {
            return new CalculoService;
        });
    }
}
