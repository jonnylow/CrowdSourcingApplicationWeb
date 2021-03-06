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
        // Custom Validator to check that name contains only letters or whitespaces
        Validator::extend('alpha_space', function($attribute, $value) {
            if (preg_match('/^[\s]+$/u', $value)) {
                return false;
            }

            return is_string($value) && preg_match('/^[\pL\pM\s]+$/u', $value);
        });

        // Custom Validator to check that location contains only letters, numbers, or whitespaces
        Validator::extend('alpha_num_space', function($attribute, $value) {
            if (preg_match('/^[\s]+$/u', $value)) {
                return false;
            }

            return is_string($value) && preg_match('/^[\pL\pM\pN\s]+$/u', $value);
        });

        // Custom Validator to check that the string contains only number (1 or 2 digits, leading 0s or not, not zero)
        // integer_between:min,max - int value must be between min and max.
        Validator::extend('integer_between', function($attribute, $value, $parameters) {
            if (count($parameters) !== 2) {
                return false;
            } else {
                if(is_string($value) && strlen($value) == 1) {
                    if (filter_var($value, FILTER_VALIDATE_INT) === 0 || filter_var($value, FILTER_VALIDATE_INT)) {
                        return $value >= $parameters[0] && $value <= $parameters[1];
                    }
                } else if (is_string($value) && strlen($value) == 2) {
                    if (filter_var($value, FILTER_VALIDATE_INT)) {
                        return $value >= $parameters[0] && $value <= $parameters[1];
                    } else if (filter_var(substr($value, 0, 1), FILTER_VALIDATE_INT) === 0) {
                        if(filter_var(substr($value, 1), FILTER_VALIDATE_INT) === 0 || filter_var(substr($value, 1), FILTER_VALIDATE_INT)) {
                            return $value >= $parameters[0] && $value <= $parameters[1];
                        }
                    }
                }
            }
            return false;
        });

        // Custom Validator to check that the string contains only number, number of digits to specify (leading 0s or not, not zero)
        // integer_digits_and_between:digit,min,max - digit is the number of digits, int value must be between min and max.
        Validator::extend('integer_digits_and_between', function($attribute, $value, $parameters) {
            if (count($parameters) !== 3) {
                return false;
            } else {
                if(is_string($value) && strlen($value) == $parameters[0]) {
                    if (filter_var($value, FILTER_VALIDATE_INT)) {
                        return $value >= $parameters[1] && $value <= $parameters[2];
                    } else if (filter_var(substr($value, 0, 1), FILTER_VALIDATE_INT) === 0) {
                        if(filter_var(substr($value, 1), FILTER_VALIDATE_INT) === 0 || filter_var(substr($value, 1), FILTER_VALIDATE_INT)) {
                            return $value >= $parameters[1] && $value <= $parameters[2];
                        }
                    }
                }
            }
            return false;
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
