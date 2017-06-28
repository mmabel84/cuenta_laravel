<?php

namespace App\Providers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);


        Validator::extend('rfc', function ($attribute, $value, $parameters, $validator) {
            
            $resultm = preg_match('/^[A-ZÑ&]{3}([0-9]{2})([0-1][0-9])([0-3][0-9])[A-Z0-9][A-Z0-9][0-9A]$/u', $value, $matchesm);
            $resultf = preg_match('/^[A-ZÑ&]{4}([0-9]{2})([0-1][0-9])([0-3][0-9])[A-Z0-9][A-Z0-9][0-9A]$/u', $value, $matchesf);
            if (!$resultm && !$resultf) {
                return false;
            }

            if (count($matchesm)  > 0)
            {
                if ((int) $matchesm[1] <= 12) {
                $matchesm[1] = 2000 + (int) $matchesm[1];
                } 
                else {
                $matchesm[1] = 1900 + (int) $matchesm[1];
                }

                $strtotimeresultm = strtotime($matchesm[1] . '-' . $matchesm[2] . '-' . $matchesm[3]);

            }
            else
            {
                $strtotimeresultm = false;
            }
            
            if (count($matchesf) > 0){
                if ((int) $matchesf[1] <= 12) {
                $matchesf[1] = 2000 + (int) $matchesf[1];
                } else {
                $matchesf[1] = 1900 + (int) $matchesf[1];
                }

                $strtotimeresultf = strtotime($matchesf[1] . '-' . $matchesf[2] . '-' . $matchesf[3]);

            }
            else
            {
                $strtotimeresultf = false;

            }
            
            return $strtotimeresultm || $strtotimeresultf ? true : false;
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
