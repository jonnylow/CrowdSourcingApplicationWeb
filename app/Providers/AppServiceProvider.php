<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Custom Validator to check that name contains only letters, whitespaces or any of these characters (/, ', -)
        Validator::extend('name', function($attribute, $value, $parameters, $validator) {
            return is_string($value) && preg_match('/^[\pL\pM\s\/\'-]+$/u', $value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
