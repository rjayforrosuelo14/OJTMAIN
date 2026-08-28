<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Intern;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share phase counts with admin layout
        View::composer('layouts.app', function ($view) {
            try {
                $pendingCount = Intern::where('status', 'pending')->count();
                
                $phaseCounts = Intern::where('status', 'pending')
                    ->selectRaw('current_phase, COUNT(*) as count')
                    ->groupBy('current_phase')
                    ->pluck('count', 'current_phase')
                    ->toArray();
                
                $view->with([
                    'pendingCount' => $pendingCount,
                    'phaseCounts' => $phaseCounts
                ]);
            } catch (\Exception $e) {
                // Gracefully handle if database not ready
                $view->with([
                    'pendingCount' => 0,
                    'phaseCounts' => []
                ]);
            }
        });
    }
}
