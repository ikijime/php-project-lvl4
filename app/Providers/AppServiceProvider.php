<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment(['staging', 'production'])) {
            // $this->app->register(\Rollbar\Laravel\RollbarServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Locale
        view()->composer('components.language-switcher', function ($view) {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });
        //Gate::define('task_create', fn(User $user, Task $task) => $user->id === $task->author);
    }
}
