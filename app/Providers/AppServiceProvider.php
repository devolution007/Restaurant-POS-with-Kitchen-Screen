<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        Schema::defaultStringLength(191);
        Str::macro('sku', function ($name) {
            // Clean up the source
            $name = Str::studly($name);
            // Limit the source
            $name = Str::limit($name, 3, '');
            // signature
            $signature = str_shuffle(str_repeat(str_pad(time(), 8, rand(0, 9) . rand(0, 9), STR_PAD_LEFT), 2));
            // Sanitize the signature
            $signature = substr($signature, 0, 6);
            // Implode with random
            $result = implode('-', [$name, $signature]);
            // Uppercase it
            return Str::upper($result);
        });
    }
}
