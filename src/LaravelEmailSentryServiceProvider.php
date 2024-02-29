<?php

namespace Ahmedwassef\LaravelEmailSentry;
use Ahmedwassef\LaravelEmailSentry\Contracts\PurgeableRepository;
use Ahmedwassef\LaravelEmailSentry\Facades\EmailSentry;
use Ahmedwassef\LaravelEmailSentry\Services\EmailSentryService;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
class LaravelEmailSentryServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCommands();
        $this->registerPublishing();
        $this->registerResources();
        $loader = AliasLoader::getInstance();
        $loader->alias('MailSentry', EmailSentry::class);
        EmailSentry::monitor($this->app);
    }

    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'email-sentry-migrations');

            $this->publishes([
                __DIR__.'/public' => public_path('vendor/email-sentry'),
            ], ['email-sentry-assets', 'email-sentry-assets']);

            $this->publishes([
                __DIR__.'/../config/email-sentry.php' => config_path('email-sentry.php'),
            ], 'email-sentry-config');

        }
    }

    /**
     * Register the package's commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\PurgeCommand::class,
                Console\PublishCommand::class,
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/email-sentry.php', 'email-sentry'
        );

    }


    /**
     * Register the package resources.
     *
     * @return void
     */
    private function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../src/resources/views', 'EmailSentry');

        $this->registerFacades();
        $this->registerRoutes();
     }


    /**
     * Get the package route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'as' => 'email.sentry.',
            'domain' => config('email-sentry.domain', null),
            'namespace' => 'Ahmedwassef\LaravelEmailSentry\Http\Controllers',
            'prefix' => config('email-sentry.path'),
            'middleware' => config('email-sentry.middleware'),
        ];
    }



    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/Routes/routes.php');
        });
    }

    private function registerFacades()
    {
        $this->app->singleton('EmailSentry', function ($app) {
             $emailSentryService = $app->make(EmailSentryService::class);
            return new \Ahmedwassef\LaravelEmailSentry\EmailSentry($emailSentryService); // Replace MyClass with the class you want to bind
        });
    }

    /**
     * Register the package database storage driver.
     *
     * @return void
     */
    protected function registerDatabaseDriver()
    {
        $this->app->singleton(
            PurgeableRepository::class, EmailSentryService::class
        );

    }
}
