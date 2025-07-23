<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // You can register services here if needed
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        setlocale(LC_TIME, 'id_ID.UTF-8');
        
        // Set the pagination view to use Tailwind CSS
        Paginator::useTailwind();

        // Define a Gate to check if the user is an admin
        Gate::define('admin', function ($user) {
            return $user->role === 'admin'; // Ensure this is based on the role
        });

        // Define a Gate to check if the user is a superadmin
        Gate::define('superadmin', function ($user) {
            return $user->role === 'superadmin'; // Check if the role is superadmin
        });

        // Define a Gate to check if the user is a general user
        Gate::define('user', function ($user) {
            return $user->role === 'user'; // Ensure this is based on the role
        });
    }
}
