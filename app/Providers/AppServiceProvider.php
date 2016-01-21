<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Custom Validator to check that name contains only letters, whitespaces or any of these characters ('/', ',', '-')
        Validator::extend('name', function($attribute, $value) {
            return is_string($value) && preg_match('/^[\pL\pM\s\/,-]+$/u', $value);
        });

        // Custom Validator to check that valid Singapore phone numbers
        Validator::extend('sg_phone', function($attribute, $value) {
            return is_numeric($value)
            && strlen((string) $value) == 8
            && Str::startsWith((string) $value, ['6', '8', '9']);
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
