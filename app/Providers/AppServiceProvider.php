<?php

namespace App\Providers;

use App\Models\Activity;
use App\Models\ActivityType;
use App\Observers\ActivityObserver;
use App\Observers\ActivityTypeObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('apiRateLimiting', function (Request $request) {
            return Limit::perMinute(config('api.rateLimiting'))
                ->by($request->user()?->id ?: $request->ip())
                ->response(function(){
                    return response()->json(['success' => false, 'message' => 'Too many requests'], 429); 
                });
        });
        Activity::observe(ActivityObserver::class);
        ActivityType::observe(ActivityTypeObserver::class);
    }
}
