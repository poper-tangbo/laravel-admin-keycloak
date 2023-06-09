<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Extensions\AdminUserProvider;
use App\Extensions\WebUserProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::provider('web-user', function (Application $app, array $config) {
            return new WebUserProvider($config['model']);
        });
        Auth::provider('admin-user', function (Application $app, array $config) {
            return new AdminUserProvider($config['model']);
        });
    }
}
