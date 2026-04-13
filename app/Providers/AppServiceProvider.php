<?php

// namespace App\Providers;

// use Illuminate\Support\ServiceProvider;

// class AppServiceProvider extends ServiceProvider
// {
//     /**
//      * Register any application services.
//      */
//     public function register(): void
//     {
//         //
//     }

//     /**
//      * Bootstrap any application services.
//      */
//     public function boot(): void
//     {
//         //
//     }
// }


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

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
        // Set locale Carbon dan Aplikasi ke Bahasa Indonesia
        Carbon::setLocale('id');
        App::setLocale('id');

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        \Illuminate\Validation\Rules\Password::defaults(function () {
            return \Illuminate\Validation\Rules\Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised();
        });

        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Login::class, function (\Illuminate\Auth\Events\Login $event) {
            activity('auth')
                ->causedBy($event->user)
                ->withProperties(['ip' => request()->ip(), 'user_agent' => request()->userAgent()])
                ->event('login')
                ->log('User berhasil login');
        });

        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Failed::class, function (\Illuminate\Auth\Events\Failed $event) {
            activity('auth')
                ->withProperties([
                    'email' => request()->email, 
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent()
                ])
                ->event('failed_login')
                ->log('Gagal login (kredensial salah)');
        });    }
}
