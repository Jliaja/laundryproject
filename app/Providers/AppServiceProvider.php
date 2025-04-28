<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CekLogin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Tidak ada perubahan di sini
    }

    /**
     * Define your application's service container bindings.
     *
     * @return void
     */
    public function boot()
    {
        // Mendaftarkan middleware secara manual di sini
        Route::aliasMiddleware('ceklogin', CekLogin::class);
    }
}
