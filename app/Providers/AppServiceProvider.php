<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Report;
use App\Models\WbsReport;
use App\Http\Middleware\RecordViewMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register services here if needed
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        setlocale(LC_TIME, 'id_ID.UTF-8');

        // Set the pagination view to use Tailwind CSS
        Paginator::useTailwind();

        // Inject RecordViewMiddleware ke group 'web'
        app('router')->pushMiddlewareToGroup('web', RecordViewMiddleware::class);

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

        // Share global data ke semua view
        View::composer('*', function ($view) {
            $user = Auth::user();

            // 🔹 Jumlah aduan baru
            $newReportsCount = 0;
            if ($user) {
                if ($user->role === 'superadmin') {
                    $newReportsCount = Report::where('status', Report::STATUS_DIAJUKAN)->count();
                } elseif ($user->role === 'admin') {
                    $newReportsCount = Report::where('status', Report::STATUS_DIAJUKAN)
                        ->whereHas('kategori', function ($q) use ($user) {
                            $q->where('admin_id', $user->id_user);
                        })
                        ->count();
                } elseif ($user->role === 'wbs_admin') {
                    // Hitung dari wbs_reports untuk WBS Admin
                    $newReportsCount = WbsReport::where('status', 'Diajukan')->count();
                }
            }

            // 🔹 Statistik kunjungan
            $onlineVisitors = DB::table('views')
                ->where('viewed_at', '>=', Carbon::now()->subMinutes(5))
                ->distinct('visitor')
                ->count('visitor');

            $todayViews = DB::table('views')
                ->whereDate('viewed_at', Carbon::today())
                ->count();

            $weekViews = DB::table('views')
                ->whereBetween('viewed_at', [Carbon::now()->subDays(7), Carbon::now()])
                ->count();

            $totalVisitors = DB::table('views')
                ->distinct('visitor')
                ->count('visitor');

            $totalViews = DB::table('views')->count();

            $view->with(compact(
                'newReportsCount',
                'onlineVisitors',
                'todayViews',
                'weekViews',
                'totalVisitors',
                'totalViews'
            ));
        });
    }
}
