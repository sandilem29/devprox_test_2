<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->commands([
            \App\Console\Commands\ImportUsers::class,
        ]);

        // run the command every minute and add the users
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('import:users')->everyMinute()->appendOutputTo(storage_path('logs/examplecommand.log'));
        });
    }
}
