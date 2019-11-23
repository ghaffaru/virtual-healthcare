<?php

namespace App\Providers;

use Route;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\HospitalEvent' => 'App\Policies\HospitalEventPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::tokensExpireIn(now()->addDays(15));
        
        Passport::routes(null, ['middleware' => [\Barryvdh\Cors\HandleCors::class]]);

        Route::group(['middleware' => ['oauth.providers', \Barryvdh\Cors\HandleCors::class]], function () {
            
            Passport::routes(function ($router) {
                return $router->forAccessTokens();
            });
        });

    }
}
