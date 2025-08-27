<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

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

        // Define Gates
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('superadmin', function ($user) {
            return $user->role === 'superadmin';
        });

        Gate::define('user', function ($user) {
            return $user->role === 'user';
        });

        // Share jumlah aduan baru ke semua view
        View::composer('*', function ($view) {
            $user = Auth::user();
            $newReportsCount = 0;

            if ($user) {
                if ($user->role === 'superadmin') {
                    // Superadmin -> hitung semua aduan yang masih diajukan
                    $newReportsCount = Report::where('status', Report::STATUS_DIAJUKAN)->count();
                } elseif ($user->role === 'admin') {
                    // Admin -> hitung aduan yang kategori_umum.admin_id = admin login
                    $newReportsCount = Report::where('status', Report::STATUS_DIAJUKAN)
                        ->whereHas('kategori', function ($q) use ($user) {
                            $q->where('admin_id', $user->id_user);
                        })
                        ->count();
                }
                // Role 'user' -> biarkan default 0
            }

            $view->with('newReportsCount', $newReportsCount);
        });
    }
}
