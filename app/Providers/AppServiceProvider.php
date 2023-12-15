<?php

namespace App\Providers;

use App\Models\empresa;
use Illuminate\Support\ServiceProvider;

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
        $empresa = empresa::first();
        view()->share('empresa', $empresa);
    }
}
