<?php

namespace App\Providers;

use App\Models\ExportRequest;
use App\Policies\ExportRequestPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(ExportRequest::class, ExportRequestPolicy::class);

        // Force HTTPS when behind a reverse proxy (Render, Heroku, etc.)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
