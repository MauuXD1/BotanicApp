<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Models\MoonshineUser;

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
        //Gate::policy(MoonshineUser::class, MoonshineUserPolicy::class);
    }
}
